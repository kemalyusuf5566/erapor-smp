@extends('layouts.adminlte')

@section('page_title', 'Anggota Kelompok Kokurikuler')

@section('content')
<div class="card">
  <div class="card-body">
    <p><b>Kelompok:</b> {{ $kelompok->nama_kelompok }}</p>
    <p><b>Kelas:</b> {{ $kelompok->kelas?->nama_kelas }}</p>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('guru.kokurikuler.anggota.store', $kelompok->id) }}" class="mb-3">
      @csrf
      <div class="form-row">
        <div class="col">
          <select name="data_siswa_id" class="form-control" required>
            <option value="">-- pilih siswa --</option>
            @foreach($kandidat as $s)
              <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_siswa }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-auto">
          <button class="btn btn-primary">Tambah Anggota</button>
        </div>
      </div>
    </form>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th width="60">No</th>
          <th>NIS</th>
          <th>Nama</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($anggota as $i => $a)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $a->siswa?->nis }}</td>
            <td>{{ $a->siswa?->nama_siswa }}</td>
            <td>
              <form method="POST" action="{{ route('guru.kokurikuler.anggota.destroy', [$kelompok->id, $a->id]) }}"
                    onsubmit="return confirm('Hapus anggota ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center">Belum ada anggota</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
