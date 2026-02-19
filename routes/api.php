<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\FavoriteController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| EventsWally API Routes — v1
|--------------------------------------------------------------------------
|
| All routes are prefixed with /api/v1/
| Public routes = no auth required
| Protected routes = Bearer token required (Sanctum)
|
*/

Route::prefix('v1')->group(function () {

    // ─────────────────────────────────────────────────
    // PUBLIC ROUTES (No authentication required)
    // ─────────────────────────────────────────────────

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    // Home (aggregated data for app home screen)
    Route::get('home', [HomeController::class, 'index']);

    // Search
    Route::get('search', [HomeController::class, 'search']);

    // Cities
    Route::get('cities', [CityController::class, 'index']);
    Route::get('cities/{city}', [CityController::class, 'show']);

    // Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    // Vendors
    Route::get('vendors', [VendorController::class, 'index']);
    Route::get('vendors/featured', [VendorController::class, 'featured']);
    Route::get('vendors/popular', [VendorController::class, 'popular']);
    Route::get('vendors/{vendor}', [VendorController::class, 'show']);
    Route::get('vendors/{vendor}/reviews', [VendorController::class, 'reviews']);

    // ─────────────────────────────────────────────────
    // PROTECTED ROUTES (Authentication required)
    // ─────────────────────────────────────────────────

    Route::middleware('auth:sanctum')->group(function () {

        // Auth (authenticated)
        Route::prefix('auth')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
            Route::put('profile', [AuthController::class, 'updateProfile']);
            Route::put('password', [AuthController::class, 'changePassword']);
        });

        // Bookings
        Route::get('bookings', [BookingController::class, 'index']);
        Route::post('bookings', [BookingController::class, 'store']);
        Route::get('bookings/{booking}', [BookingController::class, 'show']);
        Route::put('bookings/{booking}/cancel', [BookingController::class, 'cancel']);

        // Reviews
        Route::post('reviews', [ReviewController::class, 'store']);
        Route::put('reviews/{review}', [ReviewController::class, 'update']);
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);

        // Favorites
        Route::get('favorites', [FavoriteController::class, 'index']);
        Route::post('favorites/toggle', [FavoriteController::class, 'toggle']);
    });
});
