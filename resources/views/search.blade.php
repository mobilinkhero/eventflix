@extends('layouts.app')
@section('title', 'Search: ' . $q . ' — EventsWally')

@section('body')
    <div class="ph">
        <div class="wrap">
            <div class="crumb"><a href="{{ route('home') }}">Home</a> <span>›</span> Search</div>
            <h1>Search results</h1>
            @if($q)<p>{{ $vendors->total() }} results for "{{ $q }}"</p>@endif
        </div>
    </div>
    <section class="sec">
        <div class="wrap">
            <form action="{{ route('search') }}" method="GET"
                style="max-width:420px;margin-bottom:1.75rem;position:relative">
                <input type="text" name="q" value="{{ $q }}" placeholder="Search vendors..." class="fi"
                    style="padding-right:44px">
                <button type="submit"
                    style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--t3)">
                    <span class="material-icons-round">search</span>
                </button>
            </form>
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
                    <h3>No results</h3>
                    <p>Try a different search or <a href="{{ route('vendors.index') }}"
                            style="color:var(--c2);text-decoration:underline">browse all vendors</a>.</p>
                </div>
            @endif
        </div>
    </section>
@endsection