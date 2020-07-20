<div class="pivot-price shadow-sm rounded-sm overflow-hidden text-center bg-gray-100">
    <div class="price-heading p-3 bg-red-700">
        <span class="block text-xl font-bold text-white">{{ $block->content['title'] ?? '' }}</span>
    </div>
    <div class="p-3 h-24 text-base flex items-center justify-center text-gray-700">
        {{ $block->content['description'] ?? '' }}
    </div>
    <div class="p-3 text-2xl font-bold text-gray-900">£{{ isset($block->content['price']) ? str_replace('.00', '', number_format($block->content['price'], 2)) : '' }}</div>
    <basket-button :item="{{ $block->toJson() }}"></basket-button>
</div>
