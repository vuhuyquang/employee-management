<?php $menus = config('menu'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quản trị viên</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('ad123') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('ad123') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('ad123') }}/dist/css/adminlte.min.css">
    <!-- Nhúng css -->
    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{ Str::ucfirst(Auth::user()->quyen) }}</span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('getProfile') }}" class="dropdown-item">
                            <i class="fas fa-user-alt"></i> Hồ sơ cá nhân
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('getChangePassword') }}" class="dropdown-item">
                            <i class="fas fa-key"></i> Đổi mật khẩu
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('getLogout') }}" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../../index3.html" class="brand-link">
                <img src="{{ url('ad123') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span style="font-size: 14px;" class="brand-text font-weight-light">
                    @if (Auth::user()->quyen == 'admin')
                        Quản trị viên
                    @elseif (Auth::user()->quyen == 'manager')
                        Trưởng phòng {{ Auth::user()->phongbans->ten }}
                    @elseif (Auth::user()->quyen == 'employee')
                        Nhân viên
                    @endif
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (Auth::user()->anh_dai_dien == null)
                            <img src="{{ url('uploads') }}/avatar_default.png" alt="Avatar">
                        @else
                            <img src="{{ url('uploads') }}/{{ Auth::user()->anh_dai_dien }}" alt="Avatar">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('getProfile') }}" class="d-block">{{ Auth::user()->ho_ten }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    @if (Auth::check())


                        {{-- ADMIN --}}
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            @if (Auth::user()->quyen == 'admin')
                                @foreach ($menus as $item)
                                    @if ($item['label'] == 'Dashboard')
                                        <li class="nav-item menu-open">
                                            <a href="{{ route('home') }}" class="nav-link active">
                                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                                <p>
                                                    Dashboard
                                                </p>
                                            </a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon fas {{ $item['icon'] }}"></i>
                                                <p>
                                                    {{ $item['label'] }}
                                                    <i class="fas fa-angle-left right"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">
                                                @if (isset($item['items']))
                                                    @foreach ($item['items'] as $a)
                                                        <li class="nav-item">
                                                            <a href="{{ route($a['route']) }}"
                                                                class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>{{ $a['label'] }}</p>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                        </ul>
                    @elseif(Auth::user()->quyen == 'employee')
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item menu-open">
                                <a href="" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        </ul>
                    @elseif(Auth::user()->quyen == 'manager')
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item menu-open">
                                <a href="" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('list.employee') }}" class="nav-link">
                                    <i class="nav-icon fas fa-table"></i>
                                    <p>
                                        Nhân viên
                                        {{-- <i class="fas fa-angle-left right"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    @endif
                    @endif
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card">
                                <div class="card-body">
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert"></button>
                                            {{ Session::get('error') }}
                                        </div>
                                    @endif
                                    @if (Session::has('success'))
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert"></button>
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    @if (Session::has('warning'))
                                        <div class="alert alert-warning">
                                            <button type="button" class="close" data-dismiss="alert"></button>
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                    @yield('main')
                                </div>
                                <!-- /.card-footer-->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ url('ad123') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('ad123') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('ad123') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('ad123') }}/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('ad123') }}/dist/js/demo.js"></script>
    @yield('js')
</body>

</html>
