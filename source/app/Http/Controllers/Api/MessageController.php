<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


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

    // Gesprek ophalen tussen twee users
    public function getConversation(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user1_id' => 'required|integer',
                'user1_type' => 'required|string',
                'user2_id' => 'required|integer',
                'user2_type' => 'required|string',
            ]);

            $messages = Message::where(function ($query) use ($validated) {
                $query->where('sender_id', $validated['user1_id'])
                    ->where('sender_type', $validated['user1_type'])
                    ->where('receiver_id', $validated['user2_id'])
                    ->where('receiver_type', $validated['user2_type']);
            })->orWhere(function ($query) use ($validated) {
                $query->where('sender_id', $validated['user2_id'])
                    ->where('sender_type', $validated['user2_type'])
                    ->where('receiver_id', $validated['user1_id'])
                    ->where('receiver_type', $validated['user1_type']);
            })->orderBy('created_at', 'asc')->get();

            return response()->json(['conversation' => $messages]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validatiefout',
                'details' => $e->errors()
            ], 422);
        }
    }
}
