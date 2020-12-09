<div class="pass-rates w-full">
    <h2>
        {{ $block->heading }}
    </h2>
    <div>
        @foreach($block->bars as $bar)
        <div class="progress-bar bg-gray-200 rounded overflow-hidden h-10 mb-3 last:mb-0">
            <span class="text-white font-bold text-lg truncate flex items-center h-10 bg-red-600 px-2" style="width:{{ $bar['value'] }}%;">
                {{ $bar['title'] }} - {{ $bar['value'] }}%
            </span>
        </div>
        @endforeach
    </div>
    <div class="text-sm text-gray-500 mt-3">* Data from the last 3 months</div>
</div>