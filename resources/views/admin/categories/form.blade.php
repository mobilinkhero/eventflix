@extends('admin.layout')
@section('title', isset($category) ? 'Edit: ' . $category->name : 'New Category')

@php
    $currentIcon = old('icon', $category->icon ?? '');
    $isUploaded = str_starts_with($currentIcon, 'uploaded:');
    $uploadedPath = $isUploaded ? str_replace('uploaded:', '', $currentIcon) : '';
    $materialIcon = $isUploaded ? '' : $currentIcon;
@endphp

@section('content')
    <form method="POST" enctype="multipart/form-data"
        action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        style="max-width:600px">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <div class="form-card">
            <div class="form-card-h"><span class="mi material-icons-round">sell</span> Category Details</div>
            <div class="form-card-b">
                <div class="fg">
                    <label>Name *</label>
                    <input type="text" name="name" class="fi" value="{{ old('name', $category->name ?? '') }}" required>
                </div>

                {{-- ═══ ICON PICKER ═══ --}}
                <div class="fg">
                    <label>Icon</label>
                    <input type="hidden" name="icon" id="iconInput" value="{{ $materialIcon }}">
                    <input type="hidden" name="remove_icon_image" id="removeIconImage" value="0">

                    {{-- Mode Tabs --}}
                    <div class="icon-tabs">
                        <button type="button" class="icon-tab {{ !$isUploaded ? 'active' : '' }}"
                            onclick="switchMode('material')">
                            <span class="material-icons-round" style="font-size:15px">grid_view</span> Material Icons
                        </button>
                        <button type="button" class="icon-tab {{ $isUploaded ? 'active' : '' }}"
                            onclick="switchMode('upload')">
                            <span class="material-icons-round" style="font-size:15px">upload_file</span> Upload PNG
                        </button>
                    </div>

                    {{-- Selected preview --}}
                    <div id="iconPreview" class="icon-preview">
                        <div class="icon-preview-box" id="previewBox">
                            @if($isUploaded)
                                <img src="{{ url('uploads/' . $uploadedPath) }}" id="previewImg"
                                    style="width:26px;height:26px;object-fit:contain">
                                <span class="material-icons-round" id="previewIcon" style="display:none">category</span>
                            @else
                                <img src="" id="previewImg" style="width:26px;height:26px;object-fit:contain;display:none">
                                <span class="material-icons-round" id="previewIcon">{{ $materialIcon ?: 'category' }}</span>
                            @endif
                        </div>
                        <div style="flex:1;min-width:0">
                            <div class="icon-preview-name" id="previewName">
                                @if($isUploaded)
                                    {{ basename($uploadedPath) }}
                                @elseif($materialIcon)
                                    {{ $materialIcon }}
                                @else
                                    None selected
                                @endif
                            </div>
                            <div class="hint" id="previewHint">
                                {{ $isUploaded ? 'Uploaded image' : 'Click below to change' }}</div>
                        </div>
                        <button type="button" class="btn btn-xs btn-out" onclick="clearAll()" style="flex-shrink:0">
                            <span class="mi material-icons-round">close</span> Clear
                        </button>
                    </div>

                    {{-- ═══ Material Icons Mode ═══ --}}
                    <div id="materialMode" style="{{ $isUploaded ? 'display:none' : '' }}">
                        <div style="position:relative;margin-bottom:.5rem">
                            <span class="material-icons-round"
                                style="position:absolute;left:.5rem;top:50%;transform:translateY(-50%);font-size:16px;color:var(--t3)">search</span>
                            <input type="text" class="fi" id="iconSearch" placeholder="Search icons..."
                                style="padding-left:2rem;font-size:.72rem">
                        </div>
                        <div class="icon-grid" id="iconGrid"></div>
                    </div>

                    {{-- ═══ Upload Mode ═══ --}}
                    <div id="uploadMode" style="{{ !$isUploaded ? 'display:none' : '' }}">
                        <div class="drop-zone" id="dropZone" onclick="document.getElementById('fileInput').click()">
                            <div class="drop-zone-inner" id="dropInner">
                                @if($isUploaded)
                                    <img src="{{ url('uploads/' . $uploadedPath) }}" class="drop-zone-thumb" id="dropThumb">
                                    <div class="drop-zone-info">
                                        <span class="drop-zone-name">{{ basename($uploadedPath) }}</span>
                                        <span class="drop-zone-hint">Click or drag to replace</span>
                                    </div>
                                @else
                                    <div class="drop-zone-placeholder" id="dropPlaceholder">
                                        <span class="material-icons-round"
                                            style="font-size:32px;color:var(--pri);opacity:.5">cloud_upload</span>
                                        <span style="font-size:.78rem;font-weight:600;color:var(--t2)">Drop PNG here or click to
                                            browse</span>
                                        <span style="font-size:.6rem;color:var(--t3)">PNG, JPG, WebP, SVG • Max 2MB</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <input type="file" name="icon_image" id="fileInput"
                            accept="image/png,image/jpeg,image/webp,image/svg+xml" style="display:none">
                    </div>
                </div>

                <div class="fg">
                    <label>Color</label>
                    <div style="display:flex;gap:.3rem;align-items:center">
                        <input type="color" name="color" id="colorPicker"
                            value="{{ old('color', $category->color ?? '#b07272') }}"
                            style="width:30px;height:28px;border:1px solid var(--brd);border-radius:4px;cursor:pointer;padding:0">
                        <input type="text" class="fi" value="{{ old('color', $category->color ?? '#b07272') }}"
                            style="flex:1;font-family:monospace;font-size:.72rem"
                            onchange="this.previousElementSibling.value=this.value;updatePreviewColor()" id="colorText">
                    </div>
                </div>

                <div class="fg">
                    <label>Description</label>
                    <textarea name="description" class="fi"
                        rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                </div>
                <div class="fg">
                    <label>Image URL</label>
                    <input type="text" name="image" class="fi" value="{{ old('image', $category->image ?? '') }}"
                        placeholder="https://...">
                </div>
                <div class="fg-row">
                    <div class="fg">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="fi"
                            value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
                    </div>
                    <div class="fg" style="display:flex;align-items:flex-end;padding-bottom:.5rem">
                        <div style="display:flex;align-items:center;justify-content:space-between;width:100%">
                            <span style="font-size:.72rem;font-weight:500">Active</span>
                            <label class="tog"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}><span class="sl"></span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.4rem">
            <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">save</span>
                {{ isset($category) ? 'Save' : 'Create' }}</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-out">Cancel</a>
        </div>
    </form>

    <style>
        .icon-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: .5rem;
            background: var(--bg);
            border-radius: var(--radius);
            padding: 3px;
            border: 1px solid var(--brd);
        }

        .icon-tab {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 6px 10px;
            border: none;
            background: transparent;
            border-radius: 5px;
            font-size: .7rem;
            font-weight: 600;
            color: var(--t3);
            cursor: pointer;
            font-family: inherit;
            transition: all .15s;
        }

        .icon-tab:hover {
            color: var(--t2);
        }

        .icon-tab.active {
            background: var(--card);
            color: var(--pri-d);
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        .icon-preview {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .5rem .7rem;
            background: var(--bg);
            border-radius: var(--radius);
            border: 1px solid var(--brd);
            margin-bottom: .5rem;
        }

        .icon-preview-box {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
            transition: background .2s;
        }

        .icon-preview-box .material-icons-round {
            font-size: 22px;
        }

        .icon-preview-name {
            font-size: .75rem;
            font-weight: 600;
            color: var(--t1);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(68px, 1fr));
            gap: 4px;
            max-height: 240px;
            overflow-y: auto;
            border: 1px solid var(--brd);
            border-radius: var(--radius);
            padding: 5px;
            background: var(--bg);
        }

        .icon-grid::-webkit-scrollbar {
            width: 4px;
        }

        .icon-grid::-webkit-scrollbar-thumb {
            background: var(--brd);
            border-radius: 4px;
        }

        .icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            padding: 7px 3px;
            border-radius: 6px;
            cursor: pointer;
            transition: all .15s;
            border: 2px solid transparent;
            background: var(--card);
        }

        .icon-item:hover {
            background: var(--pri-xl);
            border-color: var(--pri-l);
            transform: translateY(-1px);
        }

        .icon-item.selected {
            background: var(--pri-l);
            border-color: var(--pri);
            box-shadow: 0 2px 8px rgba(176, 114, 114, .2);
        }

        .icon-item .material-icons-round {
            font-size: 20px;
            color: var(--t2);
            transition: color .15s;
        }

        .icon-item.selected .material-icons-round,
        .icon-item:hover .material-icons-round {
            color: var(--pri-d);
        }

        .icon-item-label {
            font-size: .48rem;
            color: var(--t3);
            text-align: center;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            line-height: 1.1;
        }

        .icon-item.selected .icon-item-label {
            color: var(--pri-d);
            font-weight: 600;
        }

        /* Drop Zone */
        .drop-zone {
            border: 2px dashed var(--brd);
            border-radius: var(--radius);
            padding: 4px;
            cursor: pointer;
            transition: all .2s;
            background: var(--bg);
        }

        .drop-zone:hover,
        .drop-zone.drag-over {
            border-color: var(--pri);
            background: var(--pri-xl);
        }

        .drop-zone-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100px;
            gap: 6px;
        }

        .drop-zone-thumb {
            width: 48px;
            height: 48px;
            object-fit: contain;
            border-radius: 8px;
            background: var(--card);
            padding: 4px;
            border: 1px solid var(--brd);
        }

        .drop-zone-info {
            text-align: center;
        }

        .drop-zone-name {
            display: block;
            font-size: .72rem;
            font-weight: 600;
            color: var(--t1);
        }

        .drop-zone-hint {
            display: block;
            font-size: .6rem;
            color: var(--t3);
            margin-top: 2px;
        }

        .drop-zone-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 1rem;
        }
    </style>
