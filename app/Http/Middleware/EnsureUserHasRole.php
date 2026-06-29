<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Jika user belum login, langsung hentikan ke 401 Unauthorized
        if ($user === null) {
            abort(401, 'Silakan login terlebih dahulu untuk mengakses sistem ini.');
        }

        // Ambil nama role secara aman
        $roleName = $user->role?->name ?? '';
        
        // Mekanisme Cadangan: Jika relasi kosong namun memiliki id, cari langsung ke tabel database
        if (empty($roleName) && $user->role_id) {
            $roleName = Role::find($user->role_id)?->name ?? '';
        }

        $activeRole = strtolower((string) $roleName);
        $allowedRoles = array_map(static fn (string $role): string => strtolower(trim($role)), $roles);

        // Jika role saat ini tidak diizinkan masuk ke rute, lempar status 403
        if (!in_array($activeRole, $allowedRoles, true)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}