<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use Illuminate\Http\JsonResponse;

class AdminLogController extends Controller
{
    // Helper functie voor het loggen van admin acties
//    private function logAdminAction(string $action, string $targetType, string $targetId, string $severity = 'info'): void
//    {
//        // In een echte toepassing zou je hier de huidige ingelogde admin ID gebruiken
//        // Voor nu gebruiken we ID 1 als voorbeeld
//        $adminId = 1; // Hier zou je Auth::id() of iets dergelijks gebruiken
//
//        AdminLog::create([
//            'admin_id' => $adminId,
//            'action' => $action,
//            'target_type' => $targetType,
//            'target_id' => $targetId,
//            'severity' => $severity,
//            // timestamp wordt automatisch ingevuld door de database
//        ]);
//    }
// we weten niet voor wat we die moeten gebruiken maar zien wel he (AI)

// Logs bekijken
    public function getLogs(): JsonResponse
    {
        $logs = AdminLog::with('admin')->orderBy('timestamp', 'desc')->get();
        return response()->json(['data' => $logs]);
    }
}
