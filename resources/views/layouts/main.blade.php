<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main CSS-->
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">

</head>
<style>
    .liststyle {
        list-style: none;
    }
</style>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo">
                            <img src="{{ asset('images/icon/book1.png') }}" alt="CoolAdmin" style="width: 30%; height: auto;">
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    @php
                        $userRole = '';
                    @endphp
                    @if (auth()->check())
                        @php
                            $userRole = strtolower(auth()->user()->role->role_name);
                            // dd($userRole);
                        @endphp
                    @endif
                    <ul class="navbar-mobile__list list-unstyled">
                        @php
                            $roleId = Auth::user()->role_id;
                            $sideBarMenus = DB::table('side_bar_menus')
                                ->leftJoin(
                                    'role_sider_bar_joins',
                                    'role_sider_bar_joins.siderbar_id',
                                    '=',
                                    'side_bar_menus.id',
                                )
                                ->whereNull('role_sider_bar_joins.deleted_at')
                                ->where('role_sider_bar_joins.role_id', $roleId)
                                ->where('role_sider_bar_joins.permission', 1)
                                ->select('side_bar_menus.*')
                                ->get();
                        @endphp
                        <ul>
                            @foreach ($sideBarMenus as $menu)
                                <li class="liststyle">
                                    <a href="{{ route($menu->route) }}">
                                        <i class="{{ $menu->name }}"></i>{{ $menu->display_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo " style="text-align: center">
                <a href="#">
                    <img src="{{ asset('images/icon/book1.png') }}" alt="CoolAdmin" style="width: 40%; height: auto;">
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        @php
                            $roleId = Auth::user()->role_id;
                            $sideBarMenus = DB::table('side_bar_menus')
                                ->leftJoin(
                                    'role_sider_bar_joins',
                                    'role_sider_bar_joins.siderbar_id',
                                    '=',
                                    'side_bar_menus.id',
                                )
                                ->whereNull('role_sider_bar_joins.deleted_at')
                                ->where('role_sider_bar_joins.role_id', $roleId)
                                ->where('role_sider_bar_joins.permission', 1)
                                ->whereNot('side_bar_menus.display_name', "User")
                                ->whereNot('side_bar_menus.display_name', "Sidebar")
                                ->select('side_bar_menus.*')
                                ->get();
                        @endphp
                        <ul>
                            @foreach ($sideBarMenus as $menu)
                                <li class="liststyle">
                                    <a href="{{ route($menu->route) }}">
                                        <i class="{{ $menu->name }}"></i>{{ $menu->display_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">

                            </form>
                            <div class="header-button">

                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            @if (auth()->user())
                                                <img src="{{ asset('images/' . auth()->user()->image) }}"
                                                    alt="User Image" width="100" height="50px"
                                                    class="img-circle profile_img">
                                            @else
                                                <p>No user image available</p>
                                            @endif
                                        </div>
                                        <div class="content">
                                            @auth
                                                <a class="js-acc-btn" href="#">{{ auth()->user()->name }}</a>
                                            @else
                                                <a class="js-acc-btn" href="#">Guest</a>
                                            @endauth
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="account-dropdown__body">
                                                {{-- @if (Auth::check()) --}}
                                                {{-- @if (Auth::user()->role == 'admin' || Auth::user()->role == 'employee' || Auth::user()->role == 'supervisor') --}}
                                                <div class="account-dropdown__item">
                                                    <a href="{{ route('myprofile') }}">
                                                        <i class="bi bi-person-square"></i> My Profile
                                                    </a>
                                                </div>
                                                {{-- @endif --}}
                                                {{-- @endif --}}
                                                @if ($userRole == 'superadmin')
                                                <div class="account-dropdown__item">
                                                    <a href="{{ route('changepass') }}">
                                                        <i class="zmdi zmdi-settings"></i>Change Password</a>
                                                </div>
                                                @endif
                                                <div class="account-dropdown__item">
                                                    <a href="{{ route('logout') }}">
                                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <main class="main-content">
                            @yield('content')
                        </main>
                    </div>
                    <div class="copyright">
                        <p> Created by⭐<a href="https://kalathiyainfotech.com/">Kalathiya Infotech</a></p>
                    </div>
                </div>
                <!-- END MAIN CONTENT-->
                <!-- END PAGE CONTAINER-->
            </div>

        </div>

    </div>
    <!-- Jquery JS-->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script><!-- Bootstrap JS-->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>

    <!-- Vendor JS-->

    <script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

    <!-- Main JS-->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')

</body>

</html>
<!-- end document-->
