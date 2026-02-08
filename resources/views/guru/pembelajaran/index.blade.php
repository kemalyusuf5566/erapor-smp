@extends('layouts.adminlte')

@section('content')
<table>
@foreach($pembelajaran as $p)
<tr>
  <td>{{ $p->kelas->nama_kelas }}</td>
  <td>{{ $p->mapel->nama_mapel }}</td>
  <td>
    <a href="{{ route('guru.nilai', $p->id) }}">Input Nilai</a>
  </td>
</tr>
@endforeach
</table>
@endsection
