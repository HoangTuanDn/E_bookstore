<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{auth()->guard('admin')->user()->image_path}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Dn 2021</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('categories.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Danh mục
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Sản phẩm
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('orders.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Đơn hàng
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('ships.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-shipping-fast"></i>
                        <p>
                            Vận chuyển
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('coupons.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-donate"></i>
                        <p>
                            Mã Giảm giá
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Quản trị viên
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            Vai trò
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('permissions.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-eye-slash"></i>
                        <p>
                            Quyền truy cập
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('settings.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            cài đặt
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('menus.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Menus
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('sliders.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-image"></i>
                        <p>
                            slider
                        </p>
                    </a>
                </li>
            </ul>
        </nav>


        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>