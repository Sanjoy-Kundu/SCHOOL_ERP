@push('styles')
<style>
    /* Dynamic responsive design CSS for Workspace Panels */
    @media (max-width: 575.98px) {
        .card-responsive { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important; }
        .container-responsive { padding-left: 10px !important; padding-right: 10px !important; }
        .title-responsive { font-size: 1.5rem !important; }
    }
    @media (min-width: 576px) and (max-width: 991.98px) {
        .card-responsive { border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }
        .title-responsive { font-size: 1.8rem !important; }
    }
    @media (min-width: 992px) {
        .card-responsive { border-radius: 20px !important; box-shadow: 0 12px 40px rgba(0,0,0,0.06) !important; }
    }

    .form-switch .form-check-input {
        width: 2.2em;
        height: 1.15em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #004d40; /* Classic Bangladeshi School Green */
        border-color: #004d40;
    }

    /* Custom DataTables CSS */
    #assignmentsTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #assignmentsTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">বিষয় এসাইনমেন্ট (Subject Assignment)</h1>
            <p class="text-muted small mb-0">শ্রেণী কাঠামো (Class Setup) অনুযায়ী মাস্টার বিষয়, ঐচ্ছিক বিভাগ এবং স্বাধীন পত্রসমূহ ম্যাপিং করুন।</p>
            <button class="btn btn-primary btn-sm mt-2"><a href="{{url('/academic-subject-assignment-overviews')}}" style="text-decoration: none; color:white">বিষয় ভিত্তিক ওভারভিউ</a></button>
        </div>
    </div>

    <div class="row g-4 flex-column-reverse flex-lg-row">
        <!-- Left Column: Interactive Assignments List DataTable -->
        <div class="col-12 {{ auth()->user()->can('subject_assignments.create') ? 'col-xl-8 col-lg-7' : 'col-xl-12' }}" id="tableCard">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                
                <!-- Dynamic Filter Header Panel -->
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-graduation-cap text-success me-2"></i>বিদ্যালয়ের বিষয় বিন্যাস তালিকা
                    </h5>
                    <!-- Dynamic Live Filter Dropdown -->
                    <div style="min-width: 250px;">
                        <select class="form-select form-select-sm rounded-3" id="filterClassSetup">
                            <option value="">সকল শ্রেণী কাঠামো (Show All)</option>
                        </select>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table id="assignmentsTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>সিরিয়াল নং</th>
                                <th>শ্রেণী কাঠামো</th>
                                <th>বিষয় ও পত্র</th>
                                <th>মাস্টার বিভাগ</th>
                                <th>ধরণ</th>
                                <th>অবস্থা</th>
                                {{-- @canany(['subject_assignments.edit', 'subject_assignments.delete']) --}}
                                    <th class="text-end">অ্যাকশন</th>
                                {{-- @endcanany --}}
                            </tr>
                        </thead>
                        <tbody id="assignmentsTableBody">
                            <tr>
                                <td colspan="{{ auth()->user()->canAny(['subject_assignments.edit', 'subject_assignments.delete']) ? 7 : 6 }}" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">বিন্যাস তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Create / Edit Subject Assignment Form -->
        {{-- @canany(['subject_assignments.create', 'subject_assignments.edit']) --}}
            <div class="col-12 col-xl-4 col-lg-5 {{ !auth()->user()->can('subject_assignments.create') ? 'd-none' : '' }}" id="formCard">
                <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                    <h5 class="fw-bold text-dark mb-3" id="formTitle">
                        <i class="fa-solid fa-sliders me-2 text-warning"></i>Assign Subject
                    </h5>
                    <p class="text-muted small" id="formDesc">শ্রেণীর সাথে ডাইনামিক বিষয়, বিভাগ এবং পত্রসমূহ ম্যাপ করুন।</p>
                    
                    <form id="subjectAssignmentCreateForm" novalidate>
                        <!-- Hidden input to store Assignment ID when editing -->
                        <input type="hidden" id="editAssignmentId" value="">

                        <!-- Class Setup Dropdown (Required) -->
                        <div class="mb-3">
                            <label for="classSetupId" class="form-label fw-semibold small text-dark">শ্রেণী কাঠামো (Class Setup) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6 form-control-academic" id="classSetupId" required>
                                <option value="" selected disabled>শ্রেণী কাঠামো নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-class-setup-id"></div>
                        </div>

                        <!-- Dynamic Setup Info Display Panel -->
                        <div class="mb-3 p-3 bg-light rounded-3 d-none" id="setupDetailsPanel">
                            <span class="small d-block text-secondary mb-1 fw-bold"><i class="fa-solid fa-circle-info text-info me-1"></i> নির্বাচিত শ্রেণীর বিবরণী:</span>
                            <div class="d-flex flex-wrap gap-2 mt-1">
                                <span class="badge bg-success-subtle text-success px-2 py-1.5" id="infoClass"></span>
                                <span class="badge bg-info-subtle text-info px-2 py-1.5" id="infoSection"></span>
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1.5" id="infoShift"></span>
                            </div>
                        </div>

                        <!-- Subject Dropdown (Required) -->
                        <div class="mb-3">
                            <label for="subjectId" class="form-label fw-semibold small text-dark">বিষয় (Subject) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6 form-control-academic" id="subjectId" required>
                                <option value="" selected disabled>বিষয় নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-subject-id"></div>
                        </div>

                        <!-- Toggle Switch to show optional Group -->
                        <div class="mb-3 form-check form-switch p-0 ps-5 fs-7">
                            <input class="form-check-input ms-5" type="checkbox" role="switch" id="toggleGroup">
                            <label class="form-check-label fw-semibold text-secondary ps-2" for="toggleGroup">বিভাগ আছে কি? (Has Group?)</label>
                        </div>

                        <!-- Optional Group Dropdown (Hidden initially, slides down on toggle check) -->
                        <div class="mb-3 d-none" id="groupDropdownContainer">
                            <label for="groupId" class="form-label fw-semibold small text-secondary">বিভাগ (Group)</label>
                            <select class="form-select form-select-lg rounded-3 fs-6 form-control-academic" id="groupId">
                                <option value="" selected disabled>বিভাগ নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-group-id"></div>
                        </div>

                        <!-- Subject Category Type: Compulsory / 4th Subject -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark d-block">বিষয়ের ধরণ (Subject Type) <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_fourth_subject" id="compulsoryType" value="0" checked>
                                <label class="form-check-label small fw-semibold" for="compulsoryType">আবশ্যিক বিষয় (Compulsory)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_fourth_subject" id="optionalType" value="1">
                                <label class="form-check-label small fw-semibold" for="optionalType">৪র্থ বিষয় (4th Subject)</label>
                            </div>
                        </div>

                        <!-- Toggle Switch to show optional Paper -->
                        <div class="mb-3 form-check form-switch p-0 ps-5 fs-7">
                            <input class="form-check-input ms-5" type="checkbox" role="switch" id="togglePaper">
                            <label class="form-check-label fw-semibold text-secondary ps-2" for="togglePaper">কোনো নির্দিষ্ট পত্র আছে কি? (Has Paper?)</label>
                        </div>

                        <!-- Optional Paper Dropdown (Hidden initially, slides down on toggle check) -->
                        <div class="mb-3 d-none" id="paperDropdownContainer">
                            <label for="paperId" class="form-label fw-semibold small text-secondary">পত্রের নাম (Paper)</label>
                            <select class="form-select form-select-lg rounded-3 fs-6 form-control-academic" id="paperId">
                                <option value="" selected disabled>পত্রের নাম নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-paper-id"></div>
                        </div>

                        <!-- Optional Subject / Paper Code Input -->
                        <div class="mb-3">
                            <label for="subjectCode" class="form-label fw-semibold small text-dark">বিষয় / পত্রের কোড (Code)</label>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6 text-uppercase" id="subjectCode" placeholder="উদা: 101, 103, 105">
                            <div class="invalid-feedback" id="error-code"></div>
                        </div>

                        <!-- Is Active Toggle Switch -->
                        <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                            <label class="fw-semibold small text-muted mb-0" for="status">অবস্থা (Active Status)</label>
                            <input class="form-check-input m-0" type="checkbox" role="switch" id="status" checked>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                            Assign Subject
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="resetBtn" style="display: none;">
                            <i class="fa-solid fa-rotate-left me-1"></i>Cancel Edit
                        </button>
                    </form>
                </div>
            </div>
        {{-- @endcanany --}}
    </div>
