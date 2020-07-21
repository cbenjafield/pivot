@extends(Theme::layout('site'))
@section('title', 'Checkout')

@section('content')

<div class="page-header py-20 bg-gray-900">
    <div class="container relative">
        <h1 class="text-white text-5xl font-bold">Checkout</h1>
        <p class="text-gray-200 text-xl">Checkout securely with PayPal</p>
    </div>
</div>

<div class="py-10">

    <div class="container mx-auto">
        <checkout-form></checkout-form>
    </div>

</div>

@endsection
