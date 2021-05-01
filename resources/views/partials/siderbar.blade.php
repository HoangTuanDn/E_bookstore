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
                <a href="#" class="d-block">{{auth()->guard('admin')->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        @can('category-viewAny')
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
        @endcan

        @can('product-viewAny')
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Sản phẩm
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        @endcan

        @can('order-viewAny')
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('orders.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                        <p>
                            Đơn hàng
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        @endcan

        @can('ship-viewAny')
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
        @endcan

        @can('coupon-viewAny')
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
        @endcan

        @can('admin-viewAny')
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
        @endcan

        @can('role-viewAny')
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
        @endcan

        @can('permission-viewAny')
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
        @endcan

        @can('setting-viewAny')
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('settings.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            cài đặt
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        @endcan

        @can('menu-viewAny')
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
        @endcan

        @can('slider-viewAny')
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
        @endcan

        @can('blog_category-viewAny')
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('blog_categories.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                            Thể loại bài viết
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        @endcan

        @can('blog-viewAny')
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('blogs.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>
                            Bài viết
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        @endcan

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>