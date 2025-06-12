<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log; // nodig voor Log::info()

class ActivityLogController extends Controller
{
    // Logs bekijken
    public function getLogs(): JsonResponse
    {
        $logs = ActivityLog::with('actor', 'target')
            ->orderBy('created_at', 'desc') // Gebruik created_at
            ->get();

        // DTO map (mooie output maken voor frontend)
        $logs = $logs->map(function ($log) {
            return [
                'actor'     => $log->actor ? $this->formatActor($log->actor) : 'System',
                'action'    => $log->action,
                'target'    => $log->target ? $this->formatTarget($log->target) : ($log->target_type ? $log->target_type . ' #' . $log->target_id : null),
                'severity'  => $log->severity,
                'timestamp' => $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : null,
            ];
        });

        return response()->json(['data' => $logs]);
    }

    // Log wegschrijven → wordt in andere controllers aangeroepen
    public static function logAction(
        string $actorType,
        int $actorId,
        string $action,
        ?string $targetType = null,
        ?int $targetId = null,
        string $severity = 'info'
    ): void {
        // TESTLOG → kijken of logAction wordt bereikt
        Log::info('TESTLOG LOGACTION START', [
            'actorType' => $actorType,
            'actorId' => $actorId,
            'action' => $action,
            'targetType' => $targetType,
            'targetId' => $targetId,
            'severity' => $severity
        ]);

        // TESTLOG → vlak voor create
        Log::info('TESTLOG LOGACTION BEFORE CREATE');

        ActivityLog::create([
            'actor_type'  => $actorType,
            'actor_id'    => $actorId,
            'action'      => $action,
            'target_type' => $targetType,
            'target_id'   => $targetId,
            'severity'    => $severity,
            'created_at'  => now(),
        ]);
    }

    // Helpers voor DTO
    private function formatActor($actor): string
    {
        if ($actor instanceof \App\Models\Admin) {
            return 'Admin: ' . $actor->email;
        }

        if ($actor instanceof \App\Models\Student) {
            return 'Student: ' . $actor->first_name . ' ' . $actor->last_name;
        }

        if ($actor instanceof \App\Models\Company) {
            return 'Company: ' . $actor->name;
        }

        return 'Unknown actor';
    }

    private function formatTarget($target): string
    {
        if ($target instanceof \App\Models\Student) {
            return 'Student: ' . $target->first_name . ' ' . $target->last_name;
        }

        if ($target instanceof \App\Models\Company) {
            return 'Company: ' . $target->name;
        }

        if ($target instanceof \App\Models\Message) {
            return 'Message #' . $target->id;
        }

        if ($target instanceof \App\Models\Appointment) {
            return 'Appointment #' . $target->id;
        }

        return 'Unknown target';
    }
}
