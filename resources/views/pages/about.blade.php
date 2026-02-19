@extends('layouts.app')
@section('title','About — EventsWally')

@section('body')
<div class="ph">
    <div class="wrap">
        <div class="crumb"><a href="{{ route('home') }}">Home</a> <span>›</span> About</div>
        <h1>Our Story</h1>
        <p>Making wedding planning effortless since 2024</p>
    </div>
</div>
<section class="sec">
    <div class="wrap-sm">
        <div style="margin-bottom:3rem">
            <p style="font-size:.92rem;color:var(--t2);line-height:1.8;margin-bottom:1rem">We know how overwhelming wedding planning can be. Finding the right photographer, the perfect venue, a caterer who understands your vision — it shouldn't feel like a second job.</p>
            <p style="font-size:.92rem;color:var(--t2);line-height:1.8;margin-bottom:1rem">That's why we created EventsWally. A single place where couples in Pakistan can discover, compare, and book trusted wedding professionals — all with honest reviews, transparent pricing, and verified profiles.</p>
            <p style="font-size:.92rem;color:var(--t2);line-height:1.8">From intimate nikah ceremonies to grand walimahs, we're here to help you build your dream team.</p>
        </div>

        <div style="margin-bottom:3rem">
            <div class="orn" style="justify-content:flex-start;margin-bottom:.75rem">How it works</div>
            <h2 class="serif" style="font-size:1.45rem;font-weight:500;margin-bottom:1.25rem">Three simple steps</h2>
            @foreach([
                ['search','Browse vendors','Search by category, city, budget — read real reviews from real couples.'],
                ['favorite','Shortlist favorites','Save the ones you love, compare pricing, and request custom quotes.'],
                ['event_available','Book with confidence','Confirm your booking through EventsWally with verified vendors.'],
            ] as [$icon,$title,$desc])
            <div style="display:flex;gap:1rem;padding:1.15rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--brd2);' : '' }}">
                <div style="width:44px;height:44px;border-radius:50%;background:var(--rose-pale);border:1px solid var(--rose-light);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <span class="material-icons-round" style="font-size:20px;color:var(--rose-deep)">{{ $icon }}</span>
                </div>
                <div>
                    <h4 style="font-size:.9rem;font-weight:600;margin-bottom:.2rem">{{ $title }}</h4>
                    <p style="font-size:.84rem;color:var(--t2);line-height:1.5">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div style="background:linear-gradient(135deg,var(--t1),#4a3e3e);border-radius:14px;padding:2.5rem;text-align:center">
            <div class="orn" style="color:var(--rose-light);margin-bottom:.75rem">✦ trusted ✦</div>
            <h3 class="serif" style="font-size:1.35rem;font-weight:400;color:#fff;margin-bottom:1.5rem">The numbers speak</h3>
            <div style="display:flex;justify-content:center;gap:2.5rem;flex-wrap:wrap">
                @foreach([
                    [\App\Models\Vendor::active()->count().'+','Vendors'],
                    [\App\Models\City::active()->count(),'Cities'],
                    [\App\Models\Category::active()->count(),'Categories'],
                    [\App\Models\Review::where('status','approved')->count().'+','Reviews'],
                ] as [$n,$l])
                <div>
                    <div class="serif" style="font-size:1.5rem;font-weight:500;color:#fff">{{ $n }}</div>
                    <div style="font-size:.68rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.8px;margin-top:.1rem">{{ $l }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
