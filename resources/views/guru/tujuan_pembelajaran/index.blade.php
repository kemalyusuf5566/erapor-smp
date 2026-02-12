@extends('layouts.adminlte')

@section('title', 'Kelola Tujuan Pembelajaran')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Kelola Tujuan Pembelajaran</h4>
            <div class="text-muted">
                <div><b>Mata Pelajaran:</b> {{ $pembelajaran->mapel->nama_mapel ?? '-' }}</div>
                <div><b>Kelas:</b> {{ $pembelajaran->kelas->nama_kelas ?? '-' }}</div>
                <div><b>Guru Pengampu:</b> {{ $pembelajaran->guru->nama ?? '-' }}</div>
            </div>
        </div>

        <div class="d-flex gap-2">
            {{-- tombol ke Nilai (sesuaikan dengan route kamu yang sudah ada) --}}
            <a href="{{ route('guru.nilai_akhir.index', $pembelajaran->id) }}" class="btn btn-success">
                Input Nilai
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

    <form action="{{ route('guru.tp.store', $pembelajaran->id) }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-body table-responsive">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Daftar Tujuan Pembelajaran</h6>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">
                        + Tambah Tujuan
                    </button>
                </div>

                <table class="table table-bordered" id="tpTable">
                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Tujuan Pembelajaran (max 150 karakter)</th>
                            <th style="width:120px;">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tujuan as $i => $tp)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <input
                                        type="text"
                                        name="tujuan_existing[{{ $tp->id }}]"
                                        value="{{ old('tujuan_existing.'.$tp->id, $tp->tujuan) }}"
                                        maxlength="150"
                                        class="form-control"
                                        required
                                    >
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('guru.tp.destroy', $tp->id) }}" method="POST" onsubmit="return confirm('Hapus tujuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- jika kosong, kasih 1 baris baru --}}
                            <tr class="tp-new-row">
                                <td>1</td>
                                <td>
                                    <input type="text" name="tujuan_new[]" maxlength="150" class="form-control" required>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">Hapus</button>
                                </td>
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
function addRow() {
    const tbody = document.querySelector('#tpTable tbody');
    const rowCount = tbody.querySelectorAll('tr').length;
    const tr = document.createElement('tr');
    tr.classList.add('tp-new-row');
    tr.innerHTML = `
        <td>${rowCount + 1}</td>
        <td>
            <input type="text" name="tujuan_new[]" maxlength="150" class="form-control" required>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">Hapus</button>
        </td>
    `;
    tbody.appendChild(tr);
}

function removeRow(btn) {
    const row = btn.closest('tr');
    row.remove();

    // refresh nomor
    const rows = document.querySelectorAll('#tpTable tbody tr');
    rows.forEach((r, idx) => {
        r.querySelector('td').innerText = idx + 1;
    });
}
</script>
@endsection
