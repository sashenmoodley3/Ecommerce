<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php 
if($this->session->userdata('language') == "arabic")
{
    ?>
    <div class="col-md-3">
    </div>
<?php
}
?>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">home</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo  $this->lang->line("Pincode");?></h4>
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="row">
                                            <label class="col-md-4 label-on-right">Select Delivery Days: </label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select multiple="" id="days" name="days[]" class="form-control">
                                                    <?php 
                                                        $days_Arr       = explode(', ', $pincode->delivery_days);
                                                        $days_arrList   = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"); 
                                                        for($i = 0; $i <= count($days_arrList); $i++) {
                                                            if(in_array($days_arrList[$i], $days_Arr)){
                                                                echo '<option value="'.$days_arrList[$i].'" selected>'.$days_arrList[$i].'</option>';
                                                            }
                                                            else{
                                                                 echo '<option value="'.$days_arrList[$i].'">'.$days_arrList[$i].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
<!--
                                        <div class="row">
                                            <label class="col-md-4 label-on-right"><?php echo $this->lang->line("Socity Name :");?>: </label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="socity_name" class="form-control" value="<?php echo $socity->socity_name; ?>">
                                                </div>
                                            </div>
                                        </div>
-->
                                        <div class="row">
                                            <label class="col-md-4 label-on-right"><?php echo $this->lang->line("Pincode / Area code :");?> : </label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="pincode" class="form-control" value="<?php echo $pincode->pincode; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 label-on-right"><?php echo $this->lang->line("Delivery Charge");?>: </label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="number" name="delivery" class="form-control" value="<?php echo $pincode->delivery_charge; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 label-on-right"><?php echo $this->lang->line("Free Delivery Charge Amount");?>: </label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="number" name="free_delivery_amount" class="form-control" value="<?php echo $pincode->free_delivery_amount; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4"></label>
                                            <div class="col-md-8">
                                                <div class="form-group form-button">
                                                    <button type="submit" class="btn btn-fill btn-rose" name="addcatg" value="Update Society"><?php echo $this->lang->line("Update Detail");?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
</html>