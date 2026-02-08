@extends('layouts.adminlte')

@section('page_title','Data Siswa')

@section('content')

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Daftar Siswa</h3>
  </div>

  <div class="card-body">

    @if(empty($siswa) || $siswa->isEmpty())
      <div class="alert alert-info">
        Data siswa belum tersedia
      </div>
    @else
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($siswa as $i => $s)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $s->nama_siswa }}</td>
              <td>{{ optional($s->kelas)->nama_kelas ?? '-' }}</td>
              <td>
                <button class="btn btn-sm btn-warning">Edit</button>
                <button class="btn btn-sm btn-danger">Hapus</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>
</div>

@endsection
