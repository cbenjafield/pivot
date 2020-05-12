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



@endsection