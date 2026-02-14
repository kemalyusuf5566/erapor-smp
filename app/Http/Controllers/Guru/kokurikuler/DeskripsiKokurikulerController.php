<?php

namespace App\Http\Controllers\Guru\Kokurikuler;

use App\Http\Controllers\Controller;
use App\Models\KkKelompok;
use App\Models\KkKegiatan;
use App\Models\KkNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeskripsiKokurikulerController extends Controller
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

        // anggota + siswa
        $anggota = $kelompok->anggota()->with('siswa')->get();

        // nilai per siswa untuk kegiatan ini
        $nilaiRows = KkNilai::where('kk_kelompok_id', $kelompok->id)
            ->where('kk_kegiatan_id', $kegiatan->id)
            ->get()
            ->keyBy('data_siswa_id');

        return view('guru.kokurikuler.deskripsi.index', [
            'kelompok'  => $kelompok->load(['kelas', 'koordinator']),
            'kegiatan'  => $kegiatan,
            'anggota'   => $anggota,
            'nilaiRows' => $nilaiRows,
        ]);
    }

    public function update(Request $request, KkKelompok $kelompok, KkKegiatan $kegiatan)
    {
        $this->assertKoordinator($kelompok);

        $request->validate([
            'deskripsi' => 'required|array',
        ]);

        foreach ($request->input('deskripsi', []) as $siswaId => $text) {
            // pastikan row kk_nilai ada; kalau belum ada, buat dulu
            KkNilai::updateOrCreate(
                [
                    'kk_kelompok_id' => $kelompok->id,
                    'kk_kegiatan_id' => $kegiatan->id,
                    'data_siswa_id'  => (int) $siswaId,
                ],
                [
                    // kolom lain boleh null dulu
                    'deskripsi' => $text ?: null,
                ]
            );
        }

        return back()->with('success', 'Deskripsi kokurikuler berhasil disimpan.');
    }
}
