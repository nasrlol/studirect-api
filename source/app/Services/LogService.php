<?php

namespace App\Services;

use App\Enums\LogLevel;
use App\Models\Log;

class LogService
{

    public function setLog(string $actor, $actor_id, string $action, string $targetType, LogLevel $severity = LogLevel::NORMAL): void
    {
        Log::create([
            'actor' => $actor,
            'actor_id' => $actor_id,
            'action' => $action,
            'target_type' => $targetType,
            'severity' => $severity->value,
        ]);
    }
}
