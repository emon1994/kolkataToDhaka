<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        return view('customer.dashboard');
    }


    public function completeProfile()
    {
        return view('customer.pages.complete_profile');
    }

    


    public function additionalProfile(Request $request, $customer_id)
    {
        // Validate the request
        $request->validate([
            'country' => 'nullable|string|max:255',
            'fb_id_link' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'dress_size' => 'nullable|string|max:255',
            'shoe_size' => 'nullable|string|max:255',
            'discount' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'review' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:50048',
        ]);

        // Find the customer by ID
        $customer = Customer::findOrFail($customer_id);

        $data = $request->only([
            'country',
            'fb_id_link',
            'dob',
            'address',
            'dress_size',
            'shoe_size',
            'discount',
            'status',
        ]);

        // Check if an review file was uploaded
        if ($request->hasFile('review')) {
            $originalFileName = $request->file('review')->getClientOriginalName();
            $fileExtension = $request->file('review')->getClientOriginalExtension();
            $uniqueFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . time() . '.' . $fileExtension;
            $path = $request->file('review')->storeAs('review', $uniqueFileName, 'public');

            // Check if the file was saved successfully
            if ($path) {
                // Store the file path in the database
                $data['review'] = $path;
            } else {
                return redirect()->back()->withErrors(['review' => 'File could not be saved.']);
            }
        }

        // Update the customer with the request data
        $customer->update($data);

        // Redirect or respond as needed
        return redirect()->back()->with('success', 'Additional information updated successfully.');
    }

   
   
   
   

}
