<?php
    namespace Se7entech\Contractnew\Modules\Zones;
    require('../../envloader.php');
    require('../../config/config.php');
    require('../../config/connection.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <style>
            .required{
                color:red;
            }
        </style>
    </head>
    <body class="">
        <?php include ('../../sidebar.php'); ?>
        <div class="main-content">
            <?php include ('../../nav.php'); ?>
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                            <?php if($this->session->get('access') == '0'):?>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add new Task</a>
                                </li>
                            <?php endif;?>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 <?php echo $this->session->get('access') == '0' ? '': 'active';?>" id="tabs-media-list" data-toggle="tab" href="#listzones" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-users mr-2"></i>Tasks List</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Top navbar -->
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <br />
                        <div class="tab-content" id="tabs">
                            <!-- Tab Managment -->
                            <?php if($this->session->get('access') == '0'):?>
                                <div class="tab-pane fade show active" id="addzone" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                                    <div class="card bg-secondary shadow">
                                        <div class="card-header bg-white border-0">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h3 class="mb-0">Tasks Management</h3>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <?php if(count($this->data['session'])):?>
                                                        <?php foreach ($this->data['session'] as $msg)
                                                            echo $msg;    
                                                        ?>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="heading-small text-muted mb-4">Add information</h6>
                                            <div class="pl-lg-4">       
                                                <form id="postzone" method="POST">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="task-labels">Task Label</label>
                                                                <br>
                                                                <!-- Multiple select for task labels -->
                                                                <select id="task-labels" name="task-labels[]" class="form-control noselecttwo" multiple>
                                                                    <option value="">Select Label</option>
                                                                    <?php if (!empty($this->data['labels'])): ?>
                                                                        <?php foreach ($this->data['labels'] as $label): ?>
                                                                            <option value="<?php echo htmlspecialchars($label['id']); ?>" <?php echo (isset($this->data['last_data']['task-label']) && $this->data['last_data']['task-label'] == $label['id']) ? 'selected' : ''; ?>>
                                                                                <span style="background-color: <?php echo htmlspecialchars($label['background_color']); ?>; color: <?php echo htmlspecialchars($label['text_color']); ?>; padding: 2px 5px; border-radius: 3px;">
                                                                                    <?php echo htmlspecialchars($label['name']); ?>
                                                                                </span>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="task-categories">Task Category</label>
                                                                <br>
                                                                <!-- Multiple select for task categories -->
                                                                <select id="task-categories" name="task-categories[]" class="form-control" multiple>
                                                                    <option value="">Select Category</option>
                                                                    <?php if (!empty($this->data['categories'])): ?>
                                                                        <?php foreach ($this->data['categories'] as $category): ?>
                                                                            <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo (isset($this->data['last_data']['task-categories']) && $this->data['last_data']['task-categories'] == $category['id']) ? 'selected' : ''; ?>>
                                                                                <span>
                                                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                                                </span>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group  ">
                                                                <label class="form-control-label" for="customer-id">Customer <span class="required">*</span></label>
                                                                <br>
                                                                <select name="customer-id" id="customer-id" class="form-control">
                                                                    <option value="">SELECT A CUSTOMER</option>
                                                                    <?php foreach($this->data['customers'] as $customer):?>
                                                                        <option value="<?php echo $customer['id'];?>"><?php echo $customer['type'] . ' - ' .$customer['business_name'] . ' - ' . $customer['name'];;?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="customer-tempname">Customer Name <span class="required">*</span></label>
                                                                <input value="<?php echo isset($this->data['last_data']['customer-tempname']) ? $this->data['last_data']['customer-tempname'] : '';?>" type="text" id="customer-tempname" name="customer-tempname" placeholder="Example: Los Jerezanos" class="form-control">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="task-labels">Task Project</label>
                                                                <select id="task-project" name="task-project" class="form-control">
                                                                    <option value="">Select a project for this task</option>
                                                                    <?php 
                                                                        if(!empty($this->data['projects'])):
                                                                            foreach($this->data['projects'] as $project):?>
                                                                                <option <?php echo ($this->data['last_data']['task-project'] == $project['id']) ? 'selected' : '';?> value="<?php echo $project['id'];?>"><?php echo $project['name'];?></option>
                                                                            <?php
                                                                            endforeach;
                                                                        endif;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group  ">
                                                                <label class="form-control-label" for="task-name">Task Name <span class="required">*</span></label>
                                                                <input value="<?php echo isset($this->data['last_data']['task-name']) ? $this->data['last_data']['task-name'] : '';?>" type="text" id="task-name" name="task-name" placeholder="Example: Create Design" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group  ">
                                                                <label class="form-control-label" for="task-description">Task Description <span class="required">*</span></label>
                                                                <div class="task-description-wrapper" style="display:block; position:relative;">
                                                                    <textarea id="task-description" rows="10" class="form-control" name="task-description" placeholder="Describe the task here..." style="height: 250px; overflow-y: auto;">
                                                                        <?php echo isset($this->data['last_data']['task-description']) ? $this->data['last_data']['task-description'] : '';?>
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="task-user">Asign to <span class="required">*</span></label>
                                                                <select id="task-user" name="task-user" class="form-control">
                                                                    <option value="">Select User</option>
                                                                    <?php if(count($this->data['users'])):?>
                                                                        <?php foreach($this->data['users'] as $user):?>
                                                                            <option value="<?php echo $user['id'];?>" <?php echo (isset($this->data['last_data']['task-user']) && $this->data['last_data']['task-user'] == $user['id']) ? 'selected' : '';?>><?php echo $user['first_name'];?> <?php echo $user['last_name'];?>(<?php echo $user['email'];?>)</option>
                                                                        <?php endforeach;?>
                                                                    <?php endif;?>
                                                                </select>
                                                                <!-- <input value="<?php echo isset($this->data['last_data']['task-user']) ? $this->data['last_data']['task-user'] : '';?>" type="text" id="task-user" name="task-user" class="form-control"> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="deadline">Deadline</label>
                                                                <br>
                                                                <input type="text" id="deadline" name="deadline" value="<?php echo isset($this->data['last_data']['deadline']) ? $this->data['last_data']['deadline'] : '';?>" class="form-control datepicker" placeholder="Select a deadline">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="estimated_time">Estimated time (in hours)</label>
                                                                <br>
                                                                <input type="number" step="0.5" id="estimated_time" name="estimated_time" value="<?php echo isset($this->data['last_data']['estimated_time']) ? $this->data['last_data']['estimated_time'] : '';?>" class="form-control" placeholder="Estimated time in hours">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="task-description-for-customer">Task Description for customer <span class="required">*</span></label>
                                                                <div class="task-description-wrapper" style="display:block; position:relative;">
                                                                    <textarea id="task-description-for-customer" rows="10" class="form-control" name="task-description-for-customer" placeholder="Describe the task here..." style="height: 250px; overflow-y: auto;">
                                                                        <?php echo isset($this->data['last_data']['task-description-for-customer']) ? $this->data['last_data']['task-description-for-customer'] : '';?>
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" name="save" value="1" class="btn btn-primary">Add New Task</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                            <!-- Tab Managment -->

                            <!-- Tab Apps -->
                            <!-- Tab Media List -->
                            <div class="tab-pane fade show <?php echo $this->session->get('access') == '0' ? '': 'active';?>" id="listzones" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="card card-profile shadow">
                                    <div class="card-body" style="overflow-x:hidden;">
                                        <table id="roles-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                            <thead style="background:#337ab7;color:white;"> 
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Task Name</th>
                                                    <th>Customer</th>
                                                    <th>Task User</th>
                                                    <th>Status</th>
                                                    <th>Labels</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="roles-list-tbody">
                                                <?php if(count($this->data['tasks'])):?>
                                                    <?php foreach($this->data['tasks'] as $task):?>
                                                        <tr>
                                                            <td><?php echo $task['id'];?></td>
                                                            <td><?php echo $task['name'];?></td>
                                                            <td>
                                                                <?php 
                                                                    $clientName = '';
                                                                    if (!empty($task['customer_name'])) {
                                                                        $clientName .= $task['customer_name'];
                                                                        if (!empty($task['customer_business_name'])) {
                                                                            $clientName .= ' - ' . $task['customer_business_name'];
                                                                        }
                                                                        if (!empty($task['customer_tempname'])) {
                                                                            $clientName .= ' (' . $task['customer_tempname'] . ')';
                                                                        }
                                                                    } else {
                                                                        $clientName = $task['customer_tempname'];
                                                                    }
                                                                    echo htmlspecialchars($clientName);
                                                                ?>
                                                            </td>
                                                            <td><?php 
                                                                 $assigned = trim($task['first_name'] . ' ' . $task['last_name']);
                                                                 if (!empty($assigned)) {
                                                                     echo htmlspecialchars($assigned . ' (' . $task['email'] . ')');
                                                                 } else {
                                                                     echo '<span class="text-muted">Unassigned</span>';
                                                                 }
                                                             ?></td>

                                                            <td>
                                                                <?php 
                                                                    if($task['status'] == 'created'){
                                                                        echo '<span class="badge badge-info">Created</span>';
                                                                    }else if($task['status'] == 'started'){
                                                                        echo '<span class="badge badge-warning">Started</span>';
                                                                    }else if($task['status'] == 'finished'){
                                                                        echo  '<span class="badge badge-success">Finished</span>';
                                                                    }else if($task['status'] == 'paused'){
                                                                        echo '<span class="badge badge-danger">Paused</span>';
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    if (!empty($task['labels'])) {
                                                                        $labelIds = array_map('trim', explode(',', $task['labels']));
                                                                        $labelsMap = [];
                                                                        foreach ($this->data['labels'] as $label) {
                                                                            $labelsMap[$label['id']] = $label;
                                                                        }
                                                                        $hasLabels = false;
                                                                        foreach ($labelIds as $labelId) {
                                                                            if (isset($labelsMap[$labelId])) {
                                                                                $label = $labelsMap[$labelId];
                                                                                echo '<span style="background-color: ' . htmlspecialchars($label['background_color']) . '; color: ' . htmlspecialchars($label['text_color']) . '; padding: 2px 5px; border-radius: 3px; margin-right:2px;">'
                                                                                    . htmlspecialchars($label['name']) .
                                                                                    '</span>';
                                                                                $hasLabels = true;
                                                                            }
                                                                        }
                                                                        if (!$hasLabels) {
                                                                            echo '<span class="badge badge-light">No Labels</span>';
                                                                        }
                                                                    } else {
                                                                        echo '<span class="badge badge-light">No Labels</span>';
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?php echo $base_url;?>/modules/tasks/index.php/<?php echo $task['id'];?>/view" class="btn btn-success">View</a>
                                                                <?php if($this->session->get('access') == '0'):?>
                                                                    <a href="<?php echo $base_url;?>/modules/tasks/index.php/<?php echo $task['id'];?>" class="btn btn-primary">Edit</a>
                                                                    <a href="#" class="btn btn-danger" data-id="<?php echo $task['id'];?>" onclick="showModal(this)">Delete</a>
                                                                <?php endif;?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </tbody>
                                        </table>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
         </footer>
        <!-- Commented because navtabs includes same script -->
        <?php include '../../layout/footer_scripts.php';?>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">        
        <script src="<?php echo $base_url;?>/js/summernote.min.js"></script>
        <style>
            .task-description-wrapper b{
                font-weight: bold !important;
            }
        </style>
        <script>
            
            $(document).ready(function(){
                $('#roles-list-table').DataTable({
                    responsive: true,
                    order: [[0, 'desc']]
                });
                $('#task-description').summernote({
                    height: 250,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link']],
                        ['view', ['codeview']]
                    ]
                });

                $('#task-description-for-customer').summernote({
                    height: 250,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link']],
                        ['view', ['codeview']]
                    ]
                });

                // Initialize Select2 for task-label
                function formatState (state) {
                    if (!state.id) {
                        return state.text;
                    }
                    var $state = $(state.element.innerHTML);
                    return $state;
                };

                $("#task-labels").select2({
                    templateSelection: formatState,
                    templateResult: formatState
                });

                // // Initialize Select2 for customer-id
                // $("#customer-id").select2();

                //check if there is #listzones in the URL
                if(window.location.hash === '#listzones'){
                    $('#tabs-media-list').addClass('show active');
                    $('#tabs-menagment-main').removeClass('show active');
                    $('#listzones').addClass('show active');
                    $('#addzone').removeClass('show active');
                    // Refresh DataTable after tab change
                    $('#roles-list-table').DataTable().columns.adjust().responsive.recalc();
                }

                // Also refresh DataTable when tab is changed by clicking
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    if ($(e.target).attr('href') === '#listzones') {
                        $('#roles-list-table').DataTable().columns.adjust().responsive.recalc();
                    }
                });

                //force datatable refresh to apply responsive styles
                $('#roles-list-table').DataTable().columns.adjust().responsive.recalc();

                // Use jQuery event for select2 change
                
                $('#customer-id').on('change', function() {
                    console.log('changed');
                    var customerId = $(this).val();
                    var projectSelect = document.getElementById('task-project');
                    // Clear existing options except the first
                    projectSelect.options.length = 1;

                    if (customerId) {
                        $.ajax({
                            url: '<?php echo $base_url; ?>/modules/projects/index.php/ajax/get_projects_by_customer_id',
                            type: 'POST',
                            data: { customer_id: customerId },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success && Array.isArray(response.projects)) {
                                    response.projects.forEach(function(project) {
                                        var option = document.createElement('option');
                                        option.value = project.id;
                                        option.text = project.name;
                                        projectSelect.appendChild(option);
                                    });
                                }
                            }
                        });
                    }
                });

                flatpickr("#deadline", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                });
                
            })
            
            function showModal(button){
                let id = button.dataset.id;
                let row = button.parentElement.parentElement;    

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    console.log(confirmed)
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/tasks/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#roles-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Task deleted!', 'success')
                                //TODO: delete row from datatable
                            }
                        })
                        xhr.send(data)
                    }
                });
            }

            
        </script>        
    </body>
</html>