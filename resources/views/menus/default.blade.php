<nav class="navigation" id="main-menu">
    @foreach($pages as $menuPage)
    <a href="{{ $menuPage->url() }}">
        {{ $menuPage->title }}
    </a>
    @endforeach
</nav>