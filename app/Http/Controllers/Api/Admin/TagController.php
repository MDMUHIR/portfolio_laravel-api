<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        $tags = Tag::withCount('projects')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $tags,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag created successfully',
            'data' => $tag,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $tag = Tag::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag updated successfully',
            'data' => $tag,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $tag = Tag::findOrFail($id);
        $tag->projects()->detach();
        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully',
        ]);
    }
}
