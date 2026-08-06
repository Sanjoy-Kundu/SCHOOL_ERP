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
    #subjectsTable tbody td, #papersTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">বিষয় ও পত্র ব্যবস্থাপনা (Subjects & Papers)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের জন্য ডাইনামিক মাস্টার বিষয় এবং এর স্বাধীন মাস্টার পত্রসমূহ আলাদাভাবে নিয়ন্ত্রণ করুন।</p>
        </div>
    </div>

    <!-- Navigation Tabs for Subjects and Papers Panel -->
    <ul class="nav nav-tabs nav-tabs-academic border-0 mb-4 gap-2" id="academicTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects-pane" type="button" role="tab" aria-controls="subjects-pane" aria-selected="true">
                <i class="fa-solid fa-book-open me-2"></i>বিষয়সমূহ (Subjects)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="papers-tab" data-bs-toggle="tab" data-bs-target="#papers-pane" type="button" role="tab" aria-controls="papers-pane" aria-selected="false">
                <i class="fa-solid fa-layer-group me-2"></i>ঐচ্ছিক পত্রসমূহ (Papers)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="academicTabsContent">
        
        <!-- Tab 1: Subjects Workspace -->
        <div class="tab-pane fade show active" id="subjects-pane" role="tabpanel" aria-labelledby="subjects-tab" tabindex="0">
            <div class="row g-4">
                <!-- Left: Subjects Table -->
                <div class="col-12 {{ auth()->user()->can('subjects_papers.create') ? 'col-xl-8 col-lg-7' : 'col-xl-12' }}" id="subjectTableCard">
                    <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                        <h5 class="fw-bold text-dark mb-4">
                            <i class="fa-solid fa-book text-success me-2"></i>সক্রিয় বিষয়ের তালিকা
                        </h5>
                        <div class="table-responsive">
                            <table id="subjectsTable" class="table table-hover align-middle border-0 w-100">
                                <thead class="table-light table-academic-thead">
                                    <tr>
                                        <th>সিরিয়াল নং</th>
                                        <th>বিষয়ের নাম</th>
                                        <th>তৈরির তারিখ</th>
                                        {{-- @canany(['subjects_papers.edit', 'subjects_papers.delete']) --}}
                                            <th class="text-end">অ্যাকশন</th>
                                        {{-- @endcanany --}}
                                    </tr>
                                </thead>
                                <tbody id="subjectsTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="spinner-border text-success" role="status"></div>
                                            <span class="ms-2">বিষয়ের তালিকা লোড হচ্ছে...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Subjects Form -->
                {{-- @canany(['subjects_papers.create', 'subjects_papers.edit']) --}}
                    <div class="col-12 col-xl-4 col-lg-5 {{ !auth()->user()->can('subjects_papers.create') ? 'd-none' : '' }}" id="subjectFormCard">
                        <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                            <h5 class="fw-bold text-dark mb-3" id="subjectFormTitle">
                                <i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন বিষয় যুক্ত করুন
                            </h5>
                            <p class="text-muted small" id="subjectFormDesc">নতুন স্বাধীন মাস্টার বিষয় (উদা: বাংলা, ইংরেজি, সাধারণ গণিত) যুক্ত করুন।</p>
                            
                            <form id="subjectCreateForm" novalidate>
                                <input type="hidden" id="editSubjectId" value="">

                                <div class="mb-4">
                                    <label for="subjectName" class="form-label fw-semibold small">বিষয়ের নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="subjectName" placeholder="উদা: বাংলা, সাধারণ গণিত" required>
                                    <div class="invalid-feedback" id="error-subject-name"></div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="subjectSubmitBtn" style="background-color: #004d40; border-color: #004d40;">
                                    বিষয় যুক্ত করুন
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="subjectResetBtn" style="display: none;">
                                    <i class="fa-solid fa-rotate-left me-1"></i>পরিবর্তন বাতিল করুন
                                </button>
                            </form>
                        </div>
                    </div>
                {{-- @endcanany --}}
            </div>
        </div>

        <!-- Tab 2: Papers Workspace -->
        <div class="tab-pane fade" id="papers-pane" role="tabpanel" aria-labelledby="papers-tab" tabindex="0">
            <div class="row g-4">
                <!-- Left: Papers Table -->
                <div class="col-12 {{ auth()->user()->can('subjects_papers.create') ? 'col-xl-8 col-lg-7' : 'col-xl-12' }}" id="paperTableCard">
                    <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                        <h5 class="fw-bold text-dark mb-4">
                            <i class="fa-solid fa-layer-group text-success me-2"></i>ঐচ্ছিক পত্রের মাস্টার তালিকা
                        </h5>
                        <div class="table-responsive">
                            <table id="papersTable" class="table table-hover align-middle border-0 w-100">
                                <thead class="table-light table-academic-thead">
                                    <tr>
                                        <th>সিরিয়াল নং</th>
                                        <th>পত্রের নাম</th>
                                        <th>তৈরির তারিখ</th>
                                        {{-- @canany(['subjects_papers.edit', 'subjects_papers.delete']) --}}
                                            <th class="text-end">অ্যাকশন</th>
                                        {{-- @endcanany --}}
                                    </tr>
                                </thead>
                                <tbody id="papersTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="spinner-border text-success" role="status"></div>
                                            <span class="ms-2">শাখা তালিকা লোড হচ্ছে...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Papers Form -->
                {{-- @canany(['subjects_papers.create', 'subjects_papers.edit']) --}}
                    <div class="col-12 col-xl-4 col-lg-5 {{ !auth()->user()->can('subjects_papers.create') ? 'd-none' : '' }}" id="paperFormCard">
                        <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                            <h5 class="fw-bold text-dark mb-3" id="paperFormTitle">
                                <i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন পত্র যুক্ত করুন
                            </h5>
                            <p class="text-muted small" id="paperFormDesc">নতুন স্বাধীন মাস্টার পত্র (উদা: ১ম পত্র, ২য় পত্র) যুক্ত করুন।</p>
                            
                            <form id="paperCreateForm" novalidate>
                                <input type="hidden" id="editPaperId" value="">

                                <div class="mb-4">
                                    <label for="paperName" class="form-label fw-semibold small">পত্রের নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="paperName" placeholder="উদা: ১ম পত্র, ২য় পত্র" required>
                                    <div class="invalid-feedback" id="error-paper-name"></div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="paperSubmitBtn" style="background-color: #004d40; border-color: #004d40;">
                                    পত্র যুক্ত করুন
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="paperResetBtn" style="display: none;">
                                    <i class="fa-solid fa-rotate-left me-1"></i>পরিবর্তন বাতিল করুন
                                </button>
                            </form>
                        </div>
                    </div>
                {{-- @endcanany --}}
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
const canCreateAll = @json(auth()->user()->can('subjects_papers.create'));
const canEditAll = @json(auth()->user()->can('subjects_papers.edit'));
const canDeleteAll = @json(auth()->user()->can('subjects_papers.delete'));

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
  SUBJECTS CORE AJAX MANAGEMENT WORKSPACE
