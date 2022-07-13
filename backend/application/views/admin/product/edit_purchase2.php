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
                    <div class="row">
                        <form id="edit2" form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
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
                                                    <input type="text" name="prod_title" class="form-control" readonly
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
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Select Product Category Type");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select id="optional_fields" onchange="optional_field(this.value)" class="text-input form-control" name="product_cat_type" required>
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
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Parent Category :");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select disabled class="text-input form-control" name="parent">
                                                        <option value=""><?php echo $this->lang->line("Select Category");?></option>
                                                         <?php  
                                                            echo printCategory(0,0,$this,$product);
                                                            function printCategory($parent,$leval,$th,$product){
                                                            
                                                            $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`status`=1 and a.`parent`=" . $parent);
                                                            $rows = $q->result();
                                    
                                                            foreach($rows as $row){
                                                                if ($row->count > 0) {
                                                                        
                                                                            //print_r($row) ;
                                                                            //echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                            printRow($row,$product,true);
                                                                            printCategory($row->id, $leval + 1,$th,$product);
                                                                            
                                                                        } elseif ($row->count == 0) {
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
                                      <hr>
                                        <?php     
                                            $pro_cat_type1 = $product->product_cat_type_id;
                                            $disp = "";
                                            if($pro_cat_type1==126 || $pro_cat_type1==127 || $pro_cat_type1==128){ $disp = "block"; }else{ $disp = "none";} 
                                        ?>
                                    
                                        <?php  if(!empty($purchase)){
                                                // $price          = explode(',',$purchase->price);
                                                // $qty            = explode(',',$purchase->qty);
                                                // $unit           = explode(',',$purchase->unit);
                                                // $stock_inv      = explode(',',$purchase->stock_inv);
                                                // $tax            = explode(',',$purchase->tax);
                                                // $mrp            = explode(',',$purchase->mrp);
                                               
                                                //$price_number = count($price);
                                                $i=1;
                                        foreach($purchase as $k=>$value){ 
                                                $varient_id     = $value->varient_id;  
                                                $price          = $value->price;
                                                $qty            = $value->qty;
                                                $unit           = $value->unit;
                                                $stock_inv      = $value->stock_inv;
                                                $tax            = $value->tax;
                                                $mrp            = $value->mrp;
                                                $var_use_for            = $value->var_use_for; 
                                                $var_size            = $value->var_size; 
                                                $var_color            = $value->var_color; 
                                                $var_material            = $value->var_material; 
                                                
                                            ?>
                                            <div class="">
                                                <div class="row">
                                                  <input type="hidden" name="varient_id[]" value="<?=$varient_id?>">
<!--
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1" >
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Sr. No.')?> </label>
                                                            <?=$i;?>
                                                        </fieldset>
                                                    </div>
-->
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:<?=$disp;?>">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Use For')?> </label>
                                                            <select class="text-input form-control" name="var_use_for[]">
                                                        <option value=""><?php echo $this->lang->line("Select Use For");?></option>
                                                        <?php
                                                            $q1 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=4");
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
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:<?=$disp;?>">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Color')?> </label>
                                                            <select class="text-input form-control" name="var_color[]">
                                                        <option value=""><?php echo $this->lang->line("Select Color");?></option>
                                                        <?php
                                                            $q2 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=1");
                                                            $rows2 = $q2->result();
                                                        //print_r($rows);
                                                            if(count($rows2)>0)
                                                            {
                                                                foreach($rows2 as $row){
                                                        ?>
                                                        <option value="<?php echo $row->attribute_value_id; ?>" <?php if($var_color == $row->attribute_value_id){ echo "selected"; } ?>><?php echo $row->attribute_value; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:<?=$disp;?>">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Size')?> </label>
                                                            <select class="text-input form-control" name="var_size[]">
                                                        <option value=""><?php echo $this->lang->line("Select Size");?></option>
                                                        <?php
                                                            $q3 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=2");
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
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1 optional" style="display:<?=$disp;?>">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?=$this->lang->line('Material')?> </label>
                                                            <select class="text-input form-control" name="var_material[]">
                                                        <option value=""><?php echo $this->lang->line("Select Material");?></option>
                                                        <?php
                                                            $q4 = $this->db->query("SELECT a.* FROM `attribute_values` a  WHERE a.`attribute_value_status`=1 and a.`attribute_value_deleted`=0 and a.`attribute_id`=3");
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
                                                            <label for="basicInput"><?php echo $this->lang->line("Quantity");?> <span class="required">*</span></label>
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
                                                                            
                                                            </select>
                                                            
                                                        </fieldset>

                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?php echo $this->lang->line("Stock");?> <span class="required">*</span></label>
                                                            <input type="text" name="stock[]" value="<?=$stock_inv?>" placeholder="Stock"
                                                                   class="form-control" maxlength="5" required readonly/>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput"><?php echo $this->lang->line("New Stock");?> <span class="required">*</span></label>
                                                            <input type="text" name="newstock[]" value="0" placeholder="New Stock"
                                                                   class="form-control" maxlength="5" required/>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Original Price<span class="required">*</span></label>
                                                            <input type="text" name="mrp[]" placeholder="MRP" value="<?=$mrp?>" readonly
                                                                   class="form-control pcls" required/>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-12 mb-1">
                                                        <fieldset class="form-group">
                                                            <label for="basicInput">Sell Price<span class="required">*</span></label>
                                                            <input type="text" name="price[]" placeholder="dSale Price" value="<?=$price?>" class="form-control pcls"  readonly required/>
                                                            
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <!-- <div class="col-xl-2 col-lg-3 col-md-12 mb-1">-->
                                                    <!--    <fieldset class="form-group">-->
                                                    <!--        <label for="basicInput">Tax<span class="required">*</span></label>-->
                                                    <!--        <input type="text" name="tax[]" id="tax" required class="form-control" value="<?=$tax?>"  placeholder="00.00" />-->
                                                    <!--    </fieldset>-->
                                                        
                                                    <!--</div>-->
                                                </div>

                                            </div>
                                        <?php 
                                        $i++;
                                        }?> 
                                        <?php } ?>
                                            
                                            
                                        <input type="hidden" name="rewards" class="form-control" value="<?php echo $product->rewards; ?>"  placeholder="00"/>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="<?php echo $this->lang->line("Update Product");?>">
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

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
    
</script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
   
   <script>
   $(document).ready(function() {
       
       
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
        
            var fieldHTML = '<div class="row "><div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">Quantity<span class="required">*</span></label> <input type="text" name="quantity[]" placeholder="Quantity" class="form-control" maxlength="5" required/></fieldset></div><div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">Unit<span class="required">*</span></label><select class="custom-select form-control" name="unit[]"><option value=""> Select </option><option value="ML">ML</option> <option value="LTR">LTR</option><option value="GM">GM</option><option value="KG">KG</option></select></fieldset></div><div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">Stock<span class="required">*</span></label><input type="text" name="stock[]" placeholder="Stock" class="form-control" maxlength="5" required/></fieldset></div>';
            
            
            var fieldHTML1 = '<div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">MRP<span class="required">*</span></label><input type="text" name="mrp[]" placeholder="MRP"class="form-control pcls" maxlength="4" required/></fieldset></div><div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">Sale Price<span class="required">*</span></label><input type="text" name="price[]" placeholder="Saale Price"class="form-control pcls" maxlength="4" required/></fieldset></div><div class="col-xl-2 col-lg-3 col-md-12 mb-1"><fieldset class="form-group"><label for="basicInput">Tax<span class="required">*</span></label><input type="text" name="tax[]" id="tax" required class="form-control" placeholder="00.00" /></fieldset></div>'; //New input field html

        
           
            fieldHTML = fieldHTML + fieldHTML1 + '<a href="javascript:void(0);" class="remove_button text-25 margin-5 margin-top-5" title="Remove field"><!--<img src="remove-icon.png"/>--><i class="fa fa-window-close-o danger"></i> </a></fieldset></div>';
       

            var x = 1; //Initial field counter is 1
            $(addButton).click(function () { //Once add button is clicked
                if (x < maxField) { //Check maximum number of input fields
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); // Add field html
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


       $("#edit2").validate({
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
   function update_price(price_id,tax_id,pro_price_id) {
       // alert('connecttes');
       var projected_price   = parseFloat($('#'+price_id).val()) + ( (parseFloat($('#'+price_id).val()) *  parseFloat($('#'+tax_id).val()))/100 );
        $('#'+pro_price_id).val(projected_price);
   }
</script>
<script>
	initSample();
</script>
</html>