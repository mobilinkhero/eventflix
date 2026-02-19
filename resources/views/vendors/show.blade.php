@extends('layouts.app')
@section('title', $vendor->name . ' — EventsWally')

@section('body')
    <div class="det-hero">
        <div class="wrap">
            <div class="crumb" style="font-size:.76rem;color:var(--t3);display:flex;gap:.4rem;margin-bottom:1.25rem">
                <a href="{{ route('home') }}" style="color:var(--t2)">Home</a> <span>›</span>
                <a href="{{ route('vendors.index') }}" style="color:var(--t2)">Vendors</a> <span>›</span>
                <span>{{ Str::limit($vendor->name, 30) }}</span>
            </div>
            <div class="det-top">
                <div class="det-av" style="background:linear-gradient(135deg,#d4a5a5,#c48b8b)">
                    <span class="material-icons-round mi">{{ $vendor->categories->first()?->icon ?? 'store' }}</span>
                </div>
                <div class="det-inf">
                    <p
                        style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--rose-deep);margin-bottom:.35rem">
                        {{ $vendor->categories->pluck('name')->join(' · ') }}</p>
                    <h1>{{ $vendor->name }}</h1>
                    <div class="loc"><span class="material-icons-round mi">location_on</span>
                        {{ $vendor->address ? Str::limit($vendor->address, 40) . ', ' : '' }}{{ $vendor->city->name ?? 'Pakistan' }}
                    </div>
                    <div class="det-tags">
                        @if($vendor->is_verified)<span class="det-tag" style="color:#2d8a56"><span
                        class="material-icons-round mi">verified</span>Verified</span>@endif
                        @if($vendor->is_featured)<span class="det-tag" style="color:var(--rose-deep)"><span
                        class="material-icons-round mi">favorite</span>Featured</span>@endif
                        <span class="det-tag"><span class="material-icons-round mi"
                                style="color:var(--gold)">star</span>{{ number_format($vendor->rating, 1) }}
                            ({{ $vendor->reviews_count }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="sec">
        <div class="wrap">
            <div class="det-body">
                <div class="det-main">
                    <div style="margin-bottom:2.5rem">
                        <h2 class="serif" style="font-size:1.35rem;font-weight:500;margin-bottom:.75rem">About</h2>
                        <p style="font-size:.88rem;color:var(--t2);line-height:1.7">
                            {{ $vendor->description ?? 'No description available yet.' }}</p>
                    </div>

                    @if($vendor->services->count())
                        <div style="margin-bottom:2.5rem">
                            <h2 class="serif" style="font-size:1.35rem;font-weight:500;margin-bottom:.75rem">Services & Pricing
                            </h2>
                            <div class="card" style="overflow:hidden">
                                <table class="svt">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Details</th>
                                            <th style="text-align:right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vendor->services as $svc)
                                            <tr>
                                                <td style="font-weight:600;white-space:nowrap">{{ $svc->name }}</td>
                                                <td style="color:var(--t2)">{{ Str::limit($svc->description, 55) ?? '—' }}</td>
                                                <td style="text-align:right;font-weight:600;white-space:nowrap">PKR
                                                    {{ number_format($svc->price) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div>
                        <h2 class="serif" style="font-size:1.35rem;font-weight:500;margin-bottom:.75rem">Reviews
                            ({{ $vendor->reviews_count }})</h2>
                        @forelse($vendor->reviews as $review)
                            <div class="rv fi-a">
                                <div class="rv-h">
                                    <div class="rv-av">
                                        {{ $review->is_anonymous ? '?' : strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="rv-m">
                                        <h4>{{ $review->is_anonymous ? 'Anonymous' : ($review->user->name ?? 'User') }}</h4>
                                        <div class="d">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)<span
                                        class="material-icons-round mi {{ $i <= $review->rating ? '' : 'off' }}">star</span>@endfor
                                    </div>
                                </div>
                                <p>{{ $review->comment }}</p>
                                @if($review->vendor_reply)
                                    <div
                                        style="margin-top:.65rem;padding:.65rem;background:var(--rose-pale);border-radius:7px;border-left:3px solid var(--rose)">
                                        <p style="font-size:.68rem;font-weight:700;color:var(--rose-deep);margin-bottom:.15rem">
                                            Vendor Reply</p>
                                        <p style="font-size:.82rem;color:var(--t2)">{{ $review->vendor_reply }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="empty" style="padding:1.5rem">
                                <h3>No reviews yet</h3>
                                <p>Be the first to share your experience.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <aside class="det-aside">
                    <div class="aside-c">
                        <h3>Pricing</h3>
                        <div class="serif" style="font-size:1.4rem;font-weight:600;margin-bottom:.25rem">
                            {{ $vendor->price_range_formatted }}</div>
                        <div style="font-size:.75rem;color:var(--t3);margin-bottom:1.25rem">Starting price</div>
                        <a href="#" class="btn btn-r btn-l" style="width:100%;justify-content:center">
                            <span class="material-icons-round" style="font-size:16px">favorite_border</span> Book Now
                        </a>
                    </div>
                    <div class="aside-c">
                        <h3>Contact</h3>
                        @if($vendor->phone)
                            <div class="info-r"><span class="material-icons-round mi">phone</span>
                                <div>
                                    <div class="lb">Phone</div>
                                    <div class="vl">{{ $vendor->phone }}</div>
                                </div>
                            </div>
                        @endif
                        @if($vendor->whatsapp)
                            <div class="info-r"><span class="material-icons-round mi">chat</span>
                                <div>
                                    <div class="lb">WhatsApp</div>
                                    <div class="vl">{{ $vendor->whatsapp }}</div>
                                </div>
                            </div>
                        @endif
                        @if($vendor->email)
                            <div class="info-r"><span class="material-icons-round mi">email</span>
                                <div>
                                    <div class="lb">Email</div>
                                    <div class="vl" style="word-break:break-all;font-size:.8rem">{{ $vendor->email }}</div>
                                </div>
                            </div>
                        @endif
                        @if($vendor->address)
                            <div class="info-r"><span class="material-icons-round mi">location_on</span>
                                <div>
                                    <div class="lb">Address</div>
                                    <div class="vl" style="font-size:.82rem">{{ Str::limit($vendor->address, 50) }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>
            </div>

            @if($relatedVendors->count())
                <div style="margin-top:3.5rem">
                    <div class="orn" style="justify-content:flex-start;margin-bottom:.5rem">More options</div>
                    <h2 class="serif" style="font-size:1.35rem;font-weight:500;margin-bottom:1.25rem">Similar vendors in
                        {{ $vendor->city->name ?? 'your city' }}</h2>
                    <div class="g3">
                        @foreach($relatedVendors as $vendor)
                            @include('partials.vendor-card')
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection