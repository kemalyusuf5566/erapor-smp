<?php

namespace App\Http\Controllers\Guru\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use Illuminate\Support\Facades\Auth;

class DataKelasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil hanya kelas yang dia walikan
        $kelas = DataKelas::withCount('siswa')
            ->where('wali_kelas_id', $user->id)
            ->get();

        return view('guru.wali_kelas.data_kelas.index', compact('kelas'));
    }

    public function detail($id)
    {
        $user = Auth::user();

        $kelas = DataKelas::where('wali_kelas_id', $user->id)
            ->findOrFail($id);

        $siswa = DataSiswa::where('data_kelas_id', $kelas->id)->get();

        return view('guru.wali_kelas.data_kelas.detail', compact('kelas', 'siswa'));
    }
}
