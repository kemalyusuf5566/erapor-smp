<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DataEkstrakurikuler;
use App\Models\DataGuru;
use Illuminate\Support\Facades\Auth;

class EkskulController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil kemungkinan ID guru (kalau pembina_id ternyata menyimpan data_guru.id)
        $guruRow = DataGuru::where('pengguna_id', $user->id)->first();
        $guruId  = $guruRow?->id;

        // Ambil data ekskul yang dibina guru ini
        // - cocokkan jika pembina_id disimpan sebagai pengguna.id
        // - atau jika pembina_id disimpan sebagai data_guru.id
        $ekskul = DataEkstrakurikuler::query()
            ->where('pembina_id', $user->id)
            ->when($guruId, function ($q) use ($guruId) {
                $q->orWhere('pembina_id', $guruId);
            })
            ->orderBy('id', 'desc')
            ->get();

        // view yang kamu punya: guru/ekskul/index.blade.php
        return view('guru.ekskul.index', compact('ekskul'));
    }
}
