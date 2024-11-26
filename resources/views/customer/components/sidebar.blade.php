<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{ asset('admin/dist/img/logo.png') }}" alt="AdminLTE Logo" class="elevation-3"
            style="opacity: .8; background-color:azure; width:235px; height: 65px; padding: 10px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin/dist/img/tiny-logo.png') }}" class="img-circle elevation-2"
                    style="background-color: wheat;" alt="User Image">
            </div>
            <div class="info">
                <a href="" class="d-block">{{ Auth::guard('customer')->user()->name }}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('complete.profile') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('order.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Order
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('order.list', ['customer_id' => Auth::guard('customer')->user()->id]) }}"
                        class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Order List
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
