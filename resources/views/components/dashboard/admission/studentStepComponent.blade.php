<!-- STUDENT PERSONAL INFORMATION SECTION -->
<div class="form-section p-4 p-md-5">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-user-graduate text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">শিক্ষার্থীর ব্যক্তিগত তথ্য</h5>
    </div>

    <div class="row g-4">
        <!-- Input Fields Column -->
        <div class="col-lg-9 order-2 order-lg-1">
            <div class="row g-3">
                <!-- Student ID (Readonly) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">শিক্ষার্থী আইডি</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-id-badge"></i></span>
                        <input type="text" class="form-control bg-light border-start-0 fw-semibold text-muted" value="Pending Payment" placeholder="পেমেন্ট বা অনুমোদন শেষে আইডি তৈরি হবে" readonly style="font-size: 15px;">
                    </div>
                    <div class="small-hint text-danger mt-1" style="font-size: 11px;">
                        <i class="fa-solid fa-circle-exclamation me-1"></i>পেমেন্ট নিশ্চিত বা অ্যাডমিন কর্তৃক ভর্তি অনুমোদিত হলে আইডি স্বয়ংক্রিয়ভাবে তৈরি হবে।
                    </div>
                </div>

                <!-- Birth Certificate -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">জন্ম নিবন্ধন নম্বর</label>
                    <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 15px;" name="birth_certificate_no" id="birthCertificateNo" maxlength="17" placeholder="১৭ সংখ্যার জন্ম নিবন্ধন নম্বর লিখুন">
                </div>

                <!-- Name BN -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary required">শিক্ষার্থীর নাম (বাংলা) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 15px;" name="name_bn" id="nameBn" placeholder="শিক্ষার্থীর পূর্ণ নাম বাংলায় লিখুন" required>
                </div>

                <!-- Name EN -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary required">শিক্ষার্থীর নাম (English) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 15px;" name="name_en" id="nameEn" placeholder="Enter student full name in English" required>
                </div>

                <!-- DOB -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary required">জন্ম তারিখ <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-lg shadow-sm" style="font-size: 15px;" name="date_of_birth" id="dateOfBirth" required>
                </div>

                <!-- Gender -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary required">লিঙ্গ <span class="text-danger">*</span></label>
                    <select class="form-select form-select-lg shadow-sm" style="font-size: 15px;" name="gender" id="gender" required>
                        <option value="">নির্বাচন করুন</option>
                        <option value="male">ছেলে</option>
                        <option value="female">মেয়ে</option>
                        <option value="other">অন্যান্য</option>
                    </select>
                </div>

                <!-- Blood Group -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">রক্তের গ্রুপ</label>
                    <select class="form-select form-select-lg shadow-sm" style="font-size: 15px;" name="blood_group" id="bloodGroup">
                        <option value="">নির্বাচন করুন</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">শিক্ষার্থীর মোবাইল</label>
                    <input type="text" class="form-control form-control-lg shadow-sm" style="font-size: 15px;" name="phone" id="phone" placeholder="যেমন: 01XXXXXXXXX">
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">ই-মেইল</label>
                    <input type="email" class="form-control form-control-lg shadow-sm" style="font-size: 15px;" name="email" id="email" placeholder="যেমন: student@example.com">
                </div>
            </div>
        </div>

        <!-- Photo Upload Column -->
        <div class="col-lg-3 order-1 order-lg-2">
            <label class="form-label fw-semibold text-secondary d-block text-lg-center">শিক্ষার্থীর ছবি (ঐচ্ছিক)</label>
            <div class="position-relative mx-auto" style="max-width: 200px;">
                <!-- Remove Image Circle Button Overlay -->
                <button type="button" id="btnRemovePhoto" class="btn btn-danger btn-sm rounded-circle position-absolute d-flex align-items-center justify-content-center" style="top: -8px; right: -8px; width: 28px; height: 28px; display: none !important; z-index: 10; border: 2px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.15);" title="ছবি মুছুন">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                
                <!-- Upload Container Box -->
                <label class="photo-upload w-100 m-0 shadow-sm">
                    <img id="photoPreview" class="photo-preview mb-2 shadow-sm" alt="Photo Preview">
                    <div id="photoDefaultPlaceholder" class="text-center d-flex flex-column align-items-center">
                        <i id="photoIcon" class="fa-regular fa-image text-muted"></i>
                        <span id="photoText" class="fw-semibold">ছবি নির্বাচন করুন</span>
                        <small class="text-muted mt-1">JPG / PNG • Max 2MB</small>
                    </div>
                    <input type="file" class="d-none" id="studentPhoto" name="photo" accept="image/jpeg,image/png">
                </label>
            </div>
        </div>
    </div>
</div>

