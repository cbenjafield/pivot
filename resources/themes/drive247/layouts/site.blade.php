<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @hasSection('title')
    <title>@yield('title') - {{ $website->title ?? 'Driving School' }}</title>
    @else
    <title>{{ $article->seoTitle() }}</title>
    @endif
    @if(isset($article) && !empty($article->description))
    <meta name="description" content="{{ $article->description }}">
    @endif
    <link rel="preconnect" href="https://kit.fontawesome.com">
    <script src="https://kit.fontawesome.com/f2f28012e7.js" crossorigin="anonymous" defer></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="{{ asset(mix('css/site.css')) }}" rel="stylesheet">
    <link href="{{ Theme::styles() }}" rel="stylesheet">
</head>
<body>

    <div class="min-h-screen bg-white" id="site">
        @include(Theme::partial('header'))
        @yield('content')
        @include(Theme::partial('footer'))
    </div>

    <script src="{{ asset(mix('js/site.js')) }}"></script>

</body>
</html>
