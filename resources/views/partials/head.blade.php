<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
@hasSection('title')
<title>@yield('title') &mdash; {{ config('app.name') }}</title>
@else
<title>{{ config('app.name') }}</title>
@endif
<script src="https://kit.fontawesome.com/f2f28012e7.js" crossorigin="anonymous" defer></script>
<link rel="stylesheet" href="https://rsms.me/inter/inter.css">
<link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">