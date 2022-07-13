<?php  $this->load->view("admin/common/head"); ?>
    <style>
        .border-dark{
            padding: 10px 0px 0px 0px;
            border-top:1px #ccc solid;
            border-bottom:1px #ccc solid;
        }
        table.custom-table > thead > tr > th{
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }
        .mybtn{text-align:center;}
        .mybtn .dt-buttons>button{
        webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        position: relative;
        border: 0;
        border-radius: 3px;
        padding: 6px;
        font-weight: 400;
        color: #ffffff;
        font-style: inherit;
        font-variant: inherit;
        font-size: inherit;
        font-family: inherit;
        line-height: inherit;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.26);
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),-webkit-transform .4s cubic-bezier(.25,.8,.25,1);
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),transform .4s cubic-bezier(.25,.8,.25,1);
        }
        .mybtn .dt-buttons>button:nth-child(1){
        background-color: #e91e63;
        }
        .mybtn .dt-buttons>button:nth-child(2){
        background-color: #2196f3;
        margin-left: 3x;
        }
        .mybtn .dt-buttons>button:nth-child(3){
        background-color: #4caf50;
        margin-left: 3px;
        }
        .mybtn .dt-buttons>button:nth-child(4){
        background-color: #e91e63;
        margin-left: 3px;
        }
        
        .myselect label, .mysearch label{color: #292929;}
        .myselect select{height: 35px; width: 100%; padding: 0 5px;}
        
        .mysearch label{display:block;}
        .mysearch input{width:100% !important; border:1px solid #cccccc; height: 35px; padding: 0 12px;}
        a.action-btn-detail{
                padding: 10px;
                border-radius: 50%;
        }
        a.action-btn-edit{
                padding: 11px 5px;
                border-radius: 50%;
        }
        
    </style>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <?php  $this->load->view("admin/common/header"); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php  $this->load->view("admin/common/sidebar"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            
             <?php echo $this->lang->line("Slider");?> 
          </h1>
           
        </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"> <?php echo $this->lang->line("Add Slider");?>  </h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                    <div class="col-md-6">
                                     <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Slider Title");?>  : <span class="text-danger">*</span></label>
                                            <input type="text" name="slider_title" class="form-control" placeholder="Slider Title" value="<?php if(isset($_REQUEST["slider_title"])){echo $_REQUEST["slider_title"];} ?>"/>
                                        </div>
                                        </div>
                                   <div class="col-md-6">
                                     <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Slider Url");?>  : </label>
                                            <input type="text" name="slider_url" class="form-control" placeholder="Slider Url/Link" value="<?php if(isset($_REQUEST["slider_url"])){echo $_REQUEST["slider_url"];} ?>"/>
                                        </div>
                                        </div>
                                  
                                   
                                         
                                        <div class="col-md-6">
                                     
                                        <div class="form-group">
                                            <label>  <?php echo $this->lang->line("Image");?>  : <span class="text-danger">*</span> </label>
                                            <input type="file" name="slider_img" />
                                        </div>
                                        </div>
                               
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="">Select Status : <span class="text-danger">*</span></label>
                                                <select class="text-input form-control" name="slider_status">
                                                    <option value="1"> <?php echo $this->lang->line("Active");?>  </option>
                                                    <option value="0"> <?php echo $this->lang->line("DeActive");?>  </option>
                                                          
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="">Sub Category : <span class="text-danger">*</span></label>
                                                <select class="text-input form-control" name="sub_cat">
                                                    <option> <?php echo "Select Sub Category"; ?></option>
                                                    <?php  
                                                    echo printCategory(0,0,$this);
                                                    function printCategory($parent,$leval,$th){
                                                    
                                                    $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`status`=1 and a.`parent`!=0" );
                                                    $rows = $q->result();
                            
                                                    foreach($rows as $row){
                                                        if ($row->count > 0) {
                                                				
                                                                    //print_r($row) ;
                                                					//echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                    printRow($row,true);
                                               					    printCategory($row->id, $leval + 1,$th);
                                                					
                                                				} elseif ($row->count == 0) {
                                                					printRow($row,false);
                                                                    //print_r($row);
                                                				}
                                                        }
                            
                                                    }
                                                     
                                                    function printRow($d,$bool){
                                                          
                                                   // foreach($data as $d){
                                                    ?>
                                                    <option value="<?php echo $d->id; ?>" <?php if($d->parent == "0" && $d->leval == "0" && $bool){echo "disabled";} ?> <?php if(isset($_REQUEST["parent"]) && $_REQUEST["parent"]==$d->id){echo "selected"; } ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                        
                                                     <?php } ?> 
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addslider" value="Add Slider" />
                                       
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div>

                    </div>
                    <!-- Main row -->
                </section><!-- /.content -->
           
        </div><!-- ./wrapper -->

        <?php  $this->load->view("admin/common/common_footer"); ?>  

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jQuery/jQuery-2.1.4.min.js"); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/js/bootstrap.min.js"); ?>"></script>
    
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/morris/morris.min.js"); ?>"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/sparkline/jquery.sparkline.min.js"); ?>"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"); ?>"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"); ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/knob/jquery.knob.js"); ?>"></script>
    
    <!-- AdminLTE App -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/app.min.js"); ?>"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/demo.js"); ?>"></script>
   
   
  </body>
</html>
