@push('styles')
<style>
    /* Dynamic responsive design CSS */
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

    .form-switch .form-check-input {
        width: 2.2em;
        height: 1.15em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #004d40; /* Classic Bangladeshi School Green */
        border-color: #004d40;
    }

    /* Custom DataTables CSS */
    #sessionsTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #sessionsTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">শিক্ষাবর্ষ ব্যবস্থাপনা (Academic Sessions)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের জন্য ডাইনামিক শিক্ষাবর্ষ তৈরি করুন, পরিবর্তন করুন এবং যেকোনো একটি সেশনকে একটিভ হিসেবে নির্ধারণ করুন।</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Interactive Sessions List DataTable -->
        <!-- Dynamically adjusts column span if creation form is omitted or hidden based on authorization -->
        <div class="col-12 {{ auth()->user()->can('academic_sessions.create') ? 'col-xl-8' : 'col-xl-12' }}" id="tableCard">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-calendar-days me-2 text-success"></i>বর্তমান সেশনসমূহের তালিকা
                </h5>
                
                <div class="table-responsive">
                    <table id="sessionsTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>সিরিয়াল নং</th>
                                <th>শিক্ষাবর্ষের বছর (Session Year)</th>
                                <th>অবস্থা (Status)</th>
                                <th>সেশন অ্যাক্টিভেশন কন্ট্রোল</th>
                                <th>তৈরির তারিখ</th>
                                <!-- Hide Action header completely if user cannot edit/delete -->
                                {{-- @canany(['academic_sessions.edit', 'academic_sessions.delete']) --}}
                                    <th class="text-end">অ্যাকশন (Action)</th>
                                {{-- @endcanany --}}
                            </tr>
                        </thead>
                        <tbody id="sessionsTableBody">
                            <tr>
                                <td colspan="{{ auth()->user()->canAny(['academic_sessions.edit', 'academic_sessions.delete']) ? 6 : 5 }}" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">সেশন তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Create / Edit Session Form -->
        <!-- Displayed only if the user is authorized to create or edit sessions -->
        @canany(['academic_sessions.create', 'academic_sessions.edit'])
            <div class="col-12 col-xl-4 {{ !auth()->user()->can('academic_sessions.create') ? 'd-none' : '' }}" id="formCard">
                <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                    <h5 class="fw-bold text-dark mb-3" id="formTitle">
                        <i class="fa-solid fa-calendar-plus me-2 text-warning"></i>নতুন সেশন তৈরি করুন
                    </h5>
                    <p class="text-muted small" id="formDesc">নতুন শিক্ষাবর্ষের নাম লিখুন এবং একটিভ সুইচ অন করে সেশন যুক্ত করুন।</p>
                    
                    <form id="sessionCreateForm" novalidate>
                        <!-- Hidden input to store Session ID when editing -->
                        <input type="hidden" id="editSessionId" value="">

                        <!-- Session Name -->
                        <div class="mb-3">
                            <label for="sessionName" class="form-label fw-semibold small">শিক্ষাবর্ষের নাম</label>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="sessionName" placeholder="উদা: 2026 অথবা 2020-2030" required>
                            <div class="invalid-feedback" id="error-name"></div>
                        </div>

                        <!-- Is Active Toggle Switch -->
                        <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                            <label class="fw-semibold small text-muted mb-0" for="isActive">অ্যাক্টিভ অবস্থা (Active Status)</label>
                            <input class="form-check-input m-0" type="checkbox" role="switch" id="isActive" checked>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                            সেশন তৈরি করুন
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="resetBtn" style="display: none;">
                            <i class="fa-solid fa-rotate-left me-1"></i>পরিবর্তন বাতিল করুন
                        </button>
                    </form>
                </div>
            </div>
        @endcanany
    </div>
</div>

@push('scripts')
<!-- DataTables Bootstrap 5 CSS & JS Integration Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// 1. Pass Authorization States from Server to JavaScript
const canCreateSession = @json(auth()->user()->can('academic_sessions.create'));
const canEditSession = @json(auth()->user()->can('academic_sessions.edit'));
const canDeleteSession = @json(auth()->user()->can('academic_sessions.delete'));

