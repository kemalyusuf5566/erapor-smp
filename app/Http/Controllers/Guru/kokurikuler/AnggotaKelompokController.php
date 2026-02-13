<?php

namespace App\Http\Controllers\Guru\Kokurikuler;

use App\Http\Controllers\Controller;
use App\Models\KkKelompok;
use App\Models\KkKelompokAnggota;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaKelompokController extends Controller
{
    private function assertKoordinator(KkKelompok $kelompok): void
    {
        abort_unless($kelompok->koordinator_id === Auth::id(), 403, 'Bukan koordinator kelompok ini');
    }

    public function index(KkKelompok $kelompok)
    {
        $this->assertKoordinator($kelompok);

        $anggota = KkKelompokAnggota::with('siswa')
            ->where('kk_kelompok_id', $kelompok->id)
            ->orderBy('id')
            ->get();

        // kandidat: siswa di kelas kelompok yang belum jadi anggota
        $sudah = $anggota->pluck('data_siswa_id')->toArray();

        $kandidat = DataSiswa::where('data_kelas_id', $kelompok->data_kelas_id)
            ->whereNotIn('id', $sudah)
            ->orderBy('nama_siswa')
            ->get();

        return view('guru.kokurikuler.anggota.index', compact('kelompok', 'anggota', 'kandidat'));
    }

    public function store(Request $request, KkKelompok $kelompok)
    {
        $this->assertKoordinator($kelompok);

        $request->validate([
            'data_siswa_id' => 'required|exists:data_siswa,id',
        ]);

        // pastikan siswa dari kelas yang sama
        $siswa = DataSiswa::findOrFail($request->data_siswa_id);
        abort_unless($siswa->data_kelas_id === $kelompok->data_kelas_id, 422, 'Siswa bukan dari kelas kelompok ini');

        KkKelompokAnggota::firstOrCreate([
            'kk_kelompok_id' => $kelompok->id,
            'data_siswa_id'  => $siswa->id,
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan');
    }

    public function destroy(KkKelompok $kelompok, KkKelompokAnggota $anggota)
    {
        $this->assertKoordinator($kelompok);

        abort_unless($anggota->kk_kelompok_id === $kelompok->id, 404);

        $anggota->delete();

        return back()->with('success', 'Anggota berhasil dihapus');
    }
}
