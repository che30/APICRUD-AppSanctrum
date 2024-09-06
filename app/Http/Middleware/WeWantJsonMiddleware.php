<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WeWantJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    // if (!$request->isMethod('post')) return $next($request);
    

        $acceptHeader = $request->header('Accept');
        // dd($acceptHeader );
        // Log::info();
        
        
        if ($acceptHeader != 'application/json') {
            return response()->json([], 406);
        }

            return $next($request);
        }
}
