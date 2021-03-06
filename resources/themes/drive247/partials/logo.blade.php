@if($website->hasLogo())
<a href="{{ $website->domain() }}" class="flex items-center">
    <img src="{{ $website->logo_path }}" alt="{{ $website->title }} Logo" class="h-8 block">
</a>
@else
<a href="{{ $website->domain() }}" class="flex items-center">
    <img src="{{ Theme::image('drive247-logo-standalone.png') }}" alt="{{ $website->title }} Logo" class="h-8 block">
</a>
@endif