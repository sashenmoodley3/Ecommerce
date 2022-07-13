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
</head>

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
                                    <h4 class="card-title"><?php echo $this->lang->line("Feature Brand Slider");?></h4>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Slider Title");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <!--<input required type="text" name="slider_title" class="form-control" placeholder="<?php echo $this->lang->line("Slider Title");?>" />-->
                                                    <?php $q = $this->db->query("Select * from feature_slider_type")->result(); ?>
                                                    <select required name="slider_title" class="form-control" required>
                                                        <option value=""> Select </option>
                                                        <?php foreach($q as $v){ ?>
                                                        <option value="<?=$v->type_id?>"> <?=$v->type_name?> </option>
                                                        <?php } ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Select Banner Size");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control" name="banner_size" id="banner_size" required>
                                                        <option value=""> <?php echo $this->lang->line("Select");?> </option>
                                                        <option value="1"> <?php echo $this->lang->line("Small");?>  </option>
                                                        <option value="0"> <?php echo $this->lang->line("FullSize");?>  </option>
                                                              
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Select Banner Type");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control" name="banner_type" id="banner_type" required onChange="imageSize()">
                                                        <option value=""> <?php echo $this->lang->line("Select");?> </option>
                                                        <option value="1"> <?php echo $this->lang->line("4 Small + 1 Big Banner");?>  </option>
                                                        <option value="2"> <?php echo $this->lang->line("4 Small Banner");?>  </option>
                                                        <option value="3"> <?php echo $this->lang->line("3 Small + 1 Big Banner");?>  </option>
                                                        <option value="4"> <?php echo $this->lang->line("1 Slider Big Banner");?>  </option>
                                                        <option value="5"> <?php echo $this->lang->line("1 Big Banner");?>  </option>
                                                    </select>
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
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Image")." <span id='sizeof'>(Size - 750*250)</span>";?>(<?=$this->config->item('slider_file_size')/1024 ?>KB): *</label>
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
                                                            <input type="file" required  name="slider_img">
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
                                        <div class="row" id="category_list">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Sub Category");?> :</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                        <select class="text-input form-control" name="sub_cat" id="sub_cat">
                                                            <option value=""> <?php echo $this->lang->line("Select Sub Category");?></option>
                                                            <?php  
                                                            echo printCategory(0,0,$this);
                                                            function printCategory($parent,$leval,$th){
                                                            
                                                            $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`status`=1 and a.`parent`=" . $parent);
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
                                        <div class="row" ><p style="text-align:center"><strong>OR</strong></p></div>
                                        <div class="row" id="brand_list">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Brand");?> :</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                        <select  class="selectpicker"  name="brand" id="brand">
                                                            <option value=""> <?php echo $this->lang->line("Select Brand");?></option>
                                                            <?php  
                                                            $q = $this->db->query("SELECT * FROM `tbl_brand` where trash=0 and status=1 ");
                                                           
                                                            if ($q->num_rows() > 0) {
                                                                $rows = $q->result();
                                                                foreach($rows as $row){
                                                                ?>
                                                                     <option value="<?php echo $row->id; ?>" ><?php  echo $row->title; ?></option>
                                                                <?php }
                                    
                                                            }?>
                                                        </select>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row" ><p style="text-align:center"><strong>OR</strong></p></div>
                                        <div class="row" id="product_list">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product");?> :</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                        <select class="selectpicker" name="product" id="product">
                                                            <option value=""> <?php echo $this->lang->line("Select Product");?></option>
                                                            <?php  
                                                            $q = $this->db->query("SELECT distinct(products.product_id),products.*, product_varient.*
                                                                                    FROM products
                                                                                    INNER JOIN product_varient ON product_varient.product_id = products.product_id
                                                                                    INNER JOIN categories ON categories.id=products.category_id
                                                                                    LEFT JOIN tbl_brand on tbl_brand.id = products.brand_id AND tbl_brand.trash=0 and tbl_brand.status=1 
                                                                                    WHERE products.trash=0 AND products.in_stock=1");
                                                            $rows = $q->result();
                                    
                                                            if ($q->num_rows() > 0) {
                                                                $rows = $q->result();
                                                                foreach($rows as $row){ ?>
                                                                     <option value="<?php echo $row->product_id; ?>" ><?php  echo $row->product_name .' ( '.$row->qty.' '.$row->unit.' )'; ?></option>
                                                                <?php }
                                    
                                                            }?> 
                                                        </select>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" name="addslider" value="<?php echo $this->lang->line("Add Slider");?>" class="btn btn-fill btn-rose add-curd" >                                                </div>
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
<script>
    $(document).on('change','#sub_cat', function(e){
        if($(this).find(':selected').val() !=''){
            $('#product').attr('disabled','disabled');
            $('#brand').attr('disabled','disabled');
        }
        else{
            $('#product').removeAttr('disabled');
            $('#brand').removeAttr('disabled');
        }
    
    })
    $(document).on('change','#product', function(e){
        if($(this).find(':selected').val() !=''){
            $('#sub_cat').attr('disabled','disabled');
            $('#brand').attr('disabled','disabled');
        }
        else{
            $('#sub_cat').removeAttr('disabled');
            $('#brand').removeAttr('disabled');
        }
    })
    $(document).on('change','#brand', function(e){
        if($(this).find(':selected').val() !=''){
            $('#product').attr('disabled','disabled');
            $('#sub_cat').attr('disabled','disabled');
        }
        else{
            $('#product').removeAttr('disabled');
            $('#sub_cat').removeAttr('disabled');
        }
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
    
    function imageSize(){
        var banner_size     =   $('#banner_size').val();
        var banner_type     =   $('#banner_type').val();
        var max_width       = 0;  
        var max_height      = 0; 
        if(banner_size == 1 && banner_type == 3){
                max_width  = '750';
                max_height = '250';
        }
        if(banner_size == 0 && banner_type == 3){
            max_width  = '1395';
            max_height = '200';
        }
        if(banner_size == 0 && banner_type == 1){
            max_width  = '560';
            max_height = '378';
        }
        if(banner_size == 1 && banner_type == 1){
            max_width  = '275';
            max_height = '184';
        }
        if((banner_size == 1 || banner_size == 0) && banner_type == 2){
            max_width  = '480';
            max_height = '360';
        } if((banner_size == 1 || banner_size == 0) && banner_type == 4){
            max_width  = '1130';
            max_height = '400';
        }
        $('#sizeof').html('(Size -'+max_width+'*'+max_height+')');
        
    }
    
</script>
</html>