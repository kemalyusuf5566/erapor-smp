<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\LegerNilai;
use App\Models\DataKetidakhadiran;
use App\Models\CatatanWaliKelas;
use App\Models\DataTahunPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakRaporController extends Controller
{
    public function semester($siswaId)
    {
        $tahun = DataTahunPelajaran::where('status_aktif',1)->first();
        $siswa = DataSiswa::findOrFail($siswaId);

        $nilai = LegerNilai::with('pembelajaran.mapel')
            ->where('data_siswa_id',$siswa->id)->get();

        $kehadiran = DataKetidakhadiran::where([
            'data_siswa_id'=>$siswa->id,
            'data_tahun_pelajaran_id'=>$tahun->id
        ])->first();

        $catatan = CatatanWaliKelas::where([
            'data_siswa_id'=>$siswa->id,
            'data_tahun_pelajaran_id'=>$tahun->id
        ])->first();

        $pdf = Pdf::loadView('wali.rapor.pdf.semester', compact(
            'siswa','nilai','kehadiran','catatan','tahun'
        ));

        return $pdf->stream('rapor-'.$siswa->nama_siswa.'.pdf');
    }
}
