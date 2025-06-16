<?php

namespace App\Services;

use App\Enums\LogLevel;
use App\Models\Log;

class LogService
{

    public function setLog(string $actor, string $action, string $targetType, LogLevel $severity = LogLevel::NORMAL): void
    {
        Log::create([
            'actor' => $actor,
            'action' => $action,
            'target_type' => $targetType,
            'severity' => $severity->value,
        ]);
    }
}
