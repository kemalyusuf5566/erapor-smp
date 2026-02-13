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
    private function assertKoordinator(KkKelompok $kelompok): void
    {
        abort_unless($kelompok->koordinator_id === Auth::id(), 403, 'Bukan koordinator kelompok ini');
    }

    public function index(KkKelompok $kelompok)
    {
        $this->assertKoordinator($kelompok);

        // list kegiatan yang sudah dipilih kelompok (pivot)
        $kegiatanPilihan = KkKelompokKegiatan::with('kegiatan')
            ->where('kk_kelompok_id', $kelompok->id)
            ->orderBy('id', 'desc')
            ->get();

        // kandidat kegiatan yang belum dipilih
        $sudahDipilih = $kegiatanPilihan->pluck('kk_kegiatan_id')->toArray();

        $kandidat = KkKegiatan::query()
            ->when(count($sudahDipilih) > 0, fn($q) => $q->whereNotIn('id', $sudahDipilih))
            ->orderBy('tema')
            ->orderBy('nama_kegiatan')
            ->get();

        return view('guru.kokurikuler.kegiatan.index', compact('kelompok', 'kegiatanPilihan', 'kandidat'));
    }

    public function store(Request $request, KkKelompok $kelompok)
    {
        $this->assertKoordinator($kelompok);

        $request->validate([
            'kk_kegiatan_id' => 'required|exists:kk_kegiatan,id',
        ]);

        KkKelompokKegiatan::firstOrCreate([
            'kk_kelompok_id' => $kelompok->id,
            'kk_kegiatan_id' => $request->kk_kegiatan_id,
        ]);

        return back()->with('success', 'Kegiatan berhasil ditambahkan ke kelompok');
    }

    public function destroy(KkKelompok $kelompok, $pivot)
    {
        $this->assertKoordinator($kelompok);

        $row = KkKelompokKegiatan::where('kk_kelompok_id', $kelompok->id)
            ->where('id', $pivot)
            ->firstOrFail();

        $row->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus dari kelompok');
    }
}
