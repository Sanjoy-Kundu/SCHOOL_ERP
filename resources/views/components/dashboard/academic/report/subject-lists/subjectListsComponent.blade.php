{{-- @push('styles')
<style>
    /* Responsive styling for workspace card layouts */
    @media (max-width: 575.98px) {
        .card-responsive { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important; padding: 1.25rem !important; }
        .container-responsive { padding-left: 10px !important; padding-right: 10px !important; }
    }
    @media (min-width: 576px) {
        .card-responsive { padding: 2rem !important; }
    }

    .report-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #edf2f9;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    /* Print styling rules to ensure neat PDF generation and zero layout breaks */
    @media print {
        /* Hide all dynamic web layout elements  */
        body {
            background: #ffffff !important;
            color: #000000 !important;
            font-size: 11pt !important;
        }
        #sidebar, .sidebar, .navbar, .btn, .no-print, #filterContainer, .header-navigation, footer {
            display: none !important;
        }
        .main-content, .container, .container-responsive, .card, .card-responsive {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        /* Table print-break preventions */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
            page-break-inside: auto; /* Allow table to split across pages */
        }
        tr {
            page-break-inside: avoid !important; /* Prevent single row from breaking into two pages */
            page-break-after: auto;
        }
        thead {
            display: table-header-group !important; /* Repeat table headers on every printed page */
        }
        
        /* Printable Institutional Letterhead styling */
        .print-letterhead {
            display: block !important;
        }
    }

    .print-letterhead {
        display: none; /* Hidden on web browser mode */
    }

    /* Table custom borders */
    #printReportTable {
        border-collapse: collapse !important;
    }
    #printReportTable thead th {
        font-size: 0.85rem !important;
        font-weight: 700 !important;
        color: #495057 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }
    #printReportTable tbody td {
        font-size: 0.875rem !important;
        color: #000 !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }
</style>
@endpush --}}

@push('styles')
<style>
    /* Responsive styling for workspace card layouts */
    @media (max-width: 575.98px) {
        .card-responsive { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important; padding: 1.25rem !important; }
        .container-responsive { padding-left: 10px !important; padding-right: 10px !important; }
    }
    @media (min-width: 576px) {
        .card-responsive { padding: 2rem !important; }
    }

    .report-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #edf2f9;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    /* Print styling rules to ensure neat PDF generation and zero layout breaks */
    @media print {
        html, body, 
        .main-content, 
        .content-wrapper, 
        #wrapper, 
        .wrapper {
            height: auto !important;
            min-height: auto !important;
            overflow: visible !important;
            position: static !important;
        }


        .table-responsive {
            overflow: visible !important;
            overflow-x: visible !important;
            display: block !important;
        }

        /* Hide all dynamic web layout elements  */
        body {
            background: #ffffff !important;
            color: #000000 !important;
            font-size: 11pt !important;
        }
        #sidebar, .sidebar, .navbar, .btn, .no-print, #filterContainer, .header-navigation, footer {
            display: none !important;
        }
        
       
        .main-content, .container, .container-responsive, .card, .card-responsive, .report-card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow: visible !important;
        }
        
        /* Table print-break preventions */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
            page-break-inside: auto; /* Allow table to split across pages */
        }
        tr {
            page-break-inside: avoid !important; /* Prevent single row from breaking into two pages */
            page-break-after: auto;
        }
        thead {
            display: table-header-group !important; /* Repeat table headers on every printed page */
        }
        
        /* Printable Institutional Letterhead styling */
        .print-letterhead {
            display: block !important;
        }
    }

    .print-letterhead {
        display: none; /* Hidden on web browser mode */
    }

    /* Table custom borders */
    #printReportTable {
        border-collapse: collapse !important;
    }
    #printReportTable thead th {
        font-size: 0.85rem !important;
        font-weight: 700 !important;
        color: #495057 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }
    #printReportTable tbody td {
        font-size: 0.875rem !important;
        color: #000 !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.75rem !important;
    }
</style>
@endpush

