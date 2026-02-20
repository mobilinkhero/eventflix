@extends('admin.layout')
@section('title', isset($vendor) ? 'Edit: ' . $vendor->name : 'New Vendor')

@section('content')
    <form method="POST"
        action="{{ isset($vendor) ? route('admin.vendors.update', $vendor) : route('admin.vendors.store') }}">
        @csrf
        @if(isset($vendor)) @method('PUT') @endif

        <div style="display:flex;gap:.75rem;align-items:flex-start">
            <div style="flex:1;min-width:0">
                <!-- Basic Info -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">info</span> Basic Information</div>
                    <div class="form-card-b">
                        <div class="fg-row">
                            <div class="fg">
                                <label>Vendor Name *</label>
                                <input type="text" name="name" class="fi" value="{{ old('name', $vendor->name ?? '') }}"
                                    required>
                            </div>
                            <div class="fg">
                                <label>City *</label>
                                <select name="city_id" class="fi" required>
                                    <option value="">Select</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $vendor->city_id ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="fg">
                            <label>Short Description</label>
                            <input type="text" name="short_description" class="fi"
                                value="{{ old('short_description', $vendor->short_description ?? '') }}">
                            <div class="hint">Brief tagline shown in cards (max 255 chars)</div>
                        </div>
                        <div class="fg">
                            <label>Full Description</label>
                            <textarea name="description" class="fi"
                                rows="4">{{ old('description', $vendor->description ?? '') }}</textarea>
                        </div>
                        <div class="fg">
                            <label>Categories</label>
                            <div style="display:flex;flex-wrap:wrap;gap:.3rem;margin-top:.2rem">
                                @php $sel = old('categories', isset($vendor) ? $vendor->categories->pluck('id')->toArray() : []); @endphp
                                @foreach($categories as $cat)
                                    <label class="chip {{ in_array($cat->id, $sel) ? 'on' : '' }}" style="cursor:pointer">
                                        <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, $sel) ? 'checked' : '' }} style="display:none"
                                            onchange="this.parentElement.classList.toggle('on')">
                                        {{ $cat->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">contact_phone</span> Contact</div>
                    <div class="form-card-b">
                        <div class="fg-row-3">
                            <div class="fg">
                                <label>Phone</label>
                                <input type="text" name="phone" class="fi" value="{{ old('phone', $vendor->phone ?? '') }}">
                            </div>
                            <div class="fg">
                                <label>WhatsApp</label>
                                <input type="text" name="whatsapp" class="fi"
                                    value="{{ old('whatsapp', $vendor->whatsapp ?? '') }}">
                            </div>
                            <div class="fg">
                                <label>Email</label>
                                <input type="email" name="email" class="fi"
                                    value="{{ old('email', $vendor->email ?? '') }}">
                            </div>
                        </div>
                        <div class="fg-row">
                            <div class="fg">
                                <label>Website</label>
                                <input type="url" name="website" class="fi"
                                    value="{{ old('website', $vendor->website ?? '') }}" placeholder="https://">
                            </div>
                            <div class="fg">
                                <label>Address</label>
                                <input type="text" name="address" class="fi"
                                    value="{{ old('address', $vendor->address ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">payments</span> Pricing</div>
                    <div class="form-card-b">
                        <div class="fg-row-3">
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
                            <div class="fg">
                                <label>Price Unit</label>
                                <input type="text" name="price_unit" class="fi"
                                    value="{{ old('price_unit', $vendor->price_unit ?? '') }}" placeholder="per event">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">image</span> Media</div>
                    <div class="form-card-b">
                        <div class="fg">
                            <label>Cover Image URL</label>
                            <input type="text" name="image" class="fi" value="{{ old('image', $vendor->image ?? '') }}"
                                placeholder="https://...">
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div style="display:flex;gap:.4rem;margin-top:.25rem">
                    <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">save</span>
                        {{ isset($vendor) ? 'Save Changes' : 'Create Vendor' }}</button>
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-out">Cancel</a>
                    @if(isset($vendor))
                        <div style="flex:1"></div>
                        <a href="{{ route('admin.vendors.destroy', $vendor) }}" class="btn btn-red"
                            onclick="event.preventDefault();if(confirm('Delete?'))document.getElementById('del-form').submit()">
                            <span class="mi material-icons-round">delete_outline</span> Delete
                        </a>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div style="width:240px;flex-shrink:0">
                <!-- Status Card -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">tune</span> Status & Flags</div>
                    <div class="form-card-b">
                        <div class="fg">
                            <label>Status *</label>
                            <select name="status" class="fi" required>
                                <option value="pending" {{ old('status', $vendor->status ?? 'pending') === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="approved" {{ old('status', $vendor->status ?? '') === 'approved' ? 'selected' : '' }}>✅ Approved</option>
                                <option value="rejected" {{ old('status', $vendor->status ?? '') === 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                <option value="suspended" {{ old('status', $vendor->status ?? '') === 'suspended' ? 'selected' : '' }}>🚫 Suspended</option>
                            </select>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:.5rem;margin-top:.5rem">
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <span style="font-size:.72rem;font-weight:500">Active</span>
                                <label class="tog"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $vendor->is_active ?? true) ? 'checked' : '' }}><span class="sl"></span></label>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <span style="font-size:.72rem;font-weight:500">Verified</span>
                                <label class="tog"><input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $vendor->is_verified ?? false) ? 'checked' : '' }}><span class="sl"></span></label>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <span style="font-size:.72rem;font-weight:500">Featured</span>
                                <label class="tog"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $vendor->is_featured ?? false) ? 'checked' : '' }}><span class="sl"></span></label>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($vendor))
                    <!-- Quick Info -->
                    <div class="form-card">
                        <div class="form-card-h"><span class="mi material-icons-round">analytics</span> Stats</div>
                        <div class="form-card-b" style="font-size:.72rem;color:var(--t2)">
                            <div
                                style="display:flex;justify-content:space-between;padding:.25rem 0;border-bottom:1px solid var(--brd2)">
                                <span>ID</span><span class="mono">#{{ $vendor->id }}</span>
                            </div>
                            <div
                                style="display:flex;justify-content:space-between;padding:.25rem 0;border-bottom:1px solid var(--brd2)">
                                <span>Slug</span><span class="mono">{{ Str::limit($vendor->slug, 18) }}</span>
                            </div>
                            <div
                                style="display:flex;justify-content:space-between;padding:.25rem 0;border-bottom:1px solid var(--brd2)">
                                <span>Rating</span><span>★ {{ number_format($vendor->rating, 1) }}
                                    ({{ $vendor->total_reviews }})</span>
                            </div>
                            <div
                                style="display:flex;justify-content:space-between;padding:.25rem 0;border-bottom:1px solid var(--brd2)">
                                <span>Bookings</span><span>{{ $vendor->total_bookings ?? 0 }}</span>
                            </div>
                            <div
                                style="display:flex;justify-content:space-between;padding:.25rem 0;border-bottom:1px solid var(--brd2)">
                                <span>Created</span><span>{{ $vendor->created_at?->format('d M Y') }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;padding:.25rem 0">
                                <span>Updated</span><span>{{ $vendor->updated_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    @if($vendor->services->count())
                        <div class="form-card">
                            <div class="form-card-h"><span class="mi material-icons-round">room_service</span> Services
                                ({{ $vendor->services->count() }})</div>
                            <div class="form-card-b" style="font-size:.7rem">
                                @foreach($vendor->services as $svc)
                                    <div
                                        style="display:flex;justify-content:space-between;padding:.2rem 0;border-bottom:1px solid var(--brd2);color:var(--t2)">
                                        <span>{{ $svc->name }}</span>
                                        <span class="mono">{{ $svc->price ? 'PKR ' . number_format($svc->price) : '—' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </form>

    @if(isset($vendor))
        <form id="del-form" method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}" style="display:none">@csrf
            @method('DELETE')</form>
    @endif
@endsection