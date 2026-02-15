<?php

namespace App\Http\Controllers\Guru\WaliKelas\Rapor;

use App\Http\Controllers\Controller;
use App\Models\DataKelas;
use Illuminate\Support\Facades\Auth;

class LegerNilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil kelas yang diwalikan user ini
        // (tanpa relasi 'kelas' karena di model DataKelas kamu tidak ada relationship itu)
        $kelas = DataKelas::where('wali_kelas_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        return view('guru.wali_kelas.rapor.leger.index', compact('kelas'));
    }
}
