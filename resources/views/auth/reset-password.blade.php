@extends('layouts.app')

@section('title', config('app.name', 'School ERP') . ' || Reset Password')

@push('styles')
<style>
    /* Premium Academic Theme Colors */
    :root {
        --academic-green: #004d40;      /* Traditional Bangladeshi School Green */
        --academic-green-dark: #00251a;
        --academic-gold: #ffc107;        /* Traditional Academic Gold */
        --academic-text-muted: #6c757d;
    }

    body {
        background: radial-gradient(circle at 50% 50%, var(--academic-green) 0%, var(--academic-green-dark) 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    /* Responsive sizing rules for premium layout consistency */
    @media (max-width: 575.98px) {
        .card-responsive { 
            border-radius: 16px !important; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
            padding: 1.5rem !important; /* Compact padding for mobile viewports */
        }
        .container-responsive { padding-left: 12px !important; padding-right: 12px !important; }
        .title-responsive { font-size: 1.4rem !important; }
    }
    @media (min-width: 576px) and (max-width: 991.98px) {
        .card-responsive { 
            border-radius: 20px !important; 
            box-shadow: 0 15px 40px rgba(0,0,0,0.25) !important; 
            padding: 2.25rem !important;
        }
        .title-responsive { font-size: 1.6rem !important; }
    }
    @media (min-width: 992px) {
        .card-responsive { 
            border-radius: 28px !important; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important; 
            padding: 3rem !important;
        }
    }
    
    /* Elegant Institutional Seal Placeholder styling */
    .school-seal-wrapper {
        width: 80px;
        height: 80px;
        border: 3px double var(--academic-gold);
        background: var(--academic-green);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    /* Soft focus inputs for classic experience */
    .form-control-academic {
        border: 1px solid #ced4da;
        transition: all 0.25s ease-in-out;
    }

    .form-control-academic:focus {
        border-color: var(--academic-green) !important;
        box-shadow: 0 0 0 0.25rem rgba(0, 77, 64, 0.15) !important;
    }
    
    .password-toggle-btn { 
        background: transparent; 
        border-left: none; 
        color: var(--academic-text-muted); 
        transition: color 0.2s ease-in-out; 
    }
    .password-toggle-btn:hover { 
        color: var(--academic-green); 
        background: transparent; 
    }
    .password-input-field { 
        border-right: none; 
    }

    /* Submit button custom academic primary hover styles */
    .btn-academic {
        background-color: var(--academic-green);
        border-color: var(--academic-green);
        color: #ffffff;
        transition: all 0.2s ease-in-out;
    }

    .btn-academic:hover, .btn-academic:focus {
        background-color: var(--academic-green-dark);
        border-color: var(--academic-green-dark);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 77, 64, 0.2);
    }

    /* Dynamic Password Requirements card wrapper styling */
    #password-requirements {
        border: 1px dashed #ced4da;
        background-color: #fcfdfe;
        transition: all 0.3s ease-in-out;
    }
    .requirement-item {
        transition: all 0.2s ease-in-out;
    }
</style>
@endpush

@section('content')
<div class="container container-responsive">
    <div class="row justify-content-center align-items-center min-vh-100 py-3 py-sm-4 py-md-5">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
            
            <!-- Reusable Institutional Card Frame -->
            <div class="card border-0 card-responsive bg-white">
                <div class="card-body">
                    
                    <!-- Bangladesh School Crest & Identity Header -->
                    <div class="text-center mb-4">
                        <div class="school-seal-wrapper">
                            <i class="fa-solid fa-lock-open fs-2"></i>
                        </div>
                        <h2 class="fw-bold mt-2 title-responsive text-dark m-0">{{ config('app.name', 'School ERP') }}</h2>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1.5 mt-2 small">
                            নতুন পাসওয়ার্ড তৈরি করুন (Reset Password)
                        </span>
                        <p class="text-muted small mt-3">নিরাপত্তার স্বার্থে একটি শক্তিশালী পাসওয়ার্ড নির্বাচন করুন।</p>
                    </div>

                    <!-- AJAX Form Gateway -->
                    <form id="resetPasswordForm" novalidate>
                        
                        <!-- Secure token handler from route -->
                        <input type="hidden" id="token" name="token" value="{{ $token ?? request()->route('token') }}">

                        <!-- Email field (Prefilled or User Entered) -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" class="form-control form-control-lg rounded-end-3 form-control-academic fs-6" id="email" name="email" value="{{ $email ?? request()->query('email') }}" placeholder="আপনার ইমেইল এড্রেস" required readonly>
                            </div>
                            <!-- Safe placement outside input-group for stable corners -->
                            <div class="text-danger small d-none mt-1" id="error-email"></div>
                        </div>

                        <!-- New Password input -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-secondary">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" class="form-control form-control-lg password-input-field form-control-academic fs-6" id="password" name="password" placeholder="••••••••" required>
                                <button class="btn btn-outline-secondary password-toggle-btn rounded-end-3 border-start-0" type="button" id="togglePassword">
                                   <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            
                            <!-- Dynamic Real-Time Password Requirements Assistant Wrapper -->
                            <div id="password-requirements" class="mt-3 p-3 rounded-3 d-none">
                                <p class="fw-semibold small text-dark mb-2">
                                    <i class="fa-solid fa-circle-info text-primary me-2"></i>Password Rules (পাসওয়ার্ডের নিয়মাবলী):
                                </p>
                                <ul class="list-unstyled mb-0" style="font-size: 13.5px;">
                                    <li id="req-length" class="requirement-item text-muted mb-1.5">
                                        <i class="fa-solid fa-circle-dot me-2"></i>At least 8 characters (কমপক্ষে ৮টি অক্ষর)
                                    </li>
                                    <li id="req-case" class="requirement-item text-muted mb-1.5">
                                        <i class="fa-solid fa-circle-dot me-2"></i>Uppercase & lowercase letters (বড় ও ছোট হাতের অক্ষর)
                                    </li>
                                    <li id="req-number" class="requirement-item text-muted mb-1.5">
                                        <i class="fa-solid fa-circle-dot me-2"></i>At least one number (কমপক্ষে একটি সংখ্যা)
                                    </li>
                                    <li id="req-symbol" class="requirement-item text-muted mb-0">
                                        <i class="fa-solid fa-circle-dot me-2"></i>At least one special character (একটি বিশেষ চিহ্ন - @, #, $, %)
                                    </li>
                                </ul>
                            </div>

                            <!-- Safe placement outside input-group for stable corners -->
                            <div class="text-danger small d-none mt-2" id="error-password"></div>
                        </div>

                        <!-- Confirm Password input -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-circle-check"></i></span>
                                <input type="password" class="form-control form-control-lg password-input-field form-control-academic fs-6" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                                <button class="btn btn-outline-secondary password-toggle-btn rounded-end-3 border-start-0" type="button" id="toggleConfirmPassword">
                                   <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            <!-- Safe placement outside input-group for stable corners -->
                            <div class="text-danger small d-none mt-1" id="error-password_confirmation"></div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-academic btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn">
                                পাসওয়ার্ড পরিবর্তন করুন (Reset Password)
                            </button>
                        </div>
                    </form>

                    <!-- Institution Motto / National Academic Tagline Footer -->
                    <div class="text-center mt-5 border-top pt-3">
                        <span class="text-muted small italic" style="font-size: 13px;">
                            <i class="fa-solid fa-book-open text-warning me-1"></i> জ্ঞানই আলো (Knowledge is Light)
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Prevent caching issues (BFCache Back-Button Loader bug) [1]
window.addEventListener('pageshow', function (event) {
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'পাসওয়ার্ড পরিবর্তন করুন (Reset Password)';
    }
});

// 1. Dual Password Visibility Toggle Functionality
const setupPasswordToggle = (inputId, buttonId) => {
    const passwordInput = document.getElementById(inputId);
    const toggleBtn = document.getElementById(buttonId);
    const icon = toggleBtn.querySelector('i');

    toggleBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !isPassword);
        icon.classList.toggle('fa-eye-slash', isPassword);
    });
};

