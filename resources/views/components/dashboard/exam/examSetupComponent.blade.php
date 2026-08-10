@push('styles')
<style>
    /* Dynamic responsive design CSS for Workspace Panels */
    @media (max-width: 575.98px) {
        .card-responsive { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important; }
        .container-responsive { padding-left: 10px !important; padding-right: 10px !important; }
        .title-responsive { font-size: 1.5rem !important; }
    }
    @media (min-width: 576px) and (max-width: 991.98px) {
        .card-responsive { border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important; }
        .title-responsive { font-size: 1.8rem !important; }
    }
    @media (min-width: 992px) {
        .card-responsive { border-radius: 20px !important; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06) !important; }
    }

    .form-switch .form-check-input {
        width: 2.2em;
        height: 1.15em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #004d40;
        border-color: #004d40;
    }

    /* Custom DataTables CSS to match Shifts/Groups pattern */
    #examSetupsTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #examSetupsTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }

    /* Custom Academic Table Grid Styles inside Modal to match your details table exactly */
    #modalDetailsTable {
        border-collapse: collapse !important;
    }
    #modalDetailsTable thead th {
        font-size: 0.85rem !important;
        font-weight: 700 !important;
        color: #495057 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }
    #modalDetailsTable tbody td {
        font-size: 0.875rem !important;
        color: #000 !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">পরীক্ষা বিন্যাসকরণ (Exam Setup)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের পুনর্ব্যবহারযোগ্য সেশন-স্বাধীন পরীক্ষার কাঠামো (পরীক্ষার ধরণ ও শ্রেণী কাঠামো) সাজান।</p>
        </div>
    </div>

    <div class="row g-4 flex-column-reverse flex-lg-row">
        <!-- Left Column: Master Table List Card -->
        <div class="col-12 {{ auth()->user()->can('exam_setups.create') ? 'col-xl-8 col-lg-7' : 'col-xl-12' }}" id="tableCard">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-file-invoice text-success me-2"></i>সংরক্ষিত পরীক্ষা বিন্যাস তালিকা
                </h5>
                
                <div class="table-responsive">
                    <table id="examSetupsTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>সিরিয়াল নং</th>
                                <th>পরীক্ষার ধরণ</th>
                                <th>শ্রেণী</th>
                                <th>শাখা</th>
                                <th>শিফট</th>
                                <th>বিষয় সংখ্যা</th>
                                <th>অবস্থা</th>
                                @canany(['exam_setups.edit', 'exam_setups.delete'])
                                    <th class="text-end">অ্যাকশন</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody id="examSetupsTableBody">
                            <tr>
                                <td colspan="{{ auth()->user()->canAny(['exam_setups.edit', 'exam_setups.delete']) ? 8 : 7 }}" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">বিন্যাস তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Create / Edit Form panel -->
        @canany(['exam_setups.create', 'exam_setups.edit'])
            <div class="col-12 col-xl-4 col-lg-5 {{ !auth()->user()->can('exam_setups.create') ? 'd-none' : '' }}" id="formCard">
                <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                    <h5 class="fw-bold text-dark mb-3" id="formTitle">
                        <i class="fa-solid fa-sliders me-2 text-warning"></i>পরীক্ষা বিন্যাস যুক্ত করুন
                    </h5>
                    <p class="text-muted small" id="formDesc">শ্রেণীর জন্য নতুন পরীক্ষার ধরণ নির্ধারণ করুন।</p>
                    
                    <form id="examSetupCreateForm" novalidate>
                        <!-- Hidden input to store Configuration ID when editing -->
                        <input type="hidden" id="editExamSetupId" value="">

                        <!-- Exam Type Dropdown -->
                        <div class="mb-3">
                            <label for="examTypeId" class="form-label fw-semibold small text-dark">পরীক্ষার ধরণ (Exam Type) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6" id="examTypeId" required>
                                <option value="" selected disabled>পরীক্ষার ধরণ নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-exam-type-id"></div>
                        </div>

                        <!-- Class Setup Dropdown -->
                        <div class="mb-3">
                            <label for="classSetupId" class="form-label fw-semibold small text-dark">শ্রেণীর বিন্যাস (Class Setup) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6" id="classSetupId" required>
                                <option value="" selected disabled>শ্রেণীর বিন্যাস নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-class-setup-id"></div>
                        </div>

                        <!-- Is Active Toggle Switch -->
                        <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                            <label class="fw-semibold small text-muted mb-0" for="status">অবস্থা (Active Status)</label>
                            <input class="form-check-input m-0" type="checkbox" role="switch" id="status" checked>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                            পরীক্ষা বিন্যাস তৈরি করুন
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="resetBtn" style="display: none;">
                            <i class="fa-solid fa-rotate-left me-1"></i>বাতিল করুন
                        </button>
                    </form>
                </div>
            </div>
        @endcanany
    </div>