@endsection

@section('js')
    <script>
            const icons = [
                { name: 'camera_alt', label: 'Camera' },
                { name: 'photo_camera', label: 'Photo' },
                { name: 'videocam', label: 'Video' },
                { name: 'restaurant', label: 'Restaurant' },
                { name: 'restaurant_menu', label: 'Menu' },
                { name: 'local_dining', label: 'Dining' },
                { name: 'fastfood', label: 'Fast Food' },
                { name: 'cake', label: 'Cake' },
                { name: 'icecream', label: 'Ice Cream' },
                { name: 'brush', label: 'Brush' },
                { name: 'palette', label: 'Palette' },
                { name: 'auto_fix_high', label: 'Magic' },
                { name: 'directions_car', label: 'Car' },
                { name: 'local_taxi', label: 'Taxi' },
                { name: 'airport_shuttle', label: 'Shuttle' },
                { name: 'music_note', label: 'Music' },
                { name: 'queue_music', label: 'Playlist' },
                { name: 'headphones', label: 'DJ' },
                { name: 'mic', label: 'Mic' },
                { name: 'location_on', label: 'Location' },
                { name: 'location_city', label: 'City' },
                { name: 'apartment', label: 'Venue' },
                { name: 'home_work', label: 'Hall' },
                { name: 'villa', label: 'Villa' },
                { name: 'face', label: 'Face' },
                { name: 'face_retouching_natural', label: 'Makeup' },
                { name: 'spa', label: 'Spa' },
                { name: 'self_improvement', label: 'Wellness' },
                { name: 'favorite', label: 'Heart' },
                { name: 'diamond', label: 'Diamond' },
                { name: 'local_florist', label: 'Florist' },
                { name: 'yard', label: 'Garden' },
                { name: 'park', label: 'Park' },
                { name: 'checkroom', label: 'Fashion' },
                { name: 'dry_cleaning', label: 'Dress' },
                { name: 'event_note', label: 'Event' },
                { name: 'event', label: 'Calendar' },
                { name: 'celebration', label: 'Party' },
                { name: 'emoji_events', label: 'Trophy' },
                { name: 'card_giftcard', label: 'Gift' },
                { name: 'mail', label: 'Mail' },
                { name: 'print', label: 'Print' },
                { name: 'design_services', label: 'Design' },
                { name: 'church', label: 'Church' },
                { name: 'mosque', label: 'Mosque' },
                { name: 'groups', label: 'Group' },
                { name: 'handshake', label: 'Handshake' },
                { name: 'star', label: 'Star' },
                { name: 'theater_comedy', label: 'Theater' },
                { name: 'nightlife', label: 'Nightlife' },
                { name: 'local_bar', label: 'Bar' },
                { name: 'wine_bar', label: 'Wine' },
                { name: 'light', label: 'Lighting' },
                { name: 'bolt', label: 'Electric' },
                { name: 'construction', label: 'Setup' },
                { name: 'chair', label: 'Furniture' },
                { name: 'table_restaurant', label: 'Table' },
                { name: 'tent', label: 'Tent' },
                { name: 'security', label: 'Security' },
                { name: 'cleaning_services', label: 'Cleaning' },
            ];

            let currentMode = '{{ $isUploaded ? "upload" : "material" }}';
            const currentIcon = '{{ $materialIcon }}';
            const grid = document.getElementById('iconGrid');
            const input = document.getElementById('iconInput');
            const previewIcon = document.getElementById('previewIcon');
            const previewImg = document.getElementById('previewImg');
            const previewName = document.getElementById('previewName');
            const previewHint = document.getElementById('previewHint');
            const previewBox = document.getElementById('previewBox');
            const dropZone = document.getElementById('dropZone');
            const dropInner = document.getElementById('dropInner');
            const fileInput = document.getElementById('fileInput');
            const removeInput = document.getElementById('removeIconImage');

            function getColor() { return document.getElementById('colorPicker').value || '#b07272'; }
            function updatePreviewColor() { previewBox.style.background = getColor(); }

            function switchMode(mode) {
                currentMode = mode;
                document.querySelectorAll('.icon-tab').forEach((t, i) => {
                    t.classList.toggle('active', (i === 0 && mode === 'material') || (i === 1 && mode === 'upload'));
                });
                document.getElementById('materialMode').style.display = mode === 'material' ? '' : 'none';
                document.getElementById('uploadMode').style.display = mode === 'upload' ? '' : 'none';
            }

            function selectIcon(name) {
                input.value = name;
                previewIcon.textContent = name;
                previewIcon.style.display = '';
                previewImg.style.display = 'none';
                previewName.textContent = name;
                previewHint.textContent = 'Material Icon';
                previewBox.style.background = getColor();
                removeInput.value = '1'; // remove any uploaded image
                fileInput.value = ''; // clear file

                document.querySelectorAll('.icon-item').forEach(el => {
                    el.classList.toggle('selected', el.dataset.name === name);
                });
            }

            function clearAll() {
                input.value = '';
                previewIcon.textContent = 'category';
                previewIcon.style.display = '';
                previewImg.style.display = 'none';
                previewName.textContent = 'None selected';
                previewHint.textContent = 'Click below to change';
                removeInput.value = '1';
                fileInput.value = '';
                document.querySelectorAll('.icon-item').forEach(el => el.classList.remove('selected'));
                resetDropZone();
            }

            function resetDropZone() {
                dropInner.innerHTML = `
                    <div class="drop-zone-placeholder">
                        <span class="material-icons-round" style="font-size:32px;color:var(--pri);opacity:.5">cloud_upload</span>
                        <span style="font-size:.78rem;font-weight:600;color:var(--t2)">Drop PNG here or click to browse</span>
                        <span style="font-size:.6rem;color:var(--t3)">PNG, JPG, WebP, SVG • Max 2MB</span>
                    </div>`;
            }

            function handleFile(file) {
                if (!file || !file.type.startsWith('image/')) return;
                if (file.size > 2 * 1024 * 1024) { alert('File must be under 2MB'); return; }

                // Update preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    previewImg.style.display = '';
                    previewIcon.style.display = 'none';
                    previewName.textContent = file.name;
                    previewHint.textContent = 'Uploaded image';
                    previewBox.style.background = getColor();
                    input.value = ''; // clear material icon
                    removeInput.value = '0';

                    // Clear material icon selection
                    document.querySelectorAll('.icon-item').forEach(el => el.classList.remove('selected'));

                    // Update drop zone
                    dropInner.innerHTML = `
                        <img src="${e.target.result}" class="drop-zone-thumb">
                        <div class="drop-zone-info">
                            <span class="drop-zone-name">${file.name}</span>
                            <span class="drop-zone-hint">Click or drag to replace</span>
                        </div>`;
                };
                reader.readAsDataURL(file);

                // Set the file input
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
            }

            function renderIcons(filter = '') {
                const filtered = filter
                    ? icons.filter(i => i.name.includes(filter) || i.label.toLowerCase().includes(filter))
                    : icons;
                grid.innerHTML = '';
                filtered.forEach(icon => {
                    const div = document.createElement('div');
                    div.className = 'icon-item' + (currentIcon === icon.name ? ' selected' : '');
                    div.dataset.name = icon.name;
                    div.innerHTML = `<span class="material-icons-round">${icon.name}</span><span class="icon-item-label">${icon.label}</span>`;
                    div.onclick = () => selectIcon(icon.name);
                    grid.appendChild(div);
                });
                if (filtered.length === 0) {
                    grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:1.5rem;color:var(--t3);font-size:.72rem">No icons found</div>';
                }
            }

            // Init
            renderIcons();
            updatePreviewColor();
            if (currentIcon) selectIcon(currentIcon);

            // Search filter
            document.getElementById('iconSearch').addEventListener('input', function() {
                renderIcons(this.value.toLowerCase().trim());
            });

            // Color sync
            document.getElementById('colorPicker').addEventListener('input', function() {
                document.getElementById('colorText').value = this.value;
                updatePreviewColor();
            });

            // File input change
            fileInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            // Drag and drop
            ['dragenter', 'dragover'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
            });
            ['dragleave', 'drop'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
            });
            dropZone.addEventListener('drop', (e) => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
    </script>
@endsection