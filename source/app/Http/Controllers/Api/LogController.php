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
        $this->authorize('viewAny', Log::class);

        $log = Log::cursorPaginate(15);
        return response()->json(['data' => $log]);
    }

    public function getLogsStudent($id): JsonResponse
    {
        $this->authorize('viewAny', Log::class);

        $logs = Log::where('actor_id', $id)->whereRaw('LOWER(actor) = ?', ['student'])->cursorPaginate(15);
        return response()->json(['data' => $logs]);
    }

    public function getLogsCompany($id): JsonResponse
    {
        $this->authorize('viewAny', Log::class);

        $logs = Log::where('actor_id', $id)->whereRaw('LOWER(actor) = ?', ['company'])->cursorPaginate(15);
        return response()->json(['data' => $logs]);
    }

    public function getLogsAdmin($id): JsonResponse
    {
        $this->authorize('viewAny', Log::class);

        $logs = Log::where('actor_id', $id)->whereRaw('LOWER(actor) = ?', ['admin'])->cursorPaginate(15);
        return response()->json(['data' => $logs]);
    }
}
