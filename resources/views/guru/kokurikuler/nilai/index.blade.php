@extends('layouts.adminlte')

@section('page_title', 'Input Nilai Kokurikuler')

@section('content')
<div class="card">
  <div class="card-body">

    <div class="mb-3">
      <div><b>Kelompok:</b> {{ $kelompok->nama_kelompok }}</div>
      <div><b>Kelas:</b> {{ $kelompok->kelas?->nama_kelas }}</div>
      <div><b>Koordinator:</b> {{ $kelompok->koordinator?->nama }}</div>
      <div><b>Kegiatan:</b> {{ $kelompokKegiatan->kegiatan?->nama_kegiatan }}</div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Dropdown capaian profil --}}
    <form method="GET" action="{{ route('guru.kokurikuler.nilai.index', [$kelompok->id, $kelompokKegiatan->id]) }}" class="mb-3">
      <div class="form-row">
        <div class="col-md-8">
          <select name="capaian" class="form-control" onchange="this.form.submit()">
            <option value="">-- pilih capaian profil (capaian akhir) --</option>
            @foreach($capaianList as $c)
              <option value="{{ $c->id }}" @selected((string)$selectedCapaianId === (string)$c->id)>
                {{ $c->dimensi?->nama_dimensi }} - {{ $c->capaian }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-4 text-right">
          {{-- tombol deskripsi (langkah 5, nanti dibuat) --}}
          <a href="#" class="btn btn-warning disabled">Deskripsi Capaian Kokurikuler</a>
        </div>
      </div>
    </form>

    @if(!$selectedCapaianId)
      <div class="alert alert-info">
        Silakan pilih <b>capaian profil</b> terlebih dahulu untuk menampilkan input nilai.
      </div>
    @else

      <form method="POST" action="{{ route('guru.kokurikuler.nilai.store', [$kelompok->id, $kelompokKegiatan->id]) }}">
        @csrf
        <input type="hidden" name="kk_capaian_akhir_id" value="{{ $selectedCapaianId }}">

        <table class="table table-bordered">
          <thead>
            <tr>
              <th width="60">No</th>
              <th width="180">NIS</th>
              <th>Nama</th>
              <th width="120">L/P</th>
              <th width="220">Predikat</th>
            </tr>
          </thead>
          <tbody>
            @foreach($siswa as $i => $s)
              @php
                $existing = $nilaiBySiswa->get($s->id);
              @endphp
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->jenis_kelamin }}</td>
                <td>
                  <select name="predikat[{{ $s->id }}]" class="form-control">
                    <option value="">-- pilih --</option>
                    @foreach($predikatOptions as $opt)
                      <option value="{{ $opt }}" @selected(($existing?->predikat ?? '') === $opt)>
                        {{ $opt }}
                      </option>
                    @endforeach
                  </select>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('guru.kokurikuler.kegiatan.index', $kelompok->id) }}" class="btn btn-secondary">Kembali</a>
      </form>

    @endif

  </div>
</div>
@endsection
