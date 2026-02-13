@extends('layouts.adminlte')
@section('page_title','Wali Kelas - Catatan')

@section('content')
<div class="card">
  <div class="card-body">
    <table class="table table-bordered table-sm">
      <thead>
        <tr>
          <th width="60">No</th>
          <th>Nama Kelas</th>
          <th>Tingkat</th>
          <th>Jumlah Siswa</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($kelas as $i => $k)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $k->nama_kelas }}</td>
          <td>{{ $k->tingkat }}</td>
          <td>{{ $k->siswa_count }}</td>
          <td>
            <a class="btn btn-primary btn-sm"
               href="{{ route('guru.wali-kelas.catatan.kelola', $k->id) }}">
              Kelola
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
