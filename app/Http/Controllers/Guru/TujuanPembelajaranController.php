<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DataPembelajaran;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TujuanPembelajaranController extends Controller
{
    public function index($pembelajaranId)
    {
        $user = Auth::user();

        // Pastikan pembelajaran milik guru login
        $pembelajaran = DataPembelajaran::with(['mapel', 'kelas', 'guru'])
            ->where('id', $pembelajaranId)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        $tujuan = TujuanPembelajaran::where('data_pembelajaran_id', $pembelajaran->id)
            ->orderByRaw('COALESCE(urutan, 999999) ASC')
            ->orderBy('id')
            ->get();

        return view('guru.tujuan_pembelajaran.index', compact('pembelajaran', 'tujuan'));
    }

    public function store(Request $request, $pembelajaranId)
    {
        $user = Auth::user();

        // Pastikan pembelajaran milik guru login
        $pembelajaran = DataPembelajaran::where('id', $pembelajaranId)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        // validasi: update existing & tambah baru
        $request->validate([
            'tujuan_existing'           => 'array',
            'tujuan_existing.*'         => 'nullable|string|max:150',
            'tujuan_new'                => 'array',
            'tujuan_new.*'              => 'nullable|string|max:150',
        ]);

        DB::transaction(function () use ($request, $pembelajaran) {

            // 1) UPDATE tujuan yang sudah ada
            $existing = $request->input('tujuan_existing', []);
            $urutan = 1;

            foreach ($existing as $id => $text) {
                $text = trim((string) $text);

                // kalau dikosongkan, kita skip (tidak update)
                if ($text === '') continue;

                TujuanPembelajaran::where('id', $id)
                    ->where('data_pembelajaran_id', $pembelajaran->id)
                    ->update([
                        'tujuan' => $text,
                        'urutan' => $urutan++,
                    ]);
            }

            // 2) INSERT tujuan baru
            $new = $request->input('tujuan_new', []);
            foreach ($new as $text) {
                $text = trim((string) $text);

                if ($text === '') continue;

                TujuanPembelajaran::create([
                    'data_pembelajaran_id' => $pembelajaran->id,
                    'tujuan' => $text,
                    'urutan' => $urutan++,
                ]);
            }
        });

        return back()->with('success', 'Tujuan pembelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        // pastikan TP yang dihapus milik pembelajaran guru login
        $tp = TujuanPembelajaran::with('pembelajaran')
            ->where('id', $id)
            ->firstOrFail();

        if (!$tp->pembelajaran || (int) $tp->pembelajaran->guru_id !== (int) $user->id) {
            abort(403, 'Anda tidak berhak menghapus tujuan pembelajaran ini.');
        }

        $tp->delete();

        return back()->with('success', 'Tujuan pembelajaran berhasil dihapus.');
    }
}
