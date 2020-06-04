<div class="pivot-column px-6 w-{{ $block->width }}">
    @foreach($block->blocks as $block)
    {!! Article::block($block) !!}
    @endforeach
</div>