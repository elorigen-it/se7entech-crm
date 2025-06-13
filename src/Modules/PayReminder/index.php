<?php
    require('../../config/config.php');
    require('../../config/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <?php include_once('../../layout/head.php');?>
    <style>
        .table-yellow {
            background-color: #FFF7B3 !important;
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
                            <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab"
                                href="#listcontracts" role="tab" aria-controls="tabs-menagment"
                                aria-selected="true"><i class="fa fa-paper-plane"></i>Grace Contracts</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab"
                                href="#cmenagment" role="tab" aria-controls="tabs-menagment"
                                aria-selected="true"><i class="fa fa-users mr-2"></i>Add Client</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-menagment-main" data-toggle="tab"
                                href="#addFormat" role="tab" aria-controls="tabs-menagment"
                                aria-selected="true"><i class="fa fa-plus"></i>Add Format</a>
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
                        <div class="tab-pane fade show active" id="listcontracts" role="tabpanel"
                            aria-labelledby="tabs-icons-text-1-tab">
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3 class="mb-0">Grace Contracts List</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow-x:hidden;">
                                    <table id="contract-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                        <thead style="background:#337ab7;color:white;"> 
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Customer Company</th>
                                                <th>Gracetime</th>
                                                <th>Domain</th>
                                                <th>Hosting</th>
                                                <th>Marketing</th>
                                                <th>Domain Setup Date</th>
                                                <th>Hosting Setup Date</th>
                                                <th>Marketing Setup Date</th>
                                                <th>Domain Time Remaining</th>
                                                <th>Hosting Time Remaining</th>
                                                <th>Marketing Time Remaining</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contract-list-tbody">
                                            <?php if(count($this->data['contract_grace'])):?>
                                                <?php foreach($this->data['contract_grace'] as $row):?>
                                                    <?php 
                                                        $gracetime = $row['grace_time'];

                                                        $serverDate = date("Y-m-d");
                                                        if($row['setup_date_domain'] == null) {
                                                            $domainRemainingDays = "Not Installed";
                                                        } else if($gracetime > -1) {
                                                            $dateCalc = date("Y-m-d", strtotime($row['setup_date_domain'] . " + " . $gracetime . " days"));
                                                            $timestampServer = strtotime($serverDate);
                                                            $timestampCalc = strtotime($dateCalc);

                                                            // Calcular la diferencia en segundos
                                                            $remainingSeconds = $timestampCalc -  $timestampServer;

                                                            // Calcular la diferencia en días
                                                            $domainRemainingDays = round($remainingSeconds / (60 * 60 * 24));
                                                        } else {
                                                            $domainRemainingDays = 'Unlimited';
                                                        }

                                                        if($row['setup_date_hosting'] == null) {
                                                            $hostingRemainingDays = "Not Installed";
                                                        } else if($gracetime > -1) {
                                                            $dateCalc = date("Y-m-d", strtotime($row['setup_date_hosting'] . " + " . $gracetime . " days"));
                                                            $timestampServer = strtotime($serverDate);
                                                            $timestampCalc = strtotime($dateCalc);

                                                            // Calcular la diferencia en segundos
                                                            $remainingSeconds = $timestampCalc -  $timestampServer;

                                                            // Calcular la diferencia en días
                                                            $hostingRemainingDays = round($remainingSeconds / (60 * 60 * 24));
                                                        } else {
                                                            $hostingRemainingDays = 'Unlimited';
                                                        }

                                                        if($row['setup_date_marketing'] == null) {
                                                            $marketingRemainingDays = "Not Installed";
                                                        } else if($gracetime > -1) {
                                                            $dateCalc = date("Y-m-d", strtotime($row['setup_date_marketing'] . " + " . $gracetime . " days"));
                                                            $timestampServer = strtotime($serverDate);
                                                            $timestampCalc = strtotime($dateCalc);

                                                            // Calcular la diferencia en segundos
                                                            $remainingSeconds = $timestampCalc -  $timestampServer;

                                                            // Calcular la diferencia en días
                                                            $marketingRemainingDays = round($remainingSeconds / (60 * 60 * 24));
                                                        } else {
                                                            $marketingRemainingDays = 'Unlimited';
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['contract_id'];?></td>
                                                        <td><?php echo $row['customer_name_1'];?></td>
                                                        <td><?php echo $row['company_name_1'];?></td>
                                                        <td>
                                                        <?php 
                                                            if($gracetime == 0) {
                                                                echo 'N/A';
                                                            } else if($gracetime == -1) {
                                                                echo 'Unlimited';
                                                            } else {
                                                                if($gracetime > 1) {
                                                                    echo $gracetime . " days"; 
                                                                } else {
                                                                    echo $gracetime . " day"; 
                                                                }
                                                            }
                                                        ?>
                                                        </td>    
                                                        <td><?php echo $row['domain'];?></td>
                                                        <td><?php echo $row['hosting'];?></td>
                                                        <td><?php echo $row['marketing'];?></td>
                                                        <td><?php echo $row['setup_date_domain'];?></td>
                                                        <td><?php echo $row['setup_date_hosting'];?></td>
                                                        <td><?php echo $row['setup_date_marketing'];?></td>
                                                        <td>
                                                        <?php
                                                        $remainingDays = $domainRemainingDays;
                                                        if($row['setup_date_domain'] == null) {
                                                            echo $remainingDays; // Si no tiene fecha de instalacion
                                                        } else if($gracetime > -1) {
                                                            if($remainingDays > 1) {
                                                                echo $remainingDays . " days"; 
                                                            } else {
                                                                echo $remainingDays . " day";
                                                            }
                                                        } else {
                                                            echo $remainingDays; // En caso de de sea Unlimited
                                                        }
                                                        ?>
                                                        </td>
                                                        <td>
                                                        <?php
                                                        $remainingDays = $hostingRemainingDays;
                                                        if($row['setup_date_hosting'] == null) {
                                                            echo $remainingDays; // Si no tiene fecha de instalacion
                                                        } else if($gracetime > -1) {
                                                            if($remainingDays > 1) {
                                                                echo $remainingDays . " days"; 
                                                            } else {
                                                                echo $remainingDays . " day";
                                                            }
                                                        } else {
                                                            echo $remainingDays; // En caso de de sea Unlimited
                                                        }
                                                        ?>
                                                        </td>
                                                        <td>
                                                        <?php
                                                        $remainingDays = $marketingRemainingDays;
                                                        if($row['setup_date_marketing'] == null) {
                                                            echo $remainingDays; // Si no tiene fecha de instalacion
                                                        } else if($gracetime > -1) {
                                                            if($remainingDays > 1) {
                                                                echo $remainingDays . " days"; 
                                                            } else {
                                                                echo $remainingDays . " day";
                                                            }
                                                        } else {
                                                            echo $remainingDays; // En caso de de sea Unlimited
                                                        }
                                                        ?>
                                                        </td>
                                                        <td>
                                                            <?php if($this->data['access'] === '0'):?>
                                                                <a href="<?php echo $base_url;?>/modules/payReminder/index.php/edit/<?php echo $row['contract_id'];?>" class="btn btn-primary">Edit</a>
                                                                <a href="#" data-id="<?php echo $row['contract_id'];?>" onclick="showModal(this)" class="btn btn-success">Installed</a>
                                                                <a href="<?php echo $base_url;?>/modules/payReminder/index.php/reminder/<?php echo $row['contract_id'];?>" class="btn btn-primary">Send Reminder</a>
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
                        <!-- Tab Apps -->
                        <!-- Tab Location -->
                        <div class="tab-pane fade" id="cmenagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                    <h3 class="mb-0">Client Management</h3>
                                    </div>
                                    <!--<div class="col-4 text-right">-->
                                    <!--   <a target="_blank" href="https://feeder.henkakoplus.in/restaurant/kundan"-->
                                    <!--      class="btn btn-sm btn-success">View it</a>-->
                                    <!--</div>-->
                                </div>
                                </div>
                                <div class="card-body">
                                <h6 class="heading-small text-muted mb-4">Add information</h6>
                                <div class="pl-lg-4">
                                    <form id="restorant-form" method="POST" autocomplete="off" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                        <div id="form-group-name" class="form-group  ">
                                            <label class="form-control-label" for="name">Client Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Client's Name" required>
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div id="form-group-name" class="form-group  ">
                                            <label class="form-control-label" for="name">Email Address</label>
                                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div id="form-group-name" class="form-group  ">
                                            <label class="form-control-label" for="name">Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div id="form-group-name" class="form-group  ">
                                            <label class="form-control-label" for="name">Address</label>
                                            <input type="text" name="address" class="form-control" placeholder="Address">
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div id="form-group-name" class="form-group  ">
                                            <label class="form-control-label" for="name">Business Name</label>
                                            <input type="text" name="businessname" class="form-control" placeholder="Business Name">
                                        </div>
                                        </div>
                                        <!--<div class="col-md-4">
                                        <div id="form-group-name" class="form-group  ">
                                            <label class="form-control-label" for="name">File(Multiple) <sup>Optional</sup>
                                            </label>
                                            <input type="file" accept=".pdf,.doc,.png,.jpg,.jpeg,.xls,.docs" name="image[]" class="form-control" multiple class="form-control" placeholder="Note">
                                        </div>
                                        </div>-->
                                        <div class="col-md-12">
                                        <div id="form-group-name" class="form-group">
                                            <label class="form-control-label" for="name">Note</label>
                                            <textarea style="height:200px" name="notes" class="form-control" placeholder="Note"></textarea>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="submit" name="save" style="background:blue;border:none;color:white;border-radius:2px" value="save">
                                    </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tab Add Format -->
                        <div class="tab-pane fade" id="addFormat" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                    <h3 class="mb-0">Add Format</h3>
                                    </div>
                                </div>
                                </div>
                                <div class="card-body">
                                <h6 class="heading-small text-muted mb-4">Add a format</h6>
                                <div class="pl-lg-4">
                                    <form id="format-form" method="POST" autocomplete="off" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                        <div id="form-group-name" class="form-group  ">
                                            <label class="form-control-label" for="name">Format Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Format name" required>
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div id="form-group-name" class="form-group">
                                                <label class="form-control-label" for="name">Upload DOCX</label>
                                                <input type="file" name="docxFile" class="form-control" placeholder="Upload DOCX" accept=".docx" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="submit" name="saveFormat" style="background:blue;border:none;color:white;border-radius:2px" value="saveFormat">
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
    </div>
    </div>
    <!-- Commented because navtabs includes same script -->
    <?php include '../../layout/footer_scripts.php';?>

<script>
    $(document).ready(function(){
        /*$('input[type="submit"]').on('click', function(e) {
            e.preventDefault();
            var formInputs = $(this).closest('form').serializeArray();
            console.log(formInputs);
            
        });*/

        /*$('input[type="submit"]').on('click', function(e) {
            e.preventDefault();
            var formInputs = $(this).closest('form').serializeArray();
            var formData = new FormData($(this).closest('form')[0]);

            // Log formData entries
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ', ' + pair[1]); 
            }

            // Get the file size
            var fileSize = formData.get('docxFile').size;
            console.log('File size: ' + fileSize + ' bytes');

            $.ajax({
                url: 'https://crm.se7entech.net/modules/payReminder/',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                }
            });
        });*/


        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            if(target === '#listcontracts'){
                $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust()
                .responsive.recalc(); 
            }
        });

        $('#contract-list-table').DataTable({
            responsive: true,
            "createdRow": function( row, data, dataIndex ) {
                var remainingDays = [];
                remainingDays.push($(row).find("td:eq(10)").text()); // Obtener el texto de la columna "Remaining Time"
                remainingDays.push($(row).find("td:eq(11)").text()); // Obtener el texto de la columna "Remaining Time"
                remainingDays.push($(row).find("td:eq(12)").text()); // Obtener el texto de la columna "Remaining Time"

                // Llamar a la función getRowColorClass para obtener la clase de color según los días restantes
                let colorClass = getRowColorClass(remainingDays);
                
                // Agregar la clase al atributo class de la fila
                $(row).addClass(colorClass);
            }
        });

        <?php 
        if (isset($_SESSION['flash']['success'])) {
            $message = $_SESSION['flash']['success'];
            if (!is_array($message)) {
                echo "alert('Success: ". $message . "');";
                unset($_SESSION['flash']['success']);
            } else {
                echo "alert('Success: ". json_encode($message) . "');";
                unset($_SESSION['flash']['success']);
            }
        }

        if (isset($_SESSION['flash']['danger'])) {
            $message = $_SESSION['flash']['danger'];
            if (!is_array($message)) {
                echo "alert('Danger: ". $message . "');";
                unset($_SESSION['flash']['danger']);
            } else {
                echo "alert('Danger: ". json_encode($message) . "');";
                unset($_SESSION['flash']['danger']);
            }
        }

        if (isset($_SESSION['flash']['last_data'])) {
            $message = $_SESSION['flash']['last_data'];
            if (!is_array($message)) {
                echo "alert('last data: ". $message . "');";
                unset($_SESSION['flash']['last_data']);
            } else {
                echo "alert('last data: ". json_encode($message) . "');";
                unset($_SESSION['flash']['last_data']);
            }
        }

        if (isset($_SESSION['flash']['warning'])) {
            $message = $_SESSION['flash']['warning'];
            if (!is_array($message)) {
                echo "alert('warning: ". $message . "');";
                unset($_SESSION['flash']['warning']);
            } else {
                echo "alert('warning: ". json_encode($message) . "');";
                unset($_SESSION['flash']['warning']);
            }
        }
        ?>
    });

    function showModal(button){
        let id = button.dataset.id;
        //let row = button.parentElement.parentElement;    

        bootbox.prompt({
            title: 'Select the options that have been installed:',
            inputType: 'checkbox',
            inputOptions: [
                {
                    text: 'Domain',
                    value: 'Domain'
                },
                {
                    text: 'Hosting',
                    value: 'Hosting'
                },
                {
                    text: 'Marketing',
                    value: 'Marketing'
                }
            ],
            callback: function (result) {
                if(result == null) {
                    return;
                }

                if (result && result.length > 0) {
                    let data = new FormData();
                    data.set('id', id);
                    data.set('selectedOptions', result.join(',')); // Concatena las opciones seleccionadas en una cadena separada por comas
                    if (result.includes('Domain')) {
                        bootbox.prompt({
                            title: '¿Cuál es el dominio?',
                            callback: function (domain) {
                                if(domain == null) {
                                    return;
                                }

                                if (domain) {
                                    data.set('domain', domain);
                                    //console.log('Información adicional ingresada:', domain);
                                    sendToEndpoint(data);
                                } else {
                                    console.log('No se proporcionó información adicional.');
                                    bootbox.alert({
                                        title: 'Error:',
                                        message: 'If you select “domain” you must enter the domain name',
                                        backdrop: true,
                                        callback: function () {
                                            showModal(button);
                                        }
                                    });
                                }
                            }
                        });
                    } else {
                        sendToEndpoint(data);
                    }
                    //console.log(data);
                } else {
                    console.log('El usuario debe seleccionar al menos una opción.');
                    bootbox.alert({
                        title: 'Error:',
                        message: 'You must choose at least one option',
                        backdrop: true,
                        callback: function () {
                            showModal(button);
                        }
                    });             
                }
                
            }
        });

        function sendToEndpoint(data) {
            let endpoint = "<?php echo $base_url;?>/modules/payReminder/index.php/installed/";
            let xhr = new XMLHttpRequest();
            xhr.open('POST', endpoint, true);
            xhr.addEventListener('load', (e) => {
                console.log(e.target.response);
                let res = JSON.parse(e.target.response);
                if (res.success) {
                    console.log(e.target.response);
                    $.notify('installed', 'success');
                    //location.reload();
                }
            });
            xhr.send(data);
        }
    }

    function getRowColorClass(remainingDays) {
        let response = [];
        if(Array.isArray(remainingDays)) {
            remainingDays.forEach(day => {
                let numericDays = day.match(/-?\d+/); // This will match negative numbers as well
                numericDays = parseInt(numericDays);

                if(day === 'Not Installed' || day === 'Unlimited') {
                    response.push('');
                } else if (numericDays <= 10) {
                    response.push('table-danger'); // Red for less than 10 days remaining
                } else if (numericDays <= 30) {
                    response.push('table-yellow'); // Yellow for less than 30 days remaining
                } else if (numericDays < 0) {
                    response.push('table-danger'); // Red for negative days (expired)
                } else {
                    response.push('');
                }
            });

            let colorClass = response.find(table_class => {
                return table_class === 'table-danger' || table_class === 'table-yellow';
            });

            if (!colorClass) {
                colorClass = '';
            }

            return colorClass;
        }

        /*if (remainingDays === 'Not Installed' || remainingDays === 'Unlimited') {
            return '';
        } else if (numericDays <= 10) {
            return 'table-danger'; // Rojo para menos de 10 días restantes
        } else if (numericDays <= 30) {
            return 'table-yellow'; // Amarillo para menos de 30 días restantes
        } else {
            return '';
        }*/
    }


</script>
</body>

</html>