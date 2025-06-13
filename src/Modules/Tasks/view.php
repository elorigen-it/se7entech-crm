<?php
    namespace Se7entech\Contractnew\Modules\Tasks;

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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Viewing Task <?php echo $this->data['current']['name'];?></a>
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
                                    <h6 class="heading-small text-muted mb-4">View task information</h6>
                                    <div class="pl-lg-4">       
                                        <form id="postzone" method="POST">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-labels">Task Labels</label>
                                                        <br>
                                                        <?php
                                                            if (!empty($this->data['labels'])){
                                                                // Get selected label ids as array
                                                                $selectedLabels = array_map('trim', explode(',', $this->data['current']['labels'] ?? ''));
                                                                foreach ($this->data['labels'] as $label){
                                                                    $selected = in_array($label['id'], $selectedLabels) ? true : false;
                                                                    if(!$selected) continue; // Skip if label is not selected
                                                                    ?>
                                                                    <span style="background-color: <?php echo htmlspecialchars($label['background_color'] ?? '#ccc'); ?>; color: <?php echo htmlspecialchars($label['text_color'] ?? '#ccc'); ?>; padding: 2px 8px; border-radius: 12px; font-size: 90%;">
                                                                        <?php echo htmlspecialchars($label['name']); ?>
                                                                    </span>
                                                                <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group  ">
                                                        <label class="form-control-label" for="customer-id">Customer </label>
                                                        <br>
                                                        <span class="text-muted"><?php echo $this->data['current']['customer_name'] . ' - ' . $this->data['current']['customer_business_name'] ;?></span><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="customer-tempname">Customer Name</label>
                                                        <br>
                                                        <span class="text-muted"><?php echo $this->data['current']['customer_tempname'];?></span><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group  ">
                                                        <label class="form-control-label" for="task-name">Task Name</label>
                                                        <br>
                                                        <span class="text-muted"><?php echo $this->data['current']['name'];?></span><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group  ">
                                                        <label class="form-control-label" for="customer-id">Description </label>
                                                        <br>
                                                        <div class="task-description-wrapper" style="border:1px solid #c0c0c0; padding:.4em; max-height: 250px; overflow-y: auto;">
                                                            <?php echo $this->data['current']['description'];?><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-user">Asigned to</label>
                                                        <br>
                                                        <span class="text-muted"><?php echo $this->data['current']['first_name'] . ' ' . $this->data['current']['last_name'] . '<br> &lt;' . $this->data['current']['email'] . '&gt;';?></span><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-user">Status</label>
                                                        <br>
                                                        <?php 
                                                            if($this->data['current']['status'] == 'created'){
                                                                $status = '<span class="badge badge-info">Created</span>';
                                                            }else if($this->data['current']['status'] == 'started'){
                                                                $status = '<span class="badge badge-warning">Started</span>';
                                                            }else if($this->data['current']['status'] == 'finished'){
                                                                $status = '<span class="badge badge-success">Finished</span>';
                                                            }else if($this->data['current']['status'] == 'paused'){
                                                                $status = '<span class="badge badge-danger">Paused</span>';
                                                            }
                                                        ?>
                                                        <span class="text-muted"><?php echo $status; ?></span><br>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-user">Created time</label>
                                                        <br>
                                                        <?php
                                                            // echo var_dump($this->data['current']['start_time']);
                                                            // exit;
                                                            $created_time = new \DateTime($this->data['current']['created_at']);              
                                                            $created_time = $created_time->format('Y-m-d H:i:s');
                                                            
                                                        ?>
                                                        <span class="text-muted"><?php echo $created_time;?></span><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-user">Started time</label>
                                                        <br>
                                                        <?php
                                                            // echo var_dump($this->data['current']['start_time']);
                                                            // exit;
                                                            if($this->data['current']['start_time']){                
                                                                $start_time = new \DateTime('@' . $this->data['current']['start_time']);
                                                                $start_time = $start_time->format('Y-m-d H:i:s');
                                                            }else{
                                                                $start_time = 'Not started yet';
                                                            }
                                                        ?>
                                                        <span class="text-muted"><?php echo $start_time;?></span><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="task-user">Ended time</label>
                                                        <br>
                                                        <?php
                                                            if($this->data['current']['end_time']){
                                                                $end_time = new \DateTime('@' . $this->data['current']['end_time']);
                                                                $end_time = $end_time->format('Y-m-d H:i:s');
                                                            }else{
                                                                $end_time = 'Not ended yet';
                                                            }
                                                        ?>
                                                        <span class="text-muted"><?php echo $end_time;?></span><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($this->session->get('access') == '0'):?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php 
                                                                $totalPaused = $this->data['current']['total_pauses'];
                                                            
                                                                if($totalPaused ){
                                                                    $hours = floor($totalPaused / 3600);
                                                                    $minutes = floor(($totalPaused % 3600) / 60);
                                                                    $seconds = $totalPaused % 60;

                                                                    $totalPaused = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                                                                }else{
                                                                    $totalPaused = 'No pauses yet';
                                                                }
                                                            ?>
                                                            <label class="form-control-label" for="task-user">Paused time</label>
                                                            <br>
                                                            <span class="text-muted"><?php echo $totalPaused;?></span><br>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php 
                                                                if($this->data['current']['end_time'] && $this->data['current']['start_time']){
                                                                    $start_time = new \DateTime('@' . $this->data['current']['start_time']);
                                                                    $end_time = new \DateTime('@' . $this->data['current']['end_time']);
                                                                    
                                                                    // 2. Calcular el tiempo total (en segundos)
                                                                    $total_seconds = $end_time->getTimestamp() - $start_time->getTimestamp();
                                                                    
                                                                    // 3. Obtener y procesar los intervalos de pausa (ejemplo: "1641000000,1641003600,1641010000,1641012000")
                                                                    $paused_intervals = explode(',', $this->data['current']['pause_intervals']);
                                                                    
                                                                    // Si es impar, eliminamos el último timestamp (pausa no finalizada)
                                                                    if (count($paused_intervals) % 2 !== 0) {
                                                                        array_pop($paused_intervals); // Elimina el último elemento
                                                                    }

                                                                    // 4. Calcular el tiempo total pausado
                                                                    $total_paused = 0;
                                                                    for ($i = 0; $i < count($paused_intervals); $i += 2) {
                                                                        if (isset($paused_intervals[$i+1])) {
                                                                            $total_paused += ($paused_intervals[$i+1] - $paused_intervals[$i]);
                                                                        }
                                                                    }
                                                                    
                                                                    // 5. Calcular el tiempo neto (total - pausas)
                                                                    $net_seconds = $total_seconds - $total_paused;

                                                                    $hours = floor($net_seconds / 3600);
                                                                    $minutes = floor(($net_seconds % 3600) / 60);
                                                                    $seconds = $net_seconds % 60;
                                                                    $net_time = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

                                                                }else{
                                                                    $net_time = 'Not finished yet';
                                                                }
                                                                

                                                            ?>
                                                            <label class="form-control-label" for="task-user">Total time</label>
                                                            <br>
                                                            <span class="text-muted"><?php echo $net_time;?></span><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="task-user">Pause reasons</label>
                                                            <br>
                                                            <?php 
                                                                if ($this->data['current']['pause_intervals'] && $this->data['current']['pause_reasons']) {
                                                                    $pause_intervals = explode(',', $this->data['current']['pause_intervals']);
                                                                    $pause_reasons = explode('|||', $this->data['current']['pause_reasons']);
                                                                    $formatted_reasons = [];

                                                                    for ($i = 0; $i < count($pause_intervals); $i += 2) {
                                                                        if (isset($pause_intervals[$i]) && isset($pause_reasons[$i / 2])) {
                                                                            $pause_time = new \DateTime('@' . $pause_intervals[$i]);
                                                                            $formatted_reasons[] = $pause_time->format('Y-m-d H:i:s') . ' - ' . $pause_reasons[$i / 2];
                                                                        }
                                                                    }                                                                  

                                                                    $pause_reasons = implode('<br>', $formatted_reasons);
                                                                } else {
                                                                    $pause_reasons = 'No pauses yet';
                                                                }
                                                            ?>
                                                            <span class="text-muted"><?php echo $pause_reasons;?></span><br>                                                
                                                        </div> 
                                                    </div>
                                                </div>
                                            <?php endif;?>

                                            <div class="text-center">
                                                <a href="<?php echo $this->base_url;?>/modules/tasks/#listzones" class="btn btn-primary">Back to Task List</a>
                                                <?php if($this->data['current']['status'] == 'created'):?>
                                                    <a href="<?php echo $this->base_url;?>/modules/tasks/index.php/<?php echo $this->data['current']['id'];?>/start" class="btn btn-primary">Start task</a>
                                                <?php endif;?>
                                                <?php if($this->data['current']['status'] == 'started'):?>
                                                    <a id="pause-task" href="<?php echo $this->base_url;?>/modules/tasks/index.php/<?php echo $this->data['current']['id'];?>/pause" class="btn btn-warning">Pause task</a>
                                                <?php endif;?>
                                                <?php if($this->data['current']['status'] == 'paused'):?>
                                                    <a href="<?php echo $this->base_url;?>/modules/tasks/index.php/<?php echo $this->data['current']['id'];?>/resume" class="btn btn-primary">Resume task</a>
                                                <?php endif;?>
                                                <?php if($this->data['current']['status'] == 'started'):?>
                                                    <a href="<?php echo $this->base_url;?>/modules/tasks/index.php/<?php echo $this->data['current']['id'];?>/finish"class="btn btn-success">Finish task</a>
                                                <?php endif;?>
                                                <?php if($this->data['current']['status'] == 'finished'):?>
                                                    <a href="<?php echo $this->base_url;?>/modules/tasks/index.php/<?php echo $this->data['current']['id'];?>/reopen"class="btn btn-warning">Reopen task</a>
                                                <?php endif;?>
                                                <?php if($this->session->get('access') == '0'):?>
                                                    <a href="<?php echo $this->base_url;?>/modules/tasks/index.php/<?php echo $this->data['current']['id'];?>"class="btn btn-primary">Edit task</a>
                                                <?php endif;?>
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
        <script>
            window.addEventListener('load', function() {
                let pauseButton = document.getElementById('pause-task');
                pauseButton.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default action of the link
                    // Show the prompt
                    bootbox.prompt({
                        title: "Please enter a reason for pausing the task",
                        inputType: 'textarea',
                        callback: function(result) {
                            if (result !== null) {
                                console.log(result); // Log the result to the console (for debugging purposes)
                                // If the user entered a value, redirect to the URL with the reason as a query parameter
                                window.location.href = pauseButton.href + '/' + encodeURIComponent(result);
                            }
                        }
                    });
                });
            });
           
        </script>
    </body>
</html>