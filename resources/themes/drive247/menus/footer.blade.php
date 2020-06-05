<nav class="-mx-5 -my-2 flex flex-wrap justify-center" id="menu-{{ $menu->id }}">
    @foreach($menu->items as $item)
    <a href="{{ $item->destination }}" class="block text-xl leading-none font-medium text-white px-5 border-r border-red-600 last:border-r-0 hover:text-gray-300 transition-colors duration-200">
        {{ $item->title }}
    </a>
    @endforeach
</nav>