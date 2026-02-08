<div class="text-center mb-3">
  <img src="{{ asset('adminlte/dist/img/avatar.png') }}"
       class="img-circle mb-2" width="120">
  <h4>{{ $guru->pengguna->nama }}</h4>
</div>

<hr>

<table class="table table-borderless text-white">
  <tr>
    <td>Status Guru</td>
    <td>
      <span class="badge badge-success">AKTIF</span>
    </td>
  </tr>
  <tr>
    <td>NIP</td>
    <td>{{ $guru->nip ?? '-' }}</td>
  </tr>
  <tr>
    <td>NUPTK</td>
    <td>{{ $guru->nuptk ?? '-' }}</td>
  </tr>
  <tr>
    <td>Tempat, Tanggal Lahir</td>
    <td>{{ $guru->tempat_lahir ?? '-' }}, {{ $guru->tanggal_lahir ?? '-' }}</td>
  </tr>
  <tr>
    <td>Jenis Kelamin</td>
    <td>{{ $guru->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</td>
  </tr>
  <tr>
    <td>Telepon</td>
    <td>{{ $guru->telepon ?? '-' }}</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>{{ $guru->alamat ?? '-' }}</td>
  </tr>
</table>
