<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Skill::query()->orderBy('proficiency_level', 'desc');

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $skills = $query->get()->groupBy('category');

        return response()->json([
            'success' => true,
            'data' => $skills->map(fn($group) => SkillResource::collection($group)),
        ]);
    }

    public function all(): JsonResponse
    {
        $skills = Skill::orderBy('category')->orderBy('proficiency_level', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => SkillResource::collection($skills),
        ]);
    }
}
