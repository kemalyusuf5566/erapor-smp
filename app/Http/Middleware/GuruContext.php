<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\DataKelas;
use App\Models\DataEkstrakurikuler;
use Illuminate\Support\Facades\Auth;

class GuruContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $context
     */
    public function handle(Request $request, Closure $next, string $context): Response
    {
        $user = Auth::user();

        if (!$user || $user->peran?->nama_peran !== 'guru') {
            abort(403, 'Akses hanya untuk guru');
        }

        // ====== CEK KONTEXT ======
        switch ($context) {

            case 'wali':
                $isWali = DataKelas::where('wali_kelas_id', $user->id)->exists();
                if (!$isWali) {
                    abort(403, 'Anda bukan wali kelas');
                }
                break;

            case 'pembina':
                $isPembina = DataEkstrakurikuler::where('pembina_id', $user->id)->exists();
                if (!$isPembina) {
                    abort(403, 'Anda bukan pembina ekstrakurikuler');
                }
                break;

            case 'guru':
                // guru mapel → selalu boleh
                break;

            default:
                abort(403, 'Context tidak valid');
        }

        return $next($request);
    }
}
