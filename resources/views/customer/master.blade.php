@include('customer.components.head')

@include('customer.components.nav')

@include('customer.components.sidebar')

<div class="content-wrapper">

    @yield('content')

</div>

{{-- @include('customer.components.footer-control-sidebar') --}}


@include('customer.components.js')
