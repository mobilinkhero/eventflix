<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\City;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function login()
    {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $adminPassword = env('ADMIN_PASSWORD', 'admin@eventswally2024');

        if ($request->password === $adminPassword) {
            session(['admin_authenticated' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Invalid password']);
    }

    public function logout()
    {
        session()->forget('admin_authenticated');
        return redirect()->route('admin.login');
    }

    public function index()
    {
        $stats = [
            'vendors' => Vendor::count(),
            'active_vendors' => Vendor::where('is_active', true)->count(),
            'categories' => Category::count(),
            'cities' => City::count(),
            'bookings' => Booking::count(),
            'reviews' => Review::count(),
            'users' => User::count(),
            'featured_vendors' => Vendor::where('is_featured', true)->count(),
        ];

        $recentVendors = Vendor::with('city')->latest()->take(5)->get();
        $recentBookings = Booking::with(['vendor', 'user'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentVendors', 'recentBookings'));
    }
}
