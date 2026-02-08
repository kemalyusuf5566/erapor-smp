<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatatanWaliKelas;
use App\Models\DataTahunPelajaran;

class CatatanController extends Controller
{
    public function edit($siswaId)
    {
        $tahun = DataTahunPelajaran::where('status_aktif',1)->first();

        $catatan = CatatanWaliKelas::firstOrNew([
            'data_siswa_id' => $siswaId,
            'data_tahun_pelajaran_id' => $tahun->id,
        ]);

        return view('wali.catatan.edit', compact('catatan','siswaId'));
    }

    public function store(Request $request)
    {
        CatatanWaliKelas::updateOrCreate(
            [
                'data_siswa_id' => $request->data_siswa_id,
                'data_tahun_pelajaran_id' => $request->data_tahun_pelajaran_id,
            ],
            $request->only(['catatan','status_kenaikan_kelas'])
        );

        return back()->with('success','Catatan disimpan');
    }
}
