<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataTahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTahunPelajaranController extends Controller
{
    /**
     * TAMPILKAN INDEX
     */
    public function index()
    {
        $tahun = DataTahunPelajaran::orderByDesc('status_aktif')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.tahun.index', compact('tahun'));
    }

    /**
     * SIMPAN DATA BARU
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_pelajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'tempat_pembagian_rapor' => 'nullable|string|max:255',
            'tanggal_pembagian_rapor' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request, $validated) {

            // jika diset aktif, nonaktifkan semua
            if ($request->filled('status_aktif')) {
                DataTahunPelajaran::query()->update([
                    'status_aktif' => 0
                ]);
            }

            DataTahunPelajaran::create([
                ...$validated,
                'status_aktif' => $request->filled('status_aktif') ? 1 : 0,
            ]);
        });

        return back()->with('success', 'Tahun pelajaran berhasil ditambahkan');
    }

    /**
     * UPDATE DATA
     */
    public function update(Request $request, $id)
    {
        $tahun = DataTahunPelajaran::findOrFail($id);

        $validated = $request->validate([
            'tahun_pelajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'tempat_pembagian_rapor' => 'nullable|string|max:255',
            'tanggal_pembagian_rapor' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request, $tahun, $validated) {

            if ($request->filled('status_aktif')) {
                DataTahunPelajaran::query()->update([
                    'status_aktif' => 0
                ]);
            }

            $tahun->update([
                ...$validated,
                'status_aktif' => $request->filled('status_aktif') ? 1 : 0,
            ]);
        });

        return back()->with('success', 'Tahun pelajaran berhasil diperbarui');
    }

    /**
     * AKTIFKAN (OPSIONAL TOMBOL CEPAT)
     */
    public function setAktif($id)
    {
        DB::transaction(function () use ($id) {
            DataTahunPelajaran::query()->update(['status_aktif' => 0]);

            DataTahunPelajaran::where('id', $id)
                ->update(['status_aktif' => 1]);
        });

        return back()->with('success', 'Tahun pelajaran diaktifkan');
    }
}
