@extends('layouts.sidebar')
@section('title', 'Create an organisation')

@section('main-class', 'flex-1 relative z-0 overflow-y-auto pb-6 focus:outline-none')

@section('content-header')
<div class="md:flex md:items-center md:justify-between bg-white py-6 px-6 border-b border-gray-200">
    <div class="flex-1 min-w-0">
        <h1 class="text-2xl font-bold leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">
            <span class="hidden md:inline">Add </span>New Organisation 
        </h1>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4">
        <span class="shadow-sm rounded-md">
            <a href="{{ url('organisations') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                <i class="far fa-long-arrow-left mr-2"></i> Back to Organisations
            </a>
        </span>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('organisations.store') }}" method="POST">
    <div class="max-w-4xl mx-auto shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                <label for="name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Name of organisation
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input id="name" name="name" required maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    @error('name')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="description" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    About
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-lg flex rounded-md shadow-sm">
                        <textarea id="description" name="description" rows="3" class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
                    </div>
                    @error('description')
                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Write a few sentences about the organisation.</p>
                </div>
            </div>
            <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Address <small class="text-gray-400 inline-block ml-4">optional</small>
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input id="street_address" name="street_address" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Street Address" />
                        @error('street_address')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="locality" name="locality" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Locality" />
                        @error('locality')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="city" name="city" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="City" />
                        @error('city')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xs rounded-md shadow-sm mt-2">
                        <input id="postcode" name="postcode" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Post Code" />
                        @error('postcode')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <span class="inline-flex rounded-md shadow-sm">
                @csrf
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    Create
                </button>
            </span>
        </div>
    </div>
</form>
@endsection