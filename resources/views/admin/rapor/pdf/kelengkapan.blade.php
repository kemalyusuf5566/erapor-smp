<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelengkapan Rapor</title>

    <style>
        @page {
            size: 21cm 33cm; /* F4 */
            margin: 2.5cm 2cm 2.5cm 2cm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }

        .page-break { page-break-after: always; }

        .box {
            border: 1px solid #000;
            padding: 6px;
        }

        .line { height: 22px; }

        .foto {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-size: 10px;
        }

        .min-row {
            height: 4.5cm;
        }
    </style>
</head>
<body>

@php
    $namaSekolah = $sekolah->nama_sekolah ?? 'SMP BUMI PERMATA';
    $namaSiswa   = $siswa->nama_siswa ?? '-';
    $nis         = $siswa->nis ?? '-';
    $nisn        = $siswa->nisn ?? '-';
    $kelas       = $siswa->kelas->nama_kelas ?? '-';
@endphp

{{-- HALAMAN 1 --}}
<table>
    <tr><td class="center" style="height:5cm;"><div style="height:4cm;"></div></td></tr>
    <tr><td class="center bold" style="font-size:24px;">RAPOR</td></tr>
    <tr><td class="center bold" style="font-size:14px;">{{ strtoupper($namaSekolah) }}</td></tr>
    <tr><td style="height:2cm;"></td></tr>
    <tr><td class="center">NAMA MURID</td></tr>
    <tr><td class="center"><div class="box" style="width:10cm;margin:auto;">{{ strtoupper($namaSiswa) }}</div></td></tr>
    <tr><td style="height:1cm;"></td></tr>
    <tr><td class="center">NISN / NIS</td></tr>
    <tr><td class="center"><div class="box" style="width:10cm;margin:auto;">{{ $nisn }} / {{ $nis }}</div></td></tr>
    <tr><td style="height:4cm;"></td></tr>
    <tr><td class="center bold">KEMENTERIAN PENDIDIKAN DASAR DAN MENENGAH<br>REPUBLIK INDONESIA</td></tr>
</table>

<div class="page-break"></div>

{{-- HALAMAN 2 --}}
<table>
    <tr><td colspan="2" class="center bold" style="font-size:14px;">RAPOR<br>{{ strtoupper($namaSekolah) }}</td></tr>
    <tr class="line"><td width="40%">Nama Sekolah</td><td>: {{ $namaSekolah }}</td></tr>
    <tr class="line"><td>NPSN</td><td>: {{ $sekolah->npsn ?? '-' }}</td></tr>
    <tr class="line"><td>Alamat Sekolah</td><td>: {{ $sekolah->alamat ?? '-' }}</td></tr>
    <tr class="line"><td>Kode Pos</td><td>: {{ $sekolah->kode_pos ?? '-' }}</td></tr>
    <tr class="line"><td>Telepon</td><td>: {{ $sekolah->telepon ?? '-' }}</td></tr>
    <tr class="line"><td>Desa / Kelurahan</td><td>: {{ $sekolah->desa ?? '-' }}</td></tr>
    <tr class="line"><td>Kecamatan</td><td>: {{ $sekolah->kecamatan ?? '-' }}</td></tr>
    <tr class="line"><td>Kota / Kabupaten</td><td>: {{ $sekolah->kota ?? '-' }}</td></tr>
    <tr class="line"><td>Provinsi</td><td>: {{ $sekolah->provinsi ?? '-' }}</td></tr>
    <tr class="line"><td>Website</td><td>: {{ $sekolah->website ?? '-' }}</td></tr>
    <tr class="line"><td>Email</td><td>: {{ $sekolah->email ?? '-' }}</td></tr>
</table>

<div class="page-break"></div>

