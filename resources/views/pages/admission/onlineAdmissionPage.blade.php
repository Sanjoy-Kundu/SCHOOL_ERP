<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Admission Application | Public Portal</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <style>
        body {
            background: #f4f6f9;
            font-family: 'Hind Siliguri', sans-serif;
            color: #333333;
        }

        .page-wrapper {
            max-width: 1000px;
            margin: 25px auto;
            padding: 0 10px;
        }

        .form-card {
            border: 0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, .07);
        }

        /* =========================
           HEADER (Government/Official Theme)
        ========================== */
        .form-header {
            background: #fff;
            border-bottom: 3px solid #006a4e; /* Govt Green */
            padding: 22px 28px;
        }

        .school-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #006a4e;
        }

        .school-name {
            color: #006a4e;
            font-size: 23px;
            font-weight: 700;
            margin-bottom: 1px;
        }

        /* =========================
           FORM SECTION
        ========================== */
        .form-section {
            background: #fff;
            padding: 25px 28px;
            border-bottom: 1px solid #edf0f2;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 17px;
            font-weight: 600;
            color: #006a4e;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .required::after {
            content: " *";
            color: #da291c;
        }

        .form-control, .form-select {
            min-height: 42px;
            border-radius: 7px;
            border-color: #dfe3e7;
            font-size: 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #006a4e;
            box-shadow: 0 0 0 .2rem rgba(0, 106, 78, .10);
        }

        textarea.form-control {
            min-height: 90px;
        }

        /* =========================
           PHOTO UPLOAD
        ========================== */
        .photo-upload {
            border: 2px dashed #ced4da;
            border-radius: 10px;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #6c757d;
            cursor: pointer;
            background: #fafafa;
            transition: .2s;
        }

        .photo-upload:hover {
            border-color: #006a4e;
            background: #f1fbf6;
        }

        .photo-upload i {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .photo-preview {
            width: 110px;
            height: 135px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            display: none;
        }

        .form-footer {
            background: #fff;
            padding: 20px 28px;
        }

        .btn-submit {
            min-width: 180px;
            background-color: #006a4e;
            border-color: #006a4e;
            color: #fff;
        }

        .btn-submit:hover {
            background-color: #00543e;
            border-color: #00543e;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="card form-card">

        <!-- SCHOOL HEADER -->
        <div class="form-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="https://via.placeholder.com/100" class="school-logo" alt="School Logo">
                <div>
                    <div class="school-name">ঢাকা মডেল হাই স্কুল</div>
                    <div class="text-muted small">EIIN: 123456 | অনলাইন ভর্তি আবেদন পোর্টাল</div>
                </div>
            </div>
            <div class="text-md-end">
                <span class="badge bg-success text-white p-2">শিক্ষাবর্ষ: ২০২৬</span>
                <div class="text-muted small mt-1">জনসাধারণের জন্য উন্মুক্ত</div>
            </div>
        </div>

        <!-- FORM START -->
        <form id="publicApplicationForm" class="needs-validation" novalidate>

            <!-- SECTION 1: ACADEMIC CHOICE -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fa-solid fa-school"></i>
                    ১. কাঙ্খিত শ্রেণীর তথ্য
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">শিক্ষাবর্ষ</label>
                        <select class="form-select" id="appSession" required>
                            <option value="২০২৬" selected>২০২৬</option>
                            <option value="২০২৭">২০২৭</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">ভর্তির শ্রেণী</label>
                        <select class="form-select" id="appClass" required>
                            <option value="">শ্রেণী নির্বাচন করুন</option>
                            <option value="৬ষ্ঠ শ্রেণী">৬ষ্ঠ শ্রেণী</option>
                            <option value="৭ম শ্রেণী">৭ম শ্রেণী</option>
                            <option value="৮ম শ্রেণী">৮ম শ্রেণী</option>
                            <option value="৯ম শ্রেণী">৯ম শ্রেণী</option>
                            <option value="১০ম শ্রেণী">১০ম শ্রেণী</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: STUDENT INFORMATION -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fa-solid fa-user-graduate"></i>
                    ২. শিক্ষার্থীর ব্যক্তিগত তথ্য
                </div>
                <div class="row g-3">
                    <div class="col-md-9">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">শিক্ষার্থীর নাম (বাংলা)</label>
                                <input type="text" class="form-control" id="appNameBn" placeholder="শিক্ষার্থীর পূর্ণ নাম বাংলায় লিখুন" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">শিক্ষার্থীর নাম (English)</label>
                                <input type="text" class="form-control" id="appNameEn" placeholder="Student Full Name in English" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">জন্ম নিবন্ধন নম্বর</label>
                                <input type="text" class="form-control" id="appBirthCert" maxlength="17" placeholder="১৭ সংখ্যার জন্ম নিবন্ধন নম্বর লিখুন" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">জন্ম তারিখ</label>
                                <input type="date" class="form-control" id="appDob" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">লিঙ্গ</label>
                                <select class="form-select" id="appGender" required>
                                    <option value="">নির্বাচন করুন</option>
                                    <option value="male">ছেলে</option>
                                    <option value="female">মেয়ে</option>
                                    <option value="other">অন্যান্য</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">মোবাইল নম্বর (যদি থাকে)</label>
                                <input type="text" class="form-control" id="appStudentPhone" placeholder="যেমন: 01XXXXXXXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">রক্তের গ্রুপ</label>
                                <select class="form-select" id="appBloodGroup">
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
                        </div>
                    </div>

                    <!-- Photo Upload (with Remove Button Overlay) -->
                    <div class="col-md-3">
                        <label class="form-label">শিক্ষার্থীর ছবি (ঐচ্ছিক)</label>
                        <div class="position-relative">
                            <!-- Clickable Remove Icon Overlay -->
                            <button type="button" id="btnRemovePhoto" class="btn btn-danger btn-sm rounded-circle position-absolute d-flex align-items-center justify-content-center" style="top: -8px; right: -8px; width: 26px; height: 26px; display: none !important; z-index: 10; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.2);" title="ছবি মুছুন">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            <label class="photo-upload w-100 m-0">
                                <img id="photoPreview" class="photo-preview mb-2" alt="Photo Preview">
                                <i id="photoIcon" class="fa-regular fa-image"></i>
                                <span id="photoText">ছবি নির্বাচন করুন</span>
                                <small class="text-muted">JPG / PNG • Max 2MB</small>
                                <input type="file" class="d-none" id="studentPhoto" accept="image/jpeg,image/png">
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">বর্তমান ঠিকানা</label>
                        <textarea class="form-control" id="appPresentAddr" placeholder="গ্রাম/মহল্লা, রোড নম্বর, ডাকঘর ও থানা উল্লেখ করে লিখুন" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">স্থায়ী ঠিকানা</label>
                        <textarea class="form-control" id="appPermanentAddr" placeholder="স্থায়ী ঠিকানা লিখুন (বর্তমান ঠিকানার অনুরূপ হলে খালি রাখুন)"></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: PARENT DETAILS -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fa-solid fa-people-roof"></i>
                    ৩. পিতা-মাতা ও অভিভাবকের তথ্য
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">পিতার নাম</label>
                        <input type="text" class="form-control" id="appFatherName" placeholder="পিতার পূর্ণ নাম লিখুন" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">পিতার পেশা</label>
                        <input type="text" class="form-control" id="appFatherOcc" placeholder="পিতার পেশা লিখুন">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label required">পিতার মোবাইল নম্বর</label>
                        <input type="text" class="form-control" id="appFatherPhone" placeholder="যেমন: 01XXXXXXXXX" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">মাতার নাম</label>
                        <input type="text" class="form-control" id="appMotherName" placeholder="মাতার পূর্ণ নাম লিখুন" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">মাতার পেশা</label>
                        <input type="text" class="form-control" id="appMotherOcc" placeholder="মাতার পেশা লিখুন">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">মাতার মোবাইল নম্বর</label>
                        <input type="text" class="form-control" id="appMotherPhone" placeholder="যেমন: 01XXXXXXXXX">
                    </div>
                </div>
            </div>

            <!-- FOOTER WITH ACTIONS -->
            <div class="form-footer d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    <span class="text-danger">*</span> চিহ্নিত তথ্যগুলো অবশ্যই প্রদান করতে হবে।
                </div>
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-light border px-4">রিসেট</button>
                    <button type="submit" class="btn btn-submit px-5" style="background-color: #006a4e;">
                        <i class="fa-solid fa-paper-plane me-1"></i> আবেদন সাবমিট করুন
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- SUCCESS DIALOG MODAL -->
<div class="modal fade" id="appSuccessModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-5">
                <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;">
                    <i class="fa-solid fa-check fa-2x"></i>
                </div>
                <h4 class="fw-bold text-success">আবেদন সফলভাবে সাবমিট হয়েছে</h4>
                <p class="text-muted">আপনার অনলাইন ভর্তি আবেদন ডাটাবেজে সংরক্ষিত হয়েছে। আপনার আবেদন আইডিটি নিচে দেওয়া হলো। অ্যাডমিন এই আইডি ব্যবহার করে ভর্তি চূড়ান্ত করবেন।</p>
                
                <div class="bg-light border rounded p-3 my-3">
                    <span class="text-muted small d-block">ইউনিক আবেদন আইডি (Application ID)</span>
                    <strong class="fs-4 text-dark" id="generatedAppId">APP-2026-1001</strong>
                </div>

                <div class="alert alert-warning small py-2 text-start">
                    <i class="fa-solid fa-circle-info me-1"></i> এই আইডিটি স্ক্রিনশট বা খাতায় লিখে রাখুন এবং চূড়ান্ত ভর্তির জন্য স্কুল অ্যাডমিনকে প্রদান করুন।
                </div>

                <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal" id="btnAppModalOk">ঠিক আছে</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const publicForm = document.getElementById('publicApplicationForm');
    const photoInput = document.getElementById('studentPhoto');
    const photoPreview = document.getElementById('photoPreview');
    const photoIcon = document.getElementById('photoIcon');
    const photoText = document.getElementById('photoText');
    const btnRemovePhoto = document.getElementById('btnRemovePhoto');

    /* =========================================================
       PHOTO UPLOAD & PREVIEW
    ========================================================= */
    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('ছবির সর্বোচ্চ সাইজ ২ মেগাবাইট (2MB) হতে হবে।');
            resetPhotoState();
            return;
        }

        if (file.type !== 'image/jpeg' && file.type !== 'image/png') {
            alert('শুধুমাত্র JPG অথবা PNG ছবি আপলোড করুন।');
            resetPhotoState();
            return;
        }

        photoPreview.src = URL.createObjectURL(file);
        photoPreview.style.display = 'block';
        photoIcon.style.display = 'none';
        photoText.textContent = file.name;
        
        // Show Remove Button Overlay
        btnRemovePhoto.style.setProperty('display', 'flex', 'important');
    });

    /* =========================================================
       REMOVE PHOTO ACTION (NEWLY ADDED)
    ========================================================= */
    btnRemovePhoto.addEventListener('click', function (e) {
        e.preventDefault();
        resetPhotoState();
    });

    function resetPhotoState() {
        photoInput.value = '';
        photoPreview.src = '';
        photoPreview.style.display = 'none';
        photoIcon.style.display = 'block';
        photoText.textContent = 'ছবি নির্বাচন করুন';
        
        // Hide Remove Button Overlay
        btnRemovePhoto.style.setProperty('display', 'none', 'important');
    }

    /* =========================================================
       RESET FORM EVENTS
    ========================================================= */
    publicForm.addEventListener('reset', function () {
        setTimeout(function () {
            resetPhotoState();
            publicForm.classList.remove('was-validated');
        }, 50);
    });

    /* =========================================================
       FORM SUBMISSION & UNIQUE APPLICATION ID GENERATION
    ========================================================= */
    publicForm.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.classList.add('was-validated');
            return;
        }

        // Generate a random unique Application ID for Demo (e.g. APP-2026-8432)
        const randomDigits = Math.floor(1000 + Math.random() * 9000);
        const appId = `APP-2026-${randomDigits}`;
        
        // Save form data into localStorage using the Application ID as the key
        const appPayload = {
            app_id: appId,
            session: document.getElementById('appSession').value,
            class: document.getElementById('appClass').value,
            name_bn: document.getElementById('appNameBn').value,
            name_en: document.getElementById('appNameEn').value,
            birth_cert: document.getElementById('appBirthCert').value,
            dob: document.getElementById('appDob').value,
            gender: document.getElementById('appGender').value,
            student_phone: document.getElementById('appStudentPhone').value,
            blood: document.getElementById('appBloodGroup').value,
            present_addr: document.getElementById('appPresentAddr').value,
            perm_addr: document.getElementById('appPermanentAddr').value || document.getElementById('appPresentAddr').value,
            father_name: document.getElementById('appFatherName').value,
            father_occ: document.getElementById('appFatherOcc').value,
            father_phone: document.getElementById('appFatherPhone').value,
            mother_name: document.getElementById('appMotherName').value,
            mother_occ: document.getElementById('appMotherOcc').value,
            mother_phone: document.getElementById('appMotherPhone').value
        };

        // Save to browser Storage so the Admin form can load it instantly
        localStorage.setItem(appId, JSON.stringify(appPayload));

        // Inject generated App ID inside Modal
        document.getElementById('generatedAppId').textContent = appId;
        
        // Open Success Modal
        const successModal = new bootstrap.Modal(document.getElementById('appSuccessModal'));
        successModal.show();
    });

    // Reset Form when OK is clicked inside Success Modal
    document.getElementById('btnAppModalOk').addEventListener('click', function() {
        publicForm.reset();
    });

});
</script>

</body>
</html>