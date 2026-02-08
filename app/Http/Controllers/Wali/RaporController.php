<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\LegerNilai;
use App\Models\DataKetidakhadiran;
use App\Models\CatatanWaliKelas;
use App\Models\DataTahunPelajaran;

class RaporController extends Controller
{
    public function show($siswaId)
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

        return view('wali.rapor.preview', compact(
            'siswa','nilai','kehadiran','catatan'
        ));
    }
}
