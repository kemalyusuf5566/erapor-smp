<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\DataSekolah;
use App\Models\DataTahunPelajaran;
use App\Models\NilaiMapelSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class RaporSemesterPdfController extends Controller
{
    public function show($siswaId)
    {
        // ================= SISWA =================
        $siswa = DataSiswa::with([
            'kelas',
            'kelas.waliKelas',
        ])->findOrFail($siswaId);

        // ================= TAHUN AKTIF =================
        $tahun = DataTahunPelajaran::where('status_aktif', 1)->first();

        // ================= SEKOLAH =================
        $sekolah = DataSekolah::first();

        // ================= NILAI MAPEL =================
        $nilaiMapel = NilaiMapelSiswa::with('mapel')
            ->where('data_siswa_id', $siswaId)
            ->where('data_kelas_id', $siswa->data_kelas_id)
            ->where('data_tahun_pelajaran_id', $tahun->id)
            ->orderBy('data_mapel_id')
            ->get();

        // ================= RATA-RATA =================
        $rataRata = $nilaiMapel->count() > 0
            ? round($nilaiMapel->avg('nilai'), 2)
            : 0;

        // ================= EKSTRAKURIKULER =================
        // SESUAI KEPUTUSAN FINAL: BELUM ADA RELASI → KOSONG
        $ekskul = collect();

        // ================= PDF =================
        $pdf = Pdf::loadView(
            'admin.rapor.pdf.rapor-semester',
            compact(
                'siswa',
                'sekolah',
                'tahun',
                'nilaiMapel',
                'rataRata',
                'ekskul'
            )
        )->setPaper('F4', 'portrait');

        return $pdf->stream(
            'RAPOR_SEMESTER_' . $siswa->nama_siswa . '.pdf'
        );
    }
}
