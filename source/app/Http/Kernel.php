<?php

namespace App\Http;

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'api' => [
            'headers', // Voegt security headers toe aan de response
            'stateful', // Zorgt voor cookies gebaseerde authenticatie
            'throttle:api', // Throttlerequests zorgt API rate limiting
            'bindings', // zorgt voor een effecientere manier van het terug geven van modellen
            // jammer genoeg niet genoeg tijd voor het allemaal overal te refactoren

        ],
    ];

    protected $middlewareAliases = [
        'headers' => SecurityHeaders::class,
        'throttle' => ThrottleRequests::class,
        'bindings' => SubstituteBindings::class,
        'stateful' => EnsureFrontendRequestsAreStateful::class,
    ];
}
