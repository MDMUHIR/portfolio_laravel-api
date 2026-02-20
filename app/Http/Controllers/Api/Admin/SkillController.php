<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Skill::orderBy('category')->orderBy('proficiency_level', 'desc');

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $skills = $query->get();

        return response()->json([
            'success' => true,
            'data' => SkillResource::collection($skills),
        ]);
    }

    public function store(SkillRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('skills', 'public');
        }

        $skill = Skill::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Skill created successfully',
            'data' => new SkillResource($skill),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $skill = Skill::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new SkillResource($skill),
        ]);
    }

    public function update(SkillRequest $request, int $id): JsonResponse
    {
        $skill = Skill::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('icon')) {
            if ($skill->icon) {
                Storage::disk('public')->delete($skill->icon);
            }
            $data['icon'] = $request->file('icon')->store('skills', 'public');
        }

        $skill->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Skill updated successfully',
            'data' => new SkillResource($skill),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $skill = Skill::findOrFail($id);

        if ($skill->icon) {
            Storage::disk('public')->delete($skill->icon);
        }

        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully',
        ]);
    }
}
