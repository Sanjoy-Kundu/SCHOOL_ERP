{{-- @push('styles')
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

    /* Custom Academic Table Grid Styles */
    #detailsTable {
        border-collapse: collapse !important;
    }
    #detailsTable thead th {
        font-size: 0.85rem !important;
        font-weight: 700 !important;
        color: #495057 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }
    #detailsTable tbody td {
        font-size: 0.875rem !important;
        color: #000 !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }

    /* Inline sorting input styles */
    .change-sort-order {
        width: 55px;
        height: 28px;
        font-size: 13px;
        display: inline-block !important;
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 2px 5px !important;
    }
    .change-sort-order:focus {
        border-color: #004d40 !important;
        outline: none;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('academic-subject-assignment-overviews') }}" class="btn btn-link text-decoration-none p-0 me-3">
            <i class="fa-solid fa-arrow-left fs-4" style="color: #004d40;"></i>
        </a>
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">বিষয় অ্যাসাইনমেন্ট বিস্তারিত (Details)</h1>
            <p class="text-muted small mb-0">নির্দিষ্ট শ্রেণী কাঠামোর অধীনে অ্যাসাইন করা বিষয়ের বিস্তারিত তথ্য বিবরণী।</p>
        </div>
    </div>

    <!-- Selected Class Setup details title panel -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-circle-info text-info me-2"></i> শ্রেণী কাঠামোর বিবরণী</h5>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <span class="small text-secondary d-block">শ্রেণী (Class):</span>
                <strong class="text-dark fs-6" id="infoClass">—</strong>
            </div>
            <div class="col-6 col-md-3">
                <span class="small text-secondary d-block">শাখা (Section):</span>
                <strong class="text-dark fs-6" id="infoSection">—</strong>
            </div>
            <div class="col-6 col-md-3">
                <span class="small text-secondary d-block">শিফট (Shift):</span>
                <strong class="text-dark fs-6" id="infoShift">—</strong>
            </div>
            <div class="col-6 col-md-3">
                <span class="small text-secondary d-block">বিভাগ (Group):</span>
                <strong class="text-dark fs-6" id="infoGroup">—</strong>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Details Workspace Panel -->
        <div class="col-12">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-book text-success me-2"></i>অ্যাসাইন করা বিষয়সমূহের তালিকা
                </h5>
                
                <!-- Dynamic 2-Level Header Table (Matches Your Image Structure)  -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center mb-0 w-100" id="detailsTable">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width: 22%;" class="align-middle">বিষয় ধরন</th>
                                <th rowspan="2" style="width: 25%;" class="align-middle">বিষয়</th>
                                <th colspan="2" style="width: 53%;">পত্র</th>
                            </tr>
                            <tr>
                                <th style="width: 26.5%;">১ম পত্র</th>
                                <th style="width: 26.5%;">২য় পত্র</th>
                            </tr>
                        </thead>
                        <tbody id="detailsTableBody">
                            <tr>
                                <td colspan="4" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">বিস্তারিত তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const classSetupId = @json(request()->route('classSetupId'));
const canDelete = @json(auth()->user()->can('subject_assignments.delete'));
const canEdit = @json(auth()->user()->can('subject_assignments.edit'));

// English to Bangla Digit Converter Utility
function convertToBanglaNumber(number) {
    const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
    return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
}

