<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DataPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelajaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil pembelajaran yang diampu guru login
        $pembelajaran = DataPembelajaran::with(['mapel', 'kelas', 'guru'])
            ->where('guru_id', $user->id)
            ->orderBy('data_kelas_id')
            ->orderBy('data_mapel_id')
            ->get();

        return view('guru.pembelajaran.index', compact('pembelajaran'));
    }
}
