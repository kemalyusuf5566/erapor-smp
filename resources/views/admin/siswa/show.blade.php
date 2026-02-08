@extends('layouts.adminlte')
@section('page_title','Detail Siswa')

@section('content')
<div class="card card-dark">
  <div class="card-body">
    <p><b>Nama:</b> {{ $siswa->nama_siswa }}</p>
    <p><b>Kelas:</b> {{ optional($siswa->kelas)->nama_kelas }}</p>
    <p><b>NIS / NISN:</b> {{ $siswa->nis }} / {{ $siswa->nisn }}</p>
    <p><b>Alamat:</b> {{ $siswa->alamat }}</p>
    {{-- lanjutkan semua field --}}
  </div>
</div>
@endsection
