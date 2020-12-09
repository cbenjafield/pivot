<footer class="bg-gray-800 border-t-4 border-teal-600">
    <div class="max-w-screen-xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
        {!! Theme::menu('secondary', 'footer') !!}

        <div class="mt-8 text-sm text-gray-300 flex items-center justify-center">
            <a href="{{ url('terms') }}" class="px-3 hover:underline">
                Terms & Conditions
            </a>
            <a href="{{ url('sitemap') }}" class="px-3 hover:underline">
                Sitemap
            </a>
            <a href="{{ url('xml-sitemap') }}" class="px-3 hover:underline">
                XML Sitemap
            </a>
        </div>

        <div class="mt-6 text-gray-300 text-sm text-center">
            &copy; {{ "{$website->title}, " . date('Y') . "." }}
        </span>
    </div>
</footer>