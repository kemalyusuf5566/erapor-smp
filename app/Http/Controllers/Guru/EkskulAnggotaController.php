<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DataEkstrakurikuler;
use App\Models\DataSiswa;
use App\Models\EkskulAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EkskulAnggotaController extends Controller
{
    public function index($ekskulId)
    {
        $user = Auth::user();

        $ekskul = DataEkstrakurikuler::with('pembina')
            ->where('id', $ekskulId)
            ->where('pembina_id', $user->id)
            ->firstOrFail();

        $anggota = EkskulAnggota::with(['siswa.kelas'])
            ->where('data_ekstrakurikuler_id', $ekskul->id)
            ->get();

        // untuk tambah anggota (opsional)
        $siswaList = DataSiswa::with('kelas')->get();

        return view('guru.ekskul.anggota.index', compact('ekskul', 'anggota', 'siswaList'));
    }

    public function store(Request $request, $ekskulId)
    {
        $user = Auth::user();

        $ekskul = DataEkstrakurikuler::where('id', $ekskulId)
            ->where('pembina_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'data_siswa_id' => 'required|exists:data_siswa,id',
        ]);

        EkskulAnggota::firstOrCreate([
            'data_ekstrakurikuler_id' => $ekskul->id,
            'data_siswa_id' => $request->data_siswa_id,
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, $ekskulId)
    {
        $user = Auth::user();

        $ekskul = DataEkstrakurikuler::where('id', $ekskulId)
            ->where('pembina_id', $user->id)
            ->firstOrFail();

        $predikat = $request->input('predikat', []);
        $deskripsi = $request->input('deskripsi', []);

        foreach ($predikat as $anggotaId => $value) {
            $row = EkskulAnggota::where('id', $anggotaId)
                ->where('data_ekstrakurikuler_id', $ekskul->id)
                ->first();

            if ($row) {
                $row->update([
                    'predikat' => $value,
                    'deskripsi' => $deskripsi[$anggotaId] ?? null,
                ]);
            }
        }

        return back()->with('success', 'Data anggota ekskul berhasil disimpan.');
    }

    public function destroy($ekskulId, $anggotaId)
    {
        $user = Auth::user();

        $ekskul = DataEkstrakurikuler::where('id', $ekskulId)
            ->where('pembina_id', $user->id)
            ->firstOrFail();

        EkskulAnggota::where('id', $anggotaId)
            ->where('data_ekstrakurikuler_id', $ekskul->id)
            ->delete();

        return back()->with('success', 'Anggota berhasil dihapus.');
    }
}
