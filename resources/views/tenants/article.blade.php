<main id="main-content main-entity">
    <article class="article article-{{ $article->id }}">

        @foreach($article->getContent() as $block)
            {!! $block->render() !!}
        @endforeach

    </article>
</main>