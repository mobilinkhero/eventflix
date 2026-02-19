<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a review for a vendor
     * POST /api/v1/reviews
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'is_anonymous' => ['boolean'],
        ]);

        $user = $request->user();

        // Check if user already reviewed this vendor for this booking
        $existing = Review::where('user_id', $user->id)
            ->where('vendor_id', $validated['vendor_id']);

        if (!empty($validated['booking_id'])) {
            $existing->where('booking_id', $validated['booking_id']);

            // Verify booking belongs to user and is completed
            $booking = Booking::where('id', $validated['booking_id'])
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->firstOrFail();
        }

        if ($existing->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this vendor.',
            ], 422);
        }

        $review = Review::create([
            ...$validated,
            'user_id' => $user->id,
            'status' => 'approved', // Auto-approve for now (can change to 'pending' for moderation)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'data' => new ReviewResource($review->load('user')),
        ], 201);
    }

    /**
     * Update a review
     * PUT /api/v1/reviews/{review}
     */
    public function update(Request $request, Review $review): JsonResponse
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Not authorized.'], 403);
        }

        $validated = $request->validate([
            'rating' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $review->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully!',
            'data' => new ReviewResource($review->fresh()->load('user')),
        ]);
    }

    /**
     * Delete a review
     * DELETE /api/v1/reviews/{review}
     */
    public function destroy(Request $request, Review $review): JsonResponse
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Not authorized.'], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully!',
        ]);
    }
}
