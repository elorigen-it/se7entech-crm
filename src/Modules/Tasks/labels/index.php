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
                                    <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addlabel" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-tag mr-2"></i>Add new Label</a>
                                </li>
                            <?php endif;?>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 <?php echo $this->session->get('access') == '0' ? '': 'active';?>" id="tabs-media-list" data-toggle="tab" href="#listlabels" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-tags mr-2"></i>Labels List</a>
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
                                <div class="tab-pane fade show active" id="addlabel" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                                    <div class="card bg-secondary shadow">
                                        <div class="card-header bg-white border-0">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h3 class="mb-0">Task Labels Management</h3>
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
                                            <h6 class="heading-small text-muted mb-4">Add Label</h6>
                                            <div class="pl-lg-4">       
                                                <form id="postlabel" method="POST" >
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="label-name">Label Name <span class="required">*</span></label>
                                                                <input value="<?php echo isset($this->data['last_data']['label-name']) ? $this->data['last_data']['label-name'] : '';?>" type="text" id="label-name" name="label-name" placeholder="Example: Urgent" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="label-background-color">Label Background Color <span class="required">*</span></label>
                                                                <input value="<?php echo isset($this->data['last_data']['label-background-color']) ? $this->data['last_data']['label-background-color'] : '#337ab7';?>" type="color" id="label-background-color" name="label-background-color" class="form-control" style="height: 38px; width: 60px; padding: 2px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="label-text-color">Label Text Color <span class="required">*</span></label>
                                                                <input value="<?php echo isset($this->data['last_data']['label-text-color']) ? $this->data['last_data']['label-text-color'] : '#ffffff';?>" type="color" id="label-text-color" name="label-text-color" class="form-control" style="height: 38px; width: 60px; padding: 2px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <!-- create a preview of the label -->
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="label-preview">Label Preview</label>
                                                                <br>
                                                                <div id="label-preview" style="padding: 10px; text-align:center; width:auto; display:inline; min-width: 100px; background-color: <?php echo isset($this->data['last_data']['label-background-color']) ? $this->data['last_data']['label-background-color'] : '#337ab7';?>; color: <?php echo isset($this->data['last_data']['label-text-color']) ? $this->data['last_data']['label-text-color'] : '#ffffff';?>; border-radius: 4px;">
                                                                    <?php echo isset($this->data['last_data']['label-name']) ? htmlspecialchars($this->data['last_data']['label-name']) : 'Label Name';?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" name="save" value="1" class="btn btn-primary">Add New Label</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                            <!-- Tab Managment -->

                            <!-- Tab Labels List -->
                            <div class="tab-pane fade show <?php echo $this->session->get('access') == '0' ? '': 'active';?>" id="listlabels" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="card card-profile shadow">
                                    <div class="card-header">
                                        <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for label names.." title="Type in a label name" class="form-control">
                                    </div>
                                    <div class="card-body" style="overflow-x:hidden;">
                                        <table id="labels-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                            <thead style="background:#337ab7;color:white;"> 
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Label</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="labels-list-tbody">
                                                <?php if(count($this->data['labels'])):?>
                                                    <?php foreach($this->data['labels'] as $label):?>
                                                        <tr>
                                                            <td><?php echo $label['id'];?></td>
                                                            <td style="text-align:center;">
                                                                <div style="display:flex;justify-content:center;align-items:center;">
                                                                    <div style="text-align:center; display:inline; background-color:<?php echo htmlspecialchars($label['background_color']);?>;color:<?php echo htmlspecialchars($label['text_color']);?>;padding:8px;border-radius:4px;">
                                                                        <?php echo htmlspecialchars($label['name']);?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php if($this->session->get('access') == '0'):?>
                                                                    <a href="<?php echo $base_url;?>/modules/tasks/index.php/labels/<?php echo $label['id'];?>" class="btn btn-primary">Edit</a>
                                                                    <a href="#" class="btn btn-danger" data-id="<?php echo $label['id'];?>" onclick="showModal(this)">Delete</a>
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
        <?php include '../../layout/footer_scripts.php';?>
        <script>
            $(document).ready(function(){
                $('#labels-list-table').DataTable({
                    responsive: true,
                    order: [[0, 'desc']]
                });

                //create the logic for the label preview
                $('#label-name, #label-background-color, #label-text-color').on('input', function() {
                    let name = $('#label-name').val() || 'Label Name';
                    let backgroundColor = $('#label-background-color').val() || '#337ab7';
                    let textColor = $('#label-text-color').val() || '#ffffff';

                    $('#label-preview').text(name);
                    $('#label-preview').css('background-color', backgroundColor);
                    $('#label-preview').css('color', textColor);
                });

                //check if there is #listlabels in the URL
                if(window.location.hash === '#listlabels'){
                    $('#tabs-media-list').addClass('show active');
                    $('#tabs-menagment-main').removeClass('show active');
                    $('#listlabels').addClass('show active');
                    $('#addlabel').removeClass('show active');
                }
            });

            function filterTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("labels-list-table");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    }       
                }
            }
            
            function showModal(button){
                let id = button.dataset.id;
                let row = button.parentElement.parentElement;    

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/tasks/index.php/labels/"+id+"/delete"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#labels-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Label deleted!', 'success')
                            }
                        })
                        xhr.send(data)
                    }
                });
            }
        </script>        
    </body>
</html>
