<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'E-Rapor')</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  {{-- Navbar --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-link nav-link" type="submit">Logout</button>
        </form>
      </li>
    </ul>
  </nav>

  {{-- Sidebar --}}
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">E-Rapor</span>
    </a>

    <div class="sidebar">
      @php
        $user = auth()->user();
        $role = $user?->peran?->nama_peran;
      @endphp

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

          {{-- ================= ADMIN ================= --}}
          @if ($role === 'admin')

          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-header">PENGGUNA</li>

          <li class="nav-item">
            <a href="{{ route('admin.siswa.index') }}"
               class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Data Siswa</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.guru.index') }}"
               class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Data Guru</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.admin.index') }}"
               class="nav-link {{ request()->routeIs('admin.admin.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>Data Admin</p>
            </a>
          </li>

          <li class="nav-header">ADMINISTRASI</li>
          <li class="nav-item">
              <a href="{{ route('admin.sekolah.index') }}"
                class="nav-link {{ request()->routeIs('admin.sekolah.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-school"></i>
                <p>Data Sekolah</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.tahun.index') }}"
              class="nav-link {{ request()->routeIs('admin.tahun.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar"></i>
              <p>Tahun Pelajaran</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.kelas.index') }}"
               class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-school"></i>
              <p>Data Kelas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.mapel.index') }}"
               class="nav-link {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-school"></i>
              <p>Data Mapel</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.pembelajaran.index') }}"
               class="nav-link {{ request()->routeIs('admin.pembelajaran.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-school"></i>
              <p>Data Pembelajaran</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.ekstrakurikuler.index') }}"
              class="nav-link {{ request()->routeIs('admin.ekstrakurikuler.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-futbol"></i>
              <p>Ekstrakurikuler</p>
            </a>
          </li>
          @endif
          {{-- =============== END ADMIN =============== --}}

        </ul>
      </nav>
    </div>
  </aside>

  {{-- Content --}}
  <div class="content-wrapper">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif
    <section class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>© {{ date('Y') }} E-Rapor</strong>
  </footer>

</div>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('scripts')
</body>
</html>