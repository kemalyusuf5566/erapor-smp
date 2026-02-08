@extends('layouts.adminlte')

@section('page_title', $mapel ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      {{ $mapel ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}
    </h3>
  </div>

  <form method="POST"
        action="{{ $mapel
          ? route('admin.mapel.update',$mapel->id)
          : route('admin.mapel.store') }}">

    @csrf
    @if($mapel)
      @method('PUT')
    @endif

    <div class="card-body">

      <div class="form-group">
        <label>Nama Mata Pelajaran</label>
        <input type="text"
               name="nama_mapel"
               class="form-control"
               value="{{ old('nama_mapel',$mapel->nama_mapel ?? '') }}"
               required>
      </div>

    </div>

    <div class="card-footer text-right">
      <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">
        Kembali
      </a>
      <button class="btn btn-primary">
        Simpan
      </button>
    </div>

  </form>
</div>

@endsection
