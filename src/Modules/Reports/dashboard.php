<?php
// Views are included by the Controller, so $this refers to the Controller instance.
// Paths are relative to __DIR__ (src/Modules/Reports/) which is 3 levels deep from root.

require_once __DIR__ . '/../../../envloader.php';
require __DIR__ . '/../../../config/config.php';
require __DIR__ . '/../../../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . '/../../../layout/head.php'; ?>
    <style>
        .required {
            color: red;
        }
        .preview-section {
            display: none;
            margin-top: 30px;
        }
        .ai-loading {
            display: none;
        }
        .project-card {
            border-left: 3px solid #0daea8;
            margin-bottom: 20px;
        }
        .task-row-textarea {
            width: 100%;
            resize: vertical;
            min-height: 60px;
        }
    </style>
</head>

<body class="">
    <?php include __DIR__ . '/../../../sidebar.php'; ?>
    <div class="main-content">
        <?php include __DIR__ . '/../../../nav.php'; ?>
        <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Work Reports Dashboard</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid mt--7">
            <div class="row">
                <!-- generation form card -->
                <div class="col-12">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <h3 class="mb-0">Generate Customer Work Report</h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($this->data['session']) && count($this->data['session'])): ?>
                                <?php foreach ($this->data['session'] as $msg) echo $msg; ?>
                            <?php endif; ?>
                            
                            <form id="report-generator-form">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="customer_id">Select Customer <span class="required">*</span></label>
                                            <select name="customer_id" id="customer_id" class="form-control select2" required>
                                                <option value="">SELECT A CUSTOMER</option>
                                                <?php if (isset($this->data['customers']) && count($this->data['customers'])): ?>
                                                    <?php foreach ($this->data['customers'] as $customer): ?>
                                                        <option value="<?php echo $customer['id']; ?>" data-email="<?php echo htmlspecialchars($customer['email']); ?>">
                                                            <?php echo htmlspecialchars(($customer['type'] ?? '') . ' - ' . ($customer['business_name'] ?? '') . ' - ' . ($customer['name'] ?? '')); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="start_date">Start Date <span class="required">*</span></label>
                                            <input type="date" name="start_date" id="start_date" class="form-control" required value="<?php echo date('Y-m-01'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="end_date">End Date <span class="required">*</span></label>
                                            <input type="date" name="end_date" id="end_date" class="form-control" required value="<?php echo date('Y-m-t'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" id="btn-generate-preview" class="btn btn-primary mt-3">Generate Preview</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PREVIEW AND ACTIONS SECTION -->
            <div class="row preview-section" id="preview-panel">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Report Preview</h3>
                            <div>
                                <button type="button" id="btn-ai-polish" class="btn btn-warning btn-sm">
                                    <span class="ai-idle">🪄 AI Polish with OpenAI</span>
                                    <span class="ai-loading"><i class="fa fa-spinner fa-spin"></i> Polishing report...</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Executive Summary section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="executive_summary"><strong>Executive Summary (AI Generated or Manual)</strong></label>
                                        <textarea id="executive_summary" class="form-control" rows="4" placeholder="Enter an executive summary for this report period..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Destination Email section -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="destination_email"><strong>Destination Email</strong></label>
                                        <input type="email" id="destination_email" class="form-control" placeholder="client@email.com">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4"/>

                            <!-- Projects & Tasks list -->
                            <div id="preview-content"></div>

                            <!-- Grand total hours -->
                            <div class="text-right mt-3 mb-4">
                                <h3>Total Hours Worked: <span id="preview-total-hours">0.0</span> hours</h3>
                            </div>

                            <!-- Actions Form -->
                            <div class="text-center mt-4">
                                <form id="pdf-form" action="<?php echo $base_url; ?>/modules/reports/index.php/download-pdf" method="POST" target="_blank" style="display:inline-block;">
                                    <input type="hidden" name="customer_id" id="pdf_customer_id"/>
                                    <input type="hidden" name="start_date" id="pdf_start_date"/>
                                    <input type="hidden" name="end_date" id="pdf_end_date"/>
                                    <input type="hidden" name="executive_summary" id="pdf_executive_summary"/>
                                    <input type="hidden" name="professional_tasks" id="pdf_professional_tasks"/>
                                    <button type="submit" class="btn btn-info mr-2"><i class="fa fa-file-pdf-o"></i> Download PDF</button>
                                </form>

                                <form id="email-form" action="<?php echo $base_url; ?>/modules/reports/index.php/send" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="customer_id" id="email_customer_id"/>
                                    <input type="hidden" name="start_date" id="email_start_date"/>
                                    <input type="hidden" name="end_date" id="email_end_date"/>
                                    <input type="hidden" name="email" id="email_destination"/>
                                    <input type="hidden" name="executive_summary" id="email_executive_summary"/>
                                    <input type="hidden" name="professional_tasks" id="email_professional_tasks"/>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-envelope-o"></i> Send Email to Customer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HISTORY SECTION -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-white">
                            <h3 class="mb-0">Sent Reports History</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush" id="history-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Sent To</th>
                                            <th>Sent At</th>
                                            <th>Sent By</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($this->data['history']) && count($this->data['history'])): ?>
                                            <?php foreach ($this->data['history'] as $item): ?>
                                                <tr>
                                                    <td>#<?php echo $item['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($item['customer_business_name'] ? $item['customer_business_name'] : $item['customer_name']); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($item['start_date'])); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($item['end_date'])); ?></td>
                                                    <td><?php echo htmlspecialchars($item['sent_to_email']); ?></td>
                                                    <td><?php echo date('M d, Y H:i', strtotime($item['sent_at'])); ?></td>
                                                    <td><?php echo htmlspecialchars($item['user_first_name'] . ' ' . $item['user_last_name']); ?></td>
                                                    <td class="text-right">
                                                        <?php if (!empty($item['pdf_path'])): ?>
                                                            <a href="<?php echo htmlspecialchars($this->base_url . '/' . $item['pdf_path']); ?>" target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="fa fa-file-pdf"></i> View PDF
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between"></div>
            </footer>
        </div>
    </div>

    <?php include __DIR__ . '/../../../layout/footer_scripts.php'; ?>
    <script>
        $(document).ready(function () {
            $('#history-table').DataTable({
                "order": [[0, "desc"]]
            });

            $('.select2').select2({
                placeholder: 'Select a customer',
                allowClear: true
            });

            let currentReportData = null;
            let professionalTasks = {}; // task_id => custom/professional description

            // Generate Preview
            $('#btn-generate-preview').click(function () {
                let customerId = $('#customer_id').val();
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();

                if (!customerId || !startDate || !endDate) {
                    $.notify('Please select customer and date range.', 'error');
                    return;
                }

                let defaultEmail = $('#customer_id').find(':selected').data('email');
                $('#destination_email').val(defaultEmail);

                // Fetch data
                $.ajax('<?php echo $base_url; ?>/modules/reports/index.php/generate', {
                    type: 'POST',
                    data: {
                        customer_id: customerId,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function (res) {
                        if (res.success) {
                            currentReportData = res.reportData;
                            professionalTasks = {}; // Reset professionalized descriptions
                            $('#executive_summary').val(''); // Reset summary
                            renderPreview(res.reportData);
                            $('#preview-panel').slideDown();
                            $.notify('Preview generated successfully!', 'success');
                        } else {
                            $.notify(res.error || 'Error generating preview.', 'error');
                        }
                    },
                    error: function () {
                        $.notify('Error loading report preview data.', 'error');
                    }
                });
            });

            // AI Polish button
            $('#btn-ai-polish').click(function () {
                let customerId = $('#customer_id').val();
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();

                if (!customerId || !startDate || !endDate) {
                    $.notify('Please select customer and date range first.', 'error');
                    return;
                }

                // Show loading spinner
                $('.ai-idle').hide();
                $('.ai-loading').show();
                $('#btn-ai-polish').prop('disabled', true);

                $.ajax('<?php echo $base_url; ?>/modules/reports/index.php/ai-polish', {
                    type: 'POST',
                    data: {
                        customer_id: customerId,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function (res) {
                        if (res.success && res.data) {
                            let aiData = res.data;
                            if (aiData.executive_summary) {
                                $('#executive_summary').val(aiData.executive_summary);
                            }
                            if (aiData.tasks && Array.isArray(aiData.tasks)) {
                                aiData.tasks.forEach(function (t) {
                                    professionalTasks[t.id] = t.professional_description;
                                    $(`#task-desc-${t.id}`).val(t.professional_description);
                                });
                            }
                            $.notify('Report professionalized by AI!', 'success');
                        } else {
                            $.notify(res.error || 'AI Polishing failed.', 'error');
                        }
                    },
                    error: function (xhr) {
                        let errMsg = 'Connection error with AI service.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errMsg = xhr.responseJSON.error;
                        }
                        $.notify(errMsg, 'error');
                    },
                    complete: function () {
                        $('.ai-loading').hide();
                        $('.ai-idle').show();
                        $('#btn-ai-polish').prop('disabled', false);
                    }
                });
            });

            // Render Preview content
            function renderPreview(data) {
                let html = '';
                let totalHours = 0;

                // Projects
                if (data.projects && data.projects.length > 0) {
                    data.projects.forEach(function (project) {
                        if (!project.tasks || project.tasks.length === 0) return;
                        
                        let projectHours = 0;
                        html += `
                        <div class="card project-card mb-4 shadow-sm bg-white">
                            <div class="card-header bg-white py-3">
                                <h4 class="mb-0 text-primary">Project: ${escapeHtml(project.name)}</h4>
                                ${project.description ? `<small class="text-muted">${escapeHtml(project.description)}</small>` : ''}
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="30%">Task Name</th>
                                                <th width="45%">Description (Editable for Client Report)</th>
                                                <th width="15%">Assigned To</th>
                                                <th width="10%" class="text-right">Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;

                        project.tasks.forEach(function (task) {
                            let hours = parseFloat(task.custom_total_time ? (task.custom_total_time / 60) : (task.total_time ? (task.total_time / 3600) : 0));
                            if (task.custom_total_time) {
                                // Priority is custom_total_time as user mentioned
                                hours = parseFloat(task.custom_total_time) / 60;
                            }
                            projectHours += hours;
                            totalHours += hours;

                            let currentDesc = task.task_description_for_customer ? task.task_description_for_customer : task.description;
                            // Strip HTML tags for textarea editing
                            let cleanDesc = currentDesc.replace(/<[^>]*>/g, '').trim();

                            professionalTasks[task.id] = cleanDesc;

                            html += `
                            <tr>
                                <td>
                                    <strong>${escapeHtml(task.name)}</strong>
                                    <br/>
                                    <small class="text-muted">${formatDate(task.created_at)}</small>
                                </td>
                                <td>
                                    <textarea id="task-desc-${task.id}" class="form-control task-row-textarea" data-taskid="${task.id}">${escapeHtml(cleanDesc)}</textarea>
                                </td>
                                <td>${escapeHtml(task.first_name + ' ' + task.last_name)}</td>
                                <td class="text-right font-weight-bold">${hours.toFixed(1)} h</td>
                            </tr>`;
                        });

                        html += `
                                            <tr style="background-color:#f8f9fa;">
                                                <td colspan="3" class="text-right font-weight-bold">Project Total:</td>
                                                <td class="text-right font-weight-bold">${projectHours.toFixed(1)} h</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>`;
                    });
                }

                // General Tasks
                if (data.no_project_tasks && data.no_project_tasks.length > 0) {
                    let projectHours = 0;
                    html += `
                    <div class="card project-card mb-4 shadow-sm bg-white">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0 text-primary">General Tasks</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="30%">Task Name</th>
                                            <th width="45%">Description (Editable for Client Report)</th>
                                            <th width="15%">Assigned To</th>
                                            <th width="10%" class="text-right">Hours</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                    data.no_project_tasks.forEach(function (task) {
                        let hours = parseFloat(task.custom_total_time ? (task.custom_total_time / 60) : (task.total_time ? (task.total_time / 3600) : 0));
                        if (task.custom_total_time) {
                            hours = parseFloat(task.custom_total_time) / 60;
                        }
                        projectHours += hours;
                        totalHours += hours;

                        let currentDesc = task.task_description_for_customer ? task.task_description_for_customer : task.description;
                        let cleanDesc = currentDesc.replace(/<[^>]*>/g, '').trim();

                        professionalTasks[task.id] = cleanDesc;

                        html += `
                        <tr>
                            <td>
                                <strong>${escapeHtml(task.name)}</strong>
                                <br/>
                                <small class="text-muted">${formatDate(task.created_at)}</small>
                            </td>
                            <td>
                                <textarea id="task-desc-${task.id}" class="form-control task-row-textarea" data-taskid="${task.id}">${escapeHtml(cleanDesc)}</textarea>
                            </td>
                            <td>${escapeHtml(task.first_name + ' ' + task.last_name)}</td>
                            <td class="text-right font-weight-bold">${hours.toFixed(1)} h</td>
                        </tr>`;
                    });

                    html += `
                                        <tr style="background-color:#f8f9fa;">
                                            <td colspan="3" class="text-right font-weight-bold">Total:</td>
                                            <td class="text-right font-weight-bold">${projectHours.toFixed(1)} h</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;
                }

                if (html === '') {
                    html = '<div class="alert alert-warning text-center p-3">No tasks worked on in this date range.</div>';
                }

                $('#preview-content').html(html);
                $('#preview-total-hours').text(totalHours.toFixed(1));

                // Listen to edits in description textareas
                $('.task-row-textarea').on('input', function () {
                    let taskId = $(this).data('taskid');
                    professionalTasks[taskId] = $(this).val();
                });
            }

            // Forms Submit handling
            function updateFormHiddenFields() {
                let customerId = $('#customer_id').val();
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();
                let execSummary = $('#executive_summary').val();
                let destEmail = $('#destination_email').val();
                let profTasksStr = JSON.stringify(professionalTasks);

                // PDF Form fields
                $('#pdf_customer_id').val(customerId);
                $('#pdf_start_date').val(startDate);
                $('#pdf_end_date').val(endDate);
                $('#pdf_executive_summary').val(execSummary);
                $('#pdf_professional_tasks').val(profTasksStr);

                // Email Form fields
                $('#email_customer_id').val(customerId);
                $('#email_start_date').val(startDate);
                $('#email_end_date').val(endDate);
                $('#email_destination').val(destEmail);
                $('#email_executive_summary').val(execSummary);
                $('#email_professional_tasks').val(profTasksStr);
            }

            $('#pdf-form').submit(function () {
                updateFormHiddenFields();
            });

            $('#email-form').submit(function (e) {
                let destEmail = $('#destination_email').val();
                if (!destEmail || !validateEmail(destEmail)) {
                    $.notify('Please enter a valid destination email address.', 'error');
                    e.preventDefault();
                    return false;
                }
                updateFormHiddenFields();
                $.notify('Sending email with PDF report. Please wait...', 'info');
            });

            // Helpers
            function escapeHtml(text) {
                if (!text) return '';
                var map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) { return map[m]; });
            }

            function formatDate(dateStr) {
                if (!dateStr) return '';
                let d = new Date(dateStr);
                let options = { month: 'short', day: 'numeric', year: 'numeric' };
                return d.toLocaleDateString('en-US', options);
            }

            function validateEmail(email) {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            }
        });
    </script>
</body>

</html>
