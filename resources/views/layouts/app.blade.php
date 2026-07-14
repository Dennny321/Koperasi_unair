<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title', config('app.name', 'Laravel Admin'))</title>


    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:300,400,500,600,700,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <style>
        :root {
            --primary: #2f3291;
            --primary-dark: #1e2061;
            --accent: #ffca0a;
            --white: #ffffff;
            --bg-body: #f4f7fe;
            --text-main: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --sidebar-text: rgba(255, 255, 255, 0.75);
            --sidebar-text-hover: #ffffff;
            --shadow-soft: 0 4px 20px rgba(112, 144, 176, 0.08);
            --shadow-card: 0 2px 10px rgba(112, 144, 176, 0.06);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            height: 100vh;
            overflow: hidden;
            display: flex;
        }


        /* ==================== SIDEBAR ==================== */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(47, 50, 145, 0.1);
            position: fixed;
            left: 0;
            top: 0;
        }


        .sidebar.minimized {
            width: 80px;
        }


        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 80px;
        }


        .logo-box {
            min-width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            padding: 6px;
        }


        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }


        .logo-text {
            font-weight: 800;
            font-size: 20px;
            color: var(--white);
            letter-spacing: -0.5px;
            white-space: nowrap;
            transition: var(--transition);
        }


        .sidebar.minimized .logo-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }


        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
            overflow-x: hidden;
        }


        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }


        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }


        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }


        .nav-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin: 20px 0 12px 24px;
            letter-spacing: 1.2px;
            transition: var(--transition);
        }


        .sidebar.minimized .nav-label {
            opacity: 0;
            height: 0;
            margin: 0;
            overflow: hidden;
        }


        .nav-list {
            list-style: none;
            padding: 0 12px;
        }


        .nav-item {
            margin-bottom: 4px;
        }


        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 14px;
            transition: var(--transition);
            position: relative;
            gap: 12px;
        }


        .nav-link i:first-of-type {
            font-size: 18px;
            min-width: 20px;
            text-align: center;
            flex-shrink: 0;
        }


        .nav-link span {
            white-space: nowrap;
            transition: var(--transition);
            flex: 1;
        }


        .sidebar.minimized .nav-link {
            justify-content: center;
            padding: 12px;
        }


        .sidebar.minimized .nav-link span,
        .sidebar.minimized .chevron {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }


        .nav-link:hover {
            color: var(--sidebar-text-hover);
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(2px);
        }


        .nav-link.active {
            background: var(--accent);
            color: var(--primary);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(255, 202, 10, 0.3);
        }


        .nav-link.active i {
            color: var(--primary);
        }


        .chevron {
            font-size: 11px;
            margin-left: auto;
            transition: var(--transition);
        }


        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            list-style: none;
            padding: 0;
        }


        .nav-item.open .submenu {
            max-height: 300px;
            padding: 8px 0;
        }


        .nav-item.open .chevron {
            transform: rotate(180deg);
        }


        .submenu-link {
            padding: 10px 16px 10px 52px;
            display: block;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
            margin: 2px 12px;
        }


        .submenu-link:hover {
            color: var(--accent);
            background: rgba(255, 255, 255, 0.05);
        }


        .submenu-link.active {
            color: var(--accent);
            font-weight: 600;
        }


        /* ==================== MAIN WRAPPER ==================== */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            margin-left: 280px;
            transition: var(--transition);
        }


        .sidebar.minimized~.main-wrapper {
            margin-left: 80px;
        }


        /* ==================== TOP NAVBAR ==================== */
        .top-navbar {
            background: var(--white);
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-soft);
            min-height: 80px;
            position: sticky;
            top: 0;
            z-index: 50;
        }


        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }


        .toggle-sidebar-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: var(--bg-body);
            color: var(--text-main);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }


        .toggle-sidebar-btn:hover {
            background: var(--primary);
            color: var(--white);
            transform: scale(1.05);
        }


        .breadcrumb-area h4 {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2px;
        }


        .breadcrumb-area p {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 500;
        }


        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }


        .search-box {
            background: var(--bg-body);
            border-radius: 10px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 280px;
        }


        .search-box i {
            color: var(--text-secondary);
            font-size: 14px;
        }


        .search-box input {
            border: none;
            background: none;
            outline: none;
            font-size: 14px;
            width: 100%;
            color: var(--text-main);
        }


        .search-box input::placeholder {
            color: var(--text-secondary);
        }


        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: var(--bg-body);
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            position: relative;
        }


        .icon-btn:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
        }


        .icon-btn .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--white);
        }


        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-body);
            padding: 6px 16px 6px 6px;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
        }


        .user-profile:hover {
            background: var(--primary);
        }


        .user-profile:hover .user-info span {
            color: var(--white);
        }


        .user-profile:hover .user-info small {
            color: rgba(255, 255, 255, 0.8);
        }


        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }


        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }


        .user-info span {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            transition: var(--transition);
        }


        .user-info small {
            font-size: 12px;
            color: var(--text-secondary);
            transition: var(--transition);
        }


        /* ==================== CONTENT BODY ==================== */
        .content-body {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            overflow-x: hidden;
        }


        .content-body::-webkit-scrollbar {
            width: 8px;
        }


        .content-body::-webkit-scrollbar-track {
            background: var(--bg-body);
        }


        .content-body::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }


        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }


        .card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-card);
            margin-bottom: 24px;
        }


        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--bg-body);
        }


        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }


        /* ==================== BUTTONS ==================== */
        .btn {
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }


        .btn i {
            font-size: 14px;
        }


        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }


        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(47, 50, 145, 0.2);
        }


        .btn-accent {
            background: var(--accent);
            color: var(--primary);
        }


        .btn-accent:hover {
            background: #e6b709;
        }


        .btn-success {
            background: var(--success);
            color: var(--white);
        }


        .btn-success:hover {
            background: #059669;
        }


        .btn-danger {
            background: var(--danger);
            color: var(--white);
        }


        .btn-danger:hover {
            background: #dc2626;
        }


        .btn-warning {
            background: var(--warning);
            color: var(--white);
        }


        .btn-warning:hover {
            background: #d97706;
        }


        .btn-info {
            background: var(--info);
            color: var(--white);
        }


        .btn-info:hover {
            background: #2563eb;
        }


        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }


        .btn-lg {
            padding: 14px 28px;
            font-size: 16px;
        }


        /* ==================== FORM ==================== */
        .form-group {
            margin-bottom: 20px;
        }


        .form-label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-main);
            margin-bottom: 8px;
        }


        .form-label.required::after {
            content: '*';
            color: var(--danger);
            margin-left: 4px;
        }


        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: var(--transition);
            background: var(--white);
        }


        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(47, 50, 145, 0.1);
        }


        .form-control.is-invalid {
            border-color: var(--danger);
        }


        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }


        .invalid-feedback {
            color: var(--danger);
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }


        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }


        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23718096' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }


        .form-file {
            position: relative;
        }


        .form-file input[type="file"] {
            opacity: 0;
            position: absolute;
            z-index: -1;
        }


        .form-file-label {
            display: inline-block;
            padding: 12px 20px;
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            width: 100%;
        }


        .form-file-label:hover {
            border-color: var(--primary);
            background: rgba(47, 50, 145, 0.02);
        }


        .form-file-label i {
            font-size: 24px;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }


        /* ==================== TABLE ==================== */
        .table-responsive {
            overflow-x: auto;
            border-radius: 10px;
        }


        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }


        .table thead {
            background: var(--bg-body);
        }


        .table thead th {
            padding: 16px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-color);
        }


        .table tbody td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            font-size: 14px;
        }


        .table tbody tr {
            transition: var(--transition);
        }


        .table tbody tr:hover {
            background: rgba(47, 50, 145, 0.02);
        }


        .table tbody tr:last-child td {
            border-bottom: none;
        }


        /* ==================== BADGE ==================== */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
        }


        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }


        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }


        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }


        .badge-info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }


        .badge-primary {
            background: rgba(47, 50, 145, 0.1);
            color: var(--primary);
        }


        /* ==================== ALERT ==================== */
        .alert {
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }


        .alert i {
            font-size: 20px;
        }


        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }


        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }


        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
            border-left: 4px solid var(--warning);
        }


        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
            border-left: 4px solid var(--info);
        }


        /* ==================== PAGINATION ==================== */
        .pagination {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 24px;
        }


        .pagination a,
        .pagination span {
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
        }


        .pagination a {
            background: var(--white);
            color: var(--text-main);
            border: 2px solid var(--border-color);
        }


        .pagination a:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }


        .pagination .active span {
            background: var(--primary);
            color: var(--white);
            border: 2px solid var(--primary);
        }


        .pagination .disabled span {
            background: var(--bg-body);
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
            cursor: not-allowed;
        }

        .submenu-link i {
            width: 16px;
            text-align: center;
            margin-right: 6px;
            font-size: 12px;
            opacity: 0.8;
        }


        /* ==================== FILTER BAR ==================== */
        .filter-bar {
            background: var(--white);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-card);
        }


        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: end;
        }


        /* ==================== IMAGE PREVIEW ==================== */
        .img-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid var(--border-color);
        }


        .img-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }


        /* ==================== MOBILE RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
            }


            .sidebar.mobile-open {
                left: 0;
            }


            .main-wrapper {
                margin-left: 0;
            }


            .sidebar.minimized~.main-wrapper {
                margin-left: 0;
            }


            .top-navbar {
                padding: 12px 16px;
            }


            .search-box {
                display: none;
            }


            .user-info {
                display: none;
            }


            .content-body {
                padding: 20px 16px;
            }


            .navbar-left {
                gap: 12px;
            }


            .breadcrumb-area h4 {
                font-size: 18px;
            }


            .breadcrumb-area p {
                font-size: 12px;
            }


            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }


            .filter-grid {
                grid-template-columns: 1fr;
            }


            .table-responsive {
                font-size: 12px;
            }


            .card {
                padding: 16px;
            }
        }


        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }


        .mobile-overlay.active {
            display: block;
        }


        /* ==================== UTILITIES ==================== */
        .text-center {
            text-align: center;
        }


        .text-right {
            text-align: right;
        }


        .mt-20 {
            margin-top: 20px;
        }


        .mb-20 {
            margin-bottom: 20px;
        }


        .d-flex {
            display: flex;
        }


        .align-items-center {
            align-items: center;
        }


        .justify-content-between {
            justify-content: space-between;
        }


        .gap-10 {
            gap: 10px;
        }
    </style>


    @stack('styles')
