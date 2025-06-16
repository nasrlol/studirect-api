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
        $log = Log::orderBy('created_at', 'desc')->cursorPaginate(20);
        // paginate(15) hoeveelheid logs er per pagina dat er worden gegenereerd

        return response()->json([
            'data' => $log
        ]);
    }
}
