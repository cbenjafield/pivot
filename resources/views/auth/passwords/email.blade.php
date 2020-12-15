@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    <div class="w-full flex justify-center">
        <div class="max-w-lg w-full">
            <div class="rounded-md shadow overflow-hidden">
                <div class="p-3 bg-white border-b border-gray-200 text-lg font-semibold">{{ __('Reset Password') }}</div>

                <div class="p-3 bg-white">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div>
                            <label for="email" class="font-semibold">{{ __('E-Mail Address') }}</label>

                            <div class="mt-1">
                                <input id="email" type="email" class="form-input w-full transition duration-150 ease-in-out @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="rounded-md shadow-sm p-3 text-white px-6 py-3 w-full bg-indigo-600">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
