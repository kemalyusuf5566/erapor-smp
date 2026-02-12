<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DataPembelajaran;
use App\Models\DataSiswa;
use App\Models\DataTahunPelajaran;
use App\Models\NilaiMapelSiswa;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiAkhirController extends Controller
{
    public function index($pembelajaranId)
    {
        $user = Auth::user();

        // Pastikan pembelajaran milik guru login
        $pembelajaran = DataPembelajaran::with(['mapel', 'kelas', 'guru'])
            ->where('id', $pembelajaranId)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        // Tahun pelajaran aktif (wajib ada)
        $tahunAktif = DataTahunPelajaran::where('status_aktif', 1)->first();
        if (!$tahunAktif) {
            abort(500, 'Tahun pelajaran aktif belum diset.');
        }

        $semester = $tahunAktif->semester; // 'Ganjil' / 'Genap'

        // Ambil siswa di kelas pembelajaran ini
        $siswa = DataSiswa::where('data_kelas_id', $pembelajaran->data_kelas_id)
            ->orderBy('nama_siswa')
            ->get();

        // Ambil TP untuk pembelajaran ini
        $tpList = TujuanPembelajaran::where('data_pembelajaran_id', $pembelajaran->id)
            ->orderByRaw('COALESCE(urutan, 999999) ASC')
            ->orderBy('id')
            ->get();

        // Ambil nilai_mapel_siswa yg sudah ada untuk semua siswa kelas ini (mapel+kelas+tahun+semester)
        $nilaiRows = NilaiMapelSiswa::whereIn('data_siswa_id', $siswa->pluck('id'))
            ->where('data_mapel_id', $pembelajaran->data_mapel_id)
            ->where('data_kelas_id', $pembelajaran->data_kelas_id)
            ->where('data_tahun_pelajaran_id', $tahunAktif->id)
            ->where('semester', $semester)
            ->get()
            ->keyBy('data_siswa_id'); // supaya gampang akses per siswa

        // Kumpulkan semua nilai_id yang ada untuk ambil checklist TP
        $nilaiIds = $nilaiRows->pluck('id')->values();

        // Map checklist: [nilai_id][tp_id] = 'optimal' / 'perlu'
        $checkMap = [];
        if ($nilaiIds->count() > 0) {
            $pivot = DB::table('nilai_mapel_siswa_tujuan')
                ->whereIn('nilai_mapel_siswa_id', $nilaiIds)
                ->get();

            foreach ($pivot as $p) {
                $checkMap[$p->nilai_mapel_siswa_id][$p->tujuan_pembelajaran_id] = $p->kategori;
            }
        }

        return view('guru.nilai_akhir.index', compact(
            'pembelajaran',
            'tahunAktif',
            'semester',
            'siswa',
            'tpList',
            'nilaiRows',
            'checkMap'
        ));
    }

    /**
     * Bulk simpan nilai + checklist TP optimal/perlu
     * Nama input di form:
     * - nilai[siswa_id]
     * - optimal[siswa_id][]
     * - perlu[siswa_id][]
     */
    public function update(Request $request, $pembelajaranId)
    {
        $user = Auth::user();

        $pembelajaran = DataPembelajaran::where('id', $pembelajaranId)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        $tahunAktif = DataTahunPelajaran::where('status_aktif', 1)->firstOrFail();
        $semester = $tahunAktif->semester;

        $nilaiInput = $request->input('nilai', []);
        $optimalInput = $request->input('optimal', []);
        $perluInput = $request->input('perlu', []);

        DB::transaction(function () use (
            $nilaiInput,
            $optimalInput,
            $perluInput,
            $pembelajaran,
            $tahunAktif,
            $semester
        ) {
            foreach ($nilaiInput as $siswaId => $nilaiAngka) {

                // Ambil / buat nilai_mapel_siswa
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
                    ]
                );

                // Simpan nilai (boleh kosong)
                $nilaiAngka = is_null($nilaiAngka) ? null : trim((string)$nilaiAngka);
                $nilai->nilai_angka = ($nilaiAngka === '') ? null : (int)$nilaiAngka;
                $nilai->save();

                // Reset checklist TP dulu
                DB::table('nilai_mapel_siswa_tujuan')
                    ->where('nilai_mapel_siswa_id', $nilai->id)
                    ->delete();

                $opt = array_map('intval', $optimalInput[$siswaId] ?? []);
                $prl = array_map('intval', $perluInput[$siswaId] ?? []);

                // Jika TP sama masuk dua-duanya, utamakan optimal (hapus dari perlu)
                $prl = array_values(array_diff($prl, $opt));

                // Insert optimal
                foreach ($opt as $tpId) {
                    DB::table('nilai_mapel_siswa_tujuan')->insert([
                        'nilai_mapel_siswa_id' => $nilai->id,
                        'tujuan_pembelajaran_id' => $tpId,
                        'kategori' => 'optimal',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Insert perlu
                foreach ($prl as $tpId) {
                    DB::table('nilai_mapel_siswa_tujuan')->insert([
                        'nilai_mapel_siswa_id' => $nilai->id,
                        'tujuan_pembelajaran_id' => $tpId,
                        'kategori' => 'perlu',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        return back()->with('success', 'Nilai akhir & capaian TP berhasil disimpan.');
    }

    /**
     * Terapkan nilai rata-rata (set nilai semua siswa di kelas ini)
     */
    public function applyAverage(Request $request, $pembelajaranId)
    {
        $request->validate([
            'nilai_rata' => 'required|integer|min:0|max:100',
        ]);

        $user = Auth::user();

        $pembelajaran = DataPembelajaran::where('id', $pembelajaranId)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        $tahunAktif = DataTahunPelajaran::where('status_aktif', 1)->firstOrFail();
        $semester = $tahunAktif->semester;

        $siswaIds = DataSiswa::where('data_kelas_id', $pembelajaran->data_kelas_id)->pluck('id');

        DB::transaction(function () use ($siswaIds, $pembelajaran, $tahunAktif, $semester, $request) {
            foreach ($siswaIds as $siswaId) {
                $nilai = NilaiMapelSiswa::firstOrCreate(
                    [
                        'data_siswa_id' => $siswaId,
                        'data_mapel_id' => $pembelajaran->data_mapel_id,
                        'data_kelas_id' => $pembelajaran->data_kelas_id,
                        'data_tahun_pelajaran_id' => $tahunAktif->id,
                        'semester' => $semester,
                    ]
                );

                $nilai->nilai_angka = (int)$request->nilai_rata;
                $nilai->save();
            }
        });

        return back()->with('success', 'Nilai rata-rata berhasil diterapkan ke semua siswa.');
    }
}
