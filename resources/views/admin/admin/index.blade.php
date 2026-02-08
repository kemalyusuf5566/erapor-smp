@extends('layouts.adminlte')

@section('page_title','Data Admin')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Admin</h3>
  </div>

  <div class="card-body">

    {{-- TOOLBAR ATAS --}}
    <div class="d-flex justify-content-between mb-3">
      <div>
        <a href="{{ route('admin.admin.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Admin
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
    <table id="table-admin" class="table table-bordered table-striped table-hover">
      <thead class="bg-secondary">
        <tr>
          <th style="width:50px">No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Status Admin</th>
          <th style="width:180px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($admin as $i => $a)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $a->nama }}</td>
            <td>{{ $a->email }}</td>
            <td>
              <span class="badge {{ $a->status_aktif ? 'badge-success' : 'badge-secondary' }}">
                {{ $a->status_aktif ? 'AKTIF' : 'NON AKTIF' }}
              </span>
            </td>
            <td>
              <a href="{{ route('admin.admin.edit',$a->id) }}"
                 class="btn btn-warning btn-xs">
                <i class="fas fa-edit"></i>
              </a>

              <form action="{{ route('admin.admin.destroy',$a->id) }}"
                    method="POST"
                    class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-xs"
                        onclick="return confirm('Hapus admin ini?')">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted">
              Data admin belum tersedia
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

@endsection

@push('scripts')
<script>
  $(function () {
    $('#table-admin').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      lengthChange: true,
      info: true,
      autoWidth: false,
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
