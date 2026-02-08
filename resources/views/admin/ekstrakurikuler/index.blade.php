@extends('layouts.adminlte')

@section('page_title','Data Ekstrakurikuler')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Ekstrakurikuler</h3>
  </div>

  <div class="card-body">

    {{-- TOOLBAR ATAS --}}
    <div class="d-flex justify-content-between mb-3">
      <div>
        <a href="{{ route('admin.ekstrakurikuler.create') }}"
           class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Ekstrakurikuler
        </a>
      </div>
      <div>
        <button class="btn btn-info btn-sm" disabled>
          <i class="fas fa-filter"></i> Filter Data
        </button>
      </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div class="d-flex align-items-center">
        <span class="mr-2 text-muted">Tampilkan</span>
        <select class="form-control form-control-sm" style="width:90px">
          <option>10</option>
          <option>25</option>
          <option>50</option>
          <option>100</option>
        </select>
        <span class="ml-2 text-muted">data</span>
      </div>

      <div>
        <input type="text"
               class="form-control form-control-sm"
               style="width:220px"
               placeholder="Cari...">
      </div>
    </div>

    {{-- TABEL --}}
    <table class="table table-bordered table-striped table-hover">
      <thead class="bg-secondary">
        <tr>
          <th style="width:50px">No</th>
          <th>Nama</th>
          <th>Pembina</th>
          <th>Status</th>
          <th style="width:120px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($ekskul as $i => $e)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $e->nama_ekskul }}</td>
            <td>{{ $e->pembina->pengguna->nama ?? '-' }}</td>
            <td>
              <span class="badge {{ $e->status_aktif ? 'badge-success' : 'badge-secondary' }}">
                {{ $e->status_aktif ? 'Aktif' : 'Non Aktif' }}
              </span>
            </td>
            <td>
              <a href="{{ route('admin.ekstrakurikuler.edit',$e->id) }}"
                 class="btn btn-warning btn-xs">
                <i class="fas fa-edit"></i> Edit
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted">
              Data ekstrakurikuler belum tersedia
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

@endsection
