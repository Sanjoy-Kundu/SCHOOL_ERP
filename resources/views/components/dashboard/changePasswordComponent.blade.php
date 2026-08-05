@push('styles')
<style>
    /* Responsive Styles for Account Safety Grid across Mobile, Tablets & Desktops */
    @media (max-width: 575.98px) {
        .card-responsive { 
            border-radius: 12px !important; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important; 
            padding: 1.5rem !important; /* Compact padding for small mobile devices */
        }
        .container-responsive { 
            padding-left: 10px !important; 
            padding-right: 10px !important; 
        }
    }
    @media (min-width: 576px) and (max-width: 991.98px) {
        .card-responsive {
            padding: 2.25rem !important; /* Optimal spacing for tablets */
        }
    }
    @media (min-width: 992px) {
        .card-responsive {
            padding: 3rem !important; /* Luxurious padding for desktop viewports */
        }
    }
    
    .profile-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #edf2f9;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .form-control-academic {
        border: 1px solid #ced4da;
        transition: all 0.25s ease-in-out;
    }

    .form-control-academic:focus {
        border-color: #004d40 !important; /* Classic Bangladeshi School Green */
        box-shadow: 0 0 0 0.25rem rgba(0, 77, 64, 0.15) !important;
    }

    .password-toggle-btn { 
        background: #f8f9fa; 
        border-left: none; 
        color: #6c757d; 
        transition: all 0.2s ease-in-out; 
    }
    .password-toggle-btn:hover { 
        color: #004d40; 
        background: #f1f3f5; 
    }
    .password-input-field { 
        border-right: none; 
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


<!-- Page Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Account Security</h1>
        <p class="text-muted small mb-0">পাসওয়ার্ড পরিবর্তন ও অ্যাকাউন্ট নিরাপত্তা নিয়ন্ত্রণ প্যানেল।</p>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Change Password Form (Responsive bootstrap columns) -->
    <div class="col-12 col-lg-7">
        <div class="card profile-card card-responsive">
            <h5 class="fw-bold text-dark mb-4">
                <i class="fa-solid fa-shield-halved text-success me-2"></i>Change Security Password
            </h5>

            <!-- Axios API Gate Form with Native Validation Interceptors -->
            <form id="changePasswordForm" novalidate>
                
                <!-- 1. Current Password Input -->
                <div class="mb-3">
                    <label for="current_password" class="form-label fw-semibold small text-secondary">Current Password (বর্তমান পাসওয়ার্ড)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control form-control-lg password-input-field form-control-academic fs-6" id="current_password" name="current_password" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary password-toggle-btn rounded-end-3 border-start-0" type="button" id="toggleCurrentPassword">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="text-danger small d-none mt-1" id="error-current_password"></div>
                </div>

                <!-- 2. New Password Input -->
                <div class="mb-3">
                    <label for="new_password" class="form-label fw-semibold small text-secondary">New Password (নতুন পাসওয়ার্ড)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-key"></i></span>
                        <input type="password" class="form-control form-control-lg password-input-field form-control-academic fs-6" id="new_password" name="new_password" placeholder="Min 8 characters with mixed characters" required>
                        <button class="btn btn-outline-secondary password-toggle-btn rounded-end-3 border-start-0" type="button" id="toggleNewPassword">
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

                    <div class="text-danger small d-none mt-2" id="error-new_password"></div>
                </div>

                <!-- 3. Confirm New Password Input -->
                <div class="mb-4">
                    <label for="new_password_confirmation" class="form-label fw-semibold small text-secondary">Confirm New Password (পাসওয়ার্ড নিশ্চিত করুন)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-circle-check"></i></span>
                        <input type="password" class="form-control form-control-lg password-input-field form-control-academic fs-6" id="new_password_confirmation" name="new_password_confirmation" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary password-toggle-btn rounded-end-3 border-start-0" type="button" id="toggleConfirmPassword">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="text-danger small d-none mt-1" id="error-new_password_confirmation"></div>
                </div>

                <!-- Submit Button Grid (Responsive layout) -->
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2.5 rounded-3 fw-bold flex-grow-1 flex-sm-grow-0" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                        Update Security Password
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-light px-4 py-2.5 rounded-3 fw-bold border text-secondary flex-grow-1 flex-sm-grow-0 text-center">
                        Back to Dashboard
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Right Column: Institutional Security Notice -->
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="fa-solid fa-circle-info me-2 text-warning"></i>Security Advisory
            </h5>
            <div class="alert alert-warning border-0 small bg-warning-subtle text-warning-emphasis p-3 rounded-3">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <strong>গুরুত্বপূর্ণ নির্দেশনাবলী:</strong> প্রাতিষ্ঠানিক গোপনীয়তা রক্ষা করতে নিচের নির্দেশনাগুলো অনুসরণ করুন।
            </div>
            
            <ul class="list-group list-group-flush small">
                <li class="list-group-item border-0 px-0 py-2.5 text-muted">
                    <i class="fa-solid fa-circle-dot text-primary me-2"></i>Do not use easily guessable passwords like school code, phone number, or simple names.
                </li>
                <li class="list-group-item border-0 px-0 py-2.5 text-muted">
                    <i class="fa-solid fa-circle-dot text-primary me-2"></i>Never share your administrative/academic password with parents, students, or other non-authorized staff.
                </li>
                <li class="list-group-item border-0 px-0 py-2.5 text-muted">
                    <i class="fa-solid fa-circle-dot text-primary me-2"></i>Keep a mix of upper/lower case letters, numbers, and symbols to ensure dynamic password hardness.
                </li>
            </ul>
        </div>
    </div>
</div>


@push('scripts')
<script>
$(document).ready(function() {
    
    // 1. Unified Password Toggle Visibility Logic
    const initPasswordToggle = (inputId, buttonId) => {
        const input = $('#' + inputId);
        const btn = $('#' + buttonId);
        const icon = btn.find('i');

        btn.on('click', function() {
            const isPassword = input.attr('type') === 'password';
            input.attr('type', isPassword ? 'text' : 'password');
            icon.toggleClass('fa-eye', !isPassword);
            icon.toggleClass('fa-eye-slash', isPassword);
        });
    };

    initPasswordToggle('current_password', 'toggleCurrentPassword');
    initPasswordToggle('new_password', 'toggleNewPassword');
    initPasswordToggle('new_password_confirmation', 'toggleConfirmPassword');

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

    // Show suggestion box on focus
    $('#new_password').on('focus', function() {
        $('#password-requirements').removeClass('d-none');
    });

    // Check complexities on keystroke
    $('#new_password').on('input', function() {
        const val = $(this).val();

        if (val === '') {
            $('.requirement-item').removeClass('text-success text-danger fw-semibold').addClass('text-muted');
            $('.requirement-item i').removeClass('fa-circle-check fa-circle-xmark').addClass('fa-circle-dot');
            return;
        }

        // Apply rules dynamically [4]
        updateRequirementStatus('#req-length', val.length >= 8);
        updateRequirementStatus('#req-case', /[a-z]/.test(val) && /[A-Z]/.test(val));
        updateRequirementStatus('#req-number', /[0-9]/.test(val));
        updateRequirementStatus('#req-symbol', /[^a-zA-Z0-9]/.test(val));
    });

    // 3. Client-Side (Frontend) Security Validation Check (Before Submission)
    const validateChangePasswordForm = () => {
        let isValid = true;
        
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').addClass('d-none').text('');

        const currentPass = $('#current_password').val().trim();
        const newPass = $('#new_password').val().trim();
        const confirmPass = $('#new_password_confirmation').val().trim();

        // Validate Current Password field
        if (!currentPass) {
            $('#current_password').addClass('is-invalid');
            $('#error-current_password').removeClass('d-none').text('Please enter your current active password.');
            isValid = false;
        }

        // Validate New Password rules
        if (!newPass) {
            $('#new_password').addClass('is-invalid');
            $('#error-new_password').removeClass('d-none').text('New password is required.');
            isValid = false;
        } else {
            const isLen = newPass.length >= 8;
            const isCase = /[a-z]/.test(newPass) && /[A-Z]/.test(newPass);
            const isNum = /[0-9]/.test(newPass);
            const isSym = /[^a-zA-Z0-9]/.test(newPass);

            // Highlight failed requirements in red if user attempts invalid submit
            if (!isLen || !isCase || !isNum || !isSym) {
                $('#new_password').addClass('is-invalid');
                $('#error-new_password').removeClass('d-none').text('The new password does not meet our institutional requirements.');
                
                // Show unsatisfy markers as danger
                if (!isLen) $('#req-length').removeClass('text-muted').addClass('text-danger fw-semibold').find('i').removeClass('fa-circle-dot').addClass('fa-circle-xmark');
                if (!isCase) $('#req-case').removeClass('text-muted').addClass('text-danger fw-semibold').find('i').removeClass('fa-circle-dot').addClass('fa-circle-xmark');
                if (!isNum) $('#req-number').removeClass('text-muted').addClass('text-danger fw-semibold').find('i').removeClass('fa-circle-dot').addClass('fa-circle-xmark');
                if (!isSym) $('#req-symbol').removeClass('text-muted').addClass('text-danger fw-semibold').find('i').removeClass('fa-circle-dot').addClass('fa-circle-xmark');

                isValid = false;
            }
        }

        // Validate Password Confirmation field match
        if (newPass && newPass !== confirmPass) {
            $('#new_password_confirmation').addClass('is-invalid');
            $('#error-new_password_confirmation').removeClass('d-none').text('New password confirmation does not match.');
            isValid = false;
        }

        return isValid;
    };

    // 4. Form Submission via Axios
    $('#changePasswordForm').on('submit', async function(e) {
        e.preventDefault();

        // Fire local validations first
        if (!validateChangePasswordForm()) {
            return false;
        }

        const submitBtn = $('#submitBtn');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating Password...');

        const payload = {
            current_password: $('#current_password').val(),
            new_password: $('#new_password').val(),
            new_password_confirmation: $('#new_password_confirmation').val()
        };

        try {
            const res = await axios.post('/api/auth/change-password', payload);

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: 'পাসওয়ার্ড সফলভাবে পরিবর্তিত!',
                    text: res.data.message || 'Your security password has been changed successfully.',
                    confirmButtonColor: '#004d40'
                }).then(() => {
                    window.location.href = "{{ route('dashboard') }}";
                });
            }
        } catch (error) {
            submitBtn.prop('disabled', false).text('Update Security Password');

            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                const generalMessage = error.response.data.message;

                // Bind server side validation errors to input fields (Fallback/Sync errors)
                if (errors && errors.current_password) {
                    $('#current_password').addClass('is-invalid');
                    $('#error-current_password').removeClass('d-none').text(errors.current_password[0]);
                }

                if (errors && errors.new_password) {
                    $('#new_password').addClass('is-invalid');
                    $('#error-new_password').removeClass('d-none').text(errors.new_password[0]);
                }

                if (generalMessage && !errors) {
                    $('#current_password').addClass('is-invalid');
                    $('#error-current_password').removeClass('d-none').text(generalMessage);
                }
                
                Swal.fire({
                    icon: 'warning',
                    title: 'হালনাগাদ ব্যর্থ হয়েছে',
                    text: generalMessage || 'Please correct the validation errors.',
                    confirmButtonColor: '#004d40'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'সিস্টেম ত্রুটি',
                    text: error.response?.data?.message || 'An unexpected server-side error occurred.',
                    confirmButtonColor: '#d33'
                });
            }
        }
    });
});
</script>
@endpush