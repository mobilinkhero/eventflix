@php $bgs = ['linear-gradient(135deg,#d4a5a5,#c48b8b)', 'linear-gradient(135deg,#8faa8f,#6d8d6d)', 'linear-gradient(135deg,#c9a961,#b5944b)', 'linear-gradient(135deg,#a5b4c4,#8297ab)', 'linear-gradient(135deg,#c4a5d4,#a88bc4)', 'linear-gradient(135deg,#d4bfa5,#c4a888)']; @endphp
<a href="{{ route('vendors.show', $vendor->slug) }}" class="card vc fi-a">
    <div class="vc-img" style="background:{{ $bgs[($loop->index ?? 0) % count($bgs)] }}">
        @if($vendor->is_featured)<span class="vc-badge">Featured</span>@endif
        <span class="material-icons-round mi">{{ $vendor->categories->first()?->icon ?? 'store' }}</span>
    </div>
    <div class="vc-b">
        <div class="vc-cat">{{ $vendor->categories->first()?->name ?? 'Vendor' }}</div>
        <div class="vc-n">{{ $vendor->name }}</div>
        <div class="vc-loc"><span
                class="material-icons-round mi">location_on</span>{{ $vendor->city->name ?? 'Pakistan' }}</div>
        <div class="vc-f">
            <div class="vc-r"><span class="material-icons-round mi">star</span>{{ number_format($vendor->rating, 1) }}
                <span>({{ $vendor->total_reviews }})</span></div>
            <div class="vc-p">{{ $vendor->price_range_formatted }}</div>
        </div>
    </div>
</a>