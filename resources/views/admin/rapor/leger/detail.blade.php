@extends('layouts.adminlte')

@section('page_title','Detail Leger Nilai')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      Leger Nilai Kelas {{ $kelas->nama_kelas }}
    </h3>

    <div class="card-tools">
      <button class="btn btn-success btn-sm">
        <i class="fas fa-file-excel"></i> Excel
      </button>
      <button class="btn btn-danger btn-sm">
        <i class="fas fa-file-pdf"></i> PDF
      </button>
    </div>
  </div>

  <div class="card-body table-responsive p-0">

    {{-- INFO KELAS --}}
    <table class="table table-bordered mb-3">
      <tr>
        <th width="200">Kelas</th>
        <td>{{ $kelas->nama_kelas }}</td>
      </tr>
      <tr>
        <th>Wali Kelas</th>
        <td>{{ $kelas->waliKelas->nama ?? '-' }}</td>
      </tr>
    </table>

    {{-- TABEL LEGER --}}
    <table class="table table-bordered table-striped">
      <thead class="bg-secondary text-center">
        <tr>
          <th rowspan="2">No</th>
          <th rowspan="2">NIS</th>
          <th rowspan="2">Nama</th>
          <th rowspan="2">L/P</th>

          @foreach($mapel as $m)
            <th>{{ $m->nama_mapel }}</th>
          @endforeach

          <th rowspan="2">Total</th>
          <th rowspan="2">Rata-rata</th>
          <th rowspan="2">Ranking</th>
        </tr>
      </thead>

      <tbody>
        @foreach($siswa as $i => $s)
        @php
          $total = 0;
          $jumlahMapel = 0;
        @endphp
        <tr>
          <td class="text-center">{{ $i + 1 }}</td>
          <td>{{ $s->nis }}</td>
          <td>{{ $s->nama_siswa }}</td>
          <td class="text-center">{{ $s->jenis_kelamin }}</td>

          @foreach($mapel as $m)
            @php
              $n = $nilai[$s->id][$m->id][0]->nilai ?? null;
              if ($n !== null) {
                $total += $n;
                $jumlahMapel++;
              }
            @endphp
            <td class="text-center">{{ $n ?? '-' }}</td>
          @endforeach

          <td class="text-center">{{ $total }}</td>
          <td class="text-center">
            {{ $jumlahMapel ? number_format($total / $jumlahMapel, 2) : '-' }}
          </td>
          <td class="text-center">-</td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>

  <div class="card-footer">
    <a href="{{ route('admin.rapor.leger') }}" class="btn btn-secondary">
      Kembali
    </a>
  </div>
</div>

@endsection
