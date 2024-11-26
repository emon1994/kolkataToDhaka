<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    const INR_TO_BDT_CONVERSION_RATE = 1.16; // Define conversion rate here

    public function create()
    {
        return view('customer.order.create');
    }

    public function saveToSession(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'customer_id' => 'required|string|max:255',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.product_link' => 'required|url',
            'items.*.size' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_inr' => 'required|numeric|min:0',
            'items.*.price_bdt' => 'required|numeric|min:0',
            'items.*.note' => 'nullable|string|max:500',
            'items.*.files.*' => 'nullable|file|mimes:jpg,png,pdf,webp|max:2048',
        ]);

        // Prepare order data
        $orderData = [
            'customer_id' => $request->customer_id,
            'items' => [],
        ];

        foreach ($request->items as $index => $item) {
            $files = $request->file("items.$index.files");
            $fileNames = [];

            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                        // Store the file in the 'public/files' directory
                        $filePath = $file->store('files', 'public');
                        $fileNames[] = $filePath; // Store the file path relative to the public storage
                    }
                }
            }

            $orderData['items'][] = [
                'product_name' => $item['product_name'],
                'product_link' => $item['product_link'],
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'price_inr' => $item['price_inr'],
                'price_bdt' => $item['price_bdt'],
                'note' => $item['note'],
                'files' => $fileNames, // Store file paths
            ];
        }

        // Store order data in session
        Session::put('order_data', $orderData);

        // Redirect to checkout page
        return redirect()->route('order.checkout');
    }

    public function checkout()
    {
        $orderData = Session::get('order_data', null); // Default to null
        if (is_null($orderData)) {
            return redirect()->route('order.create')->with('error', 'No order data found in session.');
        }
        return view('customer.order.order_preview', compact('orderData'));
    }

    public function confirm(Request $request)
    {
        // Get the order data from the session
        $orderData = Session::get('order_data', null);

        // Check if order data exists
        if (is_null($orderData) || empty($orderData['items'])) {
            return redirect()->route('order.create')->with('error', 'No order data found in session.');
        }

        // Create the order
        $order = Order::create([
            'customer_id' => $orderData['customer_id'],
            'status' => 'pending', // Set default status
        ]);

        // Process each order item
        foreach ($orderData['items'] as $itemData) {
            // Create the order item
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $itemData['product_name'],
                'product_link' => $itemData['product_link'],
                'size' => $itemData['size'],
                'quantity' => $itemData['quantity'],
                'price_inr' => $itemData['price_inr'],
                'price_bdt' => $itemData['price_bdt'],
                'note' => $itemData['note'],
                'status' => 'pending', // Set default status
            ]);

            // Handle file uploads
            if (!empty($itemData['files'])) {
                foreach ($itemData['files'] as $filePath) {
                    // Directly use the file path string
                    OrderItemFile::create([
                        'file_path' => $filePath, // Use the stored path
                        'order_item_id' => $orderItem->id, // Associate with the OrderItem
                    ]);
                }
            }
        }

        // Clear session data
        Session::forget('order_data');

        return redirect()->route('order.list')->with('success', 'Order created successfully!');
    }

    public function list()
    {
        $customerId = auth()->guard('customer')->user()->id;

        // Fetch all orders along with their items
        $orders = Order::with('items.files')->where('customer_id', $customerId)->latest()->paginate(5);

        // Return the view with the orders data
        return view('customer.order.order-list', compact('orders'));
    }


    public function cancelItem($orderId, $itemId)
    {
        // Find the order item by its ID
        $orderItem = OrderItem::find($itemId);
    
        if ($orderItem && $orderItem->order_id == $orderId) {
            // Delete the order item
            $orderItem->delete();
    
            // Check if there are any more items in the order
            $order = Order::find($orderId);
            if ($order && $order->items()->count() == 0) {
                // If no items left, delete the order
                $order->delete();
            }
    
            return redirect()->route('order.list')->with('success', 'Order item canceled successfully!');
        }
    
        return redirect()->route('order.list')->with('error', 'Order item not found or cannot be canceled.');
    }
    
    

}
