<?php
    session_start();
    require('../../vendor/autoload.php');
    require_once('../../config/config.php');
    require_once('../../connection.php');

    use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
    $md = new hasFilledRequirementForm();
    $md->handle(0);
    $sql = "SELECT `clients`.`businessname`, `clients`.`name`, `clients`.`id` from clients";
    $res = mysqli_query($con, $sql);
    $clients = array();
    if(mysqli_num_rows($res)){
        while($row = mysqli_fetch_assoc($res)){
            $row['source'] = 'clients';
            array_push($clients, $row);
        }
    }

    $sql = "SELECT `lead`.`businessname`, `lead`.`name`, `lead`.`id` from lead";
    $res = mysqli_query($con, $sql);
    $leads = array();
    if(mysqli_num_rows($res)){
        while($row = mysqli_fetch_assoc($res)){
            $row['source'] = 'lead';
            array_push($leads, $row);
        }
    }

    $sql = "SELECT `colleges`.`client_name` as businessname, `colleges`.`name`, `colleges`.`id` from colleges";
    $res = mysqli_query($con, $sql);
    $pins = array();
    if(mysqli_num_rows($res)){
        while($row = mysqli_fetch_assoc($res)){
            $row['source'] = 'colleges';
            array_push($pins, $row);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Upload Video</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-media-list" data-toggle="tab" href="#media-list" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-users mr-2"></i>Video List</a>
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
                        <div class="tab-pane fade show active" id="menagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3 class="mb-0">Video Management</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="heading-small text-muted mb-4">Add information</h6>
                                    <div class="pl-lg-4">       
                                        <form id="uploadForm" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                   <div class="form-group  ">
                                                        <label class="form-control-label" for="leads-clients">Lead/Client</label>
                                                        <select name="leads-clients" id="leads-clients" class="form-control" required>
                                                            <option value="no-lead-client">Not Specified</option>
                                                            <?php if(count($clients)):?>
                                                                <optgroup label="Clients">
                                                                    <?php foreach($clients as $client): ?>
                                                                        <option value="<?php echo $client['source'] . '_' . $client['id'];?>"><?php echo $client['businessname'];?> - (<?php echo $client['name'];?>)</option>
                                                                    <?php endforeach;?>
                                                                </optgroup>
                                                            <?php endif;?>

                                                            <?php if(count($leads)):?>
                                                                <optgroup label="Leads">
                                                                    <?php foreach($leads as $lead): ?>
                                                                        <option value="<?php echo $lead['source'] . '_' . $lead['id'];?>"><?php echo $lead['businessname'];?> - (<?php echo $lead['name'];?>)</option>
                                                                    <?php endforeach;?>
                                                                </optgroup>
                                                            <?php endif;?>

                                                            <?php if(count($pins)):?> 
                                                                <optgroup label="Pins">
                                                                    <?php foreach($pins as $pin): ?>
                                                                        <option value="<?php echo $pin['source'] . '_' . $pin['id'];?>"><?php echo $pin['businessname'];?> - (<?php echo $pin['name'];?>)</option>
                                                                    <?php endforeach;?>
                                                                </optgroup>
                                                            <?php endif;?>
                                                        </select> 
                                                        <p>
                                                            <label for="with-or-without-project">Do not create a new project</label> 
                                                            <input id="with-or-without-project" type="checkbox" name="with-or-without-project">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="project-options">
                                                    <div class="form-group">
                                                        <div id="loading-projects">
                                                            
                                                        </div>
                                                        <div id="project-name-wrapper">
                                                            <label class="form-control-label" for="project-name">Project Name</label>
                                                            <input type="text" id="project-name" name="project-name" class="form-control">
                                                        </div>
                                                        <div id="existing-project-id-wrapper" style="display:none">
                                                            <label class="form-control-label" for="existing-project-id">Select Project</label>
                                                            
                                                            <select id="existing-project-id" name="existing-project-id" class="form-control">
                                                                <option value="">Project1</option>
                                                                <option value="">Project2</option>
                                                            </select>
                                                        </div>

                                                        <p>
                                                            <label for="new-or-existing-project">Insert into an existing project</label> 
                                                            <input id="new-or-existing-project" type="checkbox" name="new-or-existing-project">
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group  ">
                                                        <label class="form-control-label" for="name">Upload File(Multiple)</label>
                                                        <input type="file" name="media[]" id="fileInput" multiple  class="form-control" accept="video/*" required>
                                                    </div>
                                                    <div id="uploadStatus"></div>
                                                    <div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div></div>
                                                </div>
                                                
                                                <!--<div class="col-md-12">-->
                                                <!-- <div id="form-group-name" class="form-group">-->
                                                <!--    <label class="form-control-label" for="name">Note</label>-->
                                                <!--    <textarea style="height:200px" name="notes"  class="form-control" placeholder="Note" ></textarea>-->
                                                <!-- </div>-->
                                                <!--</div>-->
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" name="submit" class="btn btn-primary" value="UPLOAD">Upload</button>
                                            </div>
                                        </form>
                                    
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tab Apps -->
                        <!-- Tab Media List -->
                        <div class="tab-pane fade show" id="media-list" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                            <div class="card card-profile shadow">
                                <div class="card-header">
                                    <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for names.." title="Type in a name" class="form-control">
                                </div>
                                <div class="card-body" style="overflow-x:hidden;">
                                    <table id="video-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                        <thead style="background:#337ab7;color:white;"> 
                                            <tr>
                                                <th>Video Scope</th>
                                                <th>Video Name</th>
                                                <th>Video Format</th>
                                                <th>Customer</th>
                                                <th>Project Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="video-list-tbody"></tbody>
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
                let $withOrWithoutProject = $('#with-or-without-project');
                let $projectOptions = $('#project-options');
                let $newOrExistingProject = $('#new-or-existing-project');
                let $projectNameWrapper = $('#project-name-wrapper');
                let $existingProjectIdWrapper = $('#existing-project-id-wrapper');
                let $existingProjectId = $('#existing-project-id');
                let $leadsClients = $('#leads-clients');

                let $progressbar = $('#progressbar')
                let $statustxt = $('#statustxt');

                const queryProjectsByCustomer = () => {
                    //make ajax call using the selected lead/client/pin - retrieve and show projects from database
                    let customerInfo = $leadsClients.val();
                    let customerTable = '';
                    let customerId = '';

                    if(customerInfo !== 'no-lead-client'){
                        customerTable = customerInfo.split('_')[0];
                        customerId = customerInfo.split('_')[1]
                    }
                    let data = new FormData();
                    data.set('customer_table', customerTable);
                    data.set('customer_id', customerId);

                    $.ajax({
                        type: 'POST',
                        url: "<?php echo $base_url . '/modules/videos/api/getProjectsByCustomer.php';?>",
                        data: data,
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend: function(){
                            $existingProjectIdWrapper.hide();
                            $('#loading-projects').show();
                            $('#loading-projects').html("<b>Loading...</b><br><img src='<?php echo $base_url;?>/modules/videos/images/uploading.gif'/>");
                        },
                        error:function(){},
                        success: function(response){
                            setTimeout(() => {
                                $('#loading-projects').hide();
                                let res = JSON.parse(response)
                                let options = '<option disabled>No projects found for this customer</option>';
                                if(res.success){
                                    if(res.results.length){
                                        options = '<option disabled>Select a project</option>';
                                        res.results.forEach((opt) => {
                                            options += '<option value="'+opt.id+'">'+opt.name+'</option>'
                                        })
                                        // res.result.map((opt) => {
                                        //     options .= '<option value="'+opt.id+"'>"+opt.name+"</option>"
                                        // })
                                        
                                    }
                                }
                                $existingProjectId.html(options)
                                $existingProjectIdWrapper.show();
                            }, 2000)
                        }
                    });
                }
                $leadsClients.on('change', (e) => {
                    if($newOrExistingProject.is(':checked')){
                        queryProjectsByCustomer()
                    }
                })
                
                $withOrWithoutProject.on('change', (e) => {
                    e.target.checked
                    if(e.target.checked){
                        $projectOptions.hide();
                    }else{
                        $projectOptions.show();
                    }
                })
                $newOrExistingProject.on('change', (e) => {
                    //user wants to use an existing project for store this video
                    if(e.target.checked){
                        $projectNameWrapper.hide();
                        queryProjectsByCustomer();
                        
                    }else{
                        //make dissapear existing project select
                        $existingProjectIdWrapper.hide();
                        $projectNameWrapper.show();
                    }
                    
                })

                //TODO: Create  progress bar
                const updateProgress = (e) => {
                    console.log(e);
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        $statustxt.html(percentComplete.toFixed(2) + '%'); //update status text
                        // progressbar.width(percentComplete + '%') //update progressbar percent complete
                    } else {
                        // Unable to compute progress information since the total size is unknown
                    }
                }
                const transferComplete = (e) => {
                    console.log(e)
                    let res = JSON.parse(e.target.response);
                    console.log(res)
                    if(res.success){
                        $projectOptions.show();
                        $projectNameWrapper.show();
                        $existingProjectIdWrapper.hide();

                        $('#uploadForm')[0].reset();
                        $('#uploadStatus').html('<span style="color:#28A74B;">Video uploaded successfully.<span>');
                        $statustxt.html('0%');
                    }else{
                        $('#uploadStatus').html('<span style="color:red;">Sorry something failed: '+res.message+'<span>');
                    }
                    // $('.gallery').html(data);
                }
                const transferFailed = (e) => {
                    console.log(e);
                    $('#uploadStatus').html('<span style="color:#EA4335;">Video upload failed, please try again.<span>');
                }
                const transferCanceled = (e) => {}

                const beforeTransfer = (xhr) => {
                    $statustxt.html('0%');
                    $('#uploadStatus').html('<img src="<?php echo $base_url;?>/modules/videos/images/uploading.gif"/>');
                }

                // File upload via Ajax
                $("#uploadForm").on('submit', function(e){
                    e.preventDefault();
                    let data = new FormData(this);
                    let url = "<?php echo $base_url;?>/modules/videos/upload.php";
                    let xhr = new XMLHttpRequest();

                    beforeTransfer(xhr);
                    xhr.open('POST', url, true);
                    xhr.upload.addEventListener("progress", updateProgress);
                    xhr.addEventListener("load", transferComplete);
                    xhr.addEventListener("error", transferFailed);
                    xhr.addEventListener("abort", transferCanceled);
                    xhr.send(data);

                    // $.ajax({
                    //     type: 'POST',
                    //     data: new FormData(this),
                    //     contentType: false,
                    //     cache: false,
                    //     processData:false,
                    //     beforeSend: function(){
                    //         $('#uploadStatus').html('<img src="uploading.gif"/>');
                    //     },
                    //     error:function(){
                    //         $('#uploadStatus').html('<span style="color:#EA4335;">Video upload failed, please try again.<span>');
                    //     },
                    //     success: function(data){
                    //         $withOrWithoutProject.is(':checked')
                    //         $('#uploadForm')[0].reset();
                    //         $('#uploadStatus').html('<span style="color:#28A74B;">Video uploaded successfully.<span>');
                    //         $('.gallery').html(data);
                    //     },
                    //     uploadProgress: (event, position, total, percentComplete) => {
                    //         //Progress bar
                    //         console.log(event);
                    //         progressbar.width(percentComplete + '%') //update progressbar percent complete
                    //         statustxt.html(percentComplete + '%'); //update status text
                    //         if(percentComplete>50)
                    //         {
                    //             statustxt.css('color','#fff'); //change status text to white after 50%
                    //         }
                    //     }
                    // });
                });
                
                // File type validation
                $("#fileInput").change(function(){
                    var fileLength = this.files.length;
                    var i;
                    for(i = 0; i < fileLength; i++){ 
                        var file = this.files[i];
                        console.log(checkMatch(file.type))
                        if(!(checkMatch(file.type))){
                            alert('Please select a valid video file (MP4/AVI/MPEG/OGV/WEBM/3GP/MOV/MOVIE).');
                            $("#fileInput").val('');
                            return false;
                        }
                    }
                });

                function checkMatch(type){
                    let allowed= ["video/mp4","video/x-msvideo","video/mpeg", "video/ogg", "video/webm", "video/3gpp", "video/avi", "video/quicktime", "video/x-sgi-movie"];
                    let matched = false;
                    allowed.forEach((_type) => {
                        console.log(type, _type)
                        if(type === _type){
                            matched = true;
                        }
                    })
                    return matched;
                }

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
                updateMediaListTable().then(res => {
                    $('#video-list-tbody').html(res);
                    console.log('updating');
                    $('#video-list-table').DataTable({
                        responsive:true
                    })
                    // let dataTable = new DataTable('#video-list-table');
                })
                
            });

            function filterTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("video-list-table");
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
            function updateMediaListTable(){
                return new Promise((resolve, reject) => {
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "<?php echo $base_url;?>/modules/videos/api/getVideos.php", true);
                    xhr.addEventListener('load', (e) => {
                        let res = JSON.parse(e.target.response)
                        if(res.success){
                            let htmlTbody = '';
                            if(res.num_rows){
                                res.data.map((el, index) => {
                                    let fieldAdapter = {
                                        colleges:{
                                            businessname: 'client_name',
                                            name: 'name'
                                        },
                                        lead:{
                                            businessname: 'businessname',
                                            name: 'name'
                                        },
                                        clients:{
                                            businessname: 'businessname',
                                            name: 'name'
                                        }
                                    }
                                    let scope = (el.project_id && el.customer_id) > 0 ? 'USER-PROJECT' : ((el.project_id) ? 'PROJECT' : ((el.customer_id > 0) ? 'GLOBAL-USER' : 'GLOBAL') )
                                    console.log(el.customer_id)
                                    let projectName = (el.project_id) ? el.project_name : 'N/A';
                                    
                                    let customerField = 'N/A';
                                    if(el.project_customer_info){
                                        let table = el.project_customer_info.table;
                                        customerField = el.project_customer_info[fieldAdapter[table].businessname] + ' - ' + el.project_customer_info[fieldAdapter[table].name]
                                    }else if(el.customer_info){
                                        let table = el.customer_info.table;
                                        customerField = el.customer_info[fieldAdapter[table].businessname] + ' - ' + el.customer_info[fieldAdapter[table].name]
                                    }
                                    htmlTbody += `<tr>
                                        <td>${scope}</td>
                                        <td><span style="font-size:.9em"><b>Original:</b>${el.original_name}<br><b>Directory:</b> ${el.path+'/'+el.video_name}</span></td>
                                        <td>${el.mime}</td>
                                        <td>${customerField}</td>
                                        <td>${projectName}</td>
                                        <td>
                                            <a target="blank" class="btn btn-warning" href="<?php echo $base_url;?>/${el.path}/${el.video_name}" download title="Click to download">
                                                Download
                                            </a>
                                            <a class="btn btn-danger" onclick="showModal(this)" data-videoid="${el.video_id}">
                                                Delete
                                            </a>                                            
                                        </td>
                                    </tr>
                                    `;
                                })
                            }

                            resolve(htmlTbody)
                        }else{
                            reject('an error ocurred')
                        }
                    })
                    xhr.send();
                })
                
            }

            function showModal(button){
                let id = button.dataset.videoid;
                let row = button.parentElement.parentElement;    

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    console.log(confirmed)
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/videos/api/deleteVideo.php"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#video-list-table").dataTable().fnDeleteRow(row)
                                $.notify('video deleted!', 'success')
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