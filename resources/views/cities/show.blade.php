@extends('layouts.app')
@section('title', $city->name . ' Wedding Vendors — EventsWally')

@section('body')
    <div class="ph">
        <div class="wrap">
            <div class="crumb"><a href="{{ route('home') }}">Home</a> <span>›</span> <a
                    href="{{ route('cities.index') }}">Cities</a> <span>›</span> {{ $city->name }}</div>
            <h1>{{ $city->name }}</h1>
            <p>{{ $vendors->total() }} wedding vendors in {{ $city->name }}, {{ $city->province }}</p>
        </div>
    </div>
    <section class="sec">
        <div class="wrap">
            @if($vendors->count())
                <div class="g3">
                    @foreach($vendors as $vendor)
                        @include('partials.vendor-card')
                    @endforeach
                </div>
                {{ $vendors->links('partials.pagination') }}
            @else
                <div class="empty">
                    <span class="material-icons-round mi">search_off</span>
                    <h3>No vendors in {{ $city->name }} yet</h3>
                    <p>We're growing fast — check back soon!</p>
                </div>
            @endif
        </div>
    </section>
@endsection