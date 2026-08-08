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

    /* Custom DataTables CSS */
    #overviewsTable thead th {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        color: #6c757d !important;
        border-bottom: 1px solid #f1f2f4 !important;
        padding: 1rem 0.75rem !important;
    }
    #overviewsTable tbody td {
        font-size: 0.875rem !important;
        color: #2b3674 !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">বিষয় অ্যাসাইনমেন্ট তালিকা (Subject Assignment Overview)</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের শ্রেণী কাঠামোর সামগ্রিক বিষয় বিন্যাসের গ্রুপভিত্তিক তালিকা দেখুন।</p>
        </div>
    </div>

    <div class="row">
        <!-- Interactive Grouped Overviews DataTable -->
        <div class="col-12">
            <div class="card border-0 card-responsive p-3 p-sm-4 bg-white shadow-sm">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-graduation-cap text-success me-2"></i>বিদ্যালয়ের সক্রিয় শ্রেণী কাঠামো তালিকা
                </h5>
                
                <div class="table-responsive">
                    <table id="overviewsTable" class="table table-hover align-middle border-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width: 15%">সিরিয়াল নং</th>
                                <th>শ্রেণী কাঠামো (Class Setup Name)</th>
                                <th class="text-end pe-3" style="width: 20%">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody id="overviewsTableBody">
                            <tr>
                                <td colspan="3" class="text-center p-4">
                                    <div class="spinner-border text-success" role="status"></div>
                                    <span class="ms-2">তালিকা লোড হচ্ছে...</span>
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
<!-- DataTables Bootstrap 5 CSS & JS Integration Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// English to Bangla Digit Converter Utility
function convertToBanglaNumber(number) {
    const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
    return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
}

// Build human-readable setup name dynamically by filtering NULL values
function buildSetupName(item) {
    const parts = [];
    if (item.class) parts.push(item.class.name);
    if (item.section) parts.push(item.section.name);
    if (item.shift) parts.push(item.shift.name);
    if (item.group) parts.push(item.group.name);
    return parts.join(' - ');
}

// Render Table Rows dynamically
function renderOverviews(setups) {
    const rows = setups.map((item, index) => {
        const banglaSerial = convertToBanglaNumber(index + 1);
        const setupName = buildSetupName(item);

        return `
            <tr>
                <td class="fw-bold text-dark ps-3">${banglaSerial}</td>
                <td class="fw-semibold text-dark">${setupName}</td>
                <td class="text-end pe-3">
                    <a href="/academic-subject-assignments-overview/${item.id}/details" class="btn btn-sm btn-outline-success px-3 py-1.5 rounded-3 fw-bold">
                        <i class="fa-solid fa-eye me-1"></i> দেখুন
                    </a>
                </td>
            </tr>
        `;
    }).join('');

    $('#overviewsTableBody').html(rows);
}

// Initialize DataTables
function initializeDataTable() {
    if ($.fn.DataTable.isDataTable('#overviewsTable')) {
        $('#overviewsTable').DataTable().destroy();
    }

    $('#overviewsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        responsive: true,
        order: [], // Preserves custom sorted backend order sequence
        columnDefs: [
            { orderable: false, targets: [0, 2] }
        ],
        language: {
            search: 'সহজ অনুসন্ধান:',
            lengthMenu: 'প্রতি পেজে প্রদর্শন: _MENU_'
        }
    });
}

// Fetch all setups overviews dynamically
async function loadOverviewsList() {
    try {
        const response = await axios.get('/api/subject-assignment-overviews');
        if (response.data?.status && response.data?.all_data) {
            renderOverviews(response.data.all_data);
            initializeDataTable();
        }
    } catch (error) {
        console.warn('Failed to load overviews master list.');
    }
}

$(document).ready(function () {
    loadOverviewsList();
});
</script>
@endpush