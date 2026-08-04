@push('styles')
<style>
    @media (max-width: 575.98px) {
        .card-responsive { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important; }
        .container-responsive { padding-left: 10px !important; padding-right: 10px !important; }
    }
    
    .dashboard-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #edf2f9;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.01);
        transition: transform 0.2s ease-in-out;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
    }
</style>
@endpush

<!-- Dashboard Content Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Executive Dashboard</h1>
        <p class="text-muted small mb-0">Overview of school administration logs, attendance, and admissions.</p>
    </div>
</div>

<!-- Main Content Grid Layout -->
<div class="row g-4">
    <!-- Left Main Column (Stats, Chart, and Table) -->
    <div class="col-12 col-xl-8">
        
        <!-- Stats Cards Row (Dynamic or Static Fallback) -->
        <div class="row g-3 mb-4">
            <!-- 1. Fees Collection Card: Restricted to Accounts/Admin -->
            @can('dashboard.view_revenue')
                <div class="col-12 col-sm-6">
                    <div class="card dashboard-card p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted small mb-1 fw-semibold text-uppercase">Monthly Fees Collection</h6>
                                <h3 class="fw-bold mb-0 text-dark" id="monthlyFeesVal">৳১,৪৫,২০০.০০</h3>
                            </div>
                            <span class="bg-primary-subtle text-primary p-3 rounded-4">
                                <i class="fa-solid fa-wallet fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- 2. Active Students Card: Accessible to Teachers/Admin -->
            @can('dashboard.view_stats')
                <div class="col-12 col-sm-6 {{ !auth()->user()->can('dashboard.view_revenue') ? 'col-sm-12' : '' }}">
                    <div class="card dashboard-card p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted small mb-1 fw-semibold text-uppercase">Total Registered Students</h6>
                                <h3 class="fw-bold mb-0 text-dark" id="totalStudentsVal">৮৪৫ জন</h3>
                            </div>
                            <span class="bg-success-subtle text-success p-3 rounded-4">
                                <i class="fa-solid fa-users fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            @endcan
        </div>

        <!-- 3. Attendance Analytics Chart (Classes 6 - 10) -->
        @can('dashboard.view_analytics')
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-chart-area me-2 text-primary"></i>Average Class Attendance (%)
                </h5>
                <div style="height: 250px;">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>
        @endcan

        <!-- 4. Recent Student Admissions Table -->
        @can('dashboard.view_users')
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-address-book me-2 text-info"></i>Recent Student Admissions
                </h5>
                
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>Student Details</th>
                                <th>Roll Number</th>
                                <th>Class & Group</th>
                                <th>Status</th>
                                <th>Admission Date</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody"> </tbody>
                    </table>
                </div>
            </div>
        @endcan

    </div>

    <!-- Right Sidebar Column -->
    <div class="col-12 col-xl-4">
        <!-- 5. Quick Class Teacher Assign Widget -->
        @can('dashboard.assign_tasks')
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-sitemap me-2 text-warning"></i>Class Teacher Assignment
                </h5>
                <p class="text-muted small">Select a class to dynamically load and assign a class teacher.</p>
                
                <div class="mb-3">
                    <label for="classSelect" class="form-label fw-semibold small">Select Class</label>
                    <select class="form-select rounded-3" id="classSelect">
                        <option value="" selected disabled>Choose Class...</option>
                        <option value="class_6">Class 6 (৬ষ্ঠ)</option>
                        <option value="class_7">Class 7 (৭ম)</option>
                        <option value="class_8">Class 8 (৮ম)</option>
                        <option value="class_9">Class 9 (৯ম)</option>
                        <option value="class_10">Class 10 (১০ম)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="teacherSelect" class="form-label fw-semibold small">Select Class Teacher</label>
                    <select class="form-select rounded-3" id="teacherSelect" disabled>
                        <option value="" selected disabled>Please select class first...</option>
                    </select>
                </div>
                
                <button class="btn btn-primary w-100 rounded-3 mt-2" id="assignBtn" disabled>
                    <i class="fa-solid fa-user-plus me-1"></i>Assign Class Teacher
                </button>
            </div>
        @endcan

        <!-- 6. Academic System Health/Overview Widget -->
        @can('dashboard.view_health')
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-circle-check me-2 text-success"></i>School Daily Overview
                </h5>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                        <span><i class="fa-solid fa-chalkboard-user text-muted me-2"></i>Teacher's Attendance</span>
                        <span class="badge bg-success-subtle text-success">Optimal (96%)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                        <span><i class="fa-solid fa-database text-muted me-2"></i>Academic Database</span>
                        <span class="badge bg-success-subtle text-success">Healthy Sync</span>
                    </li>
                </ul>
            </div>
        @endcan
    </div>
</div>

@push('scripts')
<script>
// Static Data Fallback for Students (Classes 6-10)
const STATIC_STUDENTS = [
    {
        name: 'Sadia Islam Mim',
        email: 'sadia@gmail.com',
        roll: '6001',
        class_group: 'Class 6 - General',
        status: 'Active',
        joined_date: '2026-01-05'
    },
    {
        name: 'Rafiqul Hasan Rifat',
        email: 'rafiqul@gmail.com',
        roll: '9012',
        class_group: 'Class 9 - Science',
        status: 'Active',
        joined_date: '2026-01-08'
    },
    {
        name: 'Anika Rahman',
        email: 'anika@gmail.com',
        roll: '8025',
        class_group: 'Class 8 - General',
        status: 'Active',
        joined_date: '2026-01-10'
    },
    {
        name: 'Tanvir Ahmed Shanto',
        email: 'tanvir@gmail.com',
        roll: '1004',
        class_group: 'Class 10 - Business Studies',
        status: 'Active',
        joined_date: '2026-01-11'
    },
    {
        name: 'Nusrat Jahan Chowdhury',
        email: 'nusrat@gmail.com',
        roll: '9089',
        class_group: 'Class 9 - Humanities',
        status: 'Inactive',
        joined_date: '2026-01-15'
    }
];

