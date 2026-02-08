@extends('layouts.adminlte')

@section('page_title','Data Sekolah')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Sekolah</h3>

    <div class="card-tools">
      @if(!$sekolah)
        <a href="{{ route('admin.sekolah.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Data
        </a>
      @else
        <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}" class="btn btn-warning btn-sm">
          <i class="fas fa-edit"></i> Edit Data
        </a>
      @endif
    </div>
  </div>

  <div class="card-body p-0">

    @if($sekolah)
    <table class="table table-bordered table-striped mb-0">
      <tr>
        <th width="250">Nama Sekolah</th>
        <td>{{ $sekolah->nama_sekolah }}</td>
      </tr>
      <tr>
        <th>NPSN</th>
        <td>{{ $sekolah->npsn ?? '-' }}</td>
      </tr>
      {{-- <tr>
        <th>Kode POS</th>
        <td>{{ $sekolah->kode_pos ?? '-' }}</td>
      </tr>
      <tr>
        <th>Telepon</th>
        <td>{{ $sekolah->telepon ?? '-' }}</td>
      </tr>
      <tr>
        <th>Email</th>
        <td>{{ $sekolah->email ?? '-' }}</td>
      </tr>
      <tr>
        <th>Website</th>
        <td>{{ $sekolah->website ?? '-' }}</td>
      </tr> --}}
      <tr>
        <th>Alamat</th>
        <td>{{ $sekolah->alamat ?? '-' }}</td>
      </tr>
      <tr>
        <th>Kepala Sekolah</th>
        <td>{{ $sekolah->kepala_sekolah ?? '-' }}</td>
      </tr>
      <tr>
        <th>NIP Kepala Sekolah</th>
        <td>{{ $sekolah->nip_kepala_sekolah ?? '-' }}</td>
      </tr>
      <tr>
        <th>Logo Sekolah</th>
        <td>
          @if($sekolah->logo)
            <img src="{{ asset('storage/'.$sekolah->logo) }}"
                 style="max-height:120px">
          @else
            <span class="text-muted">Belum ada logo</span>
          @endif
        </td>
      </tr>
    </table>

    @else
      <div class="p-4 text-center text-muted">
        <i class="fas fa-school fa-3x mb-3"></i>
        <p>Data sekolah belum diisi.</p>
        <a href="{{ route('admin.sekolah.create') }}" class="btn btn-primary">
          <i class="fas fa-plus"></i> Tambah Data Sekolah
        </a>
      </div>
    @endif

  </div>
</div>

@endsection
