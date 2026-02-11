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
        $sekolah = DataSekolah::first();

        return view('admin.sekolah.index', [
            'sekolah' => $sekolah,
            'mode' => 'edit' // karena sekarang langsung edit di index
        ]);
    }

    public function create()
    {
        return view('admin.sekolah.index', [
            'mode' => 'create',
            'sekolah' => null
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sekolah'       => 'required',
            'npsn'               => 'nullable',
            'kode_pos'           => 'nullable',
            'telepon'            => 'nullable',
            'alamat'             => 'nullable',
            'desa'               => 'nullable',
            'kecamatan'          => 'nullable',
            'kota'               => 'nullable',
            'provinsi'           => 'nullable',
            'email'              => 'nullable|email',
            'website'            => 'nullable',
            'kepala_sekolah'     => 'nullable',
            'nip_kepala_sekolah' => 'nullable',
            'logo'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logo-sekolah', 'public');
            $data['logo'] = $path;
        }

        DataSekolah::create($data);

        return redirect()
            ->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil disimpan');
    }

    public function edit($id)
    {
        $sekolah = DataSekolah::findOrFail($id);

        return view('admin.sekolah.index', [
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
            'kode_pos'           => 'nullable',
            'telepon'            => 'nullable',
            'alamat'             => 'nullable',
            'desa'               => 'nullable',
            'kecamatan'          => 'nullable',
            'kota'               => 'nullable',
            'provinsi'           => 'nullable',
            'email'              => 'nullable|email',
            'website'            => 'nullable',
            'kepala_sekolah'     => 'nullable',
            'nip_kepala_sekolah' => 'nullable',
        ]);

        $sekolah->update($data);

        return redirect()
            ->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil diperbarui');
    }

    public function updateLogo(Request $request, $id)
    {
        $sekolah = DataSekolah::findOrFail($id);

        $request->validate([
            'logo' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {

            // hapus logo lama
            if ($sekolah->logo) {
                Storage::disk('public')->delete($sekolah->logo);
            }

            // simpan logo baru
            $path = $request->file('logo')->store('logo-sekolah', 'public');

            $sekolah->update([
                'logo' => $path
            ]);
        }

        return redirect()
            ->route('admin.sekolah.index')
            ->with('success', 'Logo berhasil diperbarui');
    }
}
