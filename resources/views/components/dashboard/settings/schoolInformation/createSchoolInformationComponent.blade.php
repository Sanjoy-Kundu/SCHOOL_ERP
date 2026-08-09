@push('styles')
<style>
    /* Dynamic responsive design CSS for Workspace Panels */
    @media (max-width: 575.98px) {
        .card-responsive { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important; }
        .container-responsive { padding-left: 10px !important; padding-right: 10px !important; }
        .title-responsive { font-size: 1.5rem !important; }
    }
    @media (min-width: 576px) and (max-width: 991.98px) {
        .card-responsive { border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }
        .title-responsive { font-size: 1.8rem !important; }
    }
    @media (min-width: 992px) {
        .card-responsive { border-radius: 20px !important; box-shadow: 0 12px 40px rgba(0,0,0,0.06) !important; }
    }

    /* Section Navigator Navigation Tabs style */
    .nav-tabs-academic .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 600;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        text-align: left;
        margin-bottom: 5px;
    }
    .nav-tabs-academic .nav-link.active {
        background-color: #004d40 !important; /* Classic Bangladeshi School Green */
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 77, 64, 0.2);
    }
    .nav-tabs-academic .nav-link:hover:not(.active) {
        background-color: #f1f2f4;
        color: #004d40;
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

    /* Standard Labeling & Assets Styling */
    .form-label-custom {
        font-weight: 600;
        font-size: 0.85rem;
        color: #4a5568;
        margin-bottom: 6px;
    }
    .logo-uploader-card {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        transition: all 0.3s ease;
        padding: 15px;
        background: #f8fafc;
        position: relative;
    }
    .logo-uploader-card:hover {
        border-color: #004d40;
        background: #f0fdf4;
    }
    .logo-img-preview {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
    }
    .favicon-img-preview {
        width: 48px;
        height: 48px;
        object-fit: contain;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        background: white;
    }

    /* Modal Rendering CSS Rules */
    .modal-profile-header {
        background: linear-gradient(135deg, #004d40, #00332a);
        color: white;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
    }
    .modal-section-title {
        color: #004d40;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 6px;
        margin-top: 20px;
        font-weight: 700;
        font-size: 1rem;
    }
    .modal-data-row {
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .modal-data-label {
        font-weight: 600;
        color: #64748b;
        font-size: 0.85rem;
    }
    .modal-data-value {
        color: #0f172a;
        font-weight: 500;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header & Action Controls -->
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">স্কুল পরিচিতি ব্যবস্থাপনা (Institution Profile)</h1>
            <p class="text-muted small mb-0">প্রতিষ্ঠানের দাপ্তরিক তথ্য, যোগাযোগের ঠিকানা, প্রতিষ্ঠান প্রধানের বিবরণ ও লোগো এখান থেকে নিয়ন্ত্রণ করুন।</p>
        </div>
        <div>
            <button id="viewInfoBtn" class="btn btn-primary btn-lg rounded-3 py-2 px-4 fw-bold fs-6 shadow-sm border-0 d-flex align-items-center gap-2" style="background-color: #004d40; border-color: #004d40;" data-bs-toggle="modal" data-bs-target="#viewSchoolModal">
                <i class="fa-solid fa-circle-info"></i> প্রতিষ্ঠানের সম্পূর্ণ তথ্য দেখুন
            </button>
        </div>
    </div>

    <!-- Loading Placeholder / Screen Loader -->
    <div id="pageScreenLoader" class="text-center py-5">
        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;"></div>
        <h5 class="mt-3 text-muted">ডাটাবেজ থেকে প্রতিষ্ঠানের প্রোফাইল লোড হচ্ছে...</h5>
    </div>

    <!-- Main Workspace (Displays on Load completion) -->
    <div id="mainWorkspace" class="row g-4" style="display: none;">
        
        <!-- Left Side: Summary Preview Card (প্রতিষ্ঠানের পরিচিতি প্রিভিউ) -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 card-responsive shadow-sm p-4 bg-white text-center">
                <div class="position-relative d-inline-block mx-auto mb-3">
                    <img id="sidePreviewSquareLogo" src="" class="logo-img-preview border shadow-sm" style="width: 120px; height: 120px;" alt="Square Logo">
                </div>
                
                <h4 id="sidePreviewNameBn" class="fw-bold text-dark mb-1"></h4>
                <p id="sidePreviewNameEn" class="text-muted small mb-3"></p>
                
                <div class="p-3 bg-light rounded-3 text-start mb-4">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="small fw-semibold text-muted">EIIN নম্বর:</span>
                        <span id="sidePreviewEIIN" class="small fw-bold text-dark"></span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="small fw-semibold text-muted">প্রতিষ্ঠানের ধরন:</span>
                        <span id="sidePreviewType" class="small fw-bold text-dark"></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-semibold text-muted">যোগাযোগের মোবাইল:</span>
                        <span id="sidePreviewPhone" class="small fw-bold text-dark"></span>
                    </div>
                </div>

                <div class="text-start">
                    <h6 class="fw-bold text-muted small uppercase mb-2">প্রতিষ্ঠানের মূলমন্ত্র:</h6>
                    <blockquote class="blockquote blockquote-custom bg-white p-3 rounded-3 border-start border-4 border-success shadow-sm mb-0">
                        <p id="sidePreviewMotto" class="mb-0 fs-6 italic text-dark fw-semibold"></p>
                    </blockquote>
                </div>
            </div>
        </div>

        <!-- Right Side: Sectioned Tab Navigator & Form Workspace -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 card-responsive shadow-sm bg-white p-4">
                <form id="schoolInformationUpdateForm" enctype="multipart/form-data" novalidate>
                    
                    <div class="row">
                        <!-- Left Navigation Tabs inside card -->
                        <div class="col-12 col-md-4 col-lg-3 border-end">
                            <div class="nav flex-column nav-tabs-academic border-0" id="section-tab" role="tablist">
                                <button class="nav-link active" id="identity-tab" data-bs-toggle="pill" data-bs-target="#tab-identity" type="button" role="tab"><i class="fa-solid fa-school me-2"></i>পরিচিতি</button>
                                <button class="nav-link" id="address-tab" data-bs-toggle="pill" data-bs-target="#tab-address" type="button" role="tab"><i class="fa-solid fa-map-location-dot me-2"></i>ঠিকানা</button>
                                <button class="nav-link" id="contact-tab" data-bs-toggle="pill" data-bs-target="#tab-contact" type="button" role="tab"><i class="fa-solid fa-phone me-2"></i>যোগাযোগ</button>
                                <button class="nav-link" id="head-tab" data-bs-toggle="pill" data-bs-target="#tab-head" type="button" role="tab"><i class="fa-solid fa-user-tie me-2"></i>প্রতিষ্ঠান প্রধান</button>
                                <button class="nav-link" id="branding-tab" data-bs-toggle="pill" data-bs-target="#tab-branding" type="button" role="tab"><i class="fa-solid fa-image me-2"></i>ব্র্যান্ডিং ও লোগো</button>
                                <button class="nav-link" id="extra-tab" data-bs-toggle="pill" data-bs-target="#tab-extra" type="button" role="tab"><i class="fa-solid fa-info-circle me-2"></i>অতিরিক্ত তথ্য</button>
                                <button class="nav-link" id="social-tab" data-bs-toggle="pill" data-bs-target="#tab-social" type="button" role="tab"><i class="fa-solid fa-share-nodes me-2"></i>সোশ্যাল মিডিয়া</button>
                            </div>
                        </div>

                        <!-- Right Contents Panel -->
                        <div class="col-12 col-md-8 col-lg-9 ps-md-4">
                            <div class="tab-content" id="section-tabContent">
                                
                                <!-- Tab 1: Institution Identity (পরিচিতি) -->
                                <div class="tab-pane fade show active" id="tab-identity" role="tabpanel">
                                    <h5 class="fw-bold mb-4 text-success border-bottom pb-2">প্রতিষ্ঠানের মূল পরিচিতি (Institution Identity)</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রতিষ্ঠানের নাম (বাংলা) <span class="text-danger">*</span></label>
                                            <input type="text" name="name_bn" id="input_name_bn" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠানের নাম (বাংলা) লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রতিষ্ঠানের নাম (ইংরেজি) <span class="text-danger">*</span></label>
                                            <input type="text" name="name_en" id="input_name_en" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠানের নাম (ইংরেজী) লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রতিষ্ঠানের কোড (School Code)</label>
                                            <input type="text" name="school_code" id="input_school_code" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠানের কোড লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">EIIN নম্বর</label>
                                            <input type="text" name="eiin" id="input_eiin" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠানের EIIN নম্বর লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রতিষ্ঠানের ধরন (School Type)</label>
                                            <select name="school_type" id="input_school_type" class="form-select form-control-lg rounded-3">
                                                <option value="">নির্বাচন করুন</option>
                                                <option value="Secondary School">Secondary School</option>
                                                <option value="School & College">School & College</option>
                                                <option value="Junior Secondary School">Junior Secondary School</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">ব্যবস্থাপনার ধরন (Management Type)</label>
                                            <select name="management_type" id="input_management_type" class="form-select form-control-lg rounded-3">
                                                <option value="">নির্বাচন করুন</option>
                                                <option value="Government">Government (সরকারি)</option>
                                                <option value="MPO">MPO (এমপিওভুক্ত)</option>
                                                <option value="Non-MPO">Non-MPO (নন-এমপিও)</option>
                                                <option value="Private">Private (ব্যক্তিগত)</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রতিষ্ঠার সাল (Established Year)</label>
                                            <input type="number" name="established_year" id="input_established_year" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠান প্রতিষ্ঠার বছর লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">স্বীকৃতি নম্বর (Recognition No)</label>
                                            <input type="text" name="recognition_no" id="input_recognition_no" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠানের স্বীকৃতি নম্বর লিখুন">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-custom">স্বীকৃতির তারিখ (Recognition Date)</label>
                                            <input type="date" name="recognition_date" id="input_recognition_date" class="form-control form-control-lg rounded-3">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 2: Address & Location (ঠিকানা ও অবস্থান) -->
                                <div class="tab-pane fade" id="tab-address" role="tabpanel">
                                    <h5 class="fw-bold mb-4 text-success border-bottom pb-2">প্রতিষ্ঠানের ঠিকানা ও অবস্থান (Address & Location)</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">বিভাগ (Division)</label>
                                            <input type="text" name="division" id="input_division" class="form-control form-control-lg rounded-3"  placeholder="বিভাগ লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">জেলা (District)</label>
                                            <input type="text" name="district" id="input_district" class="form-control form-control-lg rounded-3" placeholder="জেলা লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">উপজেলা/থানা (Upazila)</label>
                                            <input type="text" name="upazila" id="input_upazila" class="form-control form-control-lg rounded-3" placeholder="উপজেলা/থানা লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">ইউনিয়ন/ওয়ার্ড (Union/Ward)</label>
                                            <input type="text" name="union_ward" id="input_union_ward" class="form-control form-control-lg rounded-3" placeholder="ইউনিয়ন/ওয়ার্ড  লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">গ্রাম/এলাকা (Village/Area)</label>
                                            <input type="text" name="village_area" id="input_village_area" class="form-control form-control-lg rounded-3" placeholder="গ্রাম/এলাকা  লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">ডাকঘর (Post Office)</label>
                                            <input type="text" name="post_office" id="input_post_office" class="form-control form-control-lg rounded-3" placeholder="ডাকঘর  লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">পোস্ট কোড (Post Code)</label>
                                            <input type="text" name="post_code" id="input_post_code" class="form-control form-control-lg rounded-3" placeholder="পোস্ট কোড লিখুন">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-custom">পূর্ণাঙ্গ ঠিকানা (Full Address)</label>
                                            <textarea name="address" id="input_address" rows="3" class="form-control form-control-lg rounded-3" placeholder="পূর্ণাঙ্গ ঠিকানা লিখুন"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 3: Contact Details (যোগাযোগের তথ্য) -->
                                <div class="tab-pane fade" id="tab-contact" role="tabpanel">
                                    <h5 class="fw-bold mb-4 text-success border-bottom pb-2">যোগাযোগের তথ্য (Contact Information)</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">অফিসিয়াল মোবাইল <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" id="input_phone" class="form-control form-control-lg rounded-3" placeholder="অফিসিয়াল মোবাইল নাম্বার লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">বিকল্প মোবাইল (Alternate Phone)</label>
                                            <input type="text" name="alternate_phone" id="input_alternate_phone" class="form-control form-control-lg rounded-3"  placeholder="বিকল্প মোবাইল নাম্বার লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">জরুরি যোগাযোগ মোবাইল (Emergency)</label>
                                            <input type="text" name="emergency_phone" id="input_emergency_phone" class="form-control form-control-lg rounded-3"  placeholder="জরুরি যোগাযোগ মোবাইল নাম্বার লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">অফিসিয়াল ই-মেইল (Email)</label>
                                            <input type="email" name="email" id="input_email" class="form-control form-control-lg rounded-3" placeholder="অফিসিয়াল ই-মেইল লিখুন">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-custom">অফিসিয়াল ওয়েবসাইট (Website URL)</label>
                                            <input type="url" name="website" id="input_website" class="form-control form-control-lg rounded-3" placeholder="অফিসিয়াল ওয়েবসাইট লিখুন">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 4: Head of Institution (প্রতিষ্ঠান প্রধান) -->
                                <div class="tab-pane fade" id="tab-head" role="tabpanel">
                                    <h5 class="fw-bold mb-4 text-success border-bottom pb-2">প্রতিষ্ঠান প্রধানের তথ্য (Head of Institution)</h5>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রধানের নাম (বাংলা)</label>
                                            <input type="text" name="head_name_bn" id="input_head_name_bn" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠান প্রধানের নাম (বাংলা) লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রধানের নাম (ইংরেজি)</label>
                                            <input type="text" name="head_name_en" id="input_head_name_en" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠান প্রধানের নাম (ইংরেজি) লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রধানের পদবি (বাংলা)</label>
                                            <input type="text" name="head_designation_bn" id="input_head_designation_bn" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠান প্রধানের পদবি (বাংলা) লিখুন">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label-custom">প্রধানের পদবি (ইংরেজি)</label>
                                            <input type="text" name="head_designation_en" id="input_head_designation_en" class="form-control form-control-lg rounded-3" placeholder="প্রতিষ্ঠান প্রধানের পদবি (ইংরেজি) লিখুন">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 5: Logos & Branding (লোগো ও ব্র্যান্ডিং) -->
                                <div class="tab-pane fade" id="tab-branding" role="tabpanel">
                                    <h5 class="fw-bold mb-4 text-success border-bottom pb-2">প্রতিষ্ঠানের ব্র্যান্ডিং এসেট (Logo & Branding)</h5>
                                    <div class="row g-4">
                                        <!-- Logo Square -->
                                        <div class="col-12 col-md-6">
                                            <div class="logo-uploader-card text-center">
                                                <h6 class="fw-bold text-dark mb-2">স্কয়ার লোগো (Square Logo)</h6>
                                                <div class="mb-3">
                                                    <img id="formSquareLogoPreview" src="" class="logo-img-preview" alt="Square Logo">
                                                </div>
                                                <input type="file" name="logo_square" id="logo_square_input" class="form-control form-control-sm" accept="image/png, image/jpeg, image/jpg, image/webp">
                                                <div class="small text-muted mt-1">PNG, JPG (অনুপাত 1:1, সর্বোচ্চ 2MB)</div>
                                            </div>
                                        </div>

                                        <!-- Logo Circle -->
                                        <div class="col-12 col-md-6">
                                            <div class="logo-uploader-card text-center">
                                                <h6 class="fw-bold text-dark mb-2">বৃত্তাকার লোগো (Circle Logo)</h6>
                                                <div class="mb-3">
                                                    <img id="formCircleLogoPreview" src="" class="logo-img-preview rounded-circle" alt="Circle Logo">
                                                </div>
                                                <input type="file" name="logo_circle" id="logo_circle_input" class="form-control form-control-sm" accept="image/png, image/jpeg, image/jpg, image/webp">
                                                <div class="small text-muted mt-1">PNG, JPG (অনুপাত 1:1, সর্বোচ্চ 2MB)</div>
                                            </div>
                                        </div>

                                        <!-- Favicon -->
                                        <div class="col-12">
                                            <div class="logo-uploader-card text-center">
                                                <h6 class="fw-bold text-dark mb-2">ফেভিকন (Favicon)</h6>
                                                <div class="mb-3">
                                                    <img id="formFaviconPreview" src="" class="favicon-img-preview" alt="Favicon">
                                                </div>
                                                <input type="file" name="favicon" id="favicon_input" class="form-control form-control-sm" accept="image/png, image/jpeg, image/jpg, image/webp, image/x-icon">
                                                <div class="small text-muted mt-1">ICO, PNG (১৬x১৬ বা ৩২x৩২, সর্বোচ্চ ১MB)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 6: Strategic/Extra details (অতিরিক্ত বিবরণ) -->
                                <div class="tab-pane fade" id="tab-extra" role="tabpanel">
                                    <h5 class="fw-bold mb-4 text-success border-bottom pb-2">অতিরিক্ত বিবরণী (Strategic Information)</h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label-custom">প্রতিষ্ঠানের মূলমন্ত্র (Motto)</label>
                                            <input type="text" name="motto" id="input_motto" class="form-control form-control-lg rounded-3" placeholder="উদা: জ্ঞানই আলো">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-custom">সংক্ষিপ্ত পরিচিতি (Short Description)</label>
                                            <textarea name="description" id="input_description" rows="3" class="form-control form-control-lg rounded-3" placeholder="সংক্ষিপ্ত পরিচিতি লিখুন"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-custom">লক্ষ্য (Mission Statement)</label>
                                            <textarea name="mission" id="input_mission" rows="3" class="form-control form-control-lg rounded-3" placeholder="লক্ষ্য লিখুন"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-custom">উদ্দেশ্য (Vision Statement)</label>
                                            <textarea name="vision" id="input_vision" rows="3" class="form-control form-control-lg rounded-3"  placeholder="উদ্দেশ্য লিখুন"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 7: Dynamic Social Links (সোশ্যাল মিডিয়া) -->
                                <div class="tab-pane fade" id="tab-social" role="tabpanel">
                                    <h5 class="fw-bold mb-3 text-success border-bottom pb-2">অনলাইন ও সোশ্যাল নেটওয়ার্ক লিঙ্ক (Social Media Links)</h5>
                                    <div class="text-end mb-3">
                                        <button type="button" id="addNewSocialRowBtn" class="btn btn-sm btn-success rounded-3 py-2 px-3 fw-bold"><i class="fa-solid fa-circle-plus me-1"></i> নতুন লিঙ্ক যোগ করুন</button>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>প্ল্যাটফর্মের নাম</th>
                                                    <th>ফন্ট অসাম আইকন ক্লাস</th>
                                                    <th>লিঙ্ক ইউআরএল (URL)</th>
                                                    <th style="width: 50px;">অ্যাকশন</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dynamicSocialContainer">
                                                <!-- Javascript will append rows dynamically here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Master Dynamic Global Submit Buttons inside Form -->
                    <div class="row mt-4 pt-3 border-top">
                        <div class="col-12 text-end">
                            <button type="submit" id="updateFormSubmitBtn" class="btn btn-brand-primary btn-lg rounded-3 py-2 px-5 fw-bold shadow-sm" style="display: none;">
                                <i class="fa-solid fa-floppy-disk me-1"></i> পরিবর্তন সংরক্ষণ করুন
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<!-- ==========================================
     PROFILES PREVIEW BOOTSTRAP MODAL
     ========================================== -->
<div class="modal fade" id="viewSchoolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3 shadow-lg">
            
            <!-- Header branding design -->
            <div class="modal-header modal-profile-header py-3 align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <img id="modalSquareLogo" src="" class="rounded bg-white border p-1" style="width: 50px; height: 50px; object-fit: contain;" alt="Square Logo">
                    <div>
                        <h5 class="modal-title fw-bold" id="modalNameBn"></h5>
                        <small id="modalNameEn" class="text-white-50"></small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Scrollable Information Profile View -->
            <div class="modal-body p-4 bg-light">
                
                <div class="text-center p-3 rounded bg-white shadow-sm border mb-4">
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">আমাদের মূলমন্ত্র</h6>
                    <p id="modalMotto" class="mb-0 text-success fw-bold font-italic fs-5"></p>
                </div>

                <div class="row g-4" id="modalProfileContent">
                    
                    <!-- Section 1: Institution Identity details -->
                    <div class="col-12 modal-dynamic-sec" id="mSectionIdentity">
                        <h6 class="modal-section-title"><i class="fa-solid fa-school me-2"></i> প্রতিষ্ঠানের পরিচিতি</h6>
                        <div class="row bg-white rounded-3 shadow-sm px-3 py-2 border g-1">
                            <div class="col-12 col-sm-6 modal-item" id="mRowSchoolCode">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">প্রতিষ্ঠান কোড</span>
                                    <span class="modal-data-value" id="mValSchoolCode"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowEIIN">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">EIIN নম্বর</span>
                                    <span class="modal-data-value" id="mValEIIN"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowSchoolType">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">প্রতিষ্ঠানের ধরন</span>
                                    <span class="modal-data-value" id="mValSchoolType"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowManagementType">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">ব্যবস্থাপনার ধরন</span>
                                    <span class="modal-data-value" id="mValManagementType"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowEstablishedYear">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">প্রতিষ্ঠার সাল</span>
                                    <span class="modal-data-value" id="mValEstablishedYear"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowRecognitionNo">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">স্বীকৃতি নম্বর</span>
                                    <span class="modal-data-value" id="mValRecognitionNo"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 modal-item" id="mRowRecognitionDate">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">স্বীকৃতির তারিখ</span>
                                    <span class="modal-data-value" id="mValRecognitionDate"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Physical Address & Location -->
                    <div class="col-12 modal-dynamic-sec" id="mSectionLocation">
                        <h6 class="modal-section-title"><i class="fa-solid fa-map-location-dot me-2"></i> ঠিকানা ও ভৌগলিক অবস্থান</h6>
                        <div class="row bg-white rounded-3 shadow-sm px-3 py-2 border g-1">
                            <div class="col-12 col-sm-6 modal-item" id="mRowDivision">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">বিভাগ</span>
                                    <span class="modal-data-value" id="mValDivision"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowDistrict">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">জেলা</span>
                                    <span class="modal-data-value" id="mValDistrict"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowUpazila">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">উপজেলা/থানা</span>
                                    <span class="modal-data-value" id="mValUpazila"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowUnionWard">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">ইউনিয়ন/ওয়ার্ড</span>
                                    <span class="modal-data-value" id="mValUnionWard"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowVillageArea">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">গ্রাম/এলাকা</span>
                                    <span class="modal-data-value" id="mValVillageArea"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowPostOffice">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">ডাকঘর</span>
                                    <span class="modal-data-value" id="mValPostOffice"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowPostCode">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">পোস্ট কোড</span>
                                    <span class="modal-data-value" id="mValPostCode"></span>
                                </div>
                            </div>
                            <div class="col-12 modal-item" id="mRowFullAddress">
                                <div class="modal-data-row">
                                    <span class="modal-data-label d-block mb-1">পূর্ণ ঠিকানা</span>
                                    <span class="modal-data-value d-block fs-6" id="mValFullAddress"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Contact Channels info -->
                    <div class="col-12 modal-dynamic-sec" id="mSectionContact">
                        <h6 class="modal-section-title"><i class="fa-solid fa-address-book me-2"></i> যোগাযোগের মাধ্যমসমূহ</h6>
                        <div class="row bg-white rounded-3 shadow-sm px-3 py-2 border g-1">
                            <div class="col-12 col-sm-6 modal-item" id="mRowPhone">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">অফিসিয়াল মোবাইল</span>
                                    <span class="modal-data-value" id="mValPhone"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowAlternatePhone">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">বিকল্প মোবাইল</span>
                                    <span class="modal-data-value" id="mValAlternatePhone"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowEmergencyPhone">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">জরুরি যোগাযোগ</span>
                                    <span class="modal-data-value" id="mValEmergencyPhone"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowEmail">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">অফিসিয়াল ই-মেইল</span>
                                    <span class="modal-data-value text-lowercase" id="mValEmail"></span>
                                </div>
                            </div>
                            <div class="col-12 modal-item" id="mRowWebsite">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">অফিসিয়াল ওয়েবসাইট</span>
                                    <span class="modal-data-value text-lowercase" id="mValWebsite"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Leadership Profile -->
                    <div class="col-12 modal-dynamic-sec" id="mSectionHead">
                        <h6 class="modal-section-title"><i class="fa-solid fa-user-tie me-2"></i> প্রতিষ্ঠান প্রধানের তথ্য</h6>
                        <div class="row bg-white rounded-3 shadow-sm px-3 py-2 border g-1">
                            <div class="col-12 col-sm-6 modal-item" id="mRowHeadNameBn">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">প্রধানের নাম (বাংলা)</span>
                                    <span class="modal-data-value" id="mValHeadNameBn"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowHeadNameEn">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">প্রধানের নাম (ইংরেজি)</span>
                                    <span class="modal-data-value" id="mValHeadNameEn"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowHeadDesignationBn">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">পদবি (বাংলা)</span>
                                    <span class="modal-data-value" id="mValHeadDesignationBn"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 modal-item" id="mRowHeadDesignationEn">
                                <div class="modal-data-row d-flex justify-content-between">
                                    <span class="modal-data-label">পদবি (ইংরেজি)</span>
                                    <span class="modal-data-value" id="mValHeadDesignationEn"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Dynamic Online Network links -->
                    <div class="col-12 modal-dynamic-sec" id="mSectionSocial">
                        <h6 class="modal-section-title"><i class="fa-solid fa-globe me-2"></i> সোশ্যাল মিডিয়া লিঙ্কসমূহ</h6>
                        <div class="bg-white rounded-3 shadow-sm p-3 border">
                            <div id="modalSocialLinksContainer" class="d-flex flex-wrap gap-2">
                                <!-- Javascript dynamic social link blocks will render here -->
                            </div>
                        </div>
                    </div>

                    <!-- Section 6: Additional strategic details -->
                    <div class="col-12 modal-dynamic-sec" id="mSectionExtra">
                        <h6 class="modal-section-title"><i class="fa-solid fa-info-circle me-2"></i> অতিরিক্ত বিবরণী</h6>
                        <div class="row bg-white rounded-3 shadow-sm px-3 py-3 border g-3">
                            <div class="col-12 modal-item" id="mRowDescription">
                                <div class="modal-data-row pb-0 border-0">
                                    <span class="modal-data-label d-block mb-1">সংক্ষিপ্ত পরিচিতি</span>
                                    <span class="modal-data-value d-block fs-6 fw-normal text-muted" id="mValDescription"></span>
                                </div>
                            </div>
                            <div class="col-12 modal-item" id="mRowMission">
                                <div class="modal-data-row pb-0 border-0">
                                    <span class="modal-data-label d-block mb-1">আমাদের লক্ষ্য (Mission)</span>
                                    <span class="modal-data-value d-block fs-6 fw-normal text-muted" id="mValMission"></span>
                                </div>
                            </div>
                            <div class="col-12 modal-item" id="mRowVision">
                                <div class="modal-data-row pb-0 border-0">
                                    <span class="modal-data-label d-block mb-1">আমাদের উদ্দেশ্য (Vision)</span>
                                    <span class="modal-data-value d-block fs-6 fw-normal text-muted" id="mValVision"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-3 fw-bold shadow-sm" data-bs-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<!-- Spatie Authorization check for dynamic UI state protection -->
<script>
    const userPermissions = {
        canView: @json(auth()->user()->can('school_information.view')),
        canEdit: @json(auth()->user()->can('school_information.edit'))
    };

    let activeSocialCounter = 0;

    // Helper functions for Dynamic Modal Information Purging & Clean Rendering
    function setModalField(itemId, rowId, value) {
        const item = $('#' + itemId);
        const row = $('#' + rowId);
        
        if (value && value.toString().trim() !== '') {
            item.text(value);
            row.show();
            return true;
        } else {
            row.hide();
            return false;
        }
    }

    // Dynamic row rendering for Dynamic Social Grid Inputs
    function renderSocialRow(platform = '', icon = '', url = '') {
        const rowId = `social_row_${activeSocialCounter}`;
        const newRow = `
            <tr id="${rowId}" class="social-input-row">
                <td>
                    <input type="text" name="social_links[${activeSocialCounter}][platform]" class="form-control rounded-3" value="${escapeHtml(platform)}" placeholder="উদা: Facebook, YouTube, LinkedIn" required>
                </td>
                <td>
                    <input type="text" name="social_links[${activeSocialCounter}][icon]" class="form-control rounded-3" value="${escapeHtml(icon)}" placeholder="উদা: fa-brands fa-facebook" required>
                </td>
                <td>
                    <input type="url" name="social_links[${activeSocialCounter}][url]" class="form-control rounded-3" value="${escapeHtml(url)}" placeholder="https://..." required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm rounded-3 py-2 px-3 shadow-sm" onclick="removeSocialRow('${rowId}')"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
        `;
        $('#dynamicSocialContainer').append(newRow);
        activeSocialCounter++;
    }

    function removeSocialRow(rowId) {
        $('#' + rowId).remove();
    }

    // Prevent direct execution of unescaped HTML content injection inside dynamic tables
    function escapeHtml(text) {
        if (!text) return '';
        return text.toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // AJAX fetching core pipeline
    async function loadSchoolInformationDetails() {
        $('#pageScreenLoader').show();
        $('#mainWorkspace').hide();

        try {
            const response = await axios.get("{{ route('api.school-information.show') }}");
            if (response.data.status && response.data.data) {
                const school = response.data.data;
                
                // Form input pre-population
                $('#input_name_bn').val(school.name_bn);
                $('#input_name_en').val(school.name_en);
                $('#input_school_code').val(school.school_code);
                $('#input_eiin').val(school.eiin);
                $('#input_school_type').val(school.school_type);
                $('#input_management_type').val(school.management_type);
                $('#input_established_year').val(school.established_year);
                $('#input_recognition_no').val(school.recognition_no);
                
                if (school.recognition_date) {
                    const formattedDate = new Date(school.recognition_date).toISOString().split('T')[0];
                    $('#input_recognition_date').val(formattedDate);
                }

                $('#input_division').val(school.division);
                $('#input_district').val(school.district);
                $('#input_upazila').val(school.upazila);
                $('#input_union_ward').val(school.union_ward);
                $('#input_village_area').val(school.village_area);
                $('#input_post_office').val(school.post_office);
                $('#input_post_code').val(school.post_code);
                $('#input_address').val(school.address);

                $('#input_phone').val(school.phone);
                $('#input_alternate_phone').val(school.alternate_phone);
                $('#input_emergency_phone').val(school.emergency_phone);
                $('#input_email').val(school.email);
                $('#input_website').val(school.website);

                $('#input_head_name_bn').val(school.head_name_bn);
                $('#input_head_name_en').val(school.head_name_en);
                $('#input_head_designation_bn').val(school.head_designation_bn);
                $('#input_head_designation_en').val(school.head_designation_en);

                $('#input_motto').val(school.motto);
                $('#input_description').val(school.description);
                $('#input_mission').val(school.mission);
                $('#input_vision').val(school.vision);

                // Media previews assignments
                $('#formSquareLogoPreview').attr('src', school.logo_square_url);
                $('#formCircleLogoPreview').attr('src', school.logo_circle_url);
                $('#formFaviconPreview').attr('src', school.favicon_url);

                $('#sidePreviewSquareLogo').attr('src', school.logo_square_url);
                $('#modalSquareLogo').attr('src', school.logo_square_url);

                // Left Panel preview text updates
                $('#sidePreviewNameBn').text(school.name_bn || 'স্কুলের নাম পাওয়া যায়নি');
                $('#sidePreviewNameEn').text(school.name_en || 'School Name Not Configured');
                $('#sidePreviewEIIN').text(school.eiin || 'যোগ করা হয়নি');
                $('#sidePreviewType').text(school.school_type || 'যোগ করা হয়নি');
                $('#sidePreviewPhone').text(school.phone || 'যোগ করা হয়নি');
                $('#sidePreviewMotto').text(school.motto ? `"${school.motto}"` : '"এখানে প্রতিষ্ঠানের মূলমন্ত্র প্রদর্শিত হবে"');

                // Social Grid initialization
                $('#dynamicSocialContainer').empty();
                activeSocialCounter = 0;
                
                if (school.social_links && Array.isArray(school.social_links)) {
                    school.social_links.forEach(link => {
                        renderSocialRow(link.platform, link.icon, link.url);
                    });
                }

                // Hydrate details for the Information Profile modal
                hydrateModalProfile(school);

            } else {
                // If school information record does not exist, prepare clean initial state
                $('#formSquareLogoPreview').attr('src', "{{ asset('images/defaults/square-logo.png') }}");
                $('#formCircleLogoPreview').attr('src', "{{ asset('images/defaults/circle-logo.png') }}");
                $('#formFaviconPreview').attr('src', "{{ asset('images/defaults/favicon.ico') }}");
                $('#sidePreviewSquareLogo').attr('src', "{{ asset('images/defaults/square-logo.png') }}");

                $('#sidePreviewNameBn').text('নতুন প্রতিষ্ঠানের প্রোফাইল');
                $('#sidePreviewNameEn').text('Create School Profile');
                $('#sidePreviewEIIN').text('খালি');
                $('#sidePreviewType').text('খালি');
                $('#sidePreviewPhone').text('খালি');
                $('#sidePreviewMotto').text('"প্রতিষ্ঠানের মূলমন্ত্র এখনও সেট করা হয়নি"');
            }

            $('#pageScreenLoader').hide();
            $('#mainWorkspace').fadeIn(300);

        } catch (error) {
            $('#pageScreenLoader').hide();
            Swal.fire({
                icon: 'error',
                title: 'দুঃখিত!',
                text: 'সার্ভার থেকে প্রতিষ্ঠানের তথ্য লোড করা সম্ভব হয়নি। অনুগ্রহ করে রিফ্রেশ করে আবার চেষ্টা করুন।',
                confirmButtonColor: '#004d40'
            });
        }
    }

    // Modal Dynamic Purging pipeline
    function hydrateModalProfile(school) {
        $('#modalNameBn').text(school.name_bn || '');
        $('#modalNameEn').text(school.name_en || '');
        $('#modalMotto').text(school.motto ? `"${school.motto}"` : '"মূলমন্ত্র সেট করা হয়নি"');

        // Spatie Standard clean assignments & dynamic row state changes
        let sCodeVal = setModalField('mValSchoolCode', 'mRowSchoolCode', school.school_code);
        let eiinVal = setModalField('mValEIIN', 'mRowEIIN', school.eiin);
        let sTypeVal = setModalField('mValSchoolType', 'mRowSchoolType', school.school_type);
        let mTypeVal = setModalField('mValManagementType', 'mRowManagementType', school.management_type);
        let estVal = setModalField('mValEstablishedYear', 'mRowEstablishedYear', school.established_year);
        let recNoVal = setModalField('mValRecognitionNo', 'mRowRecognitionNo', school.recognition_no);
        
        let recDateStr = '';
        if (school.recognition_date) {
            recDateStr = new Date(school.recognition_date).toLocaleDateString('bn-BD', { year: 'numeric', month: 'long', day: 'numeric' });
        }
        let recDateVal = setModalField('mValRecognitionDate', 'mRowRecognitionDate', recDateStr);

        // Toggle entire Identity section if all rows inside are hidden
        if (!sCodeVal && !eiinVal && !sTypeVal && !mTypeVal && !estVal && !recNoVal && !recDateVal) {
            $('#mSectionIdentity').hide();
        } else {
            $('#mSectionIdentity').show();
        }

        // Location Section Mapping
        let divVal = setModalField('mValDivision', 'mRowDivision', school.division);
        let distVal = setModalField('mValDistrict', 'mRowDistrict', school.district);
        let upaVal = setModalField('mValUpazila', 'mRowUpazila', school.upazila);
        let unionVal = setModalField('mValUnionWard', 'mRowUnionWard', school.union_ward);
        let villVal = setModalField('mValVillageArea', 'mRowVillageArea', school.village_area);
        let poVal = setModalField('mValPostOffice', 'mRowPostOffice', school.post_office);
        let pcVal = setModalField('mValPostCode', 'mRowPostCode', school.post_code);
        let addrVal = setModalField('mValFullAddress', 'mRowFullAddress', school.address);

        if (!divVal && !distVal && !upaVal && !unionVal && !villVal && !poVal && !pcVal && !addrVal) {
            $('#mSectionLocation').hide();
        } else {
            $('#mSectionLocation').show();
        }

        // Contact Section Mapping
        let phoneVal = setModalField('mValPhone', 'mRowPhone', school.phone);
        let altPhoneVal = setModalField('mValAlternatePhone', 'mRowAlternatePhone', school.alternate_phone);
        let emVal = setModalField('mValEmergencyPhone', 'mRowEmergencyPhone', school.emergency_phone);
        let emailVal = setModalField('mValEmail', 'mRowEmail', school.email);
        let webVal = setModalField('mValWebsite', 'mRowWebsite', school.website);

        if (!phoneVal && !altPhoneVal && !emVal && !emailVal && !webVal) {
            $('#mSectionContact').hide();
        } else {
            $('#mSectionContact').show();
        }

        // Head Profile Section Mapping
        let hNameBn = setModalField('mValHeadNameBn', 'mRowHeadNameBn', school.head_name_bn);
        let hNameEn = setModalField('mValHeadNameEn', 'mRowHeadNameEn', school.head_name_en);
        let hDesBn = setModalField('mValHeadDesignationBn', 'mRowHeadDesignationBn', school.head_designation_bn);
        let hDesEn = setModalField('mValHeadDesignationEn', 'mRowHeadDesignationEn', school.head_designation_en);

        if (!hNameBn && !hNameEn && !hDesBn && !hDesEn) {
            $('#mSectionHead').hide();
        } else {
            $('#mSectionHead').show();
        }

        // Extra info strategic descriptions mapping
        let descVal = setModalField('mValDescription', 'mRowDescription', school.description);
        let missionVal = setModalField('mValMission', 'mRowMission', school.mission);
        let visionVal = setModalField('mValVision', 'mRowVision', school.vision);

        if (!descVal && !missionVal && !visionVal) {
            $('#mSectionExtra').hide();
        } else {
            $('#mSectionExtra').show();
        }

        // Render Social Networks Badges inside modal dynamically
        const socialLinksContainer = $('#modalSocialLinksContainer');
        socialLinksContainer.empty();

        if (school.social_links && Array.isArray(school.social_links) && school.social_links.length > 0) {
            school.social_links.forEach(link => {
                const iconClass = link.icon ? link.icon : 'fa-solid fa-link';
                const socialBadge = `
                    <a href="${escapeHtml(link.url)}" target="_blank" class="btn btn-outline-success rounded-pill py-2 px-3 shadow-sm d-flex align-items-center gap-2">
                        <i class="${escapeHtml(iconClass)}"></i>
                        <span class="fw-bold">${escapeHtml(link.platform)}</span>
                    </a>
                `;
                socialLinksContainer.append(socialBadge);
            });
            $('#mSectionSocial').show();
        } else {
            $('#mSectionSocial').hide();
        }
    }

    // Initialization scripts
    $(document).ready(function () {
        loadSchoolInformationDetails();

        // Standard Spatie checks for hiding edit layouts on render if missing permission
        if (userPermissions.canEdit) {
            $('#updateFormSubmitBtn').show();
        } else {
            // Disable all fields within form to prevent tampering attempts
            $('#schoolInformationUpdateForm input, #schoolInformationUpdateForm select, #schoolInformationUpdateForm textarea, #addNewSocialRowBtn').prop('disabled', true);
            $('#updateFormSubmitBtn').remove();
        }

        // Action script for dynamically binding row creation
        $('#addNewSocialRowBtn').on('click', function() {
            renderSocialRow();
        });

        // Live image previews changes triggers
        const registerPreviewTrigger = (inputId, previewId) => {
            $(`#${inputId}`).on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $(`#${previewId}`).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        };

        registerPreviewTrigger('logo_square_input', 'formSquareLogoPreview');
        registerPreviewTrigger('logo_circle_input', 'formCircleLogoPreview');
        registerPreviewTrigger('favicon_input', 'formFaviconPreview');

        // Master Ajax Submit update pipeline
        $('#schoolInformationUpdateForm').on('submit', async function(e) {
            e.preventDefault();

            if (!userPermissions.canEdit) {
                Swal.fire({
                    icon: 'error',
                    title: 'অনুমতি নেই!',
                    text: 'আপনার কাছে এই তথ্যগুলো পরিবর্তন করার প্রয়োজনীয় অনুমতি নেই।',
                    confirmButtonColor: '#004d40'
                });
                return;
            }

            const submitBtn = $('#updateFormSubmitBtn');
            const originalBtnHtml = submitBtn.html();

            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>সংরক্ষণ করা হচ্ছে...');
            
            // Clear any old validation styles
            $('.is-invalid').removeClass('is-invalid');

            // Build dynamic FormData payload wrapper
            const formData = new FormData(this);

            try {
                const response = await axios.post("{{ route('api.school-information.update') }}", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'সফল!',
                        text: response.data.message,
                        confirmButtonColor: '#004d40'
                    });
                    
                    // Re-render and update both layout forms and previews on page state securely
                    loadSchoolInformationDetails();
                }

            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    let errorMessagesHtml = '<ul class="text-start mb-0 ps-3">';
                    
                    // Match and highlights validated fields inputs internally
                    Object.keys(validationErrors).forEach(field => {
                        errorMessagesHtml += `<li class="text-danger small fw-semibold">${validationErrors[field][0]}</li>`;
                        
                        // Handle naming arrays fields
                        const matchingInput = $(`[name="${field}"]`);
                        if (matchingInput.length) {
                            matchingInput.addClass('is-invalid');
                        }
                    });
                    errorMessagesHtml += '</ul>';

                    Swal.fire({
                        icon: 'error',
                        title: 'ভ্যালিডেশন ব্যর্থ!',
                        html: errorMessagesHtml,
                        confirmButtonColor: '#004d40'
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ত্রুটি!',
                        text: error.response?.data?.message || 'সার্ভারে রিকোয়েস্ট প্রক্রিয়াকরণ করা সম্ভব হয়নি। অনুগ্রহ করে পুনরায় চেষ্টা করুন।',
                        confirmButtonColor: '#004d40'
                    });
                }
            } finally {
                submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    });
</script>
@endpush