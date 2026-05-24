<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = $request->user()->items()->latest()->get();

        return response()->json([
            'data' => $items,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        $item = $request->user()->items()->create($validated);

        return response()->json([
            'message' => 'Item created successfully',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Item $item): JsonResponse
    {
        if ($item->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to view this item',
            ], 403);
        }

        return response()->json([
            'data' => $item,
        ]);
    }

    public function update(Request $request, Item $item): JsonResponse
    {
        if ($item->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to update this item',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'details' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        $item->update($validated);

        return response()->json([
            'message' => 'Item updated successfully',
            'data' => $item,
        ]);
    }

    public function destroy(Request $request, Item $item): JsonResponse
    {
        if ($item->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to delete this item',
            ], 403);
        }

        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully',
        ]);
    }
}