</div>

<!-- ==========================================================
     POPUP MODAL: DETAILED GROUPED VIEW WITH ROWSPAN / COLSPAN
     ========================================================== -->
<div class="modal fade" id="viewExamSetupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header text-white" style="background-color: #004d40;">
                <h5 class="modal-title fw-bold" id="viewModalLabel">
                    <i class="fa-solid fa-circle-info me-2"></i>পরীক্ষা বিন্যাসের বিস্তারিত সাবজেক্ট লিস্ট
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <!-- Meta Info Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="p-3 bg-white rounded-3 shadow-sm border-start border-4 border-success">
                            <span class="text-muted small fw-semibold uppercase d-block">পরীক্ষার ধরণ (Exam Type)</span>
                            <h6 id="viewExamType" class="fw-bold text-dark mt-1 mb-0"></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 bg-white rounded-3 shadow-sm border-start border-4 border-success">
                            <span class="text-muted small fw-semibold uppercase d-block">শ্রেণী (Class Structure)</span>
                            <h6 id="viewClassStructure" class="fw-bold text-dark mt-1 mb-0"></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 bg-white rounded-3 shadow-sm border-start border-4 border-success">
                            <span class="text-muted small fw-semibold uppercase d-block">অবস্থা (Active Status)</span>
                            <h6 id="viewStatus" class="fw-bold text-dark mt-1 mb-0"></h6>
                        </div>
                    </div>
                </div>

                <!-- Structured Dynamic Table -->
                <div class="table-responsive bg-white rounded-3 shadow-sm border p-3">
                    <table class="table table-bordered table-hover align-middle mb-0 text-center" id="modalDetailsTable">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width: 22%;" class="align-middle">বিষয় ধরন</th>
                                <th rowspan="2" style="width: 25%;" class="align-middle">বিষয়</th>
                                <th colspan="2" style="width: 53%;">পত্র</th>
                            </tr>
                            <tr>
                                <th style="width: 26.5%;">১ম পত্র</th>
                                <th style="width: 26.5%;">২য় পত্র</th>
                            </tr>
                        </thead>
                        <tbody id="viewSubjectTableBody">
                            <!-- Dynamic nested rowspan arrays render here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<!-- DataTables Bootstrap 5 CSS & JS Integration Dependencies -->
