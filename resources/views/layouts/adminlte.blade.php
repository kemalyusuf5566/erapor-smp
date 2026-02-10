<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','E-Rapor')</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- FONT AWESOME --}}
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  {{-- NAVBAR --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-link nav-link">Logout</button>
        </form>
      </li>
    </ul>
  </nav>

  {{-- SIDEBAR --}}
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link text-center">
      <span class="brand-text font-weight-light">E-Rapor</span>
    </a>

    <div class="sidebar">
      @php
        $user = auth()->user();
        $role = $user?->peran?->nama_peran;
      @endphp

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

          {{-- ================= ADMIN ================= --}}
          @if($role === 'admin')

          {{-- DASHBOARD --}}
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>

          {{-- PENGGUNA --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Pengguna
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.siswa.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.guru.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Guru</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.admin.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Admin</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- ADMINISTRASI --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Administrasi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.sekolah.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Sekolah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.tahun.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tahun Pelajaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.kelas.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.mapel.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Mapel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.pembelajaran.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pembelajaran</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- EKSTRAKURIKULER (TERPISAH & KEMBALI ADA) --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-futbol"></i>
              <p>
                Ekstrakurikuler
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.ekstrakurikuler.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Ekstrakurikuler</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- KOKURIKULER --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Kokurikuler
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.kokurikuler.dimensi.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dimensi Profil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.kokurikuler.kegiatan.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kegiatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.kokurikuler.kelompok.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelompok Kokurikuler</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- RAPOR --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Rapor
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.rapor.leger') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leger Nilai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.rapor.cetak') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cetak Rapor</p>
                </a>
              </li>
            </ul>
          </li>

          @endif
          {{-- =============== END ADMIN =============== --}}

        </ul>
      </nav>
    </div>
  </aside>

  {{-- CONTENT --}}
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1>@yield('page_title')</h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  <footer class="main-footer text-center">
    <strong>© {{ date('Y') }} E-Rapor | SMP Bumi Permata</strong>
  </footer>

</div>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

@stack('scripts')
</body>
</html>