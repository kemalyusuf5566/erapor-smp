@extends('layouts.adminlte')
@section('page_title','Pembina Ekskul')

@section('content')
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th width="60">No</th>
            <th>Nama Ekstrakurikuler</th>
            <th>Pembina</th>
            <th width="140">Jumlah Anggota</th>
            <th width="120">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($ekskul as $i => $e)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $e->nama_ekskul }}</td>
            <td>{{ $e->pembina->nama ?? '-' }}</td>
            <td>{{ $e->anggota_count }}</td>
            <td>
              <a class="btn btn-primary btn-sm"
                 href="{{ route('guru.ekskul.anggota.index', $e->id) }}">
                Kelola
              </a>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">Tidak ada ekskul binaan.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
