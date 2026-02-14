@extends('layouts.adminlte')

@section('title', 'Input Nilai Kokurikuler')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="mb-0">Input Nilai Kokurikuler</h4>
      <small class="text-muted">
        <b>Kelompok:</b> {{ $kelompok->nama_kelompok ?? '-' }} |
        <b>Kelas:</b> {{ $kelompok->kelas->nama_kelas ?? '-' }} |
        <b>Kegiatan:</b> {{ $kegiatan->nama_kegiatan ?? '-' }}
      </small>
    </div>

    <a href="{{ route('guru.kokurikuler.kegiatan.index', $kelompok->id) }}" class="btn btn-secondary btn-sm">
      Kembali
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body">

      <form method="POST" action="{{ route('guru.kokurikuler.nilai.update', [$kelompok->id, $kegiatan->id]) }}">
        @csrf

        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th style="width:70px;">No</th>
                <th>Nama Siswa</th>
                <th style="width:360px;">Capaian Akhir (Dropdown)</th>
                <th style="width:200px;">Predikat</th>
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

                  <td>
                    <select name="nilai[{{ $siswa->id }}][kk_capaian_akhir_id]" class="form-control form-control-sm">
                      <option value="">- pilih capaian akhir -</option>

                      @foreach($capaianAkhir as $ca)
                        <option value="{{ $ca->id }}"
                          {{ (string)($nilai->kk_capaian_akhir_id ?? '') === (string)$ca->id ? 'selected' : '' }}>
                          {{ $ca->dimensi->nama_dimensi ?? 'Dimensi' }} — {{ $ca->capaian }}
                        </option>
                      @endforeach
                    </select>
                  </td>

                  <td>
                    <select name="nilai[{{ $siswa->id }}][predikat]" class="form-control form-control-sm">
                      <option value="">- pilih predikat -</option>
                      @foreach($opsiPredikat as $val => $label)
                        <option value="{{ $val }}"
                          {{ (string)($nilai->predikat ?? '') === (string)$val ? 'selected' : '' }}>
                          {{ $label }}
                        </option>
                      @endforeach
                    </select>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center">Belum ada anggota di kelompok ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3 text-right">
          <button class="btn btn-primary btn-sm">Simpan Nilai</button>
        </div>

      </form>

    </div>
  </div>

</div>
@endsection
