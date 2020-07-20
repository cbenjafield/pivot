@extends(Theme::layout('site'))
@section('title', 'Basket')

@section('content')

<div class="page-header py-20 bg-gray-900">
    <div class="container relative">
        <h1 class="text-white text-5xl font-bold">Basket</h1>
    </div>
</div>

<div class="py-10">

    <div class="container mx-auto">
        <div class="max-w-4xl">
            <div class="block">
                @foreach(Basket::contents() as $product)
                <div class="border-b border-gray-200 py-4 grid grid-cols-4 gap-4">
                    <div class="col-span-2">
                        <span class="block font-medium text-gray-900 text-xl">{{ $product->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <button class="text-gray-800 bg-gray-200 text-base rounded-l p-1"><i class="far fa-minus fa-fw"></i></button>
                        <span class="text-gray-800 text-base bg-gray-200 mx-1 p-1 block w-12 text-center font-bold">{{ $product->quantity }}</span>
                        <button class="text-gray-800 bg-gray-200 text-base rounded-r p-1"><i class="far fa-plus fa-fw"></i></button>
                    </div>
                    <div class="text-xl font-bold text-right">
                        £{{ $product->subtotal }}
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-end mt-8">
                <div class="flex-1 mr-20 flex items-center">
                    <span class="text-base text-gray-600 block">
                        Total to pay
                    </span>
                    <span class="text-2xl text-gray-900 font-bold ml-4">
                        £{{ Basket::total() }}
                    </span>
                </div>
                <div>
                    <a href="{{ url('checkout') }}" class="py-3 px-6 bg-black text-white font-bold text-2xl rounded">
                        Checkout Now
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
