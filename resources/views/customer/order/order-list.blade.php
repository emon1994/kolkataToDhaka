@extends('customer.master')

@section('content')

    <div class="lg:mx-5 p-4">
        <div class="container mx-auto mt-4 p-4 rounded-lg shadow-lg bg-white">
            <h5 class="text-2xl font-bold text-center bg-orange-600 text-white mb-6 p-4 rounded-lg">Your Orders</h5>

            @if (session('success'))
                <div class="alert alert-success bg-green-100 text-green-800 p-4 rounded-md shadow mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($orders->isEmpty())
                <p class="text-center text-gray-600">No orders found.</p>
            @else
                @foreach ($orders as $order)
                    <div class="bg-gray-50 border border-gray-300 rounded-lg mb-4 p-4 shadow-md hover:shadow-lg transition">
                        <h6 class="font-semibold text-lg">Order ID: {{ $order->id }} | Status: {{ $order->status }}</h6>
                        <table class="min-w-full bg-white border border-gray-300 mt-2 hidden md:table">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">Product Name</th>
                                    <th class="border px-4 py-2">Images</th>
                                    <th class="border px-4 py-2">Quantity</th>
                                    <th class="border px-4 py-2">Price (INR)</th>
                                    <th class="border px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr class="hover:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $item->product_name }}</td>
                                        <td class="border px-4 py-2">
                                            @if ($item->files->isNotEmpty())
                                                <div class="flex space-x-2">
                                                    @foreach ($item->files as $file)
                                                        @php
                                                            $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                                            <img src="{{ asset('storage/' . $file->file_path) }}"
                                                                alt="{{ $item->product_name }} Image"
                                                                class="w-16 h-16 object-cover rounded shadow">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <span>No images uploaded</span>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $item->quantity }}</td>
                                        <td class="border px-4 py-2">{{ $item->price_inr }}</td>
                                        <td class="border px-4 py-2">
                                            @if ($order->status === 'pending')
                                                <form action="{{ route('order.item.cancel', [$order->id, $item->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to cancel this item?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-red-500 text-white font-semibold px-3 py-1 rounded hover:bg-red-600 transition">Cancel
                                                        Item</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Mobile View -->
                        <div class="block md:hidden mt-2">
                            @foreach ($order->items as $item)
                                <div
                                    class="border border-gray-300 rounded-lg mb-2 p-2 bg-white shadow-sm hover:shadow-md transition">
                                    <h6 class="font-semibold">{{ $item->product_name }}</h6>
                                    <div class="flex items-center space-x-2 mb-2">
                                        @if ($item->files->isNotEmpty())
                                            @foreach ($item->files as $file)
                                                @php
                                                    $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);
                                                @endphp
                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                                    <img src="{{ asset('storage/' . $file->file_path) }}"
                                                        alt="{{ $item->product_name }} Image"
                                                        class="w-16 h-16 object-cover rounded shadow">
                                                @endif
                                            @endforeach
                                        @else
                                            <span>No images uploaded</span>
                                        @endif
                                    </div>
                                    <p>Quantity: {{ $item->quantity }}</p>
                                    <p>Price (INR): {{ $item->price_inr }}</p>
                                    @if ($order->status === 'pending')
                                        <form action="{{ route('order.item.cancel', [$order->id, $item->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel this item?');">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white font-semibold px-3 py-1 rounded hover:bg-red-600 transition">Cancel
                                                Item</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">N/A</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $orders->links() }} <!-- Display pagination links -->
                </div>
            @endif
        </div>
    </div>

@endsection
