<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Testimonial::latest();

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $testimonials = $query->get();

        return response()->json([
            'success' => true,
            'data' => TestimonialResource::collection($testimonials),
        ]);
    }

    public function store(TestimonialRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $testimonial = Testimonial::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial created successfully',
            'data' => new TestimonialResource($testimonial),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $testimonial = Testimonial::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new TestimonialResource($testimonial),
        ]);
    }

    public function update(TestimonialRequest $request, int $id): JsonResponse
    {
        $testimonial = Testimonial::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) {
                Storage::disk('public')->delete($testimonial->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $testimonial->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial updated successfully',
            'data' => new TestimonialResource($testimonial),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->avatar) {
            Storage::disk('public')->delete($testimonial->avatar);
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully',
        ]);
    }
}
