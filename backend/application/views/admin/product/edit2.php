<?php  $this->load->view("admin/common/head"); ?>
    <style>
        .col-lg-3 {
            width: 14%;
        }
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
        .col-lg-2 {
            width: 10%;
        }
        .col-lg-3 {
            width: 14%;
        }
        input[type="file"] {
          display: block;
        }
        .imageThumb {
          max-height: 75px;
          border: 2px solid;
          padding: 1px;
          cursor: pointer;
        }
        .pip {
          display: inline-block;
          margin: 10px 10px 0 0;
          width:100px;
        }
        .remove {
          display: block;
          background: #444;
          border: 1px solid black;
          color: white;
          text-align: center;
          cursor: pointer;
        }
        .remove:hover {
          background: white;
          color: black;
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
                            <?php if($this->session->userdata('language') == "arabic")
                                {
                                ?>
                                    <div class="col-md-3">
                                    </div>
                                <?php
                                }
                            ?>
                            <?php
                                $q = $this->db->query("SELECT * FROM `language_setting`  WHERE `id`=1 " );
                                $rows = $q->row();
                                if($rows->status==1)
                                {
                                    $setting=0;
                                }
                                else
                                {
                                    $setting='style="display:none"';
                                }
                            ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Edit products");?></h4>
                                        <div class="row"  style="margin-top:50px">
                                            <label class="col-md-3 label-on-left"> <?php echo $this->lang->line("product title");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="prod_title" class="form-control"
                                                           value="<?php echo $product->product_name; ?>" required placeholder="Product Title"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row"  <?= $setting ?> >
                                            <label class="col-md-3 label-on-left"> <?php echo $this->lang->line("product Arabic title");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="arb_prod_title" class="form-control"
                                                           value="<?php echo $product->product_arb_name; ?>" required placeholder="Product Title"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Category Type");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select id="optional_fields" onchange="optfield(this.value)" class="text-input form-control" name="product_cat_type" required>
                                                        <option value=""><?php echo $this->lang->line("Select Product Category Type");?></option>
                                                        <?php
                                                            $q = $this->db->query("SELECT a.* FROM `product_cat_type` a  WHERE a.`status`=1");
                                                            $rows = $q->result();
                                                        //print_r($rows);
                                                            if(count($rows)>0)
                                                            {
                                                                foreach($rows as $row){
                                                        ?>
                                                        <option value="<?php echo $row->product_cat_type_id; ?>" <?php if(isset($_POST["product_cat_type"]) && $_POST["product_cat_type"]==$row->product_cat_type_id){echo "selected"; } ?> <?php if($product->product_cat_type_id == $row->product_cat_type_id){ echo "selected"; } ?> ><?php echo $row->title; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Category");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <?php 
													
													// echo '<pre>';
													// print_r($product);
													// echo '</pre>';
													

													?>
                                                    <select class="text-input form-control" name="parent" id="parent">
                                                        <option value=""><?php echo $this->lang->line("Select Category");?></option>
                                                         <?php  
                                                            echo printCategory(0,0,$this,$product);
                                                            function printCategory($parent,$leval,$th,$product){
																$type_id = !empty($product->product_cat_type_id)?  $product->product_cat_type_id:'0';
																$q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`parent`=" . $parent." AND a.`product_cat_type_id`=" . $type_id);
																$rows = $q->result();
										
																foreach($rows as $row){
																	print_r($product);
																	if ($row->count > 0) {
																			
																		//print_r($row) ;
																		//echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
																		printRow($row,$product,true);
																		printCategory($row->id, $leval + 1,$th,$product);
																		
																	} 
																	elseif ($row->count == 0) {
																		printRow($row,$product,false);
																		//print_r($row);
																	}
                                                                }
                                    
                                                            }
                                                            function printRow($d,$product,$bool){
                                                                
                                                           // foreach($data as $d){
															  
                                                            
                                                            ?>
                                                               <option value="<?php echo $d->id; ?>" <?php if($product->category_id == $d->id){ echo "selected"; } ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                                 
                                                             <?php } ?> 
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Brand :");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control" name="brand">
                                                        <option value=""><?php echo $this->lang->line("Select Brand");?></option>
                                                        <?php  
                                                            $q = $this->db->query("SELECT * FROM `tbl_brand` WHERE trash=0 AND status=1");
                                                            $rows = $q->result(); 
                                    
                                                            foreach($rows as $row){ ?>
                                                                <option value="<?php echo $row->id; ?>" <?= $product->brand_id == $row->id ? 'selected': ''?> ><?php  echo $row->title; ?></option>
                                    
                                                            <?php }  ?> 
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Description");?></label>
                                            <div class="col-md-9">
                                                
                                                <div class="form-group label-floating is-empty" id="sample">
                                                    <textarea   name="product_description" id="product_description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>"><?php echo $product->product_description; ?></textarea>
                                                    <span class="material-input"></span>
                                                </div> <!--id="editor"-->
                                               
                                            </div>
                                        </div>
                                        <div class="row" <?= $setting ?> >
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Arabic Description");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <textarea name="arb_product_description" class="textarea"   style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo $product->product_arb_description; ?></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <label class="col-md-3 label-on-left"><?php echo "SKU Code";?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text"  name="prod_sku_code" class="form-control" value="<?php echo $product->prod_sku_code; ?>"  placeholder="Product SKU Code"/>
                                                    <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <!-- <div class="row" >-->
                                        <!--    <label class="col-md-3 label-on-left"><?php //echo "Warehouse Location Item";?>:</label>-->
                                        <!--    <div class="col-md-9">-->
                                        <!--        <div class="form-group label-floating is-empty">-->
                                        <!--            <label class="control-label"></label>-->
                                        <!--            <input type="text" name="prod_ware_location" class="form-control"  placeholder="Product Warehouse Location" value="<?php echo $product->prod_ware_location; ?>"/>-->
                                        <!--            <span class="material-input"></span></div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo "Product Image";?>:</label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div id="result"></div>
                                                <?php if(!empty($product->product_image)){
                                                                    $images = explode(',',$product->product_image);
                                                                    foreach($images as $image){
                                                                        $filename   =   FCPATH.'/uploads/products/'.$image;
                                                                        if(file_exists($filename) && !empty($image)){?>
                                                                            <span class=pip>
                                                                                <img class="imageThumb" src="<?= base_url('uploads/products/'.$image); ?>"> <br/><span class="remove">Remove image</span>
																				<input type="hidden" name="pro_img[]" value="<?= $image ?>" >
                                                                            </span>
                                                                        <?php }
                                                                        else{?>
                                                                            <span class=pip>
                                                                                <img src="<?=base_url()?>new_theme/assets/img/3b93b61b.png" alt="Selected Image"  width="100%" height="100%">
                                                                            </span>
                                                                    <?php }
                                                                    }
                                                                } 
                                                            ?>
                                                                        
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail"></div>
                                                    <!--<div class="fileinput-preview fileinput-exists thumbnail"></div>-->
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" id="files" name="prod_img[]" multiple>
                                                        </span>
                                                        <a href="#pablo" id="pablos" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" id="prod_status" name="prod_status" value="1"  <?php if($product->in_stock == 1){ echo "checked"; } ?> />
                                                <label for="prod_status" style="margin-left:20px"><?php echo $this->lang->line("In Stock");?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" id="prod_status" name="prod_status"  value="0" <?php if($product->in_stock == 0){ echo "checked"; } ?> />
                                                <label for"prod_status" style="margin-left:20px"><?php echo "Out Of Stock";?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-6">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Product Type") ?></label>
                                                <div class="col-md-6">
                                                    <select class="text-input form-control" name="prod_type">
                                                        <option value=""><?php echo $this->lang->line("Select Product Type");?></option>
                                                        <option value="1" <?php if($product->product_type == 1){ echo "selected"; } ?>><?php echo $this->lang->line("Veg");?></option>
                                                        <option value="2" <?php if($product->product_type == 2){ echo "selected"; } ?>><?php echo $this->lang->line("Nonveg");?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Product Swadeshi") ?></label>
                                                <div class="col-md-6">
                                                    <select class="text-input form-control" name="prod_call">
                                                        <option value=""><?php echo $this->lang->line("Select Product Swadeshi");?></option>
                                                        <option value="1" <?php if($product->product_call == 1){ echo "selected"; } ?>><?php echo $this->lang->line("Swadeshi");?></option>
                                                        <option value="2" <?php if($product->product_call == 2){ echo "selected"; } ?>><?php echo $this->lang->line("Videshi");?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset class="form-group">
                                                    <label for="basicInput">Tax<span class="required">*</span></label>
                                                    <input type="text" name="tax" id="tax" required class="form-control" value="<?=$purchase[0]->tax?>"  placeholder="00.00" />
                                                </fieldset>
                                                
                                            </div>
                                        </div>
                                        
                                        
                                        <?php  if(!empty($purchase)){
                                                         
                                        foreach($purchase as $k=>$value){ 
                                                $flavor     = $value->flavor;
                                                $varient_id     = $value->varient_id;
                                                $price          = $value->price;
                                                $margin         = $value->margin_value;
                                                $qty            = $value->qty;
                                                $unit           = $value->unit;
                                                $stock_inv      = $value->stock_inv;
                                                $tax            = $value->tax;
                                                $mrp            = $value->mrp; 
                                                $var_use_for            = $value->var_use_for; 
                                                $var_size            = $value->var_size; 
                                                $var_color            = $value->var_color; 
                                                $var_material            = $value->var_material; 
                                                $pro_var_images = base_url().'uploads/products/'.$value->pro_var_images;
                                                ?>
                                            <div class="">
                                                <div class="row">
                                                    <!-- <?php if(!empty($this->config->item('add_product_text_box'))){ ?>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->config->item('add_product_text_box')?> </label>
                                                            <input type="text" name="flavor[]" placeholder="<?=$this->config->item('add_product_text_box')?>"
                                                                   class="form-control"  value="<?=$flavor?>"/>
                                                        </fieldset>
                                                    </div>
                                                    <?php } ?> -->
													
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" >
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Use For')?> </label>
                                                            <select class="text-input form-control use_for_attr" name="var_use_for[]">
                                                        <option value=""><?php echo $this->lang->line("Select Use For");?></option>
                                                        <?php
                                                            $q1 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=4 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
                                                            $rows1 = $q1->result();
                                                        //print_r($rows);
                                                            if(count($rows1)>0)
                                                            {
                                                                foreach($rows1 as $row){
                                                        ?>
                                                        <option value="<?php echo $row->attribute_value_id; ?>" <?php if($var_use_for == $row->attribute_value_id){ echo "selected"; } ?>><?php echo $row->attribute_value; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" >
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Color')?> </label>
                                                            <select class="text-input form-control color_attr" name="var_color[]">
                                                        <option value=""><?php echo $this->lang->line("Select Color");?></option>
                                                        <?php
                                                            $q2 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=1 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
                                                            $rows2 = $q2->result();
                                                        //print_r($rows);
                                                            if(count($rows2)>0)
                                                            {
                                                                foreach($rows2 as $row){
                                                        ?>
                                                        <option style="background-color: <?=$row->attribute_value;?>" value="<?php echo $row->attribute_value_id; ?>" <?php if($var_color == $row->attribute_value_id){ echo "selected"; } ?>><li style="background-color: <?=$row->attribute_value;?>"><?=$row->attribute_value;?></li></option>
                                                                
<!--                                                        <option value="<?php echo $row->attribute_value_id; ?>" <?php if($var_color == $row->attribute_value_id){ echo "selected"; } ?>><?php echo $row->attribute_value; ?></option>-->
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" >
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Size')?> </label>
                                                            <select class="text-input form-control size_attr" name="var_size[]">
                                                        <option value=""><?php echo $this->lang->line("Select Size");?></option>
                                                        <?php
                                                            $q3 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=2 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
                                                            $rows3 = $q3->result();
                                                        //print_r($rows);
                                                            if(count($rows3)>0)
                                                            {
                                                                foreach($rows3 as $row){
                                                        ?>
                                                        <option value="<?php echo $row->attribute_value_id; ?>" <?php if($var_size == $row->attribute_value_id){ echo "selected"; } ?>><?php echo $row->attribute_value; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" >
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Material')?> </label>
                                                            <select class="text-input form-control material_attr" name="var_material[]">
                                                        <option value=""><?php echo $this->lang->line("Select Material");?></option>
                                                        <?php
                                                            $q4 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=3 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
                                                            $rows4 = $q4->result();
                                                        //print_r($rows);
                                                            if(count($rows4)>0)
                                                            {
                                                                foreach($rows4 as $row){
                                                        ?>
                                                        <option value="<?php echo $row->attribute_value_id; ?>"  <?php if($var_material == $row->attribute_value_id){ echo "selected"; } ?>><?php echo $row->attribute_value; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
													
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Quantity <span class="required">*</span></label>
                                                            <input type="hidden" name="varient_id[]" value="<?=$varient_id?>">
                                                            <input type="text" name="quantity[]" placeholder="Quantity"
                                                                   class="form-control" maxlength="5" required value="<?=$qty?>">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <label for="basicInput">Unit<span class="required">*</span></label>
                                                        <fieldset class="form-group ">
                                                            <select class="custom-select form-control" name="unit[]">
                                                                <option value=""> Select </option>
                                                                <option <?php if($unit == 'ML'){ echo "selected"; } ?> value="ML">ML</option>
                                                                <option <?php if($unit == 'LTR'){ echo "selected"; } ?> value="LTR">LTR</option>
                                                                <option <?php if($unit == 'GM'){ echo "selected"; } ?> value="GM">GM</option>
                                                                <option <?php if($unit == 'KG'){ echo "selected"; } ?> value="KG">KG</option>
                                                                <option <?php if($unit == 'PC'){ echo "selected"; } ?> value="PC">PC</option>
                                                                <option <?php if($unit == 'UNIT'){ echo "selected"; } ?> value="UNIT">UNIT</option>
                                                                <option <?php if($unit == 'LBS'){ echo "selected"; } ?> value="LBS">LBS</option>
                                                                            
                                                            </select>
                                                            
                                                        </fieldset>

                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Stock <span class="required">*</span></label>
                                                            <input type="text" name="stock[]" value="<?=$stock_inv?>" placeholder="Stock"
                                                                   class="form-control" maxlength="5" required readonly/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Original Price<span class="required">*</span></label>
                                                            <input id="prodOrig1<?php echo $varient_id?>" type="text" name="mrp[]" placeholder="MRP" value="<?=$mrp?>"
                                                                   class="form-control pcls" maxlength="10" required/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Margin Price<span class="required">*</span></label>
                                                            <input id="prodPrice1<?php echo $varient_id?>" type="text" name="price[]" placeholder="Product Price" readonly value="<?=$price?>" 
                                                            class="form-control pcls" maxlength="10"  required/>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Margin(%)<span class="required">*</span></label>
                                                            <input id="prodMargin1<?php echo $varient_id?>" type="text" name="margin[]" placeholder="Margin" value="<?=$margin?>" 
                                                            class="form-control pcls" maxlength="10"  required onfocusout="addMargin(<?php echo $varient_id?>)"/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <!-- <div class="col-xl-2 col-lg-3 col-md-12 mb-1">-->
                                                    <!--    <fieldset class="form-group">-->
                                                    <!--        <label for="basicInput">Tax<span class="required">*</span></label>-->
                                                    <!--        <input type="text" name="tax[]" id="tax" required class="form-control" value="<?=$tax?>"  placeholder="00.00" />-->
                                                    <!--    </fieldset>-->
                                                        
                                                    <!--</div>-->
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail">
                                                                    <img width="100%" height="100%" src="<?=$pro_var_images?>" />
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                <div>
                                                                    <span class="btn btn-rose btn-round btn-file">
                                                                        <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                                        <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                                        <input type="file" name="prod_var_img[]" multiple>
                                                                    </span>
                                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php }?> 
                                    
                                    <?php 
    
                                    $pro_cat_type1 = $product->product_cat_type_id;
                                    $disp = "";
                                    if($pro_cat_type1==5 || $pro_cat_type1==6 || $pro_cat_type1==7){ $disp = "block"; }else{ $disp = "none";} ?>
                                            <div class="field_wrapper">
                                                <div class="row">
                                                    <!-- <?php if(!empty($this->config->item('add_product_text_box'))){ ?>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->config->item('add_product_text_box')?> </label>
                                                            <input type="text" name="flavor[]" placeholder="<?=$this->config->item('add_product_text_box')?>"
                                                                   class="form-control" />
                                                        </fieldset>
                                                    </div>
                                                    <?php } ?> -->
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:<?=$disp;?>;">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Use For')?> </label>
                                                            <select class="text-input form-control use_for_attr" name="var_use_for[]">
                                                        <option value=""><?php echo $this->lang->line("Select Use For");?></option>
                                                        <?php
                                                            $q1 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=4 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
                                                            $rows1 = $q1->result();
                                                        //print_r($rows);
                                                            if(count($rows1)>0)
                                                            {
                                                                foreach($rows1 as $row){
                                                        ?>
                                                        <option value="<?php echo $row->attribute_value_id; ?>" ><?php echo $row->attribute_value; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:<?=$disp;?>;">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Color')?> </label>
                                                            <select class="text-input form-control color_attr" name="var_color[]">
                                                        <option value=""><?php echo $this->lang->line("Select Color");?></option>
                                                        <?php
                                                            $q2 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=1 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
                                                            $rows2 = $q2->result();
                                                        //print_r($rows);
                                                            if(count($rows2)>0)
                                                            {
                                                                foreach($rows2 as $row){
                                                        ?>
                                                        <option style="background-color: <?=$row->attribute_value;?>" value="<?php echo $row->attribute_value_id; ?>" ><li style="background-color: <?=$row->attribute_value;?>"><?=$row->attribute_value;?></li></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:<?=$disp;?>;">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Size')?> </label>
                                                            <select class="text-input form-control size_attr" name="var_size[]">
                                                        <option value=""><?php echo $this->lang->line("Select Size");?></option>
                                                        <?php
                                                            $q3 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=2 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
                                                            $rows3 = $q3->result();
                                                        //print_r($rows);
                                                            if(count($rows3)>0)
                                                            {
                                                                foreach($rows3 as $row){
                                                        ?>
                                                        <option value="<?php echo $row->attribute_value_id; ?>" ><?php echo $row->attribute_value; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:<?=$disp;?>;">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Material')?> </label>
                                                            <select class="text-input form-control material_attr" name="var_material[]">
                                                        <option value=""><?php echo $this->lang->line("Select Material");?></option>
                                                        <?php
                                                            $q4 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=3 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
                                                            $rows4 = $q4->result();
                                                        //print_r($rows);
                                                            if(count($rows4)>0)
                                                            {
                                                                foreach($rows4 as $row){
                                                        ?>
                                                        <option value="<?php echo $row->attribute_value_id; ?>"><?php echo $row->attribute_value; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Quantity <span class="required">*</span></label>
                                                            <input type="text" name="quantity[]" placeholder="Quantity"
                                                                   class="form-control" maxlength="5" required/>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <label for="basicInput">Unit<span class="required">*</span></label>
                                                        <fieldset class="form-group">
                                                            <select class="custom-select form-control" name="unit[]" >
                                                                <option value=""> Select </option>
                                                                <option value="ML">ML</option>
                                                                <option value="LTR">LTR</option>
                                                                <option value="GM">GM</option>
                                                                <option value="KG">KG</option>
                                                                <option value="PC">PC</option>
                                                                <option value="UNIT">UNIT</option>  
                                                                <option value="LBS">LBS</option>          
                                                            </select>
                                                            
                                                        </fieldset>

                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Stock <span class="required">*</span></label>
                                                            <input type="text" name="stock[]" placeholder="Stock"
                                                                   class="form-control" maxlength="5" required/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Original Price<span class="required">*</span></label>
                                                            <input id="prodOrig2" type="text" name="mrp[]" placeholder="MRP"
                                                                   class="form-control pcls" maxlength="10" required/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Maring price<span class="required">*</span></label>
                                                            <input id="prodPrice2" type="text" name="price[]" placeholder="Product Price" readonly
                                                            class="form-control pcls" maxlength="10"  required/>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Margin(%)<span class="required">*</span></label>
                                                            <input id="prodMargin2" type="text" name="margin[]" placeholder="margin" 
                                                            class="form-control pcls" maxlength="10"  required onfocusout="addMargin2()"/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <!--<div class="col-xl-2 col-lg-3 col-md-12 mb-1">-->
                                                    <!--    <fieldset class="form-group">-->
                                                    <!--        <label for="basicInput">Tax<span class="required">*</span></label>-->
                                                    <!--        <input type="text" name="tax[]" id="tax" required class="form-control" placeholder="00.00" />-->
                                                    <!--    </fieldset>-->
                                                        
                                                    <!--</div>-->
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail">
                                                                    <img width="100%" height="100%" src="" />
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                <div>
                                                                    <span class="btn btn-rose btn-round btn-file">
                                                                        <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                                        <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                                        <input type="file" name="prod_var_img[]" multiple>
                                                                    </span>
                                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                        <a href="javascript:void(0);" class="add_button text-25 margin-5 margin-top-5"
                                                               title="Add Product"><!--<img src="add-icon.png"/>--> <i class="fa fa-plus-square-o "></i></a>
                                                </div>

                                            </div>
                                        <?php }else{ ?>
                                            <div class="field_wrapper">
                                                <div class="row">
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Quantity <span class="required">*</span></label>
                                                            <input type="text" name="quantity[]" placeholder="Quantity"
                                                                   class="form-control" maxlength="5" required/>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <label for="basicInput">Unit<span class="required">*</span></label>
                                                        <fieldset class="form-group ">
                                                            <select class="custom-select form-control" name="unit[]">
                                                                <option value=""> Select </option>
                                                                <option value="ML">ML</option>
                                                                <option value="LTR">LTR</option>
                                                                <option value="GM">GM</option>
                                                                <option value="KG">KG</option>
                                                                <option value="PC">PC</option>
                                                                <option value="UNIT">UNIT</option>            
                                                            </select>
                                                            
                                                        </fieldset>

                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Stock <span class="required">*</span></label>
                                                            <input type="text" name="stock[]" placeholder="Stock"
                                                                   class="form-control" maxlength="5" required/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">MRP<span class="required">*</span></label>
                                                            <input type="text" name="mrp[]" placeholder="MRP"
                                                                   class="form-control pcls" maxlength="10" required/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"> Sale Price<span class="required">*</span></label>
                                                            <input type="text" name="price[]" placeholder="Sale Price" class="form-control pcls" maxlength="10"  required/>
                                                            
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <!-- <div class="col-xl-2 col-lg-3 col-md-12 mb-1">-->
                                                    <!--    <fieldset class="form-group">-->
                                                    <!--        <label for="basicInput">Tax<span class="required">*</span></label>-->
                                                    <!--        <input type="text" name="tax[]" id="tax" required class="form-control" placeholder="00.00" />-->
                                                    <!--    </fieldset>-->
                                                    <!--</div>-->
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail">
                                                                    <img width="100%" height="100%" src="" />
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                <div>
                                                                    <span class="btn btn-rose btn-round btn-file">
                                                                        <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                                        <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                                        <input type="file" name="prod_var_img[]" multiple>
                                                                    </span>
                                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <a href="javascript:void(0);" style=" position: fixed; float: right; right: -8%;" class="add_button text-25 margin-5 margin-top-5 col-xl-2 col-lg-3 col-md-1 mb-1"
                                                               title="Add Product"><!--<img src="add-icon.png"/>--> <i class="fa fa-plus-square-o "></i></a>
                                                </div>

                                            </div>
                                            <?php } ?>
                                            
                                        <input type="hidden" name="rewards" class="form-control" value="<?php echo $product->rewards; ?>"  placeholder="00"/>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose edit-curd" name="addcatg" value="<?php echo $this->lang->line("Update Product");?>">
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

    <script type="text/javascript">
        function addMargin (id){
            debugger

            if(id !== "") {
                if ($('#prodOrig1'+id).val() === "" || $('#prodOrig1'+id).val() === '0') {
                    alert("Please enter a Product price before a margin(%)");
                    return;
                }

                if ($('#prodMargin1'+id).val() !== "" && $('#prodMargin1'+id).val() !== '0') {
                    var marginPrice = parseInt($('#prodOrig1'+id).val()) + (($('#prodMargin1'+id).val() / 100) * $('#prodOrig1'+id).val())
                    $('#prodPrice1'+id).val(marginPrice.toFixed(2)); 
                } else {
                    $('#prodPrice1'+id).val($('#prodOrig1'+id).val()); 
                }
            } else {

            if ($('#prodOrig1').val() === "" || $('#prodOrig1').val() === '0') {
                alert("Please enter a Product price before a margin(%)");
                return;
            }

            if ($('#prodMargin1').val() !== "" && $('#prodMargin1').val() !== '0') {
                var marginPrice = parseInt($('#prodOrig1').val()) + (($('#prodMargin1').val() / 100) * $('#prodOrig1').val())
                $('#prodPrice1').val(marginPrice.toFixed(2)); 
            } else {
                $('#prodPrice1').val($('#prodOrig1').val()); 
            }
        }
        }                                                        
    </script>

<script type="text/javascript">
        function addMargin2 (){
            debugger
            if ($('#prodOrig2').val() === "" || $('#prodOrig2').val() === '0') {
                alert("Please enter a Product price before a margin(%)");
                return;
            }

            if ($('#prodMargin2').val() !== "" && $('#prodMargin2').val() !== '0') {
                var marginPrice = parseInt($('#prodOrig2').val()) + (($('#prodMargin2').val() / 100) * $('#prodOrig2').val())
                $('#prodPrice2').val(marginPrice.toFixed(2)); 
            } else {
                $('#prodPrice2').val($('#prodOrig2').val()); 
            }
        }                                                        
    </script>

<script type="text/javascript">
        function addMargin3 (id){
            debugger
            var id = id.id.replace(/[^0-9]/g, '');
            if ($('#prodOriga'+id).val() === "" || $('#prodOriga'+id).val() === '0') {
                alert("Please enter a Product price before a margin(%)");
                return;
            }

            if ($('#prodMargina'+id).val() !== "" && $('#prodMargina'+id).val() !== '0') {
                var marginPrice = parseInt($('#prodOriga'+id).val()) + (($('#prodMargina'+id).val() / 100) * $('#prodOriga'+id).val())
                $('#prodPricea'+id).val(marginPrice.toFixed(2)); 
            } else {
                $('#prodPricea'+id).val($('#prodOriga'+id).val()); 
            }
        }                                                        
    </script>
</body>
<!--   Core JS Files   -->

<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js">

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
    
</script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script type="text/javascript">
    CKEDITOR.replace( 'product_description', {
        extraPlugins: 'language',
        language_list: ['ar:Arabic:rtl', 'fr:French', 'he:Hebrew:rtl', 'es:Spanish', 'es:Hindi'],
    });
</script>

<script>
   $(document).ready(function() {
       
            var optional_field = $('#optional_fields').val();
            var secndaddfield = '';//add use_for, size, color, material fields
            var optional_field_display = "";
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var oneaddfield = '';

            var x = 1; //Initial field counter is 1
            $(addButton).click(function () { //Once add button is clicked
                if (x < maxField) { //Check maximum number of input fields
                    x++; //Increment field counter
                    //$(wrapper).append(fieldHTML); // Add field html
                    fieldHTML(x);
					optfield($('#optional_fields').val())
                }
            });
            $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
                e.preventDefault();
                $(this).parent().remove();
                
                x--; //Decrement field counter
            });

       jQuery.validator.addMethod("noSpace", function(value, element) {
           return value.indexOf(" ") < 0 && value != "";
       }, "No space please and don't leave it empty");


       $("#form1").validate({
        rules: {
            // price: {
            //     required: true,
            //     max: function () {
            //         return parseInt($('#mrp').val());
            //     }
            // },
        }
    });
   });
    
    function fieldHTML(x)
   {
       var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var optional_field = $('#optional_fields').val();
            var oneaddfield = '';
            var secndaddfield = '';//add use_for, size, color, material fields
            var optional_field_display = "";
            if(optional_field==5 || optional_field==6 || optional_field==7)
            {
                optional_field_display = "block";
            }
            else{
                optional_field_display = "none";
            }
       
       
            // <?php if(!empty($this->config->item('add_product_text_box'))){ ?>
            //     oneaddfield     =   '<div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput"><?=$this->config->item('add_product_text_box')?></label> <input type="text" name="flavor[]" placeholder="<?=$this->config->item('add_product_text_box')?>" class="form-control" /></fieldset></div>';
            // <?php } ?>
       
        secndaddfield     =   '<div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:'+optional_field_display+';"><fieldset class="form-group"><label for="basicInput"><?=$this->lang->line('Use For')?> </label><select class="text-input form-control use_for_attr" name="var_use_for[]"><option value=""><?=$this->lang->line("Select Use For");?></option>';       
        <?php 
            $q1 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=4 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
            $rows1 = $q1->result();
                                                        //print_r($rows);
            if(count($rows1)>0)
            {
                foreach($rows1 as $row){
        ?>
        secndaddfield     +=   '<option value="<?=$row->attribute_value_id; ?>" ><?=$row->attribute_value; ?></option>';
        <?php
                }
            }

        ?>
         secndaddfield     +='</select></fieldset></div><div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:'+optional_field_display+';"><fieldset class="form-group"> <label for="basicInput"><?=$this->lang->line('Color')?> </label><select class="text-input form-control color_attr" name="var_color[]"><option value=""><?=$this->lang->line("Select Color");?></option>';
        <?php
            $q2 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=1 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
            $rows2 = $q2->result();
        //print_r($rows);
            if(count($rows2)>0)
            {
                foreach($rows2 as $row){
        ?>
        secndaddfield     +='<option style="background-color: <?=$row->attribute_value;?>" value="<?php echo $row->attribute_value_id; ?>" ><li style="background-color: <?=$row->attribute_value;?>"><?=$row->attribute_value;?></li></option>';
        <?php
                }
            }

        ?>
     secndaddfield     +='</select> </fieldset> </div><div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:'+optional_field_display+';"><fieldset class="form-group"><label for="basicInput"><?=$this->lang->line('Size')?> </label> <select class="text-input form-control size_attr" name="var_size[]"> <option value=""><?php echo $this->lang->line("Select Size");?></option>';
    <?php
        $q3 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=2 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
        $rows3 = $q3->result();
    //print_r($rows);
        if(count($rows3)>0)
        {
            foreach($rows3 as $row){
    ?>
    secndaddfield     +='<option value="<?=$row->attribute_value_id;?>" ><?=$row->attribute_value;?></option>';
    <?php
            }
        }

    ?>
     secndaddfield     +='</select></fieldset> </div><div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:'+optional_field_display+';"> <fieldset class="form-group"> <label for="basicInput"><?=$this->lang->line('Material')?> </label> <select class="text-input form-control material_attr" name="var_material[]"> <option value=""><?=$this->lang->line("Select Material");?></option>';
    <?php
        $q4 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=3 and attribute_values_product_cat_type_id=".$product->product_cat_type_id);
        $rows4 = $q4->result();
    //print_r($rows);
        if(count($rows4)>0)
        {
            foreach($rows4 as $row){
    ?>
    secndaddfield     +='<option value="<?=$row->attribute_value_id; ?>"><?=$row->attribute_value; ?></option>';
    <?php
            }
        }

    ?>
      secndaddfield     +=' </select></fieldset></div>';
       
        
            var fieldHTML = '<div class="row ">'+oneaddfield+secndaddfield+'<div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">Quantity<span class="required">*</span></label> <input type="text" name="quantity[]" placeholder="Quantity" class="form-control" maxlength="5" required/></fieldset></div><div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">Unit<span class="required">*</span></label><select class="form-control custom-select" required name="unit[]"><option value=""> Select </option><option value="ML">ML</option> <option value="LTR">LTR</option><option value="GM">GM</option><option value="KG">KG</option><option value="PC">PC</option><option value="UNIT">UNIT</option><option value="LBS">LBS</option></select></fieldset></div><div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">Stock<span class="required">*</span></label><input type="text" name="stock[]" placeholder="Stock" class="form-control" maxlength="5" required/></fieldset></div>';
            
            
            var fieldHTML1 = '<div class="col-xl-2 col-lg-3 col-md-12 mb-1"> <fieldset class="form-group"> <label for="basicInput">Original Price <span class="required">*</span> </label> <input id="prodOriga'+x+'" type="text" name="mrp[]" placeholder="MRP"class="form-control pcls" maxlength="10" required/> </fieldset> </div> <div class="col-xl-2 col-lg-3 col-md-12 mb-1"> <fieldset class="form-group"> <label for="basicInput">Maring Price <span class="required">*</span> </label> <input id="prodPricea'+x+'" type="text" name="price[]" placeholder="Product Price"class="form-control pcls" maxlength="10" readonly required/> </fieldset> </div> <div class="col-xl-2 col-lg-3 col-md-12 mb-1"> <fieldset class="form-group"> <label for="basicInput">Margin(%) <span class="required">*</span> </label> <input id="prodMargina'+x+'" type="text" name="margin[]" placeholder="Margin"class="form-control pcls" maxlength="10" required onfocusout="addMargin3(prodMargina'+x+')"/> </fieldset> </div> <div class="col-xl-2 col-lg-3 col-md-12 mb-1"> <fieldset class="form-group"> <div class="fileinput fileinput-new text-center" data-provides="fileinput"> <div class="fileinput-new thumbnail"> <img width="100%" height="100%" src="" /> </div> <div class="fileinput-preview fileinput-exists thumbnail"> </div> <div> <span class="btn btn-rose btn-round btn-file"> <span class="fileinput-new"><?php echo $this->lang->line("Select image");?> </span> <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span> <input type="file" name="prod_var_img[]" multiple></span><a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a></div></div></fieldset></div>'; //New input field html
        
            fieldHTML = fieldHTML + fieldHTML1 + '<a href="javascript:void(0);" class="remove_button text-25 margin-5 margin-top-5" title="Remove field"><!--<img src="remove-icon.png"/>--><i class="fa fa-window-close-o danger"></i> </a></fieldset></div>';
       
        $(wrapper).append(fieldHTML);
   }
    
   function update_price(price_id,tax_id,pro_price_id) {
       // alert('connecttes');
       var projected_price   = parseFloat($('#'+price_id).val()) + ( (parseFloat($('#'+price_id).val()) *  parseFloat($('#'+tax_id).val()))/100 );
        $('#'+pro_price_id).val(projected_price);
   }
   function optfield(field){
    // alert(field);
    if(field==5 || field==6 || field==7)
    {
        $('.optional').show();
    }
    else{
        $('.optional').hide();
    }

	$.ajax({
		type: "post",
		url: "<?=base_url()?>admin/get_pro_attr/"+field,
		dataType: "json",
		success: function (response) {
			if(response.status == 1){
				var parent= $('#parent').val()
				$('#parent').html(response.data.category)
				$('#parent').val(parent)
				$('.use_for_attr').html(response.data.use_for_attr)
				$('.color_attr').html(response.data.color_attr)
				$('.size_attr').html(response.data.size_attr)
				$('.material_attr').html(response.data.material_attr)
				
			}
		}
	});	
	
}

$(document).ready(function() {
	optfield($('#optional_fields').val())
	
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter("#result");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
$(".remove").click(function(){
    $(this).parent(".pip").remove();
  });
$('#pablos').click(function(){
    $(".pip").remove();
});
</script>
<script>
	initSample();
</script>
</html>