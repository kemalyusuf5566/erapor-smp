<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\LegerNilai;
use App\Models\DataKetidakhadiran;
use App\Models\CatatanWaliKelas;
use App\Models\DataTahunPelajaran;
use Illuminate\Support\Facades\Auth;

class KelengkapanController extends Controller
{
    public function index()
    {
        $kelas = DataKelas::where('wali_kelas_id', Auth::id())->firstOrFail();
        $tahun = DataTahunPelajaran::where('status_aktif',1)->first();

        $siswa = DataSiswa::where('data_kelas_id', $kelas->id)->get();

        $data = $siswa->map(function ($s) use ($tahun) {
            return [
                'siswa' => $s,
                'nilai' => LegerNilai::where('data_siswa_id',$s->id)->exists(),
                'kehadiran' => DataKetidakhadiran::where([
                    'data_siswa_id'=>$s->id,
                    'data_tahun_pelajaran_id'=>$tahun->id
                ])->exists(),
                'catatan' => CatatanWaliKelas::where([
                    'data_siswa_id'=>$s->id,
                    'data_tahun_pelajaran_id'=>$tahun->id
                ])->exists(),
            ];
        });

        return view('wali.rapor.kelengkapan', compact('data'));
    }
}
