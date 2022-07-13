<?php  $this->load->view("admin/common/head"); ?>
<style type="text/css">
    .ui-datepicker-trigger{
        height: 25px !important;
        width: 25px !important
    }
    #ui-datepicker-div{
        background-color: #fff;
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
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("ADD COUPON");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <?php echo form_error('coupon_title'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="coupon_title" class="form-control" placeholder="<?php echo $this->lang->line("Name of The Coupon");?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('coupon_code'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Coupon Code");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="coupon_code" class="form-control" placeholder="<?php echo $this->lang->line("Coupon Code");?>" />
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
                                                            <input type='text' id='txtDate' name="from" class="form-control datetimepicker" " readonly="">
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
                                                            <input type='text' id="txtDate2" name="to" class="form-control datepicker" readonly="">
                                                        <span class="material-input"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('value'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Value");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="value" placeholder="00.00" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('cart_value'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Cart Value");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="cart_value"  placeholder="00" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('restriction'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Uses Resriction");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="restriction" placeholder="00.00" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" name="addcatg" value="<?php echo $this->lang->line("ADD COUPON");?>" class="btn btn-fill btn-rose" />
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