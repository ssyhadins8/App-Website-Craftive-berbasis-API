<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, $roles)) {
            return response()->json(['message' => 'Forbidden. You do not have the required role.'], 403);
        }
        return $next($request);
    }
}