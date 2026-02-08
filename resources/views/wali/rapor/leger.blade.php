@extends('layouts.adminlte')

@section('page_title','Leger Nilai')

@section('content')
<table class="table table-bordered">
<tr>
  <th>Siswa</th>
  <th>Mapel</th>
  <th>Nilai</th>
</tr>
@foreach($nilai as $n)
<tr>
  <td>{{ $n->siswa->nama_siswa }}</td>
  <td>{{ $n->pembelajaran->mapel->nama_mapel }}</td>
  <td>{{ $n->nilai_akhir }}</td>
</tr>
@endforeach
</table>
@endsection