setupPasswordToggle('password', 'togglePassword');
setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');

// 2. Real-Time Dynamic Password Helper Indicator Logic
const updateRequirementStatus = (selector, isValid) => {
    const item = $(selector);
    const icon = item.find('i');

    if (isValid) {
        item.removeClass('text-muted text-danger').addClass('text-success fw-semibold');
        icon.removeClass('fa-circle-dot fa-circle-xmark').addClass('fa-circle-check');
    } else {
        item.removeClass('text-success fw-semibold').addClass('text-muted');
        icon.removeClass('fa-circle-check fa-circle-xmark').addClass('fa-circle-dot');
    }
};

// Reveal suggestion panel on input focus
$('#password').on('focus', function() {
    $('#password-requirements').removeClass('d-none');
});

// Capture keystrokes dynamically [4]
$('#password').on('input', function() {
    const val = $(this).val();

    if (val === '') {
        $('.requirement-item').removeClass('text-success text-danger fw-semibold').addClass('text-muted');
        $('.requirement-item i').removeClass('fa-circle-check fa-circle-xmark').addClass('fa-circle-dot');
        return;
    }

    // Process criteria in real-time
    updateRequirementStatus('#req-length', val.length >= 8);
    updateRequirementStatus('#req-case', /[a-z]/.test(val) && /[A-Z]/.test(val));
    updateRequirementStatus('#req-number', /[0-9]/.test(val));
    updateRequirementStatus('#req-symbol', /[^a-zA-Z0-9]/.test(val));
});

