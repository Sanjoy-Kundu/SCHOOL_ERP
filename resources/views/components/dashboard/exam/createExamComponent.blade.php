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

    .form-switch .form-check-input {
        width: 2.2em;
        height: 1.15em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #004d40;
        border-color: #004d40;
    }

    /* Custom DataTables CSS to match project pattern */
    #examTypesTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #examTypesTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
</style>
@endpush


<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">পরীক্ষার ধরণ (Exam Types)</h1>
            <p class="text-muted small mb-0">পরীক্ষাসমূহ সেশন-স্বাধীনভাবে পুনর্ব্যবহারযোগ্য মাস্টার ক্যাটাগরি (বার্ষিক পরীক্ষা, অর্ধবার্ষিক পরীক্ষা) হিসেবে সাজান।</p>
        </div>
    </div>

    <div class="row g-4 flex-column-reverse flex-lg-row">
        <!-- Left Column: Interactive Master List Table -->
        <div class="col-12 {{ auth()->user()->can('exam_types.create') ? 'col-xl-8 col-lg-7' : 'col-xl-12' }}" id="tableCard">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-graduation-cap text-success me-2"></i>সংরক্ষিত পরীক্ষার ধরণ তালিকা
                </h5>
                
                <div class="table-responsive">
                    <table id="examTypesTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>সিরিয়াল নং</th>
                                <th>পরীক্ষার নাম</th>
                                <th>সংক্ষিপ্ত নাম (Code)</th>
                                <th>সাজানোর ক্রম</th>
                                <th>অবস্থা</th>
                                @canany(['exam_types.edit', 'exam_types.delete'])
                                    <th class="text-end">অ্যাকশন</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody id="examTypesTableBody">
                            <tr>
                                <td colspan="{{ auth()->user()->canAny(['exam_types.edit', 'exam_types.delete']) ? 6 : 5 }}" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">পরীক্ষার তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Create / Edit Form panel -->
        @canany(['exam_types.create', 'exam_types.edit'])
            <div class="col-12 col-xl-4 col-lg-5 {{ !auth()->user()->can('exam_types.create') ? 'd-none' : '' }}" id="formCard">
                <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                    <h5 class="fw-bold text-dark mb-3" id="formTitle">
                        <i class="fa-solid fa-sliders me-2 text-warning"></i>পরীক্ষার ধরণ যুক্ত করুন
                    </h5>
                    <p class="text-muted small" id="formDesc">পরীক্ষার জন্য নতুন একটি গ্লোবাল মাস্টার টাইপ তৈরি করুন।</p>
                    
                    <form id="examTypeCreateForm" novalidate>
                        <!-- Hidden input to store Master ID when editing -->
                        <input type="hidden" id="editExamTypeId" value="">

                        <!-- Name field -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small text-dark">পরীক্ষার নাম (বাংলা/ইংরেজি) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="name" placeholder="উদা: বার্ষিক পরীক্ষা / Annual Exam" required>
                            <div class="invalid-feedback" id="error-name"></div>
                        </div>

                        <!-- Short name field -->
                        <div class="mb-3">
                            <label for="short_name" class="form-label fw-semibold small text-secondary">সংক্ষিপ্ত নাম (Short Code)</label>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="short_name" placeholder="উদা: ANNUAL, HALF_YEARLY">
                            <div class="invalid-feedback" id="error-short-name"></div>
                        </div>

                        <!-- Sort Order field -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label fw-semibold small text-dark">সাজানোর ক্রম (Sort Order) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg rounded-3 fs-6" id="sort_order" min="0" value="0" required>
                            <div class="invalid-feedback" id="error-sort-order"></div>
                        </div>

                        <!-- Is Active Toggle Switch -->
                        <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                            <label class="fw-semibold small text-muted mb-0" for="status">অবস্থা (Active Status)</label>
                            <input class="form-check-input m-0" type="checkbox" role="switch" id="status" checked>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                            পরীক্ষার ধরণ যুক্ত করুন
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="resetBtn" style="display: none;">
                            <i class="fa-solid fa-rotate-left me-1"></i>বাতিল করুন
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
<script src="https://cdn.datatables.net/1.13.6/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/dataTables.bootstrap5.min.js"></script>

<script>
// 1. Pass Spatie Gate Authorization States to JavaScript
const canCreateType = @json(auth()->user()->can('exam_types.create'));
const canEditType = @json(auth()->user()->can('exam_types.edit'));
const canDeleteType = @json(auth()->user()->can('exam_types.delete'));

// English to Bangla Digit Converter Utility
function convertToBanglaNumber(number) {
    const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
    return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
}

