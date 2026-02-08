<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DataKelasController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\DataMapelController;
use App\Http\Controllers\Admin\DataPembelajaranController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\PembelajaranController;
use App\Http\Controllers\Wali\KelasController;
use App\Http\Controllers\Wali\SiswaController;
use App\Http\Controllers\Wali\KehadiranController;
use App\Http\Controllers\Wali\CatatanController;
use App\Http\Controllers\Wali\LegerController;
use App\Http\Controllers\Wali\KelengkapanController;
use App\Http\Controllers\Wali\RaporController;
use App\Http\Controllers\Wali\CetakRaporController;
use App\Http\Controllers\Admin\DataGuruController;
use App\Http\Controllers\Admin\DataAdminController;
use App\Http\Controllers\Admin\DataSekolahController;
use App\Http\Controllers\Admin\DataTahunPelajaranController;
use App\Http\Controllers\Admin\DataEkstrakurikulerController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        
        Route::resource('kelas', DataKelasController::class);
        Route::resource('siswa', DataSiswaController::class);
        Route::resource('guru', DataGuruController::class);
        Route::get('guru/{guru}/detail', [DataGuruController::class, 'detail'])
            ->name('guru.detail');
        Route::resource('admin', DataAdminController::class);
        Route::resource('mapel', DataMapelController::class);
        Route::resource('pembelajaran', DataPembelajaranController::class);
        Route::resource('sekolah', DataSekolahController::class)
            ->except(['show', 'destroy']);

        Route::get('/tahun-pelajaran', [DataTahunPelajaranController::class, 'index'])
            ->name('tahun.index');

        Route::post('/tahun-pelajaran', [DataTahunPelajaranController::class, 'store'])
            ->name('tahun.store');

        Route::put('/tahun-pelajaran/{id}', [DataTahunPelajaranController::class, 'update'])
            ->name('tahun.update');

        Route::put('/tahun-pelajaran/{id}/aktif', [DataTahunPelajaranController::class, 'setAktif'])
            ->name('tahun.aktif');
        Route::resource('ekstrakurikuler', DataEkstrakurikulerController::class);

    
        });

    Route::middleware(['auth','role:guru_mapel'])
    ->prefix('guru')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('guru.dashboard');
        })->name('guru.dashboard');

        Route::get('/pembelajaran', [PembelajaranController::class, 'index'])
            ->name('guru.pembelajaran');

        Route::get('/nilai/{pembelajaran}', [NilaiController::class, 'index'])
            ->name('guru.nilai');

        Route::post('/nilai', [NilaiController::class, 'store'])
            ->name('guru.nilai.store');
            
    });
Route::middleware(['auth','role:wali_kelas'])
    ->prefix('wali-kelas')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('wali.dashboard');
        })->name('wali.dashboard');

        Route::get('/kelas', [KelasController::class, 'index'])
            ->name('wali.kelas');

        Route::get('/siswa/{kelas}', [SiswaController::class, 'index'])
            ->name('wali.siswa');

        Route::get('/kehadiran/{siswa}', [KehadiranController::class, 'edit'])
            ->name('wali.kehadiran');

        Route::post('/kehadiran', [KehadiranController::class, 'store'])
            ->name('wali.kehadiran.store');

        Route::get('/catatan/{siswa}', [CatatanController::class, 'edit'])
            ->name('wali.catatan');

        Route::post('/catatan', [CatatanController::class, 'store'])
            ->name('wali.catatan.store');
        Route::get('/rapor/leger', [LegerController::class,'index'])
            ->name('wali.leger');
        Route::get('/rapor/kelengkapan', [KelengkapanController::class,'index'])
            ->name('wali.rapor.kelengkapan');
        Route::get('/rapor/preview/{siswa}', [RaporController::class,'show'])
            ->name('wali.rapor.preview');
        Route::get('/rapor/cetak/{siswa}', [CetakRaporController::class,'semester'])
            ->name('wali.rapor.cetak');



    });



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
