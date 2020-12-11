<ul class="list-disc space-y-3">
    @if(! empty($articles->first()) && $articles->first()->type == 'page')
    <li>
        <a href="{{ Theme::url('/') }}">Home</a>
    </li>
    @endif
    @foreach($articles as $article)
    @if(! $article->isHome())
        <li>
            <a href="{{ $article->url }}">{{ $article->title }}</a>
        </li>
    @endif
    @endforeach
</ul>