@extends('admin.layout')
@section('title', isset($vendor) ? 'Edit: ' . $vendor->name : 'New Vendor')

@section('content')
    <form method="POST"
        action="{{ isset($vendor) ? route('admin.vendors.update', $vendor) : route('admin.vendors.store') }}"
        enctype="multipart/form-data">
        @csrf
        @if(isset($vendor)) @method('PUT') @endif

        <div style="display:flex;gap:.75rem;align-items:flex-start">
            <div style="flex:1;min-width:0">
                <!-- Cover Photo Section -->
                <div class="form-card cover-card">
                    <div class="cover-uploader {{ isset($vendor) && $vendor->cover_image ? 'has-image' : '' }}" id="coverUploader" onclick="document.getElementById('coverInput').click()">
                        @if(isset($vendor) && $vendor->cover_image)
                            <img src="{{ Str::startsWith($vendor->cover_image, 'http') ? $vendor->cover_image : url('uploads/' . $vendor->cover_image) }}" id="coverPreview">
                        @else
                            <img src="" id="coverPreview" style="display:none">
                        @endif
                        <div class="cover-placeholder">
                            <span class="mi material-icons-round">add_a_photo</span>
                            <span>Click to upload Cover Photo</span>
                        </div>
                        <input type="file" name="cover_file" id="coverInput" accept="image/*" style="display:none" onchange="previewFile(this, 'coverPreview', 'coverUploader')">
                    </div>

                    <div class="profile-uploader-wrapper">
                        <div class="profile-uploader {{ isset($vendor) && $vendor->image ? 'has-image' : '' }}" id="profileUploader" onclick="document.getElementById('profileInput').click()">
                            @if(isset($vendor) && $vendor->image)
                                <img src="{{ Str::startsWith($vendor->image, 'http') ? $vendor->image : url('uploads/' . $vendor->image) }}" id="profilePreview">
                            @else
                                <img src="" id="profilePreview" style="display:none">
                            @endif
                            <div class="profile-placeholder">
                                <span class="mi material-icons-round">photo_camera</span>
                            </div>
                            <input type="file" name="image_file" id="profileInput" accept="image/*" style="display:none" onchange="previewFile(this, 'profilePreview', 'profileUploader')">
                        </div>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="form-card">
                    <div class="form-card-h" style="display:flex;justify-content:space-between;align-items:center">
                        <div><span class="mi material-icons-round">info</span> Professional Details</div>
                        @if(isset($vendor) && $vendor->is_verified)
                            <span class="b b-pri" style="font-size:.6rem;text-transform:uppercase;letter-spacing:1px"><span class="mi material-icons-round" style="font-size:.7rem">verified</span> Authentic</span>
                        @endif
                    </div>
                    <div class="form-card-b">
                        <div class="fg-row">
                            <div class="fg">
                                <label>Business Name *</label>
                                <input type="text" name="name" class="fi" value="{{ old('name', $vendor->name ?? '') }}"
                                    required placeholder="e.g. Royal Photography">
                            </div>
                            <div class="fg">
                                <label>City *</label>
                                <select name="city_id" class="fi" required>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $vendor->city_id ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="fg">
                            <label>Short Tagline</label>
                            <input type="text" name="short_description" class="fi"
                                value="{{ old('short_description', $vendor->short_description ?? '') }}" placeholder="Capture your best moments professionally">
                            <div class="hint">Brief tagline shown in search results</div>
                        </div>
                        <div class="fg">
                            <label>Professional Bio</label>
                            <textarea name="description" class="fi"
                                rows="5" placeholder="Describe your services, experience, and style...">{{ old('description', $vendor->description ?? '') }}</textarea>
                        </div>
                        <div class="fg">
                            <label>Services & Specialties</label>
                            <div style="display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.4rem">
                                @php $sel = old('categories', isset($vendor) ? $vendor->categories->pluck('id')->toArray() : []); @endphp
                                @foreach($categories as $cat)
                                    <label class="chip {{ in_array($cat->id, $sel) ? 'on' : '' }}" style="cursor:pointer;padding:.4rem .8rem;font-size:.75rem">
                                        <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, $sel) ? 'checked' : '' }} style="display:none"
                                            onchange="this.parentElement.classList.toggle('on')">
                                        {{ $cat->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Packages / Pricing Section -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">inventory_2</span> Service Packages</div>
                    <div class="form-card-b">
                        <div class="fg-row-3">
                            <div class="fg">
                                <label>Starting Price (PKR)</label>
                                <input type="number" name="price_min" class="fi"
                                    value="{{ old('price_min', isset($vendor) ? (float) $vendor->price_min : '') }}" min="0" step="1" placeholder="5000">
                            </div>
                            <div class="fg">
                                <label>Premium Price (Up to)</label>
                                <input type="number" name="price_max" class="fi"
                                    value="{{ old('price_max', isset($vendor) ? (float) $vendor->price_max : '') }}" min="0" step="1" placeholder="50000">
                            </div>
                            <div class="fg">
                                <label>Pricing Type</label>
                                <input type="text" name="price_unit" class="fi"
                                    value="{{ old('price_unit', $vendor->price_unit ?? '') }}" placeholder="e.g. per event, per day">
                            </div>
                        </div>

                        @if(isset($vendor))
                            <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--brd2)">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem">
                                    <span style="font-weight:600;font-size:.85rem">Detailed Packages</span>
                                    <a href="#" class="btn btn-out btn-xs"><span class="mi material-icons-round">add</span> Add Package</a>
                                </div>
                                @if($vendor->services->count())
                                    <div class="package-list">
                                        @foreach($vendor->services as $svc)
                                            <div class="package-item">
                                                <div class="package-info">
                                                    <span class="package-name">{{ $svc->name }}</span>
                                                    <span class="package-price">{{ $svc->price ? 'PKR ' . number_format((float) $svc->price) : 'Contact' }}</span>
                                                </div>
                                                <div class="act-group">
                                                    <button type="button" class="btn btn-ghost btn-xs"><span class="mi material-icons-round">edit</span></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-mini">No packages defined yet.</div>
                                @endif
                            </div>
                        @else
                            <div class="hint" style="margin-top:.5rem">You can add detailed packages after creating the vendor profile.</div>
                        @endif
                    </div>
                </div>

                <!-- Contact -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">contact_phone</span> Business Contact</div>
                    <div class="form-card-b">
                        <div class="fg-row-3">
                            <div class="fg">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="fi" value="{{ old('phone', $vendor->phone ?? '') }}" placeholder="+92 ...">
                            </div>
                            <div class="fg">
                                <label>WhatsApp</label>
                                <input type="text" name="whatsapp" class="fi"
                                    value="{{ old('whatsapp', $vendor->whatsapp ?? '') }}" placeholder="+92 ...">
                            </div>
                            <div class="fg">
                                <label>Email Address</label>
                                <input type="email" name="email" class="fi"
                                    value="{{ old('email', $vendor->email ?? '') }}" placeholder="business@example.com">
                            </div>
                        </div>
                        <div class="fg-row">
                            <div class="fg" style="flex:1">
                                <label>Official Website</label>
                                <input type="url" name="website" class="fi"
                                    value="{{ old('website', $vendor->website ?? '') }}" placeholder="https://www.yoursite.com">
                            </div>
                            <div class="fg" style="flex:2">
                                <label>Physical Studio / Office Address</label>
                                <input type="text" name="address" class="fi"
                                    value="{{ old('address', $vendor->address ?? '') }}" placeholder="Shop #12, Phase 3, ...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div style="display:flex;gap:.5rem;margin-top:1.5rem">
                    <button type="submit" class="btn btn-pri" style="padding:.75rem 2rem">
                        <span class="mi material-icons-round">{{ isset($vendor) ? 'check_circle' : 'save' }}</span>
                        {{ isset($vendor) ? 'Update Professional Profile' : 'Launch Vendor Profile' }}
                    </button>
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-out" style="padding:.75rem 1.5rem">Cancel</a>
                </div>
            </div>

            <!-- Sidebar -->
            <div style="width:280px;flex-shrink:0">
                <!-- Status & Verification -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">verified_user</span> Verification</div>
                    <div class="form-card-b">
                        <div class="fg">
                            <label>Account Status</label>
                            <select name="status" class="fi" required>
                                <option value="approved" {{ old('status', $vendor->status ?? '') === 'approved' ? 'selected' : '' }}>✅ Active / Published</option>
                                <option value="rejected" {{ old('status', $vendor->status ?? '') === 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                <option value="suspended" {{ old('status', $vendor->status ?? '') === 'suspended' ? 'selected' : '' }}>🚫 Suspended</option>
                            </select>
                            <div class="hint">"Pending" status has been removed as per professional standards.</div>
                        </div>

                        <div class="verify-box {{ old('is_verified', $vendor->is_verified ?? false) ? 'verified' : '' }}">
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <div style="display:flex;align-items:center;gap:.5rem">
                                    <span class="mi material-icons-round" style="color:var(--pri)">verified</span>
                                    <span style="font-weight:600;font-size:.75rem">Authentic Badge</span>
                                </div>
                                <label class="tog"><input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $vendor->is_verified ?? false) ? 'checked' : '' }} onchange="this.closest('.verify-box').classList.toggle('verified', this.checked)"><span class="sl"></span></label>
                            </div>
                            <p style="font-size:.65rem;color:var(--t3);margin-top:.4rem;line-height:1.4">
                                Enabling this marks the vendor as "Verified Authentic". Use only after manual check of their portfolio.
                            </p>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:.75rem;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--brd2)">
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <span style="font-size:.75rem;font-weight:500">Publicly Visible</span>
                                <label class="tog"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $vendor->is_active ?? true) ? 'checked' : '' }}><span class="sl"></span></label>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <span style="font-size:.75rem;font-weight:500">Featured Placement</span>
                                <label class="tog"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $vendor->is_featured ?? false) ? 'checked' : '' }}><span class="sl"></span></label>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($vendor))
                    <!-- Gallery Preview -->
                    <div class="form-card">
                        <div class="form-card-h"><span class="mi material-icons-round">collections</span> Portfolio</div>
                        <div class="form-card-b">
                            <div class="gallery-mini-grid">
                                @if($vendor->gallery && count($vendor->gallery))
                                    @foreach(array_slice($vendor->gallery, 0, 4) as $img)
                                        <div class="gallery-mini-item"><img src="{{ Str::startsWith($img, 'http') ? $img : url('uploads/' . $img) }}"></div>
                                    @endforeach
                                @else
                                    <div class="empty-mini" style="grid-column: span 2">No gallery images yet.</div>
                                @endif
                            </div>
                            <a href="#" class="btn btn-ghost btn-block btn-xs" style="margin-top:.5rem">Manage Portfolio</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <style>
        .cover-card { padding: 0 !important; overflow: hidden; border: none; background: #f8f9fa; }
        .cover-uploader {
            height: 220px;
            width: 100%;
            position: relative;
            cursor: pointer;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: all .2s;
        }
        .cover-uploader:hover { opacity: 0.9; }
        .cover-uploader img { width: 100%; height: 100%; object-fit: cover; }
        .cover-placeholder {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .5rem;
            color: #adb5bd;
            z-index: 1;
        }
        .cover-uploader.has-image .cover-placeholder {
            background: rgba(0,0,0,0.4);
            color: white;
            padding: .75rem 1.5rem;
            border-radius: 30px;
            font-size: .75rem;
            opacity: 0;
            transition: opacity .2s;
        }
        .cover-uploader.has-image:hover .cover-placeholder { opacity: 1; }

        .profile-uploader-wrapper {
            margin-top: -60px;
            margin-left: 30px;
            padding-bottom: 20px;
            position: relative;
            z-index: 2;
        }
        .profile-uploader {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid white;
            background: #f1f3f5;
            cursor: pointer;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative;
        }
        .profile-uploader img { width: 100%; height: 100%; object-fit: cover; }
        .profile-placeholder { color: #adb5bd; }
        .profile-uploader.has-image .profile-placeholder {
            position: absolute;
            background: rgba(0,0,0,0.4);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transition: opacity .2s;
        }
        .profile-uploader.has-image:hover .profile-placeholder { opacity: 1; }

        .package-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .75rem;
            background: #fff;
            border: 1px solid var(--brd2);
            border-radius: 8px;
            margin-bottom: .4rem;
        }
        .package-name { font-weight: 600; font-size: .8rem; color: var(--t1); }
        .package-price { font-size: .75rem; color: var(--pri); font-weight: 700; }
        .empty-mini { padding: 1.5rem; text-align: center; color: var(--t4); font-size: .75rem; background: #fff; border: 1px dashed var(--brd2); border-radius: 8px; }

        .verify-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: .75rem;
            border: 1px solid var(--brd2);
            transition: all .3s;
        }
        .verify-box.verified {
            background: var(--pri-light);
            border-color: var(--pri);
        }

        .gallery-mini-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: .4rem;
        }
        .gallery-mini-item {
            aspect-ratio: 1;
            border-radius: 6px;
            overflow: hidden;
            background: #eee;
        }
        .gallery-mini-item img { width: 100%; height: 100%; object-fit: cover; }
    </style>

    <script>
        function previewFile(input, previewId, uploaderId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const uploader = document.getElementById(uploaderId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    uploader.classList.add('has-image');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection