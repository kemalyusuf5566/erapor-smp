<?php

    namespace App\Http\Controllers\Guru;

    use App\Http\Controllers\Controller;
    use App\Models\DataPembelajaran;
    use App\Models\DataSiswa;
    use App\Models\DataKelas;
    use App\Models\DataEkstrakurikuler;
    use App\Models\KkKelompok;
    use Illuminate\Support\Facades\Auth;

    class DashboardController extends Controller
    {
        public function index()
        {
            $user = Auth::user();

            // pembelajaran yang diampu guru login
            $kelasIds = DataPembelajaran::where('guru_id', $user->id)
                ->pluck('data_kelas_id')
                ->unique()
                ->values();

            $jumlahPembelajaran = DataPembelajaran::where('guru_id', $user->id)->count();

            // siswa dihitung dari kelas-kelas yang diajar
            $jumlahSiswa = $kelasIds->isEmpty()
                ? 0
                : DataSiswa::whereIn('data_kelas_id', $kelasIds)->count();

            // role tambahan (pakai method hasRole yang sudah kamu rapikan)
            $isKoordinatorKokurikuler = method_exists($user, 'hasRole') ? $user->hasRole('koordinator_p5') : false;
            $isPembinaEkskul = method_exists($user, 'hasRole') ? $user->hasRole('pembina_ekskul') : false;

            // wali kelas bisa pakai pivot ATAU cek data_kelas langsung (biar aman)
            $isWaliKelasByTable = DataKelas::where('wali_kelas_id', $user->id)->exists();
            $isWaliKelasByRole = method_exists($user, 'hasRole') ? $user->hasRole('wali_kelas') : false;
            $isWaliKelas = $isWaliKelasByRole || $isWaliKelasByTable;

            $jumlahKokurikuler = $isKoordinatorKokurikuler
                ? KkKelompok::where('koordinator_id', $user->id)->count()
                : 0;

            $jumlahEkskul = $isPembinaEkskul
                ? DataEkstrakurikuler::where('pembina_id', $user->id)->count()
                : 0;

            $kelasWali = $isWaliKelas
                ? DataKelas::where('wali_kelas_id', $user->id)->get()
                : collect();

            // Kamu simpan view dashboard di: resources/views/guru/dashboard.blade.php
            return view('guru.dashboard', compact(
                'jumlahSiswa',
                'jumlahPembelajaran',
                'isKoordinatorKokurikuler',
                'isPembinaEkskul',
                'isWaliKelas',
                'jumlahKokurikuler',
                'jumlahEkskul',
                'kelasWali'
            ));
        }
    }
