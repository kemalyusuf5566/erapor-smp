@extends('layouts.adminlte')

@section('page_title','Kelengkapan Rapor')

@section('content')
    <table class="table">
        <tr>
            <th>Siswa</th>
            <th>Nilai</th>
            <th>Kehadiran</th>
            <th>Catatan</th>
        </tr>
        @foreach($data as $d)
        <tr>
            <td>{{ $d['siswa']->nama_siswa }}</td>
            <td>{{ $d['nilai'] ? '✔' : '✘' }}</td>
            <td>{{ $d['kehadiran'] ? '✔' : '✘' }}</td>
            <td>{{ $d['catatan'] ? '✔' : '✘' }}</td>
        </tr>
        @endforeach
    </table>
@endsection
