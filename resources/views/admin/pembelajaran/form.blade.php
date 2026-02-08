@extends('layouts.adminlte')

@section('page_title', $pembelajaran ? 'Edit Pembelajaran' : 'Tambah Pembelajaran')

@section('content')
<div class="card">
  <div class="card-body">

    <form method="POST"
      action="{{ $pembelajaran ? route('admin.pembelajaran.update',$pembelajaran->id)
                               : route('admin.pembelajaran.store') }}">
      @csrf
      @if($pembelajaran) @method('PUT') @endif

      <div class="form-group">
        <label>Kelas</label>
        <select name="data_kelas_id" class="form-control" required>
          @foreach($kelas as $k)
            <option value="{{ $k->id }}"
              @selected(old('data_kelas_id',$pembelajaran->data_kelas_id ?? '')==$k->id)>
              {{ $k->nama_kelas }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Mata Pelajaran</label>
        <select name="data_mapel_id" class="form-control" required>
          @foreach($mapel as $m)
            <option value="{{ $m->id }}"
              @selected(old('data_mapel_id',$pembelajaran->data_mapel_id ?? '')==$m->id)>
              {{ $m->nama_mapel }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Guru</label>
        <select name="guru_id" class="form-control" required>
          @foreach($guru as $g)
            <option value="{{ $g->id }}"
              @selected(old('guru_id',$pembelajaran->guru_id ?? '')==$g->id)>
              {{ $g->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.pembelajaran.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

  </div>
</div>
@endsection
