@extends('layouts.app')

@section('title', config('app.name', 'School ERP') . ' || Portal Log In')

@push('styles')
<style>
    /* Premium Academic Theme Colors */
    :root {
        --academic-green: #004d40;      /* Traditional School Green */
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
                            <i class="fa-solid fa-graduation-cap fs-2"></i>
                        </div>
                        <h2 class="fw-bold mt-2 title-responsive text-dark m-0">{{ config('app.name', 'School ERP') }}</h2>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1.5 mt-2 small">
                            শিক্ষক, শিক্ষার্থী ও অভিভাবক পোর্টাল
                        </span>
                    </div>

                    <!-- Dynamic Session Messages (e.g. Email verification success) -->
                    @if(session('success'))
                        <div class="alert alert-success rounded-3 small mb-3 border-0 shadow-sm" style="background-color: #d1e7dd; color: #0f5132;">
                            <i class="fa-solid fa-circle-check me-2 text-success"></i>{{ session('success') }}
                        </div>
                    @endif

                    <!-- AJAX Form Gateway -->
                    <form id="loginForm" novalidate>
                        
                        <!-- Dynamic credentials handler -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold small text-secondary">Username, Email, or Mobile</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-user-tie"></i></span>
                                <input type="text" class="form-control form-control-lg rounded-end-3 form-control-academic fs-6" id="username" name="username" placeholder="ইমেল, ইউজারনেম বা মোবাইল নম্বর" required>
                            </div>
                            <!-- Stable Error Container outside Input Group -->
                            <div class="text-danger small d-none mt-1" id="error-username"></div>
                        </div>

                        <!-- Secure password state with visibility controller -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" class="form-control form-control-lg password-input-field form-control-academic fs-6" id="password" name="password" placeholder="••••••••" required>
                                <button class="btn btn-outline-secondary password-toggle-btn rounded-end-3 border-start-0" type="button" id="togglePassword">
                                   <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            <!-- Stable Error Container outside Input Group -->
                            <div class="text-danger small d-none mt-1" id="error-password"></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label small text-muted" for="remember">
                                    মনে রাখুন (Remember me)
                                </label>
                            </div>
                            <a href="{{ url('/forgot-password') }}" class="small text-decoration-none fw-semibold" style="color: var(--academic-green);">পাসওয়ার্ড ভুলে গেছেন?</a>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-academic btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn">
                                পোর্টালে প্রবেশ করুন (Sign In)
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
// Prevent caching issues (BFCache Back-Button Loader bug) and auto-redirect already logged-in users [1]
window.addEventListener('pageshow', function (event) {
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        // Reset the sign-in button state to active
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'পোর্টালে প্রবেশ করুন (Sign In)';
    }

    // Auto-redirect to dashboard if token already exists in localStorage
    if (localStorage.getItem('auth_token')) {
        window.location.href = '/dashboard';
    }
});

// 1. Password Visibility Toggle Functionality
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

// 2. Dynamic Redirect Parameter Query Forwarding
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const redirectVal = urlParams.get('redirect');
    
    if (redirectVal) {
        const registerLink = document.getElementById('registerLink');
        if (registerLink) {
            registerLink.href = `/default/register?redirect=${encodeURIComponent(redirectVal)}`;
        }
    }
});

// 3. Dynamic Ajax-based Axios Login Submission
document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>যাচাই করা হচ্ছে...';
    
    // Clear previous dynamic validation errors on submission trigger
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    const usernameErr = document.getElementById('error-username');
    const passErr = document.getElementById('error-password');
    
    usernameErr.classList.add('d-none');
    usernameErr.innerHTML = '';
    passErr.classList.add('d-none');
    passErr.innerHTML = '';

    const formData = {
        username: document.getElementById('username').value, 
        password: document.getElementById('password').value,
        remember: document.getElementById('remember').checked
    };

    try {
        // Post secure credentials request to API Login Endpoint
        let res = await axios.post('/api/auth/login', formData);
        
        if (res.data.status === true) {
            // Save newly issued Sanctum Token to browser localStorage
            localStorage.setItem('auth_token', res.data.token);

            // Read the redirect path from query param safely
            const urlParams = new URLSearchParams(window.location.search);
            const redirectVal = urlParams.get('redirect');
            
            // Core Security Guard: Prevent Open Redirect Vulnerabilities
            let destinationUrl = '/dashboard';
            if (redirectVal && redirectVal.startsWith('/')) {
                destinationUrl = redirectVal;
            }

            Swal.fire({
                icon: 'success',
                title: 'স্বাগতম!',
                text: 'পোর্টালে সফলভাবে প্রবেশ করা হয়েছে।',
                timer: 1500,
                showConfirmButton: false,
                willClose: () => {
                    // Redirect dynamically to dashboard or fallback destination URL
                    window.location.href = destinationUrl;
                }
            });
        }
    } catch (error) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'পোর্টালে প্রবেশ করুন (Sign In)';

        if (error.response && error.response.status === 403 && error.response.data.requires_verification === true) {
            Swal.fire({
                icon: 'warning',
                title: 'ইমেইল ভেরিফিকেশন প্রয়োজন',
                text: error.response.data.message || 'অনুগ্রহ করে প্রথমে আপনার ইমেইল ভেরিফাই করুন।',
                confirmButtonColor: '#004d40'
            });
        } 
        else if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            const message = error.response.data.message;

            // Handle server-side password validation messages inline dynamically
            if (errors && errors.password) {
                passErr.classList.remove('d-none');
                passErr.innerHTML = errors.password[0];
                document.getElementById('password').classList.add('is-invalid');
            }

            // Handle other server-side fields like username validation errors
            if (errors) {
                Object.keys(errors).forEach(key => {
                    if (key !== 'password') {
                        const input = document.getElementById(key);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = document.getElementById('error-' + key);
                            if (feedback) {
                                feedback.classList.remove('d-none'); // Show the error div
                                feedback.innerHTML = errors[key][0];
                            }
                        }
                    }
                });
            }

            Swal.fire({
                icon: 'warning',
                title: 'লগইন ব্যর্থ হয়েছে',
                text: message || 'অনুগ্রহ করে আপনার তথ্যগুলো পুনরায় পরীক্ষা করুন।',
                confirmButtonColor: '#004d40'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'লগইন ব্যর্থ হয়েছে',
                text: error.response?.data?.message || 'আপনার দেওয়া তথ্যগুলো ভুল। পুনরায় চেষ্টা করুন।',
                confirmButtonColor: '#004d40'
            });
        }
    }
});
</script>
@endpush