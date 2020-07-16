@extends('layouts.site')
@section('title', 'Create a contact form')
@section('main-class', 'flex-1 relative z-0 overflow-y-auto pb-6 focus:outline-none')

@section('content-header')
<div class="md:flex md:items-center md:justify-between bg-white py-6 px-6 border-b border-gray-200">
    <div class="flex-1 min-w-0">
        <h1 class="text-2xl font-bold leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">
            <span class="hidden md:inline">Add </span>New Contact Form
        </h1>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4">
        <span class="shadow-sm rounded-md">
            <a href="{{ route('contact.index', $website->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                <i class="far fa-long-arrow-left mr-2"></i> Back to Contact Forms
            </a>
        </span>
    </div>
</div>
@endsection

@section('content')
<create-contact-form :website="{{ $website->id }}"></create-contact-form>
@endsection