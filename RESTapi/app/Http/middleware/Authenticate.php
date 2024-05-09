<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('auth');
        var_dump($token);
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
