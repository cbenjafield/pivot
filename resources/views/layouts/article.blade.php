<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="font-sans">
    <div class="h-screen flex overflow-hidden bg-gray-100" id="app">
        @include('partials.site-sidebar')
        <div class="flex items-stretch flex-col w-0 flex-1 overflow-hidden">
            @include('partials.header')
            <main class="flex-1 flex items-stretch h-full relative z-0 overflow-y-auto focus:outline-none" tabindex="0">
                @yield('content')
            </main>
        </div>
        @yield('global-components')
    </div>

    @include('partials.foot')
</body>
</html>