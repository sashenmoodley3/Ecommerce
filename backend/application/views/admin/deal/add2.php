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
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Add Products");?></h4>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Title");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" id="id" name="prod_title" placeholder="<?php echo $this->lang->line("Product Title");?> " class="form-control"/>
                                                    <input type="hidden" id="pro_id" name="pro_id" value="0" >
                                                    <input type="hidden" id="pro_var_id" name="pro_var_id" value="">
                                                    <div class="well" id="result" style="display:none;"></div>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Deal Price");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text"  id="deal_price" name="deal_price" class="form-control" placeholder="<?php echo $this->lang->line("Deal Price");?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Start From");?>: *</label>
                                            <div class="col-md-4">
                                                <?php echo form_error('from'); ?>
                                                <div class="card">
                                                    <div class="card-header card-header-icon" data-background-color="rose">
                                                        <i class="material-icons">today</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Start Date");?>: *</h4>
                                                        <div class="form-group">
                                                            <label class="label-control"></label>
                                                            <input type="text" placeholder="06/07/2018" name="start_date" id='txtDate' class="form-control" readonly="">
                                                        <span class="material-input"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-header card-header-icon" data-background-color="rose">
                                                        <i class="material-icons">library_books</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Start Time");?></h4>
                                                        <div class="form-group">
                                                            <label class="label-control"></label>
                                                            <input type="time" name="start_time" placeholder="00.00" class="form-control datepicker" >
                                                        <span class="material-input"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("End To");?>: *</label>
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-header card-header-icon" data-background-color="rose">
                                                        <i class="material-icons">today</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <h4 class="card-title"><?php echo $this->lang->line("End Date");?>: *</h4>
                                                        <div class="form-group">
                                                            <label class="label-control"></label>
                                                            <input type='text' placeholder="06/07/2018" id='txtDate2' name="end_date" class="form-control" placeholder="00" readonly="">
                                                        <span class="material-input"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-header card-header-icon" data-background-color="rose">
                                                        <i class="material-icons">library_books</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <h4 class="card-title"><?php echo $this->lang->line("End Time");?></h4>
                                                        <div class="form-group">
                                                            <label class="label-control"></label>
                                                            <input type='Time' name="end_time" class="form-control datepicker" placeholder="00" />
                                                        <span class="material-input"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" name="addcatg" value="<?php echo $this->lang->line("Add Product");?>"  class="btn btn-fill btn-rose" />
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
                // ckeditor.replace('editor1');
                //bootstrap WYSIHTML5 - text editor
                // $(".textarea").wysihtml5();
            });
        </script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders();
        demo.initFormExtendedDatetimepickers();
    });

    $(document).ready(function() {

    $("#txtDate").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        format: 'dd/mm/yy',
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
        format: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});
</script>
<script type="text/javascript">
        
        $(this).ready( function() {
           
        
            $("#id").autocomplete({  
                
                minLength: 1,  
                source:   
                function(req, add){
                    $("#result").show();

                    var d=[
                    'search='+$("#id").val(),
                    'type='+$("#type").val()
                    ];
                   
                    
                    $.ajax({  
                        url: "<?php echo base_url(); ?>index.php/admin/lookup",  
                        dataType: 'json',  
                        type: 'POST',  
                        data: req, 
                        success:      
                        function(data){  
                            $("#result").html(data);
                            if(data.response =="true"){ 
                                
                               $.each(data.message, function(index, element) {
                                  
                                $('#result').append("<p class='element' id='location_" + index + "' data-id='" + element.id + "' data-varient='"+element.product_varient_id+"' data-price='" + element.price + "' hrf='" + element.value +"("+element.qty+" "+element.unit+")'>" + element.value +"("+element.qty+" "+element.unit+")</p>");


                             });
                                //$("#result").add(data.message);  
                               // console.log(data);
                                $(".element").click(function(){
                                $("#result").hide();
                                $("#id").val($(this).attr("hrf"));
                                $("#deal_price").val($(this).attr("data-price"));
                                $("#pro_id").val($(this).attr("data-id"));
                                $('#pro_var_id').val($(this).attr("data-varient"));
                                });
                                
                            }else{
                            $('#result').html($('<p/>').text("No Data Found"));  
                        }   
                        },  
                    });
               
                },  
                     
            });
                
           
        });  

    </script>
</html>