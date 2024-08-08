<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        // Check if user has any of the roles
        // error roles() disebapkan oleh vs code, kode ini sudah berjalan seperti yang diharapkan
        if (!$user->roles()->whereIn('name', $roles)->exists()) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}