// English to Bangla Digit Converter Utility
function convertToBanglaNumber(number) {
    const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
    return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
}

// BD Timezone Date Formatter
function formatBDDate(dateString) {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('en-BD', {
        timeZone: 'Asia/Dhaka',
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}

// 2. Render Table Rows dynamically with client-side Gate Protection
function renderSessions(sessions) {
    const rows = sessions.map((session, index) => { // Modified: Added "index" parameter here to fix reference error
        /*
        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            ${canEditSession ? `<li><a class="dropdown-item sessionEdit py-2 px-3 small" href="#" data-id="${session.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                            ${canDeleteSession && !session.is_active ? `<li><a class="dropdown-item sessionDelete py-2 px-3 small text-danger" href="#" data-id="${session.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                        </ul>
        
        **/
        // Render Action buttons column conditionally based on user capabilities
        let actionColumnHtml = '';
        if (canEditSession || canDeleteSession) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন (Action)
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            <li><a class="dropdown-item sessionEdit py-2 px-3 small" href="#" data-id="${session.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>
                            <li><a class="dropdown-item sessionDelete py-2 px-3 small text-danger" href="#" data-id="${session.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>
                        </ul>
                    </div>
                </td>
            `;
        }

        // Action column for status toggle activation
        let activationHtml = '';
        if (!session.is_active) {
            activationHtml = `
                <button class="btn btn-outline-success btn-sm px-3 rounded-pill fw-bold sessionToggleActive" data-id="${session.id}" data-name="${session.name}">
                    অ্যাক্টিভ করুন (Set Active)
                </button>
            `;
        } else {
            activationHtml = `
                <button class="btn btn-success btn-sm px-3 rounded-pill fw-bold" disabled>
                    <i class="fa-solid fa-check-double me-1"></i> বর্তমানে অ্যাক্টিভ
                </button>
            `;
        }

        // Format dynamic index order into Bengali representation
        const banglaSerial = convertToBanglaNumber(index + 1);

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-light border rounded-3 p-1 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; overflow: hidden; color: #004d40;">
                            <i class="fa-solid fa-calendar-days fs-4"></i>
                        </div>
                        <strong>${session.name} শিক্ষাবর্ষ</strong>
                    </div>
                </td>
                <td>
                    <span class="badge ${session.is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                        ${session.is_active ? 'সক্রিয় (Active)' : 'নিষ্ক্রিয় (Inactive)'}
                    </span>
                </td>
                <td>${activationHtml}</td>
                <td class="text-muted small">${formatBDDate(session.created_at)}</td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#sessionsTableBody').html(rows);
}

// 3. DataTable Initialization
function initializeSessionsDataTable() {
    if ($.fn.DataTable.isDataTable('#sessionsTable')) {
        $('#sessionsTable').DataTable().destroy();
    }

    $('#sessionsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 30, 40, 50, 100],
        responsive: true,
        columnDefs: [
            { orderable: false, targets: (canEditSession || canDeleteSession) ? [0, 3, 5] : [0, 3] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// 4. Fetch all sessions dynamically
async function loadSessionsList() {
    let sessions = [];
    
    if ($.fn.DataTable.isDataTable('#sessionsTable')) {
        $('#sessionsTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/academic-session-lists');

        if (response.data?.status && response.data?.all_data) {
            sessions = response.data.all_data;
        }
    } catch (error) {
        console.warn('API connection failed. Failed to load academic sessions.');
    }

    renderSessions(sessions);
    initializeSessionsDataTable();
}

// Reset Form State
function resetFormState() {
    $('#editSessionId').val('');
    $('#sessionName').val('').removeClass('is-invalid');
    $('#isActive').prop('checked', true);

    // Clear Validation Errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

    $('#formTitle').html('<i class="fa-solid fa-calendar-plus me-2 text-warning"></i>নতুন সেশন তৈরি করুন');
    $('#formDesc').text('নতুন শিক্ষাবর্ষের নাম লিখুন এবং একটিভ সুইচ অন করে সেশন যুক্ত করুন।');
    
    $('#submitBtn').prop('disabled', false).text('সেশন তৈরি করুন').css('background-color', '#004d40');
    $('#resetBtn').hide();

    // Dynamically collapse and hide form card if the user is authorized to edit but not create
    if (!canCreateSession && canEditSession) {
        $('#formCard').addClass('d-none');
        $('#tableCard').removeClass('col-xl-8').addClass('col-xl-12');
    }
}

// Reset button click trigger
$('#resetBtn').on('click', function() {
    resetFormState();
});

// 5. Submit Form (Handles Create and Update using AJAX API calls)
const createFormElement = document.getElementById('sessionCreateForm');
if (createFormElement) {
    createFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const sessionNameInput = document.getElementById('sessionName');
        const editId = document.getElementById('editSessionId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>সংরক্ষণ করা হচ্ছে...';

        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

        const payload = {
            name: sessionNameInput.value,
            is_active: document.getElementById('isActive').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/academic-session-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/academic-session-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'সেশন হালনাগাদ করা হয়েছে!' : 'সেশন তৈরি করা হয়েছে!',
                    text: res.data.message || 'Academic session saved successfully.',
                    confirmButtonColor: '#004d40'
                });

                resetFormState(); 
                await loadSessionsList(); 
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                Object.keys(errors).forEach(key => {
                    const inputElement = document.getElementById('session' + key.charAt(0).toUpperCase() + key.slice(1));
                    if (inputElement) {
                        inputElement.classList.add('is-invalid');
                        const feedback = document.getElementById('error-' + key);
                        if (feedback) {
                            feedback.innerHTML = errors[key][0];
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'Something went wrong.',
                    confirmButtonColor: '#004d40'
                });
            }
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'সেশন তৈরি করুন';
        }
    });
}

// 6. jQuery Event Delegation for Edit Button Click (Without Reload)
$('#sessionsTableBody').on('click', '.sessionEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/academic-session-details/${id}`);

        if (res.data.status === true) {
            const session = res.data.data;
            
            // Switch Form column width dynamically for restricted users (Edit only)
            if (!canCreateSession && canEditSession) {
                $('#formCard').removeClass('d-none');
                $('#tableCard').removeClass('col-xl-12').addClass('col-xl-8');
            }

            // Switch form to Edit Mode
            $('#formTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>সেশন এডিট করুন');
            $('#formDesc').text(`সেশন আইডি হালনাগাদ করা হচ্ছে: #${session.id}`);
            $('#editSessionId').val(session.id);
            $('#sessionName').val(session.name);
            $('#isActive').prop('checked', session.is_active == 1);

            $('#submitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e'); // Dynamic indicator for edit mode
            $('#resetBtn').show(); 
            
            // Scroll smoothly to form card on mobile devices
            $('html, body').animate({
                scrollTop: $("#sessionCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'শিক্ষাবর্ষের তথ্য লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// 7. Toggle Active Session Action
$('#sessionsTableBody').on('click', '.sessionToggleActive', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const name = $(this).data('name');

    Swal.fire({
        title: 'অ্যাক্টিভ সেশন পরিবর্তন করবেন?',
        text: `আপনি কি নিশ্চিতভাবে '${name}' সেশনটি একটিভ করতে চান? এর ফলে বাকি অন্য সব সেশন ডিঅ্যাক্টিভ হয়ে যাবে।`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#004d40',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, একটিভ করুন',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.patch(`/api/academic-session-set-active/${id}`);

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'সেশন অ্যাক্টিভ করা হয়েছে!',
                        text: res.data.message || 'Session activated successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    await loadSessionsList(); 
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'সেশন অ্যাক্টিভেশনে ত্রুটি দেখা দিয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});

// 8. Delete Button Click Event Delegation (SweetAlert2 + Without Reload)
$('#sessionsTableBody').on('click', '.sessionDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'সেশনটি ডিলিট করলে এর ডাটা আর পুনরুদ্ধার করা যাবে না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/academic-session-delte/${id}`);

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message || 'Session deleted successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editSessionId').val() == id) {
                        resetFormState();
                    }

                    await loadSessionsList(); 
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'সেশনটি ডিলিট করতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});

// Load details on document ready
$(document).ready(function () {
    loadSessionsList();
});
</script>
@endpush