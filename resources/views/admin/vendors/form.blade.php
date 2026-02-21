@extends('admin.layout')
@section('title', isset($vendor) ? 'Edit: ' . $vendor->name : 'New Vendor')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 350px; border-radius: 12px; margin-top: 10px; border: 1px solid var(--brd2); z-index: 1; }
        .map-search-container { position: relative; margin-bottom: 10px; }
        .coord-pill { 
            position: absolute; bottom: 10px; left: 10px; z-index: 1000;
            background: rgba(255,255,255,0.9); padding: 5px 12px; border-radius: 20px;
            font-size: 0.75rem; font-weight: 600; color: var(--pri);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
@endsection

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
                    <div class="cover-uploader {{ isset($vendor) && $vendor->cover_image ? 'has-image' : '' }}"
                        id="coverUploader" onclick="document.getElementById('coverInput').click()">
                        @if(isset($vendor) && $vendor->cover_image)
                            <img src="{{ Str::startsWith($vendor->cover_image, 'http') ? $vendor->cover_image : url('uploads/' . $vendor->cover_image) }}"
                                id="coverPreview">
                        @else
                            <img src="" id="coverPreview" style="display:none">
                        @endif
                        <div class="cover-placeholder">
                            <span class="mi material-icons-round">add_a_photo</span>
                            <span>Click to upload Cover Photo</span>
                        </div>
                        <input type="file" name="cover_file" id="coverInput" accept="image/*" style="display:none"
                            onchange="previewFile(this, 'coverPreview', 'coverUploader')">
                    </div>

                    <div class="profile-uploader-wrapper">
                        <div class="profile-uploader {{ isset($vendor) && $vendor->image ? 'has-image' : '' }}"
                            id="profileUploader" onclick="document.getElementById('profileInput').click()">
                            @if(isset($vendor) && $vendor->image)
                                <img src="{{ Str::startsWith($vendor->image, 'http') ? $vendor->image : url('uploads/' . $vendor->image) }}"
                                    id="profilePreview">
                            @else
                                <img src="" id="profilePreview" style="display:none">
                            @endif
                            <div class="profile-placeholder">
                                <span class="mi material-icons-round">photo_camera</span>
                            </div>
                            <input type="file" name="image_file" id="profileInput" accept="image/*" style="display:none"
                                onchange="previewFile(this, 'profilePreview', 'profileUploader')">
                        </div>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="form-card">
                    <div class="form-card-h" style="display:flex;justify-content:space-between;align-items:center">
                        <div><span class="mi material-icons-round">info</span> Professional Details</div>
                        @if(isset($vendor) && $vendor->is_verified)
                            <span class="b b-pri" style="font-size:.6rem;text-transform:uppercase;letter-spacing:1px"><span
                                    class="mi material-icons-round" style="font-size:.7rem">verified</span> Authentic</span>
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
                                value="{{ old('short_description', $vendor->short_description ?? '') }}"
                                placeholder="Capture your best moments professionally">
                            <div class="hint">Brief tagline shown in search results</div>
                        </div>
                        <div class="fg">
                            <label>Professional Bio</label>
                            <textarea name="description" class="fi" rows="5"
                                placeholder="Describe your services, experience, and style...">{{ old('description', $vendor->description ?? '') }}</textarea>
                        </div>
                        <div class="fg">
                            <label>Services & Specialties</label>
                            <div style="display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.4rem">
                                @php $sel = old('categories', isset($vendor) ? $vendor->categories->pluck('id')->toArray() : []); @endphp
                                @foreach($categories as $cat)
                                    <label class="chip {{ in_array($cat->id, $sel) ? 'on' : '' }}"
                                        style="cursor:pointer;padding:.4rem .8rem;font-size:.75rem">
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
                                    value="{{ old('price_min', isset($vendor) ? (float) $vendor->price_min : '') }}" min="0"
                                    step="1" placeholder="5000">
                            </div>
                            <div class="fg">
                                <label>Premium Price (Up to)</label>
                                <input type="number" name="price_max" class="fi"
                                    value="{{ old('price_max', isset($vendor) ? (float) $vendor->price_max : '') }}" min="0"
                                    step="1" placeholder="50000">
                            </div>
                            <div class="fg">
                                <label>Pricing Type</label>
                                <input type="text" name="price_unit" class="fi"
                                    value="{{ old('price_unit', $vendor->price_unit ?? '') }}"
                                    placeholder="e.g. per event, per day">
                            </div>
                        </div>

                        @if(isset($vendor))
                            <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--brd2)">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem">
                                    <span style="font-weight:600;font-size:.85rem">Detailed Packages</span>
                                    <button type="button" class="btn btn-out btn-xs" onclick="openPackageModal()">
                                        <span class="mi material-icons-round">add</span> Add Package
                                    </button>
                                </div>
                                @if($vendor->services->count())
                                    <div class="package-list">
                                        @foreach($vendor->services as $svc)
                                            <div class="package-item">
                                                <div class="package-info" style="flex:1">
                                                    <div style="display:flex;justify-content:space-between">
                                                        <span class="package-name">{{ $svc->name }}</span>
                                                        <span
                                                            class="package-price">{{ $svc->price ? 'PKR ' . number_format((float) $svc->price) : 'Contact' }}</span>
                                                    </div>
                                                    @if($svc->description)
                                                        <p style="font-size:.65rem;color:var(--t3);margin:.2rem 0 0 0">
                                                            {{ Str::limit($svc->description, 80) }}</p>
                                                    @endif
                                                </div>
                                                <div class="act-group" style="margin-left:1rem;display:flex;gap:.3rem">
                                                    <button type="button" class="btn btn-ghost btn-xs"
                                                        onclick="openPackageModal({{ json_encode($svc) }})">
                                                        <span class="mi material-icons-round">edit</span>
                                                    </button>
                                                    <button type="button" class="btn btn-ghost btn-xs text-red"
                                                        onclick="deletePackage({{ $svc->id }})">
                                                        <span class="mi material-icons-round">delete</span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-mini">No packages defined yet.</div>
                                @endif
                            </div>
                        @else
                            <div class="hint" style="margin-top:.5rem">You can add detailed packages after creating the vendor
                                profile.</div>
                        @endif
                    </div>
                </div>

                <!-- Professional Portfolio -->
                <div class="form-card">
                    <div class="form-card-h" style="display:flex;justify-content:space-between;align-items:center">
                        <div><span class="mi material-icons-round">collections</span> Professional Portfolio</div>
                        <label class="btn btn-out btn-xs" style="cursor:pointer">
                            <span class="mi material-icons-round">add_photo_alternate</span> Add Photos
                            <input type="file" name="gallery_files[]" id="galleryInput" multiple accept="image/*" style="display:none" 
                                onchange="handleGallerySelect(this)">
                        </label>
                    </div>
                    <div class="form-card-b">
                        <div id="galleryGrid" class="gallery-manager-grid">
                            @if(isset($vendor) && $vendor->gallery)
                                @foreach($vendor->gallery as $img)
                                    <div class="gallery-mgr-item">
                                        <img src="{{ Str::startsWith($img, 'http') ? $img : url('uploads/' . $img) }}">
                                        <label class="mgr-del">
                                            <input type="checkbox" name="remove_gallery_images[]" value="{{ $img }}"
                                                onchange="this.closest('.gallery-mgr-item').classList.toggle('to-delete', this.checked)">
                                            <span class="mi material-icons-round">delete</span>
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                            <div class="gallery-upload-placeholder" onclick="document.getElementById('galleryInput').click()">
                                <span class="mi material-icons-round">cloud_upload</span>
                                <span>Drop or Click to add more</span>
                            </div>
                        </div>
                        <div id="newPhotosCount" style="display:none;margin-top:1rem;font-size:0.7rem;color:var(--pri);font-weight:600"></div>
                        <div class="hint" style="margin-top:1rem">Recommended: High-quality 4K photos (max 4MB per image). These will appear in the app's header gallery.</div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">contact_phone</span> Business Contact
                    </div>
                    <div class="form-card-b">
                        <div class="fg-row-3">
                            <div class="fg">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="fi" value="{{ old('phone', $vendor->phone ?? '') }}"
                                    placeholder="+92 ...">
                            </div>
                            <div class="fg">
                                <label>WhatsApp</label>
                                <input type="text" name="whatsapp" class="fi"
                                    value="{{ old('whatsapp', $vendor->whatsapp ?? '') }}" placeholder="+92 ...">
                            </div>
                            <div class="fg">
                                <label>Email Address</label>
                                <input type="email" name="email" class="fi" value="{{ old('email', $vendor->email ?? '') }}"
                                    placeholder="business@example.com">
                            </div>
                        </div>
                        <div class="fg-row">
                            <div class="fg" style="flex:1">
                                <label>Official Website</label>
                                <input type="url" name="website" class="fi"
                                    value="{{ old('website', $vendor->website ?? '') }}"
                                    placeholder="https://www.yoursite.com">
                            </div>
                            <div class="fg" style="flex:2">
                                <label>Physical Studio / Office Address</label>
                                <input type="text" name="address" class="fi"
                                    value="{{ old('address', $vendor->address ?? '') }}"
                                    placeholder="Shop #12, Phase 3, ...">
                            </div>
                        </div>

                        <!-- Live Map -->
                        <div class="fg" style="margin-top:1.5rem">
                            <label style="display:flex;justify-content:space-between;align-items:center">
                                <span><span class="mi material-icons-round" style="font-size:1rem;vertical-align:middle">location_on</span> Pin Location on Map</span>
                                <span style="font-size:0.7rem;font-weight:400;color:var(--t4)">Click on map to update coordinates</span>
                            </label>
                            
                            <input type="hidden" name="latitude" id="latInput" value="{{ old('latitude', $vendor->latitude ?? '24.8607') }}">
                            <input type="hidden" name="longitude" id="lngInput" value="{{ old('longitude', $vendor->longitude ?? '67.0011') }}">
                            
                            <div style="position:relative">
                                <div id="map"></div>
                                <div class="coord-pill">
                                    <span id="coordDisplay">
                                        {{ old('latitude', $vendor->latitude ?? '24.8607') }}, {{ old('longitude', $vendor->longitude ?? '67.0011') }}
                                    </span>
                                </div>
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
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-out"
                        style="padding:.75rem 1.5rem">Cancel</a>
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
                        </div>

                        <div class="verify-box {{ old('is_verified', $vendor->is_verified ?? false) ? 'verified' : '' }}">
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <div style="display:flex;align-items:center;gap:.5rem">
                                    <span class="mi material-icons-round" style="color:var(--pri)">verified</span>
                                    <span style="font-weight:600;font-size:.75rem">Authentic Badge</span>
                                </div>
                                <label class="tog"><input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $vendor->is_verified ?? false) ? 'checked' : '' }}
                                        onchange="this.closest('.verify-box').classList.toggle('verified', this.checked)"><span
                                        class="sl"></span></label>
                            </div>
                            <p style="font-size:.65rem;color:var(--t3);margin-top:.4rem;line-height:1.4">
                                Enabling this marks the vendor as "Verified Authentic".
                            </p>
                        </div>

                        <div
                            style="display:flex;flex-direction:column;gap:.75rem;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--brd2)">
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

            </div>
        </div>
    </form>

    <!-- Package Modal -->
    <div class="modal-overlay" id="packageModal" style="display:none">
        <div class="modal-card">
            <div class="modal-h">
                <span id="modalTitle">Add Package</span>
                <button type="button" class="mi material-icons-round" onclick="closePackageModal()">close</button>
            </div>
            <form id="packageForm" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-b">
                    <div class="fg">
                        <label>Package Name *</label>
                        <input type="text" name="name" id="pkg_name" class="fi" required
                            placeholder="e.g. Bronze Wedding Package">
                    </div>
                    <div class="fg">
                        <label>Price (PKR)</label>
                        <input type="number" name="price" id="pkg_price" class="fi" placeholder="0">
                    </div>
                    <div class="fg">
                        <label>Pricing Unit</label>
                        <input type="text" name="price_unit" id="pkg_unit" class="fi" placeholder="per event">
                    </div>
                    <div class="fg">
                        <label>Description (Optional)</label>
                        <textarea name="description" id="pkg_desc" class="fi" rows="3"
                            placeholder="What's included in this package?"></textarea>
                    </div>
                </div>
                <div class="modal-f">
                    <button type="button" class="btn btn-out" onclick="closePackageModal()">Cancel</button>
                    <button type="submit" class="btn btn-pri">Save Package</button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($vendor))
        <form id="deletePkgForm" method="POST" style="display:none">
            @csrf @method('DELETE')
        </form>
    @endif

    <style>
        .cover-card {
            padding: 0 !important;
            overflow: hidden;
            border: none;
            background: #f8f9fa;
        }

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

        .cover-uploader:hover {
            opacity: 0.9;
        }

        .cover-uploader img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

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
            background: rgba(0, 0, 0, 0.4);
            color: white;
            padding: .75rem 1.5rem;
            border-radius: 30px;
            font-size: .75rem;
            opacity: 0;
            transition: opacity .2s;
        }

        .cover-uploader.has-image:hover .cover-placeholder {
            opacity: 1;
        }

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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .profile-uploader img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-placeholder {
            color: #adb5bd;
        }

        .profile-uploader.has-image .profile-placeholder {
            position: absolute;
            background: rgba(0, 0, 0, 0.4);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transition: opacity .2s;
        }

        .profile-uploader.has-image:hover .profile-placeholder {
            opacity: 1;
        }

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

        .package-name {
            font-weight: 600;
            font-size: .8rem;
            color: var(--t1);
        }

        .package-price {
            font-size: .75rem;
            color: var(--pri);
            font-weight: 700;
        }

        .empty-mini {
            padding: 1.5rem;
            text-align: center;
            color: var(--t4);
            font-size: .75rem;
            background: #fff;
            border: 1px dashed var(--brd2);
            border-radius: 8px;
        }

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

        .gallery-mini-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-card {
            background: white;
            border-radius: 16px;
            width: 450px;
            max-width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-h {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid var(--brd2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-h span {
            font-weight: 700;
            font-size: 1rem;
        }

        .modal-h button {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--t4);
        }

        .modal-b {
            padding: 1.2rem;
        }

        .modal-f {
            padding: 1rem 1.2rem;
            border-top: 1px solid var(--brd2);
            display: flex;
            justify-content: flex-end;
            gap: .5rem;
        }

        .gallery-manager-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 1rem;
        }

        .gallery-mgr-item {
            aspect-ratio: 4/3;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            border: 1px solid var(--brd2);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .gallery-mgr-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .gallery-mgr-item:hover img {
            transform: scale(1.05);
        }

        .mgr-del {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.2s;
        }

        .mgr-del input {
            display: none;
        }

        .mgr-del span {
            font-size: 1.2rem;
            color: #444;
        }

        .gallery-mgr-item.to-delete {
            opacity: 0.6;
            filter: grayscale(1);
            border-color: #dc3545;
        }

        .gallery-mgr-item.to-delete .mgr-del {
            background: #dc3545;
        }

        .gallery-mgr-item.to-delete .mgr-del span {
            color: white;
        }

        .gallery-upload-placeholder {
            aspect-ratio: 4/3;
            border: 2px dashed var(--brd2);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--t4);
            cursor: pointer;
            transition: all 0.2s;
            background: #fbfbfb;
        }

        .gallery-upload-placeholder:hover {
            background: #f1f3f5;
            border-color: var(--pri);
            color: var(--pri);
        }

        .gallery-upload-placeholder span:first-child {
            font-size: 2.5rem;
        }

        .gallery-upload-placeholder span:last-child {
            font-size: 0.7rem;
            font-weight: 500;
        }

        .gallery-new-preview {
            border: 2px solid var(--pri) !important;
            animation: fadeIn .3s ease;
        }

        .new-tag {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--pri);
            color: white;
            font-size: .55rem;
            font-weight: 800;
            padding: .2rem .5rem;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .text-red {
            color: #dc3545 !important;
        }
    </style>

@section('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial coordinates
            let initialLat = parseFloat(document.getElementById('latInput').value) || 24.8607;
            let initialLng = parseFloat(document.getElementById('lngInput').value) || 67.0011;

            // Initialize Map
            const map = L.map('map').setView([initialLat, initialLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add Marker
            let marker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map);

            // Function to update inputs
            function updateCoords(lat, lng) {
                document.getElementById('latInput').value = lat.toFixed(6);
                document.getElementById('lngInput').value = lng.toFixed(6);
                document.getElementById('coordDisplay').innerText = lat.toFixed(6) + ', ' + lng.toFixed(6);
            }

            // Map Click Event
            map.on('click', function(e) {
                const { lat, lng } = e.latlng;
                marker.setLatLng([lat, lng]);
                updateCoords(lat, lng);
            });

            // Marker Drag Event
            marker.on('dragend', function(e) {
                const { lat, lng } = marker.getLatLng();
                updateCoords(lat, lng);
            });
        });

        function previewFile(input, previewId, uploaderId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const uploader = document.getElementById(uploaderId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    uploader.classList.add('has-image');
                }
                reader.readAsDataURL(file);
            }
        }

        const modal = document.getElementById('packageModal');
        const form = document.getElementById('packageForm');
        const storeUrl = "{{ isset($vendor) ? route('admin.services.store', $vendor) : '' }}";

        function openPackageModal(data = null) {
            if (data) {
                document.getElementById('modalTitle').innerText = 'Edit Package';
                form.action = `/admin/services/${data.id}`;
                document.getElementById('methodField').innerHTML = '@method("PUT")';
                document.getElementById('pkg_name').value = data.name;
                document.getElementById('pkg_price').value = data.price;
                document.getElementById('pkg_unit').value = data.price_unit;
                document.getElementById('pkg_desc').value = data.description;
            } else {
                document.getElementById('modalTitle').innerText = 'Add Package';
                form.action = storeUrl;
                document.getElementById('methodField').innerHTML = '';
                form.reset();
            }
            modal.style.display = 'flex';
        }

        function closePackageModal() {
            modal.style.display = 'none';
        }

        function deletePackage(id) {
            if (confirm('Are you sure you want to delete this package?')) {
                const delForm = document.getElementById('deletePkgForm');
                delForm.action = `/admin/services/${id}`;
                delForm.submit();
            }
        }

        function handleGallerySelect(input) {
            const files = Array.from(input.files);
            const grid = document.getElementById('galleryGrid');
            const placeholder = grid.querySelector('.gallery-upload-placeholder');
            const counter = document.getElementById('newPhotosCount');
            
            // Remove previous previews
            grid.querySelectorAll('.gallery-new-preview').forEach(el => el.remove());

            if (files.length > 0) {
                files.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'gallery-mgr-item gallery-new-preview';
                        div.innerHTML = `
                            <img src="${e.target.result}">
                            <div class="new-tag">NEW</div>
                        `;
                        grid.insertBefore(div, placeholder);
                    };
                    reader.readAsDataURL(file);
                });
                
                counter.innerText = `+ ${files.length} new photo(s) ready to upload`;
                counter.style.display = 'block';
            } else {
                counter.style.display = 'none';
            }
        }
    </script>
@endsection
