<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor Semester</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            margin: 20px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px;
            vertical-align: middle;
        }

        .no-border,
        .no-border th,
        .no-border td {
            border: none !important;
        }

        h3, h4 {
            margin: 6px 0;
        }

        .mt-20 { margin-top: 20px; }
    </style>
</head>
<body>

{{-- ================= HEADER ================= --}}
<h3 class="text-center">RAPOR HASIL BELAJAR PESERTA DIDIK</h3>

<table class="no-border">
    <tr>
        <td width="120">Nama Sekolah</td>
        <td width="10">:</td>
        <td>{{ $sekolah->nama_sekolah ?? '-' }}</td>
        <td width="120">Kelas</td>
        <td width="10">:</td>
        <td>{{ $siswa->kelas->nama_kelas }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $sekolah->alamat ?? '-' }}</td>
        <td>Semester</td>
        <td>:</td>
        <td>{{ $tahun->semester ?? '-' }}</td>
    </tr>
    <tr>
        <td>Nama Peserta Didik</td>
        <td>:</td>
        <td>{{ $siswa->nama_siswa }}</td>
        <td>Tahun Pelajaran</td>
        <td>:</td>
        <td>{{ $tahun->tahun_pelajaran ?? '-' }}</td>
    </tr>
    <tr>
        <td>NIS / NISN</td>
        <td>:</td>
        <td>{{ $siswa->nis }} / {{ $siswa->nisn }}</td>
        <td>Wali Kelas</td>
        <td>:</td>
        <td>{{ $siswa->kelas->waliKelas->nama ?? '-' }}</td>
    </tr>
</table>

{{-- ================= NILAI MAPEL ================= --}}
<h4>A. Nilai Akademik</h4>

<table>
    <thead>
        <tr class="text-center">
            <th width="30">No</th>
            <th>Mata Pelajaran</th>
            <th width="70">Nilai</th>
            <th width="70">Predikat</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($nilaiMapel as $i => $n)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $n->mapel->nama_mapel }}</td>
            <td class="text-center">{{ $n->nilai }}</td>
            <td class="text-center">{{ $n->predikat }}</td>
            <td>{{ $n->deskripsi }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Belum ada nilai</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ================= RATA-RATA ================= --}}
<table class="no-border">
    <tr>
        <td width="200"><strong>Rata-rata Nilai</strong></td>
        <td width="10">:</td>
        <td><strong>{{ $rataRata }}</strong></td>
    </tr>
</table>

{{-- ================= KOKURIKULER ================= --}}
<h4>B. Kokurikuler / Ekstrakurikuler</h4>

<table>
    <thead>
        <tr class="text-center">
            <th width="30">No</th>
            <th>Nama Kegiatan</th>
            <th width="100">Predikat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ekskul as $i => $e)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $e->nama_ekskul }}</td>
            <td class="text-center">{{ $e->predikat ?? '-' }}</td>
            <td>{{ $e->deskripsi ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Tidak mengikuti kegiatan</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ================= TANDA TANGAN ================= --}}
<table class="no-border mt-20">
    <tr>
        <td width="60%"></td>
        <td class="text-center">
            {{ now()->format('d F Y') }}<br>
            Wali Kelas<br><br><br><br>
            <strong>{{ $siswa->kelas->waliKelas->nama ?? '-' }}</strong>
        </td>
    </tr>
</table>

</body>
</html>
