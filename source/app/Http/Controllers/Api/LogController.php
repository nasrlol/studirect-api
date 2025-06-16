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

}
