<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use Illuminate\Http\JsonResponse;

class AdminLogController extends Controller
{

// Logs bekijken
    public function getLogs(): JsonResponse
    {
        $logs = AdminLog::with('admin')->orderBy('timestamp', 'desc')->get();
        return response()->json(['data' => $logs]);
    }
}
