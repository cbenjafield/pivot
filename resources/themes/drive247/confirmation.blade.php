@extends(Theme::layout('site'))
@section('title', 'Payment Confirmation')

@section('content')

<div class="page-header py-20 bg-gray-900">
    <div class="container relative">
        <h1 class="text-white text-5xl font-bold">Payment Confirmation</h1>
        <p class="text-gray-200 text-xl">Your payment was successful!</p>
    </div>
</div>

<div class="py-10 page-content">

    <div class="container mx-auto">
        
        <div class="flex items-start flex-wrap -mx-6">
            <div class="w-2/3 px-6">
                <div>
                    <h2 class="text-2xl text-gray-900 font-bold">Thank you for choosing <span class="text-red-700">{{ $website->title }}</span></h2>
                    <p class="text-lg text-gray-700 mt-4">Your payment has been processed and is now on our system. We will get back to you ASAP to get your driving lessons booked in.</p>
                    <p class="text-lg text-gray-700 mt-4">The details of your payment are shown below.</p>
                </div>
                <div class="shadow rounded-md overflow-hidden mt-6">
                    <div class="p-4 bg-white text-base space-y-5">
                        <div class="grid grid-cols-3">
                            <div class="pt-1 text-gray-600">
                                Order ID
                            </div>
                            <div class="col-span-2 text-gray-900 font-semibold">
                                {{ $order->order_id }}
                            </div>
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="pt-1 text-gray-600">
                                Amount paid
                            </div>
                            <div class="col-span-2 text-gray-900 font-semibold">
                                £{{ $order->price }}
                            </div>
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="pt-1 text-gray-600">
                                Date of payment
                            </div>
                            <div class="col-span-2 text-gray-900 font-semibold">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection
