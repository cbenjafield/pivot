@if(is_null($health))
    <span class="w-{{ $width }} h-{{ $height }} text-{{ $size }} rounded-full inline-flex items-center justify-center border-2 border-gray-300 text-gray-300" title="Unknown">
        <i class="fas fa-question fa-fw"></i>
    </span>
@else
    @switch($health)
        @case(1)
            <span class="w-{{ $width }} h-{{ $height }} text-{{ $size }} rounded-full inline-flex items-center justify-center border-2 border-teal-300 text-teal-300" title="Live">
                <i class="fas fa-check fa-fw"></i>
            </span>
            @break
        @case(0)
            <span class="w-{{ $width }} h-{{ $height }} text-{{ $size }} rounded-full inline-flex items-center justify-center border-2 border-red-500 text-red-500" title="Error">
                <i class="fas fa-times fa-fw"></i>
            </span>
            @break
    @endswitch
@endif