@extends(Theme::layout('site'))
@section('title', 'Basket')

@section('content')

<div class="page-header py-20 bg-gray-900">
    <div class="container relative">
        <h1 class="text-white text-5xl font-bold">Basket</h1>
    </div>
</div>

<div class="py-10 page-content">

    <div class="container mx-auto">
        <basket-contents :contents="{{ Basket::contents() }}" :subtotal="{{ Basket::total(false) }}" :total="{{ Basket::total() }}" :fee="{{ Basket::fee() }}" />
    </div>

</div>

@endsection
