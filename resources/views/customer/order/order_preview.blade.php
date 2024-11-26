@extends('customer.master')

@section('content')

    <div class="lg:mx-5">
        <div class="container mx-auto mt-4 p-2 px-5 md:p-6 rounded-lg shadow-md max-w-full bg-white">
            <h5 class="text-3xl font-bold text-center bg-orange-600 text-white mb-4 p-2 rounded mt-2">Checkout</h5>

            <div class="order-details">
                @if (!empty($orderData))
                    <h6 class="text-xl font-semibold mb-4">Order Details</h6>
                    <p><strong>Customer ID:</strong> {{ $orderData['customer_id'] }}</p>
                    <h6 class="text-lg font-semibold mt-4">Items:</h6>

                    @php $totalAmount = 0; @endphp
                    @foreach ($orderData['items'] as $item)
                        <div class="border border-gray-300 rounded-lg p-4 mb-4 shadow-sm bg-gray-50">
                            <p class="text-lg font-semibold"><strong>Product Name:</strong> {{ $item['product_name'] }}</p>
                            <p><strong>Product Link:</strong> <a href="{{ $item['product_link'] }}"
                                    class="text-blue-600 hover:underline">{{ $item['product_link'] }}</a></p>
                            <p><strong>Size:</strong> {{ $item['size'] }}</p>
                            <p><strong>Quantity:</strong> {{ $item['quantity'] }}</p>
                            <p><strong>Price (INR):</strong> ₹{{ number_format($item['price_inr'], 2) }}</p>
                            <p><strong>Price (BDT):</strong> ৳{{ number_format($item['price_bdt'], 2) }}</p>
                            <p><strong>Note:</strong> {{ $item['note'] }}</p>

                            @if (!empty($item['files']))
                                <div class="mt-2">
                                    <strong>Uploaded Files:</strong>
                                    <ul class="list-disc list-inside mt-1">
                                        @foreach ($item['files'] as $file)
                                            <li class="flex items-center mb-2">
                                                @php
                                                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                                                @endphp
                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                                    <img src="{{ asset('storage/' . $file) }}"
                                                        alt="{{ $item['product_name'] }} Image"
                                                        class="w-16 h-16 object-cover rounded mr-2">
                                                @endif
                                                {{-- <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($file) }}</a> --}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        @php
                            $totalAmount += $item['price_bdt'] * $item['quantity']; // Accumulate total amount
                        @endphp
                    @endforeach

                    <h6 class="text-xl font-bold mt-4">Total Amount: ৳ {{ number_format($totalAmount, 2) }}</h6>

                    <form action="{{ route('order.confirm') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition">Confirm
                            Order</button>
                    </form>
                @else
                    <p class="text-red-600">No order data found. Please go back and create an order.</p>
                @endif
            </div>
        </div>
    </div>

@endsection
