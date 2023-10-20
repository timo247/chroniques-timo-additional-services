<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class JsonValidationResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($response->exception instanceof ValidationException) {
            $errors = $response->exception->validator->errors();
            return new JsonResponse(['message' => 'Validation failed', 'errors' => $errors], 422);
        }
        return $response;
    }
}
