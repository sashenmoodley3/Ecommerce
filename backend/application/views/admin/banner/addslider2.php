<?php  $this->load->view("admin/common/head"); ?>

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
                    <div class="msg"></div>
                    <div class="row">
                        <form id="form1" name="form1" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                   <h4 class="card-title"><?php echo $this->lang->line("Add Banner");?></h4>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Slider Title");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" required name="slider_title" class="form-control" placeholder="<?php echo $this->lang->line("Slider Title");?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                   <div class="row" style="display: none;">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Slider Url");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="slider_url" class="form-control" placeholder="<?php echo $this->lang->line("Slider Url");?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Image");?> (Size 750*250px): *</label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img width="100%" height="100%" src="">
                                                    </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" name="slider_img" required>
                                                            <div class="ripple-container"></div>
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Select Status");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control" name="slider_status" required>
                                                    <option value="1"> <?php echo $this->lang->line("Active");?>  </option>
                                                    <option value="0"> <?php echo $this->lang->line("DeActive");?>  </option>
                                                          
                                                </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Sub Category");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                        <select class="text-input form-control" name="sub_cat" >
                                                            <option> <?php echo $this->lang->line("Select Sub Category");?></option>
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
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" name="addslider" value="<?php echo $this->lang->line("Add Banner");?>" class="btn btn-fill btn-rose add-curd" >                                                </div>
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
</script>
</html>