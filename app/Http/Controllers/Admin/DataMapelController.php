<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataMapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataMapelController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $mapel = DataMapel::orderBy('nama_mapel')->get();

        return view('admin.mapel.index', compact('mapel'));
    }

    public function create()
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        return view('admin.mapel.form', [
            'mapel' => null
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $data = $request->validate([
            'nama_mapel'     => 'required|string|max:255',
            'kelompok_mapel' => 'nullable|string|max:255',
        ]);

        DataMapel::create($data);

        return redirect()
            ->route('admin.mapel.index')
            ->with('success', 'Data mata pelajaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $mapel = DataMapel::findOrFail($id);

        return view('admin.mapel.form', compact('mapel'));
    }

    public function update(Request $request, $id)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $mapel = DataMapel::findOrFail($id);

        $data = $request->validate([
            'nama_mapel'     => 'required|string|max:255',
            'kelompok_mapel' => 'nullable|string|max:255',
        ]);

        $mapel->update($data);

        return redirect()
            ->route('admin.mapel.index')
            ->with('success', 'Data mata pelajaran berhasil diperbarui');
    }
}
