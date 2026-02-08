<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    table { width:100%; border-collapse: collapse; }
    th,td { border:1px solid #000; padding:4px; }
  </style>
</head>
<body>

<h3 style="text-align:center">RAPOR HASIL BELAJAR</h3>

<p>
Nama: {{ $siswa->nama_siswa }} <br>
NISN: {{ $siswa->nisn ?? '-' }}
</p>

<h4>Nilai</h4>
<table>
<tr>
  <th>Mapel</th>
  <th>Nilai</th>
</tr>
@foreach($nilai as $n)
<tr>
  <td>{{ $n->pembelajaran->mapel->nama_mapel }}</td>
  <td>{{ $n->nilai_akhir }}</td>
</tr>
@endforeach
</table>

<h4>Kehadiran</h4>
<p>
Sakit: {{ $kehadiran->sakit ?? 0 }} <br>
Izin: {{ $kehadiran->izin ?? 0 }} <br>
Tanpa Keterangan: {{ $kehadiran->tanpa_keterangan ?? 0 }}
</p>

<h4>Catatan Wali Kelas</h4>
<p>{{ $catatan->catatan ?? '-' }}</p>

</body>
</html>
