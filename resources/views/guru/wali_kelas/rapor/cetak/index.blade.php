@extends('layouts.adminlte')

@section('title', 'Cetak Rapor - Wali Kelas')
@section('page_title', 'Cetak Rapor')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <p>Halaman Cetak Rapor Wali Kelas.</p>
      <p>Kelas: <b>{{ $kelas->nama_kelas ?? '-' }}</b></p>
    </div>
  </div>
</div>
@endsection
