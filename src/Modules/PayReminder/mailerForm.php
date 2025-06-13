<?php
    namespace Se7entech\Contractnew\Modules\PayReminder;

    require('../../config/config.php');
    require('../../config/connection.php');

/*use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
    $validate = new hasFilledRequirementForm();
    $validate->handle(0);
if(isset($_POST['save']))
{
    $cemail=$_POST["cemail"];
    $email=$_POST["email"];
    $message=$_POST["message"];
    $subject =$_POST['subject'];
    $format_id = $_POST['format'];
    
    $html_query = "SELECT html FROM pay_reminder_format WHERE id = $format_id";
        $html_result = mysqli_query($con, $html_query);
        $html_row = mysqli_fetch_assoc($html_result);
        $html_message = $html_row['html'];
    
    $res=mysqli_query($con,"select * from payment where email='$cemail'");
    $row=mysqli_fetch_assoc($res);
    $name =$row['name'];
           
    $email_subject = $subject;
    
    $message = $html_message;
    
    //$to = $cemail;
    
    $to = 'samuel_mantilla10@hotmail.com';
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Payment Reminder <admin@se7entech.net>' . "\r\n" .
        'Reply-To: Payment Reminder <admin@se7entech.net>' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    
    if (mail($to, $email_subject, $message, $headers)) {
        echo '<script>alert("Sent");</script>';
    } else {
        echo '<script>alert("Try again");</script>';
    }
}*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('../../layout/head.php');?>
    <title>Se7entech Corporation - Reminder</title>
    <script>
        var formats = <?php echo json_encode($this->data['formats']); ?>;
    </script>
    <style>
        .se7entech-input, .se7entech-input-number{
            height: 28px;
            padding: 3px;
            border: 1px solid transparent;
            margin:3px .5em;
            border-bottom-color: black;
            outline:none;
            width: 250px;
            background:transparent;
        }
        .se7entech-input-number{
            width:50px;
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
                            <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-paper-plane"></i> Send Reminder</a>
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
                        <div class="tab-pane fade show active" id="menagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3 class="mb-0">Payment Management</h3>
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

                                        <form id="reminder-form" method="POST" autocomplete="off" enctype="multipart/form-data">
                                            <div class="col-md-4">
                                                <div id="form-group-name" class="form-group">
                                                    <label class="form-control-label" for="name">Select Client</label>
                                                    <select name="cemail" class="form-control" id="client-select" placeholder="---Select Client---" required>
                                                        <option disabled selected>---Select Client---</option>
                                                        <?php
                                                        if (!empty($this->data['clients'])) {
                                                            foreach ($this->data['clients'] as $client) {
                                                        ?>
                                                        <option value="<?php echo $client['email']; ?>" data-name="<?php echo $client['name']; ?>"><?php echo $client['name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                    ?>
                                                    </select>

                                                    <label class="form-control-label" for="format">Select Format</label>
                                                    <select name="format" class="form-control" id="format-select" placeholder="---Select Format---" required>
                                                        <option disabled selected>---Select Format---</option>
                                                        <?php
                                                        if (!empty($this->data['formats'])) {
                                                            foreach ($this->data['formats'] as $format) {
                                                        ?>
                                                        <option value="<?php echo $format['id']; ?>"><?php echo $format['name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                    <input type="hidden" name="clientName" id="client-name">
                                                </div>
                                            </div>

                                            <!--<div class="col-md-4">
                                                <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="name">From</label>
                                                    <input   type="text" name="email"  class="form-control"  value="info@se7entech.net"  required >
                                                </div>
                                            </div>-->

                                            <div class="col-md-4">
                                                <div id="form-group-name" class="form-group">
                                                    <label class="form-control-label" for="name">Subject</label>
                                                    <input type="text" id="subject" name="subject" class="form-control" required>
                                                </div>
                                            </div>

                                            <!--<div class="col-md-4">
                                                <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="name">Pay For</label>
                                                    <input   type="text" name="payfor"  class="form-control" required >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="name">Amount</label>
                                                    <input   type="text" name="amount"  class="form-control" required >
                                                </div>
                                            </div> -->

                                            <div id="format-div"></div>   

                                            <div class="text-center">
                                                <input type="submit" name="save" style="background:blue;border:none;color:white;border-radius:2px" value="Send">
                                            </div>


                                        </form>
                                        <!--<div style="visibility: hidden;display: none;">
                                        <select   class=" " placeholder="Client's Email" >
                                            <option>---Select Client---</option>
                                        </select>
                                    </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        /*$flash = $this->session->getFlashBag();
        var_dump($flash);*/
        ?>
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
        </footer>
    </div>
    </div>
    </div>
    <?php include '../../layout/footer_scripts.php';?>
    <script src="<?php echo $base_url;?>/editor/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#client-select').change(function() {
                var selectElement = this;
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var clientName = selectedOption.getAttribute('data-name');
                $('#client-name').val(clientName);
            });

            /*$('#format-select').change(function() {
                var selectedValue = $(this).val();
                
                //$('#mi-div').text('Seleccionaste: ' + selectedValue);


            });*/

            $('#subject').change(function() {
                var selectedFormat = formats.find(format => format.id === $('#format-select').val());
                if (!(selectedFormat)) {
                    console.log("No format found for the selected value");
                }

                var selectedValue = $(this).val();
                let htmlLegend = '<legend><center><img style="height:50px;width:150px" src="https://se7entech.net/images/logo.png"><h1 style="color:#000080;"><b>' + selectedValue + '<br><U>SE7ENTECH CORPORATION</u></b></h1><BR><P>460 Irving park rd Suite C123, Bensenville, IL 60106<br>(773)-666-2021</P></center><div id="google_translate_element"></div></legend>'

                let html = htmlLegend + selectedFormat['html'];

                document.getElementById('format-div').innerHTML = html;

                let esinputDivs = document.querySelectorAll('.esinput');
                // Loop through each div
                esinputDivs.forEach((span) => {
                // Create input element
                    const input = document.createElement('input');

                    // Set input attributes from div attributes
                    input.type = span.getAttribute('type');
                    input.name = span.getAttribute('name');
                    input.code = span.getAttribute('code');
                    input.placeholder = span.getAttribute('placeholder');

                    let inputInline = span.getAttribute('inline') !== null;

                    if (inputInline) {
                        input.classList.add("no-outline")
                    }

                    input.classList.add("se7entech-input")

                    // Replace div with input
                    span.replaceWith(input);
                    //div.parentNode.replaceChild(input, div);
                });
            });
        });

        <?php
        //if()
        ?>
    </script>
</body>

</html>