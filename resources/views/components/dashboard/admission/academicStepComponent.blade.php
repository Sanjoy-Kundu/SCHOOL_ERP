<div class="form-section p-4 p-md-5">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-school text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">ভর্তি ও একাডেমিক তথ্য</h5>
    </div>

    <!-- ONLINE APPLICATION SEARCH / SMART LOAD BAR -->
    <div class="col-12 mb-4">
        <div class="p-3 bg-success-subtle border border-success-subtle rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-cloud-arrow-down text-success fs-4"></i>
                </div>
                <div>
                    <strong class="text-dark d-block" style="font-size: 14px;">অনলাইন ভর্তি আবেদন থেকে তথ্য লোড করুন (ঐচ্ছিক)</strong>
                    <small class="text-muted d-block" style="font-size: 12px;">আবেদনকারীর ইউনিক আইডি দিন এবং তথ্য সরাসরি ফরমে বসিয়ে নিন।</small>
                </div>
            </div>
            <div class="d-flex gap-2 w-100 w-md-auto align-items-center flex-grow-1 flex-md-grow-0 justify-content-md-end">
                <input type="text" id="searchAppId" class="form-control border-success shadow-sm" placeholder="যেমন: APP-2026-1001" style="max-width: 250px; min-height: 40px; font-size: 14px;">
                <button type="button" class="btn btn-success px-3 shadow-sm d-flex align-items-center gap-1" id="btnLoadApplication" style="background-color: #006a4e; border-color: #006a4e; min-height: 40px; font-weight: 600;">
                    <i class="fa-solid fa-magnifying-glass"></i> খুঁজুন ও বসান
                </button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Academic Session -->
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary required">শিক্ষাবর্ষ <span class="text-danger">*</span></label>
            <select class="form-select form-select-lg shadow-sm" style="font-size: 15px;" name="academic_session_id" id="academicSession" required>
            </select>
        </div>

        <!-- Admission Date -->
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary required">ভর্তির তারিখ <span class="text-danger">*</span></label>
            <input type="date" class="form-control form-control-lg shadow-sm" style="font-size: 15px;" id="admissionDate" name="admission_date" value="2026-01-01" required>
        </div>

        <!-- Joining Month -->
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary required">যে মাস থেকে ফি প্রযোজ্য <span class="text-danger">*</span></label>
            <select class="form-select form-select-lg shadow-sm" style="font-size: 15px;" id="joiningMonth" name="joining_month" required>
            </select>
            <div class="small-hint text-muted mt-1" style="font-size: 11px;"><i class="fa-solid fa-circle-info me-1"></i>ভর্তির তারিখ অনুযায়ী মাসটি স্বয়ংক্রিয়ভাবে নির্বাচন হবে।</div>
        </div>

        <!-- Admission Type Choices -->
        <div class="col-12">
            <label class="form-label fw-semibold text-secondary required mb-3">ভর্তির ধরন <span class="text-danger">*</span></label>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="admission-type-card active h-100" data-type="regular">
                        <div class="d-flex gap-3 align-items-start">
                            <input type="radio" class="form-check-input admissionType mt-1" name="admission_type" value="regular" checked>
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="icon-box"><i class="fa-solid fa-user-plus"></i></div>
                                    <strong class="text-dark">নিয়মিত ভর্তি</strong>
                                </div>
                                <small>শিক্ষাবর্ষের শুরুতে সাধারণ ভর্তি।</small>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="col-md-4">
                    <label class="admission-type-card h-100" data-type="mid_session">
                        <div class="d-flex gap-3 align-items-start">
                            <input type="radio" class="form-check-input admissionType mt-1" name="admission_type" value="mid_session">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="icon-box"><i class="fa-solid fa-calendar-plus"></i></div>
                                    <strong class="text-dark">মধ্য-সেশন ভর্তি</strong>
                                </div>
                                <small>শিক্ষাবর্ষ চলাকালীন নতুন ভর্তি।</small>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="col-md-4">
                    <label class="admission-type-card h-100" data-type="with_tc">
                        <div class="d-flex gap-3 align-items-start">
                            <input type="radio" class="form-check-input admissionType mt-1" name="admission_type" value="with_tc">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="icon-box"><i class="fa-solid fa-file-arrow-right"></i></div>
                                    <strong class="text-dark">TC সহ ভর্তি</strong>
                                </div>
                                <small>অন্য বিদ্যালয় থেকে TC নিয়ে ভর্তি।</small>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Type Info Box -->
        <div class="col-12">
            <div id="admissionTypeInfo" class="info-box success-box shadow-sm rounded-3"></div>
        </div>

        <!-- Class Setup -->
        <div class="col-md-6">
            <label class="form-label fw-semibold text-secondary required">শ্রেণী বিন্যাস <span class="text-danger">*</span></label>
            <select class="form-select form-select-lg shadow-sm" style="font-size: 15px; color:black" name="class_setup_id" id="classSetup" required>
                <option value="">শ্রেণী বিন্যাস নির্বাচন করুন</option>
            </select>
            <div class="small-hint text-muted mt-1" style="font-size: 11px;"><i class="fa-solid fa-circle-info me-1"></i>Class Setup অনুযায়ী শ্রেণী, শাখা ও শিফট নির্ধারিত হবে।</div>
        </div>

        <!-- Group -->
        <div class="col-md-3" id="groupWrapper">
            <label class="form-label fw-semibold text-secondary">বিভাগ / গ্রুপ</label>
            <select class="form-select form-select-lg shadow-sm" style="font-size: 15px;" name="group_id" id="group">
                <option value="">প্রযোজ্য নয়</option>
               
            </select>
        </div>

        <!-- Roll No -->
        <div class="col-md-3">
            <label class="form-label fw-semibold text-secondary">রোল নম্বর</label>
            <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 15px;" name="roll_no" placeholder="প্রয়োজনে রোল নম্বর লিখুন">
        </div>
    </div>
