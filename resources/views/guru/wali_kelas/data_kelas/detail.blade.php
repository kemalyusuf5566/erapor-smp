@extends('layouts.adminlte')
@section('page_title','Detail Siswa Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <div class="mb-2">
      <b>Kelas:</b> {{ $kelas->nama_kelas }} (Tingkat {{ $kelas->tingkat }})
    </div>

    <table class="table table-bordered table-sm">
      <thead>
        <tr>
          <th width="60">No</th>
          <th>Nama</th>
          <th width="180">NIS/NISN</th>
          <th width="100">L/P</th>
        </tr>
      </thead>
      <tbody>
        @foreach($siswa as $i => $s)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $s->nama_siswa }}</td>
          <td>{{ $s->nis }} / {{ $s->nisn }}</td>
          <td>{{ $s->jenis_kelamin }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
