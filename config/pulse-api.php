<?php

return [
    // This is the route where the Pulse api is accessible from
    'route_prefix' => 'api/pulse-api',

    // These middleware will be assigned to every Pulse api route
    'route_middleware' => [
        \WebduoNederland\PulseApi\Http\Middleware\PulseApiAuthenticationMiddleware::class,
    ],

    // If using the PulseApiAuthenticationMiddleware you can define multiple api tokens which can be used to access every Pulse api route
    'api_tokens' => [
        'abcDEFghi123',
    ],
];
