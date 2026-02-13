@extends('layouts.adminlte')

@section('page_title', 'Kegiatan Pilihan Kelompok')

@section('content')
<div class="card">
  <div class="card-body">

    <div class="mb-3">
      <div><b>Kelompok:</b> {{ $kelompok->nama_kelompok }}</div>
      <div><b>Kelas:</b> {{ $kelompok->kelas?->nama_kelas }}</div>
      <div><b>Koordinator:</b> {{ $kelompok->koordinator?->nama }}</div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORM TAMBAH KEGIATAN --}}
    <form method="POST" action="{{ route('guru.kokurikuler.kegiatan.store', $kelompok->id) }}" class="mb-3">
      @csrf
      <div class="form-row">
        <div class="col">
          <select name="kk_kegiatan_id" class="form-control" required>
            <option value="">-- pilih kegiatan --</option>
            @foreach($kandidat as $k)
              <option value="{{ $k->id }}">
                {{ $k->tema }} - {{ $k->nama_kegiatan }}
              </option>
            @endforeach
          </select>
          @error('kk_kegiatan_id')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="col-auto">
          <button class="btn btn-primary">Tambah Kegiatan</button>
        </div>
      </div>
    </form>

    {{-- TABEL KEGIATAN PILIHAN --}}
    <table class="table table-bordered">
      <thead>
        <tr>
          <th width="60">No</th>
          <th>Tema</th>
          <th>Nama Kegiatan</th>
          <th>Deskripsi</th>
          <th width="280">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kegiatanPilihan as $i => $row)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row->kegiatan?->tema }}</td>
            <td>{{ $row->kegiatan?->nama_kegiatan }}</td>
            <td>{{ $row->kegiatan?->deskripsi }}</td>
            <td class="d-flex" style="gap:6px; flex-wrap:wrap;">
              {{-- Route ini kita buat di langkah berikutnya (Capaian Akhir, Nilai, Deskripsi) --}}
              <a href="{{ route('guru.kokurikuler.capaian_akhir.index', [$kelompok->id, $row->id]) }}"
                class="btn btn-success btn-sm">
                Capaian Akhir
              </a>

              <a href="{{ route('guru.kokurikuler.nilai.index', [$kelompok->id, $row->id]) }}"
                class="btn btn-primary btn-sm">
                Input Nilai
              </a>
            
              <a href="{{ route('guru.kokurikuler.deskripsi.index', [$kelompok->id, $kegiatan->id]) }}" 
                class="btn btn-warning btn-sm">
                Deskripsi
              </a>
              <a href="#" class="btn btn-info btn-sm disabled">Detail</a>

              <form method="POST"
                    action="{{ route('guru.kokurikuler.kegiatan.destroy', [$kelompok->id, $row->id]) }}"
                    onsubmit="return confirm('Hapus kegiatan ini dari kelompok?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Belum ada kegiatan pilihan</td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>
@endsection
