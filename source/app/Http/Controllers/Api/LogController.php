<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{

// Logs bekijken
    public function getLogs(): JsonResponse
    {
        $logs = Logs::with('admin')->orderBy('timestamp', 'desc')->get();
        return response()->json(['data' => $logs]);
        // hoe krijgen we nu echte logs hier in????
        // data transfer objects gebruiken om de data al in orde te krijgen en dan pas transferen
        // hiermee bedoel ik dat we eerste alle timestamps van de dinges ophalen wanneer dat die aangemaakt worden fzo
        // en die zetten we dan om naar een log
        // en dan kan je getLog doen
        // de frontend hoort geen post log te doen
    }
    public function setLog(string $action, string $targetType, string $targetId, string $severity = 'info'): void
    {
        // In een echte toepassing zou je hier de huidige ingelogde admin ID gebruiken
        // Voor nu gebruiken we ID 1 als voorbeeld

        Logs::create([
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'severity' => $severity,
            // timestamp wordt automatisch ingevuld door de database
        ]);
    }
}
