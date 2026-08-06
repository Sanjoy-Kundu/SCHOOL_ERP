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

    /* Tab Customizations */
    .nav-tabs-academic .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 600;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .nav-tabs-academic .nav-link.active {
        background-color: #004d40 !important; /* Classic Bangladeshi School Green */
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 77, 64, 0.2);
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

    /* Custom DataTables CSS */
    .table-academic-thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #shiftsTable tbody td, #groupsTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">শিফট ও বিভাগ ব্যবস্থাপনা (Shifts & Groups)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের শিফটসমূহ (যেমন: প্রভাতী, দিবা) এবং ৯ম-১০ম শ্রেণীর বিভাগসমূহ (বিজ্ঞান, মানবিক, ব্যবসায় শিক্ষা) মাস্টার প্যানেল থেকে নিয়ন্ত্রণ করুন।</p>
        </div>
    </div>

    <!-- Navigation Tabs for Shifts and Groups Panel -->
    <ul class="nav nav-tabs nav-tabs-academic border-0 mb-4 gap-2" id="academicTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="shifts-tab" data-bs-toggle="tab" data-bs-target="#shifts-pane" type="button" role="tab" aria-controls="shifts-pane" aria-selected="true">
                <i class="fa-solid fa-clock me-2"></i>শিফটসমূহ (Shifts)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="groups-tab" data-bs-toggle="tab" data-bs-target="#groups-pane" type="button" role="tab" aria-controls="groups-pane" aria-selected="false">
                <i class="fa-solid fa-people-group me-2"></i>বিভাগসমূহ (Groups)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="academicTabsContent">
        
        <!-- Tab 1: Shifts Workspace -->
        <div class="tab-pane fade show active" id="shifts-pane" role="tabpanel" aria-labelledby="shifts-tab" tabindex="0">
            <div class="row g-4">
                <!-- Left: Shifts Table -->
                <div class="col-12 {{ auth()->user()->can('shifts_groups.create') ? 'col-xl-8' : 'col-xl-12' }}" id="shiftTableCard">
                    <div class="card border-0 card-responsive p-3 p-sm-4 bg-white">
                        <h5 class="fw-bold text-dark mb-4">
                            <i class="fa-solid fa-hourglass-start text-success me-2"></i>সক্রিয় শিফটের তালিকা
                        </h5>
                        <div class="table-responsive">
                            <table id="shiftsTable" class="table table-hover align-middle border-0 w-100">
                                <thead class="table-light table-academic-thead">
                                    <tr>
                                        <th>সিরিয়াল নং</th>
                                        <th>শিফটের নাম</th>
                                        <th>সাজানোর ক্রম (Order)</th>
                                        <th>অবস্থা (Status)</th>
                                        <th>তৈরির তারিখ</th>
                                        {{-- @canany(['shifts_groups.edit', 'shifts_groups.delete']) --}}
                                            <th class="text-end">অ্যাকশন</th>
                                        {{-- @endcanany --}}
                                    </tr>
                                </thead>
                                <tbody id="shiftsTableBody">
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="spinner-border text-success" role="status"></div>
                                            <span class="ms-2">শিফট তালিকা লোড হচ্ছে...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Shifts Form -->
                {{-- @canany(['shifts_groups.create', 'shifts_groups.edit']) --}}
                    <div class="col-12 col-xl-4 {{ !auth()->user()->can('shifts_groups.create') ? 'd-none' : '' }}" id="shiftFormCard">
                        <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                            <h5 class="fw-bold text-dark mb-3" id="shiftFormTitle">
                                <i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন শিফট যুক্ত করুন
                            </h5>
                            <p class="text-muted small" id="shiftFormDesc">বিদ্যালয়ের শিফটের নাম (উদা: Morning, Day) লিখে যুক্ত করুন।</p>
                            
                            <form id="shiftCreateForm" novalidate>
                                <input type="hidden" id="editShiftId" value="">

                                <div class="mb-3">
                                    <label for="shiftName" class="form-label fw-semibold small">শিফটের নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="shiftName" placeholder="উদা: Morning, Day" required>
                                    <div class="invalid-feedback" id="error-shift-name"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="shiftSortOrder" class="form-label fw-semibold small">সাজানোর ক্রম (Sort Order) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-lg rounded-3 fs-6" id="shiftSortOrder" placeholder="উদা: ১, ২" min="0" value="0" required>
                                    <div class="invalid-feedback" id="error-shift-sort-order"></div>
                                </div>

                                <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                                    <label class="fw-semibold small text-muted mb-0" for="shiftStatus">অবস্থা (Active Status)</label>
                                    <input class="form-check-input m-0" type="checkbox" role="switch" id="shiftStatus" checked>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="shiftSubmitBtn" style="background-color: #004d40; border-color: #004d40;">
                                    শিফট যুক্ত করুন
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="shiftResetBtn" style="display: none;">
                                    <i class="fa-solid fa-rotate-left me-1"></i>বাতিল করুন
                                </button>
                            </form>
                        </div>
                    </div>
                {{-- @endcanany --}}
            </div>
        </div>

        <!-- Tab 2: Groups Workspace -->
        <div class="tab-pane fade" id="groups-pane" role="tabpanel" aria-labelledby="groups-tab" tabindex="0">
            <div class="row g-4">
                <!-- Left: Groups Table -->
                <div class="col-12 {{ auth()->user()->can('shifts_groups.create') ? 'col-xl-8' : 'col-xl-12' }}" id="groupTableCard">
                    <div class="card border-0 card-responsive p-3 p-sm-4 bg-white">
                        <h5 class="fw-bold text-dark mb-4">
                            <i class="fa-solid fa-layer-group text-success me-2"></i>বিভাগের মাস্টার তালিকা
                        </h5>
                        <div class="table-responsive">
                            <table id="groupsTable" class="table table-hover align-middle border-0 w-100">
                                <thead class="table-light table-academic-thead">
                                    <tr>
                                        <th>সিরিয়াল নং</th>
                                        <th>বিভাগের নাম</th>
                                        <th>সাজানোর ক্রম (Order)</th>
                                        <th>অবস্থা (Status)</th>
                                        <th>তৈরির তারিখ</th>
                                        {{-- @canany(['shifts_groups.edit', 'shifts_groups.delete']) --}}
                                            <th class="text-end">অ্যাকশন</th>
                                        {{-- @endcanany --}}
                                    </tr>
                                </thead>
                                <tbody id="groupsTableBody">
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="spinner-border text-success" role="status"></div>
                                            <span class="ms-2">বিভাগ তালিকা লোড হচ্ছে...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Groups Form -->
                @canany(['shifts_groups.create', 'shifts_groups.edit'])
                    <div class="col-12 col-xl-4 {{ !auth()->user()->can('shifts_groups.create') ? 'd-none' : '' }}" id="groupFormCard">
                        <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                            <h5 class="fw-bold text-dark mb-3" id="groupFormTitle">
                                <i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন বিভাগ যুক্ত করুন
                            </h5>
                            <p class="text-muted small" id="groupFormDesc">মাধ্যমিক পর্যায়ের বিভাগ (উদা: Science, Humanities, Business Studies) লিখে যুক্ত করুন।</p>
                            
                            <form id="groupCreateForm" novalidate>
                                <input type="hidden" id="editGroupId" value="">

                                <div class="mb-3">
                                    <label for="groupName" class="form-label fw-semibold small">বিভাগের নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="groupName" placeholder="উদা: Science, Humanities" required>
                                    <div class="invalid-feedback" id="error-group-name"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="groupSortOrder" class="form-label fw-semibold small">সাজানোর ক্রম (Sort Order) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-lg rounded-3 fs-6" id="groupSortOrder" placeholder="উদা: ১, ২, ৩" min="0" value="0" required>
                                    <div class="invalid-feedback" id="error-group-sort-order"></div>
                                </div>

                                <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                                    <label class="fw-semibold small text-muted mb-0" for="groupStatus">অবস্থা (Active Status)</label>
                                    <input class="form-check-input m-0" type="checkbox" role="switch" id="groupStatus" checked>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="groupSubmitBtn" style="background-color: #004d40; border-color: #004d40;">
                                    বিভাগ যুক্ত করুন
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="groupResetBtn" style="display: none;">
                                    <i class="fa-solid fa-rotate-left me-1"></i>বাতিল করুন
                                </button>
                            </form>
                        </div>
                    </div>
                @endcanany
            </div>
        </div>

    </div>
