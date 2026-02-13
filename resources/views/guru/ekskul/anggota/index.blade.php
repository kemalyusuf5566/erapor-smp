@extends('layouts.adminlte')
@section('page_title','Anggota Ekskul')

@section('content')
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card">
  <div class="card-body">
    <div class="mb-3">
      <b>Ekstrakurikuler:</b> {{ $ekskul->nama_ekskul }} <br>
      <b>Pembina:</b> {{ $ekskul->pembina->nama ?? '-' }}
    </div>

    {{-- Tambah anggota (opsional) --}}
    <form method="POST" action="{{ route('guru.ekskul.anggota.store', $ekskul->id) }}" class="form-inline mb-3">
      @csrf
      <select name="data_siswa_id" class="form-control mr-2">
        @foreach($siswaList as $s)
          <option value="{{ $s->id }}">
            {{ $s->nama_siswa }} ({{ $s->kelas->nama_kelas ?? '-' }})
          </option>
        @endforeach
      </select>
      <button class="btn btn-success">Tambah Anggota</button>
    </form>

    <form method="POST" action="{{ route('guru.ekskul.anggota.update', $ekskul->id) }}">
      @csrf

      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th width="60">No</th>
              <th>Nama</th>
              <th width="150">NIS</th>
              <th width="120">Kelas</th>
              <th width="160">Predikat</th>
              <th>Deskripsi</th>
              <th width="90">Hapus</th>
            </tr>
          </thead>
          <tbody>
            @forelse($anggota as $i => $a)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $a->siswa->nama_siswa ?? '-' }}</td>
              <td>{{ $a->siswa->nis ?? '-' }}</td>
              <td>{{ $a->siswa->kelas->nama_kelas ?? '-' }}</td>
              <td>
                <select name="predikat[{{ $a->id }}]" class="form-control">
                  <option value="">-</option>
                  @foreach(['kurang','cukup','baik','sangat baik'] as $p)
                    <option value="{{ $p }}" @selected($a->predikat === $p)>{{ ucfirst($p) }}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <input type="text" class="form-control" name="deskripsi[{{ $a->id }}]" value="{{ $a->deskripsi }}">
              </td>
              <td>
                <form method="POST" action="{{ route('guru.ekskul.anggota.destroy', [$ekskul->id, $a->id]) }}">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus anggota?')">Hapus</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted">Belum ada anggota ekskul.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <button class="btn btn-primary">Simpan</button>
    </form>

  </div>
</div>
@endsection
