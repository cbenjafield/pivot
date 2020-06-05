<div class="pivot-column px-6 mb-8 md:mb-0 last:mb-0 md:w-{{ $block->width }}">
    @foreach($block->blocks as $block)
    {!! Article::block($block) !!}
    @endforeach
</div>