// Static Data for Teachers based on selected Class
const TEACHER_LIST_MAPPING = {
    class_6: ['Mr. Kamal Hossain (Math)', 'Ms. Rumana Akter (English)'],
    class_7: ['Mr. Shah Alam (Science)', 'Ms. Sultana Razia (Bangla)'],
    class_8: ['Mr. Anwarul Kabir (ICT)', 'Ms. Farhana Yeasmin (BGS)'],
    class_9: ['Dr. Harun-ur-Rashid (Physics)', 'Mr. Shafiqul Islam (Chemistry)'],
    class_10: ['Mr. Abu Bakar (Accounting)', 'Ms. Taskia Tabassum (Biology)']
};

/**
 * Render dynamic/static student details to table
 */
function renderUsers(students) {
    if (!$('#userTableBody').length) return;

    const rows = students.map(student => `
        <tr>
            <td>
                <strong>${student.name}</strong><br>
                <small class="text-muted">${student.email}</small>
            </td>
            <td>
                <span class="badge bg-secondary px-3 py-1">
                    ${student.roll}
                </span>
            </td>
            <td>${student.class_group}</td>
            <td>
                <span class="badge ${
                    student.status === 'Active'
                        ? 'bg-success-subtle text-success'
                        : 'bg-danger-subtle text-danger'
                } rounded-pill px-3 py-1">
                    ${student.status}
                </span>
            </td>
            <td>${student.joined_date}</td>
        </tr>
    `).join('');

    $('#userTableBody').html(rows);
}

/**
 * Initialize DataTable safely
 */
function initializeDataTable() {
    if (!$('#userTable').length) return;

    if ($.fn.DataTable.isDataTable('#userTable')) {
        $('#userTable').DataTable().destroy();
    }

    $('#userTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 20, 50],
        responsive: true,
        language: {
            search: 'Quick Search Student:',
            lengthMenu: 'Show _MENU_ records'
        }
    });
}

/**
 * Fetch dynamic database stats if API is ready, else default to Static
 */
async function loadDashboardData() {
    let students = [...STATIC_STUDENTS];

    try {
        const response = await axios.get('/api/auth/details');

        // Check if DB response is valid and dynamically replace stats
        if (response.data?.status && response.data?.data) {
            const user = response.data.data;
            
            // Dynamically replace with real user data if fetched
            students = [
                {
                    name: user.name ?? 'No Name',
                    email: user.email ?? 'No Email',
                    roll: 'Admin',
                    class_group: user.role?.name ?? 'No Role',
                    status: 'Active',
                    joined_date: user.created_at ? user.created_at.split('T')[0] : '-'
                }
            ];
        }
    } catch (error) {
        console.warn('Dashboard statistics API offline. Loading static fallback dataset.');
    }

    renderUsers(students);
    initializeDataTable();
}

/**
 * Initialize ChartJS with Class 6 - 10 Attendance Statistics
 */
function initializeGrowthChart() {
    if (!$('#growthChart').length) return;

    const ctx = document.getElementById('growthChart').getContext('2d');
    
    // Dynamically retrieve theme primary color or use fallback blue
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim() || '#0d6efd';

    new Chart(ctx, {
        type: 'bar', // Bar chart representing static average class attendance rates
        data: {
            labels: ['Class 6', 'Class 7', 'Class 8', 'Class 9', 'Class 10'],
            datasets: [{
                label: 'Attendance Rate (%)',
                data: [94, 88, 91, 95, 96], // Static attendance averages
                backgroundColor: primaryColor + '20', // Add transparent hex opacity
                borderColor: primaryColor,
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
}

// Handle Class and Dynamic Teacher dropdown interactions
$(document).ready(function () {
    loadDashboardData();
    initializeGrowthChart();

    // Trigger teacher loads dynamically when a Class is selected
    $('#classSelect').on('change', function() {
        const classVal = $(this).val();
        const teacherSelect = $('#teacherSelect');
        const assignBtn = $('#assignBtn');

        teacherSelect.prop('disabled', false).html('<option value="" selected disabled>Choose Class Teacher...</option>');
        
        if (TEACHER_LIST_MAPPING[classVal]) {
            TEACHER_LIST_MAPPING[classVal].forEach(teacher => {
                teacherSelect.append(`<option value="${teacher}">${teacher}</option>`);
            });
            assignBtn.prop('disabled', false);
        }
    });

    // Handle Assign Button Click with SweetAlert Confirmation
    $('#assignBtn').on('click', function() {
        const selectedClass = $('#classSelect option:selected').text();
        const selectedTeacher = $('#teacherSelect').val();

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Teacher Assigned!',
                text: `${selectedTeacher} has been successfully assigned to ${selectedClass}.`,
                confirmButtonColor: '#0d6efd'
            });
        } else {
            alert(`${selectedTeacher} assigned to ${selectedClass}`);
        }
    });
});
</script>
@endpush