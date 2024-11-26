@extends('customer.master')

@section('content')

<div class="lg:mx-5 p-4">
    <div class="container mx-auto mt-4 p-4 px-5 md:p-6 rounded-lg shadow-lg bg-white ">
        <h5 class="text-xl font-bold  bg-orange-600 text-white mb-6 p-3 rounded-lg">Create Order</h5>

        @if (session('success'))
            <div class="alert alert-success bg-green-100 text-green-800 p-4 rounded-md shadow mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('order.saveToSession') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <input type="hidden" name="customer_id" value="{{ auth()->user()->id }}">

            <div id="orderItems">
                <div class="order-item p-4 border border-gray-300 rounded-lg bg-gray-50 shadow-sm mb-4">
                    <p class="text-lg font-semibold text-orange-600 mb-2">Item 1</p>
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <input type="text" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[0][product_name]" placeholder="Product Name" required>
                        <input type="url" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[0][product_link]" placeholder="Product Link" required>
                        <input type="text" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[0][size]" placeholder="Size" required>
                        <input type="number" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[0][quantity]" placeholder="Quantity" required>
                        <input type="number" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[0][price_inr]" placeholder="Price (INR)" required oninput="calculatePriceBDT(this)">
                        <input type="number" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[0][price_bdt]" placeholder="Price (BDT)" required readonly>
                        <input type="text" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[0][note]" placeholder="Note">

                        <div class="relative">
                            <input type="file" id="fileUpload0" class="absolute inset-0 opacity-0 cursor-pointer" name="items[0][files][]" multiple onchange="displayFileNames(this)">
                            <label for="fileUpload0" class="flex items-center justify-between border border-gray-300 rounded-lg p-3 bg-gray-50 text-gray-600 cursor-pointer hover:bg-gray-100 transition">
                                <span>Add Image (single/multiple)</span>
                                <span id="fileNames0" class="text-gray-500 text-sm"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6" /></svg>
                            </label>
                        </div>
                    </div>

                    <button type="button" class="deleteItem bg-red-500 text-white font-semibold py-1 px-2 rounded-lg hover:bg-red-600 transition">Remove Item</button>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <button type="button" id="addItem" class="bg-orange-500 text-white font-semibold px-4 md:px-6 py-2 rounded-lg shadow hover:bg-orange-600 transition">Add Item</button>
                <button type="submit" class="bg-orange-600 text-white font-semibold py-2 px-4 md:px-6 rounded-lg shadow hover:bg-orange-700 transition"> Order</button>
            </div>
        </form>
    </div>
</div>

<script>
    const conversionRate = {{ \App\Http\Controllers\OrderController::INR_TO_BDT_CONVERSION_RATE }};

    function calculatePriceBDT(input) {
        const priceINR = parseFloat(input.value);
        const priceBDTInput = input.closest('.order-item').querySelector('input[name*="[price_bdt]"]');
        if (priceBDTInput) {
            priceBDTInput.value = (priceINR * conversionRate).toFixed(2);
        }
    }

    function displayFileNames(input) {
        const fileNamesDiv = document.getElementById(`fileNames${input.id.replace('fileUpload', '')}`);
        const files = Array.from(input.files).map(file => file.name).join(', ');
        fileNamesDiv.textContent = files ? `Selected: ${files}` : '';
    }

    document.getElementById('addItem').addEventListener('click', function() {
        const orderItems = document.getElementById('orderItems');
        const itemCount = orderItems.getElementsByClassName('order-item').length;

        const newItem = `
        <div class="order-item p-4 border border-gray-300 rounded-lg bg-gray-50 shadow-sm mb-4">
            <p class="text-lg font-semibold text-orange-600 mb-2">Item ${itemCount + 1}</p>
            <div class="grid grid-cols-1 gap-4 mb-4">
                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[${itemCount}][product_name]" placeholder="Product Name" required>
                <input type="url" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[${itemCount}][product_link]" placeholder="Product Link" required>
                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[${itemCount}][size]" placeholder="Size" required>
                <input type="number" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[${itemCount}][quantity]" placeholder="Quantity" required>
                <input type="number" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[${itemCount}][price_inr]" placeholder="Price (INR)" required oninput="calculatePriceBDT(this)">
                <input type="number" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[${itemCount}][price_bdt]" placeholder="Price (BDT)" required readonly>
                <input type="text" class="form-control block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring focus:ring-orange-200" name="items[${itemCount}][note]" placeholder="Note">

                <div class="relative">
                    <input type="file" id="fileUpload${itemCount}" class="absolute inset-0 opacity-0 cursor-pointer" name="items[${itemCount}][files][]" multiple onchange="displayFileNames(this)">
                    <label for="fileUpload${itemCount}" class="flex items-center justify-between border border-gray-300 rounded-lg p-3 bg-gray-50 text-gray-600 cursor-pointer hover:bg-gray-100 transition">
                        <span>Add Image (single/multiple)</span>
                        <span id="fileNames${itemCount}" class="text-gray-500 text-sm"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6" /></svg>
                    </label>
                </div>
            </div>
            <button type="button" class="deleteItem bg-red-500 text-white font-semibold py-1 px-2 rounded-lg hover:bg-red-600 transition">Remove Item</button>
        </div>
        `;
        orderItems.insertAdjacentHTML('beforeend', newItem);
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('deleteItem')) {
            event.target.closest('.order-item').remove();
        }
    });
</script>

@endsection
