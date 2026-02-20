<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function store(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:100',
        ]);

        $vendor->services()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'price_unit' => $validated['price_unit'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Package added successfully');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:100',
        ]);

        $service->update($validated);

        return back()->with('success', 'Package updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Package deleted successfully');
    }
}
