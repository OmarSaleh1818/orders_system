@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
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
                <li class="nav-header">الموظف</li>
                <li class="nav-item">
                    <a href="{{ route('applicant.view') }}" class="nav-link {{ ($route == 'applicant.view')? 'active' : '' }}">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            مقدم الطلب
                        </p>
                    </a>
                </li>
                <li class="nav-header">مدير الموظف</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link {{ ($route == '#')? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            معتمد الطلب
                        </p>
                    </a>
                </li>
                <li class="nav-header">المدير المالي</li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ ($route == '#')? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>معتمد الصرف</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('project.approved') }}" class="nav-link {{ ($route == '#')? 'active' : '' }}">
                        <i class="nav-icon fa fa-tasks" aria-hidden="true"></i>
                        <p>معتمد المشروع</p>
                    </a>
                </li>
                <li class="nav-header">المحاسب</li>
                <li class="nav-item">
                    <a href="" class="nav-link {{ ($route == '#')? 'active' : '' }}">
                        <i class="nav-icon fa fa-check-square" aria-hidden="true"></i>
                        <p class="text">منفذ الطلب</p>
                    </a>
                </li>
                <li class="nav-header">الاعدادات</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link { ($prefix == '/users')? 'active':'' }}">
                        <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
                        <p>
                            الاعدادات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sections') }}" class="nav-link {{ ($route == 'sections')? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الأقسام</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link {{ ($route == 'users')? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>المستخدمين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ ($route == '#')? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>صلاحيات المستخدمين</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">مدير المشروع</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link { ($prefix == '/users')? 'active':'' }}">
                        <i class="nav-icon fa fa-address-card" aria-hidden="true"></i>
                        <p>
                            مدير المشروع
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('project.view') }}" class="nav-link {{ ($route == 'project.view')? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>المشاريع </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link {{ ($route == 'users')? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>التقارير</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
