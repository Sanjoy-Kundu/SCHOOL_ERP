@push('styles')
<style>
    /* ==========================================================================
       Master Admission Card, Header, and Progress Bar Theme Styles (Bootstrap 5.2.3)
       ========================================================================== */
    
    :root {
        --brand-primary: #004d40;     /* Deep Cohesive Brand Green */
        --brand-primary-hover: #00332c;
        --brand-accent: #da291c;      /* Govt Red Accent */
        --brand-success: #198754;     /* Standard Success Green */
        --bg-light-gray: #f8f9fa;
        --border-color: #e9ecef;
    }

    /* Container max-width with responsive gaps */
    .container-responsive {
        max-width: 1200px;
    }

    /* Premium Shadow and Borders */
    .form-card {
        border: none;
        border-radius: 1rem; /* 16px */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        background-color: #ffffff;
        overflow: hidden;
    }

    /* Header styling with branded bottom border */
    .form-header {
        border-bottom: 4px solid var(--brand-primary);
        background-color: #ffffff;
    }

    .school-logo {
        width: 72px;
        height: 72px;
        border: 2px solid var(--brand-primary);
        object-fit: cover;
    }

    .school-name {
        color: var(--brand-primary);
        font-weight: 700;
        font-size: 1.45rem;
    }

    .form-title {
        color: var(--brand-accent);
        font-weight: 800;
        font-size: 1.35rem;
    }

    /* Step Progress Indicator Settings */
    .step-container {
        background-color: var(--bg-light-gray);
        border-bottom: 1px solid var(--border-color);
    }

    .step-indicator {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }

    /* Connecting line background */
    .step-indicator::before {
        content: "";
        position: absolute;
        top: 20px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: var(--border-color);
        z-index: 1;
    }

    /* Dynamic progress line */
    .step-progress-line {
        position: absolute;
        top: 20px;
        left: 0;
        height: 3px;
        background-color: var(--brand-primary);
        z-index: 1;
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        width: 0%;
    }

    .step {
        position: relative;
        z-index: 2;
    }

    /* Circular Step Number Badge */
    .step-number {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background-color: #ffffff;
        border: 3px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: #6c757d;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Active Step State */
    .step.active .step-number {
        border-color: var(--brand-primary);
        background-color: var(--brand-primary);
        color: #ffffff;
        box-shadow: 0 0 0 5px rgba(0, 77, 64, 0.15);
    }

    /* Completed Step State */
    .step.completed .step-number {
        border-color: var(--brand-success);
        background-color: var(--brand-success);
        color: #ffffff;
    }

    /* Step Typography */
    .step-text {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6c757d;
        margin-top: 8px;
        transition: color 0.3s ease;
    }

    .step.active .step-text {
        color: var(--brand-primary);
        font-weight: 700;
    }

    .step.completed .step-text {
        color: var(--brand-success);
    }

    /* Step Visibility */
    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    /* Button Styling */
    .btn-next, .btn-submit {
        min-width: 160px;
        background-color: var(--brand-primary) !important;
        border-color: var(--brand-primary) !important;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 77, 64, 0.15);
        transition: all 0.2s ease-in-out;
    }

    .btn-next:hover, .btn-submit:hover {
        background-color: var(--brand-primary-hover) !important;
        border-color: var(--brand-primary-hover) !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 77, 64, 0.25);
    }

    .btn-next:active, .btn-submit:active {
        transform: translateY(0);
    }

    /* Responsive Adjustments using Media Queries */
    @media (max-width: 767.98px) {
        .step-text {
            display: none; /* Mobile-friendly clean UI */
        }
        .school-logo {
            width: 55px;
            height: 55px;
        }
        .school-name {
            font-size: 1.15rem;
        }
        .form-title {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

<div class="container container-responsive py-4 px-3 px-md-4">
    <div class="card form-card">

        <!-- =====================================================
             1. SCHOOL HEADER BLOCK
        ====================================================== -->
        <div class="form-header p-4 p-md-5">
            <div class="row align-items-center g-3">
                <!-- Logo and Branding -->
                <div class="col-12 col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <img id="dynSchoolLogo" src="https://via.placeholder.com/100" class="school-logo rounded-circle shadow-sm" alt="School Logo">
                        <div>
                            <h1 class="school-name mb-0"><span id="dynSchoolNameBn"></span></h1>
                            <div class="text-muted fw-semibold small tracking-wide text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                <span id="dynSchoolNameEn"></span>
                            </div>
                            <div class="text-muted small mt-1">
                                <span class="d-inline-block me-2">EIIN: <i id="dynSchoolEiin"></i></span> | 
                                <span class="d-inline-block mx-2">School Code: <i id="dynSchoolCode"></i></span> | 
                                <span class="d-inline-block ms-2">প্রতিষ্ঠিত: <i id="dynSchoolEst"></i></span>
                            </div>

                            <div class="text-muted small">
                                <span id="dynSchoolAddress"></span> 
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info/Status Block -->
                <div class="col-12 col-md-4 text-md-end text-start mt-3 mt-md-0">
                    <div class="form-title">শিক্ষার্থী ভর্তি</div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill mt-2">
                        শিক্ষাবর্ষ: <b id="current_year"></b>
                    </span>
                    <div id="liveClock" class="small text-muted mt-2 fw-semibold d-flex justify-content-start justify-content-md-end align-items-center gap-1" style="font-size: 12px;">
                        <!-- Live date and time will load here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- =====================================================
             2. STEP PROGRESS BAR
        ====================================================== -->
        <div class="step-container p-4 p-md-5">
            <div class="step-indicator d-flex justify-content-between align-items-center">
                <div class="step-progress-line" id="stepProgressLine"></div>
                
                <div class="step active text-center flex-fill" id="stepIndicator1">
                    <div class="step-number mx-auto">১</div>
                    <div class="step-text">একাডেমিক তথ্য</div>
                </div>
                <div class="step text-center flex-fill" id="stepIndicator2">
                    <div class="step-number mx-auto">২</div>
                    <div class="step-text">শিক্ষার্থীর তথ্য</div>
                </div>
                <div class="step text-center flex-fill" id="stepIndicator3">
                    <div class="step-number mx-auto">৩</div>
                    <div class="step-text">অভিভাবক ও অন্যান্য</div>
                </div>
                <div class="step text-center flex-fill" id="stepIndicator4">
                    <div class="step-number mx-auto">৪</div>
                    <div class="step-text">ফি ও পেমেন্ট</div>
                </div>
            </div>
        </div>

        <!-- =====================================================
             3. MAIN ADMISSION FORM WITH ENCAPSULATED SUB-STEPS
        ====================================================== -->
        <form id="admissionForm" class="needs-validation" novalidate enctype="multipart/form-data">
            @csrf

            <!-- STEP 1: ACADEMIC INFORMATION -->
            <div class="form-step active" id="step1">
                @include('components.dashboard.admission.academicStepComponent')
            </div>

            <!-- STEP 2: STUDENT INFORMATION -->
            <div class="form-step" id="step2">
                @include('components.dashboard.admission.studentStepComponent')
            </div>

            <!-- STEP 3: PARENT / GUARDIAN & CONDITIONAL DETAILS -->
            <div class="form-step" id="step3">
                @include('components.dashboard.admission.parentStepComponent')
            </div>

            <!-- STEP 4: FEES & PAYMENT -->
            <div class="form-step" id="step4">
                @include('components.dashboard.admission.paymentStepComponent')
            </div>

        </form>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
   // English to Bangla Digit Converter Utility
    function convertToBanglaNumber(number) {
        const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
        return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
    }

       /* =========================================================
       1. FETCH PUBLIC INSTITUTE INFORMATION DYNAMICALLY
    ========================================================= */
    async function loadInstituteInformation() {
        try {
            const response = await axios.get('/api/public/institute-information');
            
            if (response.data && response.data.status) {
                const school = response.data.data;
                
                // Set Header values dynamically
                if (document.getElementById('dynSchoolNameBn')) document.getElementById('dynSchoolNameBn').textContent = school.name_bn;
                if (document.getElementById('dynSchoolNameEn')) document.getElementById('dynSchoolNameEn').textContent = school.name_en;
                if (document.getElementById('dynSchoolEiin')) document.getElementById('dynSchoolEiin').textContent = convertToBanglaNumber(school.eiin);
                if (document.getElementById('dynSchoolCode')) document.getElementById('dynSchoolCode').textContent = school.school_code;
                if (document.getElementById('dynSchoolEst')) document.getElementById('dynSchoolEst').textContent = convertToBanglaNumber(school.established_year);
                if (document.getElementById('dynSchoolAddress')) document.getElementById('dynSchoolAddress').textContent = `${school.address} | ফোন: ${convertToBanglaNumber(school.phone)}`;
                
                // Set logo path
                if (document.getElementById('dynSchoolLogo')) {
                    document.getElementById('dynSchoolLogo').src = school.logo_circle_url || `/${school.logo_circle_path}`;
                }
            }
        } catch (error) {
            console.warn('Institute settings load failed: Dynamic API connection issues.');
        }
    }


/* =========================================================
   2. FETCH AND POPULATE ACADEMIC SESSIONS DYNAMICALLY
========================================================= */
async function loadAcademicSessionsDropdown() {
    const sessionSelect = document.getElementById('academicSession');
    const currentYearEl = document.getElementById('current_year'); 
    if (!sessionSelect) return;

    try {
        const response = await axios.get('/api/public/academic-session');
        
        if (response.data && response.data.status) {
            const sessions = response.data.all_data || response.data.data;
            
            sessionSelect.innerHTML = '<option value="">শিক্ষাবর্ষ নির্বাচন করুন</option>';
            sessions.forEach(session => {
                
                const isActive = session.is_active == 1 || session.is_active === true;
                const selectedAttr = isActive ? 'selected' : '';
                const banglaYear = convertToBanglaNumber(session.name);
                
                // If the session is active, set the badge text dynamically
                if (isActive && currentYearEl) {
                    currentYearEl.textContent = banglaYear;
                }

                sessionSelect.insertAdjacentHTML('beforeend', `
                    <option value="${session.id}" ${selectedAttr}>${banglaYear}</option>
                `);
            });
        }
    } catch (error) {
        console.warn('Academic sessions dropdown data load failed.', error);
    }
}



      /* =========================================================
       4. FETCH AND POPULATE ACADEMIC MONTH LISTS DYNAMICALLY
    ========================================================= */
    async function loadAcademicMonthsDropdown() {
        const monthSelect = document.getElementById('joiningMonth');
        if (!monthSelect) return;

        try {
            const response = await axios.get('/api/public/academic-month-lists');
            
            if (response.data && response.data.status) {
                const months = response.data.all_data || response.data.data;
                
                monthSelect.innerHTML = '<option value="">মাস নির্বাচন করুন</option>';
                months.forEach(month => {
                    monthSelect.insertAdjacentHTML('beforeend', `
                        <option value="${month.id}">${month.name_bn || month.name}</option>
                    `);
                });
            }
        } catch (error) {
            console.warn('Academic month dynamic list load failed.');
        }
    }



       /* =========================================================
       3. FETCH AND POPULATE CLASS SETUPS DYNAMICALLY
    ========================================================= */
async function loadClassSetupsDropdown() {
    const classSelect = document.getElementById('classSetup');
    if (!classSelect) return;

    try {
        const response = await axios.get('/api/public/class-setups');
        
        if (response.data && response.data.status) {
            const setups = response.data.all_data || response.data.data;
            
            classSelect.innerHTML = '<option value="">শ্রেণী বিন্যাস নির্বাচন করুন</option>';
            setups.forEach(setup => {
                const className = setup.class?.name || '';
                const sectionName = setup.section?.name ? ` - ${setup.section.name}` : '';
                const shiftName = setup.shift?.name ? ` - ${setup.shift.name}` : '';
                
                classSelect.insertAdjacentHTML('beforeend', `
                    <option value="${setup.id}">${className}${sectionName}${shiftName}</option>
                `);
            });
        }
    } catch (error) {
        console.error('Class setups dynamic data load failed:', error);
    }
}



       /* =========================================================
       3. FETCH AND POPULATE GROUP SETUPS DYNAMICALLY
    ========================================================= */
async function loadAcademicGroupsDropdown() {
    const groupSelect = document.getElementById('group');
    if (!groupSelect) return;

    try {
        const response = await axios.get('/api/public/academic-group-lists');
        
        if (response.data && response.data.status) {
            const groups = response.data.data;
            
            // Clear and reset the dropdown
            groupSelect.innerHTML = '<option value="">--বিভাগ সিলেক্ট করুন--</option>';
            
            groups.forEach(group => {
                // Use the exact database name
                const groupName = group.name || "NONE";
                
                groupSelect.insertAdjacentHTML('beforeend', `
                    <option value="${group.id}">${groupName}</option>
                `);
            });
        }
    } catch (error) {
        // Fail-safe handling for network or API errors
        console.warn('Academic groups dynamic data load failed.', error);
    }
}











    /* =========================================================
       LIVE DATE AND TIME (BENGALI FORMAT)
    ========================================================= */
    function updateLiveClock() {
        const now = new Date();
        const options = { 
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true
        };
        const formatter = new Intl.DateTimeFormat('bn-BD', options);
        const clockEl = document.getElementById('liveClock');
        if (clockEl) {
            clockEl.innerHTML = `<i class="fa-regular fa-clock me-1"></i> ${formatter.format(now)}`;
        }
    }
    updateLiveClock();
    setInterval(updateLiveClock, 1000);

    /* =========================================================
       MULTI-STEP FLOW NAVIGATION & VALIDATION (RESTORED)
    ========================================================= */
    const steps = document.querySelectorAll('.form-step');
    const nextButtons = document.querySelectorAll('.btnNextStep');
    const prevButtons = document.querySelectorAll('.btnPrevStep');
    const stepIndicators = document.querySelectorAll('.step');
    const stepProgressLine = document.getElementById('stepProgressLine');

    function updateStepProgress(activeStepIndex) {
        const totalSteps = steps.length;
        const progressPercent = ((activeStepIndex - 1) / (totalSteps - 1)) * 100;
        stepProgressLine.style.width = `${progressPercent}%`;

        stepIndicators.forEach((indicator, index) => {
            const stepNum = index + 1;
            indicator.classList.remove('active', 'completed');
            if (stepNum === activeStepIndex) {
                indicator.classList.add('active');
            } else if (stepNum < activeStepIndex) {
                indicator.classList.add('completed');
            }
        });
    }

    nextButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const currentStepVal = parseInt(this.getAttribute('data-current'));
            const currentStepEl = document.getElementById(`step${currentStepVal}`);

            // Validation only for the current active step fields
            const requiredFields = currentStepEl.querySelectorAll('[required]');
            let isStepValid = true;

            requiredFields.forEach(field => {
                if (!field.checkValidity()) {
                    field.classList.add('is-invalid');
                    isStepValid = false;
                } else {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                }
            });

            if (!isStepValid) {
                currentStepEl.classList.add('was-validated');
                return;
            }

            // Move to next step
            const nextStepVal = currentStepVal + 1;
            const nextStepEl = document.getElementById(`step${nextStepVal}`);

            if (nextStepEl) {
                currentStepEl.classList.remove('active');
                nextStepEl.classList.add('active');
                updateStepProgress(nextStepVal);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });

    prevButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const currentStepVal = parseInt(this.getAttribute('data-current'));
            const prevStepVal = currentStepVal - 1;

            const currentStepEl = document.getElementById(`step${currentStepVal}`);
            const prevStepEl = document.getElementById(`step${prevStepVal}`);

            if (prevStepEl) {
                currentStepEl.classList.remove('active');
                prevStepEl.classList.add('active');
                updateStepProgress(prevStepVal);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });
    // Initialize all dynamic loads synchronously
    loadInstituteInformation();
    loadAcademicSessionsDropdown();
    loadAcademicMonthsDropdown();
    loadClassSetupsDropdown();
    loadAcademicGroupsDropdown();
});


</script>
@endpush