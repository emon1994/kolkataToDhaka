@extends('customer.master')

@section('content')
<div class="p-5">
    <div class="card p-5 shadow-lg" style="background-color: white;">
        <div class="card-header bg-orange-600 text-white">
            <h3 class="card-title text-xl font-semibold">Complete Profile</h3>
        </div>
        <!-- /.card-header -->
        
        @php
            $customer = Auth::guard('customer')->user();
            $customer_id = $customer ? $customer->id : null;
        @endphp

        <form action="{{ route('profile.additional', ['customer_id' => $customer_id]) }}" method="post" enctype="multipart/form-data" class="p-2">
            @csrf
            <div class="card-body bg-gray-50 shadow space-y-4">
                <div class="form-group">
                    <input type="text" name="country" class="form-control rounded-lg border-gray-300 focus:border-orange-600 focus:ring focus:ring-orange-200" placeholder="Enter Country" required>
                </div>
                <div class="form-group">
                    <input type="text" name="fb_id_link" class="form-control rounded-lg border-gray-300 focus:border-orange-600 focus:ring focus:ring-orange-200" placeholder="Enter Facebook ID Link" required>
                </div>
                <div class="form-group">
                    <input type="date" name="dob" class="form-control rounded-lg border-gray-300 focus:border-orange-600 focus:ring focus:ring-orange-200" required>
                </div>
                <div class="form-group">
                    <input type="text" name="address" class="form-control rounded-lg border-gray-300 focus:border-orange-600 focus:ring focus:ring-orange-200" placeholder="Enter Your Address" required>
                </div>
                <div class="form-group">
                    <input type="text" name="dress_size" class="form-control rounded-lg border-gray-300 focus:border-orange-600 focus:ring focus:ring-orange-200" placeholder="Enter Your Dress Size" required>
                </div>
                <div class="form-group">
                    <input type="text" name="shoe_size" class="form-control rounded-lg border-gray-300 focus:border-orange-600 focus:ring focus:ring-orange-200" placeholder="Enter Your Shoe Size" required>
                </div>
                <div class="form-group">
                    <input type="file" name="review" class="form-control rounded-lg border-gray-300 focus:border-orange-600 focus:ring focus:ring-orange-200" required>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn w-full py-2 rounded-lg bg-orange-600 text-white hover:bg-orange-700 transition">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
