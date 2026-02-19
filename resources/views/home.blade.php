@extends('layouts.app')
@section('title','EventsWally — Find Wedding Vendors in Pakistan')

@section('css')
<style>
    .hero{background:var(--wh);border-bottom:1px solid var(--brd2);padding:5.5rem 0 4rem;text-align:center;position:relative;overflow:hidden}
    .hero::before{content:'';position:absolute;top:-200px;left:50%;transform:translateX(-50%);width:800px;height:800px;background:radial-gradient(circle,rgba(212,165,165,.08) 0%,transparent 65%);pointer-events:none}
    .hero-sub{font-size:.95rem;color:var(--t2);max-width:420px;margin:0 auto 2rem;line-height:1.6}
    .hero-search{max-width:440px;margin:0 auto 2.5rem;position:relative}
    .hero-search input{width:100%;padding:.78rem 1.1rem;padding-right:105px;border:1.5px solid var(--brd);border-radius:50px;font-size:.88rem;font-family:inherit;background:var(--wh);transition:border-color .2s}
    .hero-search input:focus{outline:none;border-color:var(--rose)}
    .hero-search .btn{position:absolute;right:5px;top:50%;transform:translateY(-50%);border-radius:50px;padding:.5rem 1.1rem}
    .hero-stats{display:flex;justify-content:center;gap:3rem;padding-top:2.25rem;border-top:1px solid var(--brd2);max-width:480px;margin:0 auto}
    .hero-stat-n{font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-weight:600;color:var(--t1)}
    .hero-stat-l{font-size:.68rem;color:var(--t3);text-transform:uppercase;letter-spacing:.8px;margin-top:.1rem}

    /* Flower divider SVG inline */
    .divider{text-align:center;padding:1.5rem 0}
    .divider svg{width:60px;height:auto;opacity:.15}
</style>
@endsection

