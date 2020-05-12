@extends('layouts.sidebar')
@section('title', $organisation->name)
@section('main-class', 'flex-1 relative z-0 overflow-y-auto pb-6 focus:outline-none')

@section('content-header')
<div class="md:flex md:items-center md:justify-between bg-white py-6 px-6 border-b border-gray-200">
    <div class="flex-1 min-w-0">
        <h1 class="text-2xl font-bold leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">
            {{ $organisation->name }}
        </h1>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4">
        <span class="shadow-sm rounded-md">
            <a href="{{ url('organisations') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                <i class="far fa-plus mr-2"></i> Add Another
            </a>
        </span>
        <span class="shadow-sm rounded-md md:ml-3">
            <button type="button" @click.prevent="submitForm('#editOrganisationForm')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out">
                Save Changes
            </button>
        </span>
    </div>
</div>
@endsection

@section('content')
<x-organisations.form :organisation="$organisation" id="editOrganisationForm" />

<div class="max-w-4xl mx-auto shadow sm:rounded-md sm:overflow-hidden mt-10 border border-red-300">
    <div class="px-4 py-5 bg-white sm:p-6">
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
            <label for="name" class="block text-sm font-medium leading-5 text-red-700 sm:mt-px md:pt-2">
                Delete Organisation?
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                @csrf
                @method('GET')
                <span class="inline-flex rounded-md shadow-sm">
                    <a href="{{ route('organisations.destroy', $organisation->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150">
                        <i class="far fa-trash mr-2"></i>
                        Delete this organisation
                    </a>
                </span>
                <p class="mt-2 text-sm text-gray-500">This action is irreversible. Proceed with caution!</p>
            </div>
        </div>
    </div>
</div>
@endsection