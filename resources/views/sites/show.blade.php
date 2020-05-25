@extends('layouts.site')
@section('title', $website->title)
@section('main-class', 'flex-1 relative z-0 overflow-y-auto pb-6 focus:outline-none')
@section('content-class', 'px-4 sm:px-6 md:px-8')

@section('content-header')
<div class="md:flex md:items-center md:justify-between bg-white py-6 px-6 border-b border-gray-200">
    <div class="flex-1 min-w-0">
        <h1 class="text-2xl font-bold leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate mb-2">
            {{ $website->title }}
        </h1>
        <a href="{{ $website->domain() }}" target="_blank" class="text-indigo-600">{{ $website->tld }} <i class="far fa-external-link-square ml-1"></i></a>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4 justify-start md:justify-center">
        <x-sites.health :health="$website->passed_health_check" size="3xl" width="16" height="16"/>
    </div>
</div>
@endsection

@section('content')
<div class="flex flex-wrap items-start -mx-5">
    <div class="w-full md:w-1/2 px-5">
        <x-sites.form :site="$website" id="editWebsiteForm">
            <h3 class="font-medium text-gray-900 mb-6 text-xl pb-4 border-b border-gray-200">Site Details</h3>
        </x-sites.form>
    </div>
    <div class="w-full md:w-1/2 sm:px-6">
        <form method="POST" action="{{ route('sites.details', $website->id) }}" id="siteDetailsForm">
            @csrf
            @method('PUT')
            <div class="shadow sm:rounded-md sm:overflow-hidden border border-gray-200 mt-6">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h3 class="font-medium text-gray-900 mb-6 text-xl pb-4 border-b border-gray-200">Site Options</h3>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="home_page_id" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px md:pt-2">
                            Home Page
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-xs rounded-md shadow-sm">
                                <select id="home_page_id" name="home_page_id" class="block form-select w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                    <option value="">Show an index of posts</option>
                                    <optgroup label="Pages">
                                        @foreach($rootPages as $page)
                                        <option value="{{ $page->id }}">{{ $page->title }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="shadow sm:rounded-md sm:overflow-hidden mt-10 border border-red-300">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                    <label for="name" class="block text-sm font-medium leading-5 text-red-700 sm:mt-px md:pt-2">
                        Delete Website?
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <span class="inline-flex rounded-md shadow-sm">
                            <a href="{{ route('sites.destroy', $website->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150">
                                <i class="far fa-trash mr-2"></i>
                                Delete this Website
                            </a>
                        </span>
                        <p class="mt-2 text-sm text-gray-500">This will remove all website data and files and is <strong>irreversible</strong>. Proceed with caution!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection