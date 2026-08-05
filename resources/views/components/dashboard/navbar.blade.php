<!-- ==================== GLOBAL EMAIL VERIFICATION BANNER ==================== -->
<div id="emailVerificationBanner" class="alert alert-warning border-0 rounded-0 m-0 py-2.5 px-4 d-none" style="z-index: 1060; background-color: #fff3cd; border-bottom: 1px solid #ffeeba !important;">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-warning fs-5"></i>
            <span class="text-dark small">
                <strong>Email Verification Pending!</strong> Please verify your email to unlock all academic functionalities of School ERP.
            </span>
        </div>
        <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 py-1 fw-bold" id="resendVerificationBtn" style="font-size: 11px;">
            Resend Link
        </button>
    </div>
</div>

<!-- Main Top Navigation Bar -->
<nav class="navbar navbar-expand navbar-light bg-white shadow-sm px-4 py-2">
    <!-- Sidebar Toggle Button -->
    <button class="btn btn-light border-0 me-3" id="sidebarToggle">
        <i class="fa-solid fa-bars fs-5"></i>
    </button>

    <!-- Quick Home shortcut -->
    <a href="{{ url('/') }}" class="btn btn-outline-primary rounded-pill btn-sm d-flex align-items-center me-3 px-3">
        <i class="fa-solid fa-house me-2"></i>
        <span class="d-none d-md-inline">Home</span>
    </a>

    <ul class="navbar-nav ms-auto align-items-center gap-3">
        <!-- ==================== DYNAMIC MULTI-THEME SELECTOR ==================== -->
        <div class="d-flex align-items-center gap-1 bg-light p-1 rounded border">
            <span class="small text-muted px-2 d-none d-sm-inline">Theme:</span>
            <!-- Default Blue Theme Button -->
            <span class="theme-selector-btn bg-primary" onclick="changeTheme('default')" title="Default Blue"></span>
            <!-- Green Theme Button (Highly requested for Bangladeshi School style) -->
            <span class="theme-selector-btn bg-success" onclick="changeTheme('green')" title="Govt Green"></span>
            <!-- Purple Premium Theme Button -->
            <span class="theme-selector-btn" style="background-color: #6f42c1 !important; width: 25px; height: 25px; border-radius: 50%; cursor: pointer; border: 2px solid #fff; display: inline-block;" onclick="changeTheme('purple')" title="Royal Purple"></span>
            <!-- Dark Mode Theme Button -->
            <span class="theme-selector-btn bg-dark" onclick="changeTheme('dark')" title="Slate Dark"></span>
        </div>

        <!-- Dynamic Notifications Count -->
        <li class="nav-item">
            <a class="nav-link text-secondary position-relative" href="#">
                <i class="fa-solid fa-bell fs-5"></i>
                <span class="position-absolute top-1 start-75 translate-middle badge rounded-pill bg-danger" style="font-size: 8px;">
                    3
                </span>
            </a>
        </li>
        
        <!-- ==================== User Profile Dropdown Section ==================== -->
        <li class="nav-item dropdown profile-dropdown-wrapper">
            <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-none d-lg-inline small fw-semibold me-2 userEmailSidebarDB">Loading...</span>
                <div class="bg-light text-primary border p-1 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-user small"></i>
                </div>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2 py-2" aria-labelledby="profileDropdown" style="min-width: 180px;">
                <li>
                    <a class="dropdown-item py-2 px-3 text-dark small" href="#">
                        <i class="fa-solid fa-id-card me-2 text-primary" style="width: 18px; text-align: center;"></i>View Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 px-3 text-dark small" href="{{url('/change-password')}}">
                        <i class="fa-solid fa-key me-2 text-warning" style="width: 18px; text-align: center;"></i>Change Password
                    </a>
                </li>
                <li><hr class="dropdown-divider border-light"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-block m-0">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 px-3 text-danger small">
                            <i class="fa-solid fa-right-from-bracket me-2" style="width: 18px; text-align: center;"></i>Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>

@push('styles')
<style>    
    .profile-dropdown-wrapper .dropdown-toggle::after {
        display: none !important;
    }
    
    @media (min-width: 992px) {
        .profile-dropdown-wrapper:hover .dropdown-menu {
            display: block;
            margin-top: 0 !important;
            animation: fadeIn 0.2s ease-in-out;
        }
    }
  
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