</div>

@push('scripts')
<!-- DataTables Bootstrap 5 CSS & JS Integration Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// 1. Pass Sptie Gate Authorization States to JavaScript
const canCreateAssignment = @json(auth()->user()->can('subject_assignments.create'));
const canEditAssignment = @json(auth()->user()->can('subject_assignments.edit'));
const canDeleteAssignment = @json(auth()->user()->can('subject_assignments.delete'));

// Caches globally to maintain high-performance live rendering
let activeClassSetups = [];
let allAssignmentsData = [];

// English to Bangla Digit Converter Utility
function convertToBanglaNumber(number) {
    const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
    return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
}

// BD Timezone Date Formatter
function formatBDDate(dateString) {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('en-BD', {
        timeZone: 'Asia/Dhaka',
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}

// 2. Render Table Rows dynamically with client-side Gate Protection
function renderAssignments(assignments) {
    const rows = assignments.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditAssignment || canDeleteAssignment) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            <li><a class="dropdown-item assignmentEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>
                            <li><a class="dropdown-item assignmentDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>
                        </ul>
                    </div>
                </td>
            `;
        }

        const banglaSerial = convertToBanglaNumber(index + 1);

        // Build simplified human-readable Class Setup text
        const className = item.class_setup?.class ? item.class_setup.class.name : '—';
        const sectionName = item.class_setup?.section ? ` - ${item.class_setup.section.name}` : '';
        const shiftName = item.class_setup?.shift ? ` (${item.class_setup.shift.name})` : '';
        const classSetupText = `${className}${sectionName}${shiftName}`;

        const subjectName = item.subject ? item.subject.name : '—';
        const paperName = item.paper ? ` <span class="badge bg-light text-dark border px-2 py-1 small" style="font-size: 11px;"><i class="fa-solid fa-caret-right text-success me-1"></i>${item.paper.name}</span>` : '';
        const subjectCode = item.code ? ` <code class="bg-light px-2.5 py-1.5 rounded fw-bold text-dark small" style="font-size: 11px;">${item.code}</code>` : '';
        
        const groupName = item.group ? `<span class="badge bg-primary px-2.5 py-1.5 rounded-pill">${item.group.name}</span>` : '—';
        const subjectType = item.is_fourth_subject ? '<span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill">৪র্থ বিষয় (4th)</span>' : '<span class="badge bg-secondary px-2.5 py-1.5 rounded-pill">আবশ্যিক</span>';

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td class="fw-semibold text-dark">${classSetupText}</td>
                <td>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <strong>${subjectName}</strong>
                        ${paperName}
                        ${subjectCode}
                    </div>
                </td>
                <td>${groupName}</td>
                <td>${subjectType}</td>
                <td>
                    <span class="badge ${item.status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                        ${item.status ? 'সক্রিয়' : 'নিষ্ক্রিয়'}
                    </span>
                </td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#assignmentsTableBody').html(rows);
}

// DataTables Initialization
function initializeAssignmentsDataTable() {
    if ($.fn.DataTable.isDataTable('#assignmentsTable')) {
        $('#assignmentsTable').DataTable().destroy();
    }

    $('#assignmentsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves natural sorting order defined on server side on load
        columnDefs: [
            { orderable: false, targets: (canEditAssignment || canDeleteAssignment) ? [0, 6] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// Filter lists dynamically based on custom dropdown selections
function filterAndRenderList() {
    const selectedFilterId = $('#filterClassSetup').val();
    let filteredData = allAssignmentsData;

    // Toggle live view button visibility based on selective filtering
    if (selectedFilterId) {
        $('#viewSetupSubjectsBtn').removeClass('d-none');
        filteredData = allAssignmentsData.filter(item => item.class_setup_id == selectedFilterId);
    } else {
        $('#viewSetupSubjectsBtn').addClass('d-none');
    }

    renderAssignments(filteredData);
    initializeAssignmentsDataTable();
}

// 3. Load all workspace assignments dynamically
async function loadAssignmentsList() {
    allAssignmentsData = [];
    if ($.fn.DataTable.isDataTable('#assignmentsTable')) {
        $('#assignmentsTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/subject-assignment-lists');
        if (response.data?.status && response.data?.all_data) {
            allAssignmentsData = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load classes subject assignments.');
    }

    filterAndRenderList(); // Render table obeying active dropdown filters
}

// 4. Fetch dynamic dropdown datasets from active master tables
async function loadFormDropdowns() {
    try {
        const [setupsRes, subjectsRes, groupsRes, papersRes] = await axios.all([
            axios.get('/api/class-setup-lists'),
            axios.get('/api/subject-lists'),
            axios.get('/api/group-lists'),
            axios.get('/api/paper-lists')
        ]);

        // Populate active Class Setups and temporarily cache them locally
        if (setupsRes.data?.status && setupsRes.data?.all_data) {
            activeClassSetups = setupsRes.data.all_data;
            
            // Build dropdown selection
            let setupOptions = '<option value="" selected disabled>শ্রেণী কাঠামো নির্বাচন করুন...</option>';
            let filterSetupOptions = '<option value="">সকল শ্রেণী কাঠামো (Show All)</option>';

            activeClassSetups.forEach(item => {
                const className = item.class ? item.class.name : '—';
                const sectionName = item.section ? ` - ${item.section.name}` : '';
                const shiftName = item.shift ? ` (${item.shift.name})` : '';
                const classSetupText = `${className}${sectionName}${shiftName}`;

                setupOptions += `<option value="${item.id}">${classSetupText}</option>`;
                filterSetupOptions += `<option value="${item.id}">${classSetupText}</option>`;
            });

            $('#classSetupId').html(setupOptions);
            $('#filterClassSetup').html(filterSetupOptions);
        }

        // Populate active Subjects
        if (subjectsRes.data?.status && subjectsRes.data?.all_data) {
            let subjectOptions = '<option value="" selected disabled>বিষয় নির্বাচন করুন...</option>';
            subjectsRes.data.all_data.forEach(item => {
                subjectOptions += `<option value="${item.id}">${item.name}</option>`;
            });
            $('#subjectId').html(subjectOptions);
        }

        // Populate active Groups
        if (groupsRes.data?.status && groupsRes.data?.all_data) {
            let groupOptions = '<option value="" selected disabled>বিভাগ নির্বাচন করুন...</option>';
            groupsRes.data.all_data.forEach(item => {
                groupOptions += `<option value="${item.id}">${item.name}</option>`;
            });
            $('#groupId').html(groupOptions);
        }

        // Populate active Papers
        if (papersRes.data?.status && papersRes.data?.all_data) {
            let paperOptions = '<option value="" selected disabled>পত্রের নাম নির্বাচন করুন...</option>';
            papersRes.data.all_data.forEach(item => {
                paperOptions += `<option value="${item.id}">${item.name}</option>`;
            });
            $('#paperId').html(paperOptions);
        }

    } catch (error) {
        console.warn('Failed to populate form datasets.');
    }
}

// Trigger live filtering upon dropdown change
$('#filterClassSetup').on('change', function() {
    filterAndRenderList();
});

// Dynamic info panel binding upon Setup select change
$('#classSetupId').on('change', function() {
    const selectedId = $(this).val();
    const match = activeClassSetups.find(item => item.id == selectedId);
    
    if (match) {
        $('#infoClass').text(`শ্রেণী: ${match.class ? match.class.name : '—'}`);
        $('#infoSection').text(`শাখা: ${match.section ? match.section.name : '—'}`);
        $('#infoShift').text(`শিফট: ${match.shift ? match.shift.name : '—'}`);
        $('#setupDetailsPanel').removeClass('d-none');
    } else {
        $('#setupDetailsPanel').addClass('d-none');
    }
});

// Show/Hide Group dropdown based on switch toggle state
$('#toggleGroup').on('change', function() {
    const isChecked = $(this).is(':checked');
    if (isChecked) {
        $('#groupDropdownContainer').removeClass('d-none');
    } else {
        $('#groupDropdownContainer').addClass('d-none');
        $('#groupId').val(''); // Reset selected group value to NULL
    }
});

// Show/Hide Paper dropdown based on switch toggle state
$('#togglePaper').on('change', function() {
    const isChecked = $(this).is(':checked');
    if (isChecked) {
        $('#paperDropdownContainer').removeClass('d-none');
    } else {
        $('#paperDropdownContainer').addClass('d-none');
        $('#paperId').val(''); // Reset selected paper value to NULL
    }
});

// Reset Form State
function resetFormState() {
    $('#editAssignmentId').val('');
    $('#classSetupId').val('').removeClass('is-invalid');
    $('#subjectId').val('').removeClass('is-invalid');
    
    // Reset Group toggle and input container
    $('#toggleGroup').prop('checked', false);
    $('#groupDropdownContainer').addClass('d-none');
    $('#groupId').val('').removeClass('is-invalid');

    // Reset Paper toggle and input container
    $('#togglePaper').prop('checked', false);
    $('#paperDropdownContainer').addClass('d-none');
    $('#paperId').val('').removeClass('is-invalid');

    $('#subjectCode').val('').removeClass('is-invalid');
    $('#compulsoryType').prop('checked', true);
    $('#status').prop('checked', true);
    
    // Hide details panel
    $('#setupDetailsPanel').addClass('d-none');

    // Clear Validation Errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

    $('#formTitle').html('<i class="fa-solid fa-sliders me-2 text-warning"></i>Assign Subject');
    $('#formDesc').text('শ্রেণীর সাথে ডাইনামিক বিষয়, বিভাগ এবং পত্রসমূহ ম্যাপ করুন।');
    
    $('#submitBtn').prop('disabled', false).text('Assign Subject').css('background-color', '#004d40');
    $('#resetBtn').hide();

    // Dynamically collapse and hide form card if the user is authorized to edit but not create
    if (!canCreateAssignment && canEditAssignment) {
        $('#formCard').addClass('d-none');
        $('#tableCard').removeClass('col-xl-8 col-lg-7').addClass('col-xl-12');
    }
}

// Reset button click trigger
$('#resetBtn').on('click', function() {
    resetFormState();
});

// 5. Submit Form (Handles Create and Update using AJAX API calls)
const createFormElement = document.getElementById('subjectAssignmentCreateForm');
if (createFormElement) {
    createFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const classSetupIdInput = document.getElementById('classSetupId');
        const subjectIdInput = document.getElementById('subjectId');
        const groupIdInput = document.getElementById('groupId');
        const paperIdInput = document.getElementById('paperId');
        const subjectCodeInput = document.getElementById('subjectCode');
        const editId = document.getElementById('editAssignmentId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...';

        // Clear previous error styles
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

        const payload = {
            class_setup_id: classSetupIdInput.value,
            subject_id: subjectIdInput.value,
            // Submit value as NULL if toggle group is not checked
            group_id: $('#toggleGroup').is(':checked') ? (groupIdInput.value || null) : null,
            // Submit value as NULL if toggle paper is not checked
            paper_id: $('#togglePaper').is(':checked') ? (paperIdInput.value || null) : null,
            code: subjectCodeInput.value || null,
            is_fourth_subject: $('input[name="is_fourth_subject"]:checked').val(),
            status: document.getElementById('status').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/subject-assignment-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/subject-assignment-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'বিষয় এসাইনমেন্ট হালনাগাদ সম্পন্ন!' : 'বিষয় সফলভাবে এসাইন সম্পন্ন!',
                    text: res.data.message || 'Subject mapping has been configured successfully.',
                    confirmButtonColor: '#004d40'
                });

                resetFormState(); 
                await loadAssignmentsList(); 
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                const generalMessage = error.response.data.message;

                // Bind Laravel validation rules back to client side elements
                if (errors) {
                    if (errors.class_setup_id) {
                        classSetupIdInput.addClass('is-invalid');
                        document.getElementById('error-class-setup-id').innerHTML = errors.class_setup_id[0];
                    }
                    if (errors.subject_id) {
                        subjectIdInput.addClass('is-invalid');
                        document.getElementById('error-subject-id').innerHTML = errors.subject_id[0];
                    }
                    if (errors.group_id) {
                        groupIdInput.addClass('is-invalid');
                        document.getElementById('error-group-id').innerHTML = errors.group_id[0];
                    }
                    if (errors.paper_id) {
                        paperIdInput.addClass('is-invalid');
                        document.getElementById('error-paper-id').innerHTML = errors.paper_id[0];
                    }
                    if (errors.code) {
                        subjectCodeInput.addClass('is-invalid');
                        document.getElementById('error-code').innerHTML = errors.code[0];
                    }
                }
                
                // Trigger warning alert for duplicate validation configurations
                if (generalMessage && !errors) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'সংরক্ষণ ব্যর্থ হয়েছে',
                        text: generalMessage,
                        confirmButtonColor: '#004d40'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'Something went wrong.',
                    confirmButtonColor: '#004d40'
                });
            }
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = editId ? 'Update Configuration' : 'Assign Subject';
        }
    });
}

// 6. jQuery Event Delegation for Edit Button Click (Without Reload)
$('#assignmentsTableBody').on('click', '.assignmentEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/subject-assignment-details/${id}`);

        if (res.data.status === true) {
            const assignment = res.data.data;
            
            // Switch Form column width dynamically for restricted users (Edit only)
            if (!canCreateAssignment && canEditAssignment) {
                $('#formCard').removeClass('d-none');
                $('#tableCard').removeClass('col-xl-12').addClass('col-xl-8 col-lg-7');
            }

            // Switch form to Edit Mode
            $('#formTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit Assignment');
            $('#formDesc').text(`Updating Assignment: #${assignment.id}`);
            $('#editAssignmentId').val(assignment.id);
            $('#classSetupId').val(assignment.class_setup_id).trigger('change');
            $('#subjectId').val(assignment.subject_id);
            
            // Map Group switch state and value
            if (assignment.group_id) {
                $('#toggleGroup').prop('checked', true).trigger('change');
                $('#groupId').val(assignment.group_id);
            } else {
                $('#toggleGroup').prop('checked', false).trigger('change');
            }

            // Map Paper switch state and value
            if (assignment.paper_id) {
                $('#togglePaper').prop('checked', true).trigger('change');
                $('#paperId').val(assignment.paper_id);
            } else {
                $('#togglePaper').prop('checked', false).trigger('change');
            }

            $('#subjectCode').val(assignment.code ?? '');
            $('#status').prop('checked', assignment.status == 1);

            if (assignment.is_fourth_subject) {
                $('#optionalType').prop('checked', true);
            } else {
                $('#compulsoryType').prop('checked', true);
            }

            $('#submitBtn').text('Update Assignment').css('background-color', '#1a237e'); // Primary contrast for edit mode
            $('#resetBtn').show(); 
            
            // Scroll smoothly to form card on mobile devices
            $('html, body').animate({
                scrollTop: $("#subjectAssignmentCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'এসাইনমেন্টের বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// 7. Delete Button Click Event Delegation (SweetAlert2 + Without Reload)
$('#assignmentsTableBody').on('click', '.assignmentDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই বিষয়ের এসাইনমেন্টটি ডিলিট করতে চান?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/subject-assignment-delte/${id}`);

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message || 'The subject assignment has been deleted successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editAssignmentId').val() == id) {
                        resetFormState();
                    }

                    await loadAssignmentsList(); 
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'এসাইনমেন্টটি ডিলিট করতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});

// Load details on document ready
$(document).ready(function () {
    loadFormDropdowns();
    loadAssignmentsList();
});
</script>
@endpush