<!-- ADDRESS SECTION -->
<div class="form-section p-4 p-md-5 border-top bg-light-subtle">
    
    <!-- SECTION TITLE -->
    <div class="section-title d-flex align-items-center gap-2 mb-4 pb-2 border-bottom text-dark">
        <i class="fa-solid fa-location-dot text-success fs-4"></i>
        <h5 class="fw-bold mb-0" style="color: var(--brand-primary, #004d40);">ঠিকানা</h5>
    </div>

    <div class="row g-4">
        <!-- Present Address -->
        <div class="col-md-6">
            <label class="form-label fw-semibold text-secondary required">বর্তমান ঠিকানা <span class="text-danger">*</span></label>
            <textarea class="form-control shadow-sm" rows="3" style="font-size: 14.5px;" name="present_address" id="presentAddress" placeholder="গ্রাম/মহল্লা, রোড নম্বর, ডাকঘর ও থানা উল্লেখ করে লিখুন" required></textarea>
        </div>
        
        <!-- Permanent Address -->
        <div class="col-md-6">
            <label class="form-label fw-semibold text-secondary">স্থায়ী ঠিকানা</label>
            <textarea class="form-control shadow-sm" rows="3" style="font-size: 14.5px;" name="permanent_address" id="permanentAddress" placeholder="স্থায়ী ঠিকানা লিখুন (বর্তমান ঠিকানার অনুরূপ হলে একই লিখুন)"></textarea>
        </div>
    </div>
</div>

<!-- FOOTER SECTION -->
<div class="form-footer d-flex justify-content-between align-items-center p-4 bg-light border-top rounded-bottom-4">
    <div>
        <button type="button" class="btn btn-light border px-4 btnPrevStep py-2 shadow-sm d-flex align-items-center gap-2" data-current="2" style="border-radius: 8px; font-weight: 600;">
            <i class="fa-solid fa-arrow-left fs-6"></i> পূর্ববর্তী ধাপ
        </button>
    </div>
    <div>
        <button type="button" class="btn btn-next px-4 btnNextStep py-2 shadow-sm d-flex align-items-center gap-2" data-current="2" style="border-radius: 8px;">
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

    /* Photo Upload Container Style */
    .photo-upload {
        border: 2px dashed var(--brand-border-muted); 
        border-radius: 12px; 
        min-height: 200px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        flex-direction: column; 
        color: #6c757d; 
        cursor: pointer; 
        background-color: #fafafa; 
        transition: all 0.25s ease-in-out;
        padding: 15px;
    }
    
    .photo-upload:hover { 
        border-color: var(--brand-success-dark); 
        background-color: var(--brand-success-light); 
        color: var(--brand-success-dark);
    }
    
    .photo-upload i { 
        font-size: 38px; 
        margin-bottom: 10px; 
        transition: color 0.25s ease-in-out;
    }
    
    .photo-upload:hover i {
        color: var(--brand-success-dark) !important;
    }

    /* Uploaded Image Preview Frame */
    .photo-preview { 
        width: 120px; 
        height: 145px; 
        object-fit: cover; 
        border-radius: 8px; 
        border: 1px solid var(--brand-border-muted); 
        display: none; 
    }

    /* Input Field Custom Focus States */
    .form-control:focus, .form-select:focus {
        border-color: var(--brand-success-dark) !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 106, 78, 0.15) !important;
    }
</style>

<!-- COMPONENT SPECIFIC JAVASCRIPT (FUNCTIONALITY RETAINED) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('studentPhoto');
    const photoPreview = document.getElementById('photoPreview');
    const photoIcon = document.getElementById('photoIcon');
    const photoText = document.getElementById('photoText');
    const btnRemovePhoto = document.getElementById('btnRemovePhoto');
    const photoDefaultPlaceholder = document.getElementById('photoDefaultPlaceholder');

    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('ছবির সর্বোচ্চ সাইজ 2MB হতে হবে।');
            resetPhotoState();
            return;
        }

        if (file.type !== 'image/jpeg' && file.type !== 'image/png') {
            alert('শুধুমাত্র JPG অথবা PNG ছবি ব্যবহার করুন।');
            resetPhotoState();
            return;
        }

        photoPreview.src = URL.createObjectURL(file);
        photoPreview.style.display = 'block';
        if (photoDefaultPlaceholder) {
            photoDefaultPlaceholder.style.display = 'none';
        }
        photoIcon.style.display = 'none';
        photoText.textContent = file.name;
        
        btnRemovePhoto.style.setProperty('display', 'flex', 'important');
    });

    btnRemovePhoto.addEventListener('click', function (e) {
        e.preventDefault();
        resetPhotoState();
    });

    function resetPhotoState() {
        photoInput.value = '';
        photoPreview.src = '';
        photoPreview.style.display = 'none';
        if (photoDefaultPlaceholder) {
            photoDefaultPlaceholder.style.display = 'flex';
        }
        photoIcon.style.display = 'block';
        photoText.textContent = 'ছবি নির্বাচন করুন';
        btnRemovePhoto.style.setProperty('display', 'none', 'important');
    }

    // Attach to form reset
    const form = document.getElementById('admissionForm');
    if (form) {
        form.addEventListener('reset', function() {
            setTimeout(resetPhotoState, 50);
        });
    }
});
</script>