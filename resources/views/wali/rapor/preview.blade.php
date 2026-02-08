<h3>Rapor Siswa</h3>

<p><strong>Nama:</strong> {{ $siswa->nama_siswa }}</p>

<h4>Nilai</h4>
<ul>
@foreach($nilai as $n)tol
<li>{{ $n->pembelajaran->mapel->nama_mapel }} : {{ $n->nilai_akhir }}</li>
@endforeach
</ul>

<h4>Kehadiran</h4>
<p>Sakit: {{ $kehadiran->sakit ?? 0 }}</p>
<p>Izin: {{ $kehadiran->izin ?? 0 }}</p>
<p>Alpha: {{ $kehadiran->tanpa_keterangan ?? 0 }}</p>

<h4>Catatan Wali</h4>
<p>{{ $catatan->catatan ?? '-' }}</p>
<a href="{{ route('wali.rapor.cetak',$siswa->id) }}"
   target="_blank"
   class="btn btn-success">
   Cetak Rapor (PDF)
</a>