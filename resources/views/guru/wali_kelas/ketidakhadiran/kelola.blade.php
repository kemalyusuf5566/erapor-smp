@extends('layouts.adminlte')
@section('page_title','Kelola Ketidakhadiran')

@section('content')
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card">
  <div class="card-body">
    <div class="mb-2">
      <b>Kelas:</b> {{ $kelas->nama_kelas }} |
      <b>Tahun:</b> {{ $tahunAktif->tahun_pelajaran }} |
      <b>Semester:</b> {{ $tahunAktif->semester }}
    </div>

    <form method="POST" action="{{ route('guru.wali-kelas.ketidakhadiran.update', $kelas->id) }}">
      @csrf
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th width="60">No</th>
            <th>Nama</th>
            <th width="120">NIS</th>
            <th width="90">L/P</th>
            <th width="90">Sakit</th>
            <th width="90">Izin</th>
            <th width="140">Tanpa Ket.</th>
          </tr>
        </thead>
        <tbody>
          @foreach($siswa as $i => $s)
          @php $row = $data[$s->id] ?? null; @endphp
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $s->nama_siswa }}</td>
            <td>{{ $s->nis }}</td>
            <td>{{ $s->jenis_kelamin }}</td>
            <td><input type="number" class="form-control" name="sakit[{{ $s->id }}]" value="{{ $row?->sakit ?? 0 }}"></td>
            <td><input type="number" class="form-control" name="izin[{{ $s->id }}]" value="{{ $row?->izin ?? 0 }}"></td>
            <td><input type="number" class="form-control" name="tanpa_keterangan[{{ $s->id }}]" value="{{ $row?->tanpa_keterangan ?? 0 }}"></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <button class="btn btn-success">Simpan</button>
    </form>
  </div>
</div>
@endsection
