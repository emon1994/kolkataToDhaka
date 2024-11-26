@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5">
        <h2 class="text-xl font-bold">Create Order</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf<!-- resources/views/orders/create.blade.php -->
            @extends('layouts.app')
            
            @section('content')
            <div class="container">
                <h1>Create Order</h1>
                <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
            
                    <!-- Customer ID -->
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer ID</label>
                        <input type="text" class="form-control" name="customer_id" required>
                    </div>
            
                    <!-- Order Items -->
                    <div id="orderItems">
                        <h2>Order Items</h2>
                        <div class="order-item mb-3">
                            <h3>Item 1</h3>
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="items[0][product_name]" required>
            
                            <label for="product_link" class="form-label">Product Link</label>
                            <input type="url" class="form-control" name="items[0][product_link]" required>
            
                            <label for="size" class="form-label">Size</label>
                            <input type="text" class="form-control" name="items[0][size]" required>
            
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="items[0][quantity]" required>
            
                            <label for="price_inr" class="form-label">Price (INR)</label>
                            <input type="number" class="form-control" name="items[0][price_inr]" required>
            
                            <label for="price_bdt" class="form-label">Price (BDT)</label>
                            <input type="number" class="form-control" name="items[0][price_bdt]" required>
            
                            <label for="note" class="form-label">Note</label>
                            <input type="text" class="form-control" name="items[0][note]"></input>
            
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="items[0][status]">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
            
                            <label for="files" class="form-label">Upload Files</label>
                            <input type="file" class="form-control" name="items[0][files][]" multiple>
                        </div>
                    </div>
            
                    <button type="button" id="addItem" class="btn btn-secondary">Add Another Item</button>
                    <button type="submit" class="btn btn-primary">Create Order</button>
                </form>
            </div>
            
            <script>
                document.getElementById('addItem').addEventListener('click', function() {
                    const orderItems = document.getElementById('orderItems');
                    const itemCount = orderItems.getElementsByClassName('order-item').length;
            
                    const newItem = `
                        <div class="order-item mb-3">
                            <h3>Item ${itemCount + 1}</h3>
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="items[${itemCount}][product_name]" required>
            
                            <label for="product_link" class="form-label">Product Link</label>
                            <input type="url" class="form-control" name="items[${itemCount}][product_link]" required>
            
                            <label for="size" class="form-label">Size</label>
                            <input type="text" class="form-control" name="items[${itemCount}][size]" required>
            
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="items[${itemCount}][quantity]" required>
            
                            <label for="price_inr" class="form-label">Price (INR)</label>
                            <input type="number" class="form-control" name="items[${itemCount}][price_inr]" required>
            
                            <label for="price_bdt" class="form-label">Price (BDT)</label>
                            <input type="number" class="form-control" name="items[${itemCount}][price_bdt]" required>
            
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control" name="items[${itemCount}][note]"></textarea>
            
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="items[${itemCount}][status]">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
            
                            <label for="files" class="form-label">Upload Files</label>
                            <input type="file" class="form-control" name="items[${itemCount}][files][]" multiple>
                        </div>
                    `;
                    orderItems.insertAdjacentHTML('beforeend', newItem);
                });
            </script>
            @endsection
            
            <input type="hidden" name="customer_id" value="{{ Auth::id() }}">

            <div id="order-items-container">
                <div class="order-item border p-4 mb-4 rounded-md shadow-sm">
                    <h4 class="font-semibold">Item 1</h4>
                    <input type="text" name="orders[0][product_name]" placeholder="Product Name" required class="border p-2 w-full">
                    <input type="url" name="orders[0][product_link]" placeholder="Product Link" class="border p-2 w-full mt-2">
                    <input type="text" name="orders[0][size]" placeholder="Size" class="border p-2 w-full mt-2">
                    <input type="number" name="orders[0][quantity]" placeholder="Quantity" required class="border p-2 w-full mt-2">
                    <input type="number" name="orders[0][price_inr]" placeholder="Price in INR" required oninput="convertToBDT(this)" class="border p-2 w-full mt-2">
                    <input type="text" name="orders[0][note]" placeholder="Note" class="border p-2 w-full mt-2">
                    <input type="file" name="orders[0][files][]" multiple class="border p-2 w-full mt-2">
                    <select name="orders[0][status]" class="border p-2 w-full mt-2">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
            </div>

            <button type="button" id="add-order-item" class="bg-blue-500 text-white px-4 py-2 rounded">Add Another Item</button>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-4">Create Order</button>
        </form>
    </div>

    <script>
        document.getElementById('add-order-item').addEventListener('click', function() {
            const container = document.getElementById('order-items-container');
            const itemCount = container.children.length;
            const newItem = document.createElement('div');
            newItem.className = 'order-item border p-4 mb-4 rounded-md shadow-sm';
            newItem.innerHTML = `
                <h4 class="font-semibold">Item ${itemCount + 1}</h4>
                <input type="text" name="orders[${itemCount}][product_name]" placeholder="Product Name" required class="border p-2 w-full">
                <input type="url" name="orders[${itemCount}][product_link]" placeholder="Product Link" class="border p-2 w-full mt-2">
                <input type="text" name="orders[${itemCount}][size]" placeholder="Size" class="border p-2 w-full mt-2">
                <input type="number" name="orders[${itemCount}][quantity]" placeholder="Quantity" required class="border p-2 w-full mt-2">
                <input type="number" name="orders[${itemCount}][price_inr]" placeholder="Price in INR" required oninput="convertToBDT(this)" class="border p-2 w-full mt-2">
                <input type="text" name="orders[${itemCount}][note]" placeholder="Note" class="border p-2 w-full mt-2">
                <input type="file" name="orders[${itemCount}][files][]" multiple class="border p-2 w-full mt-2">
                <select name="orders[${itemCount}][status]" class="border p-2 w-full mt-2">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="canceled">Canceled</option>
                </select>
            `;
            container.appendChild(newItem);
        });

        function convertToBDT(input) {
            // Logic to convert INR to BDT if needed
        }
    </script>
@endsection
