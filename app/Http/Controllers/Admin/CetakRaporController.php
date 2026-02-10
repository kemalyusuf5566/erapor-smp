<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\DataSekolah;
use App\Models\DataTahunPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakRaporController extends Controller
{
    /**
     * ==============================
     * INDEX CETAK RAPOR (PER KELAS)
     * URL: /admin/rapor/cetak
     * ==============================
     */
    public function index()
    {
        $kelas = DataKelas::with([
            'waliKelas'
        ])
            ->withCount('siswa')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('admin.rapor.cetak.index', compact('kelas'));
    }

    /**
     * ==============================
     * DETAIL CETAK RAPOR (PER KELAS)
     * URL: /admin/rapor/cetak/{kelas}
     * ==============================
     */
    public function detail($kelasId)
    {
        $kelas = DataKelas::with([
            'waliKelas'
        ])->findOrFail($kelasId);

        $siswa = DataSiswa::where('data_kelas_id', $kelasId)
            ->orderBy('nama_siswa')
            ->get();

        $tahun = DataTahunPelajaran::where('status_aktif', 1)->first();

        $semester = $tahun?->semester ?? 1;

        return view('admin.rapor.cetak.detail', compact(
            'kelas',
            'siswa',
            'tahun'
        ));
    }

    /**
     * ==============================
     * PDF KELENGKAPAN RAPOR
     * ==============================
     */
    public function kelengkapan($siswaId)
    {
        $siswa = DataSiswa::with([
            'kelas',
            'kelas.waliKelas',
        ])->findOrFail($siswaId);

        $sekolah = DataSekolah::first();
        $tahun   = DataTahunPelajaran::where('status_aktif', 1)->first();

        $pdf = Pdf::loadView(
            'admin.rapor.pdf.kelengkapan',
            compact('siswa', 'sekolah', 'tahun')
        )->setPaper('A4');

        return $pdf->stream(
            'KELENGKAPAN_RAPOR_' . $siswa->nama_siswa . '.pdf'
        );
    }

    /**
     * ==============================
     * PDF RAPOR SEMESTER
     * ==============================
     */
    public function semester($siswaId)
    {
        $siswa = DataSiswa::with([
            'kelas',
            'kelas.waliKelas',
        ])->findOrFail($siswaId);

        $sekolah = DataSekolah::first();
        $tahun   = DataTahunPelajaran::where('status_aktif', 1)->first();

        $pdf = Pdf::loadView(
            'admin.rapor.pdf.semester',
            compact('siswa', 'sekolah', 'tahun')
        )->setPaper('F4', 'portrait');

        return $pdf->stream(
            'RAPOR_SEMESTER_' . $siswa->nama_siswa . '.pdf'
        );
    }
}
