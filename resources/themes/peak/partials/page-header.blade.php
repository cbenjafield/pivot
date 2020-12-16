<div class="page-header py-32 bg-gray-900">
    <div class="container relative">
        <h1 class="text-white text-5xl font-bold">{{ $article->title }}</h1>
        @if(! empty($article->getMetaField('header_html')))
        <div class="page-header-extra mt-4 text-lg leading-relaxed">
            {!! $article->getMetaField('header_html') !!}
        </div>
        @endif
    </div>
</div>