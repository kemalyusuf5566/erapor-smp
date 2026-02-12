<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DataPembelajaran;
use App\Models\DataSiswa;
use App\Models\DataTahunPelajaran;
use App\Models\NilaiMapelSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeskripsiCapaianController extends Controller
{
    public function index($pembelajaranId)
    {
        $user = Auth::user();

        // pastikan pembelajaran milik guru login
        $pembelajaran = DataPembelajaran::with(['mapel', 'kelas', 'guru'])
            ->where('id', $pembelajaranId)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        $tahunAktif = DataTahunPelajaran::where('status_aktif', 1)->first();
        if (!$tahunAktif) abort(500, 'Tahun pelajaran aktif belum diset.');

        $semester = $tahunAktif->semester;

        // siswa kelas terkait
        $siswa = DataSiswa::where('data_kelas_id', $pembelajaran->data_kelas_id)
            ->orderBy('nama_siswa')
            ->get();

        // nilai_mapel_siswa yang sudah ada (key by siswa_id)
        $nilaiRows = NilaiMapelSiswa::whereIn('data_siswa_id', $siswa->pluck('id'))
            ->where('data_mapel_id', $pembelajaran->data_mapel_id)
            ->where('data_kelas_id', $pembelajaran->data_kelas_id)
            ->where('data_tahun_pelajaran_id', $tahunAktif->id)
            ->where('semester', $semester)
            ->get()
            ->keyBy('data_siswa_id');

        return view('guru.deskripsi_capaian.index', compact(
            'pembelajaran',
            'tahunAktif',
            'semester',
            'siswa',
            'nilaiRows'
        ));
    }

    public function update(Request $request, $pembelajaranId)
    {
        $user = Auth::user();

        $pembelajaran = DataPembelajaran::where('id', $pembelajaranId)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        $tahunAktif = DataTahunPelajaran::where('status_aktif', 1)->firstOrFail();
        $semester = $tahunAktif->semester;

        $nilaiInput = $request->input('nilai', []);
        $tinggiInput = $request->input('deskripsi_tinggi', []);
        $rendahInput = $request->input('deskripsi_rendah', []);

        // validasi ringan
        // (lebih ketat bisa ditambah: nilai 0-100)
        DB::transaction(function () use (
            $nilaiInput,
            $tinggiInput,
            $rendahInput,
            $pembelajaran,
            $tahunAktif,
            $semester
        ) {
            $siswaIds = array_unique(array_merge(
                array_keys($nilaiInput),
                array_keys($tinggiInput),
                array_keys($rendahInput)
            ));

            foreach ($siswaIds as $siswaId) {

                $nilai = NilaiMapelSiswa::firstOrCreate(
                    [
                        'data_siswa_id' => $siswaId,
                        'data_mapel_id' => $pembelajaran->data_mapel_id,
                        'data_kelas_id' => $pembelajaran->data_kelas_id,
                        'data_tahun_pelajaran_id' => $tahunAktif->id,
                        'semester' => $semester,
                    ],
                    [
                        'nilai_angka' => null,
                        'predikat' => null,
                        'deskripsi' => null,
                        'deskripsi_tinggi' => null,
                        'deskripsi_rendah' => null,
                    ]
                );

                // nilai angka
                $angka = $nilaiInput[$siswaId] ?? null;
                $angka = is_null($angka) ? null : trim((string)$angka);
                $nilai->nilai_angka = ($angka === '' ? null : (int)$angka);

                // deskripsi
                $nilai->deskripsi_tinggi = isset($tinggiInput[$siswaId]) ? trim((string)$tinggiInput[$siswaId]) : null;
                $nilai->deskripsi_rendah = isset($rendahInput[$siswaId]) ? trim((string)$rendahInput[$siswaId]) : null;

                $nilai->save();
            }
        });

        return back()->with('success', 'Deskripsi capaian berhasil disimpan.');
    }
}
