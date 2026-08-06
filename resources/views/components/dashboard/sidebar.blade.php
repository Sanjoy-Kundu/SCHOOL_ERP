<style>
    /* ==========================================================================
       Sidebar Vertical Column & Active State Rules (Enforced for all viewports)
       ========================================================================== */

    /* Enforce strictly vertical column structure across all devices */
    #sidebar .sidebar-menu {
        display: flex !important;
        flex-direction: column !important; /* Forces strict vertical column flow */
        flex-wrap: nowrap !important;      /* Prevents items from wrapping horizontally */
        list-style: none !important;
        padding: 1rem 0.75rem !important;
        margin: 0 !important;
    }

    #sidebar .sidebar-menu li {
        width: 100% !important;            /* Each menu item takes full sidebar width */
        display: block !important;         /* Lock as block element for stacking */
    }

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

    <!-- Navigation Menu Items (Forced Vertical Column Flow) -->
    <ul class="sidebar-menu flex-grow-1 nav nav-pills flex-column px-2">
        <!-- MODULE 1: DASHBOARD -->
        <li>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge me-3"></i>Dashboard
            </a>
        </li>

        <li><hr class="border-white border-opacity-10 my-2"></li>

        <!-- MODULE 2: ACADEMIC -->
        <li>
            <a href="#academicCollapse" 
            class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('academic*') ? 'active-group' : '' }}"
            data-bs-toggle="collapse" 
            data-bs-target="#academicCollapse"
            role="button"
            aria-expanded="{{ request()->is('academic*') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-school me-3"></i>Academic
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ request()->is('academic*') ? 'show' : '' }}" id="academicCollapse">
                <ul class="list-unstyled ps-4">
                    <!-- 1. Academic Sessions (e.g., Year 2020-2030 setup) -->
                    <li>
                        <a href="{{url('/academic-session')}}" class="submenu-link">
                            <i class="fa-solid fa-calendar-check me-2"></i>Academic Sessions
                        </a>
                    </li>
                    
                    <!-- 2. Basic Classes (6-10) and Sections (A, B, C or N/A) setup -->
                    <li>
                        <a href="{{url('/academic-classes-sections')}}" class="submenu-link">
                            <i class="fa-solid fa-layer-group me-2"></i>Classes & Sections
                        </a>
                    </li>
                    
                    <!-- 3. Shifts (Morning/Day/N/A) and Groups (Science/Arts/Commerce) setup -->
                    <li>
                        <a href="{{url('/academic-shifts-groups')}}" class="submenu-link">
                            <i class="fa-solid fa-network-wired me-2"></i>Shifts & Groups
                        </a>
                    </li>

                    <!-- 4. Class Setup: Combine Class, Section, Shift & Group for dynamic configuration -->
                    <li>
                        <a href="{{url('/academic-class-setups')}}" class="submenu-link">
                            <i class="fa-solid fa-sliders me-2"></i>Class Setup
                        </a>
                    </li>

                    <!-- 5. Subjects assigned based on Class and Group setups -->
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-book-open me-2"></i>Subjects
                        </a>
                    </li>
                    
                    <!-- 6. Daily schedules, periods, and teacher assignments -->
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-clock me-2"></i>Class Routines
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 3: STUDENTS -->
        <li>
            <a href="#studentCollapse" 
               class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('students*') ? 'active-group' : '' }}"
               data-bs-toggle="collapse" 
               data-bs-target="#studentCollapse"
               role="button"
               aria-expanded="{{ request()->is('students*') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-user-graduate me-3"></i>Students
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
                            <i class="fa-solid fa-user-plus me-2"></i>New Admission
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-arrow-up-right-dots me-2"></i>Promotion
                        </a>
                    </li>
                    <li>
                        <!-- BD Context: Generate RFID/Barcode ID cards for students -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-id-card me-2"></i>ID Card Generator
                        </a>
                    </li>
                    <li>
                        <!-- BD Context: TC & Academic Transcripts/Testimonials -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-file-signature me-2"></i>TC & Testimonials
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 4: TEACHERS & STAFF -->
        <li>
            <a href="#staffCollapse" 
               class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('staff*') || request()->is('teachers*') ? 'active-group' : '' }}"
               data-bs-toggle="collapse" 
               data-bs-target="#staffCollapse"
               role="button"
               aria-expanded="{{ request()->is('staff*') || request()->is('teachers*') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-users-gear me-3"></i>Teachers & Staff
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ request()->is('staff*') || request()->is('teachers*') ? 'show' : '' }}" id="staffCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-chalkboard-user me-2"></i>Teachers
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-user-tie me-2"></i>Staff Directory
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 5: GUARDIANS (Flat Link) -->
        <li>
            <a href="#" class="sidebar-link {{ request()->is('guardians*') ? 'active' : '' }}">
                <i class="fa-solid fa-hands-holding-child me-3"></i>Guardians
            </a>
        </li>

        <!-- MODULE 6: ATTENDANCE -->
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
                            <i class="fa-solid fa-user-check me-2"></i>Student Attendance
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-user-shield me-2"></i>Teacher Attendance
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

        <!-- MODULE 7: EXAMINATIONS -->
        <li>
            <a href="#examCollapse" 
               class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('exams*') ? 'active-group' : '' }}"
               data-bs-toggle="collapse" 
               data-bs-target="#examCollapse"
               role="button"
               aria-expanded="{{ request()->is('exams*') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-file-signature me-3"></i>Examinations
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ request()->is('exams*') ? 'show' : '' }}" id="examCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <!-- BD Context: Changed from 'Exam Terms' to 'Exam Types' (e.g., Half Yearly, Annual, Test) -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-list-check me-2"></i>Exam Types
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-calendar-days me-2"></i>Exam Schedule
                        </a>
                    </li>
                    <li>
                        <!-- BD Context: Traditional Admit card printing is critical before exams -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-ticket me-2"></i>Admit Cards
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-pen-to-square me-2"></i>Marks Entry
                        </a>
                    </li>
                    <li>
                        <!-- BD Context: Support both traditional GPA and New Curriculum Continuous Evaluation (PI/BI) -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-square-poll-horizontal me-2"></i>Results & PI/BI
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-award me-2"></i>Grading System
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 8: FEES & ACCOUNTS -->
        <li>
            <a href="#accountsCollapse" 
               class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('accounts*') || request()->is('fees*') ? 'active-group' : '' }}"
               data-bs-toggle="collapse" 
               data-bs-target="#accountsCollapse"
               role="button"
               aria-expanded="{{ request()->is('accounts*') || request()->is('fees*') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-file-invoice-dollar me-3"></i>Fees & Accounts
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ request()->is('accounts*') || request()->is('fees*') ? 'show' : '' }}" id="accountsCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-tags me-2"></i>Fee Categories
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-sitemap me-2"></i>Fee Structure
                        </a>
                    </li>
                    <li>
                        <!-- BD Context: Assigning fees, waivers, or check individual student ledger -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-user-tag me-2"></i>Student Fees
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-wallet me-2"></i>Collect Fees
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-credit-card me-2"></i>Payment History
                        </a>
                    </li>
                    <li>
                        <!-- BD Context: Managing overall dues, waivers, and sending due notifications -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-file-invoice me-2"></i>Due Management
                        </a>
                    </li>
                    <li>
                        <!-- BD Context: Tracking school's utility, salary, maintenance costs -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-hand-holding-dollar me-2"></i>Expenses
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 9: COMMUNICATION -->
        <li>
            <a href="#communicationCollapse" 
               class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('communication*') ? 'active-group' : '' }}"
               data-bs-toggle="collapse" 
               data-bs-target="#communicationCollapse"
               role="button"
               aria-expanded="{{ request()->is('communication*') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-comments me-3"></i>Communication
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ request()->is('communication*') ? 'show' : '' }}" id="communicationCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-bullhorn me-2"></i>Notice Board
                        </a>
                    </li>
                    <li>
                        <!-- BD Context: Bulk SMS feature for parents -->
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-comment-sms me-2"></i>SMS Center
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-calendar-plus me-2"></i>Events Calendar
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 10: REPORTS (Flat Link) -->
        <li>
            <a href="#" class="sidebar-link {{ request()->is('reports*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie me-3"></i>Reports & Analytics
            </a>
        </li>

       <!-- MODULE 11: USER MANAGEMENT (Active) -->
        <li>
            <a href="#userManagementCollapse" 
               class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('users*') ? 'active-group' : '' }}"
               data-bs-toggle="collapse" 
               data-bs-target="#userManagementCollapse"
               role="button"
               aria-expanded="{{ request()->is('users*') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-users me-3"></i>User Management
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ request()->is('users*') ? 'show' : '' }}" id="userManagementCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <!-- Active: For managing active login accounts of system operators, clerks, or teachers -->
                        <a href="#" class="submenu-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user me-2"></i>System Users
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 12: ACCESS CONTROL (Disabled/Locked in Current Phase - RBAC Strategy) -->
        <li>
            <a href="#accessControlCollapse" 
               class="sidebar-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse" 
               data-bs-target="#accessControlCollapse"
               role="button"
               style="opacity: 0.65;"
               aria-expanded="false">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-user-shield me-3"></i>Access Control
                    <span class="badge bg-secondary ms-2" style="font-size: 8px; padding: 2px 4px;">Locked</span>
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse" id="accessControlCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <!-- Disabled Roles sub-menu -->
                        <a href="javascript:void(0);" 
                           class="submenu-link d-flex align-items-center justify-content-between" 
                           style="pointer-events: none; opacity: 0.55; cursor: not-allowed;"
                           title="Will be implemented in final RBAC phase">
                            <div>
                                <i class="fa-solid fa-shield me-2"></i>Roles
                            </div>
                        </a>
                    </li>
                    <li>
                        <!-- Disabled Permissions sub-menu -->
                        <a href="javascript:void(0);" 
                           class="submenu-link d-flex align-items-center justify-content-between" 
                           style="pointer-events: none; opacity: 0.55; cursor: not-allowed;"
                           title="Will be implemented in final RBAC phase">
                            <div>
                                <i class="fa-solid fa-key me-2"></i>Permissions
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 12: SETTINGS -->
        <li>
            <a href="#settingsCollapse" 
               class="sidebar-link d-flex justify-content-between align-items-center {{ request()->is('settings*') ? 'active-group' : '' }}"
               data-bs-toggle="collapse" 
               data-bs-target="#settingsCollapse"
               role="button"
               aria-expanded="{{ request()->is('settings*') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-sliders me-3"></i>Settings
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ request()->is('settings*') ? 'show' : '' }}" id="settingsCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-circle-info me-2"></i>School Information
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-gear me-2"></i>Academic Configuration
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-sliders me-2"></i>General Settings
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>

    <!-- Footer Profile Block Inside Sidebar -->
    <div class="p-3 border-top border-white border-opacity-10 mt-auto">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-warning text-dark p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <h6 class="text-white mb-0 text-truncate userNameSidebarDB" style="max-width: 140px; font-size: 16px;">Admin User</h6>
                <small class="text-white userRoleSidebarDB" style="font-size: 13px; opacity: 0.8;">Super Admin</small>
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