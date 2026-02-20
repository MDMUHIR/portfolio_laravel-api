<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceRequest;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Experience::orderBy('start_date', 'desc');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $experiences = $query->get();

        return response()->json([
            'success' => true,
            'data' => ExperienceResource::collection($experiences),
        ]);
    }

    public function store(ExperienceRequest $request): JsonResponse
    {
        $experience = Experience::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Experience created successfully',
            'data' => new ExperienceResource($experience),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $experience = Experience::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new ExperienceResource($experience),
        ]);
    }

    public function update(ExperienceRequest $request, int $id): JsonResponse
    {
        $experience = Experience::findOrFail($id);
        $experience->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Experience updated successfully',
            'data' => new ExperienceResource($experience),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return response()->json([
            'success' => true,
            'message' => 'Experience deleted successfully',
        ]);
    }
}
