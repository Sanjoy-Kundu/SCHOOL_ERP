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
        background-color: #004d40; /* Classic Bangladeshi School Green */
        border-color: #004d40;
    }

    /* Custom Academic Table Styles */
    #feeCategoriesTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #feeCategoriesTable tbody td {
        font-size: 0.875rem !important;
        color: black !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">ফি ক্যাটাগরি নির্ধারণ (Fee Categories)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের বিভিন্ন প্রকার ফি (সেশন ফি, বেতন, পরীক্ষার ফি ইত্যাদি) নির্ধারণ ও পরিচালনা করুন।</p>
        </div>
    </div>

    <div class="row g-4 flex-column-reverse flex-lg-row">
        <!-- Left Column: Interactive Categories List DataTable -->
        <div class="col-12 {{ auth()->user()->can('fee_categories.create') ? 'col-xl-8 col-lg-7' : 'col-xl-12' }}" id="tableCard">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-graduation-cap text-success me-2"></i>বিদ্যালয়ের ফি ক্যাটাগরি তালিকা
                </h5>
                
                <div class="table-responsive">
                    <table id="feeCategoriesTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>সিরিয়াল নং</th>
                                <th>ফি ক্যাটাগরির নাম</th>
                                <th>শর্ট কোড (Code)</th>
                                <th class="text-center">ফি এর ধরণ (Type)</th> <!-- Rendered Type column -->
                                <th>বিবরণ (Description)</th>
                                <th>অবস্থা</th>
                                <!-- Hide Action header completely if user cannot edit/delete -->
                                @canany(['fee_categories.edit', 'fee_categories.delete'])
                                    <th class="text-end">অ্যাকশন</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody id="feeCategoriesTableBody">
                            <tr>
                                <td colspan="{{ auth()->user()->canAny(['fee_categories.edit', 'fee_categories.delete']) ? 7 : 6 }}" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">ফি ক্যাটাগরি তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Create / Edit Fee Category Form -->
        @canany(['fee_categories.create', 'fee_categories.edit'])
            <div class="col-12 col-xl-4 col-lg-5 {{ !auth()->user()->can('fee_categories.create') ? 'd-none' : '' }}" id="formCard">
                <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                    <h5 class="fw-bold text-dark mb-3" id="formTitle">
                        <i class="fa-solid fa-sliders me-2 text-warning"></i>Add Fee Category
                    </h5>
                    <p class="text-muted small" id="formDesc">নতুন একটি ফি ক্যাটাগরি যুক্ত করুন।</p>
                    
                    <form id="feeCategoryCreateForm" novalidate>
                        <!-- Hidden input to store Configuration ID when editing -->
                        <input type="hidden" id="editCategoryId" value="">

                        <!-- Fee Category Name (Required) -->
                        <div class="mb-3">
                            <label for="categoryName" class="form-label fw-semibold small text-dark">ফি ক্যাটাগরির নাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="categoryName" placeholder="উদাঃ Monthly Tuition Fee" required>
                            <div class="invalid-feedback" id="error-name"></div>
                        </div>

                        <!-- Short Code (Optional) -->
                        <div class="mb-3">
                            <label for="categoryCode" class="form-label fw-semibold small text-secondary">শর্ট কোড (Code)</label>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6 text-uppercase" id="categoryCode" placeholder="উদাঃ TUITION">
                            <div class="invalid-feedback" id="error-code"></div>
                        </div>

                        <!-- Category Type Selection (Required & Preserves existing structure) -->
                        <div class="mb-3">
                            <label for="categoryType" class="form-label fw-semibold small text-dark">ফি এর ধরণ (Type) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6" id="categoryType" required>
                                <option value="{{ \App\Models\FeeCategory::TYPE_MONTHLY }}" selected>মাসিক ফি (Monthly)</option>
                                <option value="{{ \App\Models\FeeCategory::TYPE_ONE_TIME }}">এককালীন ফি (One-Time)</option>
                                <option value="{{ \App\Models\FeeCategory::TYPE_CUSTOM }}">কাস্টম/সাময়িক ফি (Custom)</option>
                            </select>
                            <div class="invalid-feedback" id="error-type"></div>
                        </div>

                        <!-- Description (Optional) -->
                        <div class="mb-3">
                            <label for="categoryDesc" class="form-label fw-semibold small text-secondary">সংক্ষিপ্ত বিবরণ (Description)</label>
                            <textarea class="form-control form-control-lg rounded-3 fs-6" id="categoryDesc" rows="3" placeholder="মন্তব্য বা বিবরণ লিখুন..."></textarea>
                            <div class="invalid-feedback" id="error-description"></div>
                        </div>

                        <!-- Sort Order (Optional) -->
                        <div class="mb-3">
                            <label for="categorySort" class="form-label fw-semibold small text-secondary">সর্ট অর্ডার (Sort Order)</label>
                            <input type="number" class="form-control form-control-lg rounded-3 fs-6" id="categorySort" min="0" value="0">
                            <div class="invalid-feedback" id="error-sort-order"></div>
                        </div>

                        <!-- Is Active Toggle Switch -->
                        <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                            <label class="fw-semibold small text-muted mb-0" for="status">অবস্থা (Active Status)</label>
                            <input class="form-check-input m-0" type="checkbox" role="switch" id="status" checked>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                            Create Fee Category
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="resetBtn" style="display: none;">
                            <i class="fa-solid fa-rotate-left me-1"></i>Cancel Edit
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
// 1. Pass Spatie Gate Authorization States to JavaScript
const canCreateCategory = @json(auth()->user()->can('fee_categories.create'));
const canEditCategory = @json(auth()->user()->can('fee_categories.edit'));
const canDeleteCategory = @json(auth()->user()->can('fee_categories.delete'));

