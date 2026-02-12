<?php

namespace App\Http\Controllers\Guru\Kokurikuler;

use App\Http\Controllers\Controller;
use App\Models\KkKelompok;
use Illuminate\Support\Facades\Auth;

class KelompokController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $kelompok = KkKelompok::with(['kelas', 'koordinator'])
            ->where('koordinator_id', $user->id)
            ->get();

        return view('guru.kokurikuler.index', compact('kelompok'));
    }
}
