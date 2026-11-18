<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk untuk mengakses halaman ini.');
        }

        $user = auth()->user();

        // Super Admin always has full access
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (empty($roles)) {
            // General admin dashboard check: reporter or higher
            if ($user->canAccessDashboard()) {
                return $next($request);
            }
        } else {
            // Check specific role slug
            if ($user->hasRole($roles)) {
                return $next($request);
            }
        }

        abort(403, 'Anda tidak memiliki hak akses untuk tindakan ini.');
    }
}