----------------------------------------------------*/

// Render Subjects rows dynamically
function renderSubjects(subjects) {
    const rows = subjects.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditAll || canDeleteAll) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            ${canEditAll ? `<li><a class="dropdown-item subjectEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                            ${canDeleteAll ? `<li><a class="dropdown-item subjectDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                        </ul>
                    </div>
                </td>
            `;
        }

        const banglaSerial = convertToBanglaNumber(index + 1);

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-light border rounded-3 p-1 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; color: #004d40;">
                            <i class="fa-solid fa-book-open fs-4"></i>
                        </div>
                        <strong>${item.name}</strong>
                    </div>
                </td>
                <td class="text-muted small">${formatBDDate(item.created_at)}</td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#subjectsTableBody').html(rows);
}

// Subjects DataTable Initialization
function initializeSubjectsDataTable() {
    if ($.fn.DataTable.isDataTable('#subjectsTable')) {
        $('#subjectsTable').DataTable().destroy();
    }

    $('#subjectsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves server-side sorted sequence
        columnDefs: [
            { orderable: false, targets: (canEditAll || canDeleteAll) ? [0, 3] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// Fetch all subjects dynamically
async function loadSubjectsList() {
    let subjects = [];
    if ($.fn.DataTable.isDataTable('#subjectsTable')) {
        $('#subjectsTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/subject-lists');
        if (response.data?.status && response.data?.all_data) {
            subjects = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load school subjects master list.');
    }

    renderSubjects(subjects);
    initializeSubjectsDataTable();
}

// Reset Subjects Form States
function resetSubjectFormState() {
    $('#editSubjectId').val('');
    $('#subjectName').val('').removeClass('is-invalid');
    $('#error-subject-name').html('');

    $('#subjectFormTitle').html('<i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন বিষয় যুক্ত করুন');
    $('#subjectFormDesc').text('নতুন মাস্টার বিষয় (উদা: বাংলা, ইংরেজি, সাধারণ গণিত) যুক্ত করুন।');
    $('#subjectSubmitBtn').prop('disabled', false).text('বিষয় যুক্ত করুন').css('background-color', '#004d40');
    $('#subjectResetBtn').hide();

    if (!canCreateAll && canEditAll) {
        $('#subjectFormCard').addClass('d-none');
        $('#subjectTableCard').removeClass('col-xl-8 col-lg-7').addClass('col-xl-12');
    }
}

$('#subjectResetBtn').on('click', function() {
    resetSubjectFormState();
});

// Submit Subject Form
const subjectFormElement = document.getElementById('subjectCreateForm');
if (subjectFormElement) {
    subjectFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('subjectSubmitBtn');
        const subjectNameInput = document.getElementById('subjectName');
        const editId = document.getElementById('editSubjectId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>সংরক্ষণ করা হচ্ছে...';

        subjectNameInput.classList.remove('is-invalid');
        document.getElementById('error-subject-name').innerHTML = '';

        const payload = {
            name: subjectNameInput.value
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/subject-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/subject-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'বিষয় হালনাগাদ সম্পন্ন!' : 'বিষয় সফলভাবে তৈরি!',
                    text: res.data.message || 'Subject master has been saved successfully.',
                    confirmButtonColor: '#004d40'
                });

                resetSubjectFormState(); 
                await loadSubjectsList(); 
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors && errors.name) {
                    subjectNameInput.classList.add('is-invalid');
                    document.getElementById('error-subject-name').innerHTML = errors.name[0];
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
            submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'বিষয় যুক্ত করুন';
        }
    });
}

// Edit Subject trigger
$('#subjectsTableBody').on('click', '.subjectEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/subject-details/${id}`);
        if (res.data.status === true) {
            const subject = res.data.data;
            
            if (!canCreateAll && canEditAll) {
                $('#subjectFormCard').removeClass('d-none');
                $('#subjectTableCard').removeClass('col-xl-12').addClass('col-xl-8 col-lg-7');
            }

            $('#subjectFormTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>বিষয় এডিট করুন');
            $('#subjectFormDesc').text(`বিষয় আইডি হালনাগাদ করা হচ্ছে: #${subject.id}`);
            $('#editSubjectId').val(subject.id);
            $('#subjectName').val(subject.name);

            $('#subjectSubmitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e');
            $('#subjectResetBtn').show(); 
            
            $('html, body').animate({
                scrollTop: $("#subjectCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'विषয়ের বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// Delete Subject trigger
$('#subjectsTableBody').on('click', '.subjectDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই বিষয়টি মাস্টার ডাটা থেকে ডিলিট করতে চান?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/subject-delte/${id}`);
                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message || 'The subject has been deleted successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editSubjectId').val() == id) {
                        resetFormState();
                    }
                    await loadSubjectsList(); 
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


/*----------------------------------------------------
  PAPERS CORE AJAX MANAGEMENT WORKSPACE
----------------------------------------------------*/

// Render Papers rows dynamically
function renderPapers(papers) {
    const rows = papers.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditAll || canDeleteAll) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            ${canEditAll ? `<li><a class="dropdown-item paperEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                            ${canDeleteAll ? `<li><a class="dropdown-item paperDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                        </ul>
                    </div>
                </td>
            `;
        }

        const banglaSerial = convertToBanglaNumber(index + 1);

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-light border rounded-3 p-1 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; color: #004d40;">
                            <i class="fa-solid fa-layer-group fs-4"></i>
                        </div>
                        <strong>${item.name}</strong>
                    </div>
                </td>
                <td class="text-muted small">${formatBDDate(item.created_at)}</td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#papersTableBody').html(rows);
}

// Papers DataTable Initialization
function initializePapersDataTable() {
    if ($.fn.DataTable.isDataTable('#papersTable')) {
        $('#papersTable').DataTable().destroy();
    }

    $('#papersTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves server-side sorted sequence
        columnDefs: [
            { orderable: false, targets: (canEditAll || canDeleteAll) ? [0, 3] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// Fetch and load papers dynamically
async function loadPapersList() {
    let papers = [];
    if ($.fn.DataTable.isDataTable('#papersTable')) {
        $('#papersTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/paper-lists');
        if (response.data?.status && response.data?.all_data) {
            papers = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load Papers master list.');
    }

    renderPapers(papers);
    initializePapersDataTable();
}

// Reset Papers Form States
function resetPaperFormState() {
    $('#editPaperId').val('');
    $('#paperName').val('').removeClass('is-invalid');
    $('#error-paper-name').html('');

    $('#paperFormTitle').html('<i class="fa-solid fa-circle-plus me-2 text-warning"></i>নতুন পত্র যুক্ত করুন');
    $('#paperFormDesc').text('নতুন স্বাধীন মাস্টার পত্র (উদা: ১ম পত্র, ২য় পত্র) যুক্ত করুন।');
    $('#paperSubmitBtn').prop('disabled', false).text('পত্র যুক্ত করুন').css('background-color', '#004d40');
    $('#paperResetBtn').hide();

    if (!canCreateAll && canEditAll) {
        $('#paperFormCard').addClass('d-none');
        $('#paperTableCard').removeClass('col-xl-8 col-lg-7').addClass('col-xl-12');
    }
}

$('#paperResetBtn').on('click', function() {
    resetPaperFormState();
});

// Submit Paper Form
const paperFormElement = document.getElementById('paperCreateForm');
if (paperFormElement) {
    paperFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('paperSubmitBtn');
        const paperNameInput = document.getElementById('paperName');
        const editId = document.getElementById('editPaperId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>সংরক্ষণ করা হচ্ছে...';

        paperNameInput.classList.remove('is-invalid');
        document.getElementById('error-paper-name').innerHTML = '';

        const payload = {
            name: paperNameInput.value
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/paper-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/paper-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'পত্র হালনাগাদ সম্পন্ন!' : 'পত্র সফলভাবে যুক্ত!',
                    text: res.data.message,
                    confirmButtonColor: '#004d40'
                });

                resetPaperFormState();
                await loadPapersList();
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                if (errors.name) {
                    paperNameInput.classList.add('is-invalid');
                    document.getElementById('error-paper-name').innerHTML = errors.name[0];
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
            submitBtn.innerHTML = editId ? 'হালনাগাদ সম্পন্ন করুন' : 'পত্র যুক্ত করুন';
        }
    });
}

// Edit Paper trigger
$('#papersTableBody').on('click', '.paperEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/paper-details/${id}`);
        if (res.data.status === true) {
            const paperObj = res.data.data;

            if (!canCreateAll && canEditAll) {
                $('#paperFormCard').removeClass('d-none');
                $('#paperTableCard').removeClass('col-xl-12').addClass('col-xl-8 col-lg-7');
            }

            $('#paperFormTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>পত্র এডিট করুন');
            $('#paperFormDesc').text(`পত্র আইডি হালনাগাদ করা হচ্ছে: #${paperObj.id}`);
            $('#editPaperId').val(paperObj.id);
            $('#paperName').val(paperObj.name);

            $('#paperSubmitBtn').text('হালনাগাদ সম্পন্ন করুন').css('background-color', '#1a237e');
            $('#paperResetBtn').show();

            $('html, body').animate({
                scrollTop: $("#paperCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'পত্রের বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// Delete Paper trigger
$('#papersTableBody').on('click', '.paperDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই মাস্টার পত্রটি ডিলিট করতে চান?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/paper-delte/${id}`);
                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message,
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editPaperId').val() == id) {
                        resetPaperFormState();
                    }
                    await loadPapersList();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: 'পত্রটি মুছতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});


// Load data on document ready
$(document).ready(function () {
    loadSubjectsList();
    loadPapersList();
});
</script>
@endpush