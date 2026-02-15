@extends('layouts.adminlte')

@section('title', 'Leger Nilai - Wali Kelas')
@section('page_title', 'Leger Nilai')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <p>Halaman Leger Nilai Wali Kelas.</p>
      <p>Kelas: <b>{{ $kelas->nama_kelas ?? '-' }}</b></p>
    </div>
  </div>
</div>
@endsection
