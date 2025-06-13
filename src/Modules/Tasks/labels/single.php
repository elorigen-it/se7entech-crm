<?php
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
    <body>
        <?php include ('../../sidebar.php'); ?>
        <div class="main-content">
            <?php include ('../../nav.php'); ?>
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-menagment-main" data-toggle="tab" href="#editlabel" role="tab" aria-controls="tabs-menagment" aria-selected="true">
                                    <i class="fa fa-tag mr-2"></i>Editing Label <?php echo $this->data['current']['name'];?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <br />
                        <div class="tab-content" id="tabs">
                            <div class="tab-pane fade show active" id="editlabel" role="tabpanel">
                                <div class="card bg-secondary shadow">
                                    <div class="card-header bg-white border-0">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="mb-0">Label Management</h3>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <?php if(count($this->data['session'])):?>
                                                    <?php foreach ($this->data['session'] as $msg) echo $msg;?>
                                                <?php endif;?>
                                            </div>
                                            <div>
                                                <?php if(isset($this->data['errors']) && count($this->data['errors'])):?>
                                                    <div class="alert alert-danger p-2" role="alert">
                                                        <?php foreach ($this->data['errors'] as $error) echo $error . '<br />';?>
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="heading-small text-muted mb-4">Edit Label</h6>
                                        <div class="pl-lg-4">
                                            <form id="postlabel" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="label-name">Label Name <span class="required">*</span></label>
                                                            <input value="<?php echo $this->data['current']['name'];?>" type="text" id="label-name" name="label-name" placeholder="Example: Urgent" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="background-color">Background Color <span class="required">*</span></label>
                                                            <input value="<?php echo $this->data['current']['background_color'];?>" type="color" id="label-background-color" name="label-background-color" class="form-control" style="height: 38px; width: 60px; padding: 2px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="text-color">Text Color <span class="required">*</span></label>
                                                            <input value="<?php echo $this->data['current']['text_color'];?>" type="color" id="label-text-color" name="label-text-color" class="form-control" style="height: 38px; width: 60px; padding: 2px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                            <!-- create a preview of the label -->
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="label-preview">Label Preview</label>
                                                            <br>
                                                            <div id="label-preview" style="padding: 10px; text-align:center; width:auto; display:inline; min-width: 100px; background-color: <?php echo $this->data['current']['background_color'];?>; color: <?php echo $this->data['current']['text_color'];?>; border-radius: 4px;">
                                                                <?php echo htmlspecialchars($this->data['current']['name']);?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" name="save" value="1" class="btn btn-success">Update Label</button>
                                                    <a href="/modules/tasks/index.php/labels#listlabels" class="btn btn-primary">Label list</a>
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
        <?php include '../../layout/footer_scripts.php';?>
        <script>
            $(document).ready(function(){
                //create the logic for the label preview
                $('#label-name, #label-background-color, #label-text-color').on('input', function() {
                    let name = $('#label-name').val() || 'Label Name';
                    let backgroundColor = $('#label-background-color').val() || '#337ab7';
                    let textColor = $('#label-text-color').val() || '#ffffff';

                    $('#label-preview').text(name);
                    $('#label-preview').css('background-color', backgroundColor);
                    $('#label-preview').css('color', textColor);
                });
            })
        </script>
    </body>
</html>
