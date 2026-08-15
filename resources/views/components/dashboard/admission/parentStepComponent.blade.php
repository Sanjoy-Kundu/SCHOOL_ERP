<!-- PARENTS & GUARDIANS INFORMATION SECTION -->
<div class="form-section p-4 p-md-5">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-people-roof text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">পিতা-মাতা ও অভিভাবকের তথ্য</h5>
    </div>

    <div class="row g-4">
        <!-- Father -->
        <div class="col-lg-6">
            <div class="sub-card shadow-sm h-100">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 pb-2 border-bottom text-dark" style="font-size: 15px;">
                    <i class="fa-solid fa-person text-success fs-5"></i> পিতার তথ্য
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary required">পিতার নাম <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="father_name" id="fatherName" placeholder="পিতার পূর্ণ নাম লিখুন" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">পেশা</label>
                        <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="father_occupation" id="fatherOccupation" placeholder="পিতার পেশা লিখুন">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold text-secondary required">মোবাইল নম্বর <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="father_phone" id="fatherPhone" placeholder="যেমন: 01XXXXXXXXX" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mother -->
        <div class="col-lg-6">
            <div class="sub-card shadow-sm h-100">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 pb-2 border-bottom text-dark" style="font-size: 15px;">
                    <i class="fa-solid fa-person-dress text-success fs-5"></i> মাতার তথ্য
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary required">মাতার নাম <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="mother_name" id="motherName" placeholder="মাতার পূর্ণ নাম লিখুন" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">পেশা</label>
                        <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="mother_occupation" id="motherOccupation" placeholder="মাতার পেশা লিখুন">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold text-secondary">মোবাইল নম্বর</label>
                        <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="mother_phone" id="motherPhone" placeholder="যেমন: 01XXXXXXXXX">
                    </div>
                </div>
            </div>
        </div>

        <!-- Guardian -->
        <div class="col-12">
            <div class="sub-card shadow-sm">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 pb-2 border-bottom text-dark" style="font-size: 15px;">
                    <i class="fa-solid fa-user-shield text-success fs-5"></i> বিকল্প অভিভাবক (পিতা-মাতার অনুপস্থিতিতে)
                </h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">অভিভাবকের নাম</label>
                        <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="guardian_name" id="guardianName" placeholder="অভিভাবকের পূর্ণ নাম লিখুন">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">সম্পর্ক</label>
                        <select class="form-select form-select-lg shadow-sm" style="font-size: 14.5px;" name="guardian_relation" id="guardianRelation">
                            <option value="">নির্বাচন করুন</option>
                            <option value="uncle">চাচা</option>
                            <option value="maternal_uncle">মামা</option>
                            <option value="grandfather">দাদা / নানা</option>
                            <option value="other">অন্যান্য</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">মোবাইল নম্বর</label>
                        <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="guardian_phone" id="guardianPhone" placeholder="যেমন: 01XXXXXXXXX">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PREVIOUS SCHOOL (CONDITIONAL) -->
<div class="form-section conditional-section p-4 p-md-5 border-top bg-light-subtle" id="previousSchoolSection">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-school text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">পূর্ববর্তী বিদ্যালয়ের তথ্য</h5>
    </div>

    <!-- Alert Box -->
    <div class="info-box success-box mb-4 shadow-sm rounded-3">
        <i class="fa-solid fa-circle-info fs-5 me-2"></i>
        <span>শিক্ষার্থীর পূর্ববর্তী বিদ্যালয়ের সঠিক তথ্য প্রদান করুন।</span>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold text-secondary" id="previousSchoolNameLabel">পূর্ববর্তী বিদ্যালয়ের নাম</label>
            <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="previous_school_name" id="previousSchoolName" placeholder="বিদ্যালয়ের নাম লিখুন">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold text-secondary">পূর্ববর্তী বিদ্যালয়ের EIIN</label>
            <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="previous_school_eiin" placeholder="যেমন: ১২৩৪৫৬">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold text-secondary">পূর্ববর্তী শ্রেণী</label>
            <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="previous_class" placeholder="যেমন: ৫ম বা ৬ষ্ঠ">
        </div>
    </div>
</div>

