@extends('layouts.adminlte')

@section('title', 'Deskripsi Kokurikuler')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="mb-0">Deskripsi Kokurikuler</h4>
      <small class="text-muted">
        <b>Kelompok:</b> {{ $kelompok->nama_kelompok ?? '-' }} |
        <b>Kelas:</b> {{ $kelompok->kelas->nama_kelas ?? '-' }} |
        <b>Kegiatan:</b> {{ $kegiatan->nama_kegiatan ?? '-' }}
      </small>
    </div>

    <div class="d-flex gap-2">
      <a href="{{ route('guru.kokurikuler.nilai.index', [$kelompok->id, $kegiatan->id]) }}" class="btn btn-primary btn-sm">
        Input Nilai
      </a>
      <a href="{{ route('guru.kokurikuler.kegiatan.index', $kelompok->id) }}" class="btn btn-secondary btn-sm">
        Kembali
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body">

      <form method="POST" action="{{ route('guru.kokurikuler.deskripsi.update', [$kelompok->id, $kegiatan->id]) }}">
        @csrf

        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th style="width:70px;">No</th>
                <th>Nama Siswa</th>
                <th style="width:220px;">Predikat</th>
                <th style="width:420px;">Capaian (terpilih)</th>
                <th>Deskripsi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($anggota as $i => $a)
                @php
                  $siswa = $a->siswa;
                  $nilai = $nilaiRows[$siswa->id] ?? null;
                @endphp
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $siswa->nama_siswa ?? '-' }}</td>
                  <td>{{ $nilai->predikat ?? '-' }}</td>
                  <td>
                    @if($nilai && $nilai->kkCapaianAkhir)
                      {{ $nilai->kkCapaianAkhir->capaian }}
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    <textarea
                      name="deskripsi[{{ $siswa->id }}]"
                      class="form-control form-control-sm"
                      rows="2"
                      placeholder="Tulis deskripsi..."
                    >{{ old("deskripsi.$siswa->id", $nilai->deskripsi ?? '') }}</textarea>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center">Belum ada anggota di kelompok ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3 text-right">
          <button class="btn btn-success btn-sm">Simpan Deskripsi</button>
        </div>

      </form>

    </div>
  </div>

</div>
@endsection
