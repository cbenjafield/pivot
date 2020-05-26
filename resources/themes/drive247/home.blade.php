@extends(Theme::layout('site'))

@section('content')
<div class="hero relative bg-gray-900 text-white py-24 md:py-32 md:flex md:items-center md:justify-center">
    <div class="container">
        <h1 class="text-6xl font-bold">{{ $page->title }}</h1>
        <ul class="list-arrows mt-6 text-2xl font-medium">
            <li>Leicester City footballers choose us for a reason - pass first time and fast</li>
            <li>First driving lesson from £20, block bookings available too</li>
            <li>A staggering 92% first time pass rate</li>
        </ul>
    </div>
</div>

@endsection