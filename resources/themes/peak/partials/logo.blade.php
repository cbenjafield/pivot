@if($website->hasLogo())
<a href="{{ $website->domain() }}" class="flex items-center">
    <img src="{{ $website->logo_path }}" alt="{{ $website->title }} Logo" class="h-14 block">
</a>
@else
<a href="{{ $website->domain() }}" class="flex items-center">
    <img src="{{ Theme::image('peakdriving-logo.png') }}" alt="{{ $website->title }} Logo" class="h-14 block">
</a>
@endif