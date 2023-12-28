<?php

namespace WebduoNederland\PulseApi\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PulseApiAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next): JsonResponse|Closure
    {
        if (is_null($request->bearerToken())) {
            return response()->json([
                'success' => false,
                'message' => __('No bearer token supplied!'),
            ], 401);
        }

        if (! in_array($request->bearerToken(), config('pulse-api.api_tokens', []))) {
            return response()->json([
                'success' => false,
                'message' => __('Invalid bearer token!'),
            ], 401);
        }

        return $next($request);
    }
}
