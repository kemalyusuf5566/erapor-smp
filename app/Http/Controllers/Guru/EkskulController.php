<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DataEkstrakurikuler;
use Illuminate\Support\Facades\Auth;

class EkskulController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $ekskul = DataEkstrakurikuler::withCount('anggota')
            ->with('pembina')
            ->where('pembina_id', $user->id)
            ->get();

        return view('guru.ekskul.index', compact('ekskul'));
    }
}
