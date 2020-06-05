<div class="pivot-row{{ !empty($block->sectionClassNames) ? " $block->sectionClassNames" : '' }}">
    <div class="container">
        <div class="row flex flex-wrap -mx-6">
            @foreach($block->blocks as $column)
            {!! Article::block($column) !!}
            @endforeach
        </div>
    </div>
</div>