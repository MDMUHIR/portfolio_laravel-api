<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ContactMessage::latest();

        if ($request->has('is_read')) {
            $query->where('is_read', $request->boolean('is_read'));
        }

        $messages = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => ContactMessageResource::collection($messages),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $message = ContactMessage::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new ContactMessageResource($message),
        ]);
    }

    public function markAsRead(int $id): JsonResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read',
        ]);
    }

    public function markAsUnread(int $id): JsonResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsUnread();

        return response()->json([
            'success' => true,
            'message' => 'Message marked as unread',
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully',
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total' => ContactMessage::count(),
                'unread' => ContactMessage::unread()->count(),
                'read' => ContactMessage::read()->count(),
            ],
        ]);
    }
}
