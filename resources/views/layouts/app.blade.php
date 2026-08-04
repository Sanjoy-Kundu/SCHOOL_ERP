<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="default">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token for Secure Post Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title with dynamic yield -->
    <title>@yield('title', config('app.name', 'Scool Erp'))</title>
    
    <!-- Fonts for Bengali & English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Frameworks (Updated Paths) -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <!-- Custom Layout & Dynamic Colors Theme Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    
    <!-- Core Vendor Scripts (Loaded early for DataTables/Charts inside views) -->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chartjs/chart.umd.js') }}"></script>
    
    @stack('styles')

    <!-- Font Family Setup -->
    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
        }
    </style>
  
    <!-- ==================== GLOBAL ROUTE GUARD ==================== -->
    <script>
        (function() {
            // Read authentication token and user preferences from local storage
            const token = localStorage.getItem('auth_token');
            const theme = localStorage.getItem('dashboard_theme') || 'default';
            const currentPath = window.location.pathname;

            // Apply selected theme on body render
            document.documentElement.setAttribute('data-theme', theme);

            // Define guest pages that are accessible without login 
            const publicPages = ['/login', '/register', '/default/register', '/forgot-password', '/'];

            // Intercept unauthorized requests and destroy the Laravel session first
            if (!token && !publicPages.includes(currentPath) && !currentPath.startsWith('/reset-password/')) {
                const csrfMeta = document.head.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.content : '';

                // Send a silent POST request to /logout using native fetch before redirecting
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).finally(() => {
                    // Redirect to login after the session cookie is destroyed on the server
                    window.location.href = "/login";
                });
            }
        })();
    </script>
</head>
<body class="bg-light">

    @yield('content')

    <!-- ==================== LOCAL JS LIBRARIES (Updated Paths) ==================== -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>