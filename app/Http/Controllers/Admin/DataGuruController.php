<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peran;


class DataGuruController extends Controller
{
    public function index()
    {
        $guru = DataGuru::with('pengguna')->get();
        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.form', [
            'mode' => 'create',
            'guru' => null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:pengguna,email',
            'password'      => 'required|min:6',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        // AMBIL PERAN GURU (WAJIB DI SINI)
        $peranGuru = Peran::where('nama_peran', 'guru_mapel')->value('id');

        if (!$peranGuru) {
            abort(500, 'Peran guru_mapel belum tersedia');
        }

        DB::transaction(function () use ($request, $peranGuru) {

            $pengguna = User::create([
                'peran_id'     => $peranGuru,
                'nama'         => $request->nama,
                'email'        => $request->email,
                'password'     => bcrypt($request->password),
                'status_aktif' => true,
            ]);

            DataGuru::create([
                'pengguna_id'   => $pengguna->id,
                'nip'           => $request->nip,
                'nuptk'         => $request->nuptk,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
                'telepon'       => $request->telepon,
            ]);
        });

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil disimpan');
    }

    public function show($id)
    {
        $guru = DataGuru::with('pengguna')->findOrFail($id);

        return view('admin.guru.form', [
            'mode' => 'detail',
            'guru' => $guru
        ]);
    }

    public function edit($id)
    {
        $guru = DataGuru::with('pengguna')->findOrFail($id);
        return view('admin.guru.form', [
            'mode' => 'edit',
            'guru' => $guru
        ]);
    }

    public function update(Request $request, $id)
    {
        $guru = DataGuru::with('pengguna')->findOrFail($id);

        $guru->pengguna->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $guru->update($request->only([
            'nip',
            'nuptk',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'telepon'
        ]));

        return redirect()->route('admin.guru.index')->with('success', 'Data guru diperbarui');
    }

    public function destroy($id)
    {
        $guru = DataGuru::findOrFail($id);
        $guru->pengguna->delete(); // otomatis hapus data_guru

        return back()->with('success', 'Guru berhasil dihapus');
    }

    public function detail ($id) {
        $guru = DataGuru::with('pengguna')->findOrFail($id);
        return view('admin.guru.detail-modal', compact('guru'));

    }
}