{{-- =====================================================
HALAMAN 3 — KETERANGAN TENTANG DIRI MURID
===================================================== --}}
<table>
    <tr><td colspan="3" class="center bold">KETERANGAN TENTANG DIRI MURID</td></tr>

    <tr class="line"><td width="5%">1.</td><td width="45%">Nama Lengkap Murid</td><td>: {{ $namaSiswa }}</td></tr>
    <tr class="line"><td>2.</td><td>Nomor Induk / NISN</td><td>: {{ $nis }} / {{ $nisn }}</td></tr>
    <tr class="line"><td>3.</td><td>Tempat, Tanggal Lahir</td><td>: {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ?? '-' }}</td></tr>
    <tr class="line"><td>4.</td><td>Jenis Kelamin</td><td>: {{ $siswa->jenis_kelamin ?? '-' }}</td></tr>
    <tr class="line"><td>5.</td><td>Agama</td><td>: {{ $siswa->agama ?? '-' }}</td></tr>
    <tr class="line"><td>6.</td><td>Status Dalam Keluarga</td><td>: {{ $siswa->status_keluarga ?? '-' }}</td></tr>
    <tr class="line"><td>7.</td><td>Anak Ke</td><td>: {{ $siswa->anak_ke ?? '-' }}</td></tr>
    <tr class="line"><td>8.</td><td>Alamat Murid</td><td>: {{ $siswa->alamat ?? '-' }}</td></tr>
    <tr class="line"><td>9.</td><td>Nomor Telepon</td><td>: {{ $siswa->telepon ?? '-' }}</td></tr>
    <tr class="line"><td>10.</td><td>Sekolah Asal</td><td>: {{ $siswa->sekolah_asal ?? '-' }}</td></tr>

    <tr class="line"><td>11.</td><td>Diterima di Sekolah Ini</td><td></td></tr>
    <tr class="line"><td></td><td style="padding-left:20px;">a. Di Kelas</td><td>: {{ $kelas }}</td></tr>
    <tr class="line"><td></td><td style="padding-left:20px;">b. Pada Tanggal</td><td>: {{ $siswa->tanggal_masuk ?? '-' }}</td></tr>

    <tr class="line"><td>12.</td><td>Nama Orang Tua</td><td></td></tr>
    <tr class="line"><td></td><td style="padding-left:20px;">a. Ayah</td><td>: {{ $siswa->nama_ayah ?? '-' }}</td></tr>
    <tr class="line"><td></td><td style="padding-left:20px;">b. Ibu</td><td>: {{ $siswa->nama_ibu ?? '-' }}</td></tr>

    <tr class="line"><td>13.</td><td>Alamat Orang Tua</td><td>: {{ $siswa->alamat_orang_tua ?? '-' }}</td></tr>
    <tr class="line"><td></td><td>Nomor Telepon Rumah</td><td>: {{ $siswa->telepon_orang_tua ?? '-' }}</td></tr>

    <tr class="line"><td>14.</td><td>Pekerjaan Orang Tua</td><td></td></tr>
    <tr class="line"><td></td><td style="padding-left:20px;">a. Ayah</td><td>: {{ $siswa->pekerjaan_ayah ?? '-' }}</td></tr>
    <tr class="line"><td></td><td style="padding-left:20px;">b. Ibu</td><td>: {{ $siswa->pekerjaan_ibu ?? '-' }}</td></tr>

    <tr class="line"><td>15.</td><td>Nama Wali Murid</td><td>: {{ $siswa->nama_wali ?? '-' }}</td></tr>
    <tr class="line"><td>16.</td><td>Alamat Wali Murid</td><td>: {{ $siswa->alamat_wali ?? '-' }}</td></tr>
    <tr class="line"><td></td><td>Nomor Telepon Rumah</td><td>: {{ $siswa->telepon_wali ?? '-' }}</td></tr>
    <tr class="line"><td>17.</td><td>Pekerjaan Wali Murid</td><td>: {{ $siswa->pekerjaan_wali ?? '-' }}</td></tr>
</table>

<br><br>

<table>
    <tr>
        <td width="40%">
            <div class="foto">Foto Murid<br>3x4</div>
        </td>
        <td width="60%" class="right">
            Bandung, {{ date('d F Y') }}<br>
            Kepala Sekolah<br><br><br><br>
            <span class="bold">{{ $sekolah->kepala_sekolah ?? '________________' }}</span><br>
            NIP. {{ $sekolah->nip_kepala_sekolah ?? '-' }}
        </td>
    </tr>
</table>

<div class="page-break"></div>

{{-- HALAMAN 4 --}}
<table>
    <tr><td colspan="3" class="center bold">KETERANGAN PINDAH SEKOLAH</td></tr>
    <tr><td colspan="3">Nama Murid : {{ $namaSiswa }}</td></tr>
</table>

<br>

<table border="1">
    <tr class="center bold"><td colspan="3">MASUK</td></tr>
    @for($i=0;$i<3;$i++)
    <tr class="min-row">
        <td width="55%">
            1. Nama Murid : &nbsp;<br>
            2. Nomor Induk : &nbsp;<br>
            3. Nama Sekolah : &nbsp;<br>
            4. Masuk di Sekolah ini:<br>
            &nbsp;&nbsp;a. Tanggal : &nbsp;<br>
            &nbsp;&nbsp;b. Di Kelas : &nbsp;<br>
            5. Tahun Pelajaran : &nbsp;
        </td>
        <td width="45%" class="center">
            Kepala Sekolah,<br><br><br><br>
            ___________________________<br>
            NIP.
        </td>
    </tr>
    @endfor
</table>

<div class="page-break"></div>

{{-- HALAMAN 5 --}}
<table>
    <tr><td colspan="4" class="center bold">KETERANGAN PINDAH SEKOLAH</td></tr>
    <tr><td colspan="4">Nama Murid : {{ $namaSiswa }}</td></tr>
</table>

<br>

<table border="1">
    <tr class="center bold"><td colspan="4">KELUAR</td></tr>
    <tr class="center">
        <td>Tanggal</td>
        <td>Kelas yang ditinggalkan</td>
        <td>Sebab-sebab Keluar / Atas Permintaan</td>
        <td>Tanda Tangan Kepala Sekolah / Orang Tua</td>
    </tr>
    @for($i=0;$i<4;$i++)
    <tr class="min-row">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="center">
            Kepala Sekolah,<br><br><br>
            ______________________<br>
            NIP.
        </td>
    </tr>
    @endfor
</table>

</body>
</html>