@php
$user = Auth::user();
$role = $user->role;
$user_access = explode(',', $user->access_level);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="admin_themes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="/admin/images/favicon.ico">
    <title> Admin @isset($title) ~ {{ $title }} @endisset</title>
    <!-- App css -->
    <link href="/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin/css/app.css" rel="stylesheet" type="text/css" />
    {{ $styles ?? null }}
    <style>
        label.col-form-label,
        .form-control::placeholder,
        .metismenu li span {
            text-transform: capitalize;
        }

        .badge {
            color: #2c3440 !important;
            padding: 3px 6px;
        }

    </style>
</head>

<body class="left-side-menu-dark">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="/admin/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ml-1">
                            {{ auth()->user()->name }}<i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item notify-item">
                            <i class="fe-log-out"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li>
            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="index.html" class="logo text-center">
                    <span class="logo-lg">
                        <img src="/admin/images/logo-dark.png" alt="" height="16">
                        <!-- <span class="logo-lg-text-light">Xeria</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-sm-text-dark">X</span> -->
                        <img src="/admin/images/logo-sm.png" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile disable-btn waves-effect">
                        <i class="fe-menu"></i>
                    </button>
                </li>

                <li>
                    <h4 class="page-title-main text-capitalize">{{ $title }}</h4>
                </li>

            </ul>
        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">
                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul class="metismenu" id="side-menu">

                        <li class="menu-title">Navigation</li>

                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        {{-- user starts --}}
                        @if ($role == 'super-admin' || ($role == 'admin' && in_array('user', $user_access)))
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="mdi mdi-account"></i>
                                    <span> admin user </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="{{ route('user.create') }}">Add new</a></li>
                                    <li><a href="{{ route('user.index') }}">All lists</a></li>
                                </ul>
                            </li>
                        @endif
                        {{-- user ends --}}

                        {{-- category starts --}}
                        @if ($role == 'super-admin' || ($role == 'admin' && in_array('category', $user_access)))
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="mdi mdi-gift"></i>
                                    <span> Category </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="{{ route('category.create') }}">Add new</a></li>
                                    <li><a href="{{ route('category.index') }}">All lists</a></li>
                                </ul>
                            </li>
                        @endif

                        {{-- category ends --}}

                        {{-- post ends --}}
                        @if ($role == 'super-admin' || ($role == 'admin' && in_array('post', $user_access)))
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="mdi mdi-blogger"></i>
                                    <span> Post </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="{{ route('post.create') }}">Add new</a></li>
                                    <li><a href="{{ route('post.index') }}">All lists</a></li>
                                </ul>
                            </li>
                        @endif
                        {{-- post ends --}}

                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                {{ $slot }}

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            {{ date('Y') }} &copy; Admin theme by <a target="_blank"
                                href="https://hamrohaat.com/">Hamrohaat</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <script src="/admin/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="/admin/js/app.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".alertMessage").delay(2000).slideUp(500);
        });

    </script>

    {{ $scripts ?? null }}

</body>

</html>
