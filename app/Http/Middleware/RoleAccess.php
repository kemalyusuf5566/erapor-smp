<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\DataKelas;
use App\Models\DataEkstrakurikuler;
use Illuminate\Support\Facades\Auth;

class RoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $access
     */
    public function handle(Request $request, Closure $next, string $access): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        /**
         * ================= ADMIN =================
         */
        if ($access === 'admin') {
            if ($user->peran->nama_peran !== 'admin') {
                abort(403, 'Akses hanya untuk admin');
            }
            return $next($request);
        }

        /**
         * ================= GURU UMUM =================
         */
        if ($access === 'guru') {
            if ($user->peran->nama_peran !== 'guru') {
                abort(403, 'Akses hanya untuk guru');
            }
            return $next($request);
        }

        /**
         * ================= WALI KELAS =================
         * muncul hanya jika user adalah wali_kelas di data_kelas
         */
        if ($access === 'wali_kelas') {
            if ($user->peran->nama_peran !== 'guru') {
                abort(403);
            }

            $isWali = DataKelas::where('wali_kelas_id', $user->id)->exists();

            if (!$isWali) {
                abort(403, 'Anda bukan wali kelas');
            }

            return $next($request);
        }

        /**
         * ================= PEMBINA EKSKUL =================
         * muncul hanya jika user jadi pembina di data_ekstrakurikuler
         */
        if ($access === 'pembina_ekskul') {
            if ($user->peran->nama_peran !== 'guru') {
                abort(403);
            }

            $isPembina = DataEkstrakurikuler::where('pembina_id', $user->id)->exists();

            if (!$isPembina) {
                abort(403, 'Anda bukan pembina ekstrakurikuler');
            }

            return $next($request);
        }

        abort(403);
    }
}
