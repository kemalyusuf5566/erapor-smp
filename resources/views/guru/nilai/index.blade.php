@extends('layouts.adminlte')

@section('page_title','Input Nilai')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      Input Nilai – {{ $mapel->nama_mapel }} ({{ $kelas->nama_kelas }})
    </h3>
  </div>

  <form method="POST" action="{{ route('guru.nilai.store') }}">
    @csrf

    {{-- HIDDEN CONTEXT --}}
    <input type="hidden" name="data_kelas_id" value="{{ $kelas->id }}">
    <input type="hidden" name="data_mapel_id" value="{{ $mapel->id }}">
    <input type="hidden" name="data_tahun_pelajaran_id" value="{{ $tahunAktif->id }}">
    <input type="hidden" name="semester" value="{{ $tahunAktif->semester }}">

    <div class="card-body p-0">

      <table class="table table-bordered table-striped mb-0">
        <thead class="bg-secondary">
          <tr>
            <th style="width:50px">No</th>
            <th>Nama Siswa</th>
            <th style="width:120px">Nilai</th>
            <th style="width:120px">Predikat</th>
            <th>Deskripsi</th>
          </tr>
        </thead>
        <tbody>

          @forelse($siswa as $i => $s)
            @php
              $n = $nilai[$s->id] ?? null;
            @endphp
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $s->nama_siswa }}</td>

              <td>
                <input type="number"
                       name="nilai[{{ $s->id }}][nilai_angka]"
                       class="form-control form-control-sm"
                       value="{{ $n->nilai_angka ?? '' }}"
                       min="0" max="100">
              </td>

              <td>
                <select name="nilai[{{ $s->id }}][predikat]"
                        class="form-control form-control-sm">
                  <option value="">-</option>
                  <option value="A" @selected(($n->predikat ?? '')=='A')>A</option>
                  <option value="B" @selected(($n->predikat ?? '')=='B')>B</option>
                  <option value="C" @selected(($n->predikat ?? '')=='C')>C</option>
                  <option value="D" @selected(($n->predikat ?? '')=='D')>D</option>
                </select>
              </td>

              <td>
                <input type="text"
                       name="nilai[{{ $s->id }}][deskripsi]"
                       class="form-control form-control-sm"
                       value="{{ $n->deskripsi ?? '' }}"
                       placeholder="Deskripsi singkat">
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">
                Tidak ada data siswa
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>

    </div>

    <div class="card-footer text-right">
      <button class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan Nilai
      </button>
      <a href="{{ url()->previous() }}" class="btn btn-secondary">
        Kembali
      </a>
    </div>

  </form>
</div>

@endsection
