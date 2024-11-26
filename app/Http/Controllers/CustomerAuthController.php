<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerAuthController extends Controller
{
    public function showRegistrationForm()
    {
        // return view('auth.customer-register');
        return view('customer.auth.registration');
    }


    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'mobile' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new Customer instance
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->password = Hash::make($request->password);

        // Save the customer and handle the result
        if ($customer->save()) {
            Auth::guard('customer')->login($customer);
            return redirect()->route('customer.dashboard');
        }

      
        Log::error('Failed to save customer', ['customer_data' => $customer->toArray()]);

        return back()->withErrors(['error' => 'Failed to save customer']);
    }

    public function showLoginForm()
    {
        // return view('auth.customer-login');
        return view('customer.auth.login');
       
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('message', 'Successfully logged out!');
    }
}
