<?php

namespace App\Http\Controllers\Guru\Kokurikuler;

use App\Http\Controllers\Controller;
use App\Models\KkKelompok;
use App\Models\KkKelompokKegiatan;
use App\Models\KkKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanKelompokController extends Controller
{
    /**
     * Pastikan yang akses adalah koordinator kelompok tsb.
     */
    private function assertKoordinator(KkKelompok $kelompok): void
    {
        $user = Auth::user();

        if (!$user || (int) $kelompok->koordinator_id !== (int) $user->id) {
            abort(403, 'Anda bukan koordinator kelompok ini');
        }
    }

    /**
     * HALAMAN: Kelola Kegiatan & Input Nilai
     * URL: /guru/kokurikuler/{kelompok}/kegiatan
     */
    public function index(KkKelompok $kelompok)
    {
        $this->assertKoordinator($kelompok);

        // untuk header info
        $kelompok->load(['kelas', 'koordinator']);

        // LIST kegiatan yang sudah dipilih kelompok (pivot)
        $items = KkKelompokKegiatan::with('kegiatan')
            ->where('kk_kelompok_id', $kelompok->id)
            ->orderByDesc('id')
            ->get();

        // LIST master kegiatan (untuk dropdown tambah)
        $kegiatanList = KkKegiatan::orderByDesc('id')->get();

        return view('guru.kokurikuler.kegiatan.index', compact('kelompok', 'items', 'kegiatanList'));
    }

    /**
     * TAMBAH kegiatan ke kelompok (pivot)
     * (pastikan route kamu memang ada: guru.kokurikuler.kegiatan.store)
     */
    public function store(Request $request, KkKelompok $kelompok)
    {
        $this->assertKoordinator($kelompok);

        $request->validate([
            'kk_kegiatan_id' => 'required|exists:kk_kegiatan,id',
        ]);

        // cegah dobel (karena pivot kamu unique)
        $sudahAda = KkKelompokKegiatan::where('kk_kelompok_id', $kelompok->id)
            ->where('kk_kegiatan_id', $request->kk_kegiatan_id)
            ->exists();

        if ($sudahAda) {
            return back()->with('success', 'Kegiatan sudah ada di kelompok ini.');
        }

        KkKelompokKegiatan::create([
            'kk_kelompok_id' => $kelompok->id,
            'kk_kegiatan_id' => $request->kk_kegiatan_id,
        ]);

        return back()->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * HAPUS kegiatan dari kelompok (hapus pivot)
     * (pastikan route kamu memang ada: guru.kokurikuler.kegiatan.destroy)
     */
    public function destroy(KkKelompok $kelompok, $pivotId)
    {
        $this->assertKoordinator($kelompok);

        $pivot = KkKelompokKegiatan::where('kk_kelompok_id', $kelompok->id)
            ->where('id', $pivotId)
            ->firstOrFail();

        $pivot->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus dari kelompok.');
    }
}
