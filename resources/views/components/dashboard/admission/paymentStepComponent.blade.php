<!-- FEE SECTIONS -->
<div class="form-section p-4 p-md-5">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-money-bill-wave text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">ভর্তি ও প্রযোজ্য ফি</h5>
    </div>

    <!-- Info Warning Box -->
    <div class="info-box mb-4 shadow-sm rounded-3">
        <i class="fa-solid fa-circle-info fs-5 me-2"></i>
        <span>এটি Demo fee calculation। Laravel-এ পরে <strong>Class Setup + Session + Joining Month + Fee Structure</strong> অনুযায়ী Backend থেকে dynamic হবে।</span>
    </div>

    <!-- Fee Table Area -->
    <div class="fee-preview shadow-sm rounded-3 border">
        <div class="fee-preview-header d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
            <span class="fw-bold text-secondary">প্রযোজ্য ফি</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold" id="feeJoiningMonthText">জানুয়ারি ২০২৬ থেকে</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ফি বিবরণী</th>
                        <th class="text-end pe-4" width="200">পরিমাণ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 text-dark fw-medium">ভর্তি ফি</td>
                        <td class="text-end pe-4 fw-bold text-dark">৳ <span id="admissionFee">1000.00</span></td>
                    </tr>
                    <tr>
                        <td class="ps-4 text-dark fw-medium" id="monthlyFeeLabel">মাসিক বেতন - জানুয়ারি</td>
                        <td class="text-end pe-4 fw-bold text-dark">৳ <span id="monthlyFee">500.00</span></td>
                    </tr>
                    <tr>
                        <td class="ps-4 text-dark fw-medium">সেশন চার্জ</td>
                        <td class="text-end pe-4 fw-bold text-dark">৳ <span id="sessionFee">1500.00</span></td>
                    </tr>
                    <tr>
                        <td class="ps-4 text-dark fw-medium">অন্যান্য</td>
                        <td class="text-end pe-4 fw-bold text-dark">৳ <span id="otherFee">50.00</span></td>
                    </tr>
                    <tr class="table-success-subtle fw-bold" style="background-color: var(--brand-success-light);">
                        <td class="ps-4" style="color: var(--brand-success-dark);">মোট</td>
                        <td class="text-end pe-4" style="color: var(--brand-success-dark); font-size: 1.1rem;">৳ <span id="grandTotalSmall">3050.00</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PAYMENT METHOD CHOICE -->
