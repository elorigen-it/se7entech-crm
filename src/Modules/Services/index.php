<?php
    namespace Se7entech\Contractnew\Modules\Zones;

    require('../../config/config.php');
    require('../../connection.php');

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
        <link rel="stylesheet" href="<?php echo $base_url;?>/editor/summernote-bs4.min.css">
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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add new Service</a>
                            </li>    
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-media-list" data-toggle="tab" href="#listzones" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-users mr-2"></i>Services List</a>
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
                                                <h3 class="mb-0">Services Management</h3>
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
                                                        <div class="form-group  ">
                                                            <label class="form-control-label" for="service-name">Service Name <span class="required">*</span></label>
                                                            <input value="<?php echo isset($this->data['last_data']['service-name']) ? $this->data['last_data']['service-name'] : '';?>" type="text" id="service-name" name="service-name" placeholder="Example: Website Development" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group  ">
                                                            <label class="form-control-label" for="service-price">Service Price<span class="required">*</span></label>
                                                            <input value="<?php echo isset($this->data['last_data']['service-price']) ? $this->data['last_data']['service-price'] : '';?>" type="text" id="service-price" name="service-price" placeholder="Example: 310" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group  ">
                                                            <label class="form-control-label" for="service-description">Service Description<span class="required">*</span></label>
                                                            <textarea id="service-description" name="service-description" class="form-control"><?php echo isset($this->data['last_data']['service-description']) ? $this->data['last_data']['service-description'] : '';?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group  ">
                                                            <label class="form-control-label" for="department">Department<span class="required">*</span></label>
                                                            <select class="form-control" id="department" name="department">
                                                                <option>SELECT DEPARTMENT</option>
                                                                <?php foreach($this->data['departments'] as $department):?>
                                                                    <option value="<?php echo $department['id'];?>"> 
                                                                        <?php echo $department['name'];?>
                                                                    </option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" name="save" value="1" class="btn btn-primary">Add New Service</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab Apps -->
                            <!-- Tab Media List -->
                            <div class="tab-pane fade show" id="listzones" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="card card-profile shadow">
                                    <div class="card-header">
                                        <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for names.." title="Type in a name" class="form-control">
                                    </div>
                                    <div class="card-body" style="overflow-x:hidden;">
                                        <table id="roles-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                            <thead style="background:#337ab7;color:white;"> 
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Service Name</th>
                                                    <th>Service Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="roles-list-tbody">
                                                <?php if(count($this->data['services'])):?>
                                                    <?php foreach($this->data['services'] as $service):?>
                                                        <tr>
                                                            <td><?php echo $service['id'];?></td>
                                                            <td><?php echo $service['name'];?></td>
                                                            <td><?php echo $service['price'];?></td>
                                                            <td>
                                                                <a href="<?php echo $base_url;?>/modules/services/index.php/<?php echo $service['id'];?>" class="btn btn-primary">Edit</a>
                                                                <a href="#" class="btn btn-danger" data-id="<?php echo $service['id'];?>" onclick="showModal(this)">Delete</a>
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
        <script src="<?php echo $base_url;?>/editor/summernote-bs4.min.js"></script>
        <script>
            
            $(document).ready(function(){
                // $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                //     var target = $(e.target).attr("href") // activated tab
                //     if(target === '#media-list'){
                //         $($.fn.dataTable.tables(true)).DataTable()
                //         .columns.adjust()
                //         .responsive.recalc(); 
                       
                //         // $('#video-list-tbody').html("<img src='<?php echo $base_url;?>/modules/videos/images/uploading.gif' >")
                //         // updateMediaListTable()                      
                //     }
                // });

                $('#roles-list-table').DataTable({
                    responsive:true
                })

                $('#service-description').summernote();

            });

            function filterTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("roles-list-table");
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
                    console.log(confirmed)
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/services/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#roles-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Service deleted!', 'success')
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