// English to Bangla Digit Converter Utility
function convertToBanglaNumber(number) {
    if (number === undefined || number === null || number === '') return '—';
    const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
    return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
}

// 2. Render Table Rows dynamically with client-side Gate Protection
function renderCategories(categories) {
    const rows = categories.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditCategory || canDeleteCategory) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            ${canEditCategory ? `<li><a class="dropdown-item categoryEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                            ${canDeleteCategory ? `<li><a class="dropdown-item categoryDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                        </ul>
                    </div>
                </td>
            `;
        }

        const banglaSerial = convertToBanglaNumber(index + 1);
        const codeText = item.code ? `<span class="badge bg-light text-dark border px-2 py-1.5 fw-bold">${item.code}</span>` : '—';
        const descriptionText = item.description ? (item.description.length > 60 ? item.description.substring(0, 60) + '...' : item.description) : '—';

        // Render type badge dynamically based on backend model string constants
        let typeBadge = '';
        if (item.type === 'one_time') {
            typeBadge = '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 rounded-pill fw-bold">এককালীন (One-time)</span>';
        } else if (item.type === 'custom') {
            typeBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1.5 rounded-pill fw-bold">কাস্টম (Custom)</span>';
        } else {
            typeBadge = '<span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1.5 rounded-pill fw-bold">মাসিক (Monthly)</span>';
        }

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td class="fw-semibold text-dark">${item.name}</td>
                <td class="text-center">${codeText}</td>
                <td class="text-center">${typeBadge}</td> <!-- Type Column -->
                <td class="text-muted small">${descriptionText}</td>
                <td>
                    <span class="badge ${item.is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                        ${item.is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়'}
                    </span>
                </td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#feeCategoriesTableBody').html(rows);
}

// DataTables Initialization
function initializeCategoriesDataTable() {
    if ($.fn.DataTable.isDataTable('#feeCategoriesTable')) {
        $('#feeCategoriesTable').DataTable().destroy();
    }

    $('#feeCategoriesTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves sorting order loaded from the controller
        columnDefs: [
            { orderable: false, targets: (canEditCategory || canDeleteCategory) ? [0, 6] : [0] } // targets column index updated for 7 columns
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// 3. Load all workspace datasets dynamically
async function loadCategoriesList() {
    let categories = [];
    if ($.fn.DataTable.isDataTable('#feeCategoriesTable')) {
        $('#feeCategoriesTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/fees/categories/lists');
        if (response.data?.status && response.data?.all_data) {
            categories = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load fee categories.');
    }

    renderCategories(categories);
    initializeCategoriesDataTable();
}

// Reset Form State
function resetFormState() {
    $('#editCategoryId').val('');
    $('#categoryName').val('').removeClass('is-invalid');
    $('#categoryCode').val('').removeClass('is-invalid');
    $('#categoryType').val('monthly').removeClass('is-invalid'); // Type select reset to monthly
    $('#categoryDesc').val('').removeClass('is-invalid');
    $('#categorySort').val('0').removeClass('is-invalid');
    $('#status').prop('checked', true);

    // Clear Validation Errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

    $('#formTitle').html('<i class="fa-solid fa-sliders me-2 text-warning"></i>Add Fee Category');
    $('#formDesc').text('নতুন একটি ফি ক্যাটাগরি যুক্ত করুন।');
    
    $('#submitBtn').prop('disabled', false).text('Create Fee Category').css('background-color', '#004d40');
    $('#resetBtn').hide();

    // Dynamically collapse and hide form card if the user is authorized to edit but not create
    if (!canCreateCategory && canEditCategory) {
        $('#formCard').addClass('d-none');
        $('#tableCard').removeClass('col-xl-8 col-lg-7').addClass('col-xl-12');
    }
}

// Reset button click trigger
$('#resetBtn').on('click', function() {
    resetFormState();
});

// 4. Submit Form (Handles Create and Update using AJAX API calls)
const createFormElement = document.getElementById('feeCategoryCreateForm');
if (createFormElement) {
    createFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const nameInput = document.getElementById('categoryName');
        const codeInput = document.getElementById('categoryCode');
        const typeSelect = document.getElementById('categoryType');
        const descInput = document.getElementById('categoryDesc');
        const sortInput = document.getElementById('categorySort');
        const editId = document.getElementById('editCategoryId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...';

        // Clear previous error styles
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

        const payload = {
            name: nameInput.value,
            code: codeInput.value || null,
            type: typeSelect.value, // Added type select payload
            description: descInput.value || null,
            sort_order: sortInput.value || 0,
            is_active: document.getElementById('status').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/fees/categories/update/${editId}`, payload);
            } else {
                res = await axios.post('/api/fees/categories/store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'ফি ক্যাটাগরি হালনাগাদ সম্পন্ন!' : 'ফি ক্যাটাগরি সফলভাবে তৈরি!',
                    text: res.data.message || 'Fee category has been saved successfully.',
                    confirmButtonColor: '#004d40'
                });

                resetFormState(); 
                await loadCategoriesList(); 
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                const generalMessage = error.response.data.message;

                // Bind Laravel validation rules back to client side elements
                if (errors) {
                    if (errors.name) {
                        nameInput.classList.add('is-invalid');
                        document.getElementById('error-name').innerHTML = errors.name[0];
                    }
                    if (errors.code) {
                        codeInput.classList.add('is-invalid');
                        document.getElementById('error-code').innerHTML = errors.code[0];
                    }
                    if (errors.type) {
                        typeSelect.classList.add('is-invalid');
                        document.getElementById('error-type').innerHTML = errors.type[0];
                    }
                    if (errors.description) {
                        descInput.classList.add('is-invalid');
                        document.getElementById('error-description').innerHTML = errors.description[0];
                    }
                    if (errors.sort_order) {
                        sortInput.classList.add('is-invalid');
                        document.getElementById('error-sort-order').innerHTML = errors.sort_order[0];
                    }
                }
                
                // Trigger warning alert for duplicate validation configurations
                if (generalMessage && !errors) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'সংরক্ষণ ব্যর্থ হয়েছে',
                        text: generalMessage,
                        confirmButtonColor: '#004d40'
                    });
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
            submitBtn.innerHTML = editId ? 'Update Category' : 'Create Fee Category';
        }
    });
}

