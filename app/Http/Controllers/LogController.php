<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $logs = $request->user()->logs()->with('item')->latest()->get();

        return response()->json([
            'data' => $logs,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'action' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        // Ensure the item belongs to the authenticated user
        $item = $request->user()->items()->find($validated['item_id']);

        if (!$item) {
            return response()->json([
                'message' => 'Item not found or does not belong to you',
            ], 403);
        }

        $log = Log::create([
            'user_id' => $request->user()->id,
            'item_id' => $validated['item_id'],
            'action' => $validated['action'],
            'note' => $validated['note'] ?? null,
        ]);

        return response()->json([
            'message' => 'Log created successfully',
            'data' => $log,
        ], 201);
    }

    public function show(Request $request, Log $log): JsonResponse
    {
        if ($log->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to view this log',
            ], 403);
        }

        $log->load('item');

        return response()->json([
            'data' => $log,
        ]);
    }
}