<link class="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// Isolated Script Scope to prevent variable bleeding & already declared errors 
{
    // Unique naming convention to avoid conflicts with other scripts 
    const canCreateExamSetup = @json(auth()->user()->can('exam_setups.create'));
    const canEditExamSetup = @json(auth()->user()->can('exam_setups.edit'));
    const canDeleteExamSetup = @json(auth()->user()->can('exam_setups.delete'));

    // English to Bangla Digit Converter Utility
    function convertToBanglaNumber(number) {
        const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
        return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
    }

    // Render dynamic Table lists with action buttons
    function renderExamSetups(setups) {
        const rows = setups.map((item, index) => {
            let actionColumnHtml = '';
            if (canEditExamSetup || canDeleteExamSetup) {
                actionColumnHtml = `
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                                অ্যাকশন
                            </button>
                            <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                                <li><a class="dropdown-item setupView py-2 px-3 small" href="#" data-id="${item.id}" data-class-setup-id="${item.class_setup_id}"><i class="fa-solid fa-eye text-primary me-2"></i>বিস্তারিত দেখুন</a></li>
                                ${canEditExamSetup ? `<li><a class="dropdown-item setupEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                                ${canDeleteExamSetup ? `<li><a class="dropdown-item setupDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                            </ul>
                        </div>
                    </td>
                `;
            }

            const banglaSerial = convertToBanglaNumber(index + 1);
            const subjectCountText = convertToBanglaNumber(item.subject_count) + 'টি বিষয়';

            return `
                <tr>
                    <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                    <td class="fw-semibold">${item.exam_type}</td>
                    <td>${item.class_name}</td>
                    <td>${item.section_name}</td>
                    <td>${item.shift_name}</td>
                    <td><span class="badge bg-light text-secondary border fw-bold px-3 py-2">${subjectCountText}</span></td>
                    <td>
                        <span class="badge ${item.status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                            ${item.status ? 'সক্রিয়' : 'নিষ্ক্রিয়'}
                        </span>
                    </td>
                    ${actionColumnHtml}
                </tr>
            `;
        }).join('');

        $('#examSetupsTableBody').html(rows);
    }

    // DataTables Initialization
    function initializeSetupsDataTable() {
        if ($.fn.DataTable.isDataTable('#examSetupsTable')) {
            $('#examSetupsTable').DataTable().destroy();
        }

        $('#examSetupsTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 20, 50],
            responsive: true,
            order: [], // Sort order handled by Controller
            columnDefs: [
                { orderable: false, targets: (canEditExamSetup || canDeleteExamSetup) ? [0, 7] : [0] }
            ],
            language: {
                search: 'সহজ অনুসন্ধান:',
                lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
            }
        });
    }

    // Load configurations dynamically
    async function loadSetupsList() {
        let setups = [];
        if ($.fn.DataTable.isDataTable('#examSetupsTable')) {
            $('#examSetupsTable').DataTable().destroy();
        }

        try {
            const response = await axios.get('/api/exam-setup-lists');
            if (response.data?.status && response.data?.all_data) {
                setups = response.data.all_data;
            }
        } catch (error) {
            console.warn('Failed to load setups list.');
        }

        renderExamSetups(setups);
        initializeSetupsDataTable();
    }

    // Fetch dynamic dropdown datasets from active master tables
    async function loadFormDropdowns() {
        try {
            const response = await axios.get('/api/exam-setup-dependencies');
            if (response.data?.status) {
                // Populate Exam Types
                let typeOptions = '<option value="" selected disabled>পরীক্ষার ধরণ নির্বাচন করুন...</option>';
                response.data.exam_types.forEach(item => {
                    typeOptions += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#examTypeId').html(typeOptions);

                // Populate Class Setups with integrated readable labels
                let setupOptions = '<option value="" selected disabled>শ্রেণীর বিন্যাস নির্বাচন করুন...</option>';
                response.data.class_setups.forEach(item => {
                    setupOptions += `<option value="${item.id}">${item.label}</option>`;
                });
                $('#classSetupId').html(setupOptions);
            }
        } catch (error) {
            console.warn('Failed to load form dependencies.');
        }
    }

    // Reset Form State
    function resetFormState() {
        $('#editExamSetupId').val('');
        $('#examTypeId').val('').removeClass('is-invalid');
        $('#classSetupId').val('').removeClass('is-invalid');
        $('#status').prop('checked', true);

        // Clear Validation Errors
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

        $('#formTitle').html('<i class="fa-solid fa-sliders me-2 text-warning"></i>পরীক্ষা বিন্যাস যুক্ত করুন');
        $('#formDesc').text('শ্রেণীর জন্য নতুন পরীক্ষার ধরণ নির্ধারণ করুন।');
        
        $('#submitBtn').prop('disabled', false).text('পরীক্ষা বিন্যাস তৈরি করুন').css('background-color', '#004d40');
        $('#resetBtn').hide();

        // Collapse form if restricted edit-only permission applies
        if (!canCreateExamSetup && canEditExamSetup) {
            $('#formCard').addClass('d-none');
            $('#tableCard').removeClass('col-xl-8 col-lg-7').addClass('col-xl-12');
        }
    }

    // Reset button click trigger
    $('#resetBtn').on('click', function() {
        resetFormState();
    });

    // Submit Form (Handles Create and Update using AJAX API calls)
    const createFormElement = document.getElementById('examSetupCreateForm');
    if (createFormElement) {
        createFormElement.addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const examTypeIdInput = document.getElementById('examTypeId');
            const classSetupIdInput = document.getElementById('classSetupId');
            const editId = document.getElementById('editExamSetupId').value;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>সংরক্ষণ হচ্ছে...';

            // Clear previous error styles
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

            const payload = {
                exam_type_id: examTypeIdInput.value,
                class_setup_id: classSetupIdInput.value,
                status: document.getElementById('status').checked ? 1 : 0
            };

            try {
                let res;
                if (editId) {
                    res = await axios.post(`/api/exam-setup-update/${editId}`, payload);
                } else {
                    res = await axios.post('/api/exam-setup-store', payload);
                }

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: editId ? 'পরীক্ষা বিন্যাস হালনাগাদ সম্পন্ন!' : 'পরীক্ষা বিন্যাস সফলভাবে তৈরি!',
                        text: res.data.message || 'Stored successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    resetFormState(); 
                    await loadSetupsList(); 
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    const generalMessage = error.response.data.message;

                    if (errors) {
                        if (errors.exam_type_id) {
                            examTypeIdInput.classList.add('is-invalid');
                            document.getElementById('error-exam-type-id').innerHTML = errors.exam_type_id[0];
                        }
                        if (errors.class_setup_id) {
                            classSetupIdInput.classList.add('is-invalid');
                            document.getElementById('error-class-setup-id').innerHTML = errors.class_setup_id[0];
                        }
                    }

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
                submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'পরীক্ষা বিন্যাস তৈরি করুন';
            }
        });
    }

    // Edit Button Click Event Delegation (Without Reload)
    $('#examSetupsTableBody').on('click', '.setupEdit', async function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        try {
            const res = await axios.get(`/api/exam-setup-details/${id}`);

            if (res.data.status === true) {
                const setup = res.data.exam_setup;
                
                // Show Form on restricted permission profile
                if (!canCreateExamSetup && canEditExamSetup) {
                    $('#formCard').removeClass('d-none');
                    $('#tableCard').removeClass('col-xl-12').addClass('col-xl-8 col-lg-7');
                }

                // Switch form to Edit Mode
                $('#formTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>পরীক্ষা বিন্যাস সম্পাদনা');
                $('#formDesc').text(`ইডিটিং রেকর্ড আইডি: #${setup.id}`);
                $('#editExamSetupId').val(setup.id);
                $('#examTypeId').val(setup.exam_type_id);
                $('#classSetupId').val(setup.class_setup_id);
                $('#status').prop('checked', setup.status == 1);

                $('#submitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e'); // Editing emphasis color
                $('#resetBtn').show(); 
                
                // Scroll smoothly to form card
                $('html, body').animate({
                    scrollTop: $("#examSetupCreateForm").offset().top - 100
                }, 300);
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি',
                text: 'পরীক্ষা বিন্যাসের বিবরণ লোড করতে ব্যর্থ হয়েছে।',
                confirmButtonColor: '#004d40'
            });
        }
    });

    // View Details and Render Rowspan Table dynamically inside bootstrap modal
    $('#examSetupsTableBody').on('click', '.setupView', async function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const classSetupId = $(this).data('class-setup-id'); // FIXED: Loaded class_setup_id accurately from DOM 
        console.log("Class Setup ID:", classSetupId); // Console logging the class_setup_id as requested 

        try {
            const res = await axios.get(`/api/subject-assignment-overviews/${classSetupId}`); // FIXED: Query correct Class Setup endpoint 
            console.log("Response:", res);
            if (res.data.status === true) {
                const classSetup = res.data.class_setup;
                const assignments = res.data.all_data;

                // Extract Exam Type name and Status directly from the table row for dynamic rendering
                const currentRow = $(this).closest('tr');
                const examTypeName = currentRow.find('td:nth-child(2)').text(); 
                const statusHtml = currentRow.find('td:nth-child(7)').html(); 

                // Map meta information
                $('#viewExamType').text(examTypeName || '—');
                
                const className = classSetup?.class?.name || '—';
                const sectionName = classSetup?.section?.name || 'N/A';
                const shiftName = classSetup?.shift?.name || 'N/A';
                $('#viewClassStructure').text(`${className} - Section: ${sectionName} (${shiftName})`);
                $('#viewStatus').html(statusHtml);

                // Compile the subject list inside the table body using rowspan logic
                let tableRowsHtml = '';
                let serialNoCounter = 1;

                if (!assignments || assignments.length === 0) {
                    tableRowsHtml = '<tr><td colspan="4" class="text-center text-muted p-4">কোনো বিষয় বিন্যাস করা হয়নি।</td></tr>';
                } else {
                    // Grouping assignments dynamically by Group name (Compulsory, Science, Commerce, etc.) 
                    const grouped = {};
                    assignments.forEach(item => {
                        const groupName = item.group ? item.group.name : 'আবশ্যিক';
                        if (!grouped[groupName]) {
                            grouped[groupName] = {};
                        }

                        const subjectName = item.subject ? item.subject.name : '—';
                        if (!grouped[groupName][subjectName]) {
                            grouped[groupName][subjectName] = {
                                subject_name: subjectName, // FIXED: Pre-assigned correct subject name dynamically 
                                is_fourth_subject: false,
                                has_papers: false,
                                papers_array: [null, null],
                                general_assignment: null
                            };
                        }

                        if (item.paper) {
                            grouped[groupName][subjectName].has_papers = true;
                            const pName = item.paper.name;
                            
                            // Dynamically resolve slot index (0 for 1st Paper, 1 for 2nd Paper)
                            const slotIndex = (pName.includes('2') || pName.includes('২') || pName.includes('Second') || pName.toLowerCase().includes('2nd')) ? 1 : 0;
                            grouped[groupName][subjectName].papers_array[slotIndex] = item;
                        } else {
                            grouped[groupName][subjectName].general_assignment = item;
                        }

                        if (item.is_fourth_subject) {
                            grouped[groupName][subjectName].is_fourth_subject = true;
                        }
                    });

                    // Build the dynamic rowspan table rows
                    Object.keys(grouped).forEach(groupName => {
                        const subjects = grouped[groupName];
                        const subjectKeys = Object.keys(subjects);
                        const groupRowspan = subjectKeys.length;

                        subjectKeys.forEach((subjectName, sIdx) => {
                            const isFirstSubject = (sIdx === 0);
                            
                            // Build first column with rowspan grouping
                            const groupTd = isFirstSubject ? `<td rowspan="${groupRowspan}" class="fw-bold align-middle bg-light text-center" style="border-right: 1px solid #dee2e6; color: #004d40;">${groupName}</td>` : '';
                            
                            const subjectObj = subjects[subjectName];
                            const optionalBadge = subjectObj.is_fourth_subject ? ' <span class="badge bg-light text-dark border ms-1" style="font-size: 10px; vertical-align: middle;">ঐচ্ছিক</span>' : '';
                            
                            // Map papers columns
                            let papersTdHtml = '';
                            const p1 = subjectObj.papers_array[0]; 
                            const p2 = subjectObj.papers_array[1]; 
                            const general = subjectObj.general_assignment;

                            if (!subjectObj.has_papers) {
                                // If subject has no papers, span 2 columns with colspan
                                const codeText = general && general.code ? ` (কোড: ${general.code})` : '';
                                papersTdHtml = `<td colspan="2" class="text-center text-secondary align-middle fw-semibold">${subjectName}${codeText}</td>`;
                            } else {
                                // Render exact paper name dynamically
                                let p1Html = '—';
                                if (p1) {
                                    const codeText = p1.code ? ` (কোড: ${p1.code})` : '';
                                    p1Html = `${p1.subject?.name || '—'} ${p1.paper?.name || '—'}${codeText}`;
                                }

                                let p2Html = '—';
                                if (p2) {
                                    const codeText = p2.code ? ` (কোড: ${p2.code})` : '';
                                    p2Html = `${p2.subject?.name || '—'} ${p2.paper?.name || '—'}${codeText}`;
                                }

                                papersTdHtml = `
                                    <td class="text-center text-secondary align-middle fw-semibold">${p1Html}</td>
                                    <td class="text-center text-secondary align-middle fw-semibold">${p2Html}</td>
                                `;
                            }

                            tableRowsHtml += `
                                <tr>
                                    ${groupTd}
                                    <td class="fw-bold text-dark text-start ps-3 align-middle" style="border-right: 1px solid #dee2e6;">${subjectName}${optionalBadge}</td>
                                    ${papersTdHtml}
                                </tr>
                            `;
                        });
                    });
                }

                $('#viewSubjectTableBody').html(tableRowsHtml); // FIXED: Populating compiled HTML cleanly 
                $('#viewExamSetupModal').modal('show');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি',
                text: 'বিস্তারিত সাবজেক্ট বিন্যাস লোড করতে ব্যর্থ হয়েছে।',
                confirmButtonColor: '#004d40'
            });
        }
    });

    // Delete Button Click Event Delegation (SweetAlert2 + Without Reload)
    $('#examSetupsTableBody').on('click', '.setupDelete', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: 'মুছে ফেলতে চান?',
            text: 'এই পরীক্ষা বিন্যাসটি ডিলিট করলে এর ডাটা আর পুনরুদ্ধার করা যাবে না!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
            cancelButtonText: 'বাতিল'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const res = await axios.delete(`/api/exam-setup-delete/${id}`);
                    if (res.data.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'মুছে ফেলা হয়েছে!',
                            text: res.data.message || 'The configuration has been deleted successfully.',
                            confirmButtonColor: '#004d40'
                        });

                        if ($('#editExamSetupId').val() == id) {
                            resetFormState();
                        }

                        await loadSetupsList(); 
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ত্রুটি',
                        text: error.response?.data?.message || 'রেকর্ডটি ডিলিট করতে ব্যর্থ হয়েছে।',
                        confirmButtonColor: '#004d40'
                    });
                }
            }
        });
    });

    // Load details on document ready
    $(document).ready(function () {
        loadFormDropdowns();
        loadSetupsList();
    });
}
</script>
@endpush