<div class="form-section p-4 p-md-5 border-top">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-credit-card text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">পেমেন্ট তথ্য</h5>
    </div>

    <div class="row g-4">
        <div class="col-12 mb-1">
            <label class="form-label fw-bold text-dark" style="font-size: 15px;">পেমেন্ট পদ্ধতি নির্বাচন করুন <span class="text-danger">*</span></label>
        </div>

        <!-- Cash -->
        <div class="col-md-6 col-lg-3">
            <label class="payment-method active shadow-sm h-100" data-payment="cash">
                <div class="d-flex align-items-center gap-3">
                    <input type="radio" class="form-check-input paymentMethod mt-0" name="payment_method" value="cash" checked style="width: 18px; height: 18px;">
                    <div class="payment-icon"><i class="fa-solid fa-money-bill fs-5"></i></div>
                    <div>
                        <strong class="d-block text-dark">Cash</strong>
                        <small class="text-muted" style="font-size: 11px;">নগদ গ্রহণ</small>
                    </div>
                </div>
            </label>
        </div>

        <!-- Bank -->
        <div class="col-md-6 col-lg-3">
            <label class="payment-method shadow-sm h-100" data-payment="bank">
                <div class="d-flex align-items-center gap-3">
                    <input type="radio" class="form-check-input paymentMethod mt-0" name="payment_method" value="bank" style="width: 18px; height: 18px;">
                    <div class="payment-icon"><i class="fa-solid fa-building-columns fs-5"></i></div>
                    <div>
                        <strong class="d-block text-dark">Bank</strong>
                        <small class="text-muted" style="font-size: 11px;">ব্যাংক ডিপোজিট</small>
                    </div>
                </div>
            </label>
        </div>

        <!-- bKash -->
        <div class="col-md-6 col-lg-3">
            <label class="payment-method shadow-sm h-100" data-payment="bkash">
                <div class="d-flex align-items-center gap-3">
                    <input type="radio" class="form-check-input paymentMethod mt-0" name="payment_method" value="bkash" style="width: 18px; height: 18px;">
                    <div class="payment-icon" style="background-color: #e2136e20; color: #e2136e;"><i class="fa-solid fa-mobile-screen-button fs-5"></i></div>
                    <div>
                        <strong class="d-block text-dark">bKash</strong>
                        <small class="text-muted" style="font-size: 11px;">মোবাইল ব্যাংকিং</small>
                    </div>
                </div>
            </label>
        </div>

        <!-- Online Gateway -->
        <div class="col-md-6 col-lg-3">
            <label class="payment-method shadow-sm h-100" data-payment="online">
                <div class="d-flex align-items-center gap-3">
                    <input type="radio" class="form-check-input paymentMethod mt-0" name="payment_method" value="online" style="width: 18px; height: 18px;">
                    <div class="payment-icon"><i class="fa-solid fa-globe fs-5"></i></div>
                    <div>
                        <strong class="d-block text-dark">Online Payment</strong>
                        <small class="text-muted" style="font-size: 11px;">Digital Gateway</small>
                    </div>
                </div>
            </label>
        </div>

        <!-- Dynamic Reference Extra Blocks -->
        <div class="col-12">
            <div class="payment-extra show" id="cashExtra">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Cash Reference / Note</label>
                    <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="cash_reference" placeholder="প্রয়োজনে রেফারেন্স বা মন্তব্য লিখুন">
                </div>
            </div>

            <div class="payment-extra" id="bankExtra">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Bank Transaction / Reference</label>
                    <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="bank_reference" placeholder="ব্যাংক ট্রানজেকশন ID লিখুন">
                </div>
            </div>

            <div class="payment-extra" id="bkashExtra">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">bKash Transaction ID</label>
                    <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 14.5px;" name="bkash_transaction_id" placeholder="যেমন: 8A7B6C5D">
                </div>
            </div>

            <div class="payment-extra" id="onlineExtra">
                <div class="info-box success-box shadow-sm rounded-3">
                    <i class="fa-solid fa-shield-halved fs-5 me-2"></i>
                    <span>Online Payment নির্বাচন করলে Admission Submit করার পর Payment Gateway-এ রিডাইরেক্ট করা হবে।</span>
                </div>
            </div>
        </div>

        <!-- Total Box -->
        <div class="col-12 mt-4">
            <div class="grand-total-box shadow-sm rounded-3 p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="grand-total-label mb-1 fw-bold">মোট পরিশোধযোগ্য পরিমাণ</h6>
                        <span class="text-muted small">ভর্তি ফি + নির্ধারিত অন্যান্য চার্জসমূহ</span>
                    </div>
                    <div class="grand-total">৳ <span id="grandTotal">3,050.00</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AGREEMENT CHECKBOX -->
<div class="form-section p-4 p-md-5 border-top bg-light-subtle">
    <div class="p-3 bg-white rounded-3 border shadow-sm">
        <div class="d-flex gap-3 align-items-start">
            <input class="form-check-input ms-0 mt-1" type="checkbox" id="acceptTerms" required style="width: 22px; height: 22px; flex-shrink: 0; cursor: pointer;">
            <label class="form-check-label required fw-bold text-dark mt-1" for="acceptTerms" style="font-size: 14px; cursor: pointer; user-select: none; line-height: 1.5;">
                আমি এই মর্মে অঙ্গীকার করছি যে, উপরে প্রদত্ত সকল তথ্য সত্য ও নির্ভুল। যেকোনো ভুল তথ্যের জন্য আমার ভর্তি আবেদন বাতিল বলে গণ্য হবে।
            </label>
        </div>
    </div>
</div>

<!-- BUTTON ACTIONS -->
<div class="form-footer d-flex justify-content-between align-items-center flex-wrap gap-3 p-4 bg-light border-top rounded-bottom-4">
    <div>
        <button type="button" class="btn btn-light border px-4 btnPrevStep py-2 shadow-sm d-flex align-items-center gap-2" data-current="4" style="border-radius: 8px; font-weight: 600;">
            <i class="fa-solid fa-arrow-left fs-6"></i> পূর্ববর্তী ধাপ
        </button>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <button type="reset" class="btn btn-light border px-4 py-2 shadow-sm d-flex align-items-center gap-2" style="border-radius: 8px; font-weight: 600;">
            <i class="fa-solid fa-rotate-left fs-6"></i> রিসেট
        </button>
        <button type="button" class="btn btn-warning text-dark fw-bold px-4 py-2 shadow-sm d-flex align-items-center gap-2" id="btnPreviewForm" style="border-radius: 8px;">
            <i class="fa-solid fa-magnifying-glass fs-6"></i> তথ্য যাচাই করুন
        </button>
        <button type="submit" class="btn btn-submit px-5 py-2 shadow-sm d-flex align-items-center gap-2" id="btnSubmitForm" disabled style="background-color: var(--brand-primary); border-color: var(--brand-primary); border-radius: 8px;">
            <i class="fa-solid fa-user-plus fs-6"></i> <span id="submitText">শিক্ষার্থী ভর্তি করুন</span>
        </button>
    </div>
