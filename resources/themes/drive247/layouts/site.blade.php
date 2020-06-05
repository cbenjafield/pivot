<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Home' }} - {{ $website->title }}</title>
    <script src="https://kit.fontawesome.com/f2f28012e7.js" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ asset(mix('css/site.css')) }}" rel="stylesheet">
    <link href="{{ Theme::styles() }}" rel="stylesheet">
</head>
<body>
    
    <div class="min-h-screen bg-white" id="site">
        @include(Theme::partial('header'))
        @yield('content')
        @include(Theme::partial('footer'))
    </div>

    <script src="{{ asset(mix('js/site.js')) }}">

</body>
</html>