</div>

<!-- FOOTER SECTION -->
<div class="form-footer d-flex justify-content-between align-items-center p-4 bg-light border-top rounded-bottom-4">
    <div class="small text-muted"><span class="text-danger">*</span> চিহ্নিত তথ্যগুলো আবশ্যক।</div>
    <div>
        <button type="button" class="btn btn-next px-4 btnNextStep py-2 shadow-sm d-flex align-items-center gap-2" data-current="1" style="border-radius: 8px;">
            সংরক্ষণ ও পরবর্তী ধাপ <i class="fa-solid fa-arrow-right fs-6"></i>
        </button>
    </div>
</div>

<!-- COMPONENT SPECIFIC CSS -->
<style>
    :root {
        --brand-success-light: #e9f7ef;
        --brand-success-dark: #006a4e;
        --brand-border-muted: #dee2e6;
    }

    /* Modern Styled Checkbox Cards */
    .admission-type-card {
        display: block; 
        border: 1px solid var(--brand-border-muted); 
        border-radius: 12px; 
        padding: 18px; 
        cursor: pointer; 
        transition: all 0.25s ease-in-out;
        background-color: #ffffff;
    }
    
    .admission-type-card:hover { 
        border-color: var(--brand-success-dark); 
        background-color: #f6fdfa; 
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 106, 78, 0.05);
    }
    
    .admission-type-card.active { 
        border-color: var(--brand-success-dark); 
        background-color: var(--brand-success-light); 
        box-shadow: 0 0 0 1px var(--brand-success-dark); 
    }
    
    .admission-type-card .icon-box {
        width: 32px; 
        height: 32px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 8px; 
        background-color: var(--brand-success-light); 
        color: var(--brand-success-dark); 
        flex-shrink: 0;
        font-size: 14px;
    }
    
    .admission-type-card strong { 
        font-size: 14px; 
        font-weight: 700;
    }
    
    .admission-type-card small { 
        display: block; 
        color: #6c757d; 
        margin-top: 5px; 
        line-height: 1.5; 
        font-size: 11.5px;
    }

    /* Notification and Alert Boxes */
    .info-box { 
        background-color: #f8f9fa; 
        border: 1px solid #e9ecef; 
        border-radius: 10px; 
        padding: 14px 18px; 
        font-size: 13.5px; 
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .success-box { 
        background-color: var(--brand-success-light); 
        border-color: #c9eedb; 
        color: var(--brand-success-dark); 
    }
    
    .warning-box { 
        background-color: #fffaf0; 
        border-color: #ffe3a3; 
        color: #856404;
    }

    /* Smooth Input Border Hover Transitions */
    .form-control:focus, .form-select:focus {
        border-color: var(--brand-success-dark) !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 106, 78, 0.15) !important;
    }
</style>

