@extends('admin.layout')
@section('title', isset($vendor) ? 'Edit: ' . $vendor->name : 'New Vendor')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 400px; border-radius: 0 0 12px 12px; border-top: 1px solid var(--brd2); z-index: 1; }
        .coord-pill { 
            position: absolute; bottom: 20px; left: 20px; z-index: 1000;
            background: rgba(255,255,255,0.95); padding: 8px 15px; border-radius: 30px;
            font-size: 0.8rem; font-weight: 700; color: var(--dark);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15); border: 1px solid var(--brd);
            display: flex; align-items: center; gap: 8px;
        }
        .verify-box {
            padding: 1rem; border-radius: 12px; background: var(--pri-xl);
            border: 1px solid var(--pri-l); transition: all 0.3s;
        }
        .verify-box.verified {
            background: #fff; border-color: var(--pri);
            box-shadow: 0 4px 12px var(--pri-l);
        }
        .new-tag {
            position: absolute; top: 10px; left: 10px; background: var(--green);
            color: white; font-size: 0.6rem; font-weight: 800;
            padding: 2px 6px; border-radius: 4px; z-index: 2;
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
                <!-- Cover & Profile -->
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
                        </div>
                        <div class="fg">
                            <label>Professional Bio</label>
                            <textarea name="description" class="fi" rows="5"
                                placeholder="Describe your services, experience, and style...">{{ old('description', $vendor->description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Contact & Location -->
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">contact_phone</span> Business Contact</div>
                    <div class="form-card-b">
                        <div class="fg-row-3">
                            <div class="fg">
                                <label>Phone</label>
                                <input type="text" name="phone" class="fi" value="{{ old('phone', $vendor->phone ?? '') }}" placeholder="+92 ...">
                            </div>
                            <div class="fg">
                                <label>WhatsApp</label>
                                <input type="text" name="whatsapp" class="fi" value="{{ old('whatsapp', $vendor->whatsapp ?? '') }}" placeholder="+92 ...">
                            </div>
                            <div class="fg">
                                <label>Email</label>
                                <input type="email" name="email" class="fi" value="{{ old('email', $vendor->email ?? '') }}" placeholder="business@example.com">
                            </div>
                        </div>
                        <div class="fg">
                            <label>Physical Address / Studio Location</label>
                            <input type="text" name="address" class="fi" value="{{ old('address', $vendor->address ?? '') }}" placeholder="Street, Phase, City...">
                        </div>
                    </div>
                </div>

                <!-- GPS Map -->
                <div class="form-card">
                    <div class="form-card-h" style="display:flex;justify-content:space-between;align-items:center">
                        <div><span class="mi material-icons-round">map</span> Global Positioning (GPS)</div>
                        <div style="font-size:0.7rem;font-weight:400;color:var(--t4)">Click map to pin location</div>
                    </div>
                    <div style="position:relative">
                        <input type="hidden" name="latitude" id="latInput" value="{{ old('latitude', $vendor->latitude ?? '24.8607') }}">
                        <input type="hidden" name="longitude" id="lngInput" value="{{ old('longitude', $vendor->longitude ?? '67.0011') }}">
                        <div id="map"></div>
                        <div class="coord-pill">
                            <span class="mi material-icons-round" style="font-size:1.1rem;color:var(--pri)">my_location</span>
                            <span id="coordDisplay">{{ old('latitude', $vendor->latitude ?? '24.8607') }}, {{ old('longitude', $vendor->longitude ?? '67.0011') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Portfolio -->
                <div class="form-card">
                    <div class="form-card-h" style="display:flex;justify-content:space-between;align-items:center">
                        <div><span class="mi material-icons-round">collections</span> Portfolio Manager</div>
                        <label class="btn btn-out btn-xs" style="cursor:pointer">
                            <span class="mi material-icons-round">add_photo_alternate</span> Add Photos
                            <input type="file" name="gallery_files[]" id="galleryInput" multiple accept="image/*" style="display:none" onchange="handleGallerySelect(this)">
                        </label>
                    </div>
                    <div class="form-card-b">
                        <div id="galleryGrid" class="gallery-manager-grid">
                            @if(isset($vendor) && $vendor->gallery)
                                @foreach($vendor->gallery as $img)
                                    <div class="gallery-mgr-item">
                                        <img src="{{ Str::startsWith($img, 'http') ? $img : url('uploads/' . $img) }}">
                                        <label class="mgr-del">
                                            <input type="checkbox" name="remove_gallery_images[]" value="{{ $img }}" onchange="this.closest('.gallery-mgr-item').classList.toggle('to-delete', this.checked)">
                                            <span class="mi material-icons-round">delete</span>
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                            <div class="gallery-upload-placeholder" onclick="document.getElementById('galleryInput').click()">
                                <span class="mi material-icons-round">cloud_upload</span>
                                <span>Add more</span>
                            </div>
                        </div>
                        <div id="newPhotosCount" style="display:none;margin-top:1rem;font-size:0.7rem;color:var(--pri);font-weight:600"></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display:flex;gap:.5rem;margin-top:1.5rem;margin-bottom:3rem">
                    <button type="submit" class="btn btn-pri" style="padding:.75rem 2rem">
                        <span class="mi material-icons-round">{{ isset($vendor) ? 'check_circle' : 'save' }}</span>
                        {{ isset($vendor) ? 'Save Changes' : 'Create Vendor' }}
                    </button>
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-out" style="padding:.75rem 1.5rem">Cancel</a>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div style="width:280px;flex-shrink:0">
                <div class="form-card">
                    <div class="form-card-h"><span class="mi material-icons-round">verified_user</span> Status & Security</div>
                    <div class="form-card-b">
                        <div class="fg">
                            <label>Listing Status</label>
                            <select name="status" class="fi">
                                <option value="approved" {{ old('status', $vendor->status ?? '') === 'approved' ? 'selected' : '' }}>✅ Approved</option>
                                <option value="rejected" {{ old('status', $vendor->status ?? '') === 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                <option value="suspended" {{ old('status', $vendor->status ?? '') === 'suspended' ? 'selected' : '' }}>🚫 Suspended</option>
                            </select>
                        </div>
                        <div class="verify-box {{ old('is_verified', $vendor->is_verified ?? false) ? 'verified' : '' }}">
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <span style="font-weight:600;font-size:.75rem">Authentic Badge</span>
                                <label class="tog"><input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $vendor->is_verified ?? false) ? 'checked' : '' }} onchange="this.closest('.verify-box').classList.toggle('verified', this.checked)"><span class="sl"></span></label>
                            </div>
                        </div>
                        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--brd2);display:flex;flex-direction:column;gap:.75rem">
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <span style="font-size:.75rem">Publicly Visible</span>
                                <label class="tog"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $vendor->is_active ?? true) ? 'checked' : '' }}><span class="sl"></span></label>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <span style="font-size:.75rem">Featured Profile</span>
                                <label class="tog"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $vendor->is_featured ?? false) ? 'checked' : '' }}><span class="sl"></span></label>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($vendor))
                    <div class="form-card">
                        <div class="form-card-h"><span class="mi material-icons-round">inventory_2</span> Packages</div>
                        <div class="form-card-b">
                            @if($vendor->services->isNotEmpty())
                                @foreach($vendor->services as $svc)
                                    <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size.75rem">
                                        <span>{{ $svc->name }}</span>
                                        <span style="font-weight:700">PKR {{ number_format($svc->price) }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="hint">No packages defined</div>
                            @endif
                            <button type="button" onclick="openPackageModal()" class="btn btn-out btn-xs" style="width:100%;margin-top:1rem">Manage Packages</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <!-- Package Modal Placeholder -->
    <div id="packageModal" class="modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:2000;align-items:center;justify-content:center">
        <div class="form-card" style="width:450px;margin:0">
            <div class="form-card-h"><span id="modalTitle">Package</span></div>
            <form id="packageForm" method="POST">
                @csrf <div id="methodField"></div>
                <div class="form-card-b">
                    <div class="fg"><label>Name</label><input type="text" name="name" id="pkg_name" class="fi" required></div>
                    <div class="fg-row"><div class="fg"><label>Price</label><input type="number" name="price" id="pkg_price" class="fi" required></div><div class="fg"><label>Unit</label><input type="text" name="price_unit" id="pkg_unit" class="fi" placeholder="e.g. Per Event"></div></div>
                    <div class="fg"><label>Description</label><textarea name="description" id="pkg_desc" class="fi" rows="3"></textarea></div>
                </div>
                <div class="form-card-f" style="padding:1rem;display:flex;justify-content:flex-end;gap:.5rem;background:var(--bg)">
                    <button type="button" onclick="closePackageModal()" class="btn btn-out">Cancel</button>
                    <button type="submit" class="btn btn-pri">Save Package</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function previewFile(input, previewId, uploaderId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const uploader = document.getElementById(uploaderId);
            if (file) {
                const reader = new FileReader();
                reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; uploader.classList.add('has-image'); }
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                let lat = parseFloat(document.getElementById('latInput').value) || 24.8607;
                let lng = parseFloat(document.getElementById('lngInput').value) || 67.0011;
                const map = L.map('map', { scrollWheelZoom: false }).setView([lat, lng], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
                let marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                function up(l, g) {
                    document.getElementById('latInput').value = l.toFixed(6);
                    document.getElementById('lngInput').value = g.toFixed(6);
                    document.getElementById('coordDisplay').innerText = l.toFixed(6) + ', ' + g.toFixed(6);
                }
                map.on('click', e => { marker.setLatLng(e.latlng); up(e.latlng.lat, e.latlng.lng); });
                marker.on('dragend', () => { const p = marker.getLatLng(); up(p.lat, p.lng); });
                setTimeout(() => map.invalidateSize(), 500);
            }, 300);
        });

        const modal = document.getElementById('packageModal');
        const form = document.getElementById('packageForm');
        function openPackageModal(data = null) {
            if(data) { /* logic */ } else { form.action = "{{ isset($vendor) ? route('admin.services.store', $vendor) : '' }}"; form.reset(); }
            modal.style.display = 'flex';
        }
        function closePackageModal() { modal.style.display = 'none'; }

        function handleGallerySelect(input) {
            const files = Array.from(input.files);
            const grid = document.getElementById('galleryGrid');
            grid.querySelectorAll('.gallery-new-preview').forEach(el => el.remove());
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'gallery-mgr-item gallery-new-preview';
                    div.innerHTML = `<img src="${e.target.result}"><div class="new-tag">NEW</div>`;
                    grid.insertBefore(div, grid.querySelector('.gallery-upload-placeholder'));
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endsection
