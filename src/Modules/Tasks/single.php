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
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Updating Task <?php echo $this->data['current']['name'];?></a>
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
                        <div class="tab-pane fade show active" id="addzone" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3 class="mb-0">Task Management</h3>
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
                                    <h6 class="heading-small text-muted mb-4">Edit information</h6>
                                    <div class="pl-lg-4">       
                                        <form id="postzone" method="POST">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-labels">Task Label</label>
                                                        <br>
                                                        <!-- Multiple select for task labels -->
                                                        <select id="task-labels" name="task-labels[]" class="form-control noselecttwo" multiple>
                                                            <option value="">Select Label</option>
                                                            <?php
                                                                if (!empty($this->data['labels'])):
                                                                    // Get selected label ids as array
                                                                    $selectedLabels = array_map('trim', explode(',', $this->data['current']['labels'] ?? ''));
                                                                    foreach ($this->data['labels'] as $label):
                                                                        $selected = in_array($label['id'], $selectedLabels) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo htmlspecialchars($label['id']); ?>" <?php echo $selected; ?>>
                                                                    <span style="background-color: <?php echo htmlspecialchars($label['background_color'] ?? '#ccc'); ?>; color: <?php echo htmlspecialchars($label['text_color'] ?? '#ccc'); ?>; padding: 2px 8px; border-radius: 12px; font-size: 90%;">
                                                                        <?php echo htmlspecialchars($label['name']); ?>
                                                                    </span>
                                                                </option>
                                                            <?php
                                                                    endforeach;
                                                                endif;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-labels">Task Category</label>
                                                        <br>
                                                        <!-- Multiple select for task labels -->
                                                        <select id="task-categories" name="task-categories[]" class="form-control" multiple>
                                                            <option value="">Select Category</option>
                                                            <?php
                                                                if (!empty($this->data['categories'])):
                                                                    // Get selected label ids as array
                                                                    $selectedCategories = array_map('trim', explode(',', $this->data['current']['categories'] ?? ''));
                                                                    foreach ($this->data['categories'] as $category):
                                                                        $selected = in_array($category['id'], $selectedCategories) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo $selected; ?>>
                                                                    <span>
                                                                        <?php echo htmlspecialchars($category['name']); ?>
                                                                    </span>
                                                                </option>
                                                            <?php
                                                                    endforeach;
                                                                endif;
                                                            ?>
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
                                                                <option <?php echo ($customer['id'] == $this->data['current']['customer_id']) ? ' selected ' : '';?> value="<?php echo $customer['id'];?>"><?php echo $customer['type'] . ' - ' .$customer['business_name'] . ' - ' . $customer['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="customer-tempname">Customer Name <span class="required">*</span></label>
                                                        <input value="<?php echo isset($this->data['current']['customer_tempname']) ? $this->data['current']['customer_tempname'] : '';?>" type="text" id="customer-tempname" name="customer-tempname" placeholder="Example: Los Jerezanos" class="form-control">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group  ">
                                                        <label class="form-control-label" for="task-name">Task Name <span class="required">*</span></label>
                                                        <input value="<?php echo $this->data['current']['name'];?>" type="text" id="task-name" name="task-name" placeholder="Example: Create Design" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group  ">
                                                        <label class="form-control-label" for="task-description">Task Description <span class="required">*</span></label>
                                                        
                                                        <div class="task-description-wrapper" style="display:block; position:relative;">
                                                            <textarea id="task-description" rows="10" class="form-control" name="task-description" placeholder="Describe the task here..." style="height: 250px; overflow-y: auto;">
                                                                <?php echo $this->data['current']['description'];?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-user">Asign to <span class="required">*</span></label>
                                                        <select id="task-user" name="task-user" class="form-control">
                                                            <option value="">Select User</option>
                                                            <?php if(count($this->data['users'])):?>
                                                                <?php foreach($this->data['users'] as $user):?>
                                                                    <option <?php echo ($user['id'] == $this->data['current']['asigned_to']) ? ' selected ' : '';?> value="<?php echo $user['id'];?>" <?php echo (isset($this->data['last_data']['task-user']) && $this->data['last_data']['task-user'] == $user['id']) ? 'selected' : '';?>><?php echo $user['first_name'];?> <?php echo $user['last_name'];?>(<?php echo $user['email'];?>)</option>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
                                                        </select>
                                                        <!-- <input value="<?php echo isset($this->data['last_data']['task-user']) ? $this->data['last_data']['task-user'] : '';?>" type="text" id="task-user" name="task-user" class="form-control"> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" name="save" value="1" class="btn btn-success">Update Task</button>
                                                <a href="<?php echo $this->base_url;?>/modules/tasks/#listzones" class="btn btn-primary">Tasks List</a>
                                            </div>
                                        </form>
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
        </div>
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
            // Initialize Quill editor
             $(document).ready(function(){
                let descriptionValue = `<?php echo addslashes($this->data['current']['description']); ?>`;
                // Initialize Summernote editor
                $('#task-description').summernote({
                    height: 250, // Set the height of the editor
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
            })
        </script>
    </body>
</html>