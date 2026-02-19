@extends('layouts.app')
@section('title', 'Cities — EventsWally')

@section('body')
    <div class="ph">
        <div class="wrap">
            <div class="crumb"><a href="{{ route('home') }}">Home</a> <span>›</span> Cities</div>
            <h1>Cities We Serve</h1>
            <p>Find exceptional wedding vendors in your city</p>
        </div>
    </div>
    <section class="sec">
        <div class="wrap">
            <div class="g4">
                @foreach($cities as $city)
                    <a href="{{ route('cities.show', $city->slug) }}" class="card fi-a"
                        style="padding:2rem 1.25rem;text-align:center;display:block">
                        <div
                            style="width:48px;height:48px;margin:0 auto .85rem;border-radius:50%;background:var(--rose-pale);border:1px solid var(--rose-light);display:flex;align-items:center;justify-content:center">
                            <span class="material-icons-round" style="font-size:22px;color:var(--rose-deep)">location_on</span>
                        </div>
                        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:500;margin-bottom:.2rem">
                            {{ $city->name }}</h3>
                        <p style="font-size:.76rem;color:var(--t3);margin-bottom:.5rem">{{ $city->province }}</p>
                        <span style="font-size:.76rem;font-weight:600;color:var(--rose-deep)">{{ $city->vendors_count }} vendors
                            →</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection