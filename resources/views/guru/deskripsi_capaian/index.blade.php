@extends('layouts.adminlte')

@section('title', 'Kelola Deskripsi Capaian')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h4 class="mb-1">Kelola Deskripsi Capaian</h4>
            <div class="text-muted">
                <div><b>Mata Pelajaran:</b> {{ $pembelajaran->mapel->nama_mapel ?? '-' }}</div>
                <div><b>Kelas:</b> {{ $pembelajaran->kelas->nama_kelas ?? '-' }}</div>
                <div><b>Guru Pengampu:</b> {{ $pembelajaran->guru->nama ?? '-' }}</div>
                <div><b>Tahun Pelajaran:</b> {{ $tahunAktif->tahun_pelajaran }} ({{ $semester }})</div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('guru.nilai_akhir.index', $pembelajaran->id) }}" class="btn btn-success">
                Kembali ke Nilai Akhir
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guru.deskripsi.update', $pembelajaran->id) }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">No</th>
                            <th style="width:140px;">NIS</th>
                            <th style="width:240px;">Nama Siswa</th>
                            <th style="width:110px;">Nilai</th>
                            <th>Deskripsi Capaian Tinggi</th>
                            <th>Deskripsi Capaian Rendah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $i => $s)
                            @php
                                $nilai = $nilaiRows[$s->id] ?? null;
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $s->nis ?? '-' }}</td>
                                <td>{{ $s->nama_siswa }}</td>

                                <td>
                                    <input type="number"
                                           class="form-control"
                                           name="nilai[{{ $s->id }}]"
                                           value="{{ old('nilai.'.$s->id, $nilai->nilai_angka ?? '') }}"
                                           min="0" max="100">
                                </td>

                                <td>
                                    <textarea class="form-control"
                                              name="deskripsi_tinggi[{{ $s->id }}]"
                                              rows="2"
                                              placeholder="Isi deskripsi capaian tinggi...">{{ old('deskripsi_tinggi.'.$s->id, $nilai->deskripsi_tinggi ?? '') }}</textarea>
                                </td>

                                <td>
                                    <textarea class="form-control"
                                              name="deskripsi_rendah[{{ $s->id }}]"
                                              rows="2"
                                              placeholder="Isi deskripsi capaian rendah...">{{ old('deskripsi_rendah.'.$s->id, $nilai->deskripsi_rendah ?? '') }}</textarea>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada siswa pada kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
