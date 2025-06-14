<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diploma;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class DiplomaController extends Controller
{
    public function index(): JsonResponse
    {
        $diplomas = Diploma::with('student')->get();
        return response()->json(['data' => $diplomas]);
    }

    public function show(string $id): JsonResponse
    {
        $diploma = Diploma::with('student')->findOrFail($id);

        return response()->json(['data' => $diploma]);
    }
}
