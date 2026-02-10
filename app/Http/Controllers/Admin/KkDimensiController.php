<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KkDimensi;
use Illuminate\Http\Request;

class KkDimensiController extends Controller
{
    public function index()
    {
        $dimensi = KkDimensi::orderBy('nama_dimensi')->get();
        return view('admin.kokurikuler.dimensi.index', compact('dimensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dimensi' => 'required|string|max:255',
        ]);

        KkDimensi::create([
            'nama_dimensi' => $request->nama_dimensi,
        ]);

        return back()->with('success', 'Dimensi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dimensi' => 'required|string|max:255',
        ]);

        KkDimensi::findOrFail($id)->update([
            'nama_dimensi' => $request->nama_dimensi,
        ]);

        return back()->with('success', 'Dimensi berhasil diperbarui');
    }

    public function destroy($id)
    {
        KkDimensi::findOrFail($id)->delete();
        return back()->with('success', 'Dimensi berhasil dihapus');
    }
}
