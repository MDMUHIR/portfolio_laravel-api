<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Experience::query()->orderBy('start_date', 'desc');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $experiences = $query->get();

        return response()->json([
            'success' => true,
            'data' => ExperienceResource::collection($experiences),
        ]);
    }

    public function jobs(): JsonResponse
    {
        $jobs = Experience::jobs()->orderBy('start_date', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => ExperienceResource::collection($jobs),
        ]);
    }

    public function education(): JsonResponse
    {
        $education = Experience::education()->orderBy('start_date', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => ExperienceResource::collection($education),
        ]);
    }
}
