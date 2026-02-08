<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataPembelajaran;
use Illuminate\Support\Facades\Auth;


class PembelajaranController extends Controller
{
    public function index()
    {
        $pembelajaran = DataPembelajaran::with(['kelas','mapel'])
            ->where('guru_id', Auth::id())
            ->get();

        return view('guru.pembelajaran.index', compact('pembelajaran'));
    }
}
