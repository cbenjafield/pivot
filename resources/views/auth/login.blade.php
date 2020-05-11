@extends('layouts.app')
@section('title', 'Login')

@section('content')

<div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
    <div class="font-extrabold text-6xl ml-3 text-gray-900 flex items-center justify-center">piv<i class="fad fa-circle-notch text-4xl text-indigo-600 mt-4"></i>t</div>
    <h2 class="mt-6 text-3xl leading-9 font-bold text-gray-900">
        Sign in to your account
    </h2>
</div>

<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form action="{{ route('login') }}" method="POST">
            <div>
                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                    Email address
                </label>
                <div class="mt-1 rounded-md shadow-sm">
                    <input id="email" type="email" value="{{ old('email') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
            </div>
            <div class="mt-6">
                <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                    Password
                </label>
                <div class="mt-1 rounded-md shadow-sm">
                    <input id="password" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
            </div>
            <div class="mt-6 flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                    <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900"{{ old('remember') == 1 ? ' checked' : '' }}>
                        Remember me
                    </label>
                </div>

                <div class="text-sm leading-5">
                    <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Forgot your password?
                    </a>
                </div>
            </div>
            <div class="mt-6">
                <span class="block w-full rounded-md shadow-sm">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Sign in
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>

@endsection
