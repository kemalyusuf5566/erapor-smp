<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\DataKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswa = DataSiswa::with('kelas')
            ->orderBy('nama_siswa')
            ->get();

        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        return view('admin.siswa.form', [
            'mode'  => 'create',
            'siswa' => new DataSiswa(),
            'kelas' => DataKelas::orderBy('nama_kelas')->get(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $data = $this->validatedData($request);

        DataSiswa::create($data);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $siswa = DataSiswa::with('kelas')->findOrFail($id);

        return view('admin.siswa.form', [
            'mode'  => 'detail',
            'siswa' => $siswa,
            'kelas' => DataKelas::orderBy('nama_kelas')->get(),
        ]);
    }

    public function edit(string $id)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $siswa = DataSiswa::findOrFail($id);

        return view('admin.siswa.form', [
            'mode'  => 'edit',
            'siswa' => $siswa,
            'kelas' => DataKelas::orderBy('nama_kelas')->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $siswa = DataSiswa::findOrFail($id);

        $data = $this->validatedData($request);

        $siswa->update($data);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        DataSiswa::findOrFail($id)->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }

    /**
     * VALIDASI TERPUSAT — SATU SUMBER KEBENARAN
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            // A. DATA PRIBADI
            'data_kelas_id'        => 'required|exists:data_kelas,id',
            'nama_siswa'           => 'required|string|max:255',
            'nis'                  => 'nullable|string|max:50',
            'nisn'                 => 'nullable|string|max:50',
            'tempat_lahir'         => 'required|string|max:100',
            'tanggal_lahir'        => 'required|date',
            'jenis_kelamin'        => 'required|in:L,P',
            'agama'                => 'required|string|max:50',
            'status_dalam_keluarga' => 'nullable|string|max:50',
            'anak_ke'              => 'nullable|integer',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:20',

            // B. DATA PENDIDIKAN
            'sekolah_asal'         => 'nullable|string|max:255',
            'diterima_di_kelas'       => 'nullable|string|max:50',
            'tanggal_diterima'     => 'nullable|date',

            // C. ORANG TUA
            'nama_ayah'            => 'nullable|string|max:255',
            'pekerjaan_ayah'       => 'nullable|string|max:255',
            'nama_ibu'             => 'nullable|string|max:255',
            'pekerjaan_ibu'        => 'nullable|string|max:255',
            'alamat_orang_tua'     => 'nullable|string',
            'telepon_orang_tua'    => 'nullable|string|max:20',

            // D. WALI
            'nama_wali'            => 'nullable|string|max:255',
            'pekerjaan_wali'       => 'nullable|string|max:255',
            'alamat_wali'          => 'nullable|string',
            'telepon_wali'         => 'nullable|string|max:20',

            // STATUS
            'status_siswa'         => 'nullable|string|max:20',
        ]);
    }
}
