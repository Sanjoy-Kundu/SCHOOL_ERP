@push('styles')
<!-- Select2 CSS Integration Dependencies -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

<style>
    /* Dynamic responsive design CSS for Workspace Panels */
    @media (max-width: 575.98px) {
        .card-responsive { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important; padding: 1.25rem !important; }
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

    /* Traditional Bangladeshi High School Academic Table Style */
    .custom-academic-table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #b2bec3 !important;
    }
    .custom-academic-table thead th {
        font-size: 0.85rem !important;
        font-weight: 700 !important;
        color: #2d3436 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #b2bec3 !important;
        padding: 0.75rem !important;
        text-align: center;
    }
    .custom-academic-table tbody td {
        font-size: 0.9rem !important;
        color: #2d3436 !important;
        border: 1px solid #b2bec3 !important;
        padding: 0.75rem !important;
        vertical-align: middle !important;
    }
    
    /* Elegant styling for Group Rowspans */
    .custom-academic-table td[rowspan] {
        background-color: white !important;
        text-align: center !important;
        font-weight: bold !important;
        border-right: 2px solid #b2bec3 !important;
    }

    .meta-label {
        font-weight: 500;
        color: #636e72;
        font-size: 0.85rem;
    }
    .meta-value {
        font-weight: 700;
        color: #2d3436;
        font-size: 1.1rem;
    }

    /* Print Optimization CSS Stylesheet to exactly match the target layout */
    @media print {
        body {
            background-color: #fff !important;
            color: #000 !important;
        }
        .container-responsive {
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        .card-responsive {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }
        .d-print-none {
            display: none !important;
        }
        .custom-academic-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        .custom-academic-table th, 
        .custom-academic-table td {
            border: 1px solid #000 !important;
            padding: 8px !important;
            font-size: 0.85rem !important;
            color: #000 !important;
        }
        .signature-section hr {
            border-top: 1px solid #000 !important;
            opacity: 1 !important;
        }
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2 d-print-none">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">পরীক্ষার সময়সূচী</h1>
            <p class="text-muted small mb-0">পরীক্ষার রুটিন দেখুন, ডাউনলোড করুন এবং প্রিন্ট করুন।</p>
        </div>
        <div>
            <button type="button" onclick="window.print();" class="btn btn-primary fw-bold px-3 py-2 rounded-3 shadow-sm">
                <i class="fa-solid fa-print me-2"></i> প্রিন্ট / PDF ডাউনলোড
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Panel Column -->
        <div class="col-12" id="tableCard">
            <!-- Filter Panel -->
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm mb-4 d-print-none">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-sliders text-success me-2"></i>রুটিন দেখার ফিল্টারসমূহ
                </h5>
                <div class="row g-2">
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary mb-1">পরীক্ষার ধরণ ফিল্টার</label>
                        <select id="filterExamTypeId" class="form-select form-select-sm rounded-3">
                            <option value="">সকল পরীক্ষার ধরণ</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary mb-1">শ্রেণী ফিল্টার (Class)</label>
                        <select id="filterClassId" class="form-select form-select-sm rounded-3">
                            <option value="">সকল শ্রেণী</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary mb-1">শ্রেণীর বিন্যাস ফিল্টার (Class Setup)</label>
                        <select id="filterClassSetupId" class="form-select form-select-sm rounded-3" disabled>
                            <option value="">প্রথমে শ্রেণী নির্বাচন করুন...</option>
                        </select>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="button" id="resetFiltersBtn" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-bold rounded-3">
                        <i class="fa-solid fa-rotate-left me-1"></i>ফিল্টার রিসেট
                    </button>
                </div>
            </div>

            <!-- Empty / Default State Message (Shown before filtering) -->
            <div id="emptyStateMessage" class="text-center py-5 bg-white rounded-3 shadow-sm card-responsive border">
                <i class="fa-solid fa-folder-open text-warning fs-1 mb-3 d-block"></i>
                <h5 class="fw-bold text-black">পরীক্ষার সময়সূচী লোড করুন</h5>
                <p class="text-black small mb-0 px-3">পরীক্ষার রুটিন জেনারেট করতে এবং দেখতে অনুগ্রহ করে উপরের ফিল্টার প্যানেল থেকে প্রয়োজনীয় তথ্য সিলেক্ট করুন।</p>
            </div>

            <!-- Printable Academic Routine Report Sheet -->
            <div id="routineReportWrapper" class="card border-0 card-responsive p-3 p-sm-5 bg-white shadow-sm d-none">
                
                <!-- School Pad Header -->
                <div class="text-center mb-4 pb-3 border-bottom">
                    <div class="d-flex justify-content-center align-items-center mb-2">
                        <span class="text-success fs-1 me-2 d-inline-block" style="line-height: 1;"><i class="fa-solid fa-graduation-cap"></i></span>
                        <h2 class="fw-bold text-dark mb-0" id="reportSchoolName" style="font-family: 'Kalpurush', 'SolaimanLipi', sans-serif;"></h2>
                    </div>
                    <p class="text-muted small mb-2" id="reportSchoolMeta">কোড: | EIIN: </p>
                    <h4 class="fw-bold text-dark mt-3 mb-1" style="letter-spacing: 0.5px;">পরীক্ষার সময়সূচী</h4>
                    <h6>পরীক্ষা:<span class="text-black px-3 py-1.5" id="badgeExamType"></span></h6>
                    <span class="text-black px-3 py-1.5" id="">শ্রেণী: <strong id="metaClassName"></strong> || শাখা: <strong id="metaSectionName"></strong> || শিফট: <strong id="metaShiftName"></strong> || <strong id="metaGroupName"></strong></span>

                </div>

                <!-- Main Routine Table (Dynamic Columns Setup) -->
                <div class="table-responsive">
                    <table class="table custom-academic-table align-middle">
                        <thead id="examSchedulesTableHeader">
                            <!-- JS Dynamic Injection -->
                        </thead>
                        <tbody id="examSchedulesTableBody">
                            <!-- Dynamic Table Rows -->
                        </tbody>
                    </table>
                </div>

                <!-- Signature Pad Footer -->
                <div class="row mt-5 pt-5 signature-section">
                    <div class="col-6 text-start">
                        <div class="d-inline-block text-center" style="width: 200px;">
                            <hr class="mb-1" style="border-top: 1.5px solid #000 !important; opacity: 1;">
                            <span class="small fw-bold text-black">প্রস্তুতকারী (Clerk/Operator)</span>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="d-inline-block text-center" style="width: 200px;">
                            <hr class="mb-1" style="border-top: 1.5px solid #000 !important; opacity: 1;">
                            <span class="small fw-bold text-black">প্রধান শিক্ষক (Head Master)</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Select2 JavaScript dependency -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
{
    // Global local array in scope
    let loadedSchedules = [];

    // English to Bangla Digit Converter Utility
    function convertToBanglaNumber(number) {
        if (number === undefined || number === null || number === '') return '—';
        const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
        return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
    }

    // Dynamic Filter Trigger & Table Load Handler (Direct Academic View)
    async function loadSchedulesList() {
        const examTypeId = $('#filterExamTypeId').val();
        const classId = $('#filterClassId').val();
        const classSetupId = $('#filterClassSetupId').val();

        // If no filter is applied, hide table container and show standard landing state
        if (!examTypeId && !classId && !classSetupId) {
            $('#routineReportWrapper').addClass('d-none');
            $('#emptyStateMessage').removeClass('d-none');
            return;
        }

        // Prepare UI for Loading
        $('#emptyStateMessage').addClass('d-none');
        $('#routineReportWrapper').removeClass('d-none');
        $('#examSchedulesTableBody').html('<tr><td colspan="6" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm me-2"></span>তথ্য জেনারেট হচ্ছে...</td></tr>');

        try {
            const response = await axios.get('/api/exam-schedule-lists', {
                params: {
                    exam_type_id: examTypeId,
                    class_id: classId,
                    class_setup_id: classSetupId
                }
            });
                    

            // Map data securely
            loadedSchedules = response.data.all_data || [];
            
            if (loadedSchedules.length === 0) {
                $('#examSchedulesTableBody').html('<tr><td colspan="6" class="text-center py-4 text-muted">নির্বাচন করা ফিল্টারের অধীনে কোনো পরীক্ষার সময়সূচী পাওয়া যায়নি।</td></tr>');
                return;
            }

            // Bind School Information Dynamic Headers
            const school = response.data.school_information || {};
            $('#reportSchoolName').text(school.name_bn || school.name_en || 'এবিসি উচ্চ বিদ্যালয়');
            $('#reportSchoolMeta').text(`কোড: ${school.school_code || '—'} | EIIN: ${school.eiin || '—'}`);

            // Safe extracting of Academic Meta Information to prevent crashes
            const meta = loadedSchedules[0] || {};
            
            // Checking if values are null, empty, or '—' / 'N/A' to print clean N/A fallback
            const cleanMetaClassName = meta.class_name && meta.class_name !== '—' && meta.class_name !== 'N/A' ? meta.class_name : 'N/A';
            const cleanMetaSectionName = meta.section_name && meta.section_name !== '—' && meta.section_name !== 'N/A' ? meta.section_name : 'N/A';
            const cleanMetaShiftName = meta.shift_name && meta.shift_name !== '—' && meta.shift_name !== 'N/A' ? meta.shift_name : 'N/A';
            const cleanMetaGroupName = meta.group_name && meta.group_name !== '—' && meta.group_name !== 'N/A' ? meta.group_name : 'N/A';

            $('#metaClassName').text(cleanMetaClassName);
            $('#metaSectionName').text(cleanMetaSectionName);
            $('#metaShiftName').text(cleanMetaShiftName);
            $('#metaGroupName').text(cleanMetaGroupName);
            
            $('#metaExamType, #badgeExamType').text(meta.exam_type || 'N/A');

            // Determine if active group-wise rendering is needed
            const hasActiveGroups = loadedSchedules.some(item => 
                item.group_name && 
                item.group_name.trim() !== '' && 
                item.group_name.toLowerCase() !== 'compulsory' && 
                item.group_name !== '—' &&
                item.group_name !== 'N/A'
            );

            let rows = '';

            if (hasActiveGroups) {
                // 1. Grouped View Logic (Rowspan Mode)
                
                // Set Header Columns for Grouped Mode
                $('#examSchedulesTableHeader').html(`
                    <tr>
                        <th style="width: 15%; text-align: center;">গ্রুপ </th>
                        <th style="width: 8%; text-align: center;">ক্রমিক</th>
                        <th style="width: 32%;">বিষয় ও পত্র </th>
                        <th style="width: 18%;">তারিখ ও বার </th>
                        <th style="width: 15%; text-align: center;">সময় (Time)</th>
                        <th style="width: 12%;">রুম ও হল পরিদর্শক</th>
                    </tr>
                `);

                // Map data into group buckets
                const groups = {};
                loadedSchedules.forEach(item => {
                    let gName = item.group_name || 'Compulsory';
                    if (gName === '—' || gName.toLowerCase() === 'compulsory' || gName === 'N/A') {
                        gName = 'Compulsory';
                    }
                    if (!groups[gName]) {
                        groups[gName] = [];
                    }
                    groups[gName].push(item);
                });

                // Define traditional academic priority order
                const groupOrder = ['Compulsory', 'SCIENCE', 'COMMERCE', 'HUMANITIES'];
                const sortedGroupNames = Object.keys(groups).sort((a, b) => {
                    let indexA = groupOrder.indexOf(a);
                    let indexB = groupOrder.indexOf(b);
                    if (indexA === -1) indexA = 99;
                    if (indexB === -1) indexB = 99;
                    return indexA - indexB;
                });

                // Chronological sorting inside each group
                sortedGroupNames.forEach(gName => {
                    groups[gName].sort((a, b) => {
                        if (a.exam_date !== b.exam_date) {
                            return a.exam_date.localeCompare(b.exam_date);
                        }
                        return a.start_time.localeCompare(b.start_time);
                    });
                });

                let globalIndex = 1;

                sortedGroupNames.forEach(gName => {
                    const items = groups[gName];
                    const groupRowSpan = items.length;

                    // Group name label translations for beautiful display
                    let displayGroupName = gName;
                    if (gName === 'Compulsory') displayGroupName = 'আবশ্যিক (Compulsory)';
                    else if (gName === 'SCIENCE') displayGroupName = 'বিজ্ঞান (SCIENCE)';
                    else if (gName === 'COMMERCE') displayGroupName = 'ব্যবসায় শিক্ষা (COMMERCE)';
                    else if (gName === 'HUMANITIES') displayGroupName = 'মানবিক (HUMANITIES)';

                    items.forEach((item, index) => {
                        const dateObj = new Date(item.exam_date);
                        const banglaDateStr = dateObj.toLocaleDateString('bn-BD', { day: 'numeric', month: 'long', year: 'numeric' });
                        const weekdayStr = dateObj.toLocaleDateString('bn-BD', { weekday: 'long' });

                        const paperStr = (item.paper_name && item.paper_name !== '—' && item.paper_name !== 'N/A') ? ` ${item.paper_name}` : '';
                        const codeStr = (item.subject_code || item.code) ? ` (কোড: ${convertToBanglaNumber(item.subject_code || item.code)})` : '';
                        const formattedSubject = `<strong>${item.subject_name || '—'}</strong>${paperStr}${codeStr}`;

                        rows += `<tr>`;
                        
                        // Inject rowspanned group column only on the first row of each group bucket
                        if (index === 0) {
                            rows += `
                                <td rowspan="${groupRowSpan}" class="align-middle fw-bold text-center border-end">
                                    <div class="text-uppercase text-black text-wrap" style="font-size: 0.85rem; letter-spacing: 0.5px; writing-mode: vertical-rl; transform: rotate(180deg); margin: 0 auto;">
                                        ${displayGroupName}
                                    </div>
                                </td>
                            `;
                        }

                        rows += `
                                <td class="fw-bold text-center">${convertToBanglaNumber(globalIndex++)}</td>
                                <td>
                                    <span class="text-black">${formattedSubject}</span>
                                </td>
                                <td>
                                    <strong class="text-black d-block">${banglaDateStr}</strong>
                                    <small class="text-black d-block">${weekdayStr}</small>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-black">${convertToBanglaNumber(item.start_time)} - ${convertToBanglaNumber(item.end_time)}</span>
                                </td>
                                <td>
                                    <div class="text-black">রুম: ${item.room_name || '—'}</div>
                                    <small class="text-black d-block">ডিউটি: ${item.examiner_name || '—'}</small>
                                </td>
                            </tr>
                        `;
                    });
                });

            } else {
                // 2. Regular View Logic (As Usual Chronological list without group spanned columns)
                
                // Set Header Columns for Normal Mode
                $('#examSchedulesTableHeader').html(`
                    <tr>
                        <th style="width: 8%;">ক্রমিক</th>
                        <th style="width: 25%;">তারিখ ও বার (Date & Day)</th>
                        <th style="width: 35%;">বিষয় ও পত্র (Subject & Paper)</th>
                        <th style="width: 17%;">সময় (Time)</th>
                        <th style="width: 15%;">রুম ও হল পরিদর্শক</th>
                    </tr>
                `);

                loadedSchedules.forEach((item, index) => {
                    const dateObj = new Date(item.exam_date);
                    const banglaDateStr = dateObj.toLocaleDateString('bn-BD', { day: 'numeric', month: 'long', year: 'numeric' });
                    const weekdayStr = dateObj.toLocaleDateString('bn-BD', { weekday: 'long' });

                    const paperStr = (item.paper_name && item.paper_name !== '—' && item.paper_name !== 'N/A') ? ` ${item.paper_name}` : '';
                    const codeStr = (item.subject_code || item.code) ? ` (কোড: ${convertToBanglaNumber(item.subject_code || item.code)})` : '';
                    const formattedSubject = `<strong>${item.subject_name || '—'}</strong>${paperStr}${codeStr}`;

                    rows += `
                        <tr>
                            <td class="fw-bold text-center">${convertToBanglaNumber(index + 1)}</td>
                            <td>
                                <strong class="text-black d-block">${banglaDateStr}</strong>
                                <small class="text-black d-block">${weekdayStr}</small>
                            </td>
                            <td>
                                <span class="text-black">${formattedSubject}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-black">${convertToBanglaNumber(item.start_time)} - ${convertToBanglaNumber(item.end_time)}</span>
                            </td>
                            <td>
                                <div class="text-black">রুম: ${item.room_name || '—'}</div>
                                <small class="text-black d-block">ডিউটি: ${item.examiner_name || '—'}</small>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#examSchedulesTableBody').html(rows);
 
        } catch (error) {
            console.error('Failed to load exam schedules.', error);
            $('#examSchedulesTableBody').html('<tr><td colspan="6" class="text-center py-4 text-danger">সময়সূচী রেন্ডার করতে ব্যর্থ হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।</td></tr>');
        }
    }

    // Fetch master dropdown dependency structures and dynamic filter selectors
    async function loadFormDropdowns() {
        try {
            const response = await axios.get('/api/exam-schedule-dependencies');
            if (response.data?.status) {
                // Populate Filter Exam Types
                let filterTypeOptions = '<option value="">সকল পরীক্ষার ধরণ</option>'; 
                response.data.exam_types.forEach(item => {
                    filterTypeOptions += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#filterExamTypeId').html(filterTypeOptions);

                // Populate Filter Classes
                let filterClassOptions = '<option value="">সকল শ্রেণী</option>'; 
                response.data.classes.forEach(item => {
                    filterClassOptions += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#filterClassId').html(filterClassOptions);
            }
        } catch (error) {
            console.warn('Failed to load dropdown dependencies.');
        }
    }

    // Dynamic Cascading Dropdown for Class Setup Filters
    $(document).on('change', '#filterClassId', async function() {
        const classId = $(this).val();
        const targetSetupSelect = $('#filterClassSetupId');

        targetSetupSelect.prop('disabled', true).html('<option value="">লোড হচ্ছে...</option>');
        
        if (!classId) {
            targetSetupSelect.html('<option value="">প্রথমে শ্রেণী নির্বাচন করুন...</option>');
            loadSchedulesList(); 
            return;
        }

        try {
            const res = await axios.get(`/api/academic/exam-schedules/class-setups/${classId}`);
            if (res.data?.status) {
                let options = '<option value="">সকল শ্রেণীর বিন্যাস (All Class Setups)</option>';
                res.data.class_setups.forEach(item => {
                    options += `<option value="${item.id}">${item.label}</option>`;
                });
                targetSetupSelect.html(options).prop('disabled', false);
                loadSchedulesList();
            }
        } catch (error) {
            targetSetupSelect.html('<option value="">লোড ব্যর্থ হয়েছে!</option>');
        }
    });

    // Dynamic Filter Trigger Event Handler
    $(document).on('change', '#filterExamTypeId, #filterClassSetupId', function() {
        loadSchedulesList();
    });

    // Reset Filters
    $('#resetFiltersBtn').on('click', function() {
        $('#filterExamTypeId').val('');
        $('#filterClassId').val('');
        $('#filterClassSetupId').prop('disabled', true).html('<option value="">প্রথমে শ্রেণী নির্বাচন করুন...</option>');
        
        // Return to standard empty state
        loadSchedulesList();
    });

    // Document Initialization
    $(document).ready(function () {
        loadFormDropdowns();
    });
}
</script>
@endpush