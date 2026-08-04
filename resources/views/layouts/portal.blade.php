@extends('layouts.app')

@push('styles')
<!-- DataTables Bootstrap 5 CDN CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    /* Dashboard Theme Configuration & Global Rules */
    :root {
        --sidebar-width: 260px;
        --sidebar-bg: #1a237e;       /* Premium Royal Blue */
        --sidebar-hover: rgba(255, 255, 255, 0.1);
        --content-bg: #f5f6fa;
        --accent-gold: #ffc107;
    }

    #wrapper {
        display: flex;
        width: 100vw;
        height: 100vh;
    }

    /* Royal Blue Sidebar Settings */
    #sidebar {
        width: var(--sidebar-width);
        min-width: var(--sidebar-width);
        background-color: var(--sidebar-bg);
        height: 100vh;
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column; 
        transition: all 0.3s ease;
        z-index: 1010;
        box-shadow: 4px 0 10px rgba(0,0,0,0.1);
    }

    #sidebar.collapsed {
        margin-left: calc(-1 * var(--sidebar-width));
    }

    .sidebar-brand {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Sidebar menu layout spacing and vertical flow rules */
    .sidebar-menu {
        list-style: none !important;
        padding: 1rem 0.75rem !important;
        margin: 0 !important;
        display: flex !important;
        flex-direction: column !important; /* Forces items vertically item-by-item */
        flex-grow: 1;
        overflow-y: auto; 
    }

    .sidebar-footer {
        background-color: rgba(0, 0, 0, 0.2); 
        padding: 1.25rem 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Glassmorphism custom dropdown selector for school portal */
    .sidebar-select {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        font-size: 13px !important;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease-in-out;
    }

    .sidebar-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.2) !important;
        border-color: #ffc107 !important;
    }

    .sidebar-select option {
        background-color: var(--sidebar-bg) !important;
        color: #ffffff !important;
    }

    .sidebar-select:disabled {
        background-color: rgba(255, 255, 255, 0.03) !important;
        color: rgba(255, 255, 255, 0.3) !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 0.8rem 1rem;
        color: #e2e8f0;
        text-decoration: none;
        border-radius: 10px;
        margin-bottom: 0.4rem;
        transition: all 0.2s ease;
    }

    .sidebar-link i {
        font-size: 1.1rem;
        width: 25px;
        text-align: center;
    }

    .submenu-link:hover, .submenu-link.active {
        color: var(--accent-gold);
        background-color: rgba(255, 255, 255, 0.05);
    }
        
    .sidebar-link.active i {
        color: var(--accent-gold) !important;
    }

    /* Dropdown Chevron Animation */
    .transition-icon {
        transition: transform 0.2s ease-in-out;
    }

    .sidebar-link[aria-expanded="true"] .transition-icon {
        transform: rotate(180deg);
    }

    /* Submenu Link Styling */
    .submenu-link {
        display: flex;
        align-items: center;
        padding: 0.6rem 1rem 0.6rem 3rem;
        color: #cbd5e1;
        text-decoration: none;
        border-radius: 8px;
        font-size: 13.5px;
        transition: 0.2s;
    }

    .submenu-link:hover {
        background-color: rgba(255, 255, 255, 0.05);
        color: #ffc107;
    }

    /* Right Main Layout Wrapper */
    #content-wrapper {
        flex-grow: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        background-color: var(--content-bg);
    }

    .navbar-custom {
        background-color: #ffffff;
        border-bottom: 1px solid #eef2f7;
        padding: 0.75rem 1.5rem;
    }

    .dashboard-card {
        border: none;
        border-radius: 16px;
        background-color: #ffffff;
        box-shadow: var(--card-shadow);
        transition: transform 0.2s ease-in-out;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
    }

    @media (max-width: 991.98px) {
        #sidebar {
            margin-left: calc(-1 * var(--sidebar-width));
            position: fixed;
            height: 100%;
        }
        #sidebar.active {
            margin-left: 0;
            position: fixed;
            height: 100%;
            z-index: 1050;
        }
        #sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1040;
        }
        #sidebar-overlay.active {
            display: block;
        }
    }
    
    /* Slim Sidebar Custom Scrollbar */
    .sidebar-menu::-webkit-scrollbar { width: 4px; }
    .sidebar-menu::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
</style>
@endpush

@section('content')
<div id="sidebar-overlay"></div>

<div id="wrapper">
    <!-- 1. Include Global Sidebar -->
    @include('components.dashboard.sidebar')

    <!-- Right Side Panel Content -->
    <div id="content-wrapper">
        
        <!-- 2. Include Top Header Navigation Bar -->
        @include('components.dashboard.navbar')

        <!-- 3. Dynamic Portal Content Injection Point -->
        <main class="container-fluid p-4 flex-grow-1">
            @yield('portal_content') 
        </main>

        <!-- 4. Include Footer Component -->
        @include('components.dashboard.footer')

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Global Theme Switcher (Declared in window scope to make it resilient to page-level JS errors)
    window.changeTheme = function(themeName) {
        document.documentElement.setAttribute('data-theme', themeName);
        localStorage.setItem('dashboard_theme', themeName);
    };

    // Responsive sidebar trigger script
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebar-overlay');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            if (window.innerWidth >= 992) {
                sidebar.classList.toggle('collapsed');
            } else {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
</script>
@endpush