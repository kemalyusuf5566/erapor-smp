@extends('layouts.adminlte')

@section('title', 'Dashboard Guru')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Dashboard Guru</h4>

    <div class="row">

        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $jumlahPembelajaran ?? 0 }}</h3>
                    <p>Data Pembelajaran</p>
                </div>
                <a href="{{ route('guru.pembelajaran.index') }}" class="small-box-footer">
                    Lihat Pembelajaran <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        @if (!empty($isWaliKelas) && $isWaliKelas)
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Wali</h3>
                    <p>Menu Wali Kelas</p>
                </div>
                <a href="#" class="small-box-footer">
                    Kelola Rapor <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @endif

    </div>

</div>
@endsection
