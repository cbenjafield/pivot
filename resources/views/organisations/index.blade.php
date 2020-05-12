@extends('layouts.sidebar')
@section('title', 'Organisations')

@section('content-header')
<div class="max-w-7xl mx-auto px-4 flex items-center sm:px-6 md:px-8">
    <div class="flex-1">
        <h1 class="text-2xl font-semibold text-gray-900">Organisations</h1>
    </div>
    <div>
        <span class="inline-flex rounded-md shadow-sm">
            <a href="{{ route('organisations.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
              <i class="far fa-plus mr-2"></i> Add New
            </a>
        </span>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md mt-6">
  <ul>
    @foreach($organisations as $organisation)
    <li class="border-t border-gray-200 first:border-t-0">
      <a href="{{ route('organisations.show', $organisation->id) }}" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <div class="min-w-0 flex-1 flex items-center">
            <div class="flex-shrink-0">
              <span class="h-12 w-12 flex items-center justify-center rounded-full bg-gray-800 text-white font-bold text-2xl">{{ $organisation->initial }}</span>
            </div>
            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-10">
              <div>
                <div class="text-sm leading-5 font-medium text-indigo-600 truncate">{{ $organisation->name }}</div>
                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                  <i class="flex-shrink-0 mr-1.5 text-gray-400 far fa-map-marker-alt"></i>
                  <span class="truncate">{{ $organisation->string_address }}</span>
                </div>
              </div>
              <div class="hidden md:block">
                <div>
                  <div class="text-sm leading-5 text-gray-900">
                    <div class="leading-5 font-medium truncate">Created on</div>
                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                      <i class="flex-shrink-0 mr-1.5 text-gray-400 far fa-calendar-alt"></i>
                      <time class="block" datetime="{{ $organisation->created_at->format('Y-m-d H:i') }}">{{ $organisation->created_at->format('jS F Y') }}</time>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
      </a>
    </li>
    @endforeach
  </ul>
</div>

@endsection