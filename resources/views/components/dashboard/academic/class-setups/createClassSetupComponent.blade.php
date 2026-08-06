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

    /* Custom DataTables CSS */
    #setupsTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #setupsTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">শ্রেণী বিন্যাসকরণ (Class Setup)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের পুনর্ব্যবহারযোগ্য সেশন-স্বাধীন শ্রেণীর অভ্যন্তরীণ কাঠামো (শ্রেণী, শাখা, শিফট ও বিভাগ) সাজান।</p>
        </div>
    </div>

    <div class="row g-4 flex-column-reverse flex-lg-row">
        <!-- Left Column: Interactive Setups List DataTable -->
        <!-- Dynamically adjusts column span if creation form is omitted or hidden based on authorization -->
        <div class="col-12 {{ auth()->user()->can('class_setups.create') ? 'col-xl-8 col-lg-7' : 'col-xl-12' }}" id="tableCard">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-graduation-cap text-success me-2"></i>বিদ্যালয়ের শিক্ষাবর্ষ কাঠামো তালিকা
                </h5>
                
                <div class="table-responsive">
                    <table id="setupsTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>সিরিয়াল নং</th>
                                <th>শ্রেণী (Class)</th>
                                <th>শাখা (Section)</th>
                                <th>শিফট (Shift)</th>
                                <th>বিভাগ (Group)</th>
                                <th>অবস্থা</th>
                                <!-- Hide Action header completely if user cannot edit/delete -->
                                @canany(['class_setups.edit', 'class_setups.delete'])
                                    <th class="text-end">অ্যাকশন</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody id="setupsTableBody">
                            <tr>
                                <td colspan="{{ auth()->user()->canAny(['class_setups.edit', 'class_setups.delete']) ? 7 : 6 }}" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">বিন্যাস তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Create / Edit Class Setup Form -->
        <!-- Displayed only if the user is authorized to create or edit configurations -->
        @canany(['class_setups.create', 'class_setups.edit'])
            <div class="col-12 col-xl-4 col-lg-5 {{ !auth()->user()->can('class_setups.create') ? 'd-none' : '' }}" id="formCard">
                <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                    <h5 class="fw-bold text-dark mb-3" id="formTitle">
                        <i class="fa-solid fa-sliders me-2 text-warning"></i>Add Class Setup
                    </h5>
                    <p class="text-muted small" id="formDesc">বিদ্যালয়ের শ্রেণী কাঠামোর নতুন বিন্যাস তৈরি করুন।</p>
                    
                    <form id="classSetupCreateForm" novalidate>
                        <!-- Hidden input to store Configuration ID when editing -->
                        <input type="hidden" id="editSetupId" value="">

                        <!-- Class Dropdown (Required) -->
                        <div class="mb-3">
                            <label for="classId" class="form-label fw-semibold small text-dark">শ্রেণী (Class) <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 fs-6 form-control-academic" id="classId" required>
                                <option value="" selected disabled>শ্রেণী নির্বাচন করুন...</option>
                            </select>
                            <div class="invalid-feedback" id="error-class-id"></div>
                        </div>

                        <!-- Section Dropdown (Optional) -->
                        <div class="mb-3">
                            <label for="sectionId" class="form-label fw-semibold small text-secondary">শাখা (Section)</label>
                            <select class="form-select form-select-lg rounded-3 fs-6 form-control-academic" id="sectionId">
                                <option value="" selected>Select Section</option>
                            </select>
                            <div class="invalid-feedback" id="error-section-id"></div>
                        </div>

                        <!-- Shift Dropdown (Optional) -->
                        <div class="mb-3">
                            <label for="shiftId" class="form-label fw-semibold small text-secondary">শিফট (Shift)</label>
                            <select class="form-select form-select-lg rounded-3 fs-6 form-control-academic" id="shiftId">
                                <option value="" selected>Select Shift</option>
                            </select>
                            <div class="invalid-feedback" id="error-shift-id"></div>
                        </div>

                        <!-- Group Dropdown (Optional) -->
                        <div class="mb-3">
                            <label for="groupId" class="form-label fw-semibold small text-secondary">বিভাগ (Group)</label>
                            <select class="form-select form-select-lg rounded-3 fs-6 form-control-academic" id="groupId">
                                <option value="" selected>Select Group</option>
                            </select>
                            <div class="invalid-feedback" id="error-group-id"></div>
                        </div>

                        <!-- Is Active Toggle Switch -->
                        <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                            <label class="fw-semibold small text-muted mb-0" for="status">অবস্থা (Active Status)</label>
                            <input class="form-check-input m-0" type="checkbox" role="switch" id="status" checked>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                            Create Class Setup
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
// 1. Pass Sptie Gate Authorization States to JavaScript
const canCreateSetup = @json(auth()->user()->can('class_setups.create'));
const canEditSetup = @json(auth()->user()->can('class_setups.edit'));
const canDeleteSetup = @json(auth()->user()->can('class_setups.delete'));

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
function renderSetups(setups) {
    const rows = setups.map((item, index) => {
        let actionColumnHtml = '';
        if (canEditSetup || canDeleteSetup) {
            actionColumnHtml = `
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                            অ্যাকশন
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                            ${canEditSetup ? `<li><a class="dropdown-item setupEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                            ${canDeleteSetup ? `<li><a class="dropdown-item setupDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                        </ul>
                    </div>
                </td>
            `;
        }

        const banglaSerial = convertToBanglaNumber(index + 1);

        // Display empty master relationship references cleanly
        const className = item.class ? item.class.name : '—';
        const sectionName = item.section ? item.section.name : '—';
        const shiftName = item.shift ? item.shift.name : '—';
        const groupName = item.group ? item.group.name : '—';

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td class="fw-semibold">${className}</td>
                <td>${sectionName}</td>
                <td>${shiftName}</td>
                <td>${groupName}</td>
                <td>
                    <span class="badge ${item.status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} px-3 py-2 rounded-pill fw-bold">
                        ${item.status ? 'সক্রিয়' : 'নিষ্ক্রিয়'}
                    </span>
                </td>
                ${actionColumnHtml}
            </tr>
        `;
    }).join('');

    $('#setupsTableBody').html(rows);
}

// DataTables Initialization
function initializeSetupsDataTable() {
    if ($.fn.DataTable.isDataTable('#setupsTable')) {
        $('#setupsTable').DataTable().destroy();
    }

    $('#setupsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves manual display priority set on controller side on load
        columnDefs: [
            { orderable: false, targets: (canEditSetup || canDeleteSetup) ? [0, 6] : [0] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// 3. Load all workspace setups dynamically
async function loadSetupsList() {
    let setups = [];
    if ($.fn.DataTable.isDataTable('#setupsTable')) {
        $('#setupsTable').DataTable().destroy();
    }

    try {
        const response = await axios.get('/api/class-setup-lists');
        if (response.data?.status && response.data?.all_data) {
            setups = response.data.all_data;
        }
    } catch (error) {
        console.warn('Failed to load classes setups.');
    }

    renderSetups(setups);
    initializeSetupsDataTable();
}

// 4. Fetch dynamic dropdown datasets from active master tables
async function loadFormDropdowns() {
    try {
        const [classesRes, sectionsRes, shiftsRes, groupsRes] = await axios.all([
            axios.get('/api/school-class-lists'),
            axios.get('/api/section-lists'),
            axios.get('/api/shift-lists'),
            axios.get('/api/group-lists')
        ]);

        // Populate active Classes
        if (classesRes.data?.status && classesRes.data?.data) {
            let classOptions = '<option value="" selected disabled>শ্রেণী নির্বাচন করুন...</option>';
            classesRes.data.data.forEach(item => {
                classOptions += `<option value="${item.id}">${item.name}</option>`;
            });
            $('#classId').html(classOptions);
        }

        // Populate active Sections
        if (sectionsRes.data?.status && sectionsRes.data?.data) {
            let sectionOptions = '<option value="">Select Section</option>';
            sectionsRes.data.data.forEach(item => {
                sectionOptions += `<option value="${item.id}">${item.name}</option>`;
            });
            $('#sectionId').html(sectionOptions);
        }

        // Populate active Shifts
        if (shiftsRes.data?.status && shiftsRes.data?.data) {
            let shiftOptions = '<option value="">Select Shift</option>';
            shiftsRes.data.data.forEach(item => {
                shiftOptions += `<option value="${item.id}">${item.name}</option>`;
            });
            $('#shiftId').html(shiftOptions);
        }

        // Populate active Groups
        if (groupsRes.data?.status && groupsRes.data?.data) {
            let groupOptions = '<option value="">Select Group</option>';
            groupsRes.data.data.forEach(item => {
                groupOptions += `<option value="${item.id}">${item.name}</option>`;
            });
            $('#groupId').html(groupOptions);
        }

    } catch (error) {
        console.warn('Failed to populate dynamic form datasets.');
    }
}

// Reset Form State
function resetFormState() {
    $('#editSetupId').val('');
    $('#classId').val('').removeClass('is-invalid');
    $('#sectionId').val('').removeClass('is-invalid');
    $('#shiftId').val('').removeClass('is-invalid');
    $('#groupId').val('').removeClass('is-invalid');
    $('#status').prop('checked', true);

    // Clear Validation Errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

    $('#formTitle').html('<i class="fa-solid fa-sliders me-2 text-warning"></i>Add Class Setup');
    $('#formDesc').text('বিদ্যালয়ের শ্রেণী কাঠামোর নতুন বিন্যাস তৈরি করুন।');
    
    $('#submitBtn').prop('disabled', false).text('Create Class Setup').css('background-color', '#004d40');
    $('#resetBtn').hide();

    // Dynamically collapse and hide form card if the user is authorized to edit but not create
    if (!canCreateSetup && canEditSetup) {
        $('#formCard').addClass('d-none');
        $('#tableCard').removeClass('col-xl-8 col-lg-7').addClass('col-xl-12');
    }
}

// Reset button click trigger
$('#resetBtn').on('click', function() {
    resetFormState();
});

// 5. Submit Form (Handles Create and Update using AJAX API calls)
const createFormElement = document.getElementById('classSetupCreateForm');
if (createFormElement) {
    createFormElement.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const classIdInput = document.getElementById('classId');
        const sectionIdInput = document.getElementById('sectionId');
        const shiftIdInput = document.getElementById('shiftId');
        const groupIdInput = document.getElementById('groupId');
        const editId = document.getElementById('editSetupId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...';

        // Clear previous error styles
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

        const payload = {
            class_id: classIdInput.value,
            section_id: sectionIdInput.value || null,
            shift_id: shiftIdInput.value || null,
            group_id: groupIdInput.value || null,
            status: document.getElementById('status').checked ? 1 : 0
        };

        try {
            let res;
            if (editId) {
                res = await axios.post(`/api/class-setup-update/${editId}`, payload);
            } else {
                res = await axios.post('/api/class-setup-store', payload);
            }

            if (res.data.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: editId ? 'শ্রেণী বিন্যাস হালনাগাদ সম্পন্ন!' : 'শ্রেণী বিন্যাস সফলভাবে তৈরি!',
                    text: res.data.message || 'Academic configuration has been stored successfully.',
                    confirmButtonColor: '#004d40'
                });

                resetFormState(); 
                await loadSetupsList(); 
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                const generalMessage = error.response.data.message;

                // Bind Laravel validation rules back to client side elements
                if (errors) {
                    if (errors.class_id) {
                        classIdInput.classList.add('is-invalid');
                        document.getElementById('error-class-id').innerHTML = errors.class_id[0];
                    }
                    if (errors.section_id) {
                        sectionIdInput.classList.add('is-invalid');
                        document.getElementById('error-section-id').innerHTML = errors.section_id[0];
                    }
                    if (errors.shift_id) {
                        shiftIdInput.classList.add('is-invalid');
                        document.getElementById('error-shift-id').innerHTML = errors.shift_id[0];
                    }
                    if (errors.group_id) {
                        groupIdInput.classList.add('is-invalid');
                        document.getElementById('error-group-id').innerHTML = errors.group_id[0];
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
            submitBtn.innerHTML = editId ? 'Update Configuration' : 'Create Class Setup';
        }
    });
}

// 6. jQuery Event Delegation for Edit Button Click (Without Reload)
$('#setupsTableBody').on('click', '.setupEdit', async function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    try {
        const res = await axios.get(`/api/class-setup-details/${id}`);

        if (res.data.status === true) {
            const setup = res.data.data;
            
            // Switch Form column width dynamically for restricted users (Edit only)
            if (!canCreateSetup && canEditSetup) {
                $('#formCard').removeClass('d-none');
                $('#tableCard').removeClass('col-xl-12').addClass('col-xl-8 col-lg-7');
            }

            // Switch form to Edit Mode
            $('#formTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit Class Setup');
            $('#formDesc').text(`Updating Configuration ID: #${setup.id}`);
            $('#editSetupId').val(setup.id);
            $('#classId').val(setup.class_id);
            $('#sectionId').val(setup.section_id ?? '');
            $('#shiftId').val(setup.shift_id ?? '');
            $('#groupId').val(setup.group_id ?? '');
            $('#status').prop('checked', setup.status == 1);

            $('#submitBtn').text('Update Configuration').css('background-color', '#1a237e'); // Primary contrast for edit mode
            $('#resetBtn').show(); 
            
            // Scroll smoothly to form card on mobile devices
            $('html, body').animate({
                scrollTop: $("#classSetupCreateForm").offset().top - 100
            }, 300);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'শ্রেণী বিন্যাসের বিবরণ লোড করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// 7. Delete Button Click Event Delegation (SweetAlert2 + Without Reload)
$('#setupsTableBody').on('click', '.setupDelete', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই শ্রেণী বিন্যাসটি ডিলিট করলে এর ডাটা আর পুনরুদ্ধার করা যাবে না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/class-setup-delte/${id}`);

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message || 'The configuration has been deleted successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    if ($('#editSetupId').val() == id) {
                        resetFormState();
                    }

                    await loadSetupsList(); 
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
    loadFormDropdowns();
    loadSetupsList();
});
</script>
@endpush