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
            .evo-calendar{
                padding-bottom:2em !important
            }
            .evoCalendarDescriptionRow{
                border-bottom: 1px solid grey;
            }
            .royal-navy .calendar-sidebar>span#sidebarToggler{
                padding-top:3px !important;
                background-color:#5e72e4 !important;
                box-shadow: none !important;
            }
            .royal-navy #eventListToggler{
                background-color:#5e72e4 !important;
                box-shadow: none !important;
            }
            @media screen and (max-width: 425px){
                .calendar-events {
                    height:400px;
                }
            }
            .calendar-events{
                width:370px;
            }
            .calendar-inner{
                max-width: calc(100% - 570px);
            }
        </style>
        <link rel="stylesheet" href="<?php echo $base_url;?>/css/evo-calendar.min.css">
        <link rel="stylesheet" href="<?php echo $base_url;?>/css/evo-calendar.royal-navy.min.css">
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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#calendar" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Calendar</a>
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
                            <div class="tab-pane fade show active" id="calendar" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                                <div class="card bg-secondary shadow">
                                    <div class="card-header bg-white border-0">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <!-- <h3 class="mb-0">Calendar</h3> -->
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
                                        <h6 class="heading-small text-muted mb-4">Here you can see all agents appointments under your same territory</h6>
                                       
                                        <div class="--noshadow" id="demoEvoCalendar"></div>
                                             
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
        <script src="<?php echo $base_url;?>/js/evo-calendar.min.js"></script>
        <script>
            
            var today = new Date();
            var events = [];
            // var events = [ {
            //     id: "imwyx6S",
            //     name: "Event #3",
            //     description: "Lorem ipsum dolor sit amet.",
            //     date: today.getMonth() + 1 + "/18/" + today.getFullYear(),
            //     type: "event"
            // }, {
            //     id: "9jU6g6f",
            //     name: "Holiday #1",
            //     description: "Lorem ipsum dolor sit amet.",
            //     date: today.getMonth() + 1 + "/10/" + today.getFullYear(),
            //     type: "holiday"
            // }, {
            //     id: "0g5G6ja",
            //     name: "Event #1",
            //     description: "Lorem ipsum dolor sit amet.",
            //     date: [ today.getMonth() + 1 + "/2/" + today.getFullYear(), today.getMonth() + 1 + "/5/" + today.getFullYear() ],
            //     type: "event",
            //     everyYear: !0
            // }, {
            //     id: "y2u7UaF",
            //     name: "Holiday #3",
            //     description: "Lorem ipsum dolor sit amet.",
            //     date: today.getMonth() + 1 + "/23/" + today.getFullYear(),
            //     type: "holiday"
            // }, {
            //     id: "dsu7HUc",
            //     name: "Birthday #1",
            //     description: "Lorem ipsum dolor sit amet.",
            //     date: new Date(),
            //     type: "birthday"
            // }, {
            //     id: "dsu7HUc",
            //     name: "Birthday #2",
            //     description: "Lorem ipsum dolor sit amet.",
            //     date: today.getMonth() + 1 + "/27/" + today.getFullYear(),
            //     type: "birthday"
            // } ];

            // var active_events = [];

            // var week_date = [];

            // var curAdd, curRmv;

            $(document).ready(function(){
                $.ajax({
                    method: 'POST',
                    url: "<?php echo $base_url;?>/modules/calendar/index.php/getAllAppointments/",
                    success: (res) => {
                        let data = JSON.parse(res);
                        if(data.length){
                            data.forEach((el) => {
                                events.push({
                                    id: el.id,
                                    name: el.customer.business_name,
                                    description: `
                                        <p class="evoCalendarDescriptionRow">
                                            <b>Subject</b>: ${el.subject} ${el.agent.last_name}
                                        </p>
                                        <p class="evoCalendarDescriptionRow">
                                            <b>Agent</b>: ${el.agent.first_name} ${el.agent.last_name}
                                        </p>
                                        <p class="evoCalendarDescriptionRow">
                                            <b>Message sent</b>: ${el.message}
                                        </p>
                                        <p class="evoCalendarDescriptionRow">
                                            <b>Notes</b>:${el.notes}
                                        </p>
                                        <p class="evoCalendarDescriptionRow">
                                            <b>Starting Hour</b>:${el.date_start_visible.split(' ')[1]}
                                        </p>
                                        <p class="evoCalendarDescriptionRow">
                                            <b>Ending Hour</b>:${el.date_end_visible.split(' ')[1]}
                                        </p>

                                    `,
                                    date: el.date_start,
                                    type: 'Appointment',
                                    badge: el.status,
                                    data: el
                                })
                            })
                        }
                        $("#demoEvoCalendar").evoCalendar({
                            theme: 'Royal Navy',
                            format: "MM dd, yyyy",
                            titleFormat: "MM",
                            calendarEvents: events
                        });

                        // selectEvent
                        $('#demoEvoCalendar').on('selectEvent', function(event, activeEvent) {
                            window.open("<?php echo $base_url;?>/modules/appointments/index.php/"+activeEvent.id)
                            // window.history.push("<?php echo $base_url;?>/modules/appointments/index.php/edit/"+activeEvent.id)
                        });


                    }
                })
                
            });

            function showModal(button){
                let id = button.dataset.id;
                let row = button.parentElement.parentElement;    

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    console.log(confirmed)
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/roles/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#roles-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Role deleted!', 'success')
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