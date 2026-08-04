<style>
    /* Dynamic active navigation indicator style */
    #sidebar .sidebar-link.active-group {
        color: var(--primary-color) !important;
        font-weight: 700 !important;
    }
    #sidebar .sidebar-link.active-group i {
        color: var(--primary-color) !important;
    }
    #sidebar .submenu-link.active {
        color: var(--primary-color) !important;
        font-weight: 700 !important;
    }
    #sidebar .submenu-link.active i {
        color: var(--primary-color) !important;
    }
    #sidebar .sidebar-link[aria-expanded="true"] .transition-icon {
        transform: rotate(180deg);
        color: var(--primary-color) !important;
    }
</style>

<aside id="sidebar" class="sidebar flex-shrink-0">
    <!-- Brand Identity Block -->
    <div class="sidebar-brand text-center p-3">
        <h4 class="fw-bold text-white mb-0">
            <i class="fa-solid fa-graduation-cap text-warning me-2"></i>School ERP
        </h4>
        <span class="badge bg-light text-dark mt-2 small" style="font-size: 11px;">Classes 6 - 10</span>
    </div>

    <!-- Navigation Menu Items -->
    <ul class="sidebar-menu flex-grow-1 nav nav-pills flex-column px-2">
        <!-- MODULE 1: DASHBOARD -->
        <li>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge me-3"></i>Dashboard
            </a>
        </li>

        <li><hr class="border-white border-opacity-10 my-2"></li>

        <!-- MODULE 2: ACADEMIC MANAGEMENT (Admins & Teachers Only) -->
        {{-- @canany(['academic.classes', 'academic.subjects', 'academic.routines']) --}}
            <li>
                <a href="#academicSubCollapse" 
                   class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('academic*') ? 'active-group' : '' }}"
                   data-bs-toggle="collapse" 
                   data-bs-target="#academicSubCollapse"
                   role="button"
                   aria-expanded="{{ request()->is('academic*') ? 'true' : 'false' }}">
                    <div>
                        <i class="fa-solid fa-school me-3"></i>Academic Structure
                    </div>
                    <i class="fa-solid fa-chevron-down small transition-icon"></i>
                </a>

                <div class="collapse {{ request()->is('academic*') ? 'show' : '' }}" id="academicSubCollapse">
                    <ul class="list-unstyled ps-4">
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-layer-group me-2"></i>Class & Sections
                            </a>
                        </li>
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-book-open me-2"></i>Subject Mapping
                            </a>
                        </li>
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-calendar-days me-2"></i>Class Routines
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        {{-- @endcanany --}}

        <!-- MODULE 3: STUDENT REGISTRY -->
        {{-- @canany(['students.view', 'students.create']) --}}
            <li>
                <a href="#studentCollapse" 
                   class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('students*') ? 'active-group' : '' }}"
                   data-bs-toggle="collapse" 
                   data-bs-target="#studentCollapse"
                   role="button"
                   aria-expanded="{{ request()->is('students*') ? 'true' : 'false' }}">
                    <div>
                        <i class="fa-solid fa-users me-3 text-warning"></i>Student Portal
                    </div>
                    <i class="fa-solid fa-chevron-down small transition-icon"></i>
                </a>

                <div class="collapse {{ request()->is('students*') ? 'show' : '' }}" id="studentCollapse">
                    <ul class="list-unstyled ps-4">
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-address-book me-2"></i>Student Directory
                            </a>
                        </li>
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-user-plus me-2"></i>New Registration
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        {{-- @endcanany --}}

        <!-- MODULE 4: EXAMINATION & MARKINGS -->
        {{-- @canany(['exams.view', 'exams.results']) --}}
            <li>
                <a href="#examCollapse" 
                   class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('exams*') ? 'active-group' : '' }}"
                   data-bs-toggle="collapse" 
                   data-bs-target="#examCollapse"
                   role="button"
                   aria-expanded="{{ request()->is('exams*') ? 'true' : 'false' }}">
                    <div>
                        <i class="fa-solid fa-file-signature me-3"></i>Exams & Grading
                    </div>
                    <i class="fa-solid fa-chevron-down small transition-icon"></i>
                </a>

                <div class="collapse {{ request()->is('exams*') ? 'show' : '' }}" id="examCollapse">
                    <ul class="list-unstyled ps-4">
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-pen-to-square me-2"></i>Grade Book Entry
                            </a>
                        </li>
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-receipt me-2"></i>Dynamic Marksheets
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        {{-- @endcanany --}}

        <!-- MODULE 5: ATTENDANCE & TRACKING -->
        {{-- @canany(['attendance.view', 'attendance.take']) --}}
            <li>
                <a href="#attendanceCollapse" 
                   class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('attendance*') ? 'active-group' : '' }}"
                   data-bs-toggle="collapse" 
                   data-bs-target="#attendanceCollapse"
                   role="button"
                   aria-expanded="{{ request()->is('attendance*') ? 'true' : 'false' }}">
                    <div>
                        <i class="fa-solid fa-clipboard-user me-3"></i>Attendance
                    </div>
                    <i class="fa-solid fa-chevron-down small transition-icon"></i>
                </a>

                <div class="collapse {{ request()->is('attendance*') ? 'show' : '' }}" id="attendanceCollapse">
                    <ul class="list-unstyled ps-4">
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-user-check me-2"></i>Daily Attendance
                            </a>
                        </li>
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-chart-column me-2"></i>Attendance Reports
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        {{-- @endcanany --}}

        <!-- MODULE 6: ACCOUNTS & FEES -->
        {{-- @canany(['accounts.fees', 'accounts.expenses']) --}}
            <li>
                <a href="#accountsCollapse" 
                   class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('accounts*') ? 'active-group' : '' }}"
                   data-bs-toggle="collapse" 
                   data-bs-target="#accountsCollapse"
                   role="button"
                   aria-expanded="{{ request()->is('accounts*') ? 'true' : 'false' }}">
                    <div>
                        <i class="fa-solid fa-file-invoice-dollar me-3"></i>Finance & Fees
                    </div>
                    <i class="fa-solid fa-chevron-down small transition-icon"></i>
                </a>

                <div class="collapse {{ request()->is('accounts*') ? 'show' : '' }}" id="accountsCollapse">
                    <ul class="list-unstyled ps-4">
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-wallet me-2"></i>Collect Student Fees
                            </a>
                        </li>
                        <li>
                            <a href="#" class="submenu-link">
                                <i class="fa-solid fa-receipt me-2"></i>Invoice Logs
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        {{-- @endcanany --}}
    </ul>

    <!-- Footer Profile Block Inside Sidebar -->
    <div class="p-3 border-top border-white border-opacity-10 mt-auto">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-warning text-dark p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <h6 class="text-white mb-0 text-truncate userNameSidebarDB" style="max-width: 140px; font-size: 16px;"></h6>
                <small class="text-white userRoleSidebarDB" style="font-size: 13px; opacity: 0.8;"></small>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger btn-sm w-100 rounded-3">
                <i class="fa-solid fa-power-off me-2"></i>Log Out
            </button>
        </form>
    </div>
</aside>