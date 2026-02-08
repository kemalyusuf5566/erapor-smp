@extends('layouts.adminlte')

@section('page_title', $mode === 'create' ? 'Tambah Data Sekolah' : 'Edit Data Sekolah')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      {{ $mode === 'create' ? 'Tambah Data Sekolah' : 'Edit Data Sekolah' }}
    </h3>
  </div>

  <form method="POST"
        action="{{ $mode === 'create'
          ? route('admin.sekolah.store')
          : route('admin.sekolah.update', $sekolah->id) }}"
        enctype="multipart/form-data">

    @csrf
    @if($mode === 'edit')
      @method('PUT')
    @endif

    <div class="card-body">

      <div class="form-group">
        <label>Nama Sekolah</label>
        <input type="text" name="nama_sekolah" class="form-control" required
          value="{{ old('nama_sekolah', $sekolah->nama_sekolah ?? '') }}">
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>NPSN</label>
          <input type="text" name="npsn" class="form-control"
            value="{{ old('npsn', $sekolah->npsn ?? '') }}">
        </div>

        {{-- <div class="form-group col-md-6">
          <label>NSS</label>
          <input type="text" name="nss" class="form-control"
            value="{{ old('nss', $sekolah->nss ?? '') }}">
        </div> --}}
      </div>

      {{-- <div class="form-row">
        <div class="form-group col-md-6">
          <label>Telepon</label>
          <input type="text" name="telepon" class="form-control"
            value="{{ old('telepon', $sekolah->telepon ?? '') }}">
        </div>

        <div class="form-group col-md-6">
          <label>Kode POS</label>
          <input type="text" name="kode_pos" class="form-control"
            value="{{ old('kode_pos', $sekolah->kode_pos ?? '') }}">
        </div>
      </div> --}}

      <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" rows="3" class="form-control">{{ old('alamat', $sekolah->alamat ?? '') }}</textarea>
      </div>

      {{-- <div class="form-row">
        <div class="form-group col-md-6">
          <label>Email</label>
          <input type="email" name="email" class="form-control"
            value="{{ old('email', $sekolah->email ?? '') }}">
        </div>

        <div class="form-group col-md-6">
          <label>Website</label>
          <input type="text" name="website" class="form-control"
            value="{{ old('website', $sekolah->website ?? '') }}">
        </div>
      </div> --}}

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Kepala Sekolah</label>
          <input type="text" name="kepala_sekolah" class="form-control"
            value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah ?? '') }}">
        </div>

        <div class="form-group col-md-6">
          <label>NIP Kepala Sekolah</label>
          <input type="text" name="nip_kepala_sekolah" class="form-control"
            value="{{ old('nip_kepala_sekolah', $sekolah->nip_kepala_sekolah ?? '') }}">
        </div>
      </div>

      <div class="form-group">
        <label>Logo Sekolah</label>
        <input type="file" name="logo" class="form-control-file">
        @if(!empty($sekolah->logo))
          <div class="mt-2">
            <img src="{{ asset('storage/'.$sekolah->logo) }}"
                 style="max-height:120px">
          </div>
        @endif
      </div>

    </div>

    <div class="card-footer text-right">
      <a href="{{ route('admin.sekolah.index') }}" class="btn btn-secondary">
        Batal
      </a>
      <button class="btn btn-primary">
        Simpan
      </button>
    </div>

  </form>
</div>

@endsection
