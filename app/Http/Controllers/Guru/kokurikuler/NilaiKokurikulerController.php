<?php

namespace App\Http\Controllers\Guru\Kokurikuler;

use App\Http\Controllers\Controller;
use App\Models\KkKelompok;
use App\Models\KkKegiatan;
use App\Models\KkKelompokKegiatan;
use App\Models\KkCapaianAkhir;
use App\Models\KkNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiKokurikulerController extends Controller
{
    private function assertKoordinator(KkKelompok $kelompok): void
    {
        $user = Auth::user();

        if (!$user || (int) $kelompok->koordinator_id !== (int) $user->id) {
            abort(403, 'Anda bukan koordinator kelompok ini');
        }
    }

    public function index(KkKelompok $kelompok, KkKegiatan $kegiatan)
    {
        $this->assertKoordinator($kelompok);

        // pastikan kegiatan ini memang dipilih oleh kelompok (ambil pivotnya)
        $pivot = KkKelompokKegiatan::where('kk_kelompok_id', $kelompok->id)
            ->where('kk_kegiatan_id', $kegiatan->id)
            ->firstOrFail();

        // capaian akhir berdasarkan pivot kelompok-kegiatan (yang kamu buat sudah)
        $capaianAkhir = KkCapaianAkhir::with('dimensi')
            ->where('kk_kelompok_kegiatan_id', $pivot->id)
            ->orderBy('kk_dimensi_id')
            ->orderBy('id')
            ->get();

        // anggota kelompok + siswa
        $anggota = $kelompok->anggota()->with('siswa')->get();

        // nilai yang sudah tersimpan (jika ada)
        $nilaiRows = KkNilai::where('kk_kelompok_id', $kelompok->id)
            ->where('kk_kegiatan_id', $kegiatan->id)
            ->get()
            ->keyBy('data_siswa_id');

        // opsi predikat dropdown (silakan kamu ubah kalau kamu punya standar lain)
        $opsiPredikat = [
            'SB' => 'Sangat Baik',
            'B'  => 'Baik',
            'C'  => 'Cukup',
            'PB' => 'Perlu Bimbingan',
        ];

        return view('guru.kokurikuler.nilai.index', [
            'kelompok'      => $kelompok->load(['kelas', 'koordinator']),
            'kegiatan'      => $kegiatan,
            'pivot'         => $pivot,          // kalau nanti kamu butuh tampilkan id pivot
            'capaianAkhir'  => $capaianAkhir,
            'anggota'       => $anggota,
            'nilaiRows'     => $nilaiRows,
            'opsiPredikat'  => $opsiPredikat,
        ]);
    }

    public function update(Request $request, KkKelompok $kelompok, KkKegiatan $kegiatan)
    {
        $this->assertKoordinator($kelompok);

        // validasi longgar dulu biar kamu bisa jalan (nanti kalau mau diperketat bisa)
        $request->validate([
            'nilai' => 'required|array',
        ]);

        foreach ($request->input('nilai', []) as $siswaId => $row) {
            // kalau tidak dipilih apa-apa, boleh skip
            $kkCapaianAkhirId = $row['kk_capaian_akhir_id'] ?? null;
            $predikat         = $row['predikat'] ?? null;

            KkNilai::updateOrCreate(
                [
                    'kk_kelompok_id' => $kelompok->id,
                    'kk_kegiatan_id' => $kegiatan->id,
                    'data_siswa_id'  => (int) $siswaId,
                ],
                [
                    // pastikan kolom ini memang ada di tabel kk_nilai kamu
                    'kk_capaian_akhir_id' => $kkCapaianAkhirId ?: null,
                    'predikat'            => $predikat ?: null,
                ]
            );
        }

        return back()->with('success', 'Nilai kokurikuler berhasil disimpan.');
    }
}
