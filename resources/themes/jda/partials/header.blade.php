<header class="relative shadow-lg z-50 bg-true-dark-gray">
    <div class="relative">
        <div class="h-10 bg-true-gray">
            <div class="container h-10 flex items-center md:justify-end">
                <div class="text-right flex item-center justify-end space-x-4 h-10">
                    <a href="tel:01908764677" class="text-white font-semibold inline-flex items-center space-x-2">
                        <i class="far fa-phone-alt text-red-700"></i> <span>01908 533 023</span>
                    </a>
                    <a href="mailto:info@johnsonsdrivingacademy.co.uk" class="text-white font-semibold inline-flex items-center space-x-2">
                        <i class="far fa-at text-red-700"></i> <span>info@johnsonsdrivingacademy.co.uk</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="container flex items-center h-24">
            <div class="flex-1 md:flex-none md:w-1/5">
                <div class="logo py-5">
                    {!! Theme::logo() !!}
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