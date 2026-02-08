<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataAdminController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $admin = User::with('peran')
            ->whereHas('peran', fn ($q) => $q->where('nama_peran', 'admin'))
            ->orderBy('nama')
            ->get();

        return view('admin.admin.index', compact('admin'));
    }

    public function create()
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        return view('admin.admin.form', [
            'admin' => null
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            'status_aktif' => 'required|boolean',
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['peran_id'] = Peran::where('nama_peran', 'admin')->firstOrFail()->id;

        User::create($data);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Data admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $admin = User::whereHas('peran', fn ($q) => $q->where('nama_peran', 'admin'))
            ->findOrFail($id);

        return view('admin.admin.form', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        abort_unless(Auth::user()->peran->nama_peran === 'admin', 403);

        $admin = User::whereHas('peran', fn ($q) => $q->where('nama_peran', 'admin'))
            ->findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => "required|email|unique:pengguna,email,{$admin->id}",
            'status_aktif' => 'required|boolean',
        ]);

        // password tidak wajib saat edit
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6'
            ]);
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Data admin berhasil diperbarui');
    }
}
