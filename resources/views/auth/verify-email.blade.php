@extends('layouts.app')
@section('title', 'LaraSaaS Forge || Verify Email')

@push('styles')
<style>
    /* ডাইনামিক রেসপন্সিভ ডিজাইন সিএসএস (আপনার ফ্লো অনুযায়ী) */
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
        .card-responsive { border-radius: 24px !important; box-shadow: 0 15px 50px rgba(0,0,0,0.12) !important; }
    }
</style>
@endpush

@section('content')
<div class="container container-responsive">
    <div class="row justify-content-center align-items-center min-vh-100 py-3 py-sm-4 py-md-5">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="card border-0 card-responsive">
                <div class="card-body p-3 p-sm-4 p-md-5 text-center">
                    
                    <div class="mb-4">
                        <!-- কাস্টম মেইল আইকন -->
                        <i class="fa-solid fa-envelope-open-text text-primary animate-bounce" style="font-size: 4.5rem;"></i>
                        <h2 class="fw-bold mt-3 title-responsive text-dark">Verify Your Email</h2>
                        <p class="text-muted small">We've sent a verification link to your email address. Please click on the link to verify your account.</p>
                    </div>

                    <div class="alert alert-info py-2 px-3 rounded-3 small mb-4" role="alert">
                        <i class="fa-solid fa-circle-info me-2"></i>Before proceeding, please check your email for a verification link. If you did not receive the email, click the button below.
                    </div>

                    <!-- Resend Verification Link Button -->
                    <button id="resendBtn" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mb-3">
                        Resend Verification Email
                    </button>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger text-decoration-none small fw-semibold">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>Logout and try another account
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('resendBtn').addEventListener('click', async function () {
    const resendBtn = document.getElementById('resendBtn');
    
    resendBtn.disabled = true;
    resendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...';

    try {
        // Axios-এর মাধ্যমে কাস্টম রিসেন্ড এন্ডপয়েন্টে রিকোয়েস্ট পাঠানো
        let res = await axios.post('/email/verification-notification');
        
        if (res.data.status === true) {
            Swal.fire({
                icon: 'success',
                title: 'Sent!',
                text: 'A new verification link has been sent to your email address.',
                confirmButtonColor: '#0d6efd'
            });
        }
    } catch (error) {
        console.log(error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again later.',
            confirmButtonColor: '#0d6efd'
        });
    } finally {
        resendBtn.disabled = false;
        resendBtn.innerHTML = 'Resend Verification Email';
    }
});
</script>
@endpush