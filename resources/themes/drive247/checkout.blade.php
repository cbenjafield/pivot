@extends(Theme::layout('site'))
@section('title', 'Checkout')

@section('content')

<div class="page-header py-20 bg-gray-900">
    <div class="container relative">
        <h1 class="text-white text-5xl font-bold">Checkout</h1>
    </div>
</div>

<div class="py-10">

    <div class="container mx-auto">
        <div class="max-w-4xl">
            <div class="block">
                <checkout-form></checkout-form>
            </div>
        </div>
    </div>

</div>

@endsection
