@extends('layouts.app')
@section('title', 'Categories — EventsWally')

@section('body')
    <div class="ph">
        <div class="wrap">
            <div class="crumb"><a href="{{ route('home') }}">Home</a> <span>›</span> Categories</div>
            <h1>Wedding Services</h1>
            <p>Everything you need for your perfect day, all in one place</p>
        </div>
    </div>
    <section class="sec">
        <div class="wrap">
            <div class="g3">
                @foreach($categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" class="card fi-a"
                        style="padding:1.75rem;display:block">
                        <div
                            style="width:52px;height:52px;border-radius:50%;background:var(--rose-pale);border:1px solid var(--rose-light);display:flex;align-items:center;justify-content:center;margin-bottom:.85rem">
                            <span class="material-icons-round"
                                style="font-size:24px;color:var(--rose-deep)">{{ $cat->icon }}</span>
                        </div>
                        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:500;margin-bottom:.3rem">
                            {{ $cat->name }}</h3>
                        <p
                            style="font-size:.8rem;color:var(--t2);line-height:1.5;margin-bottom:.6rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                            {{ $cat->description ?? 'Find the best ' . strtolower($cat->name) . ' for your celebration' }}</p>
                        <span style="font-size:.76rem;font-weight:600;color:var(--rose-deep)">{{ $cat->vendors_count }} vendors
                            →</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection