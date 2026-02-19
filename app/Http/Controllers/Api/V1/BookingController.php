<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * List user's bookings
     * GET /api/v1/bookings
     */
    public function index(Request $request): JsonResponse
    {
        $query = $request->user()->bookings()
            ->with(['vendor.city', 'vendor.categories', 'review']);

        if ($request->filled('status')) {
            $query->forStatus($request->status);
        }

        $bookings = $query->latest()->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => BookingResource::collection($bookings),
            'meta' => [
                'current_page' => $bookings->currentPage(),
                'last_page' => $bookings->lastPage(),
                'total' => $bookings->total(),
            ],
        ]);
    }

    /**
     * Create a new booking/inquiry
     * POST /api/v1/bookings
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'event_type' => ['required', 'string', 'max:100'],
            'event_date' => ['required', 'date', 'after:today'],
            'event_time' => ['nullable', 'date_format:H:i'],
            'guest_count' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'requirements' => ['nullable', 'string', 'max:2000'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'contact_email' => ['nullable', 'email', 'max:255'],
        ]);

        // Verify vendor is active
        $vendor = Vendor::active()->findOrFail($validated['vendor_id']);

        $booking = Booking::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        // Increment vendor booking count
        $vendor->increment('total_bookings');

        return response()->json([
            'success' => true,
            'message' => 'Booking request submitted successfully! The vendor will contact you soon.',
            'data' => new BookingResource($booking->load(['vendor.city', 'vendor.categories'])),
        ], 201);
    }

    /**
     * Get single booking
     * GET /api/v1/bookings/{booking}
     */
    public function show(Request $request, Booking $booking): JsonResponse
    {
        // Ensure user owns this booking
        if ($booking->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new BookingResource($booking->load(['vendor.city', 'vendor.categories', 'review'])),
        ]);
    }

    /**
     * Cancel booking
     * PUT /api/v1/bookings/{booking}/cancel
     */
    public function cancel(Request $request, Booking $booking): JsonResponse
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Booking not found.'], 404);
        }

        if (!$booking->canBeCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'This booking cannot be cancelled in its current status.',
            ], 422);
        }

        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $validated['reason'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled successfully.',
            'data' => new BookingResource($booking->fresh()->load('vendor')),
        ]);
    }
}
