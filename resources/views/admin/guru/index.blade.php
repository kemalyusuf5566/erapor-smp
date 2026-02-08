@extends('layouts.adminlte')

@section('page_title','Data Guru')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Guru</h3>
  </div>

  <div class="card-body">

    {{-- TOOLBAR ATAS --}}
    <div class="d-flex justify-content-between mb-3">
      <div>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Guru
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
          <i class="fas fa-file-import"></i> Import Data Guru
        </button>
      </div>
    </div>

    {{-- FILTER BAR (SESUAI KOTAK MERAH) --}}
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

    {{-- TABEL --}}
    <table id="table-guru" class="table table-bordered table-hover">
      <thead class="bg-secondary">
        <tr>
          <th width="50">No</th>
          <th>Nama</th>
          <th width="60">L/P</th>
          <th>NIP</th>
          <th>NUPTK</th>
          <th>Status</th>
          <th width="200">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($guru as $i => $g)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $g->pengguna->nama ?? '-' }}</td>
          <td class="text-center">{{ $g->jenis_kelamin ?? '-' }}</td>
          <td>{{ $g->nip ?? '-' }}</td>
          <td>{{ $g->nuptk ?? '-' }}</td>
          <td>
            <span class="badge badge-success">AKTIF</span>
          </td>
          <td>
            <button class="btn btn-success btn-xs btn-detail-guru"
                    data-id="{{ $g->id }}">
              <i class="fas fa-eye"></i> Detail
            </button>

            <a href="{{ route('admin.guru.edit',$g->id) }}"
               class="btn btn-warning btn-xs">
              <i class="fas fa-edit"></i> Edit
            </a>

            <form action="{{ route('admin.guru.destroy',$g->id) }}"
                  method="POST" class="d-inline"
                  onsubmit="return confirm('Hapus data guru ini?')">
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
            Data guru belum tersedia
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade" id="modalDetailGuru" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title">Detail Guru</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body" id="detailGuruContent">
        <div class="text-center text-muted">Memuat data...</div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a href="{{ route('admin.guru.edit',$g->id) }}" id="btnEditGuru" class="btn btn-warning">Edit</a>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-detail-guru', function () {
    let id = $(this).data('id');

    $('#modalDetailGuru').modal('show');
    $('#detailGuruContent').html('<div class="p-5 text-center">Loading...</div>');

    $.get('/admin/guru/' + id + '/detail', function (res) {
        $('#detailGuruContent').html(res);
    });
});
</script>
@endpush


