<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\DataKelas;
use App\Models\LegerNilai;
use Illuminate\Support\Facades\Auth;

class LegerController extends Controller
{
    public function index()
    {
        $kelas = DataKelas::where('wali_kelas_id', Auth::id())->firstOrFail();

        $nilai = LegerNilai::with(['siswa','pembelajaran.mapel'])
            ->whereHas('siswa', function ($q) use ($kelas) {
                $q->where('data_kelas_id', $kelas->id);
            })
            ->get();

        return view('wali.rapor.leger', compact('kelas','nilai'));
    }
}