<div class="container container-responsive py-4">
    
    <!-- Page Header (Web Browser Mode Only) -->
    <div class="d-flex align-items-center justify-content-between mb-4 no-print">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold title-responsive">শ্রেণীভিত্তিক বিষয় বিন্যাস বিবরণী</h1>
            <p class="text-muted small mb-0">বিদ্যালয়ের শ্রেণী কাঠামো অনুযায়ী সাজানো বিষয়সমূহের অফিশিয়াল প্রিন্ট ও পিডিএফ রিপোর্ট জেনারেটর।</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-success px-4 py-2 rounded-3 fw-bold d-none" id="triggerPrintBtn">
                <i class="fa-solid fa-print me-1"></i> প্রিন্ট / PDF ডাউনলোড
            </button>
        </div>
    </div>

    <!-- Live Filter Selector (Web Browser Mode Only) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 no-print" id="filterContainer">
        <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-sliders text-success me-2"></i> ফিল্টারিং প্যানেল</h5>
        <div class="row g-3">
            <div class="col-md-6 col-12">
                <label for="selectClassSetup" class="form-label small fw-semibold text-secondary">শ্রেণী কাঠামো নির্বাচন করুন <span class="text-danger">*</span></label>
                <select class="form-select form-select-lg rounded-3 fs-6" id="selectClassSetup">
                    <option value="" selected disabled>শ্রেণী কাঠামো নির্বাচন করুন...</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Central Report Card Block (Prints dynamically on trigger) -->
    <div class="card border-0 card-responsive report-card bg-white d-none" id="reportMainCard">
        
        <!-- Printable Institutional Letterhead  -->
        <div class="print-letterhead text-center border-bottom pb-4 mb-4">
            <h2 class="fw-bold text-dark mb-1"><i class="fa-solid fa-graduation-cap text-success me-2"></i>এবিসি উচ্চ বিদ্যালয়</h2>
            <p class="text-secondary small mb-1">সাধারণ মাধ্যমিক শাখা, শ্রেণী: ষষ্ঠ - দশম</p>
            <h4 class="fw-bold text-dark mt-3 mb-0">শ্রেণীভিত্তিক বিষয় বিন্যাস বিবরণী (Subject Mapping Report)</h4>
        </div>

        <!-- Meta Details Description Panel -->
        <div class="mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-circle-info text-info me-2 no-print"></i> শ্রেণী কাঠামোর বিবরণী</h5>
            <div class="row g-3">
                <div class="col-3 col-sm-3 col-6">
                    <span class="small text-secondary d-block">শ্রেণী (Class):</span>
                    <strong class="text-dark fs-6" id="metaClass">—</strong>
                </div>
                <div class="col-3 col-sm-3 col-6">
                    <span class="small text-secondary d-block">শাখা (Section):</span>
                    <strong class="text-dark fs-6" id="metaSection">—</strong>
                </div>
                <div class="col-3 col-sm-3 col-6">
                    <span class="small text-secondary d-block">শিফট (Shift):</span>
                    <strong class="text-dark fs-6" id="metaShift">—</strong>
                </div>
                <div class="col-3 col-sm-3 col-6">
                    <span class="small text-secondary d-block">বিভাগ (Group):</span>
                    <strong class="text-dark fs-6" id="metaGroup">—</strong>
                </div>
            </div>
        </div>

        <!-- Mapped Subjects Table with Rowspan/Colspan -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center mb-0 w-100" id="printReportTable">
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
                <tbody id="printReportTableBody">
                    <!-- Dynamic rows grouped by rowspan will append here -->
                </tbody>
            </table>
        </div>
        
        <!-- Printable Footer Signatures  -->
        <div class="print-letterhead mt-5 pt-5">
            <div class="d-flex justify-content-between">
                <div class="text-center" style="width: 200px;">
                    <hr class="border-dark mb-1">
                    <span class="small text-secondary">প্রস্তুতকারী (Clerk/Operator)</span>
                </div>
                <div class="text-center" style="width: 200px;">
                    <hr class="border-dark mb-1">
                    <span class="small text-secondary">প্রধান শিক্ষক (Principal)</span>
                </div>
            </div>
        </div>

    </div>
    
    <!-- Empty State Loader (Web Browser Mode Only) -->
    <div class="card border-0 card-responsive report-card bg-white p-5 text-center" id="emptyStatePanel">
        <i class="fa-solid fa-file-invoice text-success mb-3" style="font-size: 3rem;"></i>
        <h5 class="fw-bold text-dark">কোনো শ্রেণী কাঠামো সিলেক্ট করা নেই</h5>
        <p class="text-muted small mb-0">দয়া করে উপরের ফিল্টারিং প্যানেল থেকে একটি নির্দিষ্ট শ্রেণী কাঠামো সিলেক্ট করুন রিপোর্ট জেনারেট করার জন্য।</p>
    </div>
</div>

@push('scripts')
<script>
// English to Bangla Digit Converter Utility
function convertToBanglaNumber(number) {
    const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
    return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
}

