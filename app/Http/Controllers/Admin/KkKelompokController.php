<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KkKelompok;
use App\Models\DataKelas;
use App\Models\DataGuru;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KkKelompokController extends Controller
{
    public function index()
    {
        $kelompok = KkKelompok::with(['kelas', 'koordinator'])
            ->orderBy('nama_kelompok')
            ->get();

        // 🔴 INI YANG SEBELUMNYA SALAH
        // 🔴 SEKARANG BENAR
        $kelas = DataKelas::orderBy('nama_kelas')->get();
        $guru  = DataGuru::with('pengguna')->orderBy('id')->get();

        return view('admin.kokurikuler.kelompok.index', compact(
            'kelompok',
            'kelas',
            'guru'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelompok'  => 'required|string|max:50',
            'data_kelas_id'  => 'required|exists:data_kelas,id',
            'koordinator_id' => 'required|exists:pengguna,id',
        ]);

        KkKelompok::create($data);

        return redirect()
            ->route('admin.kokurikuler.kelompok.index')
            ->with('success', 'Kelompok berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok'   => 'required|string|max:150',
            'data_kelas_id'   => 'required|exists:data_kelas,id',
            'koordinator_id'  => 'required|exists:pengguna,id',
        ]);

        $kelompok = \App\Models\KkKelompok::findOrFail($id);

        $kelompok->update([
            'nama_kelompok'  => $request->nama_kelompok,
            'data_kelas_id'  => $request->data_kelas_id,
            'koordinator_id' => $request->koordinator_id,
        ]);

        $roleKoordinator = Peran::where('nama_peran', 'koordinator_p5')->first();

        if ($roleKoordinator) {
            DB::table('pengguna_peran')->updateOrInsert(
                [
                    'pengguna_id' => $request->koordinator_id,
                    'peran_id'    => $roleKoordinator->id,
                ],
                []
            );
        }

        return redirect()
            ->route('admin.kokurikuler.kelompok.index')
            ->with('success', 'Kelompok berhasil diperbarui');
    }
}
