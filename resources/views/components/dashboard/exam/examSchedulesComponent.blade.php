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

    /* Custom DataTables CSS */
    #examSchedulesTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #examSchedulesTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
    
    .view-card-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.8rem;
    }
    .view-card-value {
        font-weight: 700;
        color: #2b3674;
        font-size: 0.95rem;
    }
</style>
@endpush


<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">পরীক্ষার সময়সূচী (Exam Schedule)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের বিভিন্ন পরীক্ষা ও বিষয়ের তারিখ, হল এবং ডিউটি বণ্টন সাজান।</p>
        </div>
    </div>

    <div class="row g-4 flex-column-reverse flex-lg-row">
        <!-- Left Column: Master Table List Card -->
        <div class="col-12 {{ auth()->user()->can('exam_schedules.create') ? 'col-xl-8 col-lg-7' : 'col-xl-12' }}" id="tableCard">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-calendar-days text-success me-2"></i>সংরক্ষিত পরীক্ষার সময়সূচী তালিকা
                </h5>
                
                <div class="table-responsive">
                    <table id="examSchedulesTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>সিরিয়াল নং</th>
                                <th>পরীক্ষা</th>
                                <th>শ্রেণী</th>
                                <th>শাখা</th>
                                <th>শিফট</th>
                                <th>বিষয় (পত্র)</th>
                                <th>তারিখ ও সময়</th>
                                <th>রুম/হল</th>
                                <th>অবস্থা</th>
                                @canany(['exam_schedules.edit', 'exam_schedules.delete'])
                                    <th class="text-end">অ্যাকশন</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody id="examSchedulesTableBody">
                            <tr>
                                <td colspan="{{ auth()->user()->canAny(['exam_schedules.edit', 'exam_schedules.delete']) ? 10 : 9 }}" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">সময়সূচী তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Create / Edit Form panel -->
        @canany(['exam_schedules.create', 'exam_schedules.edit'])
            <div class="col-12 col-xl-4 col-lg-5 {{ !auth()->user()->can('exam_schedules.create') ? 'd-none' : '' }}" id="formCard">
                <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                    <h5 class="fw-bold text-dark mb-3" id="formTitle">
                        <i class="fa-solid fa-sliders me-2 text-warning"></i>সময়সূচী যুক্ত করুন
                    </h5>
                    <p class="text-muted small" id="formDesc">পরীক্ষার জন্য নতুন একটি সময়সূচী নির্ধারণ করুন।</p>
                    
                    <form id="examScheduleCreateForm" novalidate>
                        <!-- Hidden input to store Configuration ID when editing -->
                        <input type="hidden" id="editExamScheduleId" value="">

                        <!-- Exam Type Dropdown -->
                        <div class="mb-3">
                            <label for="examTypeId" class="form-label fw-semibold small text-dark">পরীক্ষার ধরণ (Exam Type) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6" id="examTypeId" required>
                                <option value="" selected disabled>পরীক্ষার ধরণ নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-exam-type-id"></div>
                        </div>

                        <!-- Class Dropdown (Starts Cascade) -->
                        <div class="mb-3">
                            <label for="classId" class="form-label fw-semibold small text-dark">শ্রেণী (Class) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6" id="classId" required>
                                <option value="" selected disabled>শ্রেণী নির্বাচন করুন...</option>
                            </select>
                        </div>

                        <!-- Class Setup Dropdown -->
                        <div class="mb-3">
                            <label for="classSetupId" class="form-label fw-semibold small text-dark">শ্রেণীর বিন্যাস (Class Setup) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6" id="classSetupId" required disabled>
                                <option value="" selected disabled>প্রথমে শ্রেণী নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-class-setup-id"></div>
                        </div>

                        <!-- Subject Assignment Dropdown -->
                        <div class="mb-3">
                            <label for="subjectAssignmentId" class="form-label fw-semibold small text-dark">বিষয় ও পত্র (Subject & Paper) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6" id="subjectAssignmentId" required disabled>
                                <option value="" selected disabled>প্রথমে শ্রেণীর বিন্যাস নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-subject-assignment-id"></div>
                        </div>

                        <!-- Exam Date -->
                        <div class="mb-3">
                            <label for="examDate" class="form-label fw-semibold small text-dark">পরীক্ষার তারিখ (Exam Date) <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-lg rounded-3 fs-6" id="examDate" required>
                            <div class="invalid-feedback" id="error-exam-date"></div>
                        </div>

                        <!-- Start Time & End Time Grid -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="startTime" class="form-label fw-semibold small text-dark">শুরুর সময় <span class="text-danger">*</span></label>
                                <input type="time" class="form-control form-control-lg rounded-3 fs-6" id="startTime" required>
                                <div class="invalid-feedback" id="error-start-time"></div>
                            </div>
                            <div class="col-6">
                                <label for="endTime" class="form-label fw-semibold small text-dark">শেষের সময় <span class="text-danger">*</span></label>
                                <input type="time" class="form-control form-control-lg rounded-3 fs-6" id="endTime" required>
                                <div class="invalid-feedback" id="error-end-time"></div>
                            </div>
                        </div>

                        <!-- Room Name -->
                        <div class="mb-3">
                            <label for="roomName" class="form-label fw-semibold small text-secondary">রুম / হল নাম</label>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="roomName" placeholder="উদাঃ Room 101, Hall-1">
                        </div>

                        <!-- Examiner Name -->
                        <div class="mb-3">
                            <label for="examinerName" class="form-label fw-semibold small text-secondary">পরিদর্শক (Examiner)</label>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="examinerName" placeholder="উদাঃ শিক্ষকের নাম">
                        </div>

                        <!-- Seat Capacity -->
                        <div class="mb-3">
                            <label for="seatCapacity" class="form-label fw-semibold small text-secondary">আসন সংখ্যা</label>
                            <input type="number" class="form-control form-control-lg rounded-3 fs-6" id="seatCapacity" min="1" placeholder="উদাঃ ৪০">
                        </div>

                        <!-- Instructions -->
                        <div class="mb-3">
                            <label for="instructions" class="form-label fw-semibold small text-secondary">বিশেষ নির্দেশনাবলী</label>
                            <textarea class="form-control form-control-lg rounded-3 fs-6" id="instructions" rows="2" placeholder="পরীক্ষার্থীদের নির্দেশনা..."></textarea>
                        </div>

                        <!-- Is Active Toggle Switch -->
                        <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                            <label class="fw-semibold small text-muted mb-0" for="status">অবস্থা (Active Status)</label>
                            <input class="form-check-input m-0" type="checkbox" role="switch" id="status" checked>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                            সময়সূচী তৈরি করুন
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
     POPUP MODAL: DETAILED WORKSPACE VIEW (Beautiful Info Cards Grid)
     ========================================================== -->
