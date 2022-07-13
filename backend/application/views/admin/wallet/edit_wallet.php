<?php  $this->load->view("admin/common/head"); ?>
<style type="text/css">
        .ui-datepicker-trigger{
            height: 25px !important;
            width: 25px !important
        }
        #ui-datepicker-div{
            background-color: #fff;
            padding:20px;
        }
        a.ui-datepicker-next.ui-corner-all {
            float: right;
        }
        .ui-datepicker-title
        {
            text-align:center;
        }
        th {
            text-align: center;
            padding:4px;
        }
        .ui-datepicker-next::after {
          content: " >>";
        }
        .ui-datepicker-prev::before {
          content: " <<";
        }
</style>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('message'); 
                    ?>
                    <div class="row">
                        <form form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
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
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("ADD COUPON");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <?php echo form_error('coupon_title'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Name of The Coupon");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="coupon_title" class="form-control" value="<?= $coupon['coupon_name']; ?>" placeholder="coupon_title" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('coupon_code'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Coupon Code");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="coupon_code" class="form-control" value="<?= $coupon['coupon_code']; ?>" placeholder="couponcode" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Validity");?> : *</label>
                                            <div class="col-md-4">
                                                <?php echo form_error('from'); ?>
                                                <div class="card">
                                                    <div class="card-header card-header-icon" data-background-color="rose">
                                                        <i class="material-icons">today</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Date From");?></h4>
                                                        <div class="form-group">
                                                            <label class="label-control"></label>
                                                            <input type='text' id='txtDate' name="from" class="form-control datetimepicker" " value="<?= $coupon['valid_from']; ?>" readonly="">
                                                        <span class="material-input"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php echo form_error('to'); ?>
                                                <div class="card">
                                                    <div class="card-header card-header-icon" data-background-color="rose">
                                                        <i class="material-icons">library_books</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Date To");?></h4>
                                                        <div class="form-group">
                                                            <label class="label-control"></label>
                                                            <input type='text' id="txtDate2" name="to" class="form-control datepicker" value="<?= $coupon['valid_to']; ?>" readonly="">
                                                        <span class="material-input"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
                                            <?php echo form_error('discount_type'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("discount_type");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select style="width: 150px;
    height: 25px;"; id="discount_type" name="discount_type">
													  <option <?php if($coupon['discount_type'] == '%'){echo 'selected';}?> value="%">%</option>
													  <option <?php if($coupon['discount_type'] == 'Rs'){echo 'selected';}?> value="Rs">Rs</option>
													  
													</select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('value'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Value");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="discount_value" value="<?= $coupon['discount_value'];?>" placeholder="00.00" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
										
                                        <div class="row">
                                            <?php echo form_error('cart_value'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Cart Value");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="cart_value" value="<?= $coupon['minimum_cart_amt'];?>"  placeholder="00" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('restriction'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Uses Resriction");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="uses_restriction" value="<?= $coupon['uses_restriction'];?>" placeholder="00.00" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
										<div class="row">
                                            <?php echo form_error('max_limit'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("max_limit");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="max_limit"
													value="<?= $coupon['max_limit'];?>"placeholder="" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
										<div class="row">
                                            <?php echo form_error('coupon_description'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("coupon_description");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="coupon_description" value="<?= $coupon['coupon_description'];?>" placeholder="description" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <?php echo form_error('coupon_status'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("coupon_status");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select style="width: 150px;
    height: 25px;" id="coupon_status" name="coupon_status">
													  <option <?php if($coupon['coupon_status'] == 1){echo 'selected';}?> value="1">Active</option>
													  <option <?php if($coupon['coupon_status'] == 2){echo 'selected';}?> value="2">Block</option>
													  
													</select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit"name="addcatg" value="<?php echo $this->lang->line("Update Coupon");?>" class="btn btn-fill btn-rose" />
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->
<script src="<?php echo base_url($this->config->item('new_theme')); ?>/ckeditor/ckeditor.js" type="text/javascript"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
     
        <script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                ckeditor.replace('editor1');
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });

    $(document).ready(function() {

    $("#txtDate").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});

    $(document).ready(function() {

    $("#txtDate2").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});
</script>
</html>