<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KkKegiatan;
use Illuminate\Http\Request;

class KkKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = KkKegiatan::orderBy('tema')->get();

        return view('admin.kokurikuler.kegiatan.index', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tema'          => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
        ]);

        KkKegiatan::create($data);

        return redirect()
            ->route('admin.kokurikuler.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kegiatan = KkKegiatan::findOrFail($id);

        $data = $request->validate([
            'tema'          => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
        ]);

        $kegiatan->update($data);

        return redirect()
            ->route('admin.kokurikuler.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        KkKegiatan::findOrFail($id)->delete();

        return redirect()
            ->route('admin.kokurikuler.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus');
    }
}
