<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataKetidakhadiran;
use App\Models\DataSiswa;
use App\Models\DataTahunPelajaran;

class KehadiranController extends Controller
{
    public function edit($siswaId)
    {
        $tahun = DataTahunPelajaran::where('status_aktif',1)->first();

        $kehadiran = DataKetidakhadiran::firstOrNew([
            'data_siswa_id' => $siswaId,
            'data_tahun_pelajaran_id' => $tahun->id,
        ]);

        return view('wali.kehadiran.edit', compact('kehadiran','siswaId'));
    }

    public function store(Request $request)
    {
        DataKetidakhadiran::updateOrCreate(
            [
                'data_siswa_id' => $request->data_siswa_id,
                'data_tahun_pelajaran_id' => $request->data_tahun_pelajaran_id,
            ],
            $request->only(['sakit','izin','tanpa_keterangan'])
        );

        return back()->with('success','Kehadiran disimpan');
    }
}
