@extends('layouts.adminlte')

@section('page_title', $admin ? 'Edit Admin' : 'Tambah Admin')

@section('content')
<div class="card">
  <div class="card-body">

    <form method="POST"
      action="{{ $admin ? route('admin.admin.update',$admin->id) : route('admin.admin.store') }}">
      @csrf
      @if($admin) @method('PUT') @endif

      <div class="form-group">
        <label>Nama Admin</label>
        <input type="text" name="nama" class="form-control"
          value="{{ old('nama', $admin->nama ?? '') }}" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control"
          value="{{ old('email', $admin->email ?? '') }}" required>
      </div>

      <div class="form-group">
        <label>Password {{ $admin ? '(Opsional)' : '' }}</label>
        <input type="password" name="password" class="form-control">
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status_aktif" class="form-control">
          <option value="1" @selected(old('status_aktif', $admin->status_aktif ?? 1) == 1)>
            Aktif
          </option>
          <option value="0" @selected(old('status_aktif', $admin->status_aktif ?? 1) == 0)>
            Non Aktif
          </option>
        </select>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.admin.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

  </div>
</div>
@endsection
