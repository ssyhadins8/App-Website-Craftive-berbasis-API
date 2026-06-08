<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');
        if ($apiKey !== 'craftive-public-key-2026') {
            return response()->json(['message' => 'Unauthorized. Invalid API Key'], 401);
        }
        return $next($request);
    }
}