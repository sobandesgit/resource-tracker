<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(): JsonResponse
    {
        $groups = Group::with('users')->get();

        return response()->json([
            'data' => $groups,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = Group::create($validated);

        return response()->json([
            'message' => 'Group created successfully',
            'data' => $group,
        ], 201);
    }

    public function show(Group $group): JsonResponse
    {
        $group->load('users');

        return response()->json([
            'data' => $group,
        ]);
    }

    public function addUser(Request $request, Group $group): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $group->users()->syncWithoutDetaching([$validated['user_id']]);

        return response()->json([
            'message' => 'User added to group successfully',
        ]);
    }

    public function removeUser(Request $request, Group $group): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $group->users()->detach($validated['user_id']);

        return response()->json([
            'message' => 'User removed from group successfully',
        ]);
    }
}