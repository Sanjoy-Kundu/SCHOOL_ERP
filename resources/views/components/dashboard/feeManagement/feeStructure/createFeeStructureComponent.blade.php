@push('styles')
<style>
    /* Desktop Horizontal Scroll & Sticky First Column CSS Styling */
    .table-responsive-matrix {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }
    .custom-matrix-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        min-width: 1200px; /* Forces spacious scrollable view on smaller devices */
    }
    .custom-matrix-table thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        color: #2b3674 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem 0.5rem !important;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    /* Make the first column (Fee Category Name) sticky in horizontal scroll */
    .custom-matrix-table td.sticky-col,
    .custom-matrix-table th.sticky-col {
        position: sticky;
        left: 0;
        z-index: 5;
        background-color: #ffffff !important;
        border-right: 2px solid #dee2e6 !important;
        min-width: 200px;
    }
    .custom-matrix-table th.sticky-col {
        z-index: 11;
        background-color: #f8f9fa !important;
    }
    .custom-matrix-table tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.5rem !important;
        vertical-align: middle;
    }
    
    /* Minimal Amount inputs for precise table display */
    .matrix-input {
        width: 80px;
        text-align: right;
        padding: 4px 6px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        font-weight: bold;
        color: #2b3674;
    }
    .matrix-input:focus {
        border-color: #004d40;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 77, 64, 0.15);
    }

    /* Print Optimization CSS Stylesheet - Landscape Format */
 @media print {
        @page {
            size: A4 landscape; 
            margin: 15mm 10mm 15mm 10mm;
        }
        
        html, body {
            background-color: #fff !important;
            color: #000 !important;
            font-size: 11px !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
        }

        #wrapper, 
        .main-content, 
        .content-wrapper, 
        #tableCard, 
        .container, 
        .container-fluid, 
        .container-responsive,
        #matrixWrapper {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
            position: relative !important;
            background: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        .d-print-none,
        .sidebar,
        .navbar,
        .main-header,
        .main-footer,
        .card:not(#matrixWrapper),
        .btn,
        select,
        input:not(.matrix-input),
        label,
        .spinner-border,
        #emptyStateMessage {
            display: none !important;
        }

        #matrixWrapper {
            display: block !important;
            visibility: visible !important;
            width: 100% !important;
            padding: 5mm !important;
            box-shadow: none !important;
            border: none !important;
            background: transparent !important;
        }

      
        .text-center.mb-4.pb-3.border-bottom {
            margin-bottom: 20px !important;
            padding-bottom: 15px !important;
            border-bottom: 2px solid #000 !important;
        }

        .custom-matrix-table {
            width: 100% !important;
            min-width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 15px !important;
        }

        .custom-matrix-table thead th {
            background-color: #f2f2f2 !important;
            color: #000 !important;
            border: 1px solid #000 !important;
            padding: 6px 4px !important;
            font-size: 10px !important;
            font-weight: bold !important;
            text-align: center !important;
            position: static !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .custom-matrix-table tbody td {
            border: 1px solid #000 !important;
            padding: 6px 4px !important;
            font-size: 10px !important;
            color: #000 !important;
            vertical-align: middle !important;
            background-color: transparent !important;
        }

        .custom-matrix-table td.sticky-col,
        .custom-matrix-table th.sticky-col {
            position: static !important;
            background-color: transparent !important;
            border-right: 1px solid #000 !important;
        }

        
        .matrix-input {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            color: #000 !important;
            font-weight: bold !important;
            text-align: right !important;
            width: 100% !important;
            padding: 0 !important;
        }

        .matrix-input::-webkit-outer-spin-button,
        .matrix-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .table-secondary {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

   
        tr {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .signature-section {
            display: flex !important;
            margin-top: 55px !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .signature-section hr {
            border-top: 1.5px solid #000 !important;
            opacity: 1 !important;
            margin-bottom: 5px !important;
        }
        
        .signature-section span {
            color: #000 !important;
            font-weight: bold !important;
        }
    } 

</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2 d-print-none">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">ফি কাঠামো নির্ধারণ (Fee Structure)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের বিভিন্ন শ্রেণী বিন্যাসের অধীনে শিক্ষাবর্ষ ভিত্তিক ফি এর তালিকা সেট করুন।</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" id="printReportBtn" onclick="window.print();" class="btn btn-primary fw-bold px-3 py-2 rounded-3 shadow-sm d-none">
                <i class="fa-solid fa-print me-2"></i>প্রিন্ট / PDF ডাউনলোড
            </button>
            <button type="button" class="btn btn-outline-primary fw-bold px-3 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#copyStructureModal">
                <i class="fa-solid fa-copy me-2"></i>পূর্ববর্তী শিক্ষাবর্ষ থেকে কপি করুন
            </button>
        </div>
    </div>

    <!-- Filter/Loader Card Selection -->
    <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm mb-4 d-print-none">
        <h5 class="fw-bold text-dark mb-3">
            <i class="fa-solid fa-sliders text-success me-2"></i>কাঠামো ফিল্টার প্যারামিটার
        </h5>
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <label for="filterSessionId" class="form-label small fw-bold text-secondary mb-1">শিক্ষাবর্ষ (Academic Session) *</label>
                <select id="filterSessionId" class="form-select form-select-sm rounded-3">
                    <option value="" selected disabled>শিক্ষাবর্ষ লোড হচ্ছে...</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <label for="filterClassSetupId" class="form-label small fw-bold text-secondary mb-1">শ্রেণী বিন্যাস (Class Setup) *</label>
                <select id="filterClassSetupId" class="form-select form-select-sm rounded-3">
                    <option value="" selected disabled>শ্রেণী বিন্যাস লোড হচ্ছে...</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <button type="button" id="loadStructureBtn" class="btn btn-sm btn-success w-100 fw-bold rounded-3 py-2" style="background-color: #004d40; border-color: #004d40;">
                    <i class="fa-solid fa-cloud-arrow-down me-1"></i> ফি কাঠামো লোড করুন
                </button>
            </div>
        </div>
    </div>

    <!-- Empty State / Instruction Loader Block -->
    <div id="emptyStateMessage" class="text-center py-5 bg-white rounded-3 shadow-sm card-responsive border d-print-none animate__animated animate__fadeIn">
        <i class="fa-solid fa-table-cells text-warning fs-1 mb-3 d-block"></i>
        <h5 class="fw-bold text-black">ফি কাঠামো লোড করুন</h5>
        <p class="text-black small mb-0 px-3">ফি ম্যাট্রিক্স জেনারেট এবং কনফিগার করতে অনুগ্রহ করে উপরের শিক্ষাবর্ষ ও শ্রেণী নির্বাচন করে "ফি কাঠামো লোড করুন" বাটনে ক্লিক করুন।</p>
    </div>

    <!-- Dynamic Main Yearly Matrix Table Wrapper -->
    <div id="matrixWrapper" class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm d-none">

        <!-- School Information Branding Header Block (Responsive and Premium Layout) -->
        <div id="schoolHeaderBlock" class="d-flex align-items-center justify-content-center gap-3 border-bottom pb-4 mb-4 flex-column flex-sm-row text-center text-sm-start d-none">
            <div class="flex-shrink-0">
                <img id="schoolLogo" src="" alt="School Logo" class="img-fluid rounded-circle border p-1 shadow-sm bg-light" style="width: 85px; height: 85px; object-fit: cover;">
            </div>
            <div class="flex-grow-1">
                <h3 id="schoolNameBn" class="fw-bold mb-1 text-success" style="color: #004d40 !important; font-size: 1.5rem;"></h3>
                <h3 id="schoolNameEn" class="text-black mb-2 fw-semibold text-uppercase tracking-wide" style="font-size: 0.95rem; opacity: 0.85;"></h3>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-sm-start text-black small">
                    <span><i class="fa-solid fa-hashtag me-1 text-success"></i>ইআইআইএন (EIIN): <strong id="schoolEiin" class="text-black"></strong></span>
                    <span><i class="fa-solid fa-barcode me-1 text-success"></i>স্কুল কোড: <strong id="schoolCode" class="text-black"></strong></span>
                    <span><i class="fa-solid fa-calendar-day me-1 text-success"></i>স্থাপিত: <strong id="schoolEst" class="text-black"></strong></span>
                </div>
                <!-- Premium Sub-header Meta Data for Print Sheet -->
                <div class="mt-2 text-dark small fw-bold">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill" style="font-size: 0.85rem;">
                        শিক্ষাবর্ষ: <strong id="metaSessionName"></strong> || শ্রেণী বিন্যাস: <strong id="metaClassLabel"></strong>
                    </span>
                </div>
                <p id="schoolAddress" class="mb-0 text-black small mt-1"></p>
            </div>
        </div>

        <h5 class="fw-bold text-dark mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2 d-print-none">
            <span><i class="fa-solid fa-table text-success me-2"></i>বার্ষিক ফি ম্যাট্রিক্স বিবরণী</span>
            <span class="badge bg-light text-success border border-success px-3 py-2 rounded-pill fs-6" id="badgeSessionClass"></span>
        </h5>

        <form id="feeStructureForm">
            <div class="table-responsive-matrix">
                <table class="table custom-matrix-table align-middle">
                    <thead>
                        <tr id="matrixHeader">
                            <!-- JS Dynamic columns inject target -->
                        </tr>
                    </thead>
                    <tbody id="matrixBody">
                        <!-- JS Dynamic rows inject target -->
                    </tbody>
                </table>
            </div>

            <!-- Footer Save, Reset and Totals summaries -->
            <div class="row mt-4 pt-3 border-top g-3 align-items-center">
                <div class="col-12 col-md-6 text-start">
                    <h5 class="fw-bold text-secondary mb-0">সর্বমোট বার্ষিক ফি (Grand Total): ৳ <span id="grandAnnualTotal" class="text-success fs-4 fw-bold">০.০০</span></h5>
                </div>
                <div class="col-12 col-md-6 text-end d-flex justify-content-md-end justify-content-center gap-2 flex-wrap d-print-none">
                    <button type="button" id="resetStructureBtn" class="btn btn-outline-danger fw-bold px-3 py-2 rounded-3 shadow-sm">
                        <i class="fa-solid fa-arrows-rotate me-2"></i>রিসেট করুন
                    </button>
                    <button type="submit" id="saveStructureBtn" class="btn btn-success fw-bold px-4 py-2 rounded-3 shadow-sm" style="background-color: #004d40; border-color: #004d40;">
                        <i class="fa-solid fa-circle-check me-2"></i>ফি কাঠামো সংরক্ষণ করুন
                    </button>
                </div>
            </div>

            <!-- Signature Pad Footer for Printing -->
            <div class="row mt-5 pt-4 signature-section d-none">
                <div class="col-6 text-start">
                    <div class="d-inline-block text-center" style="width: 200px;">
                        <hr class="mb-1" style="border-top: 1.5px solid #000 !important; opacity: 1;">
                        <span class="small fw-bold text-black">প্রস্তুতকারী (Accountant/Clerk)</span>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <div class="d-inline-block text-center" style="width: 200px;">
                        <hr class="mb-1" style="border-top: 1.5px solid #000 !important; opacity: 1;">
                        <span class="small fw-bold text-black">প্রধান শিক্ষক / অধ্যক্ষ</span>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- Copy Structure Modal Interface -->
<div class="modal fade" id="copyStructureModal" tabindex="-1" aria-labelledby="copyStructureModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header text-white" style="background-color: #004d40;">
                <h5 class="modal-title fw-bold" id="copyStructureModalLabel">
                    <i class="fa-solid fa-copy me-2 text-warning"></i>শিক্ষাবর্ষের কাঠামো কপি করুন
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="copyModalCloseBtn"></button>
            </div>
            <form id="copyStructureForm" novalidate>
                <div class="modal-body p-4">
                    <p class="text-muted small">নির্ধারিত উৎসের (Source) শিক্ষাবর্ষের সকল কনফিগারেশন টার্গেট শিক্ষাবর্ষে কপি হয়ে যাবে।</p>
                    
                    <!-- Source Session -->
                   <!-- Source Session -->
                    <div class="mb-3">
                        <label for="sourceSessionId" class="form-label fw-semibold small text-dark">উৎস শিক্ষাবর্ষ (Source Session) *</label>
                        <select class="form-select rounded-3" id="sourceSessionId" required>
                            <option value="" selected disabled>শিক্ষাবর্ষ লোড হচ্ছে...</option>
                        </select>
                        <div class="invalid-feedback" id="error-source-session"></div>
                    </div>

                     <!-- Target Session -->
                    <div class="mb-3">
                        <label for="targetSessionId" class="form-label fw-semibold small text-dark">টার্গেট শিক্ষাবর্ষ (Target Session) *</label>
                        <select class="form-select rounded-3" id="targetSessionId" required>
                            <option value="" selected disabled>শিক্ষাবর্ষ লোড হচ্ছে...</option>
                        </select>
                        <div class="invalid-feedback" id="error-target-session"></div>
                    </div>

                          <!-- Class Setup Target -->
                    <div class="mb-3">
                        <label for="copyClassSetupId" class="form-label fw-semibold small text-dark">শ্রেণী বিন্যাস (Class Setup Target) *</label>
                        <select class="form-select rounded-3" id="copyClassSetupId" required>
                            <option value="" selected disabled>শ্রেণী বিন্যাস লোড হচ্ছে...</option>
                        </select>
                        <div class="invalid-feedback" id="error-copy-class-setup"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top rounded-bottom-4">
                    <button type="button" class="btn btn-secondary px-4 fw-bold rounded-3" data-bs-dismiss="modal">বাতিল করুন</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold rounded-3" id="copySubmitBtn" style="background-color: #004d40; border-color: #004d40;">কাঠামো কপি করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
$(document).ready(function() {
    // Global parameters inside scope
    let activeMonths = [];
    let activeCategories = [];
    let savedMatrix = {};

    // English to Bangla Digit Converter Utility
    function convertToBanglaNumber(number) {
        if (number === undefined || number === null || number === '') return '০';
        const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
        return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
    }

    // Dynamic Real-time totals math calculations
    function calculateMatrixTotals() {
        let grandTotal = 0;
        
        activeCategories.forEach(cat => {
            let rowTotal = 0;
            if (cat.type === 'one_time') {
                // One-time configurations don't have month bindings.
                // Pull directly from the annual amount input (month index mapped to 0)
                const val = parseFloat($(`.matrix-input[data-category="${cat.id}"][data-month="0"]`).val()) || 0;
                rowTotal = val;
            } else {
                // For monthly and custom categories
                activeMonths.forEach(m => {
                    const val = parseFloat($(`.matrix-input[data-category="${cat.id}"][data-month="${m.id}"]`).val()) || 0;
                    rowTotal += val;
                });
            }
            $(`#rowTotal-${cat.id}`).text(convertToBanglaNumber(rowTotal.toFixed(2)));
            grandTotal += rowTotal;
        });

        // Calculate column totals (Only relevant for monthly and custom columns)
        activeMonths.forEach(m => {
            let colTotal = 0;
            activeCategories.forEach(cat => {
                if (cat.type !== 'one_time') {
                    const val = parseFloat($(`.matrix-input[data-category="${cat.id}"][data-month="${m.id}"]`).val()) || 0;
                    colTotal += val;
                }
            });
            $(`#colTotal-${m.id}`).text(convertToBanglaNumber(colTotal.toFixed(2)));
        });

        // Set global grand total sum
        $('#grandAnnualTotal').text(convertToBanglaNumber(grandTotal.toFixed(2)));
    }


        // Load initial dropdown values from API
    async function loadInitialData() {
        try {
            const res = await axios.get('/api/fees/structure/initial-data');
            if (res.data.status === true) {
                const sessions = res.data.sessions || [];
                const classSetups = res.data.classSetups || [];

                // 1. Populate Sessions Dropdown
                let sessionOptions = '<option value="" selected disabled>শিক্ষাবর্ষ নির্বাচন করুন...</option>';
                sessions.forEach(session => {
                    sessionOptions += `<option value="${session.id}">${session.name}</option>`;
                });
                $('#filterSessionId').html(sessionOptions);
                $('#sourceSessionId').html(sessionOptions);
                $('#targetSessionId').html(sessionOptions);

                // 2. Populate Class Setup Dropdown
                let classOptions = '<option value="" selected disabled>শ্রেণী বিন্যাস নির্বাচন করুন...</option>';
                classSetups.forEach(setup => {
                    const className = setup.school_class ? setup.school_class.name : (setup.schoolClass ? setup.schoolClass.name : '—');
                    const sectionName = setup.section ? ' - ' + setup.section.name : '';
                    const shiftName = setup.shift ? ' - ' + setup.shift.name : '';
                    classOptions += `<option value="${setup.id}">${className}${sectionName}${shiftName}</option>`;
                });
                $('#filterClassSetupId').html(classOptions);
                $('#copyClassSetupId').html(classOptions);
            }
        } catch (error) {
            console.error('Failed to load initial dropdown data:', error);
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি!',
                text: 'পেজের প্রাথমিক তালিকা ড্রপডাউন ডাটা লোড করতে ব্যর্থ হয়েছে।',
                confirmButtonColor: '#d33'
            });
        }
    }

    // Call drop downs loader immediately on load
    loadInitialData();

    // Direct event listener for input value keyups
    $(document).on('keyup input', '.matrix-input', function () {
        if (parseFloat($(this).val()) < 0) {
            $(this).val(0);
        }
        calculateMatrixTotals();
    });

    // Reset Page back to default initial state
    $(document).on('click', '#resetStructureBtn', function() {
        // Clear Filter values
        $('#filterSessionId').val('');
        $('#filterClassSetupId').val('');

        // Toggle UI wrappers back to original empty state
        $('#matrixWrapper').addClass('d-none');
        $('#emptyStateMessage').removeClass('d-none');
        $('#printReportBtn').addClass('d-none'); // Hide print button on reset

        // Clear dynamic elements safely
        $('#matrixHeader').empty();
        $('#matrixBody').empty();
        $('#grandAnnualTotal').text('০.০০');

        $('html, body').animate({ scrollTop: 0 }, 'fast');

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'info',
            title: 'ফি কাঠামো রিসেট করা হয়েছে।'
        });
    });

    // CRUD Load yearly fee matrix mapping configuration
    $('#loadStructureBtn').on('click', async function (e) {
        e.preventDefault();

        const sessionId = $('#filterSessionId').val();
        const classSetupId = $('#filterClassSetupId').val();

        if (!sessionId || !classSetupId) {
            Swal.fire({
                icon: 'warning',
                title: 'প্যারামিটার অমিল!',
                text: 'অনুগ্রহ করে প্রথমে শিক্ষাবর্ষ এবং শ্রেণী বিন্যাস নির্বাচন করুন।',
                confirmButtonColor: '#004d40'
            });
            return;
        }

        $('#emptyStateMessage').addClass('d-none');
        $('#matrixWrapper').removeClass('d-none');
        $('#matrixBody').html('<tr><td colspan="15" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm me-2"></span>তথ্য জেনারেট হচ্ছে...</td></tr>');

        try {
            const res = await axios.get('/api/fees/structure/load', {
                params: {
                    academic_session_id: sessionId,
                    class_setup_id: classSetupId
                }
            });

            if (res.data.status === true) {
                activeMonths = res.data.months || [];
                activeCategories = res.data.categories || [];
                savedMatrix = res.data.matrix || {};
                const school = res.data.school;
                const classSetup = res.data.class_setup;

                // Show Print PDF button dynamically when loaded
                $('#printReportBtn').removeClass('d-none');

                // --- SCHOOL BRANDING HEADER RENDERING ---
                if (school) {
                    $('#schoolNameBn').text(school.name_bn || 'বিদ্যালয়ের নাম');
                    $('#schoolNameEn').text(school.name_en || 'SCHOOL NAME');
                    $('#schoolEiin').text(convertToBanglaNumber(school.eiin || '—'));
                    $('#schoolCode').text(convertToBanglaNumber(school.school_code || '—'));
                    
                    const estYear = school.established_year ? school.established_year.toString() : '—';
                    $('#schoolEst').text(convertToBanglaNumber(estYear));
                    
                    let addressText = school.address || 'ঠিকানা প্রদান করা হয়নি';
                    if (school.phone) {
                        addressText += ' | ফোন: ' + convertToBanglaNumber(school.phone);
                    }
                    $('#schoolAddress').text(addressText);

                    const logoUrl = school.logo_circle_url || school.logo_square_url || '/images/defaults/circle-logo.png';
                    $('#schoolLogo').attr('src', logoUrl);

                    $('#schoolHeaderBlock').removeClass('d-none').addClass('d-flex');
                } else {
                    $('#schoolHeaderBlock').addClass('d-none').removeClass('d-flex');
                }

                // Bind Meta Session & Class Information
                const sessionLabel = $('#filterSessionId option:selected').text();
                let classLabel = '—';
                if (classSetup) {
                    const className = classSetup.school_class ? classSetup.school_class.name : (classSetup.schoolClass ? classSetup.schoolClass.name : '—');
                    const sectionName = classSetup.section ? ' - ' + classSetup.section.name : '';
                    const shiftName = classSetup.shift ? ' - ' + classSetup.shift.name : '';
                    const groupName = (classSetup.group && classSetup.group.name !== '—' && classSetup.group.name !== 'N/A') ? ' (' + classSetup.group.name + ')' : '';
                    classLabel = `${className}${sectionName}${shiftName}${groupName}`;
                }
                $('#metaSessionName').text(sessionLabel);
                $('#metaClassLabel').text(classLabel);

                $('#badgeSessionClass').text(`${sessionLabel} | ${classLabel}`);

                // Generate table columns headers
                let headerHtml = `<th class="sticky-col">ফি ক্যাটাগরি</th>`;
                activeMonths.forEach(m => {
                    headerHtml += `<th>${m.name}</th>`;
                });
                headerHtml += `<th>বছরওয়ারী মোট</th>`;
                $('#matrixHeader').html(headerHtml);

                // Generate table body rows
                let rowsHtml = '';
                activeCategories.forEach(cat => {
                    rowsHtml += `<tr>`;
                    rowsHtml += `<td class="sticky-col fw-bold text-dark">${cat.name}</td>`;
                    
                    if (cat.type === 'one_time') {
                        // Yearly / One-time fee category: spans across all 12 month columns cleanly
                        // Inputs bind to month_id "0"
                        const amountVal = savedMatrix[cat.id] && savedMatrix[cat.id][0] !== undefined 
                            ? savedMatrix[cat.id][0] 
                            : '';

                        rowsHtml += `
                            <td colspan="${activeMonths.length}" class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="fw-semibold text-secondary me-2 small">বার্ষিক পরিমাণ (Annual Amount): ৳</span>
                                    <input type="number" 
                                           class="matrix-input text-center w-25 border border-success" 
                                           name="fees[${cat.id}][0]" 
                                           data-category="${cat.id}" 
                                           data-month="0" 
                                           value="${amountVal}" 
                                           placeholder="০" 
                                           min="0" 
                                           step="50">
                                </div>
                            </td>
                        `;
                    } else {
                        // Monthly & Custom fee categories: render individual month columns
                        activeMonths.forEach(m => {
                            const amountVal = savedMatrix[cat.id] && savedMatrix[cat.id][m.id] !== undefined 
                                ? savedMatrix[cat.id][m.id] 
                                : '';

                            rowsHtml += `
                                <td class="text-center">
                                    <input type="number" 
                                           class="matrix-input" 
                                           name="fees[${cat.id}][${m.id}]" 
                                           data-category="${cat.id}" 
                                           data-month="${m.id}" 
                                           value="${amountVal}" 
                                           placeholder="০" 
                                           min="0" 
                                           step="10">
                                </td>
                            `;
                        });
                    }

                    // Row total placeholder
                    rowsHtml += `<td class="text-center fw-bold text-primary" id="rowTotal-${cat.id}">০.০০</td>`;
                    rowsHtml += `</tr>`;
                });

                // Generate monthly column totals summary row at the bottom of matrix
                let colTotalRow = `<tr class="table-secondary fw-bold">`;
                colTotalRow += `<td class="sticky-col">মাসিক সর্বমোট</td>`;
                activeMonths.forEach(m => {
                    colTotalRow += `<td class="text-center" id="colTotal-${m.id}">০.০০</td>`;
                });
                colTotalRow += `<td class="text-center text-success" id="grandTotalPlaceholder">৳</td>`;
                colTotalRow += `</tr>`;

                rowsHtml += colTotalRow;
                $('#matrixBody').html(rowsHtml);

                // Calculate totals initially
                calculateMatrixTotals();
            }

        } catch (error) {
            console.log(error);
            console.error('Failed to load matrix.', error);
            $('#matrixWrapper').addClass('d-none');
            $('#emptyStateMessage').removeClass('d-none');
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি!',
                text: error.response?.data?.message || 'রুটিন লোড করতে সমস্যা হয়েছে।',
                confirmButtonColor: '#d33'
            });
        }
    });

    // CRUD: Store or Update Asynchronously via Axios
    $('#feeStructureForm').on('submit', async function (e) {
        e.preventDefault();

        const saveBtn = $('#saveStructureBtn');
        saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>সংরক্ষণ হচ্ছে...');

        // Serialize the matrix form into key/value payload mappings
        const formData = new FormData(this);
        formData.append('academic_session_id', $('#filterSessionId').val());
        formData.append('class_setup_id', $('#filterClassSetupId').val());

        try {
            const res = await axios.post('/api/fees/structure/store', formData);
            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: 'সংরক্ষণ সম্পন্ন!',
                    text: res.data.message || 'Stored successfully.',
                    confirmButtonColor: '#004d40'
                });
                // Reload stored matrix representation dynamically
                $('#loadStructureBtn').trigger('click');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি!',
                text: error.response?.data?.message || 'সংরক্ষণ করতে সমস্যা হয়েছে।',
                confirmButtonColor: '#d33'
            });
        } finally {
            saveBtn.prop('disabled', false).html('<i class="fa-solid fa-circle-check me-2"></i>ফি কাঠামো সংরক্ষণ করুন');
        }
    });

    // Action: Copy previous academic session configurations
    $('#copyStructureForm').on('submit', async function (e) {
        e.preventDefault();

        const submitBtn = $('#copySubmitBtn');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>কপি হচ্ছে...');

        // Clear previous error styles
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');

        const payload = {
            source_session_id: $('#sourceSessionId').val(),
            target_session_id: $('#targetSessionId').val(),
            class_setup_id: $('#copyClassSetupId').val()
        };

        try {
            const res = await axios.post('/api/fees/structure/copy', payload);
            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: 'কপি সম্পন্ন!',
                    text: res.data.message || 'Copied successfully.',
                    confirmButtonColor: '#004d40'
                }).then(() => {
                    $('#copyStructureModal').modal('hide');
                    $('#copyStructureForm')[0].reset();
                    
                    // Automatically filter to target session to show copied structure immediately
                    $('#filterSessionId').val(payload.target_session_id);
                    $('#filterClassSetupId').val(payload.class_setup_id);
                    $('#loadStructureBtn').trigger('click');
                });
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                const generalMessage = error.response.data.message;

                if (errors) {
                    if (errors.source_session_id) {
                        $('#sourceSessionId').addClass('is-invalid');
                        $('#error-source-session').html(errors.source_session_id[0]);
                    }
                    if (errors.target_session_id) {
                        $('#targetSessionId').addClass('is-invalid');
                        $('#error-target-session').html(errors.target_session_id[0]);
                    }
                    if (errors.class_setup_id) {
                        $('#copyClassSetupId').addClass('is-invalid');
                        $('#error-copy-class-setup').html(errors.class_setup_id[0]);
                    }
                }

                if (generalMessage && !errors) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'কপি ব্যর্থ হয়েছে',
                        text: generalMessage,
                        confirmButtonColor: '#004d40'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি!',
                    text: error.response?.data?.message || 'রুটিন কপি করতে সমস্যা হয়েছে।',
                    confirmButtonColor: '#d33'
                });
            }
        } finally {
            submitBtn.prop('disabled', false).html('কাঠামো কপি করুন');
        }
    });

    // Reset copy modal on close click
    $('#copyModalCloseBtn').on('click', function () {
        $('#copyStructureForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    });
});
</script>
@endpush