@extends('layouts.adminlte')

@section('title', 'Kelola Ekskul')

@section('content')
<div class="container-fluid">
  <h4 class="mb-2">Kelola Anggota Ekskul</h4>
  <div class="mb-3">
    <b>Ekskul:</b> {{ $ekskul->nama_ekskul ?? $ekskul->nama_ekstrakurikuler ?? '-' }}
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card mb-3">
    <div class="card-body">
      <form method="POST" action="{{ route('guru.ekskul.anggota.store', $ekskul->id) }}">
        @csrf
        <div class="row">
          <div class="col-md-8">
            <select name="data_siswa_id" class="form-control" required>
              <option value="">- Pilih Siswa -</option>
              @foreach($siswa as $s)
                <option value="{{ $s->id }}">
                  {{ $s->nama_siswa }} ({{ $s->kelas->nama_kelas ?? '-' }})
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <button class="btn btn-primary w-100" type="submit">Tambah Anggota</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- FORM UPDATE (BULK SIMPAN NILAI/DESKRIPSI) --}}
  <form method="POST" action="{{ route('guru.ekskul.anggota.update', $ekskul->id) }}">
    @csrf

    <div class="card">
      <div class="card-body table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th style="width:60px;">No</th>
              <th>Nama Siswa</th>
              <th style="width:110px;">Predikat</th>
              <th>Deskripsi</th>
              <th style="width:110px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($anggota as $i => $a)
              @php
                $opsi = [
                  'Sangat Baik',
                  'Baik',
                  'Cukup',
                  'Kurang',
                ];
              @endphp

              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $a->siswa->nama_siswa ?? '-' }}</td>

                <td>
                  <select name="nilai[{{ $a->id }}][predikat]" class="form-control form-control-sm">
                   <option value="">-</option>
                    @foreach($opsi as $op)
                      <option value="{{ $op }}" @selected(($a->predikat ?? '') === $op)>{{ $op }}</option>
                    @endforeach
                  </select>
                </td>

                <td>
                  <input type="text"
                         name="nilai[{{ $a->id }}][deskripsi]"
                         value="{{ $a->deskripsi ?? '' }}"
                         class="form-control form-control-sm"
                         placeholder="Deskripsi ekskul...">
                </td>

                <td class="text-center">
                  {{-- tombol hapus submit ke form terpisah (tanpa nested form) --}}
                  <button type="submit"
                          form="del-anggota-{{ $a->id }}"
                          class="btn btn-danger btn-sm"
                          onclick="return confirm('Hapus anggota ini?')">
                    Hapus
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">Belum ada anggota.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="text-right">
          <button class="btn btn-success" type="submit">Simpan Nilai/Deskripsi</button>
        </div>
      </div>
    </div>

  </form>

  {{-- FORM DELETE DITARUH DI LUAR FORM UPDATE (PENTING!) --}}
  @foreach($anggota as $a)
    <form id="del-anggota-{{ $a->id }}"
          method="POST"
          action="{{ route('guru.ekskul.anggota.destroy', [$ekskul->id, $a->id]) }}"
          style="display:none;">
      @csrf
      @method('DELETE')
    </form>
  @endforeach

</div>
@endsection