// 3. Client-Side (Frontend) Security Validation Check (Before Submission)
const validateResetPasswordForm = () => {
    let isValid = true;
    
    // Reset former validation visuals safely
    $('.is-invalid').removeClass('is-invalid');
    $('#error-email, #error-password, #error-password_confirmation').addClass('d-none').text('');

    const newPass = $('#password').val().trim();
    const confirmPass = $('#password_confirmation').val().trim();

    // Validate Password Complexities via Frontend JS [4]
    if (!newPass) {
        $('#password').addClass('is-invalid');
        $('#error-password').removeClass('d-none').text('New password is required.');
        isValid = false;
    } else {
        const isLen = newPass.length >= 8;
        const isCase = /[a-z]/.test(newPass) && /[A-Z]/.test(newPass);
        const isNum = /[0-9]/.test(newPass);
        const isSym = /[^a-zA-Z0-9]/.test(newPass);

        // Highlight requirements in danger red if submit fails
        if (!isLen || !isCase || !isNum || !isSym) {
            $('#password').addClass('is-invalid');
            $('#error-password').removeClass('d-none').text('The new password does not meet our safety guidelines.');
            
            if (!isLen) $('#req-length').removeClass('text-muted').addClass('text-danger fw-semibold').find('i').removeClass('fa-circle-dot').addClass('fa-circle-xmark');
            if (!isCase) $('#req-case').removeClass('text-muted').addClass('text-danger fw-semibold').find('i').removeClass('fa-circle-dot').addClass('fa-circle-xmark');
            if (!isNum) $('#req-number').removeClass('text-muted').addClass('text-danger fw-semibold').find('i').removeClass('fa-circle-dot').addClass('fa-circle-xmark');
            if (!isSym) $('#req-symbol').removeClass('text-muted').addClass('text-danger fw-semibold').find('i').removeClass('fa-circle-dot').addClass('fa-circle-xmark');

            isValid = false;
        }
    }

    // Check confirmation field matching
    if (newPass && newPass !== confirmPass) {
        $('#password_confirmation').addClass('is-invalid');
        $('#error-password_confirmation').removeClass('d-none').text('The confirmation password does not match.');
        isValid = false;
    }

    return isValid;
};

// 4. Ajax-based Axios Password Reset Submission
document.getElementById('resetPasswordForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    
    // Fire local validations first
    if (!validateResetPasswordForm()) {
        return false;
    }

    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>আপডেট করা হচ্ছে...';
    
    const formData = {
        token: document.getElementById('token').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('password_confirmation').value
    };

    try {
        let res = await axios.post('/api/reset-password', formData);
        
        if (res.data.status === true || res.status === 200) {
            // CRITICAL FIX: Instantly clear out any stale tokens to break login redirect loops
            localStorage.removeItem('auth_token');

            Swal.fire({
                icon: 'success',
                title: 'সফল হয়েছে!',
                text: res.data.message || 'আপনার পাসওয়ার্ড সফলভাবে পরিবর্তিত হয়েছে।',
                confirmButtonColor: '#004d40',
                willClose: () => {
                    // Redirect back to login screen cleanly
                    window.location.href = '/login';
                }
            });
        }
    } catch (error) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'পাসওয়ার্ড পরিবর্তন করুন (Reset Password)';

        if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            const message = error.response.data.message;

            // Map server-side validation errors dynamically
            if (errors) {
                Object.keys(errors).forEach(key => {
                    const input = document.getElementById(key);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = document.getElementById('error-' + key);
                        if (feedback) {
                            feedback.classList.remove('d-none'); // Show error
                            feedback.innerHTML = errors[key][0];
                        }
                    }
                });
            }

            Swal.fire({
                icon: 'warning',
                title: 'অনুরোধ ব্যর্থ হয়েছে',
                text: message || 'অনুগ্রহ করে তথ্যগুলো পুনরায় পরীক্ষা করুন।',
                confirmButtonColor: '#004d40'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি ঘটেছে',
                text: error.response?.data?.message || 'পাসওয়ার্ড রিসেট করতে সমস্যা হয়েছে। পুনরায় চেষ্টা করুন।',
                confirmButtonColor: '#004d40'
            });
        }
    }
});
</script>
@endpush