// Render Table Rows with Rowspan and Colspan Grouping 
function renderDetails(assignments) {
    if (!assignments || assignments.length === 0) {
        $('#detailsTableBody').html(`<tr><td colspan="4" class="text-center text-muted py-5"><i class="fa-solid fa-folder-open me-2 fs-4 d-block mb-2 text-secondary"></i>No assigned subjects found.</td></tr>`);
        return;
    }

    // Grouping assignments dynamically by Group name (e.g. Science, Commerce, Compulsory) 
    const grouped = {};
    assignments.forEach(item => {
        const groupName = item.group ? item.group.name : 'Compulsory';
        if (!grouped[groupName]) {
            grouped[groupName] = {};
        }

        const subjectName = item.subject ? item.subject.name : '—';
        if (!grouped[groupName][subjectName]) {
            grouped[groupName][subjectName] = {
                is_fourth_subject: false,
                has_papers: false,
                papers_array: [null, null],
                general_assignment: null
            };
        }

        // Map parent assignments directly to paper names from DB 
        if (item.paper) {
            grouped[groupName][subjectName].has_papers = true;
            const pName = item.paper.name;
            
            // Dynamically resolve slot index (0 for 1st Paper, 1 for 2nd Paper) based on numeric contents
            const slotIndex = (pName.includes('2') || pName.includes('২') || pName.includes('Second') || pName.toLowerCase().includes('2nd')) ? 1 : 0;
            
            // Assign mapping to papers_array index safely
            grouped[groupName][subjectName].papers_array[slotIndex] = item;
        } else {
            grouped[groupName][subjectName].general_assignment = item;
        }

        if (item.is_fourth_subject) {
            grouped[groupName][subjectName].is_fourth_subject = true;
        }
    });

    // Build the dynamic rowspan table rows
    let html = '';
    Object.keys(grouped).forEach(groupName => {
        const subjects = grouped[groupName];
        const subjectKeys = Object.keys(subjects);
        const groupRowspan = subjectKeys.length;

        subjectKeys.forEach((subjectName, sIdx) => {
            const isFirstSubject = (sIdx === 0);
            
            // Build first column with rowspan grouping
            const groupTd = isFirstSubject ? `<td rowspan="${groupRowspan}" class="fw-bold align-middle bg-light text-center" style="border-right: 1px solid #dee2e6; color: #004d40;">${groupName}</td>` : '';
            
            const subjectObj = subjects[subjectName];
            const optionalBadge = subjectObj.is_fourth_subject ? ' <span class="badge bg-light text-dark border ms-1" style="font-size: 10px; vertical-align: middle;">ঐচ্ছিক</span>' : '';
            
            // Map papers columns
            let papersTdHtml = '';
            const p1 = subjectObj.papers_array[0]; // Exact database value
            const p2 = subjectObj.papers_array[1]; // Exact database value
            const general = subjectObj.general_assignment;

            if (!subjectObj.has_papers) {
                // If subject has no papers, span 2 columns with colspan 
                const codeText = general && general.code ? ` (কোড: ${general.code})` : '';
                
                // Render dynamic inline sort order input field
                const sortInput = canEdit && general ? `<input type="number" class="form-control text-center mx-1 change-sort-order" data-id="${general.id}" value="${general.sort_order ?? 0}" min="0">` : '';
                const delBtn = general && canDelete ? `<button class="btn btn-sm text-danger p-0 ms-2 deleteAssignment" data-id="${general.id}" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>` : '';
                
                papersTdHtml = `<td colspan="2" class="text-center text-secondary align-middle fw-semibold">${subjectName}${codeText} ${sortInput} ${delBtn}</td>`;
            } else {
                // Render exact paper name dynamically without static concatenation 
                let p1Html = '—';
                if (p1) {
                    const codeText = p1.code ? ` (কোড: ${p1.code})` : '';
                    const sortInput = canEdit ? `<input type="number" class="form-control text-center mx-1 change-sort-order" data-id="${p1.id}" value="${p1.sort_order ?? 0}" min="0">` : '';
                    const delBtn = canDelete ? `<button class="btn btn-sm text-danger p-0 ms-2 deleteAssignment" data-id="${p1.id}" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>` : '';
                    p1Html = `${p1.subject?.name || '—'} ${p1.paper?.name || '—'}${codeText} ${sortInput} ${delBtn}`;
                }

                let p2Html = '—';
                if (p2) {
                    const codeText = p2.code ? ` (কোড: ${p2.code})` : '';
                    const sortInput = canEdit ? `<input type="number" class="form-control text-center mx-1 change-sort-order" data-id="${p2.id}" value="${p2.sort_order ?? 0}" min="0">` : '';
                    const delBtn = canDelete ? `<button class="btn btn-sm text-danger p-0 ms-2 deleteAssignment" data-id="${p2.id}" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>` : '';
                    p2Html = `${p2.subject?.name || '—'} ${p2.paper?.name || '—'}${codeText} ${sortInput} ${delBtn}`;
                }

                papersTdHtml = `
                    <td class="text-center text-secondary align-middle fw-semibold">${p1Html}</td>
                    <td class="text-center text-secondary align-middle fw-semibold">${p2Html}</td>
                `;
            }

            html += `
                <tr>
                    ${groupTd}
                    <td class="fw-bold text-dark text-start ps-3 align-middle" style="border-right: 1px solid #dee2e6;">${subjectName}${optionalBadge}</td>
                    ${papersTdHtml}
                </tr>
            `;
        });
    });

    $('#detailsTableBody').html(html);
}