<div class="modal fade" id="viewExamScheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header text-white" style="background-color: #004d40;">
                <h5 class="modal-title fw-bold" id="viewModalLabel">
                    <i class="fa-solid fa-circle-info me-2"></i>পরীক্ষার সময়সূচীর বিস্তারিত বিবরণী
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-4">
                    <!-- Column 1: Exam Metadata -->
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3 bg-white h-100">
                            <h6 class="fw-bold text-success border-bottom pb-2 mb-3"><i class="fa-solid fa-graduation-cap me-1"></i> পরীক্ষার মৌলিক তথ্য</h6>
                            <div class="row g-2 small">
                                <div class="col-6 view-card-label">পরীক্ষার ধরণ:</div>
                                <div class="col-6 view-card-value" id="viewExamType"></div>

                                <div class="col-6 view-card-label">শ্রেণী (Class):</div>
                                <div class="col-6 view-card-value" id="viewClassName"></div>

                                <div class="col-6 view-card-label">শাখা (Section):</div>
                                <div class="col-6 view-card-value" id="viewSectionName"></div>

                                <div class="col-6 view-card-label">শিফট (Shift):</div>
                                <div class="col-6 view-card-value" id="viewShiftName"></div>

                                <div class="col-6 view-card-label">বিভাগ (Group):</div>
                                <div class="col-6 view-card-value" id="viewGroupName"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Subject Details -->
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3 bg-white h-100">
                            <h6 class="fw-bold text-success border-bottom pb-2 mb-3"><i class="fa-solid fa-book-open me-1"></i> বিষয়ের বিবরণী</h6>
                            <div class="row g-2 small">
                                <div class="col-6 view-card-label">বিষয় (Subject):</div>
                                <div class="col-6 view-card-value" id="viewSubjectName"></div>

                                <div class="col-6 view-card-label">পত্র (Paper):</div>
                                <div class="col-6 view-card-value" id="viewPaperName"></div>

                                <div class="col-6 view-card-label">বিষয় কোড (Subject Code):</div>
                                <div class="col-6 view-card-value" id="viewSubjectCode"></div>

                                <div class="col-6 view-card-label">ঐচ্ছিক বিষয় (4th Subject):</div>
                                <div class="col-6 view-card-value" id="viewIsFourth"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Timing Details -->
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3 bg-white h-100">
                            <h6 class="fw-bold text-success border-bottom pb-2 mb-3"><i class="fa-solid fa-clock me-1"></i> পরীক্ষার সময় ও তারিখ</h6>
                            <div class="row g-2 small">
                                <div class="col-6 view-card-label">পরীক্ষার তারিখ:</div>
                                <div class="col-6 view-card-value" id="viewExamDate"></div>

                                <div class="col-6 view-card-label">শুরুর সময়:</div>
                                <div class="col-6 view-card-value" id="viewStartTime"></div>

                                <div class="col-6 view-card-label">শেষের সময়:</div>
                                <div class="col-6 view-card-value" id="viewEndTime"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 4: Seating Arrangement -->
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3 bg-white h-100">
                            <h6 class="fw-bold text-success border-bottom pb-2 mb-3"><i class="fa-solid fa-location-dot me-1"></i> রুম ও পরিদর্শক তথ্য</h6>
                            <div class="row g-2 small">
                                <div class="col-6 view-card-label">রুম / হল নাম:</div>
                                <div class="col-6 view-card-value text-success" id="viewRoomName"></div>

                                <div class="col-6 view-card-label">পরিদর্শক (Examiner):</div>
                                <div class="col-6 view-card-value" id="viewExaminerName"></div>

                                <div class="col-6 view-card-label">আসন সংখ্যা:</div>
                                <div class="col-6 view-card-value" id="viewSeatCapacity"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Full Width Card: Instructions -->
                    <div class="col-12" id="viewInstructionsWrapper">
                        <div class="card border-0 shadow-sm p-3 bg-white">
                            <h6 class="fw-bold text-success border-bottom pb-2 mb-3"><i class="fa-solid fa-file-invoice me-1"></i> বিশেষ নির্দেশনাবলী</h6>
                            <p class="mb-0 small text-muted" id="viewInstructions"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
