<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\DataKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
   public function index()
    {
        $kelas = DataKelas::where('wali_kelas_id', Auth::id())->get();
        return view('wali.kelas.index', compact('kelas'));
    }
}
