@extends('layouts.app')
@section('title', $category->name . ' Vendors — EventsWally')

@section('body')
    <div class="ph">
        <div class="wrap">
            <div class="crumb"><a href="{{ route('home') }}">Home</a> <span>›</span> <a
                    href="{{ route('categories.index') }}">Categories</a> <span>›</span> {{ $category->name }}</div>
            <h1>{{ $category->name }}</h1>
            <p>{{ $vendors->total() }} {{ strtolower($category->name) }} vendors across Pakistan</p>
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
                    <h3>No vendors yet</h3>
                    <p>We're adding new vendors regularly — check back soon!</p>
                </div>
            @endif
        </div>
    </section>
@endsection