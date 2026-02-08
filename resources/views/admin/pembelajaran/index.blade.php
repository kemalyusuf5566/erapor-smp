@extends('layouts.adminlte')

@section('page_title','Data Pembelajaran')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Pembelajaran</h3>
  </div>

  <div class="card-body">

    {{-- TOOLBAR ATAS --}}
    <div class="d-flex justify-content-between mb-3">
      <div>
        <a href="{{ route('admin.pembelajaran.create') }}"
           class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Pembelajaran
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
    <table id="table-pembelajaran"
           class="table table-bordered table-striped table-hover">
      <thead class="bg-secondary">
        <tr>
          <th style="width:50px">No</th>
          <th>Mata Pelajaran</th>
          <th style="width:120px">Kelas</th>
          <th>Guru Pengampu</th>
          <th style="width:140px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @if($pembelajaran->isEmpty())
          <tr>
            <td colspan="5" class="text-center text-muted">
              Data pembelajaran belum tersedia
            </td>
          </tr>
        @else
          @foreach($pembelajaran as $i => $p)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $p->mapel->nama_mapel }}</td>
              <td>{{ $p->kelas->nama_kelas }}</td>
              <td>{{ $p->guru->nama }}</td>
              <td>
                <a href="{{ route('admin.pembelajaran.edit',$p->id) }}"
                   class="btn btn-warning btn-xs">
                  <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('admin.pembelajaran.destroy',$p->id) }}"
                      method="POST"
                      class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-xs"
                          onclick="return confirm('Hapus pembelajaran ini?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

  </div>
</div>

@endsection

@push('scripts')
<script>
  $(function () {
    $('#table-pembelajaran').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      lengthChange: true,
      info: true,
      responsive: true,
      language: {
        lengthMenu: "Tampilkan _MENU_ data",
        search: "Cari:",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        paginate: {
          previous: "‹",
          next: "›"
        }
      }
    });
  });
</script>
@endpush