</div>

<!-- PREVIEW MODAL -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header text-white" style="background-color: var(--brand-primary); border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title fw-bold" id="previewModalLabel"><i class="fa-solid fa-list-check me-2"></i>ভর্তি আবেদন তথ্য যাচাই</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 p-md-5" id="previewModalBody">
                <!-- Dynamic Content Will Be Injected Here -->
            </div>
            <div class="modal-footer bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-3" data-bs-dismiss="modal">বন্ধ করুন</button>
                <button type="button" class="btn btn-success px-4 py-2 rounded-3" style="background-color: var(--brand-success-dark); border-color: var(--brand-success-dark);" onclick="document.getElementById('previewModal').querySelector('[data-bs-dismiss=modal]').click();">সম্পূর্ণ ঠিক আছে</button>
            </div>
        </div>
    </div>
</div>

<!-- SUCCESS MODAL -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body text-center p-5">
                <div class="text-success mb-4">
                    <i class="fa-solid fa-circle-check" style="font-size: 64px;"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">ভর্তি আবেদন সফল হয়েছে!</h4>
                <p class="text-muted mb-4">শিক্ষার্থীর ভর্তির আবেদনটি সফলভাবে সিস্টেমে সংরক্ষিত হয়েছে। অনুমোদন ও পরবর্তী ধাপ সম্পন্ন করতে পেমেন্ট তথ্য যাচাই করা হবে।</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-success px-4 py-2" id="btnReload" data-bs-dismiss="modal" style="background-color: var(--brand-success-dark); border-color: var(--brand-success-dark); border-radius: 8px;">নতুন আবেদন করুন</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- COMPONENT SPECIFIC CSS -->
