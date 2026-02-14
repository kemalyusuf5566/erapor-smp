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

        // Wajib: load kegiatan dengan pivot id
        $kelompok = KkKelompok::with([
            'kelas',
            'koordinator',
            'kegiatan' => function ($q) {
                $q->withPivot('id');
            }
        ])
            ->where('koordinator_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('guru.kokurikuler.index', compact('kelompok'));
    }
}
