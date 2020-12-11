<ul class="list-disc space-y-3 pl-6">
    @foreach($articles as $article)
    <li>
        <a href="{{ $article->url }}">{{ ! $article->isHome() ? $article->title : 'Home' }}</a>
        @if($article->children->count() > 0)
        {!! Theme::makeSitemapChildrenListing($article->children) !!}
        @endif
    </li>
    @endforeach
</ul>