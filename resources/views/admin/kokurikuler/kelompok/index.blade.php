@extends('layouts.adminlte')

@section('page_title','Kelompok Kokurikuler')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Kelompok Kokurikuler</h3>
    <div class="card-tools">
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahKelompok">
        <i class="fas fa-plus"></i> Tambah Kelompok
      </button>
    </div>
  </div>

  <div class="card-body p-0">
    <table class="table table-bordered table-striped mb-0">
      <thead class="bg-secondary">
        <tr>
          <th width="50">No</th>
          <th>Nama Kelompok</th>
          <th>Kelas</th>
          <th>Koordinator</th>
          <th width="260" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kelompok as $i => $k)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $k->nama_kelompok }}</td>
          <td>{{ $k->kelas->nama_kelas ?? '-' }}</td>
          <td>{{ $k->koordinator->nama ?? '-' }}</td>
          <td class="text-center">

            <a href="#" class="btn btn-info btn-xs">
              <i class="fas fa-users"></i> Anggota
            </a>

            <a href="#" class="btn btn-success btn-xs">
              <i class="fas fa-tasks"></i> Kegiatan
            </a>

            <button class="btn btn-warning btn-xs"
              data-toggle="modal"
              data-target="#modalEdit{{ $k->id }}">
              <i class="fas fa-edit"></i>
            </button>

            <form action="{{ route('admin.kokurikuler.kelompok.destroy',$k->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Hapus kelompok ini?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-xs">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </td>
        </tr>

        {{-- MODAL EDIT --}}
        <div class="modal fade" id="modalEdit{{ $k->id }}">
          <div class="modal-dialog">
            <form method="POST"
                  action="{{ route('admin.kokurikuler.kelompok.update',$k->id) }}">
              @csrf
              @method('PUT')

              <div class="modal-content">
                <div class="modal-header bg-dark">
                  <h5 class="modal-title">Edit Kelompok</h5>
                  <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama Kelompok</label>
                    <input type="text"
                           name="nama_kelompok"
                           class="form-control"
                           value="{{ $k->nama_kelompok }}"
                           required>
                  </div>

                  <div class="form-group">
                    <label>Kelas</label>
                    <select name="data_kelas_id" class="form-control" required>
                      @foreach($kelas as $kl)
                        <option value="{{ $kl->id }}"
                          @selected($k->data_kelas_id == $kl->id)>
                          {{ $kl->nama_kelas }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Koordinator</label>
                    <select name="koordinator_id" class="form-control" required>
                      @foreach($guru as $g)
                        <option value="{{ $g->pengguna_id }}"
                          @selected($k->koordinator_id == $g->pengguna_id)>
                          {{ $g->pengguna->nama }}
                        </option>
                      @endforeach
                    </select>
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
          <td colspan="5" class="text-center text-muted">
            Data kelompok belum tersedia
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahKelompok">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.kokurikuler.kelompok.store') }}">
      @csrf

      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title">Tambah Kelompok</h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Nama Kelompok</label>
            <input type="text"
                   name="nama_kelompok"
                   class="form-control"
                   required>
          </div>

          <div class="form-group">
            <label>Kelas</label>
            <select name="data_kelas_id" class="form-control" required>
              <option value="">-- Pilih Kelas --</option>
              @foreach($kelas as $kl)
                <option value="{{ $kl->id }}">{{ $kl->nama_kelas }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Koordinator</label>
            <select name="koordinator_id" class="form-control" required>
              <option value="">-- Pilih Guru --</option>
              @foreach($guru as $g)
                <option value="{{ $g->pengguna_id }}">{{ $g->pengguna->nama }}</option>
              @endforeach
            </select>
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