<style>
    :root {
        --brand-success-light: #e9f7ef;
        --brand-success-dark: #006a4e;
        --brand-border-muted: #dee2e6;
    }

    /* Info Notification Boxes */
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

    /* Table Preview Settings */
    .fee-preview { 
        overflow: hidden; 
    }
    
    .fee-preview table th {
        font-size: 13.5px;
        color: #6c757d;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .fee-preview table td { 
        font-size: 14px; 
        padding-top: 12px;
        padding-bottom: 12px;
    }

    /* Branded Styled Radio Choices */
    .payment-method { 
        border: 1px solid var(--brand-border-muted); 
        border-radius: 12px; 
        padding: 18px; 
        cursor: pointer; 
        display: block;
        transition: all 0.25s ease-in-out; 
        background-color: #ffffff;
    }
    
    .payment-method:hover { 
        border-color: var(--brand-success-dark); 
        background-color: #f6fdfa; 
        transform: translateY(-2px);
    }
    
    .payment-method.active { 
        border-color: var(--brand-success-dark); 
        background-color: var(--brand-success-light); 
        box-shadow: 0 0 0 1px var(--brand-success-dark); 
    }
    
    .payment-icon { 
        width: 40px; 
        height: 40px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 10px; 
        background-color: var(--brand-success-light); 
        color: var(--brand-success-dark); 
        flex-shrink: 0;
    }
    
    .payment-method strong { 
        font-size: 14px; 
        font-weight: 700;
    }

    /* Extra Dynamic Container Transitions */
    .payment-extra { 
        display: none; 
        margin-top: 20px;
    }
    
    .payment-extra.show { 
        display: block; 
        animation: fadeIn 0.3s ease;
    }

    /* Premium Grand Total Frame */
    .grand-total-box { 
        background-color: var(--brand-success-light); 
        border: 1px solid #c9eedb; 
    }
    
    .grand-total-label { 
        color: var(--brand-success-dark); 
        font-size: 15px; 
    }
    
    .grand-total { 
        color: var(--brand-success-dark); 
        font-size: 28px; 
        font-weight: 800; 
    }

    /* Modal Styling Fixes */
    .modal-body table td {
        font-size: 14px;
        padding: 10px 14px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- COMPONENT SPECIFIC JAVASCRIPT (FUNCTIONALITY RETAINED & BUGS FIXED) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const acceptTerms = document.getElementById('acceptTerms');
    const btnSubmitForm = document.getElementById('btnSubmitForm');
    const btnPreviewForm = document.getElementById('btnPreviewForm');
    const previewModalBody = document.getElementById('previewModalBody');
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    const admissionForm = document.getElementById('admissionForm');

    const paymentMethods = document.querySelectorAll('.paymentMethod');
    const paymentCards = document.querySelectorAll('.payment-method');
    const paymentExtras = {
        cash: document.getElementById('cashExtra'),
        bank: document.getElementById('bankExtra'),
        bkash: document.getElementById('bkashExtra'),
        online: document.getElementById('onlineExtra')
    };

    /* =========================================================
       T&C TRIGGER FOR SUBMIT BUTTON
    ========================================================= */
    acceptTerms.addEventListener('change', function () {
        btnSubmitForm.disabled = !this.checked;
    });

    /* =========================================================
       PAYMENT BLOCKS CONTROLLER
    ========================================================= */
    function updatePaymentMethod() {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        if (!selected) return;

        const method = selected.value;

        paymentCards.forEach(card => card.classList.remove('active'));
        const selectedCard = selected.closest('.payment-method');
        if (selectedCard) selectedCard.classList.add('active');

        Object.values(paymentExtras).forEach(element => {
            if (element) element.classList.remove('show');
        });
        if (paymentExtras[method]) paymentExtras[method].classList.add('show');

        const submitText = document.getElementById('submitText');
        if (submitText) {
            if (method === 'online') {
                submitText.textContent = 'ভর্তি + পেমেন্ট করুন';
            } else {
                submitText.textContent = 'শিক্ষার্থী ভর্তি করুন';
            }
        }
    }

    paymentMethods.forEach(radio => radio.addEventListener('change', updatePaymentMethod));
    updatePaymentMethod(); // Init

    /* =========================================================
       REAL-TIME DATA PREVIEW GENERATOR
    ========================================================= */
    btnPreviewForm.addEventListener('click', function () {
        // Fetch values across dynamically loaded steps seamlessly
        const academicSessionText = document.getElementById('academicSession')?.options[document.getElementById('academicSession').selectedIndex]?.text || 'N/A';
        const admissionDateText = document.getElementById('admissionDate')?.value || 'N/A';
        const joiningMonthText = document.getElementById('joiningMonth')?.options[document.getElementById('joiningMonth').selectedIndex]?.text || 'N/A';
        
        const selectedAdmType = document.querySelector('input[name="admission_type"]:checked');
        let admissionTypeText = 'N/A';
        if (selectedAdmType) {
            const labelCard = selectedAdmType.closest('.admission-type-card');
            if (labelCard) admissionTypeText = labelCard.querySelector('strong').textContent.trim();
        }
        
        const classSetupText = document.getElementById('classSetup')?.options[document.getElementById('classSetup').selectedIndex]?.text || 'N/A';
        
        const groupEl = document.getElementById('group');
        let groupText = 'প্রযোজ্য নয়';
        const groupWrapper = document.getElementById('groupWrapper');
        if (groupWrapper && groupWrapper.style.display !== 'none' && groupEl) {
            groupText = groupEl.options[groupEl.selectedIndex]?.text || 'নির্বাচন করা হয়নি';
        }
        
        const rollNoVal = document.querySelector('input[name="roll_no"]')?.value || 'প্রদান করা হয়নি';

        // Student Info
        const nameBnVal = document.getElementById('nameBn')?.value || 'N/A';
        const nameEnVal = document.getElementById('nameEn')?.value || 'N/A';
        const birthCertNoVal = document.getElementById('birthCertificateNo')?.value || 'প্রদান করা হয়নি';
        const dobVal = document.getElementById('dateOfBirth')?.value || 'N/A';
        
        const genderSelect = document.getElementById('gender');
        const genderText = genderSelect ? (genderSelect.options[genderSelect.selectedIndex]?.text || 'N/A') : 'N/A';
        
        const bloodSelect = document.getElementById('bloodGroup');
        const bloodGroupText = bloodSelect ? (bloodSelect.options[bloodSelect.selectedIndex]?.text || 'প্রদান করা হয়নি') : 'N/A';
        
        const studentPhoneVal = document.getElementById('phone')?.value || 'প্রদান করা হয়নি';
        const studentEmailVal = document.getElementById('email')?.value || 'প্রদান করা হয়নি';
        const presentAddrVal = document.getElementById('presentAddress')?.value || 'N/A';
        const permanentAddrVal = document.getElementById('permanentAddress')?.value || 'প্রদান করা হয়নি';

        // Parents Info
        const fatherNameVal = document.getElementById('fatherName')?.value || 'N/A';
        const fatherOccVal = document.getElementById('fatherOccupation')?.value || 'প্রদান করা হয়নি';
        const fatherPhoneVal = document.getElementById('fatherPhone')?.value || 'N/A';
        const motherNameVal = document.getElementById('motherName')?.value || 'N/A';
        const motherOccVal = document.getElementById('motherOccupation')?.value || 'প্রদান করা হয়নি';
        const motherPhoneVal = document.getElementById('motherPhone')?.value || 'প্রদান করা হয়নি';
        
        const guardianNameVal = document.getElementById('guardianName')?.value || 'প্রদান করা হয়নি';
        const guardianRelSelect = document.getElementById('guardianRelation');
        const guardianRelText = guardianRelSelect ? (guardianRelSelect.options[guardianRelSelect.selectedIndex]?.text || 'N/A') : 'N/A';
        const guardianPhoneVal = document.getElementById('guardianPhone')?.value || 'প্রদান করা হয়নি';

        // Additional Info
        const nationalityVal = document.querySelector('input[name="nationality"]')?.value || 'বাংলাদেশী';
        const religionSelect = document.getElementById('religion');
        const religionText = religionSelect ? (religionSelect.options[religionSelect.selectedIndex]?.text || 'প্রদান করা হয়নি') : 'N/A';
        const remarksVal = document.querySelector('input[name="remarks"]')?.value || 'কোনো মন্তব্য নেই';

        // Payment Info
        const grandTotalVal = document.getElementById('grandTotal')?.textContent || '0.00';
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');

        let studentPhotoHTML = '';
        const photoInput = document.getElementById('studentPhoto');
        if (photoInput && photoInput.files && photoInput.files[0]) {
            studentPhotoHTML = `<img src="${URL.createObjectURL(photoInput.files[0])}" class="img-thumbnail shadow-sm" style="width: 110px; height: 135px; object-fit: cover; border: 2px solid #006a4e;">`;
        } else {
            studentPhotoHTML = `<div class="d-flex align-items-center justify-content-center bg-light text-muted border rounded shadow-sm" style="width: 110px; height: 135px; font-size: 11px;">ছবি দেওয়া হয়নি</div>`;
        }

        let previewHTML = `
            <div class="row g-4 mb-4">
                <div class="col-sm-9">
                    <h6 class="fw-bold pb-1 border-bottom" style="color: #006a4e;"><i class="fa-solid fa-school me-2"></i>১. ভর্তি ও একাডেমিক তথ্য</h6>
                    <table class="table table-sm table-bordered mt-2">
                        <tr><td width="35%" class="bg-light fw-semibold">শিক্ষাবর্ষ</td><td>${academicSessionText}</td></tr>
                        <tr><td class="bg-light fw-semibold">ভর্তির তারিখ</td><td>${admissionDateText}</td></tr>
                        <tr><td class="bg-light fw-semibold">যে মাস থেকে ফি প্রযোজ্য</td><td>${joiningMonthText}</td></tr>
                        <tr><td class="bg-light fw-semibold">ভর্তির ধরন</td><td>${admissionTypeText}</td></tr>
                        <tr><td class="bg-light fw-semibold">শ্রেণী বিন্যাস</td><td>${classSetupText}</td></tr>
                        <tr><td class="bg-light fw-semibold">বিভাগ / গ্রুপ</td><td>${groupText}</td></tr>
                        <tr><td class="bg-light fw-semibold">রোল নম্বর</td><td>${rollNoVal}</td></tr>
                    </table>
                </div>
                <div class="col-sm-3 text-center d-flex flex-column align-items-center justify-content-start">
                    <span class="d-block fw-bold mb-2 text-secondary" style="font-size:14px;">শিক্ষার্থীর ছবি</span>
                    ${studentPhotoHTML}
                </div>
            </div>

            <h6 class="fw-bold pb-1 border-bottom" style="color: #006a4e;"><i class="fa-solid fa-user-graduate me-2"></i>২. শিক্ষার্থীর ব্যক্তিগত তথ্য</h6>
            <table class="table table-sm table-bordered mb-4 mt-2">
                <tr><td width="25%" class="bg-light fw-semibold">নাম (বাংলা)</td><td width="25%">${nameBnVal}</td><td width="25%" class="bg-light fw-semibold">নাম (English)</td><td width="25%">${nameEnVal}</td></tr>
                <tr><td class="bg-light fw-semibold">জন্ম নিবন্ধন নম্বর</td><td>${birthCertNoVal}</td><td class="bg-light fw-semibold">জন্ম তারিখ</td><td>${dobVal}</td></tr>
                <tr><td class="bg-light fw-semibold">লিঙ্গ</td><td>${genderText}</td><td class="bg-light fw-semibold">রক্তের গ্রুপ</td><td>${bloodGroupText}</td></tr>
                <tr><td class="bg-light fw-semibold">মোবাইল নম্বর</td><td>${studentPhoneVal}</td><td class="bg-light fw-semibold">ই-মেইল</td><td>${studentEmailVal}</td></tr>
                <tr><td class="bg-light fw-semibold">জাতীয়তা</td><td>${nationalityVal}</td><td class="bg-light fw-semibold">ধর্ম</td><td>${religionText}</td></tr>
                <tr><td class="bg-light fw-semibold">বর্তমান ঠিকানা</td><td colspan="3">${presentAddrVal}</td></tr>
                <tr><td class="bg-light fw-semibold">স্থায়ী ঠিকানা</td><td colspan="3">${permanentAddrVal}</td></tr>
            </table>

            <h6 class="fw-bold pb-1 border-bottom" style="color: #006a4e;"><i class="fa-solid fa-people-roof me-2"></i>৩. পিতা-মাতা ও অভিভাবকের তথ্য</h6>
            <table class="table table-sm table-bordered mb-4 mt-2">
                <tr><td width="25%" class="bg-light fw-semibold">পিতার নাম</td><td width="25%">${fatherNameVal}</td><td width="25%" class="bg-light fw-semibold">পিতার পেশা</td><td width="25%">${fatherOccVal}</td></tr>
                <tr><td class="bg-light fw-semibold">পিতার মোবাইল</td><td colspan="3">${fatherPhoneVal}</td></tr>
                <tr><td class="bg-light fw-semibold">মাতার নাম</td><td>${motherNameVal}</td><td class="bg-light fw-semibold">মাতার পেশা</td><td>${motherOccVal}</td></tr>
                <tr><td class="bg-light fw-semibold">মাতার মোবাইল</td><td colspan="3">${motherPhoneVal}</td></tr>
                <tr><td class="bg-light fw-semibold">বিকল্প অভিভাবক</td><td>${guardianNameVal} (${guardianRelText})</td><td class="bg-light fw-semibold">অভিভাবকের মোবাইল</td><td>${guardianPhoneVal}</td></tr>
            </table>

            <h6 class="fw-bold pb-1 border-bottom" style="color: #006a4e;"><i class="fa-solid fa-money-bill-wave me-2"></i>৪. পেমেন্ট ও পরিশোধযোগ্য ফি</h6>
            <table class="table table-sm table-bordered mb-3 mt-2">
                <tr><td width="25%" class="bg-light fw-semibold">পেমেন্ট পদ্ধতি</td><td>${selectedPayment ? selectedPayment.value.toUpperCase() : 'N/A'}</td><td width="25%" class="bg-light text-success fw-bold">মোট পরিশোধযোগ্য টাকা</td><td class="text-danger fw-bold fs-5">৳ ${grandTotalVal}</td></tr>
                <tr><td class="bg-light fw-semibold">মন্তব্য / বিশেষ প্রয়োজন</td><td colspan="3">${remarksVal}</td></tr>
            </table>
        `;

        previewModalBody.innerHTML = previewHTML;
        previewModal.show();
    });

    /* =========================================================
       SUBMIT EVENT INTERCEPTOR
    ========================================================= */
    admissionForm.addEventListener('submit', function (e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            return;
        }

        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        if (selectedPayment && selectedPayment.value === 'online') {
            alert('অনলাইন পেমেন্ট গেটওয়েতে রিডাইরেক্ট করা হচ্ছে...');
            return;
        }

        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });

    document.getElementById('btnReload').addEventListener('click', function() {
        admissionForm.reset();
    });
});
</script>