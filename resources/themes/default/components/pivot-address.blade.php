<div class="pivot-address">
    <div itemscope itemtype="https://schema.org/LocalBusiness">
        <meta itemprop="name" content="{{ $website->title }}">
        <address itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="not-italic">
            <span class="block" itemprop="streetAddress">{{ $website->street_address }}<br>{{ $website->locality }}</span>
            <span class="block" itemprop="addressLocality">{{ $website->city }}</span>
            <span class="block" itemprop="postalCode">{{ $website->postcode }}</span>
        </address>
    </div>
</div>