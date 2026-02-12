@extends('layouts.adminlte')

@section('title', 'Kelola Nilai Akhir')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h4 class="mb-1">Kelola Nilai Akhir</h4>
            <div class="text-muted">
                <div><b>Mata Pelajaran:</b> {{ $pembelajaran->mapel->nama_mapel ?? '-' }}</div>
                <div><b>Kelas:</b> {{ $pembelajaran->kelas->nama_kelas ?? '-' }}</div>
                <div><b>Guru Pengampu:</b> {{ $pembelajaran->guru->nama ?? '-' }}</div>
                <div><b>Tahun Pelajaran:</b> {{ $tahunAktif->tahun_pelajaran }} ({{ $semester }})</div>
            </div>
        </div>

        <div class="d-flex gap-2">
            {{-- tombol terapkan nilai rata-rata --}}
            <form action="{{ route('guru.nilai_akhir.applyAverage', $pembelajaran->id) }}" method="POST"
                  onsubmit="return confirmApplyAverage(this)">
                @csrf
                <input type="hidden" name="nilai_rata" id="nilai_rata_input">
                <button type="submit" class="btn btn-warning">
                    Terapkan Nilai Rata-rata
                </button>
            </form>

            {{-- tombol ke deskripsi capaian (nanti dibuat di langkah berikutnya) --}}
            <a href="{{ route('guru.deskripsi.index', $pembelajaran->id) }}" class="btn btn-primary">
                Edit Deskripsi Capaian
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

    <form action="{{ route('guru.nilai_akhir.update', $pembelajaran->id) }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">No</th>
                            <th style="width:140px;">NIS</th>
                            <th>Nama Siswa</th>
                            <th style="width:120px;">Nilai</th>
                            <th style="min-width:320px;">Capaian TP Optimal</th>
                            <th style="min-width:320px;">Capaian TP Perlu Peningkatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $i => $s)
                            @php
                                $nilai = $nilaiRows[$s->id] ?? null;
                                $nilaiId = $nilai->id ?? null;
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
                                    @if ($tpList->count() === 0)
                                        <span class="text-muted">Belum ada TP. Silakan isi di Kelola TP.</span>
                                    @else
                                        @foreach ($tpList as $tp)
                                            @php
                                                $checked = false;
                                                if ($nilaiId && isset($checkMap[$nilaiId][$tp->id])) {
                                                    $checked = $checkMap[$nilaiId][$tp->id] === 'optimal';
                                                }
                                            @endphp
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="optimal[{{ $s->id }}][]"
                                                       value="{{ $tp->id }}"
                                                       {{ $checked ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $tp->tujuan }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>

                                <td>
                                    @if ($tpList->count() === 0)
                                        <span class="text-muted">Belum ada TP.</span>
                                    @else
                                        @foreach ($tpList as $tp)
                                            @php
                                                $checked = false;
                                                if ($nilaiId && isset($checkMap[$nilaiId][$tp->id])) {
                                                    $checked = $checkMap[$nilaiId][$tp->id] === 'perlu';
                                                }
                                            @endphp
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="perlu[{{ $s->id }}][]"
                                                       value="{{ $tp->id }}"
                                                       {{ $checked ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $tp->tujuan }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
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

<script>
function confirmApplyAverage(formEl) {
    const nilai = prompt('Masukkan nilai rata-rata (0-100) untuk diterapkan ke semua siswa:');
    if (nilai === null) return false;
    const n = parseInt(nilai, 10);
    if (isNaN(n) || n < 0 || n > 100) {
        alert('Nilai harus angka 0 sampai 100.');
        return false;
    }
    document.getElementById('nilai_rata_input').value = n;
    return true;
}
</script>
@endsection
