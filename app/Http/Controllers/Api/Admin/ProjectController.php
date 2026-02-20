<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Project::with('tags')->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->paginate($request->get('per_page', 15));

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

    public function store(ProjectRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('projects', 'public');
        }

        $project = Project::create($data);

        if ($request->has('tags')) {
            $project->tags()->sync($request->tags);
        }

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
            'data' => new ProjectResource($project),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $project = Project::with('tags')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new ProjectResource($project),
        ]);
    }

    public function update(ProjectRequest $request, int $id): JsonResponse
    {
        $project = Project::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($project->featured_image) {
                Storage::disk('public')->delete($project->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')
                ->store('projects', 'public');
        }

        $project->update($data);

        if ($request->has('tags')) {
            $project->tags()->sync($request->tags);
        }

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => new ProjectResource($project),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        if ($project->featured_image) {
            Storage::disk('public')->delete($project->featured_image);
        }

        $project->tags()->detach();
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully',
        ]);
    }
}
