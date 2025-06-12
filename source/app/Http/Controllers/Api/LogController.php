<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{

// Log bekijken
    public function getLogs(): JsonResponse
    {
        // $logs = Log::with('admin')->orderBy('timestamp', 'desc')->get();
        // return response()->json(['data' => $logs]);

        // de fk is weg dus ffkes de vorige code uizetten
        $log = Log::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $log
        ]);

    }
    public function setLog(string $action, string $targetType, string $targetId, string $severity = 'info'): void
    {
        // In een echte toepassing zou je hier de huidige ingelogde admin ID gebruiken
        // Voor nu gebruiken we ID 1 als voorbeeld

        Log::create([
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'severity' => $severity,
            // timestamp wordt automatisch ingevuld door de database
        ]);
    }
}
