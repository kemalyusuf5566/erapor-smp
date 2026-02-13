<?php

namespace App\Http\Controllers\Guru\Kokurikuler;

use App\Http\Controllers\Controller;
use App\Models\KkCapaianAkhir;
use App\Models\KkDimensi;
use App\Models\KkKelompok;
use App\Models\KkKelompokKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CapaianAkhirController extends Controller
{
    private function assertKoordinator(KkKelompok $kelompok): void
    {
        abort_unless($kelompok->koordinator_id === Auth::id(), 403, 'Bukan koordinator kelompok ini');
    }

    public function index(KkKelompok $kelompok, $pivot)
    {
        $this->assertKoordinator($kelompok);

        $kelompokKegiatan = KkKelompokKegiatan::with(['kegiatan', 'kelompok.kelas', 'kelompok.koordinator'])
            ->where('kk_kelompok_id', $kelompok->id)
            ->where('id', $pivot)
            ->firstOrFail();

        $dimensi = KkDimensi::orderBy('nama_dimensi')->get();

        $items = KkCapaianAkhir::with('dimensi')
            ->where('kk_kelompok_kegiatan_id', $kelompokKegiatan->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('guru.kokurikuler.capaian_akhir.index', compact('kelompok', 'kelompokKegiatan', 'dimensi', 'items'));
    }

    public function store(Request $request, KkKelompok $kelompok, $pivot)
    {
        $this->assertKoordinator($kelompok);

        $kelompokKegiatan = KkKelompokKegiatan::where('kk_kelompok_id', $kelompok->id)
            ->where('id', $pivot)
            ->firstOrFail();

        $request->validate([
            'kk_dimensi_id' => 'required|exists:kk_dimensi,id',
            'capaian'       => 'required|string',
        ]);

        KkCapaianAkhir::create([
            'kk_kelompok_kegiatan_id' => $kelompokKegiatan->id,
            'kk_dimensi_id'           => $request->kk_dimensi_id,
            'capaian'                 => $request->capaian,
        ]);

        return back()->with('success', 'Capaian akhir berhasil ditambahkan');
    }

    public function update(Request $request, KkKelompok $kelompok, $pivot, $id)
    {
        $this->assertKoordinator($kelompok);

        $kelompokKegiatan = KkKelompokKegiatan::where('kk_kelompok_id', $kelompok->id)
            ->where('id', $pivot)
            ->firstOrFail();

        $item = KkCapaianAkhir::where('kk_kelompok_kegiatan_id', $kelompokKegiatan->id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'kk_dimensi_id' => 'required|exists:kk_dimensi,id',
            'capaian'       => 'required|string',
        ]);

        $item->update([
            'kk_dimensi_id' => $request->kk_dimensi_id,
            'capaian'       => $request->capaian,
        ]);

        return back()->with('success', 'Capaian akhir berhasil diperbarui');
    }

    public function destroy(KkKelompok $kelompok, $pivot, $id)
    {
        $this->assertKoordinator($kelompok);

        $kelompokKegiatan = KkKelompokKegiatan::where('kk_kelompok_id', $kelompok->id)
            ->where('id', $pivot)
            ->firstOrFail();

        $item = KkCapaianAkhir::where('kk_kelompok_kegiatan_id', $kelompokKegiatan->id)
            ->where('id', $id)
            ->firstOrFail();

        $item->delete();

        return back()->with('success', 'Capaian akhir berhasil dihapus');
    }
}
