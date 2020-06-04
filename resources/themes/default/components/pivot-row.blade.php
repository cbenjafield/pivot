<div class="pivot-row py-10">
    <div class="container">
        <div class="row flex flex-wrap -mx-6">
            @foreach($block->blocks as $column)
            {!! Article::block($column) !!}
            @endforeach
        </div>
    </div>
</div>