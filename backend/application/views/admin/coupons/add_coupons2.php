<?php  $this->load->view("admin/common/head"); ?>
<link href="<?php echo base_url($this->config->item('new_theme')); ?>/assets/css/select2.min.css" rel="stylesheet" />
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("ADD COUPON");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <?php echo form_error('coupon_title'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("coupon_title");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="coupon_title" class="form-control" placeholder="<?php echo $this->lang->line("Name of The Coupon");?>" />
                                                    <input type="hidden" name="addcatg" class="form-control" placeholder="" value="addcatg" />
                                                    
                                                    
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('coupon_code'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("couponcode");?>: *</label>
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
                                                            <input type='text' id='txtDate' name="from" class="form-control datetimepicker" data-date-format="dd-mm-yyyy"   readonly="">
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
                                                            <input type='text' id="txtDate2" data-date-format="dd-mm-yyyy" name="to" class="form-control datetimepicker" readonly="">
                                                        <span class="material-input"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php //echo form_error('discount_type'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("discount_type");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select style="width: 200px; height: 31px;"; id="discount_type" name="discount_type" class="form-control">
													  <option  value="">Select</option>
													  <option  value="%">%</option>
													  <option  value="R">R</option>
													  
													</select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    
                                    <div class="row">
                                            <?php //echo form_error('discount_type'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Coupon Apply On");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select onchange="coupon_apply_on()" style="width: 200px; height: 31px;"; id="apply_type" name="apply_type" class="form-control">
                                                      <option  value="">--Select--</option>
                                                      <option  value="all_product">All Product</option>
                                                      <option  value="single_product">Single Product</option>
                                                        <option  value="category">Category</option>
                                                        <option  value="brand">Brand</option>
													  
													</select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    
                                    
                                    <div id="coupon_type_panel">
                                        <div class="row" id="category_ddl">
                                            <?php //echo form_error('discount_type'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Category");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select id="select_product_category" class="form-control js-example-basic-multiple" name="product_category[]" multiple="multiple" >
													  <option  value="">--Select Product Category--</option>
                                                    <?php if(!empty($allcat)){
                                                        foreach($allcat as $cat)
                                                        {
                                                            echo "<option  value='".$cat->id."'>".$cat->title."</option>";
                                                        }
                                                    }?>
													  
<!--													  <option  value="Rs">Rs</option>-->
													  
													</select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    
                                        <div class="row" id="single_product_ddl">
                                            <?php //echo form_error('discount_type'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select id="select_products" class="form-control js-example-basic-multiple" name="products[]" multiple="multiple">
													  <option  value="">--Select Product--</option>
                                                    <?php if(!empty($products)){
                                                        foreach($products as $product)
                                                        {
                                                            echo "<option  value='".$product->product_id."'>".$product->product_name."</option>";
                                                        }
                                                    }?>
													  
<!--													  <option  value="Rs">Rs</option>-->
													  
													</select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    
                                        <div class="row" id="brand_ddl">
                                            <?php //echo form_error('discount_type'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Brand");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select id="select_brand" class="form-control js-example-basic-multiple" name="brand[]" multiple="multiple">
													  <option  value="">--Brand Product--</option>
                                                    <?php if(!empty($allbrand)){
                                                        foreach($allbrand as $brand)
                                                        {
                                                            echo "<option  value='".$brand->id."'>".$brand->title."</option>";
                                                        }
                                                    }?>
													  
<!--													  <option  value="Rs">Rs</option>-->
													  
													</select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <?php echo form_error('value'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Discount Value");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="discount_value" value="" placeholder="00.00" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
										
                                        <div class="row">
                                            <?php echo form_error('cart_value'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Cart Value");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="minimum_cart_amt" value=""  placeholder="00" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo form_error('restriction'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Uses Resriction");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="uses_restriction" value="" placeholder="00.00" class="form-control" />
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
													value="" placeholder="" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
										<div class="row">
                                            <?php echo form_error('coupon_description'); ?>
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("coupon_description");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="coupon_description" value="" placeholder="description" class="form-control" />
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


<script src="<?php echo base_url($this->config->item('new_theme')); ?>/assets/js/select2.min.js" type="text/javascript"></script>
    

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

<!--
<script>
funtion coupon_apply_on()
{
    alert("ram");
    //$("#apply_type").val();
    //alert($("#apply_type").val());
}
</script>
-->

<script type="text/javascript">
    $(document).ready(function() {
        $("#coupon_type_panel").css("display","none");
        
        $("#apply_type").change( function() {
            $("#coupon_type_panel").css("display","block");
            $(".select2-search__field").css("width", "90%");
            $(".select2").css("width", "90%");
            //alert("ram");
            $type=$(this).val();
            if($type=="single_product"){
                $("#single_product_ddl").show();
                $("#category_ddl").hide();
                $("#brand_ddl").hide();
            }else if($type=="category"){
                $("#category_ddl").show();
                $("#single_product_ddl").hide();
                $("#brand_ddl").hide();
            }else if($type=="brand"){
                $("#brand_ddl").show();
                $("#category_ddl").hide();
                $("#single_product_ddl").hide();
            }else{
                $("#category_ddl").hide();
                $("#brand_ddl").hide();
                $("#single_product_ddl").hide();
            }
            //alert($(this).val());
        });
        
//        $("#select_products").select2({
//            placeholder: "Select Products",
//            allowClear:true
//        });
//        
//        $("#select_product_category").select2({
//            placeholder: "Select Product Category",
//            allowClear:true
//        });
    });
    
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
        //dateFormat: 'dd/mm/yy',
        dateFormat: 'mm/dd/yy',
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
        //dateFormat: 'dd/mm/yy',
        dateFormat: 'mm/dd/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});
    
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
    
    
    
</script>
</html>