// Scoped JavaScript execution to prevent global variable bleeding
{
    const canCreateSchedule = @json(auth()->user()->can('exam_schedules.create'));
    const canEditSchedule = @json(auth()->user()->can('exam_schedules.edit'));
    const canDeleteSchedule = @json(auth()->user()->can('exam_schedules.delete'));

    // English to Bangla Digit Converter Utility
    function convertToBanglaNumber(number) {
        if (!number) return '—';
        const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
        return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
    }

    // Render Table list securely
    function renderExamSchedules(schedules) {
        const rows = schedules.map((item, index) => {
            let actionColumnHtml = '';
            if (canEditSchedule || canDeleteSchedule) {
                actionColumnHtml = `
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                                অ্যাকশন
                            </button>
                            <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                                <li><a class="dropdown-item scheduleView py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-eye text-primary me-2"></i>বিস্তারিত দেখুন</a></li>
                                ${canEditSchedule ? `<li><a class="dropdown-item scheduleEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                                ${canDeleteSchedule ? `<li><a class="dropdown-item scheduleDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                            </ul>
                        </div>
                    </td>
                `;
            }

            const banglaSerial = convertToBanglaNumber(index + 1);
            const paperText = item.paper_name !== '—' ? `<span class="text-muted d-block small">(${item.paper_name})</span>` : '';

            // Format date nicely to Bangla
            const dateObj = new Date(item.exam_date);
            const banglaDate = dateObj.toLocaleDateString('bn-BD', { day: 'numeric', month: 'long', year: 'numeric' });

            return `
                <tr>
                    <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                    <td class="fw-semibold">${item.exam_type}</td>
                    <td>${item.class_name}</td>
                    <td>${item.section_name}</td>
                    <td>${item.shift_name}</td>
                    <td>
                        <strong>${item.subject_name}</strong>
                        ${paperText}
                    </td>
                    <td><span class="badge bg-light text-dark border px-3 py-2 fw-semibold">${banglaDate}</span></td>
                    <td class="small text-secondary">${item.start_time} - ${item.end_time}</td>
                    <td><strong class="text-success">${item.room_name}</strong></td>
                    <td>
                        <span class="badge ${item.status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                            ${item.status ? 'সক্রিয়' : 'নিষ্ক্রিয়'}
                        </span>
                    </td>
                    ${actionColumnHtml}
                </tr>
            `;
        }).join('');

        $('#examSchedulesTableBody').html(rows);
    }

    // DataTables Initialization
    function initializeDataTable() {
        if ($.fn.DataTable.isDataTable('#examSchedulesTable')) {
            $('#examSchedulesTable').DataTable().destroy();
        }

        $('#examSchedulesTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 20, 50],
            responsive: true,
            order: [], 
            columnDefs: [
                { orderable: false, targets: (canEditSchedule || canDeleteSchedule) ? [0, 9] : [0] }
            ],
            language: {
                search: 'সহজ অনুসন্ধান:',
                lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
            }
        });
    }

    // Load active setups configuration list
    async function loadSchedulesList() {
        let schedules = [];
        if ($.fn.DataTable.isDataTable('#examSchedulesTable')) {
            $('#examSchedulesTable').DataTable().destroy();
        }

        try {
            const response = await axios.get('/api/exam-schedule-lists');
            if (response.data?.status && response.data?.all_data) {
                schedules = response.data.all_data;
            }
        } catch (error) {
            console.warn('Failed to load exam schedules.');
        }

        renderExamSchedules(schedules);
        initializeDataTable();
    }

    // Fetch master dropdown dynamic structures
    async function loadFormDropdowns() {
        try {
            // Hit the newly mapped dedicated schedules endpoint to avoid conflicts [cite: 1.1.2]
            const response = await axios.get('/api/exam-schedule-dependencies');
            if (response.data?.status) {
                // Populate Exam Types
                let typeOptions = '<option value="" selected disabled>পরীক্ষার ধরণ নির্বাচন করুন...</option>';
                response.data.exam_types.forEach(item => {
                    typeOptions += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#examTypeId').html(typeOptions);

                // Populate School Classes
                let classOptions = '<option value="" selected disabled>শ্রেণী নির্বাচন করুন...</option>';
                response.data.classes.forEach(item => {
                    classOptions += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#classId').html(classOptions);
            }
        } catch (error) {
            console.warn('Failed to load dropdown dependencies.');
        }
    }

    // Dynamic Cascading Dropdown: Class -> Class Setup
    $('#classId').on('change', async function() {
        const classId = $(this).val();
        const classSetupSelect = $('#classSetupId');
        const subjectAssignSelect = $('#subjectAssignmentId');

        classSetupSelect.prop('disabled', true).html('<option value="">লোড হচ্ছে...</option>');
        subjectAssignSelect.prop('disabled', true).html('<option value="" selected disabled>প্রথমে শ্রেণীর বিন্যাস নির্বাচন করুন...</option>');

        try {
            const res = await axios.get(`/api/academic/exam-schedules/class-setups/${classId}`);
            if (res.data?.status) {
                let options = '<option value="" selected disabled>শ্রেণীর বিন্যাস নির্বাচন করুন...</option>';
                res.data.class_setups.forEach(item => {
                    options += `<option value="${item.id}">${item.label}</option>`;
                });
                classSetupSelect.html(options).prop('disabled', false);
            }
        } catch (error) {
            classSetupSelect.html('<option value="">লোড ব্যর্থ হয়েছে!</option>');
        }
    });

    // Dynamic Cascading Dropdown: Class Setup -> Subject Assignment
    $('#classSetupId').on('change', async function() {
        const setupId = $(this).val();
        const subjectAssignSelect = $('#subjectAssignmentId');

        subjectAssignSelect.prop('disabled', true).html('<option value="">লোড হচ্ছে...</option>');

        try {
            const res = await axios.get(`/api/academic/exam-schedules/subject-assignments/${setupId}`);
            if (res.data?.status) {
                let options = '<option value="" selected disabled>বিষয় ও পত্র নির্বাচন করুন...</option>';
                if (res.data.subject_assignments.length === 0) {
                    options = '<option value="">No subject assigned for this class setup.</option>';
                    subjectAssignSelect.html(options);
                    return;
                }
                res.data.subject_assignments.forEach(item => {
                    options += `<option value="${item.id}">${item.label}</option>`;
                });
                subjectAssignSelect.html(options).prop('disabled', false);
            }
        } catch (error) {
            subjectAssignSelect.html('<option value="">লোড ব্যর্থ হয়েছে!</option>');
        }
    });

    // Reset Form State
    function resetFormState() {
        $('#editExamScheduleId').val('');
        $('#examTypeId').val('').removeClass('is-invalid');
        $('#classId').val('').removeClass('is-invalid');
        $('#classSetupId').prop('disabled', true).html('<option value="" selected disabled>প্রথমে শ্রেণী নির্বাচন করুন...</option>').removeClass('is-invalid');
        $('#subjectAssignmentId').prop('disabled', true).html('<option value="" selected disabled>প্রথমে শ্রেণীর বিন্যাস নির্বাচন করুন...</option>').removeClass('is-invalid');
        
        $('#examDate').val('').removeClass('is-invalid');
        $('#startTime').val('').removeClass('is-invalid');
        $('#endTime').val('').removeClass('is-invalid');
        $('#roomName').val('');
        $('#examinerName').val('');
        $('#seatCapacity').val('');
        $('#instructions').val('');
        $('#status').prop('checked', true);

        // Clear Validation Errors
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

        $('#formTitle').html('<i class="fa-solid fa-sliders me-2 text-warning"></i>সময়সূচী যুক্ত করুন');
        $('#formDesc').text('পরীক্ষার জন্য নতুন একটি সময়সূচী নির্ধারণ করুন।');
        
        $('#submitBtn').prop('disabled', false).text('সময়সূচী তৈরি করুন').css('background-color', '#004d40');
        $('#resetBtn').hide();

        // Collapse form if restricted edit-only permission applies
        if (!canCreateSchedule && canEditSchedule) {
            $('#formCard').addClass('d-none');
            $('#tableCard').removeClass('col-xl-8 col-lg-7').addClass('col-xl-12');
        }
    }

    // Reset button click trigger
    $('#resetBtn').on('click', function() {
        resetFormState();
    });

    // Submit Form (Handles Create and Update using AJAX API calls)
    const createFormElement = document.getElementById('examScheduleCreateForm');
    if (createFormElement) {
        createFormElement.addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const editId = document.getElementById('editExamScheduleId').value;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>সংরক্ষণ হচ্ছে...';

            // Clear previous error styles
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

            const payload = {
                exam_type_id: $('#examTypeId').val(),
                class_setup_id: $('#classSetupId').val(),
                subject_assignment_id: $('#subjectAssignmentId').val(),
                exam_date: $('#examDate').val(),
                start_time: $('#startTime').val(),
                end_time: $('#endTime').val(),
                room_name: $('#roomName').val() || null,
                examiner_name: $('#examinerName').val() || null,
                seat_capacity: $('#seatCapacity').val() || null,
                instructions: $('#instructions').val() || null,
                status: document.getElementById('status').checked ? 1 : 0
            };

            try {
                let res;
                if (editId) {
                    res = await axios.post(`/api/exam-schedule-update/${editId}`, payload);
                } else {
                    res = await axios.post('/api/exam-schedule-store', payload);
                }

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: editId ? 'সময়সূচী হালনাগাদ সম্পন্ন!' : 'সময়সূচী সফলভাবে তৈরি!',
                        text: res.data.message || 'Stored successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    resetFormState(); 
                    await loadSchedulesList(); 
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    const generalMessage = error.response.data.message;

                    if (errors) {
                        Object.keys(errors).forEach(key => {
                            // Translate keys to match input element IDs
                            let camelKey = key.replace(/_([a-z])/g, function (g) { return g[1].toUpperCase(); });
                            const inputElement = document.getElementById(camelKey);
                            if (inputElement) {
                                inputElement.classList.add('is-invalid');
                                const errDiv = document.getElementById(`error-${key.replace(/_/g, '-')}`);
                                if (errDiv) errDiv.innerHTML = errors[key][0];
                            }
                        });
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
                submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'সময়সূচী তৈরি করুন';
            }
        });
    }

    // Edit Button Click Event Delegation (Without Reload)
    $('#examSchedulesTableBody').on('click', '.scheduleEdit', async function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        try {
            const res = await axios.get(`/api/exam-schedule-details/${id}`);

            if (res.data.status === true) {
                const schedule = res.data.data;
                
                // Show Form on restricted permission profile
                if (!canCreateSchedule && canEditSchedule) {
                    $('#formCard').removeClass('d-none');
                    $('#tableCard').removeClass('col-xl-12').addClass('col-xl-8 col-lg-7');
                }

                // Switch form to Edit Mode
                $('#formTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>সময়সূচী সম্পাদনা');
                $('#formDesc').text(`ইডিটিং রেকর্ড আইডি: #${schedule.id}`);
                $('#editExamScheduleId').val(schedule.id);
                
                $('#examTypeId').val(schedule.exam_type_id);
                $('#classId').val(schedule.class_setup?.class_id);

                // Dynamically trigger cascading class setup populate
                const classSetupSelect = $('#classSetupId');
                const subjectAssignSelect = $('#subjectAssignmentId');

                classSetupSelect.prop('disabled', true).html('<option value="">লোড হচ্ছে...</option>');
                subjectAssignSelect.prop('disabled', true).html('<option value="" selected disabled>প্রথমে শ্রেণীর বিন্যাস নির্বাচন করুন...</option>');

                // Mapped Promise sequences to ensure dropdown cascading selections match database values perfectly
                axios.get(`/api/academic/exam-schedules/class-setups/${schedule.class_setup?.class_id}`)
                    .then(response => {
                        let options = '<option value="" selected disabled>শ্রেণীর বিন্যাস নির্বাচন করুন...</option>';
                        response.data.class_setups.forEach(item => {
                            options += `<option value="${item.id}">${item.label}</option>`;
                        });
                        classSetupSelect.html(options).prop('disabled', false).val(schedule.class_setup_id);

                        return axios.get(`/api/academic/exam-schedules/subject-assignments/${schedule.class_setup_id}`);
                    })
                    .then(response => {
                        let options = '<option value="" selected disabled>বিষয় ও পত্র নির্বাচন করুন...</option>';
                        response.data.subject_assignments.forEach(item => {
                            options += `<option value="${item.id}">${item.label}</option>`;
                        });
                        subjectAssignSelect.html(options).prop('disabled', false).val(schedule.subject_assignment_id);
                    })
                    .catch(() => {
                        classSetupSelect.html('<option value="">লোড ব্যর্থ!</option>');
                        subjectAssignSelect.html('<option value="">লোড ব্যর্থ!</option>');
                    });

                $('#examDate').val(schedule.exam_date);
                $('#startTime').val(schedule.formatted_start);
                $('#endTime').val(schedule.formatted_end);
                $('#roomName').val(schedule.room_name);
                $('#examinerName').val(schedule.examiner_name);
                $('#seatCapacity').val(schedule.seat_capacity);
                $('#instructions').val(schedule.instructions);
                $('#status').prop('checked', schedule.status == 1);

                // Replaced edit background emphasis color with standard brand color to maintain visual consistency
                $('#submitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#004d40');
                $('#resetBtn').show(); 
                
                // Scroll smoothly to form card
                $('html, body').animate({
                    scrollTop: $("#examScheduleCreateForm").offset().top - 100
                }, 300);
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি',
                text: 'সময়সূচীর বিবরণ লোড করতে ব্যর্থ হয়েছে।',
                confirmButtonColor: '#004d40'
            });
        }
    });

    // View Details on Modal
    $('#examSchedulesTableBody').on('click', '.scheduleView', async function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        try {
            const res = await axios.get(`/api/exam-schedule-details/${id}`);
            if (res.data.status === true) {
                const s = res.data.data;

                // Bind Master Meta labels
                $('#viewExamType').text(s.exam_type?.name || '—');
                $('#viewClassName').text(s.class_setup?.class?.name || '—'); // Fixed: Resolved relationship path safely
                $('#viewSectionName').text(s.class_setup?.section?.name || 'N/A');
                $('#viewShiftName').text(s.class_setup?.shift?.name || 'N/A');
                $('#viewGroupName').text(s.subject_assignment?.group?.name || 'Compulsory');

                // Bind Subject metadata
                $('#viewSubjectName').text(s.subject_assignment?.subject?.name || '—');
                $('#viewPaperName').text(s.subject_assignment?.paper?.name || '—');
                
                // Fixed: Stripped out convertToBanglaNumber helper on string type code representation
                $('#viewSubjectCode').text(s.subject_assignment?.code || '—');

                const isFourth = s.subject_assignment?.is_fourth_subject ? '<span class="badge bg-warning text-dark">হ্যাঁ</span>' : '<span class="badge bg-light text-dark border">না</span>';
                $('#viewIsFourth').html(isFourth);

                // Bind Timing meta properties
                const dateObj = new Date(s.exam_date);
                const banglaDateStr = dateObj.toLocaleDateString('bn-BD', { day: 'numeric', month: 'long', year: 'numeric' });
                $('#viewExamDate').text(`${banglaDateStr} (${dateObj.toLocaleDateString('bn-BD', { weekday: 'long' })})`);
                
                $('#viewStartTime').text(convertToBanglaNumber(s.start_time));
                $('#viewEndTime').text(convertToBanglaNumber(s.end_time));

                // Bind seating resources details
                $('#viewRoomName').text(s.room_name || '—');
                $('#viewExaminerName').text(s.examiner_name || '—');
                
                // Fixed: Handled integer seat capacity conversion safely
                $('#viewSeatCapacity').text(convertToBanglaNumber(s.seat_capacity) || '—');

                // Render instructions gracefully
                if (s.instructions) {
                    $('#viewInstructions').text(s.instructions);
                    $('#viewInstructionsWrapper').show();
                } else {
                    $('#viewInstructionsWrapper').hide();
                }

                $('#viewExamScheduleModal').modal('show');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি',
                text: 'সময়সূচীর বিস্তারিত বিবরণ লোড করতে ব্যর্থ হয়েছে।',
                confirmButtonColor: '#004d40'
            });
        }
    });

    // Delete Button Click Event Delegation (SweetAlert2 + Without Reload)
    $('#examSchedulesTableBody').on('click', '.scheduleDelete', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: 'মুছে ফেলতে চান?',
            text: 'এই পরীক্ষার সময়সূচীটি ডিলিট করলে এর ডাটা আর পুনরুদ্ধার করা যাবে না!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
            cancelButtonText: 'বাতিল'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const res = await axios.delete(`/api/exam-schedule-delete/${id}`);

                    if (res.data.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'মুছে ফেলা হয়েছে!',
                            text: res.data.message || 'Deleted successfully.',
                            confirmButtonColor: '#004d40'
                        });

                        if ($('#editExamScheduleId').val() == id) {
                            resetFormState();
                        }

                        await loadSchedulesList(); 
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
        loadSchedulesList();
    });
}
</script>
@endpush
