@extends('layouts.adminlte')

@section('page_title','Data Siswa')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Siswa</h3>
  </div>

  <div class="card-body">

    {{-- TOOLBAR ATAS (SAMA KAYA GURU) --}}
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

    {{-- FILTER BAR (SAMA KAYA GURU) --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div>
        <label class="mb-0">
          Tampilkan
          <select id="limitData" class="custom-select custom-select-sm w-auto">
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
          </select>
          data
        </label>
      </div>

      <div>
        <input type="text" id="searchData"
               class="form-control form-control-sm"
               placeholder="Cari..."
               style="width:200px">
      </div>
    </div>

    {{-- TABEL (SAMA KAYA GURU) --}}
    <table id="table-siswa" class="table table-bordered table-hover">
      <thead class="bg-secondary">
        <tr>
          <th width="50">No</th>
          <th>Nama</th>
          <th width="90">Kelas</th>
          <th>NIS</th>
          <th>NISN</th>
          <th width="60">L/P</th>
          <th>Status</th>
          <th width="200">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($siswa as $i => $s)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $s->nama_siswa ?? '-' }}</td>
          <td>{{ optional($s->kelas)->nama_kelas ?? '-' }}</td>
          <td>{{ $s->nis ?? '-' }}</td>
          <td>{{ $s->nisn ?? '-' }}</td>
          <td class="text-center">{{ $s->jenis_kelamin ?? '-' }}</td>
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
                  method="POST" class="d-inline"
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
          <td colspan="8" class="text-center text-muted">
            Data siswa belum tersedia
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

@endsection