</head>


<body>
    <div class="mobile-overlay" id="mobileOverlay"></div>


    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">
                <img src="{{ asset('images/unair-logo.png') }}" alt="UNAIR Logo" class="logo-img">
            </div>
            <span class="logo-text">KOPERASI<span style="color: var(--accent)"><br>UNAIR</span></span>
        </div>


        <nav class="sidebar-nav">
            <div class="nav-label">Main Menu</div>
            <ul class="nav-list">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}"
                        class="nav-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                {{-- Master Data - Admin Only --}}
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link {{ request()->is('master/*') ? 'active' : '' }}"
                            onclick="toggleSubmenu(this)">
                            <i class="fas fa-box-archive"></i>
                            <span>Master Data</span>
                            <i class="fas fa-chevron-down chevron"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.user.index') }}"
                                    class="submenu-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                                    <i class="fas fa-users-gear"></i> Pengguna</a>
                            </li>
                            <li><a href="{{ route('admin.supplier.index') }}"
                                    class="submenu-link {{ request()->routeIs('admin.supplier.*') ? 'active' : '' }}">
                                    <i class="fas fa-truck"></i> Supplier</a>
                            </li>
                            <li><a href="{{ route('admin.restock.index') }}"
                                    class="submenu-link {{ request()->routeIs('admin.restock.*') ? 'active' : '' }}">
                                    <i class="fas fa-rotate-right"></i> Restock</a>
                            </li>
                            <li><a href="{{ route('admin.kategori-produk.index') }}"
                                    class="submenu-link {{ request()->routeIs('admin.kategori-produk.*') ? 'active' : '' }}">
                                    <i class="fas fa-tags"></i> Kategori Produk</a>
                            </li>
                            <li><a href="{{ route('admin.produk.index') }}"
                                    class="submenu-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                                    <i class="fas fa-box"></i> Produk</a>
                            </li>
                            <li><a href="{{ route('admin.hadiah.index') }}"
                                    class="submenu-link {{ request()->routeIs('admin.hadiah.*') ? 'active' : '' }}">
                                    <i class="fas fa-gift"></i> Hadiah</a>
                            </li>
                            <li><a href="{{ route('admin.member.index') }}"
                                    class="submenu-link {{ request()->routeIs('admin.member.*') ? 'active' : '' }}">
                                    <i class="fas fa-id-card"></i> Member</a>
                            </li>
                        </ul>
                    </li>
                @endif


                {{-- Member - Kasir Only (Full CRUD) --}}
                @if (auth()->user()->role === 'kasir')
                    <li class="nav-item">
                        <a href="{{ route('kasir.member.index') }}"
                            class="nav-link {{ request()->routeIs('kasir.member.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Member</span>
                        </a>
                    </li>
                @endif
            </ul>


            <div class="nav-label">Management</div>
            <ul class="nav-list">
                {{-- Transaksi --}}
                <li class="nav-item">
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.transaksi.index') }}"
                            class="nav-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                        @else
                            <a href="{{ route('kasir.transaksi.index') }}"
                                class="nav-link {{ request()->routeIs('kasir.transaksi.*') ? 'active' : '' }}">
                    @endif
                    <i class="fas fa-cash-register"></i>
                    <span>Transaksi</span>
                    </a>
                </li>


                {{-- Laporan Penjualan - Admin Only --}}
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.laporan-penjualan.index') }}"
                            class="nav-link {{ request()->routeIs('admin.laporan-penjualan.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Laporan Penjualan</span>
                        </a>
                    </li>
                @endif


                {{-- Surat Jalan - Admin Only --}}
                <li class="nav-item">
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.surat-jalan.index') }}"
                            class="nav-link {{ request()->routeIs('admin.surat-jalan.*') ? 'active' : '' }}">
                        @else
                            <a href="{{ route('kasir.surat-jalan.index') }}"
                                class="nav-link {{ request()->routeIs('kasir.surat-jalan.*') ? 'active' : '' }}">
                    @endif
                    <i class="fas fa-file-alt"></i>
                    <span>Surat Jalan</span>
                    </a>
                </li>

                @if (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.activity-log.index') }}"
                            class="nav-link {{ request()->routeIs('admin.activity-log.*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Log Aktivitas</span>
                        </a>
                    </li>
                @endif


                {{-- Settings --}}
                <li class="nav-item">
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.settings.index') }}"
                            class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        @else
                            <a href="{{ route('kasir.settings.index') }}"
                                class="nav-link {{ request()->routeIs('kasir.settings') ? 'active' : '' }}">
                    @endif
                    <i class="fas fa-gears"></i>
                    <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>


    <!-- Main Wrapper -->
    <main class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="navbar-left">
                <button class="toggle-sidebar-btn" id="toggleBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="breadcrumb-area">
                    <p>@yield('breadcrumb', 'Pages / Dashboard')</p>
                    <h4>@yield('page-title', 'Dashboard')</h4>
                </div>
            </div>


            <div class="navbar-right">
                <div class="user-profile" style="cursor:default;">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                        <small>{{ ucfirst(auth()->user()->username ?? 'Administrator') }}</small>
                    </div>
                </div>


                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="icon-btn" title="Logout"
                        style="background:rgba(239,68,68,0.08);color:var(--danger);">
                        <i class="fas fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </header>


        <!-- Content Body -->
        <div class="content-body">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif


            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif


            @yield('content')
        </div>
    </main>


    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        const mobileOverlay = document.getElementById('mobileOverlay');


        toggleBtn.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-open');
                mobileOverlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('minimized');
            }
        });


        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            mobileOverlay.classList.remove('active');
        });


        function toggleSubmenu(el) {
            const parent = el.parentElement;
            const wasOpen = parent.classList.contains('open');


            document.querySelectorAll('.nav-item.open').forEach(item => {
                item.classList.remove('open');
            });


            if (!wasOpen) {
                parent.classList.add('open');
            }
        }


        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-open');
                mobileOverlay.classList.remove('active');
            }
        });


        sidebar.addEventListener('transitionend', () => {
            if (sidebar.classList.contains('minimized')) {
                document.querySelectorAll('.nav-item.open').forEach(item => {
                    item.classList.remove('open');
                });
            }
        });


        // Auto dismiss alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.3s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>


    @stack('scripts')
</body>


</html>
