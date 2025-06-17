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
        $log = Log::cursorPaginate(15);
        // paginate(15) hoeveelheid logs er per pagina dat er worden gegenereerd

        return response()->json([
            'data' => $log
        ]);
    }

    public function getLogsStudent($id): JsonResponse
    {

        $logs = Log::where('actor_id', $id)->whereRaw('LOWER(actor) = ?', ['student'])->cursorPaginate(15);

        return response()->json([
            'data' => $logs
        ]);
    }

    public function getLogsCompany($id): JsonResponse
    {
        $logs = Log::where('actor_id', $id)->whereRaw('LOWER(actor) = ?', ['company'])->cursorPaginate(15);

        return response()->json([
            'data' => $logs
        ]);
    }

    public function getLogsAdmin($id): JsonResponse
    {
        $logs = Log::where('actor_id', $id)->whereRaw('LOWER(actor) = ?', ['admin'])->cursorPaginate(15);

        return response()->json([
            'data' => $logs
        ]);
    }
}
