@extends('layouts.app')
@section('title', 'Confirm Password')

@section('content')
<div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
    <div class="font-extrabold text-6xl ml-3 text-gray-900 flex items-center justify-center">piv<i class="fad fa-circle-notch text-4xl text-indigo-600 mt-4"></i>t</div>
    <h2 class="mt-6 text-3xl leading-9 font-bold text-gray-900">
        Confirm your password
    </h2>
    <p class="mt-4 text-gray-500">This action requires you to enter your password again.</p>
</div>

<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form action="{{ url('password/confirm') }}" method="POST">
            <div>
                <label for="password" class="block text-sm font-medium leading-5 text-gray-700">Password</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="password" name="password" id="password" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="Enter your password" />
                </div>
            </div>
            <div class="mt-6">
                @csrf
                <span class="block w-full rounded-md shadow-sm">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Confirm
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>
@endsection