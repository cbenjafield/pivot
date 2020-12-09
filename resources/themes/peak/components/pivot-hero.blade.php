<div class="hero py-32 bg-gray-900 text-white relative">
    <div class="container relative">
        <h1 class="text-5xl font-bold">{!! $block->headingText !!}</h1>
        @if(!empty($block->bullets))
        <ul class="list-checks mt-6">
            @foreach($block->bullets as $bullet)
            <li class="text-xl font-medium mb-4 last:mb-0 pl-8 relative">{{ $bullet }}</li>
            @endforeach
        </ul>
        @endif

        <a href="{{ url('areas-we-cover') }}" class="mt-8 text-xl text-white bg-teal-500 rounded shadow-sm px-6 py-3 inline-block font-bold duration-300 transition-colors hover:bg-teal-800">
            Find out more <i class="far fa-long-arrow-right ml-2"></i>
        </a>
    </div>
</div>