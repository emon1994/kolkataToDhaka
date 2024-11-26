@extends('customer.master')
@section('content')
    <div>
        <h1>Welcome, {{ Auth::guard('customer')->user()->name }}</h1>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

    </div>
@endsection
