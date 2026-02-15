@extends('layouts.adminlte')

@section('title', 'Ekskul Binaan')

@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Ekskul Binaan Saya</h4>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th style="width:60px;">No</th>
            <th>Nama Ekskul</th>
            <th>Pembina</th>
            <th style="width:180px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($ekskul as $i => $row)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row->nama_ekskul ?? $row->nama_ekstrakurikuler ?? '-' }}</td>
            <td>{{ $row->pembina_nama ?? '-' }}</td>
            <td>
              <a href="{{ route('guru.ekskul.anggota.index', $row->id) }}" class="btn btn-primary btn-sm">
                Kelola Anggota & Nilai
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center">Anda belum ditetapkan sebagai pembina ekskul.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
