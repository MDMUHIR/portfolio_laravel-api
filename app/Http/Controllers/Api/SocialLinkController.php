<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialLinkResource;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;

class SocialLinkController extends Controller
{
    public function index(): JsonResponse
    {
        $links = SocialLink::active()->get();

        return response()->json([
            'success' => true,
            'data' => SocialLinkResource::collection($links),
        ]);
    }
}