</div>

@push('scripts')
<!-- DataTables Bootstrap 5 CSS & JS Integration Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// 1. Pass Sptie Gate Authorization States to JavaScript
const canCreateAll = @json(auth()->user()->can('shifts_groups.create'));
const canEditAll = @json(auth()->user()->can('shifts_groups.edit'));
const canDeleteAll = @json(auth()->user()->can('shifts_groups.delete'));

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

/*----------------------------------------------------
  SHIFTS CORE AJAX MANAGEMENT WORKSPACE
----------------------------------------------------*/

// Render Shifts rows dynamically
function renderShifts(shifts) {
    const rows = shifts.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditAll || canDeleteAll) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            <li><a class="dropdown-item shiftEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>
                            <li><a class="dropdown-item shiftDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>
                        </ul>
                    </div>
                </td>
            `;
        }

        const banglaSerial = convertToBanglaNumber(index + 1);
        const banglaSortOrder = convertToBanglaNumber(item.sort_order ?? 0);

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-light border rounded-3 p-1 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; color: #004d40;">
                            <i class="fa-solid fa-clock fs-4"></i>
                        </div>
                        <strong>${item.name} শিফট</strong>
                    </div>
                </td>
                <td class="fw-semibold text-secondary">${banglaSortOrder}</td>
                <td>
                    <span class="badge ${item.status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                        ${item.status ? 'সক্রিয়' : 'নিষ্ক্রিয়'}
                    </span>
                </td>
                <td class="text-muted small">${formatBDDate(item.created_at)}</td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#shiftsTableBody').html(rows);
}

// Shifts DataTable Initialization
function initializeShiftsDataTable() {
    if ($.fn.DataTable.isDataTable('#shiftsTable')) {
        $('#shiftsTable').DataTable().destroy();
    }

    $('#shiftsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves manual sort ordering defined on server side on load
        columnDefs: [
            { orderable: false, targets: (canEditAll || canDeleteAll) ? [0, 5] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// Fetch and load shifts dynamically
async function loadShiftsList() {
    let shifts = [];
    if ($.fn.DataTable.isDataTable('#shiftsTable')) {
        $('#shiftsTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/shift-lists');
        if (response.data?.status && response.data?.all_data) {
            shifts = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load school shifts.');
    }

    renderShifts(shifts);
    initializeShiftsDataTable();
}

// Reset Shifts Form States
function resetShiftFormState() {
    $('#editShiftId').val('');
    $('#shiftName').val('').removeClass('is-invalid');
    $('#shiftSortOrder').val('0').removeClass('is-invalid');
    $('#shiftStatus').prop('checked', true);
    $('#error-shift-name').html('');
    $('#error-shift-sort-order').html('');

    $('#shiftFormTitle').html('<i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন শিফট যুক্ত করুন');
    $('#shiftFormDesc').text('বিদ্যালয়ের শিফটের নাম (উদা: Morning, Day) লিখে যুক্ত করুন।');
    $('#shiftSubmitBtn').prop('disabled', false).text('শিফট যুক্ত করুন').css('background-color', '#004d40');
    $('#shiftResetBtn').hide();

    if (!canCreateAll && canEditAll) {
        $('#shiftFormCard').addClass('d-none');
        $('#shiftTableCard').removeClass('col-xl-8').addClass('col-xl-12');
    }
}

$('#shiftResetBtn').on('click', function() {
    resetShiftFormState();
});

// Submit Shift Form
const shiftFormElement = document.getElementById('shiftCreateForm');
if (shiftFormElement) {
    shiftFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('shiftSubmitBtn');
        const shiftNameInput = document.getElementById('shiftName');
        const shiftSortOrderInput = document.getElementById('shiftSortOrder');
        const editId = document.getElementById('editShiftId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>সংরক্ষণ করা হচ্ছে...';

        shiftNameInput.classList.remove('is-invalid');
        shiftSortOrderInput.classList.remove('is-invalid');
        document.getElementById('error-shift-name').innerHTML = '';
        document.getElementById('error-shift-sort-order').innerHTML = '';

        const payload = {
            name: shiftNameInput.value,
            sort_order: shiftSortOrderInput.value,
            status: document.getElementById('shiftStatus').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/shift-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/shift-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'শিফট হালনাগাদ করা হয়েছে!' : 'শিফট যুক্ত করা হয়েছে!',
                    text: res.data.message,
                    confirmButtonColor: '#004d40'
                });

                resetShiftFormState();
                await loadShiftsList();
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.name) {
                    shiftNameInput.classList.add('is-invalid');
                    document.getElementById('error-shift-name').innerHTML = errors.name[0];
                }
                if (errors.sort_order) {
                    shiftSortOrderInput.classList.add('is-invalid');
                    document.getElementById('error-shift-sort-order').innerHTML = errors.sort_order[0];
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
            submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'শিফট যুক্ত করুন';
        }
    });
}

// Edit Shift trigger
$('#shiftsTableBody').on('click', '.shiftEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/shift-details/${id}`);
        if (res.data.status === true) {
            const shiftObj = res.data.data;

            if (!canCreateAll && canEditAll) {
                $('#shiftFormCard').removeClass('d-none');
                $('#shiftTableCard').removeClass('col-xl-12').addClass('col-xl-8');
            }

            $('#shiftFormTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>শিফট এডিট করুন');
            $('#shiftFormDesc').text(`শিফট আইডি হালনাগাদ করা হচ্ছে: #${shiftObj.id}`);
            $('#editShiftId').val(shiftObj.id);
            $('#shiftName').val(shiftObj.name);
            $('#shiftSortOrder').val(shiftObj.sort_order ?? 0);
            $('#shiftStatus').prop('checked', shiftObj.status == 1);

            $('#shiftSubmitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e');
            $('#shiftResetBtn').show();

            $('html, body').animate({
                scrollTop: $("#shiftCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'শিফটের বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// Delete Shift trigger
$('#shiftsTableBody').on('click', '.shiftDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই শিফটটি মাস্টার ডাটা থেকে স্থায়ীভাবে মুছে ফেলা হবে!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/shift-delte/${id}`);
                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message,
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editShiftId').val() == id) {
                        resetShiftFormState();
                    }
                    await loadShiftsList();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: 'শিফটটি মুছতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});


/*----------------------------------------------------
  GROUPS CORE AJAX MANAGEMENT WORKSPACE
----------------------------------------------------*/

// Render Groups rows dynamically
function renderGroups(groups) {
    const rows = groups.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditAll || canDeleteAll) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            <li><a class="dropdown-item groupEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>
                            <li><a class="dropdown-item groupDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>
                        </ul>
                    </div>
                </td>
            `;
        }

        const banglaSerial = convertToBanglaNumber(index + 1);
        const banglaSortOrder = convertToBanglaNumber(item.sort_order ?? 0);

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-light border rounded-3 p-1 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; color: #004d40;">
                            <i class="fa-solid fa-people-group fs-4"></i>
                        </div>
                        <strong>${item.name}</strong>
                    </div>
                </td>
                <td class="fw-semibold text-secondary">${banglaSortOrder}</td>
                <td>
                    <span class="badge ${item.status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                        ${item.status ? 'সক্রিয়' : 'নিষ্ক্রিয়'}
                    </span>
                </td>
                <td class="text-muted small">${formatBDDate(item.created_at)}</td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#groupsTableBody').html(rows);
}

// Groups DataTable Initialization
function initializeGroupsDataTable() {
    if ($.fn.DataTable.isDataTable('#groupsTable')) {
        $('#groupsTable').DataTable().destroy();
    }

    $('#groupsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves manual sort ordering defined on server side on load
        columnDefs: [
            { orderable: false, targets: (canEditAll || canDeleteAll) ? [0, 5] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// Fetch and load groups dynamically
async function loadGroupsList() {
    let groups = [];
    if ($.fn.DataTable.isDataTable('#groupsTable')) {
        $('#groupsTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/group-lists');
        if (response.data?.status && response.data?.all_data) {
            groups = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load Groups master list.');
    }

    renderGroups(groups);
    initializeGroupsDataTable();
}

// Reset Groups Form States
function resetGroupFormState() {
    $('#editGroupId').val('');
    $('#groupName').val('').removeClass('is-invalid');
    $('#groupSortOrder').val('0').removeClass('is-invalid');
    $('#groupStatus').prop('checked', true);
    $('#error-group-name').html('');
    $('#error-group-sort-order').html('');

    $('#groupFormTitle').html('<i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন বিভাগ যুক্ত করুন');
    $('#groupFormDesc').text('মাধ্যমিক পর্যায়ের বিভাগ (উদা: Science, Humanities, Business Studies) লিখে যুক্ত করুন।');
    $('#groupSubmitBtn').prop('disabled', false).text('বিভাগ যুক্ত করুন').css('background-color', '#004d40');
    $('#groupResetBtn').hide();

    if (!canCreateAll && canEditAll) {
        $('#groupFormCard').addClass('d-none');
        $('#groupTableCard').removeClass('col-xl-8').addClass('col-xl-12');
    }
}

$('#groupResetBtn').on('click', function() {
    resetGroupFormState();
});

// Submit Group Form
const groupFormElement = document.getElementById('groupCreateForm');
if (groupFormElement) {
    groupFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('groupSubmitBtn');
        const groupNameInput = document.getElementById('groupName');
        const groupSortOrderInput = document.getElementById('groupSortOrder');
        const editId = document.getElementById('editGroupId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>সংরক্ষণ করা হচ্ছে...';

        groupNameInput.classList.remove('is-invalid');
        groupSortOrderInput.classList.remove('is-invalid');
        document.getElementById('error-group-name').innerHTML = '';
        document.getElementById('error-group-sort-order').innerHTML = '';

        const payload = {
            name: groupNameInput.value,
            sort_order: groupSortOrderInput.value,
            status: document.getElementById('groupStatus').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/group-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/group-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'বিভাগ হালনাগাদ করা হয়েছে!' : 'বিভাগ যুক্ত করা হয়েছে!',
                    text: res.data.message,
                    confirmButtonColor: '#004d40'
                });

                resetGroupFormState();
                await loadGroupsList();
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.name) {
                    groupNameInput.classList.add('is-invalid');
                    document.getElementById('error-group-name').innerHTML = errors.name[0];
                }
                if (errors.sort_order) {
                    groupSortOrderInput.classList.add('is-invalid');
                    document.getElementById('error-group-sort-order').innerHTML = errors.sort_order[0];
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
            submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'বিভাগ যুক্ত করুন';
        }
    });
}

// Edit Group trigger
$('#groupsTableBody').on('click', '.groupEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/group-details/${id}`);
        if (res.data.status === true) {
            const groupObj = res.data.data;

            if (!canCreateAll && canEditAll) {
                $('#groupFormCard').removeClass('d-none');
                $('#groupTableCard').removeClass('col-xl-12').addClass('col-xl-8');
            }

            $('#groupFormTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>বিভাগ এডিট করুন');
            $('#groupFormDesc').text(`বিভাগ আইডি হালনাগাদ করা হচ্ছে: #${groupObj.id}`);
            $('#editGroupId').val(groupObj.id);
            $('#groupName').val(groupObj.name);
            $('#groupSortOrder').val(groupObj.sort_order ?? 0);
            $('#groupStatus').prop('checked', groupObj.status == 1);

            $('#groupSubmitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e');
            $('#groupResetBtn').show();

            $('html, body').animate({
                scrollTop: $("#groupCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'বিভাগের বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// Delete Group trigger
$('#groupsTableBody').on('click', '.groupDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই বিভাগটি মাস্টার ডাটা থেকে স্থায়ীভাবে মুছে ফেলা হবে!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/group-delte/${id}`);
                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message,
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editGroupId').val() == id) {
                        resetGroupFormState();
                    }
                    await loadGroupsList();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: 'বিভাগটি মুছতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});


// Load data on document ready
$(document).ready(function () {
    loadShiftsList();
    loadGroupsList();
});
</script>
@endpush