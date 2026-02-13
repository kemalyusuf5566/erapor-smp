<?php

namespace App\Http\Controllers\Guru\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\CatatanWaliKelas;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\DataTahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanWaliKelasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $kelas = DataKelas::withCount('siswa')
            ->where('wali_kelas_id', $user->id)
            ->get();

        return view('guru.wali_kelas.catatan.index', compact('kelas'));
    }

    public function kelola($kelasId)
    {
        $user = Auth::user();

        $kelas = DataKelas::where('id', $kelasId)->where('wali_kelas_id', $user->id)->firstOrFail();
        $tahunAktif = DataTahunPelajaran::where('status_aktif', 1)->firstOrFail();

        $siswa = DataSiswa::where('data_kelas_id', $kelas->id)->get();

        $catatan = CatatanWaliKelas::where('data_tahun_pelajaran_id', $tahunAktif->id)
            ->where('semester', $tahunAktif->semester)
            ->whereIn('data_siswa_id', $siswa->pluck('id'))
            ->get()
            ->keyBy('data_siswa_id');

        return view('guru.wali_kelas.catatan.kelola', compact('kelas', 'tahunAktif', 'siswa', 'catatan'));
    }

    public function update(Request $request, $kelasId)
    {
        $user = Auth::user();

        $kelas = DataKelas::where('id', $kelasId)->where('wali_kelas_id', $user->id)->firstOrFail();
        $tahunAktif = DataTahunPelajaran::where('status_aktif', 1)->firstOrFail();

        $catatan = $request->input('catatan', []);
        $naik = $request->input('status_kenaikan_kelas', []); // hanya semester Genap (opsional)

        foreach ($catatan as $siswaId => $text) {
            CatatanWaliKelas::updateOrCreate(
                [
                    'data_siswa_id' => $siswaId,
                    'data_tahun_pelajaran_id' => $tahunAktif->id,
                    'semester' => $tahunAktif->semester,
                ],
                [
                    'catatan' => $text,
                    'status_kenaikan_kelas' => ($tahunAktif->semester === 'Genap')
                        ? ($naik[$siswaId] ?? null)
                        : null,
                ]
            );
        }

        return back()->with('success', 'Catatan wali kelas berhasil disimpan.');
    }
}
