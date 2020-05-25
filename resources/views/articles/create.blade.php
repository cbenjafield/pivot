@extends('layouts.article')
@section('title', "Add Article — {$website->tld}")

@section('content')
<form class="flex items-stretch w-full" action="{{ route('articles.store', [$website->id]) }}" id="createArticleForm">
    <div class="flex-1 bg-white relative">
        <div class="md:flex md:items-center h-16">
            <label class="md:w-1/6 text-gray-500 md:p-3" for="title">
                Title
            </label>
            <div class="flex-1">
                <input id="title" name="title" value="{{ old('title') }}" class="flex-1 h-16 block w-full rounded-none border-l border-gray-200 transition duration-150 ease-in-out sm:leading-5 outline-none px-3 text-base" placeholder="Enter title" @change="$root.slugify($event.target.value, '#slug')" />
            </div>
        </div>
        <div class="md:flex md:items-center h-16 border-t border-gray-200">
            <label class="md:w-1/6 text-gray-500 md:p-3" for="slug">
                Slug
            </label>
            <div class="flex-1">
                <input id="slug" name="slug" value="{{ old('slug') }}" class="flex-1 h-16 block w-full rounded-none border-l border-gray-200 transition duration-150 ease-in-out sm:leading-5 outline-none px-3 text-base" placeholder="Enter slug" />
            </div>
        </div>
        <editor ref="ArticleEditor" />
    </div>

    <div class="w-1/3">
        <div class="w-full p-3">
            <div class="w-full mb-4">
                <span class="relative z-0 inline-flex shadow-sm w-full">
                    <button type="button"
                        class="relative flex-1 inline-flex items-center px-4 py-3 rounded-l-md border border-gray-300 bg-white text-lg leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                        @click.prevent="saveDraft"
                    >
                        Save as draft
                    </button>
                    <span class="-ml-px relative block">
                        <button type="button"
                            class="relative inline-flex items-center px-2 py-3 rounded-r-md border border-gray-300 bg-white text-lg leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                            @click.prevent="isArticleSaveOpen =! isArticleSaveOpen"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <transition
                            enter-active-class="transition ease-out duration-100"
                            enter-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95"
                        >
                            <div class="origin-top-right absolute right-0 mt-2 -mr-1 w-56 rounded-md shadow-lg" v-show="isArticleSaveOpen">
                                <div class="rounded-md bg-white shadow-xs">
                                    <div class="py-1">
                                        <button type="button"
                                            class="block text-left w-full px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                            @click.prevent="savePublish"
                                        >
                                            Save and publish
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </span>
                </span>
            </div>
            <div class="w-full border-t border-dashed border-gray-200 pt-4">
                <input type="hidden" name="status" id="status" value="drafted">
                <div class="flex rounded-md shadow-sm mb-2">
                    <button type="button" class="inline-flex w-full items-center px-4 py-2 border border-gray-300 text-base leading-6 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                        <i class="far fa-image-polaroid fa-fw mr-2"></i> Insert Image
                    </button>
                </div>
                <div class="flex rounded-md shadow-sm mb-2">
                    <button type="button" class="inline-flex w-full items-center px-4 py-2 border border-gray-300 text-base leading-6 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" @click.prevent="$root.busEvent('article-insert-row')">
                        <i class="far fa-arrows-h fa-fw mr-2"></i> Insert Row
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection