@extends('layouts.adminlte')
@section('page_title','Kelola Catatan Wali Kelas')

@section('content')
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card">
  <div class="card-body">
    <div class="mb-2">
      <b>Kelas:</b> {{ $kelas->nama_kelas }} |
      <b>Tahun:</b> {{ $tahunAktif->tahun_pelajaran }} |
      <b>Semester:</b> {{ $tahunAktif->semester }}
    </div>

    <form method="POST" action="{{ route('guru.wali-kelas.catatan.update', $kelas->id) }}">
      @csrf
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th width="60">No</th>
            <th>Nama</th>
            <th width="120">NIS</th>
            <th width="90">L/P</th>
            <th>Catatan</th>
            @if($tahunAktif->semester === 'Genap')
              <th width="160">Naik Tingkat</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach($siswa as $i => $s)
          @php $row = $catatan[$s->id] ?? null; @endphp
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $s->nama_siswa }}</td>
            <td>{{ $s->nis }}</td>
            <td>{{ $s->jenis_kelamin }}</td>
            <td>
              <input type="text" class="form-control"
                     name="catatan[{{ $s->id }}]"
                     value="{{ $row?->catatan }}">
            </td>

            @if($tahunAktif->semester === 'Genap')
              <td>
                <select class="form-control" name="status_kenaikan_kelas[{{ $s->id }}]">
                  <option value="">-</option>
                  <option value="naik" @selected(($row?->status_kenaikan_kelas)==='naik')>Naik Kelas</option>
                  <option value="tinggal" @selected(($row?->status_kenaikan_kelas)==='tinggal')>Tinggal Kelas</option>
                </select>
              </td>
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>
      <button class="btn btn-success">Simpan</button>
    </form>
  </div>
</div>
@endsection
