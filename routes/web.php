<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\DataGuruController;
use App\Http\Controllers\Admin\DataAdminController;
use App\Http\Controllers\Admin\DataSekolahController;
use App\Http\Controllers\Admin\DataTahunPelajaranController;
use App\Http\Controllers\Admin\DataKelasController;
use App\Http\Controllers\Admin\DataMapelController;
use App\Http\Controllers\Admin\DataPembelajaranController;
use App\Http\Controllers\Admin\DataEkstrakurikulerController;

// KOKURIKULER
use App\Http\Controllers\Admin\KkDimensiController;
use App\Http\Controllers\Admin\KkKegiatanController;
use App\Http\Controllers\Admin\KkKelompokController;

// RAPOR (TANPA subfolder Rapor)
use App\Http\Controllers\Admin\LegerNilaiController;
use App\Http\Controllers\Admin\CetakRaporController;
use App\Http\Controllers\Admin\KelengkapanRaporPdfController;
use App\Http\Controllers\Admin\RaporSemesterPdfController;

/*
|--------------------------------------------------------------------------
| GURU CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Guru\PembelajaranController;
use App\Http\Controllers\Guru\NilaiController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // MASTER DATA
        Route::resource('siswa', DataSiswaController::class);
        Route::resource('guru', DataGuruController::class);
        Route::resource('admin', DataAdminController::class);

    // ADMINISTRASI
    Route::resource('sekolah', DataSekolahController::class)
        ->except(['show', 'destroy']);

    Route::put(
        'sekolah/{id}/logo',
        [DataSekolahController::class, 'updateLogo']
    )->name('sekolah.updateLogo');


    // TAHUN PELAJARAN
    Route::get('tahun-pelajaran', [DataTahunPelajaranController::class, 'index'])
            ->name('tahun.index');
        Route::post('tahun-pelajaran', [DataTahunPelajaranController::class, 'store'])
            ->name('tahun.store');
        Route::put('tahun-pelajaran/{id}', [DataTahunPelajaranController::class, 'update'])
            ->name('tahun.update');
        Route::put('tahun-pelajaran/{id}/aktif', [DataTahunPelajaranController::class, 'setAktif'])
            ->name('tahun.aktif');

        // ADMINISTRASI LANJUTAN
        Route::resource('kelas', DataKelasController::class);
        Route::resource('mapel', DataMapelController::class);
        Route::resource('pembelajaran', DataPembelajaranController::class);
        Route::resource('ekstrakurikuler', DataEkstrakurikulerController::class);

        /*
        |--------------------------------------------------------------------------
        | KOKURIKULER
        |--------------------------------------------------------------------------
        */
        Route::prefix('kokurikuler')
            ->name('kokurikuler.')
            ->group(function () {
                Route::resource('dimensi', KkDimensiController::class);
                Route::resource('kegiatan', KkKegiatanController::class);
                Route::resource('kelompok', KkKelompokController::class);
            });

        /*
        |--------------------------------------------------------------------------
        | RAPOR
        |--------------------------------------------------------------------------
        */
        Route::prefix('rapor')
            ->name('rapor.')
            ->group(function () {

                // LEGER NILAI
                Route::get('leger', [LegerNilaiController::class, 'index'])
                    ->name('leger');
                Route::get('leger/{kelas}', [LegerNilaiController::class, 'detail'])
                    ->name('leger.detail');

                // CETAK RAPOR
                Route::get('cetak', [CetakRaporController::class, 'index'])
                    ->name('cetak');
                Route::get('cetak/{kelas}', [CetakRaporController::class, 'detail'])
                    ->name('cetak.detail');

                // PDF
                Route::get('pdf/kelengkapan/{siswa}', [KelengkapanRaporPdfController::class, 'show'])
                    ->name('pdf.kelengkapan');

                Route::get('pdf/semester/{siswa}', [RaporSemesterPdfController::class, 'show'])
                    ->name('pdf.semester');
            });
    });

/*
|--------------------------------------------------------------------------
| GURU AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

        Route::get('dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');

        Route::get('pembelajaran', [PembelajaranController::class, 'index'])
            ->name('pembelajaran');

        Route::get('nilai/{pembelajaran}', [NilaiController::class, 'index'])
            ->name('nilai');

        Route::post('nilai', [NilaiController::class, 'store'])
            ->name('nilai.store');
    });

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
