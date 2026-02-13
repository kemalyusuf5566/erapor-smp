@extends('layouts.adminlte')

@section('page_title', 'Deskripsi Capaian Kokurikuler')

@section('content')

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
  <div class="card-body">
    <div class="mb-2">
      <b>Kelompok:</b> {{ $kelompok->nama_kelompok }} <br>
      <b>Kelas:</b> {{ $kelompok->kelas->nama_kelas ?? '-' }} <br>
      <b>Koordinator:</b> {{ $kelompok->koordinator->nama ?? '-' }} <br>
      <b>Kegiatan:</b> {{ $kegiatan->nama_kegiatan ?? '-' }}
    </div>

    {{-- Tombol balik sesuai narasi --}}
    <div class="mb-3 text-right">
      <a href="{{ route('guru.kokurikuler.nilai.index', [$kelompok->id, $kegiatan->id]) }}"
         class="btn btn-primary btn-sm">
        Input Nilai Kokurikuler
      </a>
    </div>

    <form method="POST" action="{{ route('guru.kokurikuler.deskripsi.update', [$kelompok->id, $kegiatan->id]) }}">
      @csrf

      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th style="width:60px">No</th>
              <th style="width:120px">NIS</th>
              <th>Nama</th>
              <th style="width:100px">L/P</th>
              <th>Deskripsi</th>
            </tr>
          </thead>
          <tbody>
          @forelse($anggota as $i => $row)
            @php
              $siswa = $row->siswa;
              $nilai = $nilaiBySiswa[$siswa->id] ?? null;
            @endphp
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $siswa->nis ?? '-' }}</td>
              <td>{{ $siswa->nama_siswa ?? '-' }}</td>
              <td>{{ $siswa->jenis_kelamin ?? '-' }}</td>
              <td>
                <textarea
                  name="deskripsi[{{ $siswa->id }}]"
                  class="form-control"
                  rows="2"
                >{{ old('deskripsi.'.$siswa->id, $nilai?->deskripsi) }}</textarea>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">Belum ada anggota kelompok.</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <button class="btn btn-success">Simpan Perubahan</button>
    </form>
  </div>
</div>

@endsection
