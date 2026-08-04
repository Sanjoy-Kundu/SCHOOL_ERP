/**
 * ==========================================================================
 * LaraSaaS Forge - Global Application Core Configuration
 * ==========================================================================
 * This script initializes global AJAX headers, handles API token authentication,
 * and configures response interceptors for session security and timeouts.
 * 
 * Complies with CodeCanyon standard direct-script integration guidelines.
 * 
 * @package    LaraSaaS Forge
 * @author     Your Name / Studio
 * @copyright  2026 LaraSaaS Forge
 */

// 1. Ensure Axios handles AJAX identification headers properly
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// 2. Fetch and bind Laravel CSRF Token for stateful web request validation
const csrfMetaToken = document.head.querySelector('meta[name="csrf-token"]');
if (csrfMetaToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfMetaToken.content;
} else {
    console.error('Core Security Error: CSRF token meta tag not found in the DOM.');
}

// 3. Retrieve and assign Bearer Auth Token from browser LocalStorage
const userAuthToken = localStorage.getItem('auth_token');
if (userAuthToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${userAuthToken}`;
}

// 4. Setup Global Axios Interceptors to handle authentication timeouts dynamically (401 Unauthorized)
axios.interceptors.response.use(
    (response) => {
        // Return successful responses seamlessly
        return response;
    },
    (error) => {
        // Intercept 401 Unauthorized errors (e.g. invalid, tampered, or expired tokens)
        if (error.response && error.response.status === 401) {
            
            // Clear corrupted, expired, or invalid session token from client storage
            localStorage.removeItem('auth_token');

            // Gracefully notify user and clear server session via POST logout
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Session Expired',
                    text: 'Your security session has expired. Please log in again.',
                    confirmButtonColor: '#1a237e'
                }).then(() => {
                    // Send post request to clear Laravel session, then redirect
                    axios.post('/logout').finally(() => {
                        window.location.href = '/login';
                    });
                });
            } else {
                alert('Your security session has expired. Please log in again.');
                axios.post('/logout').finally(() => {
                    window.location.href = '/login';
                });
            }
        }
        return Promise.reject(error);
    }
);

// 5. Automatically monitor localStorage changes in real-time
window.addEventListener('storage', (event) => {
    // If 'auth_token' is deleted in another tab or via developer tools, force immediate logout
    if (event.key === 'auth_token' && !event.newValue) {
        // Clear server session before redirecting to avoid guest middleware loops
        axios.post('/logout').finally(() => {
            window.location.href = '/login';
        });
    }
});