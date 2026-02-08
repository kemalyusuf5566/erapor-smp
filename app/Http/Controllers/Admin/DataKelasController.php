<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKelas;
use App\Models\DataGuru;
use App\Models\DataTahunPelajaran;
use Illuminate\Http\Request;

class DataKelasController extends Controller
{
    public function index()
    {
        $kelas = \App\Models\DataKelas::withCount('siswa')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        // AMBIL TAHUN PELAJARAN AKTIF
        $tahunAktif = DataTahunPelajaran::where('status_aktif', 1)->first();

        if (!$tahunAktif) {
            return redirect()
                ->route('admin.tahun.index')
                ->with('error', 'Tahun pelajaran aktif belum ditentukan');
        }

        return view('admin.kelas.form', [
            'mode'        => 'create',
            'kelas'       => null,
            'tahunAktif'  => $tahunAktif,
            'wali'        => DataGuru::with('pengguna')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_tahun_pelajaran_id' => 'required|exists:data_tahun_pelajaran,id',
            'nama_kelas'              => 'required',
            'tingkat'                 => 'required|numeric',
            'wali_kelas_id'           => 'nullable|exists:pengguna,id',
        ]);

        DataKelas::create([
            'data_sekolah_id'         => 1,
            'data_tahun_pelajaran_id' => $request->data_tahun_pelajaran_id,
            'nama_kelas'              => $request->nama_kelas,
            'tingkat'                 => $request->tingkat,
            'wali_kelas_id'           => $request->wali_kelas_id,
        ]);

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil disimpan');
    }

    public function edit($id)
    {
        $kelas = DataKelas::findOrFail($id);

        return view('admin.kelas.form', [
            'mode'        => 'edit',
            'kelas'       => $kelas,
            'tahunAktif'  => $kelas->tahunPelajaran,
            'wali'        => DataGuru::with('pengguna')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $kelas = DataKelas::findOrFail($id);

        $request->validate([
            'data_tahun_pelajaran_id' => 'required|exists:data_tahun_pelajaran,id',
            'nama_kelas'              => 'required',
            'tingkat'                 => 'required|numeric',
            'wali_kelas_id'           => 'nullable|exists:pengguna,id',
        ]);

        $kelas->update($request->only([
            'data_tahun_pelajaran_id',
            'nama_kelas',
            'tingkat',
            'wali_kelas_id',
        ]));

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui');
    }
}
