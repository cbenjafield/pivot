<nav class="navigation" id="menu-{{ $menu->id }}">
    @foreach($menu->items as $item)
    <a href="{{ url($item->destination) }}">{{ $item->title }}</a>
    @endforeach
    <a href="{{ url('basket') }}" class="basket">
        <span class="basket-label">
            Basket
        </span>
        <span class="w-6 h-6 bg-orange-500 text-white font-medium rounded-full overflow-hidden" v-if="basketCount">
            @{{ basketCount }}
        </span>
    </a>
</nav>