@extends('layouts.adminlte')

@section('page_title', 'Capaian Akhir Kokurikuler')

@section('content')
<div class="card">
  <div class="card-body">

    <div class="mb-3">
      <div><b>Kelompok:</b> {{ $kelompok->nama_kelompok }}</div>
      <div><b>Kelas:</b> {{ $kelompok->kelas?->nama_kelas }}</div>
      <div><b>Koordinator:</b> {{ $kelompok->koordinator?->nama }}</div>
      <div><b>Kegiatan:</b> {{ $kelompokKegiatan->kegiatan?->nama_kegiatan }}</div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORM TAMBAH --}}
    <form method="POST" action="{{ route('guru.kokurikuler.capaian_akhir.store', [$kelompok->id, $kelompokKegiatan->id]) }}" class="mb-3">
      @csrf
      <div class="form-row">
        <div class="col-md-4">
          <select name="kk_dimensi_id" class="form-control" required>
            <option value="">-- pilih dimensi --</option>
            @foreach($dimensi as $d)
              <option value="{{ $d->id }}">{{ $d->nama_dimensi }}</option>
            @endforeach
          </select>
          @error('kk_dimensi_id')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="col-md-6">
          <input type="text" name="capaian" class="form-control" placeholder="Tulis capaian akhir..." required>
          @error('capaian')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="col-md-2">
          <button class="btn btn-primary btn-block">Tambah</button>
        </div>
      </div>
    </form>

    {{-- TABEL --}}
    <table class="table table-bordered">
      <thead>
        <tr>
          <th width="60">No</th>
          <th width="220">Dimensi</th>
          <th>Capaian Akhir</th>
          <th width="200">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $i => $it)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $it->dimensi?->nama_dimensi }}</td>
          <td>{{ $it->capaian }}</td>
          <td class="d-flex" style="gap:6px;">
            {{-- EDIT inline sederhana --}}
            <button class="btn btn-warning btn-sm" type="button"
              onclick="document.getElementById('edit-{{ $it->id }}').classList.toggle('d-none')">
              Edit
            </button>

            <form method="POST" action="{{ route('guru.kokurikuler.capaian_akhir.destroy', [$kelompok->id, $kelompokKegiatan->id, $it->id]) }}"
                  onsubmit="return confirm('Hapus capaian ini?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </td>
        </tr>

        {{-- FORM EDIT (toggle) --}}
        <tr id="edit-{{ $it->id }}" class="d-none">
          <td colspan="4">
            <form method="POST" action="{{ route('guru.kokurikuler.capaian_akhir.update', [$kelompok->id, $kelompokKegiatan->id, $it->id]) }}">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="col-md-4">
                  <select name="kk_dimensi_id" class="form-control" required>
                    @foreach($dimensi as $d)
                      <option value="{{ $d->id }}" @selected($it->kk_dimensi_id == $d->id)>
                        {{ $d->nama_dimensi }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="capaian" class="form-control" value="{{ $it->capaian }}" required>
                </div>
                <div class="col-md-2">
                  <button class="btn btn-success btn-block">Simpan</button>
                </div>
              </div>
            </form>
          </td>
        </tr>

        @empty
        <tr>
          <td colspan="4" class="text-center">Belum ada capaian akhir</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <a href="{{ route('guru.kokurikuler.kegiatan.index', $kelompok->id) }}" class="btn btn-secondary">
      Kembali
    </a>

  </div>
</div>
@endsection
