@extends('layouts.adminlte')

@section('title', 'Data Pembelajaran')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Data Pembelajaran</h4>
    </div>

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th style="width:60px;">No</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Guru Pengampu</th>
                        <th style="width:260px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembelajaran as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->mapel->nama_mapel ?? '-' }}</td>
                            <td>{{ $row->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $row->guru->nama ?? '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('guru.tp.index', $row->id) }}" 
                                      class="btn btn-sm btn-primary">
                                      Kelola TP</a>
                                    <a href="{{ route('guru.nilai.index', $row->id) }}"
                                       class="btn btn-sm btn-success">
                                       Input Nilai & Deskripsi
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada data pembelajaran untuk guru ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
