<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataSiswa;
use App\Models\DataKelas;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index($kelasId)
    {
        $kelas = DataKelas::where('id', $kelasId)
            ->where('wali_kelas_id', Auth::id())
            ->firstOrFail();

        $siswa = DataSiswa::where('data_kelas_id', $kelas->id)->get();

        return view('wali.siswa.index', compact('kelas','siswa'));
    }
}
