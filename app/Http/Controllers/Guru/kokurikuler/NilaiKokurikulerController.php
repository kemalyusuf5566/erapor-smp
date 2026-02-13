<?php

namespace App\Http\Controllers\Guru\Kokurikuler;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\KkCapaianAkhir;
use App\Models\KkKelompok;
use App\Models\KkKelompokAnggota;
use App\Models\KkKelompokKegiatan;
use App\Models\KkNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiKokurikulerController extends Controller
{
    private function assertKoordinator(KkKelompok $kelompok): void
    {
        abort_unless($kelompok->koordinator_id === Auth::id(), 403, 'Bukan koordinator kelompok ini');
    }

    public function index(Request $request, KkKelompok $kelompok, $pivot)
    {
        $this->assertKoordinator($kelompok);

        $kelompokKegiatan = KkKelompokKegiatan::with(['kegiatan', 'kelompok.kelas', 'kelompok.koordinator'])
            ->where('kk_kelompok_id', $kelompok->id)
            ->where('id', $pivot)
            ->firstOrFail();

        // dropdown capaian profil (capaian akhir)
        $capaianList = KkCapaianAkhir::with('dimensi')
            ->where('kk_kelompok_kegiatan_id', $kelompokKegiatan->id)
            ->orderBy('id', 'asc')
            ->get();

        // pilih capaian aktif (dari querystring)
        $selectedCapaianId = $request->get('capaian'); // boleh null

        // anggota kelompok (siswa)
        $anggotaIds = KkKelompokAnggota::where('kk_kelompok_id', $kelompok->id)
            ->pluck('data_siswa_id');

        $siswa = DataSiswa::whereIn('id', $anggotaIds)
            ->orderBy('nama_siswa')
            ->get();

        // nilai yang sudah ada (per capaian)
        $nilaiBySiswa = collect();

        if ($selectedCapaianId) {
            $nilaiBySiswa = KkNilai::where('kk_kelompok_id', $kelompok->id)
                ->where('kk_kegiatan_id', $kelompokKegiatan->kk_kegiatan_id)
                ->where('kk_capaian_akhir_id', $selectedCapaianId)
                ->get()
                ->keyBy('data_siswa_id');
        }

        $predikatOptions = ['Kurang', 'Cukup', 'Baik', 'Sangat Baik'];

        return view('guru.kokurikuler.nilai.index', compact(
            'kelompok',
            'kelompokKegiatan',
            'capaianList',
            'selectedCapaianId',
            'siswa',
            'nilaiBySiswa',
            'predikatOptions'
        ));
    }

    public function store(Request $request, KkKelompok $kelompok, $pivot)
    {
        $this->assertKoordinator($kelompok);

        $kelompokKegiatan = KkKelompokKegiatan::where('kk_kelompok_id', $kelompok->id)
            ->where('id', $pivot)
            ->firstOrFail();

        $request->validate([
            'kk_capaian_akhir_id' => 'required|exists:kk_capaian_akhir,id',
            'predikat'            => 'required|array',
            'predikat.*'          => 'nullable|in:Kurang,Cukup,Baik,Sangat Baik',
        ]);

        $kkCapaianAkhirId = (int) $request->kk_capaian_akhir_id;

        foreach ($request->predikat as $dataSiswaId => $predikat) {
            // boleh kosong -> skip (atau simpan null)
            KkNilai::updateOrCreate(
                [
                    'kk_kelompok_id'      => $kelompok->id,
                    'kk_kegiatan_id'      => $kelompokKegiatan->kk_kegiatan_id,
                    'data_siswa_id'       => $dataSiswaId,
                    'kk_capaian_akhir_id' => $kkCapaianAkhirId,
                ],
                [
                    'predikat' => $predikat,
                ]
            );
        }

        return redirect()
            ->route('guru.kokurikuler.nilai.index', [$kelompok->id, $kelompokKegiatan->id, 'capaian' => $kkCapaianAkhirId])
            ->with('success', 'Nilai kokurikuler berhasil disimpan');
    }
}