// 2. Render Table Rows dynamically with client-side Gate Protection
function renderExamTypes(types) {
    const rows = types.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditType || canDeleteType) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            ${canEditType ? `<li><a class="dropdown-item typeEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                            ${canDeleteType ? `<li><a class="dropdown-item typeDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                        </ul>
                    </div>
                </td>
            `;
        }

        const banglaSerial = convertToBanglaNumber(index + 1);
        const banglaSortOrder = convertToBanglaNumber(item.sort_order ?? 0);
        const shortName = item.short_name ? item.short_name : '—';

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td class="fw-semibold">${item.name}</td>
                <td>${shortName}</td>
                <td>${banglaSortOrder}</td>
                <td>
                    <span class="badge ${item.status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                        ${item.status ? 'সক্রিয়' : 'নিষ্ক্রিয়'}
                    </span>
                </td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#examTypesTableBody').html(rows);
}

// DataTables Initialization
function initializeExamTypesDataTable() {
    if ($.fn.DataTable.isDataTable('#examTypesTable')) {
        $('#examTypesTable').DataTable().destroy();
    }

    $('#examTypesTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Sort order handled by Controller
        columnDefs: [
            { orderable: false, targets: (canEditType || canDeleteType) ? [0, 5] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// 3. Load all workspace configurations dynamically
async function loadExamTypesList() {
    let types = [];
    if ($.fn.DataTable.isDataTable('#examTypesTable')) {
        $('#examTypesTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/exam-type-lists');
        if (response.data?.status && response.data?.all_data) {
            types = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load exam types.');
    }

    renderExamTypes(types);
    initializeExamTypesDataTable();
}

// Reset Form State
function resetFormState() {
    $('#editExamTypeId').val('');
    $('#name').val('').removeClass('is-invalid');
    $('#short_name').val('').removeClass('is-invalid');
    $('#sort_order').val('0').removeClass('is-invalid');
    $('#status').prop('checked', true);

    // Clear Validation Errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

    $('#formTitle').html('<i class="fa-solid fa-sliders me-2 text-warning"></i>পরীক্ষার ধরণ যুক্ত করুন');
    $('#formDesc').text('পরীক্ষার জন্য নতুন একটি গ্লোবাল মাস্টার টাইপ তৈরি করুন।');
    
    $('#submitBtn').prop('disabled', false).text('পরীক্ষার ধরণ যুক্ত করুন').css('background-color', '#004d40');
    $('#resetBtn').hide();

    // Collapse form if restricted edit-only permission applies
    if (!canCreateType && canEditType) {
        $('#formCard').addClass('d-none');
        $('#tableCard').removeClass('col-xl-8 col-lg-7').addClass('col-xl-12');
    }
}

// Reset button click trigger
$('#resetBtn').on('click', function() {
    resetFormState();
});

// 4. Submit Form (Handles Create and Update using AJAX API calls)
const createFormElement = document.getElementById('examTypeCreateForm');
if (createFormElement) {
    createFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const nameInput = document.getElementById('name');
        const shortNameInput = document.getElementById('short_name');
        const sortOrderInput = document.getElementById('sort_order');
        const editId = document.getElementById('editExamTypeId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>সংরক্ষণ হচ্ছে...';

        // Clear previous error styles
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

        const payload = {
            name: nameInput.value,
            short_name: shortNameInput.value || null,
            sort_order: sortOrderInput.value,
            status: document.getElementById('status').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/exam-type-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/exam-type-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'পরীক্ষার ধরণ হালনাগাদ সম্পন্ন!' : 'পরীক্ষার ধরণ সফলভাবে তৈরি!',
                    text: res.data.message || 'Stored successfully.',
                    confirmButtonColor: '#004d40'
                });

                resetFormState(); 
                await loadExamTypesList(); 
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors) {
                    if (errors.name) {
                        nameInput.classList.add('is-invalid');
                        document.getElementById('error-name').innerHTML = errors.name[0];
                    }
                    if (errors.short_name) {
                        shortNameInput.classList.add('is-invalid');
                        document.getElementById('error-short-name').innerHTML = errors.short_name[0];
                    }
                    if (errors.sort_order) {
                        sortOrderInput.classList.add('is-invalid');
                        document.getElementById('error-sort-order').innerHTML = errors.sort_order[0];
                    }
                }
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
            submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'পরীক্ষার ধরণ যুক্ত করুন';
        }
    });
}

// 5. jQuery Event Delegation for Edit Button Click (Without Reload)
$('#examTypesTableBody').on('click', '.typeEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/exam-type-details/${id}`);

        if (res.data.status === true) {
            const type = res.data.data;
            
            // Show Form on restricted permission profile
            if (!canCreateType && canEditType) {
                $('#formCard').removeClass('d-none');
                $('#tableCard').removeClass('col-xl-12').addClass('col-xl-8 col-lg-7');
            }

            // Switch form to Edit Mode
            $('#formTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>পরীক্ষার ধরণ সম্পাদনা');
            $('#formDesc').text(`ইডিটিং রেকর্ড আইডি: #${type.id}`);
            $('#editExamTypeId').val(type.id);
            $('#name').val(type.name);
            $('#short_name').val(type.short_name ?? '');
            $('#sort_order').val(type.sort_order);
            $('#status').prop('checked', type.status == 1);

            $('#submitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e'); // Editing emphasis color
            $('#resetBtn').show(); 
            
            // Scroll smoothly to form card
            $('html, body').animate({
                scrollTop: $("#examTypeCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'পরীক্ষার ধরণের বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// 6. Delete Button Click Event Delegation (SweetAlert2 + Without Reload)
$('#examTypesTableBody').on('click', '.typeDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই পরীক্ষার ধরণটি ডিলিট করলে এর ডাটা আর পুনরুদ্ধার করা যাবে না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/exam-type-delete/${id}`);

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message || 'Deleted successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editExamTypeId').val() == id) {
                        resetFormState();
                    }

                    await loadExamTypesList(); 
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'রেকর্ডটি ডিলিট করতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});

// Load details on document ready
$(document).ready(function () {
    loadExamTypesList();
});
</script>
@endpush