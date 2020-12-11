<div class="hero py-32 bg-gray-900 text-white relative">
    <div class="hero-video-wrapper absolute left-0 bottom-0 h-full w-full overflow-hidden hidden lg:block">
        <video class="absolute bottom-0 z-0 w-full" autoplay loop muted id="herovideo">
            <source src="{{ Theme::image('drive247-bg-video.mp4') }}" type="video/mp4">
        </video>
    </div>

    <div class="container relative">
        <h1 class="text-5xl font-bold">{!! $block->headingText !!}</h1>
        @if(!empty($block->bullets))
        <ul class="list-checks mt-6">
            @foreach($block->bullets as $bullet)
            <li class="text-xl font-medium mb-4 last:mb-0 pl-8 relative">{{ $bullet }}</li>
            @endforeach
        </ul>
        @endif

        <a href="{{ url('prices') }}" class="mt-8 text-xl text-white bg-red-700 rounded shadow-sm px-6 py-3 inline-block font-bold duration-300 transition-colors hover:bg-red-800">
            Book now <i class="far fa-long-arrow-right ml-2"></i>
        </a>
    </div>
</div>