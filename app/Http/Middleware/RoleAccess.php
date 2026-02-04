<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        $role = $user->role ? strtolower($user->role->name) : '';
        $routeName = $request->route() ? $request->route()->getName() : '';

        // Allow logout for everyone
        if ($routeName === 'logout') {
            return $next($request);
        }

        // Admin: Full Access
        if ($role === 'admin') {
            return $next($request);
        }

        // HRD: Full Access but Readonly (except GET/HEAD)
        if ($role === 'hrd') {
            // Check if method is state-changing (POST, PUT, DELETE, PATCH)
            // dashboard, index pages are usually GET.
            if (!$request->isMethod('get') && !$request->isMethod('head')) {
                 return abort(403, 'Akses HRD terbatas hanya untuk melihat data (Read Only).');
            }
            return $next($request);
        }

        // Karyawan: Only 'absensi' (attendance)
        if ($role === 'karyawan') {
             // Check if route name starts with 'attendance.'
             if ($routeName && strpos($routeName, 'attendance.') === 0) {
                 return $next($request);
             }
             return abort(403, 'Karyawan hanya memiliki akses ke menu Absensi.');
        }

        // Tamu: Only apply and view status
        if ($role === 'tamu') {
            // Allowed: jobapplicant, jobvacancie (view), selectionapplicant (status?)
            // We allow these prefixes
            $allowedPrefixes = ['jobvacancie.', 'jobapplication.', 'selection.'];
            $isAllowed = false;
            
            if ($routeName) {
                foreach ($allowedPrefixes as $prefix) {
                    if (strpos($routeName, $prefix) === 0) {
                        $isAllowed = true;
                        break;
                    }
                }
            }
            
            if ($isAllowed) {
                return $next($request);
            }
            
            return abort(403, 'Tamu hanya dapat melamar dan melihat status lamaran.');
        }

        // If no role matched or allowed (Fallback)
        return abort(403, 'Role tidak dikenali atau tidak memiliki akses.');
    }
}
