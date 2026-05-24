<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $settings = $request->user()->settings;

        if (!$settings) {
            return response()->json([
                'message' => 'No settings found. Use POST /settings to create them.',
            ], 404);
        }

        return response()->json([
            'data' => $settings,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->user()->settings) {
            return response()->json([
                'message' => 'Settings already exist. Use PUT /settings to update them.',
            ], 409);
        }

        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'timezone' => 'string|max:100',
            'language' => 'string|max:10',
        ]);

        $settings = $request->user()->settings()->create($validated);

        return response()->json([
            'message' => 'Settings created successfully',
            'data' => $settings,
        ], 201);
    }

    public function update(Request $request): JsonResponse
    {
        $settings = $request->user()->settings;

        if (!$settings) {
            return response()->json([
                'message' => 'No settings found. Use POST /settings to create them first.',
            ], 404);
        }

        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'timezone' => 'string|max:100',
            'language' => 'string|max:10',
        ]);

        $settings->update($validated);

        return response()->json([
            'message' => 'Settings updated successfully',
            'data' => $settings,
        ]);
    }
}