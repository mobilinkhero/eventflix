<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\VendorController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CityController;
use App\Http\Controllers\Web\PageController;

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