// Fetch details from API
async function loadDetailsList() {
    try {
        const res = await axios.get(`/api/subject-assignment-overviews/${classSetupId}`);
        if (res.data?.status) {
            const setup = res.data.class_setup;
            
            // Map metadata panel
            $('#infoClass').text(setup.class ? setup.class.name : '—');
            $('#infoSection').text(setup.section ? setup.section.name : '—');
            $('#infoShift').text(setup.shift ? setup.shift.name : '—');
            $('#infoGroup').text(setup.group ? setup.group.name : '—');

            renderDetails(res.data.all_data);
        }
    } catch (error) {
        console.warn('Failed to load assignments dynamic details.');
    }
}

// Handle inline sort order changes dynamically
$('#detailsTableBody').on('change', '.change-sort-order', async function() {
    const id = $(this).data('id');
    const newOrder = $(this).val();

    if (newOrder === '' || isNaN(newOrder) || newOrder < 0) {
        Swal.fire({
            icon: 'warning',
            title: 'ভ্যালিডেশন ত্রুটি',
            text: 'দয়া করে একটি সঠিক ইতিবাচক সংখ্যা ইনপুট দিন।',
            confirmButtonColor: '#004d40'
        });
        return;
    }

    try {
        const res = await axios.patch(`/api/subject-assignment-sort-order/${id}`, {
            sort_order: newOrder
        });

        if (res.data.status) {
            // Elegant micro-toast notification for seamless UX 
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: res.data.message
            });

            // Re-fetch and re-render the list so items instantly auto-reorder smoothly!
            await loadDetailsList();
        }
    } catch (error) {
         Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'সাজানোর ক্রম আপডেট করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// Event Delegation for Delete Button Click (AJAX SPA style without reload)
$('#detailsTableBody').on('click', '.deleteAssignment', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই বিষয়ের ম্যাপিংটি ডিলিট করতে চান?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/subject-assignment-delte/${id}`);
                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message || 'Mapping deleted successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    // Reload dynamic rowspan data tree seamlessly
                    await loadDetailsList();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'ম্যাপিংটি ডিলিট করতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});

$(document).ready(function () {
    loadDetailsList();
});
</script>
@endpush --}}


@push('styles')
<style>
    /* Dynamic responsive design CSS for Workspace Panels */
    @media (max-width: 575.98px) {
        .card-responsive { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important; }
        .container-responsive { padding-left: 10px !important; padding-right: 10px !important; }
        .title-responsive { font-size: 1.5rem !important; }
    }
    @media (min-width: 576px) and (max-width: 991.98px) {
        .card-responsive { border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important; }
        .title-responsive { font-size: 1.8rem !important; }
    }
    @media (min-width: 992px) {
        .card-responsive { border-radius: 20px !important; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06) !important; }
    }

    /* Custom Academic Table Grid Styles */
    #detailsTable {
        border-collapse: collapse !important;
    }
    #detailsTable thead th {
        font-size: 0.85rem !important;
        font-weight: 700 !important;
        color: #495057 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }
    #detailsTable tbody td {
        font-size: 0.875rem !important;
        color: #000 !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }

    /* Inline sorting input styles */
    .change-sort-order {
        width: 55px;
        height: 28px;
        font-size: 13px;
        display: inline-block; /* Fixed: Removed !important to allow Bootstrap's .d-none to override and toggle properly */
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 2px 5px !important;
    }
    .change-sort-order:focus {
        border-color: #004d40 !important;
        outline: none;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('academic-subject-assignment-overviews') }}" class="btn btn-link text-decoration-none p-0 me-3">
            <i class="fa-solid fa-arrow-left fs-4" style="color: #004d40;"></i>
        </a>
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">বিষয় অ্যাসাইনমেন্ট বিস্তারিত (Details)</h1>
            <p class="text-muted small mb-0">নির্দিষ্ট শ্রেণী কাঠামোর অধীনে অ্যাসাইন করা বিষয়ের বিস্তারিত তথ্য বিবরণী।</p>
        </div>
    </div>

    <!-- Selected Class Setup details title panel -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-circle-info text-info me-2"></i> শ্রেণী কাঠামোর বিবরণী</h5>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <span class="small text-secondary d-block">শ্রেণী (Class):</span>
                <strong class="text-dark fs-6" id="infoClass">—</strong>
            </div>
            <div class="col-6 col-md-3">
                <span class="small text-secondary d-block">শাখা (Section):</span>
                <strong class="text-dark fs-6" id="infoSection">—</strong>
            </div>
            <div class="col-6 col-md-3">
                <span class="small text-secondary d-block">শিফট (Shift):</span>
                <strong class="text-dark fs-6" id="infoShift">—</strong>
            </div>
            <div class="col-6 col-md-3">
                <span class="small text-secondary d-block">বিভাগ (Group):</span>
                <strong class="text-dark fs-6" id="infoGroup">—</strong>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Details Workspace Panel -->
        <div class="col-12">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                
                <!-- Dynamic Header with Edit Mode Toggle Switch -->
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-book text-success me-2"></i>অ্যাসাইন করা বিষয়সমূহের তালিকা
                    </h5>
                    <!-- Professional Reusable Edit Mode Toggle Switch -->
                    <div class="form-check form-switch p-0 ps-5 fs-7">
                        <input class="form-check-input ms-5" type="checkbox" role="switch" id="toggleEditMode">
                        <label class="form-check-label fw-semibold text-secondary ps-2" for="toggleEditMode">সম্পাদন মুড (Edit Mode)</label>
                    </div>
                </div>
                
                <!-- Dynamic 2-Level Header Table (Matches Your Image Structure)  -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center mb-0 w-100" id="detailsTable">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width: 22%;" class="align-middle">বিষয় ধরন</th>
                                <th rowspan="2" style="width: 25%;" class="align-middle">বিষয়</th>
                                <th colspan="2" style="width: 53%;">পত্র</th>
                            </tr>
                            <tr>
                                <th style="width: 26.5%;">১ম পত্র</th>
                                <th style="width: 26.5%;">২য় পত্র</th>
                            </tr>
                        </thead>
                        <tbody id="detailsTableBody">
                            <tr>
                                <td colspan="4" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">বিস্তারিত তালিকা লোড হচ্ছে...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const classSetupId = @json(request()->route('classSetupId'));
const canDelete = @json(auth()->user()->can('subject_assignments.delete'));
const canEdit = @json(auth()->user()->can('subject_assignments.edit'));

// English to Bangla Digit Converter Utility
function convertToBanglaNumber(number) {
    const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
    return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
}

// Render Table Rows with Rowspan and Colspan Grouping 
function renderDetails(assignments) {
    if (!assignments || assignments.length === 0) {
        $('#detailsTableBody').html(`<tr><td colspan="4" class="text-center text-muted py-5"><i class="fa-solid fa-folder-open me-2 fs-4 d-block mb-2 text-secondary"></i>No assigned subjects found.</td></tr>`);
        return;
    }

    // Check if Edit Mode is currently active to maintain active state across AJAX updates
    const isEditModeActive = $('#toggleEditMode').is(':checked');
    const editControlClass = isEditModeActive ? '' : 'd-none';

    // Grouping assignments dynamically by Group name (e.g. Science, Commerce, Compulsory) 
    const grouped = {};
    assignments.forEach(item => {
        const groupName = item.group ? item.group.name : 'Compulsory';
        if (!grouped[groupName]) {
            grouped[groupName] = {};
        }

        const subjectName = item.subject ? item.subject.name : '—';
        if (!grouped[groupName][subjectName]) {
            grouped[groupName][subjectName] = {
                is_fourth_subject: false,
                has_papers: false,
                papers_array: [null, null],
                general_assignment: null
            };
        }

        // Map parent assignments directly to paper names from DB 
        if (item.paper) {
            grouped[groupName][subjectName].has_papers = true;
            const pName = item.paper.name;
            
            // Dynamically resolve slot index (0 for 1st Paper, 1 for 2nd Paper) based on numeric contents
            const slotIndex = (pName.includes('2') || pName.includes('২') || pName.includes('Second') || pName.toLowerCase().includes('2nd')) ? 1 : 0;
            
            // Assign mapping to papers_array index safely
            grouped[groupName][subjectName].papers_array[slotIndex] = item;
        } else {
            grouped[groupName][subjectName].general_assignment = item;
        }

        if (item.is_fourth_subject) {
            grouped[groupName][subjectName].is_fourth_subject = true;
        }
    });

    // Build the dynamic rowspan table rows
    let html = '';
    Object.keys(grouped).forEach(groupName => {
        const subjects = grouped[groupName];
        const subjectKeys = Object.keys(subjects);
        const groupRowspan = subjectKeys.length;

        subjectKeys.forEach((subjectName, sIdx) => {
            const isFirstSubject = (sIdx === 0);
            
            // Build first column with rowspan grouping
            const groupTd = isFirstSubject ? `<td rowspan="${groupRowspan}" class="fw-bold align-middle bg-light text-center" style="border-right: 1px solid #dee2e6; color: #004d40;">${groupName}</td>` : '';
            
            const subjectObj = subjects[subjectName];
            const optionalBadge = subjectObj.is_fourth_subject ? ' <span class="badge bg-light text-dark border ms-1" style="font-size: 10px; vertical-align: middle;">ঐচ্ছিক</span>' : '';
            
            // Map papers columns
            let papersTdHtml = '';
            const p1 = subjectObj.papers_array[0]; // Exact database value
            const p2 = subjectObj.papers_array[1]; // Exact database value
            const general = subjectObj.general_assignment;

            if (!subjectObj.has_papers) {
                // If subject has no papers, span 2 columns with colspan
                const codeText = general && general.code ? ` (কোড: ${general.code})` : '';
                
                // Embedded edit-control class into inputs and delete buttons
                const sortInput = canEdit && general ? `<input type="number" class="form-control text-center mx-1 change-sort-order edit-control ${editControlClass}" data-id="${general.id}" value="${general.sort_order ?? 0}" min="0">` : '';
                const delBtn = general && canDelete ? `<button class="btn btn-sm text-danger p-0 ms-2 deleteAssignment edit-control ${editControlClass}" data-id="${general.id}" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>` : '';
                
                papersTdHtml = `<td colspan="2" class="text-center text-secondary align-middle fw-semibold">${subjectName}${codeText} ${sortInput} ${delBtn}</td>`;
            } else {
                // Render exact paper name dynamically with edit-control mappings
                let p1Html = '—';
                if (p1) {
                    const codeText = p1.code ? ` (কোড: ${p1.code})` : '';
                    const sortInput = canEdit ? `<input type="number" class="form-control text-center mx-1 change-sort-order edit-control ${editControlClass}" data-id="${p1.id}" value="${p1.sort_order ?? 0}" min="0">` : '';
                    const delBtn = canDelete ? `<button class="btn btn-sm text-danger p-0 ms-2 deleteAssignment edit-control ${editControlClass}" data-id="${p1.id}" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>` : '';
                    p1Html = `${p1.subject?.name || '—'} ${p1.paper?.name || '—'}${codeText} ${sortInput} ${delBtn}`;
                }

                let p2Html = '—';
                if (p2) {
                    const codeText = p2.code ? ` (কোড: ${p2.code})` : '';
                    const sortInput = canEdit ? `<input type="number" class="form-control text-center mx-1 change-sort-order edit-control ${editControlClass}" data-id="${p2.id}" value="${p2.sort_order ?? 0}" min="0">` : '';
                    const delBtn = canDelete ? `<button class="btn btn-sm text-danger p-0 ms-2 deleteAssignment edit-control ${editControlClass}" data-id="${p2.id}" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>` : '';
                    p2Html = `${p2.subject?.name || '—'} ${p2.paper?.name || '—'}${codeText} ${sortInput} ${delBtn}`;
                }

                papersTdHtml = `
                    <td class="text-center text-secondary align-middle fw-semibold">${p1Html}</td>
                    <td class="text-center text-secondary align-middle fw-semibold">${p2Html}</td>
                `;
            }

            html += `
                <tr>
                    ${groupTd}
                    <td class="fw-bold text-dark text-start ps-3 align-middle" style="border-right: 1px solid #dee2e6;">${subjectName}${optionalBadge}</td>
                    ${papersTdHtml}
                </tr>
            `;
        });
    });

    $('#detailsTableBody').html(html);
}

// Fetch details from API
async function loadDetailsList() {
    try {
        const res = await axios.get(`/api/subject-assignment-overviews/${classSetupId}`);
        if (res.data?.status) {
            const setup = res.data.class_setup;
            
            // Map metadata panel
            $('#infoClass').text(setup.class ? setup.class.name : '—');
            $('#infoSection').text(setup.section ? setup.section.name : '—');
            $('#infoShift').text(setup.shift ? setup.shift.name : '—');
            $('#infoGroup').text(setup.group ? setup.group.name : '—');

            renderDetails(res.data.all_data);
        }
    } catch (error) {
        console.warn('Failed to load assignments dynamic details.');
    }
}

// Live Toggle Switch action listener to show/hide dynamic edit controls
$('#toggleEditMode').on('change', function() {
    const isEditMode = $(this).is(':checked');
    if (isEditMode) {
        $('.edit-control').removeClass('d-none');
    } else {
        $('.edit-control').addClass('d-none');
    }
});

// Handle inline sort order changes dynamically
$('#detailsTableBody').on('change', '.change-sort-order', async function() {
    const id = $(this).data('id');
    const newOrder = $(this).val();

    if (newOrder === '' || isNaN(newOrder) || newOrder < 0) {
        Swal.fire({
            icon: 'warning',
            title: 'ভ্যালিডেশন ত্রুটি',
            text: 'দয়া করে একটি সঠিক ইতিবাচক সংখ্যা ইনপুট দিন।',
            confirmButtonColor: '#004d40'
        });
        return;
    }

    try {
        const res = await axios.patch(`/api/subject-assignment-sort-order/${id}`, {
            sort_order: newOrder
        });

        if (res.data.status) {
            // Elegant micro-toast notification for seamless UX 
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: res.data.message
            });

            // Re-fetch and re-render the list so items instantly auto-reorder smoothly!
            await loadDetailsList();
        }
    } catch (error) {
         Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: 'সাজানোর ক্রম আপডেট করতে ব্যর্থ হয়েছে।',
            confirmButtonColor: '#004d40'
        });
    }
});

// Event Delegation for Delete Button Click (AJAX SPA style without reload)
$('#detailsTableBody').on('click', '.deleteAssignment', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'মুছে ফেলতে চান?',
        text: 'এই বিষয়ের ম্যাপিংটি ডিলিট করতে চান?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
        cancelButtonText: 'বাতিল'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await axios.delete(`/api/subject-assignment-delte/${id}`);
                if (res.data.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'মুছে ফেলা হয়েছে!',
                        text: res.data.message || 'Mapping deleted successfully.',
                        confirmButtonColor: '#004d40'
                    });

                    // Reload dynamic rowspan data tree seamlessly
                    await loadDetailsList();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি',
                    text: error.response?.data?.message || 'ম্যাপিংটি ডিলিট করতে ব্যর্থ হয়েছে।',
                    confirmButtonColor: '#004d40'
                });
            }
        }
    });
});

$(document).ready(function () {
    loadDetailsList();
});
</script>
@endpush