<!-- COMPONENT SPECIFIC JAVASCRIPT (FUNCTIONALITY RETAINED) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const admissionDate = document.getElementById('admissionDate');
    const joiningMonth = document.getElementById('joiningMonth');
    const feeJoiningMonthText = document.getElementById('feeJoiningMonthText');
    const monthlyFeeLabel = document.getElementById('monthlyFeeLabel');
    const classSetup = document.getElementById('classSetup');
    const groupWrapper = document.getElementById('groupWrapper');
    const admissionTypeInfo = document.getElementById('admissionTypeInfo');
    const admissionTypes = document.querySelectorAll('.admissionType');
    const admissionCards = document.querySelectorAll('.admission-type-card');

    const monthNames = {
        1: 'জানুয়ারি', 2: 'ফেব্রুয়ারি', 3: 'মার্চ', 4: 'এপ্রিল', 5: 'মে', 6: 'জুন',
        7: 'জুলাই', 8: 'আগস্ট', 9: 'সেপ্টেম্বর', 10: 'অক্টোবর', 11: 'নভেম্বর', 12: 'ডিসেম্বর'
    };

    /* =========================================================
       ADMISSION TYPE SELECTION (TRIGGERS EVENT FOR CONDITIONAL SECTIONS IN STEP 3)
    ========================================================= */
    function updateAdmissionType() {
        const selected = document.querySelector('input[name="admission_type"]:checked');
        if (!selected) return;

        const type = selected.value;

        admissionCards.forEach(card => card.classList.remove('active'));
        const selectedCard = selected.closest('.admission-type-card');
        if (selectedCard) selectedCard.classList.add('active');

        // Dispatch custom global event so other components (Step 3) can toggle visibility safely
        document.dispatchEvent(new CustomEvent('admissionTypeChanged', { detail: type }));

        if (type === 'regular') {
            admissionTypeInfo.className = 'info-box success-box shadow-sm';
            admissionTypeInfo.innerHTML = `<i class="fa-solid fa-circle-info fs-5 me-1"></i><span><strong>নিয়মিত ভর্তি:</strong> শিক্ষাবর্ষের শুরুতে সাধারণ ভর্তি হিসেবে শিক্ষার্থী নিবন্ধিত হবে।</span>`;
        } else if (type === 'mid_session') {
            admissionTypeInfo.className = 'info-box warning-box shadow-sm';
            admissionTypeInfo.innerHTML = `<i class="fa-solid fa-circle-info fs-5 me-1"></i><span><strong>মধ্য-সেশন ভর্তি:</strong> শিক্ষাবর্ষ চলাকালীন নতুন শিক্ষার্থী ভর্তি হবে। পূর্ববর্তী বিদ্যালয়ের তথ্য আবশ্যক, তবে TC বাধ্যতামূলক নয়।</span>`;
        } else if (type === 'with_tc') {
            admissionTypeInfo.className = 'info-box warning-box shadow-sm';
            admissionTypeInfo.innerHTML = `<i class="fa-solid fa-file-circle-check fs-5 me-1"></i><span><strong>TC সহ ভর্তি:</strong> অন্য বিদ্যালয় থেকে TC নিয়ে আসা শিক্ষার্থীর পূর্ববর্তী বিদ্যালয় এবং TC সংক্রান্ত তথ্য প্রদান করুন।</span>`;
        }
    }

    admissionTypes.forEach(radio => radio.addEventListener('change', updateAdmissionType));
    updateAdmissionType(); // Init

    /* =========================================================
       DATE TO JOINING MONTH AUTO-FILL
    ========================================================= */
    function updateJoiningMonth() {
        if (!admissionDate.value) return;
        const date = new Date(admissionDate.value + 'T00:00:00');
        const month = date.getMonth() + 1;
        const year = date.getFullYear();

        joiningMonth.value = String(month);
        updateFeeMonthText(month, year);
    }

    function updateFeeMonthText(month, year) {
        if (!month) return;
        if (feeJoiningMonthText) feeJoiningMonthText.textContent = `${monthNames[month]} ${year || ''} থেকে`;
        if (monthlyFeeLabel) monthlyFeeLabel.textContent = `মাসিক বেতন - ${monthNames[month]}`;
    }

    admissionDate.addEventListener('change', updateJoiningMonth);
    joiningMonth.addEventListener('change', function () {
        const month = parseInt(this.value);
        if (!month) return;
        let year = '';
        if (admissionDate.value) {
            year = new Date(admissionDate.value + 'T00:00:00').getFullYear();
        }
        updateFeeMonthText(month, year);
    });
    updateJoiningMonth(); // Init

    /* =========================================================
       CLASS CONFIG TO GROUP TOGGLER
    ========================================================= */
    classSetup.addEventListener('change', function () {
        const value = parseInt(this.value);
        if (value === 5 || value === 6) {
            groupWrapper.style.display = 'block';
        } else {
            groupWrapper.style.display = 'none';
            const groupSelect = document.getElementById('group');
            if (groupSelect) groupSelect.value = '';
        }
    });

    /* =========================================================
       API SEARCH AND AUTO-FILL ADMISSION FORM
    ========================================================= */
    document.getElementById('btnLoadApplication').addEventListener('click', function () {
        const inputId = document.getElementById('searchAppId').value.trim();
        if (!inputId) {
            alert('দয়া করে একটি সঠিক অনলাইন আবেদন আইডি লিখুন!');
            return;
        }

        let appData = localStorage.getItem(inputId);

        // Demo fallback values for testing offline
        if (!appData && inputId === 'APP-2026-1001') {
            appData = JSON.stringify({
                app_id: "APP-2026-1001", session: "২০২৬", class: "৬ষ্ঠ শ্রেণী",
                name_bn: "তানভীর রহমান রায়হান", name_en: "Tanveer Rahman Rayhan",
                birth_cert: "20121516518191024", dob: "2012-05-15", gender: "male",
                student_phone: "01712345678", blood: "A+",
                present_addr: "বাড়ি #২৫, ফ্ল্যাট বি-৩, ধানমণ্ডি, ঢাকা",
                perm_addr: "গ্রাম: চাঁদপুর, ডাকঘর: চাঁদপুর সদর, জেলা: চাঁদপুর",
                father_name: "মোঃ আনিসুর রহমান", father_occ: "ব্যবসায়ী", father_phone: "01812345678",
                mother_name: "সামিয়া বেগম", mother_occ: "গৃহিণী", mother_phone: "01912345678"
            });
        }

        if (appData) {
            const data = JSON.parse(appData);

            document.getElementById('academicSession').value = "1";
            
            if (data.class.includes("৬ষ্ঠ")) {
                document.getElementById('classSetup').value = "1";
            } else if (data.class.includes("৭ম")) {
                document.getElementById('classSetup').value = "3";
            } else if (data.class.includes("৮ম")) {
                document.getElementById('classSetup').value = "4";
            } else if (data.class.includes("৯ম")) {
                document.getElementById('classSetup').value = "5";
                groupWrapper.style.display = 'block';
            }

            // Fill elements of Step 2 (Since DOM is preloaded, we can set values globally across other steps!)
            if(document.getElementById('nameBn')) document.getElementById('nameBn').value = data.name_bn;
            if(document.getElementById('nameEn')) document.getElementById('nameEn').value = data.name_en;
            if(document.getElementById('birthCertificateNo')) document.getElementById('birthCertificateNo').value = data.birth_cert;
            if(document.getElementById('dateOfBirth')) document.getElementById('dateOfBirth').value = data.dob;
            if(document.getElementById('gender')) document.getElementById('gender').value = data.gender;
            if(document.getElementById('bloodGroup')) document.getElementById('bloodGroup').value = data.blood || "";
            if(document.getElementById('phone')) document.getElementById('phone').value = data.student_phone || "";
            if(document.getElementById('presentAddress')) document.getElementById('presentAddress').value = data.present_addr;
            if(document.getElementById('permanentAddress')) document.getElementById('permanentAddress').value = data.perm_addr || "";

            // Fill elements of Step 3
            if(document.getElementById('fatherName')) document.getElementById('fatherName').value = data.father_name;
            if(document.getElementById('fatherOccupation')) document.getElementById('fatherOccupation').value = data.father_occ || "";
            if(document.getElementById('fatherPhone')) document.getElementById('fatherPhone').value = data.father_phone;
            if(document.getElementById('motherName')) document.getElementById('motherName').value = data.mother_name;
            if(document.getElementById('motherOccupation')) document.getElementById('motherOccupation').value = data.mother_occ || "";
            if(document.getElementById('motherPhone')) document.getElementById('motherPhone').value = data.mother_phone || "";

            alert(`সফল হয়েছে! আবেদন আইডি: ${data.app_id}-এর ডাটা সফলভাবে লোড করা হয়েছে। অনুগ্রহ করে পরবর্তী ধাপগুলো চেক করুন।`);
        } else {
            alert('দুঃখিত! এই আবেদন আইডিটি খুঁজে পাওয়া যায়নি। আপনি কি "APP-2026-1001" টাইপ করেছেন?');
        }
    });
});
</script>