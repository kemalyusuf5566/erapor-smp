<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataSekolahController extends Controller
{
    public function index()
    {
        // AMBIL SATU DATA SAJA
        $sekolah = DataSekolah::first();

        return view('admin.sekolah.index', compact('sekolah'));
    }

    public function create()
    {
        return view('admin.sekolah.form', [
            'mode' => 'create',
            'sekolah' => null
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sekolah'       => 'required',
            'npsn'               => 'nullable',
            'nss'                => 'nullable',
            'kode_pos'           => 'nullable',
            'telepon'            => 'nullable',
            'alamat'             => 'nullable',
            'email'              => 'nullable|email',
            'website'            => 'nullable',
            'kepala_sekolah'     => 'nullable',
            'nip_kepala_sekolah' => 'nullable',
            'logo'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logo-sekolah', 'public');
        }

        DataSekolah::create($data);

        return redirect()
            ->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil disimpan');
    }

    public function edit($id)
    {
        $sekolah = DataSekolah::findOrFail($id);

        return view('admin.sekolah.form', [
            'mode' => 'edit',
            'sekolah' => $sekolah
        ]);
    }

    public function update(Request $request, $id)
    {
        $sekolah = DataSekolah::findOrFail($id);

        $data = $request->validate([
            'nama_sekolah'       => 'required',
            'npsn'               => 'nullable',
            'nss'                => 'nullable',
            'kode_pos'           => 'nullable',
            'telepon'            => 'nullable',
            'alamat'             => 'nullable',
            'email'              => 'nullable|email',
            'website'            => 'nullable',
            'kepala_sekolah'     => 'nullable',
            'nip_kepala_sekolah' => 'nullable',
            'logo'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($sekolah->logo) {
                Storage::disk('public')->delete($sekolah->logo);
            }
            $data['logo'] = $request->file('logo')->store('logo-sekolah', 'public');
        }

        $sekolah->update($data);

        return redirect()
            ->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil diperbarui');
    }
}
