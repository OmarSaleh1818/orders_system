@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
@endphp
<style>
    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
        background: #8F7055;
        color: #fff;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #004653">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('assets/dist/img/logo_ryadh.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"> الريادة الاجتماعية</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/usr.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="{{ url('/') }}" class="nav-link {{ ($route == 'dashboard')? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الصفحة الرئيسية
                        </p>
                    </a>
                </li>
                @can('طلبات الصرف')
                    <li class="nav-item">
                        <a href="{{ route('applicant.view') }}" class="nav-link {{ ($prefix == '/applicant')? 'active':'' }}">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>
                                طلبات الصرف
                            </p>
                        </a>
                    </li>
                @endcan
                @can('تسعير المشاريع')
                    <li class="nav-item">
                        <a href="{{ route('project.view') }}" class="nav-link {{ ($prefix == '/manager')? 'active':'' }}">
                            <i class="nav-icon fa fa-tasks" aria-hidden="true"></i>
                            <p>تسعير المشاريع </p>
                        </a>
                    </li>
                @endcan
                @can('المشاريع')
                    <li class="nav-item">
                        <a href="{{ route('project.open') }}" class="nav-link {{ ($prefix == '/project')? 'active':'' }}">
                            <i class="fa fa-product-hunt nav-icon"></i>
                            <p>المشاريع</p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route('invoices.view') }}" class="nav-link {{ ($route == 'invoices.view')? 'active' : '' }}">
                        <i class="fa fa-archive nav-icon"></i>
                        <p>إصدار الفواتير</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link {{ ($prefix == '/balance')? 'active':'' }}">
                        <i class="nav-icon fa fa-balance-scale" aria-hidden="true"></i>
                        <p>
                            الموازنات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('balance.public') }}" class="nav-link {{ ($route == 'balance.public')? 'active' : '' }}">
                                <i class="fa fa-hourglass nav-icon"></i>
                                <p>الموازنة العامة</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('balance.project') }}" class="nav-link {{ ($route == 'balance.project')? 'active' : '' }}">
                                <i class="fa fa-cubes nav-icon"></i>
                                <p>موازنة المشاريع</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('balance.setting') }}" class="nav-link {{ ($route == 'balance.setting')? 'active' : '' }}">
                                <i class="fa fa-cogs nav-icon"></i>
                                <p>إعدادات الموازنة</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @can('صلاحيات المستخدمين')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link {{ ($prefix == '/users')? 'active':'' }}">
                            <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
                            <p>
                                الاعدادات
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('sections') }}" class="nav-link {{ ($route == 'sections')? 'active' : '' }}">
                                    <i class="fa fa-puzzle-piece nav-icon"></i>
                                    <p>الأقسام</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/users') }}" class="nav-link {{ ($route == 'users')? 'active' : '' }}">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>قائمة المستخدمين</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/roles') }}" class="nav-link {{ ($route == 'roles')? 'active' : '' }}">
                                    <i class="fa fa-cube nav-icon"></i>
                                    <p>صلاحيات المستخدمين</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