// 5. jQuery Event Delegation for Edit Button Click (Without Reload)
$('#feeCategoriesTableBody').on('click', '.categoryEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/fees/categories/details/${id}`);

        if (res.data.status === true) {
            const category = res.data.data;
            
            // Switch Form column width dynamically for restricted users (Edit only)
            if (!canCreateCategory && canEditCategory) {
                $('#formCard').removeClass('d-none');
                $('#tableCard').removeClass('col-xl-12').addClass('col-xl-8 col-lg-7');
            }

            // Switch form to Edit Mode
            $('#formTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit Fee Category');
            $('#formDesc').text(`Updating Category ID: #${category.id}`);
            $('#editCategoryId').val(category.id);
            $('#categoryName').val(category.name);
            $('#categoryCode').val(category.code ?? '');
            $('#categoryType').val(category.type ?? 'monthly'); // Bind loaded type value safely
            $('#categoryDesc').val(category.description ?? '');
            $('#categorySort').val(category.sort_order ?? 0);
            $('#status').prop('checked', category.is_active == 1);

            $('#submitBtn').text('Update Category').css('background-color', '#1a237e'); // Primary contrast for edit mode
            $('#resetBtn').show(); 
            
            // Scroll smoothly to form card on mobile devices
            $('html, body').animate({
                scrollTop: $("#feeCategoryCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'ফি ক্যাটাগরির বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// 6. Delete Button Click Event Delegation (SweetAlert2 + Without Reload)
$('#feeCategoriesTableBody').on('click', '.categoryDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই ফি ক্যাটাগরিটি ডিলিট করলে এর ডাটা আর পুনরুদ্ধার করা যাবে না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/fees/categories/delete/${id}`);

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message || 'The fee category has been deleted successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editCategoryId').val() == id) {
                        resetFormState();
                    }

                    await loadCategoriesList(); 
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'ক্যাটাগরি ডিলিট করতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});

// Load details on document ready
$(document).ready(function () {
    loadCategoriesList();
});
</script>
@endpush