<!-- TC (CONDITIONAL) -->
<div class="form-section conditional-section p-4 p-md-5 border-top bg-light-subtle" id="tcSection">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-file-circle-check text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">Transfer Certificate (TC) তথ্য</h5>
    </div>

    <!-- TC Content Container -->
    <div class="tc-box shadow-sm rounded-3 p-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary" id="tcNoLabel">TC নম্বর</label>
                <input type="text" class="form-control form-control-lg shadow-sm bg-white" style="font-size: 14.5px;" name="tc_no" id="tcNo" placeholder="টিসি নম্বর লিখুন">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary" id="tcDateLabel">TC তারিখ</label>
                <input type="date" class="form-control form-control-lg shadow-sm bg-white" style="font-size: 14.5px;" name="tc_date" id="tcDate">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary">TC কপি আপলোড</label>
                <input type="file" class="form-control form-control-lg shadow-sm bg-white" style="font-size: 14px;" name="tc_document" id="tcDocument" accept=".pdf,.jpg,.jpeg,.png">
                <div class="small-hint text-muted mt-1" style="font-size: 11px;"><i class="fa-solid fa-circle-info me-1"></i>PDF / JPG / PNG • Max 5MB</div>
            </div>
        </div>
    </div>
</div>

<!-- ADDITIONAL -->
<div class="form-section p-4 p-md-5 border-top">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-circle-info text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">অতিরিক্ত তথ্য</h5>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">জাতীয়তা</label>
            <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="nationality" value="বাংলাদেশী" placeholder="যেমন: বাংলাদেশী">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">ধর্ম</label>
            <select class="form-select form-select-lg shadow-sm" style="font-size: 14.5px;" name="religion" id="religion">
                <option value="">নির্বাচন করুন</option>
                <option value="islam">ইসলাম</option>
                <option value="hinduism">হিন্দু</option>
                <option value="buddhism">বৌদ্ধ</option>
                <option value="christianity">খ্রিস্টান</option>
                <option value="other">অন্যান্য</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold text-secondary">বিশেষ প্রয়োজন / মন্তব্য</label>
            <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="remarks" placeholder="প্রয়োজনে অন্য কোনো তথ্য বা মন্তব্য লিখুন">
        </div>
    </div>
</div>

<!-- FOOTER SECTION -->
<div class="form-footer d-flex justify-content-between align-items-center p-4 bg-light border-top rounded-bottom-4">
    <div>
        <button type="button" class="btn btn-light border px-4 btnPrevStep py-2 shadow-sm d-flex align-items-center gap-2" data-current="3" style="border-radius: 8px; font-weight: 600;">
            <i class="fa-solid fa-arrow-left fs-6"></i> পূর্ববর্তী ধাপ
        </button>
    </div>
    <div>
        <button type="button" class="btn btn-next px-4 btnNextStep py-2 shadow-sm d-flex align-items-center gap-2" data-current="3" style="border-radius: 8px;">
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

    /* Branded Parent/Guardian Container Cards */
    .sub-card { 
        background-color: #ffffff; 
        border: 1px solid var(--brand-border-muted); 
        border-radius: 12px; 
        padding: 24px; 
        height: 100%; 
        transition: all 0.25s ease-in-out;
    }
    
    .sub-card:hover {
        border-color: var(--brand-success-dark);
        box-shadow: 0 4px 15px rgba(0, 106, 78, 0.05) !important;
    }

    /* Smooth CSS Animations for Conditional Elements */
    .conditional-section { 
        display: none !important; 
    }
    
    .conditional-section.show { 
        display: block !important; 
        animation: slideDown 0.35s ease-out forwards;
    }

    /* TC Box Styling */
    .tc-box { 
        background-color: #fffaf0; 
        border: 1px solid #ffe3a3; 
        border-radius: 12px; 
    }

    /* Input Focus Styles override */
    .form-control:focus, .form-select:focus {
        border-color: var(--brand-success-dark) !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 106, 78, 0.15) !important;
    }

    /* Info Warning/Notification Box */
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

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- COMPONENT SPECIFIC JAVASCRIPT (FUNCTIONALITY RETAINED) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const previousSchoolSection = document.getElementById('previousSchoolSection');
    const tcSection = document.getElementById('tcSection');
    const previousSchoolName = document.getElementById('previousSchoolName');
    const tcNo = document.getElementById('tcNo');
    const tcDate = document.getElementById('tcDate');

    // Safe global event listener to communicate across separate blade components
    document.addEventListener('admissionTypeChanged', function (e) {
        const type = e.detail;

        if (type === 'regular') {
            previousSchoolSection.classList.remove('show');
            tcSection.classList.remove('show');
            previousSchoolName.required = false;
            tcNo.required = false;
            tcDate.required = false;
        } else if (type === 'mid_session') {
            previousSchoolSection.classList.add('show');
            tcSection.classList.remove('show');
            previousSchoolName.required = true;
            tcNo.required = false;
            tcDate.required = false;
        } else if (type === 'with_tc') {
            previousSchoolSection.classList.add('show');
            tcSection.classList.add('show');
            previousSchoolName.required = true;
            tcNo.required = true;
            tcDate.required = true;
        }
    });
});
</script>