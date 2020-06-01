@extends('layouts.site')
@section('title', "Menus — {$website->tld}")

@section('content-header')
<div class="max-w-7xl mx-auto px-4 flex items-center sm:px-6 md:px-8">
    <div class="flex-1">
        <h1 class="text-2xl font-semibold text-gray-900">
            Menus
        </h1>
    </div>
    <div>
        <span class="inline-flex rounded-md shadow-sm">
            <a href="{{ route('menus.create', $website->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
              <i class="far fa-plus mr-2"></i> Add New
            </a>
        </span>
    </div>
</div>
@endsection

@section('content')

<div class="flex flex-col mt-6">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th
                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Position
                        </th>
                        <th
                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                            {{ $menu->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $menu->position }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500 text-center">
                            {{ $menu->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                            <a href="{{ route('menus.show', [$website->id, $menu->id]) }}" class="text-gray-500 inline-flex items-center justify-center bg-gray-100 rounded-md py-2 px-3">
                                <i class="far fa-angle-right text-lg"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white">
                        <td colspan="4" class="text-center text-base p-6 text-gray-500">
                            <i class="far fa-frown mr-2"></i> No menus have been added.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection