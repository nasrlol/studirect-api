<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Student;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


class MessageController extends Controller
{
    // Bericht versturen
    public function sendMessage(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'sender_id' => 'required|integer',
            'sender_type' => 'required|string', // 'App\Models\Student' of 'App\Models\Company'
            'receiver_id' => 'required|integer',
            'receiver_type' => 'required|string',
            'content' => 'required|string',
        ]);

        $message = Message::create($validated);

        return response()->json(['message' => 'Bericht verzonden.', 'data' => $message]);
    }

