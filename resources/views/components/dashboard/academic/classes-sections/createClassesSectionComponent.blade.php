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
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">শ্রেণী ও শাখা ব্যবস্থাপনা (Classes & Sections)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের শ্রেণীসমূহ (Class 6-10) এবং ঐচ্ছিক শাখাসমূহ (A, B, C) মাস্টার প্যানেল থেকে নিয়ন্ত্রণ করুন।</p>
        </div>
    </div>

    <!-- Navigation Tabs for Classes and Sections Panel -->
    <ul class="nav nav-tabs nav-tabs-academic border-0 mb-4 gap-2" id="academicTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes-pane" type="button" role="tab" aria-controls="classes-pane" aria-selected="true">
                <i class="fa-solid fa-graduation-cap me-2"></i>শ্রেণীসমূহ (Classes)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sections-tab" data-bs-toggle="tab" data-bs-target="#sections-pane" type="button" role="tab" aria-controls="sections-pane" aria-selected="false">
                <i class="fa-solid fa-layer-group me-2"></i>শাখাসমূহ (Sections)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="academicTabsContent">
        
        <!-- Tab 1: Classes Workspace -->
        <div class="tab-pane fade show active" id="classes-pane" role="tabpanel" aria-labelledby="classes-tab" tabindex="0">
            <div class="row g-4">
                <!-- Left: Classes Table -->
                <div class="col-12 {{ auth()->user()->can('classes_sections.create') ? 'col-xl-8' : 'col-xl-12' }}" id="classTableCard">
                    <div class="card border-0 card-responsive p-3 p-sm-4 bg-white">
                        <h5 class="fw-bold text-dark mb-4">
                            <i class="fa-solid fa-school text-success me-2"></i>সক্রিয় শ্রেণীর তালিকা
                        </h5>
                        <div class="table-responsive">
                            <table id="classesTable" class="table table-hover align-middle border-0 w-100">
                                <thead class="table-light table-academic-thead">
                                    <tr>
                                        <th>সিরিয়াল নং</th>
                                        <th>শ্রেণীর নাম</th>
                                        <th>সাজানোর ক্রম (Order)</th>
                                        <th>অবস্থা (Status)</th>
                                        <th>তৈরির তারিখ</th>
                                        {{-- @canany(['classes_sections.edit', 'classes_sections.delete']) --}}
                                            <th class="text-end">অ্যাকশন</th>
                                        {{-- @endcanany --}}
                                    </tr>
                                </thead>
                                <tbody id="classesTableBody">
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="spinner-border text-success" role="status"></div>
                                            <span class="ms-2">শ্রেণী তালিকা লোড হচ্ছে...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Classes Form -->
                {{-- @canany(['classes_sections.create', 'classes_sections.edit']) --}}
                    <div class="col-12 col-xl-4 {{ !auth()->user()->can('classes_sections.create') ? 'd-none' : '' }}" id="classFormCard">
                        <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                            <h5 class="fw-bold text-dark mb-3" id="classFormTitle">
                                <i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন শ্রেণী যুক্ত করুন
                            </h5>
                            <p class="text-muted small" id="classFormDesc">Class 6 থেকে Class 10-এর মধ্যে শ্রেণী লিখে যুক্ত করুন।</p>
                            
                            <form id="classCreateForm" novalidate>
                                <input type="hidden" id="editClassId" value="">

                                <!-- Class Name Input -->
                                <div class="mb-3">
                                    <label for="className" class="form-label fw-semibold small">শ্রেণীর নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="className" placeholder="উদা: Class 6, Class 10" required>
                                    <div class="invalid-feedback" id="error-class-name"></div>
                                </div>

                                <!-- Class Sort Order Input (Newly Added) -->
                                <div class="mb-3">
                                    <label for="classSortOrder" class="form-label fw-semibold small">সাজানোর ক্রম (Sort Order) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-lg rounded-3 fs-6" id="classSortOrder" placeholder="উদা: ১, ২, ৩" min="0" value="0" required>
                                    <div class="invalid-feedback" id="error-class-sort-order"></div>
                                </div>

                                <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                                    <label class="fw-semibold small text-muted mb-0" for="classStatus">অবস্থা (Active Status)</label>
                                    <input class="form-check-input m-0" type="checkbox" role="switch" id="classStatus" checked>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="classSubmitBtn" style="background-color: #004d40; border-color: #004d40;">
                                    শ্রেণী যুক্ত করুন
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="classResetBtn" style="display: none;">
                                    <i class="fa-solid fa-rotate-left me-1"></i>বাতিল করুন
                                </button>
                            </form>
                        </div>
                    </div>
                {{-- @endcanany --}}
            </div>
        </div>

        <!-- Tab 2: Sections Workspace -->
        <div class="tab-pane fade" id="sections-pane" role="tabpanel" aria-labelledby="sections-tab" tabindex="0">
            <div class="row g-4">
                <!-- Left: Sections Table -->
                <div class="col-12 {{ auth()->user()->can('classes_sections.create') ? 'col-xl-8' : 'col-xl-12' }}" id="sectionTableCard">
                    <div class="card border-0 card-responsive p-3 p-sm-4 bg-white">
                        <h5 class="fw-bold text-dark mb-4">
                            <i class="fa-solid fa-network-wired text-success me-2"></i>শাখার মাস্টার তালিকা
                        </h5>
                        <div class="table-responsive">
                            <table id="sectionsTable" class="table table-hover align-middle border-0 w-100">
                                <thead class="table-light table-academic-thead">
                                    <tr>
                                        <th>সিরিয়াল নং</th>
                                        <th>শাখার নাম</th>
                                        <th>সাজানোর ক্রম (Order)</th>
                                        <th>অবস্থা (Status)</th>
                                        <th>তৈরির তারিখ</th>
                                        {{-- @canany(['classes_sections.edit', 'classes_sections.delete']) --}}
                                            <th class="text-end">অ্যাকশন</th>
                                        {{-- @endcanany --}}
                                    </tr>
                                </thead>
                                <tbody id="sectionsTableBody">
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="spinner-border text-success" role="status"></div>
                                            <span class="ms-2">শাখা তালিকা লোড হচ্ছে...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Sections Form -->
                @canany(['classes_sections.create', 'classes_sections.edit'])
                    <div class="col-12 col-xl-4 {{ !auth()->user()->can('classes_sections.create') ? 'd-none' : '' }}" id="sectionFormCard">
                        <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                            <h5 class="fw-bold text-dark mb-3" id="sectionFormTitle">
                                <i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন শাখা যুক্ত করুন
                            </h5>
                            <p class="text-muted small" id="sectionFormDesc">A, B, C অথবা শাখার নাম লিখে যুক্ত করুন।</p>
                            
                            <form id="sectionCreateForm" novalidate>
                                <input type="hidden" id="editSectionId" value="">

                                <!-- Section Name Input -->
                                <div class="mb-3">
                                    <label for="sectionName" class="form-label fw-semibold small">শাখার নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="sectionName" placeholder="উদা: A, B অথবা মেঘনা, পদ্মা" required>
                                    <div class="invalid-feedback" id="error-section-name"></div>
                                </div>

                                <!-- Section Sort Order Input (Newly Added) -->
                                <div class="mb-3">
                                    <label for="sectionSortOrder" class="form-label fw-semibold small">সাজানোর ক্রম (Sort Order) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-lg rounded-3 fs-6" id="sectionSortOrder" placeholder="উদা: ১, ২, ৩" min="0" value="0" required>
                                    <div class="invalid-feedback" id="error-section-sort-order"></div>
                                </div>

                                <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                                    <label class="fw-semibold small text-muted mb-0" for="sectionStatus">অবস্থা (Active Status)</label>
                                    <input class="form-check-input m-0" type="checkbox" role="switch" id="sectionStatus" checked>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="sectionSubmitBtn" style="background-color: #004d40; border-color: #004d40;">
                                    শাখা যুক্ত করুন
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="sectionResetBtn" style="display: none;">
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
const canCreateAll = @json(auth()->user()->can('classes_sections.create'));
const canEditAll = @json(auth()->user()->can('classes_sections.edit'));
const canDeleteAll = @json(auth()->user()->can('classes_sections.delete'));

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
  CLASSES CORE AJAX MANAGEMENT WORKSPACE


  <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            ${canEditAll ? `<li><a class="dropdown-item classEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                            ${canDeleteAll ? `<li><a class="dropdown-item classDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
   </ul>

----------------------------------------------------*/

// Render Classes rows dynamically
function renderClasses(classes) {
    const rows = classes.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditAll || canDeleteAll) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            <li><a class="dropdown-item classEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>
                            <li><a class="dropdown-item classDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>
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
                            <i class="fa-solid fa-graduation-cap fs-4"></i>
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

    $('#classesTableBody').html(rows);
}

