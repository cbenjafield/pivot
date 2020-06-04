<div class="pivot-hero py-20 bg-gray-900 text-white">
    <div class="container">
        <h1 class="text-5xl font-bold">{!! $block->headingText !!}</h1>
        @if(!empty($block->bullets))
        <ul class="pivot-hero-list">
            @foreach($block->bullets as $bullet)
            <li>{{ $bullet }}</li>
            @endforeach
        </ul>
        @endif
    </div>
</div>