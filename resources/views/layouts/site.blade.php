<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="font-sans">
    
    <div class="h-screen flex overflow-hidden bg-gray-100" id="app">
        @include('partials.site-sidebar')
        
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            @include('partials.header')
            @hasSection('main-class')
            <main class="@yield('main-class')" tabindex="0">
            @else
            <main class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0">
            @endif
                @yield('content-header')
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    @include('partials.alerts')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @include('partials.foot')
</body>
</html>