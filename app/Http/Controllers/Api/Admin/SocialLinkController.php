<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialLinkRequest;
use App\Http\Resources\SocialLinkResource;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index(): JsonResponse
    {
        $links = SocialLink::orderBy('order')->get();

        return response()->json([
            'success' => true,
            'data' => SocialLinkResource::collection($links),
        ]);
    }

    public function store(SocialLinkRequest $request): JsonResponse
    {
        $link = SocialLink::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Social link created successfully',
            'data' => new SocialLinkResource($link),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $link = SocialLink::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new SocialLinkResource($link),
        ]);
    }

    public function update(SocialLinkRequest $request, int $id): JsonResponse
    {
        $link = SocialLink::findOrFail($id);
        $link->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Social link updated successfully',
            'data' => new SocialLinkResource($link),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $link = SocialLink::findOrFail($id);
        $link->delete();

        return response()->json([
            'success' => true,
            'message' => 'Social link deleted successfully',
        ]);
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'links' => 'required|array',
            'links.*.id' => 'required|exists:social_links,id',
            'links.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->links as $item) {
            SocialLink::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
        ]);
    }
}
