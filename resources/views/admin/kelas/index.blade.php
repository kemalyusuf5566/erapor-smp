@extends('layouts.adminlte')

@section('page_title','Data Kelas')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Kelas</h3>
  </div>

  <div class="card-body">

    {{-- TOOLBAR ATAS --}}
    <div class="d-flex justify-content-between mb-3">
      <div>
        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Kelas
        </a>
        <button class="btn btn-danger btn-sm" disabled>
          <i class="fas fa-trash"></i> Hapus Beberapa
        </button>
      </div>

      <div>
        <button class="btn btn-info btn-sm" disabled>
          <i class="fas fa-filter"></i> Filter Data
        </button>
      </div>
    </div>

    {{-- FILTER BAR (SAMA SEPERTI DATA SISWA) --}}
    <div class="d-flex justify-content-between align-items-center mb-2">

      {{-- TAMPILKAN --}}
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

      {{-- SEARCH --}}
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
          <th>ID Kelas</th>
          <th>Nama Kelas</th>
          <th>Wali Kelas</th>
          <th class="text-center">Tingkat</th>
          <th class="text-center">Jumlah Siswa</th>
          <th style="width:180px" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kelas as $i => $k)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $k->id }}</td>
          <td>{{ $k->nama_kelas }}</td>
          <td>{{ $k->waliKelas->nama ?? '-' }}</td>
          <td class="text-center">{{ $k->tingkat }}</td>
          <td class="text-center">{{ $k->siswa_count ?? 0 }}</td>
          <td class="text-center">
            <a href="{{ route('admin.kelas.edit',$k->id) }}"
               class="btn btn-warning btn-xs">
              <i class="fas fa-edit"></i> Edit
            </a>

            <form action="{{ route('admin.kelas.destroy',$k->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Hapus kelas ini?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-xs">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center text-muted">
            Data kelas belum tersedia
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

@endsection
