@extends('layouts.adminlte')

@section('page_title', $mode === 'create' ? 'Tambah Data Kelas' : 'Edit Data Kelas')

@section('content')

<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      {{ $mode === 'create' ? 'Tambah Data Kelas' : 'Edit Data Kelas' }}
    </h3>
  </div>

  <form method="POST"
        action="{{ $mode === 'create'
            ? route('admin.kelas.store')
            : route('admin.kelas.update', $kelas->id) }}">

    @csrf
    @if($mode === 'edit')
      @method('PUT')
    @endif

    <input type="hidden"
           name="data_tahun_pelajaran_id"
           value="{{ $tahunAktif->id }}">

    <div class="card-body">

      <div class="form-group">
        <label>Nama Kelas</label>
        <input type="text"
               name="nama_kelas"
               class="form-control"
               value="{{ old('nama_kelas', $kelas->nama_kelas ?? '') }}"
               required>
      </div>

      <div class="form-group">
        <label>Tingkat</label>
        <select name="tingkat" class="form-control" required>
          <option value="">-- Pilih --</option>
          @for($i=7;$i<=9;$i++)
            <option value="{{ $i }}"
              @selected(old('tingkat',$kelas->tingkat ?? '')==$i)>
              Kelas {{ $i }}
            </option>
          @endfor
        </select>
      </div>

      <div class="form-group">
        <label>Wali Kelas</label>
        <select name="wali_kelas_id" class="form-control">
          <option value="">-- Pilih --</option>

          @foreach($wali as $g)
            <option value="{{ $g->pengguna_id }}"
              @selected(old('wali_kelas_id', $kelas->wali_kelas_id ?? '') == $g->pengguna_id)>
              {{ $g->pengguna->nama }}
            </option>
          @endforeach

        </select>
      </div>

    </div>

    <div class="card-footer text-right">
      <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
        Batal
      </a>
      <button class="btn btn-primary">
        Simpan
      </button>
    </div>

  </form>
</div>

@endsection
