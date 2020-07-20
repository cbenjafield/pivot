@extends('layouts.site')
@section('title', "Add Product — {$website->tld}")
@section('main-class', 'flex-1 relative z-0 overflow-y-auto pb-6 focus:outline-none')
@section('content-class', 'px-0')

@section('content-header')
<div class="md:flex md:items-center md:justify-between bg-white py-6 px-6 border-b border-gray-200">
    <div class="flex-1 min-w-0">
        <h1 class="text-2xl font-bold leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">
            <span class="hidden md:inline">Add </span>New Product
        </h1>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4">
        <span class="shadow-sm rounded-md">
            <a href="{{ url("websites/{$website->id}/products") }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                <i class="far fa-long-arrow-left mr-2"></i> Back to Products
            </a>
        </span>
    </div>
</div>
@endsection

@section('content')
<form action="{{ url("websites/{$website->id}/products") }}" method="POST">
    @csrf
    <div class="max-w-2xl mx-auto mt-10">
        <div class="shadow-sm rounded-md overflow-hidden">
            <div class="p-4 bg-white">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                    <label for="first_name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                        Name
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                            <input id="name" name="name" value="{{ old('name') }}" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="type" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                        Type
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                            <select id="type" class="block form-select w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                <option value="service">Service</option>
                                <option value="product">Product</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="price" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                        Price
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                            <div class="border border-gray-300 rounded-md flex items-center">
                                <span class="bg-white sm:text-sm sm:leading-5 px-4 border-r border-gray-300">£</span>
                                <input id="price" name="price" value="{{ old('price') }}" class="form-input block flex-1 transition duration-150 ease-in-out sm:text-sm sm:leading-5 rounded-l-none border-0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="limit" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                        Customer Limit
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                            <input type="number" id="limit" name="limit" value="{{ old('limit') }}" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="limit" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                        Duration (hours)
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                            <input type="duration" id="duration" name="duration" value="{{ old('duration') }}" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="limit" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                        Description
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                            <textarea rows="4" id="description" name="description" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">{{ old('duration') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 p-3">
                <div class="flex justify-start">
                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                            Save
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
