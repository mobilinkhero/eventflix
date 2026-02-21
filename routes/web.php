<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\VendorController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CityController;
use App\Http\Controllers\Web\PageController;

// Serve storage files directly (shared hosting fix - no symlink needed)
Route::get('/uploads/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    $mime = mime_content_type($fullPath);
    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('path', '.*')->name('storage.serve');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Vendors
Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
Route::get('/vendors/{slug}', [VendorController::class, 'show'])->name('vendors.show');

// Cities
Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('/cities/{slug}', [CityController::class, 'show'])->name('cities.show');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// ─── Admin Panel ────────────────────────────────────
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CityController as AdminCityController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// Login (no middleware)
Route::get('/admin/login', [DashboardController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [DashboardController::class, 'authenticate'])->name('admin.authenticate');

// Protected admin routes
Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

    // Vendors
    Route::get('/vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
    Route::get('/vendors/create', [AdminVendorController::class, 'create'])->name('vendors.create');
    Route::post('/vendors', [AdminVendorController::class, 'store'])->name('vendors.store');
    Route::get('/vendors/{vendor}/edit', [AdminVendorController::class, 'edit'])->name('vendors.edit');
    Route::put('/vendors/{vendor}', [AdminVendorController::class, 'update'])->name('vendors.update');
    Route::delete('/vendors/{vendor}', [AdminVendorController::class, 'destroy'])->name('vendors.destroy');

    // Packages / Services
    Route::post('/vendors/{vendor}/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Cities
    Route::get('/cities', [AdminCityController::class, 'index'])->name('cities.index');
    Route::get('/cities/create', [AdminCityController::class, 'create'])->name('cities.create');
    Route::post('/cities', [AdminCityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{city}/edit', [AdminCityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/{city}', [AdminCityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{city}', [AdminCityController::class, 'destroy'])->name('cities.destroy');

    // Users
    Route::resource('users', AdminUserController::class);
});
