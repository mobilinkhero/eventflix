@extends('admin.layout')
@section('title', isset($vendor) ? 'Edit Vendor' : 'Add Vendor')

@section('content')
    <div style="display:flex;gap:1.5rem;align-items:flex-start">
        <!-- Main Form -->
        <div style="flex:1">
            <form method="POST"
                action="{{ isset($vendor) ? route('admin.vendors.update', $vendor) : route('admin.vendors.store') }}">
                @csrf
                @if(isset($vendor)) @method('PUT') @endif

                <div class="form-card">
                    <h2>Basic Information</h2>
                    <div class="fg">
                        <label>Vendor Name *</label>
                        <input type="text" name="name" class="fi" value="{{ old('name', $vendor->name ?? '') }}" required>
                    </div>
                    <div class="fg-row">
                        <div class="fg">
                            <label>City *</label>
                            <select name="city_id" class="fi" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $vendor->city_id ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fg">
                            <label>Status *</label>
                            <select name="status" class="fi" required>
                                <option value="pending" {{ old('status', $vendor->status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $vendor->status ?? '') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $vendor->status ?? '') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="suspended" {{ old('status', $vendor->status ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                    </div>
                    <div class="fg">
                        <label>Short Description</label>
                        <input type="text" name="short_description" class="fi"
                            value="{{ old('short_description', $vendor->short_description ?? '') }}" maxlength="255">
                    </div>
                    <div class="fg">
                        <label>Full Description</label>
                        <textarea name="description"
                            class="fi">{{ old('description', $vendor->description ?? '') }}</textarea>
                    </div>
                    <div class="fg">
                        <label>Categories</label>
                        <div style="display:flex;flex-wrap:wrap;gap:.5rem;padding:.5rem 0">
                            @php $selectedCats = old('categories', isset($vendor) ? $vendor->categories->pluck('id')->toArray() : []); @endphp
                            @foreach($categories as $cat)
                                <label
                                    style="display:flex;align-items:center;gap:.3rem;font-size:.82rem;padding:.35rem .7rem;border:1px solid var(--brd);border-radius:6px;cursor:pointer;{{ in_array($cat->id, $selectedCats) ? 'background:var(--pri-l);border-color:var(--pri)' : '' }}">
                                    <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'checked' : '' }} style="accent-color:var(--pri-d)">
                                    {{ $cat->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <h2>Contact Information</h2>
                    <div class="fg-row">
                        <div class="fg">
                            <label>Phone</label>
                            <input type="text" name="phone" class="fi" value="{{ old('phone', $vendor->phone ?? '') }}">
                        </div>
                        <div class="fg">
                            <label>WhatsApp</label>
                            <input type="text" name="whatsapp" class="fi"
                                value="{{ old('whatsapp', $vendor->whatsapp ?? '') }}">
                        </div>
                    </div>
                    <div class="fg-row">
                        <div class="fg">
                            <label>Email</label>
                            <input type="email" name="email" class="fi" value="{{ old('email', $vendor->email ?? '') }}">
                        </div>
                        <div class="fg">
                            <label>Website</label>
                            <input type="url" name="website" class="fi" value="{{ old('website', $vendor->website ?? '') }}"
                                placeholder="https://">
                        </div>
                    </div>
                    <div class="fg">
                        <label>Address</label>
                        <input type="text" name="address" class="fi" value="{{ old('address', $vendor->address ?? '') }}">
                    </div>
                </div>

                <div class="form-card">
                    <h2>Pricing</h2>
                    <div class="fg-row">
                        <div class="fg">
                            <label>Min Price (PKR)</label>
                            <input type="number" name="price_min" class="fi"
                                value="{{ old('price_min', $vendor->price_min ?? '') }}" min="0" step="0.01">
                        </div>
                        <div class="fg">
                            <label>Max Price (PKR)</label>
                            <input type="number" name="price_max" class="fi"
                                value="{{ old('price_max', $vendor->price_max ?? '') }}" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="fg">
                        <label>Price Unit</label>
                        <input type="text" name="price_unit" class="fi"
                            value="{{ old('price_unit', $vendor->price_unit ?? '') }}"
                            placeholder="e.g. per event, per hour">
                    </div>
                </div>

                <div class="form-card">
                    <h2>Media & Flags</h2>
                    <div class="fg">
                        <label>Image URL</label>
                        <input type="text" name="image" class="fi" value="{{ old('image', $vendor->image ?? '') }}"
                            placeholder="https://...">
                    </div>
                    <div style="display:flex;gap:1.5rem;margin-top:.75rem">
                        <div class="fg-check">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $vendor->is_active ?? true) ? 'checked' : '' }}>
                            <label for="is_active">Active</label>
                        </div>
                        <div class="fg-check">
                            <input type="checkbox" id="is_verified" name="is_verified" value="1" {{ old('is_verified', $vendor->is_verified ?? false) ? 'checked' : '' }}>
                            <label for="is_verified">Verified</label>
                        </div>
                        <div class="fg-check">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $vendor->is_featured ?? false) ? 'checked' : '' }}>
                            <label for="is_featured">Featured</label>
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:.75rem">
                    <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">save</span>
                        {{ isset($vendor) ? 'Update Vendor' : 'Create Vendor' }}</button>
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-out">Cancel</a>
                </div>
            </form>
        </div>

        <!-- Sidebar Preview -->
        @if(isset($vendor))
            <div style="width:280px;flex-shrink:0">
                <div class="form-card" style="position:sticky;top:80px">
                    <h2>Quick Info</h2>
                    <div style="font-size:.82rem;color:var(--t2);line-height:1.8">
                        <div><strong>ID:</strong> {{ $vendor->id }}</div>
                        <div><strong>Slug:</strong> {{ $vendor->slug }}</div>
                        <div><strong>Rating:</strong> ★ {{ number_format($vendor->rating, 1) }} ({{ $vendor->total_reviews }}
                            reviews)</div>
                        <div><strong>Bookings:</strong> {{ $vendor->total_bookings }}</div>
                        <div><strong>Created:</strong> {{ $vendor->created_at?->format('d M Y') }}</div>
                        <div><strong>Updated:</strong> {{ $vendor->updated_at?->diffForHumans() }}</div>
                    </div>
                    @if($vendor->services->count())
                        <h2 style="margin-top:1.25rem">Services ({{ $vendor->services->count() }})</h2>
                        <div style="font-size:.8rem;color:var(--t2)">
                            @foreach($vendor->services as $service)
                                <div style="padding:.4rem 0;border-bottom:1px solid var(--brd)">
                                    {{ $service->name }}
                                    @if($service->price) — PKR {{ number_format($service->price) }} @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection