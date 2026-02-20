<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Project::query()->published()->latest();

        if ($request->has('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        $projects = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($projects),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'per_page' => $projects->perPage(),
                'total' => $projects->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $project = Project::where('slug', $slug)
            ->published()
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new ProjectResource($project),
        ]);
    }
}
