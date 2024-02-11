<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($response->isSuccessful()) {
            Log::info('Request accepted', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'headers' => $request->headers->all(),
                'payload' => $request->all(),
                'status_code' => $response->getStatusCode(),
            ]);
        } else {
            Log::error('Request rejected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'headers' => $request->headers->all(),
                'payload' => $request->all(),
                'status_code' => $response->getStatusCode(),
            ]);
        }
        return $response;
    }
}