// Render dynamic rows with rowspan and colspan logic 
function renderReportTable(assignments) {
    if (!assignments || assignments.length === 0) {
        $('#printReportTableBody').html(`<tr><td colspan="4" class="text-center text-muted py-5"><i class="fa-solid fa-folder-open me-2 fs-4 d-block mb-2 text-secondary"></i>এই শ্রেণীর অধীনে কোনো বিষয় এসাইন করা পাওয়া যায়নি।</td></tr>`);
        return;
    }

    // Grouping assignments dynamically by Group name directly from DB 
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
            const groupTd = isFirstSubject ? `<td rowspan="${groupRowspan}" class="fw-bold align-middle bg-light text-center" style="border-right: 1px solid #dee2e6; color: #004d40;">${groupName}</td>` : '';
            
            const subjectObj = subjects[subjectName];
            const optionalBadge = subjectObj.is_fourth_subject ? ' <span class="badge bg-light text-dark border ms-1" style="font-size: 10px; vertical-align: middle;">ঐচ্ছিক</span>' : '';
            
            let papersTdHtml = '';
            const p1 = subjectObj.papers_array[0];
            const p2 = subjectObj.papers_array[1];
            const general = subjectObj.general_assignment;

            if (!subjectObj.has_papers) {
                // If subject has no papers, span 2 columns with colspan 
                const codeText = general && general.code ? ` (কোড: ${general.code})` : '';
                papersTdHtml = `<td colspan="2" class="text-center text-secondary align-middle fw-semibold">${subjectName}${codeText}</td>`;
            } else {
                // Render exact paper name dynamically without static concatenation 
                let p1Html = '—';
                if (p1) {
                    const codeText = p1.code ? ` (কোড: ${p1.code})` : '';
                    p1Html = `${p1.subject?.name || '—'} ${p1.paper?.name || '—'}${codeText}`;
                }

                let p2Html = '—';
                if (p2) {
                    const codeText = p2.code ? ` (কোড: ${p2.code})` : '';
                    p2Html = `${p2.subject?.name || '—'} ${p2.paper?.name || '—'}${codeText}`;
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

    $('#printReportTableBody').html(html);
}

// Fetch dynamic dropdown datasets from active setups table on load
async function loadFilterDropdown() {
    try {
        const response = await axios.get('/api/class-setup-lists');
        if (response.data?.status && response.data?.all_data) {
            let options = '<option value="" selected disabled>শ্রেণী কাঠামো নির্বাচন করুন...</option>';
            response.data.all_data.forEach(item => {
                const className = item.class ? item.class.name : '—';
                const sectionName = item.section ? ` - ${item.section.name}` : '';
                const shiftName = item.shift ? ` (${item.shift.name})` : '';
                const classSetupText = `${className}${sectionName}${shiftName}`;
                options += `<option value="${item.id}">${classSetupText}</option>`;
            });
            $('#selectClassSetup').html(options);
        }
    } catch (error) {
        console.warn('Failed to populate setups filter dropdown.');
    }
}

// Live setup selection listener to fetch and compile printable data 
$('#selectClassSetup').on('change', async function() {
    const classSetupId = $(this).val();
    if (!classSetupId) return;

    $('#emptyStatePanel').addClass('d-none');
    $('#reportMainCard').removeClass('d-none');
    
    // Set table loading skeleton
    $('#printReportTableBody').html(`
        <tr>
            <td colspan="4" class="text-center py-4">
                <div class="spinner-border text-success" role="status"></div>
                <span class="ms-2">রিপোর্ট জেনারেট হচ্ছে...</span>
            </td>
        </tr>
    `);

    try {
        const res = await axios.get(`/api/subject-assignment-overviews/${classSetupId}`);
        if (res.data?.status) {
            const setup = res.data.class_setup;
            
            // Map printable meta values
            $('#metaClass').text(setup.class ? setup.class.name : '—');
            $('#metaSection').text(setup.section ? setup.section.name : '—');
            $('#metaShift').text(setup.shift ? setup.shift.name : '—');
            $('#metaGroup').text(setup.group ? setup.group.name : '—');

            renderReportTable(res.data.all_data);
            $('#triggerPrintBtn').removeClass('d-none');
        }
    } catch (error) {
        console.warn('Failed to generate subject printable report.');
    }
});

// Trigger browser's native print dial cleanly without reload
$('#triggerPrintBtn').on('click', function() {
    window.print();
});

$(document).ready(function () {
    loadFilterDropdown();
});
</script>
@endpush
