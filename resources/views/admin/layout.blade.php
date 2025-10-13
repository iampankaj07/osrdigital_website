<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - OSR Digital</title>
    <!-- AdminLTE 3.2 & Montserrat Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- AdminLTE 3.2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Load Vite-built CSS -->
    @vite(['resources/css/app.css'])

    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script src="{{ asset('js/quill-config.js') }}"></script>
    <style>
        /* AdminLTE 3.2 Custom Styles with Montserrat */
        body {
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            font-weight: 400;
            background: #f4f6f9 !important;
        }

        /* Brand & Logo */
        .brand-text {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700 !important;
            font-size: 1.2rem !important;
        }

        .navbar-brand {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700 !important;
        }

        /* Sidebar Customizations */
        .main-sidebar {
            background: #343a40 !important;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 500 !important;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #007bff !important;
            color: #fff !important;
        }

        /* Navigation Headers */
        .nav-header {
            color: rgba(255, 255, 255, 0.6) !important;
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        /* Content Header */
        .content-header h1 {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700 !important;
            color: #495057 !important;
        }

        /* Cards */
        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2) !important;
            border: none !important;
        }

        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid rgba(0, 0, 0, .125) !important;
        }

        .card-title {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 600 !important;
        }

        /* Info Boxes */
        .info-box {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2) !important;
            border-radius: 0.25rem !important;
        }

        .info-box .info-box-number {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700 !important;
        }

        .info-box .info-box-text {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 500 !important;
        }

        /* Buttons */
        .btn {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 500 !important;
        }

        /* Control Sidebar */
        .control-sidebar {
            background: #343a40 !important;
        }

        /* Navbar */
        .navbar-white {
            background-color: #fff !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        /* Custom OSR Styles */
        .nav-icon {
            margin-right: 0.5rem !important;
            width: 1.2rem !important;
        }

        /* Quill Editor */
        .ql-editor {
            min-height: 200px;
            font-family: 'Montserrat', sans-serif !important;
        }

        .ql-toolbar {
            border-top: 1px solid #ced4da !important;
            border-left: 1px solid #ced4da !important;
            border-right: 1px solid #ced4da !important;
            border-bottom: none !important;
        }

        .ql-container {
            border-bottom: 1px solid #ced4da !important;
            border-left: 1px solid #ced4da !important;
            border-right: 1px solid #ced4da !important;
            border-top: none !important;
        }


        /* Loading Animation */
        .loading {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .loaded {
            opacity: 1;
        }

        /* Custom Colors */
        .bg-primary-custom {
            background-color: #007bff !important;
        }

        .bg-success-custom {
            background-color: #28a745 !important;
        }

        .bg-warning-custom {
            background-color: #ffc107 !important;
        }

        .bg-danger-custom {
            background-color: #dc3545 !important;
        }

        .text-primary-custom {
            color: #007bff !important;
        }

        /* Loading States */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Content Loading States */
        .content-loading .card-body {
            position: relative;
        }

        .content-loading .card-body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 10;
        }

        /* Fade in animation for loaded content */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Dropdown Enhancements */
        .dropdown-menu {
            border: none !important;
            box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.15) !important;
            border-radius: 0.375rem !important;
            font-family: 'Montserrat', sans-serif !important;
        }

        .dropdown-item {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 400 !important;
            padding: 0.5rem 1rem !important;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa !important;
            color: #007bff !important;
        }

        .navbar-nav .nav-link {
            color: #495057 !important;
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 500 !important;
            transition: color 0.15s ease-in-out !important;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff !important;
        }

        /* Search Block Styles */
        .navbar-search-block {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #dee2e6;
            padding: 0.5rem;
            z-index: 1000;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Badge Styles */
        .badge {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 600 !important;
        }

        /* Alert Animations */
        .alert {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <div class="media-object">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <span
                                            class="text-white font-weight-bold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        New Message
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>

                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <span
                                class="text-white font-weight-bold text-sm">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-header">
                            <strong>{{ auth()->user()->name ?? 'User' }}</strong><br>
                            <small>{{ auth()->user()->email ?? 'user@example.com' }}</small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.settings') }}" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-white elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <i class="fas fa-video brand-image img-circle elevation-3 ml-3 mr-2"
                    style="font-size: 2rem; color: #007bff;"></i>
                <span class="brand-text font-weight-light">OSR Digital</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 2.1rem; height: 2.1rem;">
                            <span
                                class="text-white font-weight-bold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name ?? 'User' }}</a>
                    </div>
                </div>



                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Content Management -->
                        <li class="nav-header">CONTENT MANAGEMENT</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.hero-sections.index') }}"
                                class="nav-link {{ request()->routeIs('admin.hero-sections*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-star"></i>
                                <p>Hero Sections</p>
                            </a>
                        </li>

                        <!-- About Us Section -->
                        <li class="nav-header">ABOUT US</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.mission-vision.index') }}"
                                class="nav-link {{ request()->routeIs('admin.mission-vision*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bullseye"></i>
                                <p>Mission & Vision</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.core-values.index') }}"
                                class="nav-link {{ request()->routeIs('admin.core-values*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-heart"></i>
                                <p>Core Values</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.services.index') }}"
                                class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Services</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.associates.index') }}"
                                class="nav-link {{ request()->routeIs('admin.associates*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>Associates</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.distribution-services.index') }}"
                                class="nav-link {{ request()->routeIs('admin.distribution-services*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>Distribution Services</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.global-impact.index') }}"
                                class="nav-link {{ request()->routeIs('admin.global-impact*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Global Impact</p>
                            </a>
                        </li>

                        <!-- Partners Section -->
                        <li class="nav-header">OUR PARTNERS</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.trusted-partners.index') }}"
                                class="nav-link {{ request()->routeIs('admin.trusted-partners*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>Trusted Partners</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.partnership-benefits.index') }}"
                                class="nav-link {{ request()->routeIs('admin.partnership-benefits*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-gift"></i>
                                <p>Partnership Benefits</p>
                            </a>
                        </li>

                        <!-- Team Section -->
                        <li class="nav-header">OUR TEAMS</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.team-members.index') }}"
                                class="nav-link {{ request()->routeIs('admin.team-members*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Team Members</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.team-values.index') }}"
                                class="nav-link {{ request()->routeIs('admin.team-values*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-heart"></i>
                                <p>Team Values</p>
                            </a>
                        </li>

                        <!-- Film Section -->
                        <li class="nav-header">FILM</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.film-portfolios.index') }}"
                                class="nav-link {{ request()->routeIs('admin.film-portfolios*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-film"></i>
                                <p>Film Portfolios</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.film-categories.index') }}"
                                class="nav-link {{ request()->routeIs('admin.film-categories*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Film Categories</p>
                            </a>
                        </li>

                        <!-- Testimonials -->
                        <li class="nav-header">TESTIMONIALS</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.testimonials.index') }}"
                                class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-quote-left"></i>
                                <p>Testimonials</p>
                            </a>
                        </li>

                        <!-- News Section -->
                        <li class="nav-header">NEWS & CATEGORIES</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.news.index') }}"
                                class="nav-link {{ request()->routeIs('admin.news*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>News</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.news-categories.index') }}"
                                class="nav-link {{ request()->routeIs('admin.news-categories*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>News Categories</p>
                            </a>
                        </li>

                        <!-- System Section -->
                        <li class="nav-header">SYSTEM</li>


                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}"
                                class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Settings</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.roles') }}"
                                class="nav-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>Roles & Permissions</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->

        </aside>
        <!-- /.main-sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title', 'Dashboard')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('breadcrumb')
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade-in">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Success!</h4>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade-in">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade-in">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Validation Error!</h4>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <div class="main-content-area">
                        @yield('content')
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="#">OSR Digital</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>


    <!-- Load Vite-built JS -->
    @vite(['resources/js/app.jsx'])

    <!-- AdminLTE initialization script -->
    <script>
        $(document).ready(function() {
            // Initialize AdminLTE components
            if (window.AdminLTE) {
                window.AdminLTE.init();
            }

            // Simple loading functionality
            window.showLoading = function(container) {
                $(container).addClass('content-loading');
                const loadingHtml = `
            <div class="loading-overlay">
                <div class="loading-spinner"></div>
            </div>
        `;
                $(container).append(loadingHtml);
            };

            window.hideLoading = function(container) {
                $(container).removeClass('content-loading');
                $(container).find('.loading-overlay').remove();
                $(container).addClass('fade-in');
            };

            // Handle sidebar toggle state
            const body = document.body;
            const sidebarToggle = document.querySelector('[data-widget="pushmenu"]');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    setTimeout(() => {
                        if (body.classList.contains('sidebar-collapse')) {
                            localStorage.setItem('adminlte-sidebar', 'collapsed');
                        } else {
                            localStorage.setItem('adminlte-sidebar', 'expanded');
                        }
                    }, 300);
                });
            }

            // Restore sidebar state
            const savedState = localStorage.getItem('adminlte-sidebar');
            if (savedState === 'collapsed') {
                body.classList.add('sidebar-collapse');
            }

            // Initialize dropdown menus
            $('.dropdown-toggle').dropdown();

            // Handle navbar search
            $('[data-widget="navbar-search"]').on('click', function() {
                $('.navbar-search-block').toggle();
                $('.form-control-navbar').focus();
            });

            // Handle sidebar search
            $('[data-widget="sidebar-search"]').SidebarSearch({
                arrowSign: '→',
                minLength: 2,
                maxResults: 7,
                highlightName: true,
                highlightPath: false,
                highlightClass: 'text-light',
                notFoundText: 'No results found'
            });

            // Initialize treeview
            $('[data-widget="treeview"]').Treeview('init');

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>

    @yield('scripts')
</body>

</html>
