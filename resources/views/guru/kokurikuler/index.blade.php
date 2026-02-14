@extends('layouts.adminlte')

@section('title', 'Kokurikuler')

@section('content')
<div class="container-fluid">

  <h4 class="mb-4">Kelompok Kokurikuler</h4>

  <div class="card">
    <div class="card-body table-responsive">

      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width:60px;">No</th>
            <th>Nama Kelompok</th>
            <th style="width:160px;">Kelas</th>
            <th style="width:220px;">Koordinator</th>
            <th style="width:260px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($kelompok as $i => $row)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $row->nama_kelompok }}</td>
              <td>{{ $row->kelas->nama_kelas ?? '-' }}</td>
              <td>{{ $row->koordinator->nama ?? '-' }}</td>
              <td>
                <a href="{{ route('guru.kokurikuler.anggota.index', $row->id) }}"
                   class="btn btn-sm btn-primary">
                  Anggota Kelompok
                </a>

                <a href="{{ route('guru.kokurikuler.kegiatan.index', $row->id) }}"
                   class="btn btn-sm btn-success">
                  Kelola Kegiatan &amp; Input Nilai
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">
                Tidak ada kelompok yang Anda koordinatori.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

    </div>
  </div>

</div>
@endsection
