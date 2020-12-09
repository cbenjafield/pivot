@extends(Theme::layout('site'))
@section('title', 'Checkout')

@section('content')

<div class="page-header py-20 bg-gray-900">
    <div class="container relative">
        <h1 class="text-white text-5xl font-bold">Checkout</h1>
        <p class="text-gray-200 text-xl">Checkout securely with PayPal</p>
    </div>
</div>

<div class="py-10 page-content">

    <div class="container mx-auto">
    <checkout-form :contents="{{ Basket::contents() }}" :subtotal="{{ Basket::total(false) }}" :total="{{ Basket::total() }}" :fee="{{ Basket::fee() }}" :paypal-status="{{ request()->filled('paypal-status') ? "'".request('paypal-status')."'" : 'null' }}" :inputs="{{ session()->has('previous_input') ? session('previous_input') : 'null' }}"></checkout-form>
    </div>

</div>

@endsection
