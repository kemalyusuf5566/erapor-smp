@extends('layouts.adminlte')

@section('page_title','Data Kelas')

@section('content')
<table class="table">
@foreach($kelas as $k)
<tr>
  <td>{{ $k->nama_kelas }}</td>
  <td>
    <a href="{{ route('wali.kelas.siswa',$k->id) }}" class="btn btn-sm btn-primary">
      Lihat Siswa
    </a>
  </td>
</tr>
@endforeach
</table>
@endsection
