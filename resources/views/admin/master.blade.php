@include('admin.components.head')

@include('admin.components.nav')

@include('admin.components.sidebar')

<div class="content-wrapper">

    @yield('content')

</div>

@include('admin.components.footer-control-sidebar')


@include('admin.components.js')
