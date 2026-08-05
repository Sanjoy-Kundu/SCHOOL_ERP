@extends('layouts.app')

@section('title', config('app.name', 'School ERP') . ' || Forgot Password')

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
        .card-responsive { border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important; }
        .container-responsive { padding-left: 12px !important; padding-right: 12px !important; }
        .title-responsive { font-size: 1.4rem !important; }
    }
    @media (min-width: 576px) and (max-width: 991.98px) {
        .card-responsive { border-radius: 20px !important; box-shadow: 0 15px 40px rgba(0,0,0,0.25) !important; }
        .title-responsive { font-size: 1.6rem !important; }
    }
    @media (min-width: 992px) {
        .card-responsive { border-radius: 28px !important; box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important; }
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
</style>
@endpush

@section('content')
<div class="container container-responsive">
    <div class="row justify-content-center align-items-center min-vh-100 py-3 py-sm-4 py-md-5">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
            
            <!-- Reusable Institutional Card Frame -->
            <div class="card border-0 card-responsive bg-white">
                <div class="card-body p-4 p-sm-5">
                    
                    <!-- Bangladesh School Crest & Identity Header -->
                    <div class="text-center mb-4">
                        <div class="school-seal-wrapper">
                            <i class="fa-solid fa-key fs-2"></i>
                        </div>
                        <h2 class="fw-bold mt-2 title-responsive text-dark m-0">{{ config('app.name', 'School ERP') }}</h2>
                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-1.5 mt-2 small">
                            পাসওয়ার্ড পুনরুদ্ধার (Password Recovery)
                        </span>
                        <p class="text-muted small mt-3">আপনার রেজিস্টার্ড ইমেইল এড্রেসটি নিচে লিখুন। আমরা আপনাকে পাসওয়ার্ড রিসেট করার একটি লিংক পাঠাবো।</p>
                    </div>

                    <!-- AJAX Form Gateway -->
                    <form id="forgotPasswordForm" novalidate>
                        
                        <!-- Email input handler -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" class="form-control form-control-lg rounded-end-3 form-control-academic fs-6" id="email" name="email" placeholder="আপনার ইমেইল এড্রেস" required>
                            </div>
                            <!-- Stable Error Container outside Input Group to keep perfect corner radius -->
                            <div class="text-danger small d-none mt-1" id="error-email"></div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-academic btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn">
                                রিসেট লিংক পাঠান (Send Reset Link)
                            </button>
                        </div>

                        <!-- Back to login link -->
                        <div class="text-center mt-3">
                            <a href="{{ url('/login') }}" class="small text-decoration-none fw-semibold" style="color: var(--academic-green);">
                                <i class="fa-solid fa-arrow-left-long me-1"></i> লগইন পেজে ফিরে যান (Back to Login)
                            </a>
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
        submitBtn.innerHTML = 'রিসেট লিংক পাঠান (Send Reset Link)';
    }
});

// Dynamic Ajax-based Axios Forgot Password Submission
document.getElementById('forgotPasswordForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    
    const emailInput = document.getElementById('email');
    const emailErr = document.getElementById('error-email');
    const submitBtn = document.getElementById('submitBtn');
    
    // Clear previous dynamic validation errors
    emailInput.classList.remove('is-invalid');
    emailErr.classList.add('d-none');
    emailErr.innerHTML = '';

    const emailValue = emailInput.value.trim();

    // 1. Client-Side Email format validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailValue) {
        emailInput.classList.add('is-invalid');
        emailErr.classList.remove('d-none');
        emailErr.innerHTML = 'Please enter your email address.';
        return false;
    } else if (!emailRegex.test(emailValue)) {
        emailInput.classList.add('is-invalid');
        emailErr.classList.remove('d-none');
        emailErr.innerHTML = 'Please provide a valid email format (e.g. user@school.com).';
        return false;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>পাঠানো হচ্ছে...';

    const formData = {
        email: emailValue
    };

    try {
        // Send request to API Forgot Password Endpoint
        let res = await axios.post('/api/forgot-password', formData);
        
        if (res.data.status === true || res.status === 200) {
            // SECURITY: Instantly clear out any stale local tokens before redirecting
            localStorage.removeItem('auth_token');

            Swal.fire({
                icon: 'success',
                title: 'সফল হয়েছে!',
                text: res.data.message || 'আপনার ইমেইলে পাসওয়ার্ড রিসেট লিংক পাঠানো হয়েছে।',
                confirmButtonColor: '#004d40',
                willClose: () => {
                    // Redirect back to login screen cleanly
                    window.location.href = '/login';
                }
            });
        }
    } catch (error) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'রিসেট লিংক পাঠান (Send Reset Link)';

        if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            const message = error.response.data.message;

            // Handle server-side validation errors for email field
            if (errors && errors.email) {
                emailInput.classList.add('is-invalid');
                if (emailErr) {
                    emailErr.classList.remove('d-none');
                    emailErr.innerHTML = errors.email[0];
                }
            }

            Swal.fire({
                icon: 'warning',
                title: 'অনুরোধ ব্যর্থ হয়েছে',
                text: message || 'অনুগ্রহ করে সঠিক ইমেইল এড্রেস প্রদান করুন।',
                confirmButtonColor: '#004d40'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি ঘটেছে',
                text: error.response?.data?.message || 'লিংক পাঠাতে সমস্যা হয়েছে। পুনরায় চেষ্টা করুন।',
                confirmButtonColor: '#004d40'
            });
        }
    }
});
</script>
@endpush