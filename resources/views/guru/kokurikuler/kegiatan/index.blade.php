@extends('layouts.adminlte')

@section('title', 'Kelola Kegiatan Kelompok')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="mb-0">Kelola Kegiatan &amp; Input Nilai</h4>
      <small class="text-muted">
        <b>Kelompok:</b> {{ $kelompok->nama_kelompok ?? '-' }} |
        <b>Kelas:</b> {{ $kelompok->kelas->nama_kelas ?? '-' }} |
        <b>Koordinator:</b> {{ $kelompok->koordinator->nama ?? '-' }}
      </small>
    </div>
    <a href="{{ route('guru.kokurikuler.index') }}" class="btn btn-secondary btn-sm">
      Kembali
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- (Opsional) Form tambah kegiatan kalau kamu memang sudah buat --}}
  {{-- Jika belum ada, boleh hapus blok ini --}}
  @if(\Illuminate\Support\Facades\Route::has('guru.kokurikuler.kegiatan.store'))
  <div class="card mb-3">
    <div class="card-body">
      <form method="POST" action="{{ route('guru.kokurikuler.kegiatan.store', $kelompok->id) }}">
        @csrf
        <div class="row">
          <div class="col-md-10">
            <label class="mb-1">Pilih Kegiatan</label>
            <select name="kk_kegiatan_id" class="form-control">
              @foreach($kegiatanList ?? [] as $k)
                <option value="{{ $k->id }}">{{ $k->tema ?? '-' }} — {{ $k->nama_kegiatan }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary btn-block">Tambah</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endif

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width:60px;">No</th>
            <th style="width:220px;">Tema</th>
            <th>Kegiatan</th>
            <th>Deskripsi</th>
            <th style="width:380px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $i => $row)
            @php
              // $row = pivot kk_kelompok_kegiatan
              $pivotId   = $row->id; // INI yang dipakai untuk Capaian Akhir
              $kegiatan  = $row->kegiatan; // relasi ke kk_kegiatan
              $kegiatanId = $kegiatan?->id;
            @endphp

            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $kegiatan->tema ?? '-' }}</td>
              <td>{{ $kegiatan->nama_kegiatan ?? '-' }}</td>
              <td>{{ $kegiatan->deskripsi ?? '-' }}</td>
              <td>

                {{-- 1) CAPAIAN AKHIR (butuh pivot id) --}}
                <a href="{{ route('guru.kokurikuler.capaian_akhir.index', [$kelompok->id, $pivotId]) }}"
                   class="btn btn-sm btn-info">
                  Capaian Akhir
                </a>

                {{-- 2) INPUT NILAI (butuh kegiatan id) --}}
                <a href="{{ route('guru.kokurikuler.nilai.index', [$kelompok->id, $kegiatanId]) }}"
                   class="btn btn-sm btn-warning">
                  Input Nilai
                </a>

                {{-- 3) DESKRIPSI (butuh kegiatan id) --}}
                <a href="{{ route('guru.kokurikuler.deskripsi.index', [$kelompok->id, $kegiatanId]) }}"
                   class="btn btn-sm btn-success">
                  Deskripsi
                </a>

                {{-- 4) HAPUS (hapus pivot) --}}
                @if(\Illuminate\Support\Facades\Route::has('guru.kokurikuler.kegiatan.destroy'))
                  <form method="POST"
                        action="{{ route('guru.kokurikuler.kegiatan.destroy', [$kelompok->id, $pivotId]) }}"
                        class="d-inline"
                        onsubmit="return confirm('Hapus kegiatan dari kelompok ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                      Hapus
                    </button>
                  </form>
                @endif

              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">
                Belum ada kegiatan di kelompok ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