@section('body')
    <!-- ═══ HERO ═══ -->
    <section class="hero">
        <div class="wrap" style="position:relative;z-index:1">
            <div class="orn orn-lg" style="margin-bottom:1.25rem">✦ your perfect day starts here ✦</div>
            <h1 class="serif" style="font-size:clamp(2.2rem,5vw,3.2rem);font-weight:400;line-height:1.15;margin-bottom:1rem">
                Find the perfect vendors<br>for your <em style="font-style:italic;color:var(--rose-deep)">dream wedding</em>
            </h1>
            <p class="hero-sub">Discover {{ $stats['vendors'] }}+ trusted wedding professionals across {{ $stats['cities'] }} cities in Pakistan.</p>

            <form action="{{ route('search') }}" method="GET" class="hero-search">
                <input type="text" name="q" placeholder="Try &quot;photographer in Lahore&quot;">
                <button type="submit" class="btn btn-p">Search</button>
            </form>

            <div class="hero-stats">
                @foreach([
                    [$stats['vendors'].'+', 'Vendors'],
                    [$stats['cities'], 'Cities'],
                    [$stats['categories'], 'Categories'],
                    [$stats['reviews'].'+', 'Reviews'],
                ] as [$num, $lbl])
                <div>
                    <div class="hero-stat-n">{{ $num }}</div>
                    <div class="hero-stat-l">{{ $lbl }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ═══ CATEGORIES ═══ -->
    <section class="sec">
        <div class="wrap">
            <div class="sec-h">
                <div>
                    <div class="orn" style="justify-content:flex-start">Services</div>
                    <h2>Browse by category</h2>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-o" style="flex-shrink:0">View all</a>
            </div>
            <div class="g4">
                @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}" class="cc fi-a">
                    <div class="cc-ic"><span class="material-icons-round mi">{{ $cat->icon }}</span></div>
                    <div class="cc-t">
                        <h3>{{ $cat->name }}</h3>
                        <span>{{ $cat->vendors_count }} vendors</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ═══ FEATURED VENDORS ═══ -->
    <section class="sec" style="background:var(--wh);border-top:1px solid var(--brd2);border-bottom:1px solid var(--brd2)">
        <div class="wrap">
            <div class="sec-h">
                <div>
                    <div class="orn" style="justify-content:flex-start">Handpicked</div>
                    <h2>Featured vendors</h2>
                </div>
                <a href="{{ route('vendors.index') }}" class="btn btn-o" style="flex-shrink:0">View all</a>
            </div>
            <div class="g3">
                @php $bgs=['linear-gradient(135deg,#d4a5a5,#c48b8b)','linear-gradient(135deg,#8faa8f,#6d8d6d)','linear-gradient(135deg,#c9a961,#b5944b)','linear-gradient(135deg,#a5b4c4,#8297ab)','linear-gradient(135deg,#c4a5d4,#a88bc4)','linear-gradient(135deg,#d4bfa5,#c4a888)']; @endphp
                @foreach($featuredVendors as $v)
                <a href="{{ route('vendors.show', $v->slug) }}" class="card vc fi-a">
                    <div class="vc-img" style="background:{{ $bgs[$loop->index % count($bgs)] }}">
                        @if($v->is_featured)<span class="vc-badge">Featured</span>@endif
                        <span class="material-icons-round mi">{{ $v->categories->first()?->icon ?? 'store' }}</span>
                    </div>
                    <div class="vc-b">
                        <div class="vc-cat">{{ $v->categories->first()?->name ?? 'Vendor' }}</div>
                        <div class="vc-n">{{ $v->name }}</div>
                        <div class="vc-loc"><span class="material-icons-round mi">location_on</span>{{ $v->city->name ?? 'Pakistan' }}</div>
                        <div class="vc-f">
                            <div class="vc-r"><span class="material-icons-round mi">star</span>{{ number_format($v->rating,1) }} <span>({{ $v->total_reviews }})</span></div>
                            <div class="vc-p">{{ $v->price_range_formatted }}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ═══ CITIES ═══ -->
    <section class="sec">
        <div class="wrap">
            <div class="sec-h">
                <div>
                    <div class="orn" style="justify-content:flex-start">Locations</div>
                    <h2>Popular cities</h2>
                </div>
                <a href="{{ route('cities.index') }}" class="btn btn-o" style="flex-shrink:0">All cities</a>
            </div>
            <div class="g5">
                @foreach($cities as $city)
                <a href="{{ route('cities.show', $city->slug) }}" class="cy fi-a">
                    <h3>{{ $city->name }}</h3>
                    <p>{{ $city->vendors_count }} vendors</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ═══ CTA ═══ -->
    <section style="padding:4rem 0">
        <div class="wrap">
            <div style="background:linear-gradient(135deg,var(--t1) 0%,#4a3e3e 100%);border-radius:16px;padding:3.5rem 2.5rem;text-align:center;position:relative;overflow:hidden">
                <div style="position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:radial-gradient(circle,rgba(212,165,165,.1),transparent 65%);border-radius:50%"></div>
                <div class="orn orn-lg" style="color:var(--rose-light);margin-bottom:1rem">✦ get started ✦</div>
                <h2 class="serif" style="font-size:1.85rem;font-weight:400;color:#fff;margin-bottom:.6rem;position:relative;z-index:1">Ready to plan your <em>big day</em>?</h2>
                <p style="font-size:.88rem;color:rgba(255,255,255,.45);margin-bottom:1.75rem;max-width:360px;margin-left:auto;margin-right:auto;line-height:1.5;position:relative;z-index:1">Download our app for exclusive deals and direct vendor communication.</p>
                <div style="display:flex;justify-content:center;gap:.75rem;position:relative;z-index:1">
                    <a href="#" class="btn btn-w btn-l">Download App</a>
                    <a href="{{ route('contact') }}" class="btn btn-l" style="background:transparent;color:rgba(255,255,255,.55);border:1.5px solid rgba(255,255,255,.12)">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
@endsection