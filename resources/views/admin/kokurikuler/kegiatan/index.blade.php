@extends('layouts.adminlte')

@section('page_title','Data Kegiatan Kokurikuler')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Data Kegiatan</h3>
    <div class="card-tools">
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus"></i> Tambah Kegiatan
      </button>
    </div>
  </div>

  <div class="card-body">

    {{-- TAMPILKAN ERROR VALIDASI (BIAR KETAHUAN KENAPA GA MASUK DB) --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <strong>Gagal simpan:</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- TABEL --}}
    <table class="table table-bordered table-striped table-hover">
      <thead class="bg-secondary">
        <tr>
          <th style="width:50px">No</th>
          <th>Tema</th>
          <th>Nama Kegiatan</th>
          <th>Deskripsi</th>
          <th style="width:170px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kegiatan as $i => $k)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $k->tema }}</td>
            <td>{{ $k->nama_kegiatan }}</td>
            <td>{{ $k->deskripsi ?? '-' }}</td>
            <td>
              {{-- DETAIL (kalau kamu sudah punya modal detail sendiri, silakan sesuaikan) --}}
              <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalDetail{{ $k->id }}">
                <i class="fas fa-eye"></i> Detail
              </button>

              <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalEdit{{ $k->id }}">
                <i class="fas fa-edit"></i> Edit
              </button>

              <form action="{{ route('admin.kokurikuler.kegiatan.destroy', $k->id) }}"
                    method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus kegiatan ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-xs">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </td>
          </tr>

          {{-- MODAL DETAIL --}}
          <div class="modal fade" id="modalDetail{{ $k->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content bg-dark">
                <div class="modal-header">
                  <h5 class="modal-title">Detail Kegiatan</h5>
                  <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                  <table class="table table-borderless text-white mb-0">
                    <tr><td style="width:180px">Tema</td><td>{{ $k->tema }}</td></tr>
                    <tr><td>Nama Kegiatan</td><td>{{ $k->nama_kegiatan }}</td></tr>
                    <tr><td>Deskripsi</td><td>{{ $k->deskripsi ?? '-' }}</td></tr>
                  </table>
                </div>
              </div>
            </div>
          </div>

          {{-- MODAL EDIT --}}
          <div class="modal fade" id="modalEdit{{ $k->id }}" tabindex="-1">
            <div class="modal-dialog">
              <form method="POST" action="{{ route('admin.kokurikuler.kegiatan.update', $k->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-content">
                  <div class="modal-header bg-dark">
                    <h5 class="modal-title">Edit Kegiatan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                  </div>

                  <div class="modal-body">

                    <div class="form-group">
                      <label>Tema</label>
                      <input type="text"
                             name="tema"
                             class="form-control"
                             value="{{ old('tema', $k->tema) }}"
                             required>
                    </div>

                    <div class="form-group">
                      <label>Nama Kegiatan</label>
                      <input type="text"
                             name="nama_kegiatan"
                             class="form-control"
                             value="{{ old('nama_kegiatan', $k->nama_kegiatan) }}"
                             required>
                    </div>

                    <div class="form-group">
                      <label>Deskripsi</label>
                      <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $k->deskripsi) }}</textarea>
                    </div>

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                      Simpan
                    </button>
                  </div>

                </div>
              </form>
            </div>
          </div>

        @empty
          <tr>
            <td colspan="6" class="text-center text-muted">Data kegiatan belum tersedia</td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.kokurikuler.kegiatan.store') }}">
      @csrf

      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title">Tambah Kegiatan</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>

        <div class="modal-body">

          

          <div class="form-group">
            <label>Tema</label>
            <input type="text"
                   name="tema"
                   class="form-control"
                   value="{{ old('tema') }}"
                   required>
          </div>

          <div class="form-group">
            <label>Nama Kegiatan</label>
            <input type="text"
                   name="nama_kegiatan"
                   class="form-control"
                   value="{{ old('nama_kegiatan') }}"
                   required>
          </div>

          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          {{-- INI YANG PENTING: HARUS SUBMIT --}}
          <button type="submit" class="btn btn-primary">
            Simpan
          </button>
        </div>

      </div>
    </form>
  </div>
</div>

{{-- Kalau ada error validasi, modal tambah otomatis kebuka lagi biar kelihatan --}}
@if ($errors->any())
@push('scripts')
<script>
  $(function(){
    $('#modalTambah').modal('show');
  });
</script>
@endpush
@endif

@endsection
