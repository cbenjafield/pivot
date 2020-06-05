<header class="relative border-b border-gray-200 shadow-lg z-50">
    <div class="border-t-4 border-red-600 relative">
        <div class="container flex items-center h-24">
            <div class="flex-1 md:flex-none md:w-1/5">
                <div class="logo py-5">
                    {!! Theme::logo() !!}
                    <a href="tel:08452412884" class="flex items-center font-bold text-gray-900 text-lg md:text-sm mt-2">
                        <span class="hidden lg:inline-block">CALL:</span>
                        <span class="lg:hidden"><i class="far fa-phone-alt"></i></span>
                        <span class="text-red-600 ml-1 lg:ml-3">0845 241 2884</span>
                    </a>
                </div>
            </div>
            <div class="flex items-center md:hidden">
                <button class="inline-flex items-center justify-center text-3xl text-gray-800 p-4" @click.prevent="toggleMenu">
                    <i class="far fa-bars"></i>
                </button>
            </div>
            <div class="md:flex-1 ml-6 main-nav">
                {!! Theme::menu('primary') !!}
            </div>
        </div>
    </div>
</header>