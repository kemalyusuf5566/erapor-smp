<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KkKelompok;
use App\Models\DataKelas;
use App\Models\DataGuru;
use Illuminate\Http\Request;

class KkKelompokController extends Controller
{
    public function index()
    {
        $kelompok = KkKelompok::with(['kelas', 'koordinator'])
            ->orderBy('nama_kelompok')
            ->get();

        // 🔴 INI YANG SEBELUMNYA SALAH
        // 🔴 SEKARANG BENAR
        $kelas = DataKelas::orderBy('nama_kelas')->get();
        $guru  = DataGuru::with('pengguna')->orderBy('id')->get();

        return view('admin.kokurikuler.kelompok.index', compact(
            'kelompok',
            'kelas',
            'guru'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelompok'  => 'required|string|max:50',
            'data_kelas_id'  => 'required|exists:data_kelas,id',
            'koordinator_id' => 'required|exists:pengguna,id',
        ]);

        KkKelompok::create($data);

        return redirect()
            ->route('admin.kokurikuler.kelompok.index')
            ->with('success', 'Kelompok berhasil ditambahkan');
    }
}
