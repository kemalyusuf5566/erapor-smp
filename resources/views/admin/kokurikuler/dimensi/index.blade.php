@extends('layouts.adminlte')

@section('page_title','Dimensi Profil Kokurikuler')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Dimensi Profil Kokurikuler</h3>
    <div class="card-tools">
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus"></i> Tambah Dimensi
      </button>
    </div>
  </div>

  <div class="card-body p-0">
    <table class="table table-bordered table-striped mb-0">
      <thead class="bg-secondary">
        <tr>
          <th width="60">No</th>
          <th>Nama Dimensi</th>
          <th width="160" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($dimensi as $i => $d)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $d->nama_dimensi }}</td>
          <td class="text-center">
            <button class="btn btn-warning btn-xs"
              data-toggle="modal"
              data-target="#modalEdit{{ $d->id }}">
              <i class="fas fa-edit"></i> Edit
            </button>

            <form action="{{ route('admin.kokurikuler.dimensi.destroy',$d->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Hapus dimensi ini?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-xs">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </form>
          </td>
        </tr>

        {{-- MODAL EDIT --}}
        <div class="modal fade" id="modalEdit{{ $d->id }}">
          <div class="modal-dialog">
            <form method="POST"
                  action="{{ route('admin.kokurikuler.dimensi.update',$d->id) }}">
              @csrf
              @method('PUT')

              <div class="modal-content">
                <div class="modal-header bg-dark">
                  <h5 class="modal-title">Edit Dimensi</h5>
                  <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama Dimensi</label>
                    <input type="text"
                           name="nama_dimensi"
                           class="form-control"
                           value="{{ $d->nama_dimensi }}"
                           required>
                  </div>
                </div>

                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        @empty
        <tr>
          <td colspan="3" class="text-center text-muted">
            Data dimensi belum tersedia
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.kokurikuler.dimensi.store') }}">
      @csrf

      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title">Tambah Dimensi</h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Nama Dimensi</label>
            <input type="text"
                   name="nama_dimensi"
                   class="form-control"
                   placeholder="Contoh: Keimanan dan Ketakwaan"
                   required>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
