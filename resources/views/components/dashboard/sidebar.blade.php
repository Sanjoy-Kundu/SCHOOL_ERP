<style>
    /* ==========================================================================
       Sidebar Vertical Column & Active State Rules (Enforced for all viewports)
       ========================================================================== */

    /* Enforce strictly vertical column structure across all devices */
    #sidebar .sidebar-menu {
        display: flex !important;
        flex-direction: column !important;
        flex-wrap: nowrap !important;
        list-style: none !important;
        padding: 1rem 0.75rem !important;
        margin: 0 !important;
    }

    #sidebar .sidebar-menu li {
        width: 100% !important;
        display: block !important;
    }

    /* General Links Hover Effect */
    #sidebar .sidebar-link:hover,
    #sidebar .submenu-link:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: #ffc107 !important;
        text-decoration: none !important;
    }

    /* Active Submenu Link Highlight Styling */
    #sidebar .submenu-link.active {
        background-color: rgba(255, 255, 255, 0.12) !important;
        color: #ffc107 !important;
        font-weight: 700 !important;
        border-left: 3px solid #ffc107 !important;
        border-radius: 0 4px 4px 0 !important;
        padding-left: 10px !important;
    }

    #sidebar .submenu-link.active i {
        color: #ffc107 !important;
    }

    /* Active Parent Link Highlights */
    #sidebar .sidebar-link.active-group {
        color: #ffc107 !important;
        font-weight: 700 !important;
        background-color: rgba(255, 255, 255, 0.05) !important;
        border-radius: 6px !important;
    }

    #sidebar .sidebar-link.active-group i {
        color: #ffc107 !important;
    }

    #sidebar .sidebar-link[aria-expanded="true"] .transition-icon {
        transform: rotate(180deg);
        color: #ffc107 !important;
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
            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active-group' : '' }}">
                <i class="fa-solid fa-gauge me-3"></i>Dashboard
            </a>
        </li>

        <li>
            <hr class="border-white border-opacity-10 my-2">
        </li>

        <!-- MODULE 2: ACADEMIC -->
        <li>
            @php
                $isAcademicActive = request()->is('academic-*') 
                    && !request()->is('academic-subject-list-print*') 
                    && !request()->is('academic-examination-shedule-lists-print*')
                    && !request()->is('academic-subject-assignment-overview*');
            @endphp
            <a href="#academicCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isAcademicActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#academicCollapse" role="button"
                aria-expanded="{{ $isAcademicActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-school me-3"></i>Academic
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isAcademicActive ? 'show' : '' }}" id="academicCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="{{ url('/academic-session') }}"
                            class="submenu-link {{ request()->is('academic-session*') ? 'active' : '' }}">
                            <i class="fa-solid fa-calendar-check me-2"></i>Academic Sessions
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/academic-classes-sections') }}"
                            class="submenu-link {{ request()->is('academic-classes-sections*') ? 'active' : '' }}">
                            <i class="fa-solid fa-layer-group me-2"></i>Classes & Sections
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/academic-shifts-groups') }}"
                            class="submenu-link {{ request()->is('academic-shifts-groups*') ? 'active' : '' }}">
                            <i class="fa-solid fa-network-wired me-2"></i>Shifts & Groups
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/academic-class-setups') }}"
                            class="submenu-link {{ request()->is('academic-class-setups*') ? 'active' : '' }}">
                            <i class="fa-solid fa-sliders me-2"></i>Class Setup
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/academic-subject-papers') }}"
                            class="submenu-link {{ request()->is('academic-subject-papers*') ? 'active' : '' }}">
                            <i class="fa-solid fa-book-open me-2"></i>Subjects & Papers
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/academic-subject-assignments') }}"
                            class="submenu-link {{ request()->is('academic-subject-assignments*') && !request()->is('academic-subject-assignment-overviews*') ? 'active' : '' }}">
                            <i class="fa-solid fa-book-open me-2"></i>Subject Assignment
                        </a>
                    </li>

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
            @php 
                // Check if any route under students module is active
                $isStudentsActive = request()->is('students*'); 
            @endphp
            <a href="#studentCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isStudentsActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#studentCollapse" role="button"
                aria-expanded="{{ $isStudentsActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-user-graduate me-3"></i>STUDENTS CORNER
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isStudentsActive ? 'show' : '' }}" id="studentCollapse">
                <ul class="list-unstyled ps-4">
                    <!-- 1. Student Directory -->
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-address-book me-2"></i>Student Directory
                        </a>
                    </li>
                    
                    <!-- 2. Online Applications (Pre-admission applications list) -->
                    <li>
                        <a href="{{ url('/students/online-applications') }}" 
                           class="submenu-link {{ request()->is('students/online-applications*') ? 'active' : '' }}">
                            <i class="fa-solid fa-laptop-file me-2"></i>Online Applications
                        </a>
                    </li>
                    
                    <!-- 3. New Admission (Official admission form with application ID pull feature) -->
                    <li>
                        <a href="{{ url('/students/new-admission') }}" 
                           class="submenu-link {{ request()->is('students/new-admission*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-plus me-2"></i>New Admission
                        </a>
                    </li>
                    
                    <!-- 4. Promotion -->
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-arrow-up-right-dots me-2"></i>Promotion
                        </a>
                    </li>
                    
                    <!-- 5. ID Card Generator -->
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-id-card me-2"></i>ID Card Generator
                        </a>
                    </li>
                    
                    <!-- 6. TC & Testimonials -->
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-file-signature me-2"></i>TC & Testimonials
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 4: TEACHERS & STAFF -->
        <li>
            @php $isStaffActive = request()->is('staff*') || request()->is('teachers*'); @endphp
            <a href="#staffCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isStaffActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#staffCollapse" role="button"
                aria-expanded="{{ $isStaffActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-users-gear me-3"></i>Teachers & Staff
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isStaffActive ? 'show' : '' }}" id="staffCollapse">
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
            <a href="#" class="sidebar-link {{ request()->is('guardians*') ? 'active-group' : '' }}">
                <i class="fa-solid fa-hands-holding-child me-3"></i>Guardians
            </a>
        </li>

        <!-- MODULE 6: ATTENDANCE -->
        <li>
            @php $isAttendanceActive = request()->is('attendance*'); @endphp
            <a href="#attendanceCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isAttendanceActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#attendanceCollapse" role="button"
                aria-expanded="{{ $isAttendanceActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-clipboard-user me-3"></i>Attendance
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isAttendanceActive ? 'show' : '' }}" id="attendanceCollapse">
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
            @php $isExamActive = request()->is('exams*') || request()->is('exms*'); @endphp
            <a href="#examCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isExamActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#examCollapse" role="button"
                aria-expanded="{{ $isExamActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-file-signature me-3"></i>Examinations
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isExamActive ? 'show' : '' }}" id="examCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="{{ url('/exms/exam-types') }}" 
                           class="submenu-link {{ request()->is('exms/exam-types*') ? 'active' : '' }}">
                            <i class="fa-solid fa-list-check me-2"></i>Exam Types
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/exms/exam-setups') }}" 
                           class="submenu-link {{ request()->is('exms/exam-setups*') ? 'active' : '' }}">
                            <i class="fa-solid fa-list-check me-2"></i>Exam Setups
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/exms/exam-schedules') }}" 
                           class="submenu-link {{ request()->is('exms/exam-schedules*') ? 'active' : '' }}">
                            <i class="fa-solid fa-calendar-days me-2"></i>Exam Schedule
                        </a>
                    </li>
                    <li>
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
            @php $isFeesActive = request()->is('fees*'); @endphp
            <a href="#feesAccountsCollapse" 
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isFeesActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#feesAccountsCollapse" role="button"
                aria-expanded="{{ $isFeesActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-file-invoice-dollar me-3"></i>Fees & Accounts
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isFeesActive ? 'show' : '' }}" id="feesAccountsCollapse">
                <ul class="list-unstyled ps-4">
                    <!-- FEE SETUP -->
                    <li class="small text-uppercase text-white text-opacity-50 fw-bold mt-2 mb-1"
                        style="font-size: 10px; letter-spacing: .5px;">
                        Fee Setup
                    </li>

                    <li>
                        <a href="{{ url('/fees-categories') }}" 
                           class="submenu-link {{ request()->is('fees-categories*') ? 'active' : '' }}">
                            <i class="fa-solid fa-tags me-2"></i>Fee Categories
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/fees-months') }}" 
                           class="submenu-link {{ request()->is('fees-months*') ? 'active' : '' }}">
                            <i class="fa-solid fa-tags me-2"></i>Month Master
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/fees-structures') }}" 
                           class="submenu-link {{ request()->is('fees-structures*') ? 'active' : '' }}">
                            <i class="fa-solid fa-sitemap me-2"></i>Fee Structures
                        </a>
                    </li>

                    <!-- STUDENT FEES -->
                    <li class="small text-uppercase text-white text-opacity-50 fw-bold mt-3 mb-1"
                        style="font-size: 10px; letter-spacing: .5px;">
                        Student Fees
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-book me-2"></i>Student Fee Ledger
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-wallet me-2"></i>Collect Fees
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-file-invoice me-2"></i>Due Management
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-credit-card me-2"></i>Payment History
                        </a>
                    </li>

                    <!-- ACCOUNTS -->
                    <li class="small text-uppercase text-white text-opacity-50 fw-bold mt-3 mb-1"
                        style="font-size: 10px; letter-spacing: .5px;">
                        Accounts
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-hand-holding-dollar me-2"></i>Expenses
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 9: COMMUNICATION -->
        <li>
            @php $isCommunicationActive = request()->is('communication*'); @endphp
            <a href="#communicationCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isCommunicationActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#communicationCollapse" role="button"
                aria-expanded="{{ $isCommunicationActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-comments me-3"></i>Communication
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isCommunicationActive ? 'show' : '' }}" id="communicationCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-bullhorn me-2"></i>Notice Board
                        </a>
                    </li>
                    <li>
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

        <!-- MODULE 10: REPORTS & PRINT -->
        <li>
            @php
                $isReportsActive = request()->is('academic-subject-list-print*') 
                    || request()->is('academic-examination-shedule-lists-print*')
                    || request()->is('academic-subject-assignment-overview*') 
                    || request()->is('academic-subject-assignments-overview*');
            @endphp
            <a href="#reportsCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isReportsActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#reportsCollapse" role="button"
                aria-expanded="{{ $isReportsActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-print me-3"></i>Reports & Print
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isReportsActive ? 'show' : '' }}" id="reportsCollapse">
                <ul class="list-unstyled ps-4">
                    <!-- Academic Reports Sub-group -->
                    <li class="small text-uppercase text-white text-opacity-50 fw-bold mt-2 mb-1"
                        style="font-size: 10px; letter-spacing: 0.5px;">Academic</li>
                    <li>
                        <a href="{{ url('/academic-subject-list-print') }}"
                            class="submenu-link {{ request()->is('academic-subject-list-print*') ? 'active' : '' }}">
                            <i class="fa-solid fa-book-open me-2"></i>Subject Lists
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-calendar-days me-2"></i>Class Routine
                        </a>
                    </li>

                    <!-- Students Reports Sub-group -->
                    <li class="small text-uppercase text-white text-opacity-50 fw-bold mt-3 mb-1"
                        style="font-size: 10px; letter-spacing: 0.5px;">Students</li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-address-book me-2"></i>Student Roster
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link">
                            <i class="fa-solid fa-id-card me-2"></i>ID Card Print
                        </a>
                    </li>

                    <!-- Examinations -->
                    <li class="small text-uppercase text-white text-opacity-50 fw-bold mt-3 mb-1"
                        style="font-size: 10px; letter-spacing: 0.5px;">Examinations</li>
                    <li>
                        <a href="{{ url('/academic-examination-shedule-lists-print') }}"
                            class="submenu-link {{ request()->is('academic-examination-shedule-lists-print*') ? 'active' : '' }}">
                            <i class="fa-solid fa-calendar-check me-2"></i>Exam Schedule
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 11: USER MANAGEMENT -->
        <li>
            @php $isUserActive = request()->is('users*'); @endphp
            <a href="#userManagementCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isUserActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#userManagementCollapse" role="button"
                aria-expanded="{{ $isUserActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-users me-3"></i>User Management
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isUserActive ? 'show' : '' }}" id="userManagementCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="#" class="submenu-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user me-2"></i>System Users
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- MODULE 12: ACCESS CONTROL (Locked Phase) -->
        <li>
            <a href="#accessControlCollapse" class="sidebar-link d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" data-bs-target="#accessControlCollapse" role="button"
                style="opacity: 0.65;" aria-expanded="false">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-user-shield me-3"></i>Access Control
                    <span class="badge bg-secondary ms-2" style="font-size: 8px; padding: 2px 4px;">Locked</span>
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse" id="accessControlCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
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

        <!-- MODULE 13: SETTINGS -->
        <li>
            @php $isSettingsActive = request()->is('settings*'); @endphp
            <a href="#settingsCollapse"
                class="sidebar-link d-flex justify-content-between align-items-center {{ $isSettingsActive ? 'active-group' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#settingsCollapse" role="button"
                aria-expanded="{{ $isSettingsActive ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-sliders me-3"></i>Settings
                </div>
                <i class="fa-solid fa-chevron-down small transition-icon"></i>
            </a>

            <div class="collapse {{ $isSettingsActive ? 'show' : '' }}" id="settingsCollapse">
                <ul class="list-unstyled ps-4">
                    <li>
                        <a href="{{ url('/settings/school-information') }}" 
                           class="submenu-link {{ request()->is('settings/school-information*') ? 'active' : '' }}">
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
            <div class="bg-warning text-dark p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px;">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <h6 class="text-white mb-0 text-truncate userNameSidebarDB"
                    style="max-width: 140px; font-size: 16px;">Admin User</h6>
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