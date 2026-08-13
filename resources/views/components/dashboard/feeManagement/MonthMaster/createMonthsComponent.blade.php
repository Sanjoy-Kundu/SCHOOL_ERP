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
    #monthsTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #monthsTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
</style>
@endpush


<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">শিক্ষাবর্ষ মাস নির্ধারণ (Month Management)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের ফি কাঠামো (Fee Structure) তৈরির জন্য ব্যবহৃত শিক্ষাবর্ষের অ্যাক্টিভ মাসসমূহ সাজান।</p>
        </div>
    </div>

    <!-- Layout Container (Always 2-Column Split both on Screen and Operation) -->
    <div class="row g-4 flex-column-reverse flex-lg-row">
        <!-- Left Column: Interactive Months List Table -->
        <div class="col-12 col-xl-8 col-lg-7" id="tableCard">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-calendar-days text-success me-2"></i>একাডেমিক শিক্ষাবর্ষ মাস তালিকা
                </h5>
                
                <div class="table-responsive">
                    <table id="monthsTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 15%;">সর্ট অর্ডার</th>
                                <th>মাসের নাম</th>
                                <th style="width: 20%; text-align: center;">অবস্থা</th>
                                <th class="text-end" style="width: 20%;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody id="monthsTableBody">
                            <tr>
                                <td colspan="4" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">শিক্ষাবর্ষ মাস তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Create / Edit Month Form Panel (Always Visible) -->
        <div class="col-12 col-xl-4 col-lg-5" id="formCard">
            <div class="card border-0 card-responsive shadow-sm bg-white p-3 p-sm-4 p-md-5">
                <h5 class="fw-bold text-dark mb-3" id="formTitle">
                    <i class="fa-solid fa-sliders me-2 text-warning"></i>Add Month
                </h5>
                <p class="text-muted small" id="formDesc">ফি কাঠামোর জন্য নতুন একটি মাস নির্ধারণ করুন।</p>
                
                <form id="monthCreateForm" novalidate>
                    <!-- Hidden input to store Configuration ID when editing -->
                    <input type="hidden" id="editMonthId" value="">

                    <!-- Month Name (Required) -->
                    <div class="mb-3">
                        <label for="monthName" class="form-label fw-semibold small text-dark">মাসের নাম <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="monthName" placeholder="উদাঃ January, February" required>
                        <div class="invalid-feedback" id="error-name"></div>
                    </div>

                    <!-- Sort Order (Required) -->
                    <div class="mb-3">
                        <label for="monthSort" class="form-label fw-semibold small text-dark">সর্ট অর্ডার (Sort Order) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-lg rounded-3 fs-6" id="monthSort" min="1" value="1" required>
                        <div class="invalid-feedback" id="error-sort-order"></div>
                    </div>

                    <!-- Is Active Toggle Switch -->
                    <div class="mb-4 form-check form-switch d-flex align-items-center justify-content-between p-0">
                        <label class="fw-semibold small text-muted mb-0" for="status">অবস্থা (Active Status)</label>
                        <input class="form-check-input m-0" type="checkbox" role="switch" id="status" checked>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold fs-6" id="submitBtn" style="background-color: #004d40; border-color: #004d40;">
                        Create Month
                    </button>

                    <!-- Cancel Button -->
                    <button type="button" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3 fw-bold fs-6 mt-2" id="resetBtn" style="display: none;">
                        <i class="fa-solid fa-rotate-left me-1"></i>Cancel Edit
                    </button>
                </form>
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
{
    // Global local arrays inside current scope context
    let loadedMonths = [];

    // Spatie dynamic gate permission check replacements
    const canCreateMonth = true; 
    const canEditMonth = true; 
    const canDeleteMonth = true;

    // English to Bangla Digit Converter Utility
    function convertToBanglaNumber(number) {
        if (number === undefined || number === null || number === '') return '—';
        const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
        return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
    }

    // Dynamic UI Table Rendering with safe action mappings
    function renderMonths(months) {
        const rows = months.map((item, index) => {
            let actionColumnHtml = '';
            if (canEditMonth || canDeleteMonth) {
                actionColumnHtml = `
                    <td class="text-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm rounded-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #004d40; color: #ffffff;">
                                অ্যাকশন
                            </button>
                            <ul class="dropdown-menu shadow border-0 rounded-3 mt-1">
                                ${canEditMonth ? `<li><a class="dropdown-item monthEdit py-2 px-3 small" href="#" data-id="${item.id}"><i class="fa-solid fa-pencil text-warning me-2"></i>এডিট করুন</a></li>` : ''}
                                ${canDeleteMonth ? `<li><a class="dropdown-item monthDelete py-2 px-3 small text-danger" href="#" data-id="${item.id}"><i class="fa-solid fa-trash-can me-2"></i>ডিলিট করুন</a></li>` : ''}
                            </ul>
                        </div>
                    </td>
                `;
            }

            return `
                <tr id="row-${item.id}">
                    <td class="fw-bold text-secondary ps-3">${convertToBanglaNumber(item.sort_order)}</td>
                    <td class="fw-semibold text-dark">${item.name}</td>
                    <td class="text-center">
                        <div class="form-check form-switch d-inline-block p-0">
                            <input class="form-check-input m-0 toggle-status-switch" type="checkbox" role="switch" data-id="${item.id}" ${item.is_active ? 'checked' : ''}>
                        </div>
                    </td>
                    ${actionColumnHtml}
                </tr>
            `;
        }).join('');

        $('#monthsTableBody').html(rows);
    }

    // DataTables Initialization Configuration
    function initializeMonthsDataTable() {
        if ($.fn.DataTable.isDataTable('#monthsTable')) {
            $('#monthsTable').DataTable().destroy();
        }

        $('#monthsTable').DataTable({
            pageLength: 12, // Standard calendar month count
            lengthMenu: [12, 24, 50],
            responsive: true,
            order: [], // Preserves custom manual priority sorting loaded from API side
            columnDefs: [
                { orderable: false, targets: (canEditMonth || canDeleteMonth) ? [2, 3] : [2] }
            ],
            language: {
                search: 'সহজ অনুসন্ধান:',
                lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
            }
        });
    }

    // Load active academic months dataset
    async function loadMonthsList() {
        if ($.fn.DataTable.isDataTable('#monthsTable')) {
            $('#monthsTable').DataTable().destroy();
        }

        try {
            const response = await axios.get('/api/fees/months/lists');
            if (response.data?.status && response.data?.all_data) {
                loadedMonths = response.data.all_data;
                renderMonths(loadedMonths);
                initializeMonthsDataTable();
            }
        } catch (error) {
            console.warn('Failed to load months dataset.', error);
        }
    }

    // Reset Form Input State & validation styles (Form column kept visible)
    function resetFormState() {
        $('#editMonthId').val('');
        $('#monthName').val('').removeClass('is-invalid');
        $('#monthSort').val('1').removeClass('is-invalid');
        $('#status').prop('checked', true);

        // Clear previous validation error elements
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

        $('#formTitle').html('<i class="fa-solid fa-sliders me-2 text-warning"></i>Add Month');
        $('#formDesc').text('ফি কাঠামোর জন্য নতুন একটি মাস নির্ধারণ করুন।');
        
        $('#submitBtn').prop('disabled', false).text('Create Month').css('background-color', '#004d40');
        $('#resetBtn').hide();
    }

    // Reset Trigger action mapping
    $('#resetBtn').on('click', function() {
        resetFormState();
    });

    // Submit Create or Update Configuration
    const createFormElement = document.getElementById('monthCreateForm');
    if (createFormElement) {
        createFormElement.addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const nameInput = document.getElementById('monthName');
            const sortInput = document.getElementById('monthSort');
            const editId = document.getElementById('editMonthId').value;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...';

            // Clear validation error containers
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

            const payload = {
                name: nameInput.value,
                sort_order: sortInput.value || 0,
                is_active: document.getElementById('status').checked ? 1 : 0
            };

            try {
                let res;
                if (editId) {
                    res = await axios.post(`/api/fees/months/update/${editId}`, payload);
                } else {
                    res = await axios.post('/api/fees/months/store', payload);
                }

                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: editId ? 'মাসটি সফলভাবে হালনাগাদ করা হয়েছে!' : 'মাসটি সফলভাবে যুক্ত করা হয়েছে!',
                        text: res.data.message || 'Academic month configurations have been processed.',
                        confirmButtonColor: '#004d40'
                    });

                    resetFormState(); 
                    await loadMonthsList(); 
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    const generalMessage = error.response.data.message;

                    if (errors) {
                        if (errors.name) {
                            nameInput.classList.add('is-invalid');
                            document.getElementById('error-name').innerHTML = errors.name[0];
                        }
                        if (errors.sort_order) {
                            sortInput.classList.add('is-invalid');
                            document.getElementById('error-sort-order').innerHTML = errors.sort_order[0];
                        }
                    }
                    
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
                submitBtn.innerHTML = editId ? 'Update Month Settings' : 'Create Month';
            }
        });
    }

    // jQuery Event Delegation: Populate selected month into Edit form
    $('#monthsTableBody').on('click', '.monthEdit', async function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        try {
            const res = await axios.get(`/api/fees/months/details/${id}`);

            if (res.data.status === true) {
                const month = res.data.data;

                // Bind data parameters back to elements
                $('#formTitle').html('<i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit Month Settings');
                $('#formDesc').text(`Updating Configuration ID: #${month.id}`);
                $('#editMonthId').val(month.id);
                $('#monthName').val(month.name);
                $('#monthSort').val(month.sort_order);
                $('#status').prop('checked', month.is_active == 1);

                $('#submitBtn').text('Update Month Settings').css('background-color', '#1a237e'); 
                $('#resetBtn').show(); 
                
                // Smooth scroll to container input elements on smaller displays
                $('html, body').animate({
                    scrollTop: $("#monthCreateForm").offset().top - 100
                }, 300);
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি',
                text: 'মাসের বিবরণী লোড করতে ব্যর্থ হয়েছে।',
                confirmButtonColor: '#004d40'
            });
        }
    });

    // Toggle Status switch handler securely with AJAX
    $('#monthsTableBody').on('change', '.toggle-status-switch', function() {
        const switchEl = $(this);
        const id = switchEl.data('id');
        const isCurrentlyChecked = switchEl.prop('checked');

        if (!isCurrentlyChecked) {
            // Confirmation alert before disabling month record configurations
            Swal.fire({
                title: 'নিষ্ক্রিয় করতে চান?',
                text: 'এই মাসটি নিষ্ক্রিয় করা হলে নতুন কোনো ফি কাঠামোতে (Fee Structure) এটি নির্বাচন করা যাবে না।',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#004d40',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'হ্যাঁ, নিষ্ক্রিয় করুন',
                cancelButtonText: 'বাতিল'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await processToggleStatus(id, switchEl);
                } else {
                    switchEl.prop('checked', true); // Revert switch if canceled
                }
            });
        } else {
            processToggleStatus(id, switchEl);
        }
    });

    // Helper Async Status toggle request pipeline
    async function processToggleStatus(id, switchEl) {
        try {
            const res = await axios.patch(`/api/fees/months/${id}/toggle-status`);
            if (res.data.status === true) {
                Toast.fire({
                    icon: 'success',
                    title: res.data.message
                });
            }
        } catch (error) {
            switchEl.prop('checked', !switchEl.prop('checked')); // Revert on failure
            Swal.fire({
                icon: 'error',
                title: 'ব্যর্থতা!',
                text: 'অবস্থা পরিবর্তন করা সম্ভব হয়নি।',
                confirmButtonColor: '#004d40'
            });
        }
    }

    // jQuery Event Delegation: Safely deleting month entries
    $('#monthsTableBody').on('click', '.monthDelete', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: 'মুছে ফেলতে চান?',
            text: 'এই মাসটি ডিলিট করলে এর ডাটা আর পুনরুদ্ধার করা যাবে না!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
            cancelButtonText: 'বাতিল'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const res = await axios.delete(`/api/fees/months/delete/${id}`);

                    if (res.data.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'মুছে ফেলা হয়েছে!',
                            text: res.data.message || 'Deleted successfully.',
                            confirmButtonColor: '#004d40'
                        });

                        if ($('#editMonthId').val() == id) {
                            resetFormState();
                        }

                        await loadMonthsList(); 
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

    // Standard SweetAlert dynamic toast configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // Document Initializations on load
    $(document).ready(function () {
        loadMonthsList();
    });
}
</script>
@endpush