// Classes DataTable Initialization
function initializeClassesDataTable() {
    if ($.fn.DataTable.isDataTable('#classesTable')) {
        $('#classesTable').DataTable().destroy();
    }

    $('#classesTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves natural sort ordering defined on server side on load
        columnDefs: [
            { orderable: false, targets: (canEditAll || canDeleteAll) ? [0, 5] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// Fetch and load classes dynamically
async function loadClassesList() {
    let classes = [];
    if ($.fn.DataTable.isDataTable('#classesTable')) {
        $('#classesTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/school-class-lists');
        if (response.data?.status && response.data?.all_data) {
            classes = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load school classes.');
    }

    renderClasses(classes);
    initializeClassesDataTable();
}

// Reset Classes Form States
function resetClassFormState() {
    $('#editClassId').val('');
    $('#className').val('').removeClass('is-invalid');
    $('#classSortOrder').val('0').removeClass('is-invalid');
    $('#classStatus').prop('checked', true);
    $('#error-class-name').html('');
    $('#error-class-sort-order').html('');

    $('#classFormTitle').html('<i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন শ্রেণী যুক্ত করুন');
    $('#classFormDesc').text('Class 6 থেকে Class 10-এর মধ্যে শ্রেণী লিখে যুক্ত করুন।');
    $('#classSubmitBtn').prop('disabled', false).text('শ্রেণী যুক্ত করুন').css('background-color', '#004d40');
    $('#classResetBtn').hide();

    if (!canCreateAll && canEditAll) {
        $('#classFormCard').addClass('d-none');
        $('#classTableCard').removeClass('col-xl-8').addClass('col-xl-12');
    }
}

$('#classResetBtn').on('click', function() {
    resetClassFormState();
});

// Submit Class Form
const classFormElement = document.getElementById('classCreateForm');
if (classFormElement) {
    classFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('classSubmitBtn');
        const classNameInput = document.getElementById('className');
        const classSortOrderInput = document.getElementById('classSortOrder');
        const editId = document.getElementById('editClassId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>সংরক্ষণ করা হচ্ছে...';

        classNameInput.classList.remove('is-invalid');
        classSortOrderInput.classList.remove('is-invalid');
        document.getElementById('error-class-name').innerHTML = '';
        document.getElementById('error-class-sort-order').innerHTML = '';

        const payload = {
            name: classNameInput.value,
            sort_order: classSortOrderInput.value,
            status: document.getElementById('classStatus').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/school-class-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/school-class-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'শ্রেণী হালনাগাদ করা হয়েছে!' : 'শ্রেণী যুক্ত করা হয়েছে!',
                    text: res.data.message,
                    confirmButtonColor: '#004d40'
                });

                resetClassFormState();
                await loadClassesList();
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.name) {
                    classNameInput.classList.add('is-invalid');
                    document.getElementById('error-class-name').innerHTML = errors.name[0];
                }
                if (errors.sort_order) {
                    classSortOrderInput.classList.add('is-invalid');
                    document.getElementById('error-class-sort-order').innerHTML = errors.sort_order[0];
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
            submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'শ্রেণী যুক্ত করুন';
        }
    });
}

// Edit Class trigger
$('#classesTableBody').on('click', '.classEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/school-class-details/${id}`);
        if (res.data.status === true) {
            const classObj = res.data.data;

            if (!canCreateAll && canEditAll) {
                $('#classFormCard').removeClass('d-none');
                $('#classTableCard').removeClass('col-xl-12').addClass('col-xl-8');
            }

            $('#classFormTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>শ্রেণী এডিট করুন');
            $('#classFormDesc').text(`শ্রেণী আইডি হালনাগাদ করা হচ্ছে: #${classObj.id}`);
            $('#editClassId').val(classObj.id);
            $('#className').val(classObj.name);
            $('#classSortOrder').val(classObj.sort_order ?? 0);
            $('#classStatus').prop('checked', classObj.status == 1);

            $('#classSubmitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e');
            $('#classResetBtn').show();

            $('html, body').animate({
                scrollTop: $("#classCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'শ্রেণীর বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// Delete Class trigger
$('#classesTableBody').on('click', '.classDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই শ্রেণীটি মাস্টার ডাটা থেকে স্থায়ীভাবে মুছে ফেলা হবে!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/school-class-delte/${id}`);
                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message,
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editClassId').val() == id) {
                        resetClassFormState();
                    }
                    await loadClassesList();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: 'শ্রেণীটি মুছতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});


/*----------------------------------------------------
  SECTIONS CORE AJAX MANAGEMENT WORKSPACE


  <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            ${canEditAll ? `<li><a class="dropdown-item sectionEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                            ${canDeleteAll ? `<li><a class="dropdown-item sectionDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
   </ul>

----------------------------------------------------*/

// Render Sections rows dynamically
function renderSections(sections) {
    const rows = sections.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditAll || canDeleteAll) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            <li><a class="dropdown-item sectionEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>
                            <li><a class="dropdown-item sectionDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>
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
                            <i class="fa-solid fa-layer-group fs-4"></i>
                        </div>
                        <strong>Section ${item.name}</strong>
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

    $('#sectionsTableBody').html(rows);
}

// Sections DataTable Initialization
function initializeSectionsDataTable() {
    if ($.fn.DataTable.isDataTable('#sectionsTable')) {
        $('#sectionsTable').DataTable().destroy();
    }

    $('#sectionsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves natural sort ordering defined on server side on load
        columnDefs: [
            { orderable: false, targets: (canEditAll || canDeleteAll) ? [0, 5] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// Fetch and load sections dynamically
async function loadSectionsList() {
    let sections = [];
    if ($.fn.DataTable.isDataTable('#sectionsTable')) {
        $('#sectionsTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/section-lists');
        if (response.data?.status && response.data?.all_data) {
            sections = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load Sections master list.');
    }

    renderSections(sections);
    initializeSectionsDataTable();
}

// Reset Sections Form States
function resetSectionFormState() {
    $('#editSectionId').val('');
    $('#sectionName').val('').removeClass('is-invalid');
    $('#sectionSortOrder').val('0').removeClass('is-invalid');
    $('#sectionStatus').prop('checked', true);
    $('#error-section-name').html('');
    $('#error-section-sort-order').html('');

    $('#sectionFormTitle').html('<i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন শাখা যুক্ত করুন');
    $('#sectionFormDesc').text('A, B, C অথবা শাখার নাম লিখে যুক্ত করুন।');
    $('#sectionSubmitBtn').prop('disabled', false).text('শাখা যুক্ত করুন').css('background-color', '#004d40');
    $('#sectionResetBtn').hide();

    if (!canCreateAll && canEditAll) {
        $('#sectionFormCard').addClass('d-none');
        $('#sectionTableCard').removeClass('col-xl-8').addClass('col-xl-12');
    }
}

$('#sectionResetBtn').on('click', function() {
    resetSectionFormState();
});

// Submit Section Form
const sectionFormElement = document.getElementById('sectionCreateForm');
if (sectionFormElement) {
    sectionFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('sectionSubmitBtn');
        const sectionNameInput = document.getElementById('sectionName');
        const sectionSortOrderInput = document.getElementById('sectionSortOrder');
        const editId = document.getElementById('editSectionId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>সংরক্ষণ করা হচ্ছে...';

        sectionNameInput.classList.remove('is-invalid');
        sectionSortOrderInput.classList.remove('is-invalid');
        document.getElementById('error-section-name').innerHTML = '';
        document.getElementById('error-section-sort-order').innerHTML = '';

        const payload = {
            name: sectionNameInput.value,
            sort_order: sectionSortOrderInput.value,
            status: document.getElementById('sectionStatus').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/section-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/section-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'শাখা হালনাগাদ করা হয়েছে!' : 'শাখা যুক্ত করা হয়েছে!',
                    text: res.data.message,
                    confirmButtonColor: '#004d40'
                });

                resetSectionFormState();
                await loadSectionsList();
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.name) {
                    sectionNameInput.classList.add('is-invalid');
                    document.getElementById('error-section-name').innerHTML = errors.name[0];
                }
                if (errors.sort_order) {
                    sectionSortOrderInput.classList.add('is-invalid');
                    document.getElementById('error-section-sort-order').innerHTML = errors.sort_order[0];
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
            submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'শাখা যুক্ত করুন';
        }
    });
}

// Edit Section trigger
$('#sectionsTableBody').on('click', '.sectionEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/section-details/${id}`);
        if (res.data.status === true) {
            const secObj = res.data.data;

            if (!canCreateAll && canEditAll) {
                $('#sectionFormCard').removeClass('d-none');
                $('#sectionTableCard').removeClass('col-xl-12').addClass('col-xl-8');
            }

            $('#sectionFormTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>শাখা এডিট করুন');
            $('#sectionFormDesc').text(`শাখা আইডি হালনাগাদ করা হচ্ছে: #${secObj.id}`);
            $('#editSectionId').val(secObj.id);
            $('#sectionName').val(secObj.name);
            $('#sectionSortOrder').val(secObj.sort_order ?? 0);
            $('#sectionStatus').prop('checked', secObj.status == 1);

            $('#sectionSubmitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e');
            $('#sectionResetBtn').show();

            $('html, body').animate({
                scrollTop: $("#sectionCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'শাখার বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// Delete Section trigger
$('#sectionsTableBody').on('click', '.sectionDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই শাখাটি মাস্টার ডাটা থেকে স্থায়ীভাবে মুছে ফেলা হবে!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/section-delte/${id}`);
                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message,
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editSectionId').val() == id) {
                        resetSectionFormState();
                    }
                    await loadSectionsList();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: 'শাখাটি মুছতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});


// Load data on document ready
$(document).ready(function () {
    loadClassesList();
    loadSectionsList();
});
</script>
@endpush