<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * List user's favorite vendors
     * GET /api/v1/favorites
     */
    public function index(Request $request): JsonResponse
    {
        $favorites = $request->user()
            ->favorites()
            ->active()
            ->with(['city', 'categories'])
            ->latest('favorites.created_at')
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => VendorResource::collection($favorites),
            'meta' => [
                'current_page' => $favorites->currentPage(),
                'last_page' => $favorites->lastPage(),
                'total' => $favorites->total(),
            ],
        ]);
    }

    /**
     * Toggle favorite (add/remove)
     * POST /api/v1/favorites/toggle
     */
    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
        ]);

        $user = $request->user();
        $vendorId = $validated['vendor_id'];

        $exists = $user->favorites()->where('vendor_id', $vendorId)->exists();

        if ($exists) {
            $user->favorites()->detach($vendorId);
            $message = 'Vendor removed from favorites.';
            $isFavorited = false;
        } else {
            $user->favorites()->attach($vendorId);
            $message = 'Vendor added to favorites!';
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => ['is_favorited' => $isFavorited],
        ]);
    }
}
