<!-- Off-canvas menu for mobile -->
<transition
    enter-active-class="transition-opacity ease-linear duration-300"
    enter-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition-opacity ease-linear duration-300"
    leave-class="opacity-100"
    leave-to-class="opacity-0"
>
    <div class="md:hidden z-40" v-show="isNavOpen">
        <div class="fixed inset-0 flex z-40">
            <transition
                enter-active-class="transition-opacity ease-linear duration-300"
                enter-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity ease-linear duration-300"
                leave-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div class="fixed inset-0" v-if="isNavOpen" @click.prevent="isNavOpen = false">
                    <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
                </div>
            </transition>
            <transition
                enter-active-class="transition ease-in-out duration-300 transform"
                enter-class="-translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transition ease-in-out duration-300 transform"
                leave-class="translate-x-0"
                leave-to-class="-translate-x-full"
            >
                <div 
                    class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white transition ease-in-out duration-300 z-40"
                    v-show="isNavOpen"
                >
                    <div class="absolute top-0 right-0 -mr-14 p-1">
                        <button class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600" aria-label="Close sidebar" @click.prevent="isNavOpen = false">
                            <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-start flex-shrink-0 px-4 font-extrabold text-3xl leading-none text-gray-900">
                        piv<i class="fad fa-circle-notch text-indigo-600 text-xl mt-2"></i>t
                    </div>
                    <div class="mt-5 flex-1 h-0 overflow-y-auto">
                        <nav class="px-2">
                            <a href="{{ route('sites.index') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                                <i class="far fa-long-arrow-left mr-2"></i> Back to all websites
                            </a>

                            <a href="{{ url('/') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                                <i class="far fa-home-lg mr-2"></i> Dashboard
                            </a>
                        </nav>
                    </div>
                </div>
            </transition>
            <div class="flex-shrink-0 w-14">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>
</transition>
<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 border-r border-gray-200 pt-5 pb-4 bg-white">
        <div class="flex items-center justify-start flex-shrink-0 px-4 font-extrabold text-3xl leading-none text-gray-900">
            piv<i class="fad fa-circle-notch text-indigo-600 text-xl mt-2"></i>t
        </div>
        <div class="mt-5 h-0 flex-1 flex flex-col overflow-y-auto">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <nav class="flex-1 px-2 bg-white">
                <a href="{{ url('/') }}" class="group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-900 rounded-md focus:outline-none bg-gray-100 transition ease-in-out duration-150">
                    <i class="far fa-fw fa-long-arrow-left mr-2"></i> Back to all websites
                </a>
                <a href="{{ url("websites/{$website->id}") }}" class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-900 rounded-md hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                    <i class="far fa-fw fa-cogs mr-2"></i> Settings
                </a>
                <a href="{{ url("websites/{$website->id}/articles?type=page") }}" class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-900 rounded-md hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                    <i class="far fa-fw fa-file mr-2"></i> Pages
                </a>
                <a href="{{ url("websites/{$website->id}/articles?type=post") }}" class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-900 rounded-md hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                    <i class="far fa-fw fa-newspaper mr-2"></i> Posts
                </a>
                <a href="{{ url("websites/{$website->id}/menus") }}" class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-900 rounded-md hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                    <i class="far fa-fw fa-bars mr-2"></i> Menus
                </a>
            </nav>
        </div>
    </div>
</div>