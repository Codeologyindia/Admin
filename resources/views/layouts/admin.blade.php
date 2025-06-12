<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Use Nunito Sans font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f4f6fa;
            font-family: 'Nunito Sans', Arial, Helvetica, sans-serif;
            font-size: 0.88rem; /* reduced from 0.92rem */
        }
        .sidebar {
            min-height: 100vh;
            background: #232946;
            color: #fff;
            width: 240px; /* Increased from 200px to 240px */
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            box-shadow: 2px 0 8px rgba(34,43,69,0.10);
            display: flex;
            flex-direction: column;
            font-size: 0.88rem; /* reduced from 0.92rem */
            transition: width 0.2s;
            overflow-y: auto;
            max-height: 100vh;
        }
        .sidebar .sidebar-header {
            font-size: 1.05rem;
            font-weight: bold;
            padding: 1.1rem 1rem 0.8rem 1.2rem;
            letter-spacing: 1px;
            color: #fff;
            border-bottom: 1px solid #2e3650;
            background: #232946;
        }
        .sidebar .user-panel {
            padding: 0.7rem 1rem 0.7rem 1.2rem;
            border-bottom: 1px solid #2e3650;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: #232946;
        }
        .sidebar .user-panel .avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            color: #fff;
            box-shadow: 0 2px 8px rgba(59,130,246,0.15);
        }
        .sidebar .user-panel .info {
            flex: 1;
        }
        .sidebar .user-panel .info .name {
            font-weight: 600;
            font-size: 0.89rem;
            color: #fff;
        }
        .sidebar .user-panel .info .role {
            font-size: 0.8rem;
            color: #b0b8d1;
        }
        .sidebar .nav-section-title {
            font-size: 0.75rem;
            color: #b0b8d1;
            font-weight: 700;
            margin: 0.8rem 0 0.3rem 1.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sidebar .nav {
            flex-direction: column;
            gap: 0.08rem;
        }
        .sidebar .nav-link {
            color: #cfd8dc;
            font-weight: 500;
            border-radius: 0.5rem;
            margin: 0.06rem 0;
            padding: 0.36rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: background 0.18s, color 0.18s, box-shadow 0.18s;
            border: none;
            background: none;
            font-size: 0.88rem; /* reduced from 0.92rem */
            position: relative;
        }
        .sidebar .nav-link.dropdown-toggle {
            cursor: pointer;
            user-select: none;
        }
        .sidebar .submenu {
            padding-left: 0.5rem;
            background: none;
            border-left: 2px solid #3b82f6;
            margin-left: 0.7rem;
            /* Prevent submenu from overflowing sidebar */
            max-width: 100%;
            overflow-x: auto;
            font-size: 0.85rem; /* make dropdown submenu font smaller */
        }
        .sidebar .submenu .nav-link {
            font-size: 0.75rem; /* make dropdown submenu link font smaller */
            padding: 0.22rem 1.2rem 0.22rem 1.5rem;
            border-radius: 0.4rem;
            margin: 0.03rem 0;
            color: #b0b8d1;
            background: none;
        }
        .sidebar .submenu .nav-link.active,
        .sidebar .submenu .nav-link:hover,
        .sidebar .submenu .nav-link:focus {
            background: #f4f6fa;
            color: #232946;
            font-weight: 600;
            box-shadow: none;
            border-radius: 0.4rem;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover,
        .sidebar .nav-link:focus {
            background: #fff;
            color: #232946;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(59,130,246,0.10);
            outline: none;
            border-radius: 0;
        }
        .sidebar .nav-link.active::before,
        .sidebar .nav-link:hover::before,
        .sidebar .nav-link:focus::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 3px;
            border-radius: 3px;
            background: #3b82f6;
        }
        .sidebar .nav-link .bi {
            font-size: 0.98rem;
        }
        .sidebar .nav-link .bi-chevron-down {
            margin-left: auto;
            font-size: 0.9rem;
            transition: transform 0.2s;
        }
        .sidebar .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }
        .sidebar .nav-section-title:not(:first-child) {
            margin-top: 1rem;
        }
        .sidebar .nav.flex-column.mb-3 {
            margin-bottom: 1rem !important;
        }
        /* Dropdown arrow rotate */
        .sidebar .nav-link.collapsed .bi-chevron-down {
            transform: rotate(0deg);
            transition: transform 0.2s;
        }
        .sidebar .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
            transition: transform 0.2s;
        }
        .topbar {
            height: 44px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 0.9rem;
            margin-left: 240px; /* Increased from 200px to 240px */
            font-size: 0.88rem; /* reduced from 0.97rem */
            transition: margin-left 0.2s;
            box-shadow: 0 2px 8px rgba(34,43,69,0.03);
        }
        .main-content {
            margin-left: 240px; /* Increased from 200px to 240px */
            padding: 0.9rem 0.9rem 0.9rem 0.9rem;
            font-size: 0.88rem; /* reduced from 0.92rem */
            transition: margin-left 0.2s;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                width: 170px; /* Increased from 150px to 170px */
                min-height: 100vh;
                z-index: 1040;
                left: -170px;
                top: 0;
                transition: left 0.3s;
            }
            .sidebar.active {
                left: 0;
            }
            .topbar, .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
            .main-content {
                padding: 0.5rem;
            }
            .topbar {
                padding: 0 0.5rem;
            }
            .sidebar-toggle-btn {
                display: inline-block !important;
            }
        }
        .sidebar-toggle-btn {
            display: none;
            background: none;
            border: none;
            color: #3b82f6;
            font-size: 1.3rem;
            margin-right: 0.7rem;
        }
        select.form-select {
            border-radius: 0.4rem;
            border: 1px solid #d1d5db;
            font-size: 0.88rem; /* reduced from 0.92rem */
            padding: 0.35rem 1.2rem 0.35rem 0.6rem;
            background-color: #f8fafc;
            box-shadow: none;
            transition: border-color 0.2s;
        }
        select.form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.12rem rgba(59,130,246,0.15);
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list"></i>
    </button>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="bi bi-hospital"></i> Admin Panel
        </div>
        <div class="user-panel">
            <div class="avatar">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="info">
                <div class="name">{{ Auth::user()->email ?? 'Admin' }}</div>
                <div class="role">
                    @if(Auth::check() && Auth::user()->rol)
                        {{ Auth::user()->rol->name }}
                    @else
                        Admin
                    @endif
                </div>
            </div>
        </div>
        <div class="nav-section-title">Main</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </nav>

        <div class="nav-section-title">Online Booking</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.online-booking') ? 'active' : '' }}" href="{{ route('admin.online-booking') }}">
                <i class="bi bi-calendar-check"></i> New Booking
            </a>
            <a class="nav-link {{ request()->routeIs('admin.booking-list') ? 'active' : '' }}" href="{{ route('admin.booking-list') }}">
                <i class="bi bi-list-check"></i> All Bookings
            </a>
        </nav>

        <div class="nav-section-title">Management</div>
        <nav class="nav flex-column">
            @php
                $managementActive = request()->routeIs('admin.madison-quary') || request()->routeIs('admin.ayushman-card-query');
                $hospitalActive = request()->routeIs('admin.hospital') || request()->routeIs('admin.hospital.add') || request()->routeIs('admin.hospital.edit');
            @endphp
            <a class="nav-link dropdown-toggle {{ $managementActive ? '' : 'collapsed' }}" href="#managementSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ $managementActive ? 'true' : 'false' }}" aria-controls="managementSubmenu">
                <i class="bi bi-diagram-3"></i> Management Quary
            </a>
            <div class="collapse submenu{{ $managementActive ? ' show' : '' }}" id="managementSubmenu">
                <a class="nav-link {{ request()->routeIs('admin.madison-quary') ? 'active' : '' }}" href="{{ route('admin.madison-quary') }}">
                    <i class="bi bi-capsule-pill"></i> Madison Quary
                </a>
                <a class="nav-link {{ request()->routeIs('admin.ayushman-card-query') ? 'active' : '' }}" href="{{ route('admin.ayushman-card-query') }}">
                    <i class="bi bi-credit-card-2-front"></i> Ayushman Card Query
                </a>
            </div>
            {{-- Hospital Section --}}
            <a class="nav-link dropdown-toggle {{ $hospitalActive ? '' : 'collapsed' }}" href="#hospitalSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ $hospitalActive ? 'true' : 'false' }}" aria-controls="hospitalSubmenu">
                <i class="bi bi-hospital"></i> Hospital
            </a>
            <div class="collapse submenu{{ $hospitalActive ? ' show' : '' }}" id="hospitalSubmenu">
                <a class="nav-link {{ request()->routeIs('admin.hospital') ? 'active' : '' }}" href="{{ route('admin.hospital') }}">
                    <i class="bi bi-list-ul"></i> All Hospitals
                </a>
                <a class="nav-link {{ request()->routeIs('admin.hospital.add') ? 'active' : '' }}" href="{{ route('admin.hospital.add') }}">
                    <i class="bi bi-plus-lg"></i> Add Hospital
                </a>
            </div>
            <a class="nav-link" href="#">
                <i class="bi bi-people"></i> Users
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-person-badge"></i> Roles
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-upload"></i> UPL
            </a>
        </nav>
        <div class="nav-section-title">Reports</div>
        <nav class="nav flex-column">
            <a class="nav-link" href="#">
                <i class="bi bi-bar-chart-line"></i> Analytics
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-file-earmark-text"></i> Logs
            </a>
        </nav>
        <div class="nav-section-title">Account</div>
        <nav class="nav flex-column mb-3">
            <a class="nav-link" href="{{ route('admin.logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </div>
    <div class="topbar d-flex justify-content-between align-items-center">
        <div>
            <button class="sidebar-toggle-btn d-lg-none" id="sidebarToggleTop" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <span class="fw-bold fs-5" style="font-size:1.1rem;">@yield('topbar-title', 'Dashboard')</span>
        </div>
        <div>
            <span class="me-3" style="font-size:0.97rem;"><i class="bi bi-person-circle"></i> {{ Auth::user()->email ?? 'Admin' }}</span>
        </div>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('sidebar');
            var toggleBtns = [document.getElementById('sidebarToggle'), document.getElementById('sidebarToggleTop')];
            toggleBtns.forEach(function(btn) {
                if(btn) {
                    btn.addEventListener('click', function () {
                        sidebar.classList.toggle('active');
                    });
                }
            });
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if(window.innerWidth <= 991 && sidebar.classList.contains('active')) {
                    if (!sidebar.contains(e.target) && !toggleBtns.some(btn => btn && btn.contains(e.target))) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        });
    </script>
</body>
</html>
