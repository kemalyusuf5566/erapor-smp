@extends('layouts.adminlte')
@section('page_title','Wali Kelas - Data Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <table class="table table-bordered table-sm">
      <thead>
        <tr>
          <th width="60">No</th>
          <th>ID Kelas</th>
          <th>Nama Kelas</th>
          <th>Tingkat</th>
          <th>Jumlah Siswa</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kelas as $i => $k)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $k->id }}</td>
          <td>{{ $k->nama_kelas }}</td>
          <td>{{ $k->tingkat }}</td>
          <td>{{ $k->siswa_count }}</td>
          <td>
            <a class="btn btn-primary btn-sm"
               href="{{ route('guru.wali-kelas.data-kelas.detail', $k->id) }}">
               Detail
            </a>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted">Anda belum menjadi wali kelas.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
