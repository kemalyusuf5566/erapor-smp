<?php

namespace App\Http\Controllers\Guru\Kokurikuler;

use App\Http\Controllers\Controller;
use App\Models\KkKelompok;
use App\Models\KkKegiatan;
use App\Models\KkNilai;
use App\Models\KkKelompokAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeskripsiKokurikulerController extends Controller
{
    public function index(Request $request, $kelompokId, $kegiatanId)
    {
        $user = Auth::user();

        // Pastikan kelompok ini milik koordinator yang login
        $kelompok = KkKelompok::with(['kelas', 'koordinator'])
            ->where('id', $kelompokId)
            ->where('koordinator_id', $user->id)
            ->firstOrFail();

        $kegiatan = KkKegiatan::findOrFail($kegiatanId);

        // Ambil anggota kelompok (siswa)
        $anggota = KkKelompokAnggota::with('siswa')
            ->where('kk_kelompok_id', $kelompok->id)
            ->get();

        // Ambil nilai per siswa untuk kegiatan ini (kalau belum ada, nanti dibuat saat update)
        $nilaiBySiswa = KkNilai::where('kk_kelompok_id', $kelompok->id)
            ->where('kk_kegiatan_id', $kegiatan->id)
            ->get()
            ->keyBy('data_siswa_id');

        return view('guru.kokurikuler.deskripsi.index', [
            'kelompok' => $kelompok,
            'kegiatan' => $kegiatan,
            'anggota' => $anggota,
            'nilaiBySiswa' => $nilaiBySiswa,
        ]);
    }

    public function update(Request $request, $kelompokId, $kegiatanId)
    {
        $user = Auth::user();

        $kelompok = KkKelompok::where('id', $kelompokId)
            ->where('koordinator_id', $user->id)
            ->firstOrFail();

        $kegiatan = KkKegiatan::findOrFail($kegiatanId);

        $deskripsi = $request->input('deskripsi', []); // [data_siswa_id => text]

        foreach ($deskripsi as $siswaId => $text) {
            KkNilai::updateOrCreate(
                [
                    'kk_kelompok_id' => $kelompok->id,
                    'kk_kegiatan_id' => $kegiatan->id,
                    'data_siswa_id'  => $siswaId,
                ],
                [
                    'deskripsi' => $text,
                ]
            );
        }

        return redirect()
            ->route('guru.kokurikuler.deskripsi.index', [$kelompok->id, $kegiatan->id])
            ->with('success', 'Deskripsi kokurikuler berhasil disimpan.');
    }
}
