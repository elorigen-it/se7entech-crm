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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add new Zone</a>
                            </li>    
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-media-list" data-toggle="tab" href="#listzones" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-users mr-2"></i>Zone List</a>
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
                                            <h3 class="mb-0">Zones Management</h3>
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
                                                        <label class="form-control-label" for="zone-name">Zone Name <span class="required">*</span></label>
                                                        <input value="<?php echo isset($this->data['last_data']['zone-name']) ? $this->data['last_data']['zone-name'] : '';?>" type="text" id="zone-name" name="zone-name" placeholder="Example: New York - West" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="form-group  ">
                                                        <label class="form-control-label" for="zone-code">Zone Code <span class="required">*</span></label>
                                                        <input value="<?php echo isset($this->data['last_data']['zone-code']) ? $this->data['last_data']['zone-code'] : '';?>" type="text" id="zone-code" name="zone-code" placeholder="Example: NY-W" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" name="save" value="1" class="btn btn-primary">Add New Zone</button>
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
                                    <table id="zones-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                        <thead style="background:#337ab7;color:white;"> 
                                            <tr>
                                                <th>ID</th>
                                                <th>Zone Name</th>
                                                <th>Zone Code</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="zones-list-tbody">
                                            <?php if(count($this->data['zones'])):?>
                                                <?php foreach($this->data['zones'] as $zone):?>
                                                    <tr>
                                                        <td><?php echo $zone['id'];?></td>
                                                        <td><?php echo $zone['name'];?></td>
                                                        <td><?php echo $zone['code'];?></td>
                                                        <td>
                                                            <a href="<?php echo $base_url;?>/modules/zones/index.php/<?php echo $zone['id'];?>" class="btn btn-primary">Edit</a>
                                                            <a href="#" class="btn btn-danger" data-id="<?php echo $zone['id'];?>" onclick="showModal(this)">Delete</a>
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
         <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
         </footer>
        </div>
        <!-- Commented because navtabs includes same script -->
        <?php include '../../layout/footer_scripts.php';?>
        <script>
            
            $(document).ready(function(){
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if(target === '#media-list'){
                        $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust()
                        .responsive.recalc(); 
                       
                        // $('#video-list-tbody').html("<img src='<?php echo $base_url;?>/modules/videos/images/uploading.gif' >")
                        // updateMediaListTable()                      
                    }
                });

                $('#zones-list-table').DataTable({
                    responsive:true
                })
            });

            function filterTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("zones-list-table");
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
                        let endpoint = "<?php echo $base_url;?>/modules/zones/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#zones-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Zone deleted!', 'success')
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