<?php

namespace App\Http\Controllers\Guru\WaliKelas\Rapor;

use App\Http\Controllers\Controller;
use App\Models\DataKelas;
use Illuminate\Support\Facades\Auth;

class CetakRaporController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil kelas yang diwalikan user ini
        // TANPA with('kelas') karena tidak ada relasi itu
        $kelas = DataKelas::where('wali_kelas_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        return view('guru.wali_kelas.rapor.cetak.index', compact('kelas'));
    }
}
