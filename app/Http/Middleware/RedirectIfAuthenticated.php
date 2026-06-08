<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect based on role
                $role = Auth::guard($guard)->user()->role;
                switch ($role) {
                    case 'admin':
                        return redirect('/admin/dashboard');
                    case 'seller':
                        return redirect('/seller/dashboard');
                    default:
                        return redirect('/user/dashboard');
                }
            }
        }
        return $next($request);
    }
}
