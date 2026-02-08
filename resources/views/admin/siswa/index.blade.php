@extends('layouts.adminlte')

@section('page_title','Data Siswa')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Siswa</h3>
  </div>

  <div class="card-body">

    {{-- TOOLBAR ATAS --}}
    <div class="d-flex justify-content-between mb-3">
      <div>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Siswa
        </a>
        <button class="btn btn-danger btn-sm" disabled>
          <i class="fas fa-trash"></i> Hapus Beberapa
        </button>
      </div>

      <div>
        <button class="btn btn-info btn-sm" disabled>
          <i class="fas fa-filter"></i> Filter Data
        </button>
        <button class="btn btn-warning btn-sm" disabled>
          <i class="fas fa-file-import"></i> Import Data Siswa
        </button>
      </div>
    </div>

    {{-- FILTER BAR (SESUAI CONTOH MERAH) --}}
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
          <th>Nama</th>
          <th>Kelas</th>
          <th>NIS / NISN</th>
          <th>L/P</th>
          <th>Status</th>
          <th style="width:180px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($siswa as $i => $s)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $s->nama_siswa }}</td>
            <td>{{ optional($s->kelas)->nama_kelas ?? '-' }}</td>
            <td>{{ $s->nis }} / {{ $s->nisn }}</td>
            <td>{{ $s->jenis_kelamin }}</td>
            <td>
              <span class="badge badge-success">AKTIF</span>
            </td>
            <td>
              <a href="{{ route('admin.siswa.show', $s->id) }}" class="btn btn-success btn-xs">
                <i class="fas fa-eye"></i> Detail
              </a>
              <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-warning btn-xs">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form action="{{ route('admin.siswa.destroy', $s->id) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('Hapus data siswa ini?')">
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
              Data siswa belum tersedia
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

@endsection
