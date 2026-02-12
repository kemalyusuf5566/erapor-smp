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
use App\Http\Controllers\Guru\TujuanPembelajaranController;
use App\Http\Controllers\Guru\NilaiAkhirController;
use App\Http\Controllers\Guru\DeskripsiCapaianController;
use App\Http\Controllers\Guru\DashboardController;

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
| Wajib: hanya admin yang boleh masuk /admin/*
*/
Route::middleware(['auth', 'role:admin'])
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
        |----------------------------------------------------------------------
        | KOKURIKULER
        |----------------------------------------------------------------------
        */
        Route::prefix('kokurikuler')
            ->name('kokurikuler.')
            ->group(function () {
                Route::resource('dimensi', KkDimensiController::class);
                Route::resource('kegiatan', KkKegiatanController::class);
                Route::resource('kelompok', KkKelompokController::class);
            });

        /*
        |----------------------------------------------------------------------
        | RAPOR
        |----------------------------------------------------------------------
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
| Minimal: hanya guru_mapel yang boleh masuk /guru/*
| (nanti bisa diperluas untuk multi-role wali_kelas/koordinator_p5/pembina_ekskul)
*/
Route::middleware(['auth', 'role:guru_mapel'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('pembelajaran', [PembelajaranController::class, 'index'])
            ->name('pembelajaran.index');

        Route::get('nilai/{pembelajaran}', [NilaiController::class, 'index'])
            ->name('nilai.index');

        Route::post('nilai', [NilaiController::class, 'store'])
            ->name('nilai.store');
        Route::get('tujuan-pembelajaran/{pembelajaran}', [TujuanPembelajaranController::class, 'index'])
            ->name('tp.index');

        Route::post('tujuan-pembelajaran/{pembelajaran}', [TujuanPembelajaranController::class, 'store'])
            ->name('tp.store');

        Route::delete('tujuan-pembelajaran/hapus/{id}', [TujuanPembelajaranController::class, 'destroy'])
            ->name('tp.destroy');

        Route::get('nilai-akhir/{pembelajaran}', [NilaiAkhirController::class, 'index'])
            ->name('nilai_akhir.index');

        Route::post('nilai-akhir/{pembelajaran}', [NilaiAkhirController::class, 'update'])
            ->name('nilai_akhir.update');

        Route::post('nilai-akhir/{pembelajaran}/apply-average', [NilaiAkhirController::class, 'applyAverage'])
            ->name('nilai_akhir.applyAverage');

        Route::get('deskripsi-capaian/{pembelajaran}', [DeskripsiCapaianController::class, 'index'])
            ->name('deskripsi.index');

        Route::post('deskripsi-capaian/{pembelajaran}', [DeskripsiCapaianController::class, 'update'])
            ->name('deskripsi.update');
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
