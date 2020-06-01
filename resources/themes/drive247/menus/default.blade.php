<nav class="navigation" id="menu-{{ $menu->id }}">
    @foreach($menu->items as $item)
    <a href="{{ url($item->destination) }}">{{ $item->title }}</a>
    @endforeach
</nav>