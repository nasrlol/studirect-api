<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'api' => [
            'stateful', // Zorgt voor cookies gebaseerde authenticatie
            'throttle:api', // Throttlerequests zorgt API rate limiting
            'bindings', // zorgt voor een effecientere manier van het terug geven van modellen
            // jammer genoeg niet genoeg tijd voor het allemaal overal te refactoren
        ],
    ];

    protected $middlewareAliases = [
        'throttle' => ThrottleRequests::class,
        'bindings' => SubstituteBindings::class,
        'stateful' => EnsureFrontendRequestsAreStateful::class,
    ];
}
