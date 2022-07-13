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
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            <?php if($this->session->userdata('language') == "arabic"){ ?>
                        <div class="col-md-3">
                        </div>
                        <?php } ?>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Edit Categories");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3"><?php echo $this->lang->line("Categories Title");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="cat_title" class="form-control" value="<?php echo $getcat->title; ?>"/>
                                                    <input type="hidden" name="cat_id" class="form-control" placeholder="Categories id" value="<?php echo $getcat->id; ?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" <?= $setting ?> >
                                            <label class="col-md-3"><?php echo $this->lang->line("Arabic Categories Title");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="arb_cat_title" class="form-control" value="<?php echo $getcat->arb_title; ?>"/>
                                                    <input type="hidden" name="cat_id" class="form-control" placeholder="Categories id" value="<?php echo $getcat->id; ?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
										<div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Category Type");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select id="product_cat_type" onchange="optional_field(this.value)" class="text-input form-control" name="product_cat_type" required>
                                                        <option value=""><?php echo $this->lang->line("Select Product Category Type");?></option>
                                                        <?php
                                                            $q = $this->db->query("SELECT a.* FROM `product_cat_type` a  WHERE a.`status`=1");
                                                            $rows = $q->result();
                                                        //print_r($rows);
                                                            if(count($rows)>0)
                                                            {
                                                                foreach($rows as $row){
                                                        ?>
                                                        <option value="<?php echo $row->product_cat_type_id; ?>" <?php if(isset($_POST["product_cat_type"]) && $_POST["product_cat_type"]==$row->product_cat_type_id){echo "selected"; }elseif(isset($getcat->product_cat_type_id) && $getcat->product_cat_type_id==$row->product_cat_type_id){echo "selected"; } ?> ><?php echo $row->title; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"> <?php echo $this->lang->line("Parent Category");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="form-control"  name="parent" id="parent">
                                                        <option value="0"> <?php echo $this->lang->line("Select Category"); ?></option>
                                                <?php  
                                                    echo printCategory(0,0,$this,$getcat);
                                                    function printCategory($parent,$leval,$th,$getcat){
														$type_id = !empty($getcat->product_cat_type_id)? $getcat->product_cat_type_id : '0';
														$q = $th->db->query("SELECT a.*, IFNULL(Deriv1.count, 0) AS count FROM `categories` a  LEFT JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`parent`=" . $parent." AND a.`product_cat_type_id`=" . $type_id);
														$rows = $q->result();
								
														foreach($rows as $row){
															if ($row->count > 0) {
																	printRow($row,$getcat);
																	printCategory($row->id, $leval + 1,$th,$getcat);
																	// print_r($row);
															}
															elseif ($row->count == 0) {
																printRow($row,$getcat);
																// print_r($row);
															}
														}
                            
                                                    }
                                                    function printRow($d,$getcat){
                                                        
                                                   // foreach($data as $d){
                                                    
                                                    ?>
                                                     <option value="<?php echo $d->id; ?>" <?php if($getcat->parent == $d->id){ echo 'selected=""';} ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                        
                                                     <?php } ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Categories icon");?> </label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <?php 
                                                        $filename   =   FCPATH.'/uploads/category/'.$getcat->image;
                                                        if(file_exists($filename) && !empty($getcat->image)){
                                                            echo '<img width="100%" height="100%" src="'.$this->config->item('base_url').'/uploads/category/'.$getcat->image.'" />';
                                                        }
                                                        else{
                                                             echo '<img width="100%" height="100%" src="'.$this->config->item('base_url').'new_theme/assets/img/3b93b61b.png" />';
                                                        } ?>
                                                        
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="cat_img">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                    <input type="radio" name="cat_status" value="0" <?php if($getcat->status == 0){ echo 'checked'; } ?> class="col-md-3"/>
                                                    <label class="col-md-6"><?php echo $this->lang->line("Deactive");?></label>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                    <input type="radio" name="cat_status" value="1" <?php if($getcat->status != 0){ echo 'checked'; } ?> class="col-md-3"/>
                                                    <label class="col-md-6"><?php echo $this->lang->line("Active");?></label>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="savecat" value="<?php echo $this->lang->line("Save Category");?>">
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
<script>

$(document).on('change', '#product_cat_type', function(){
	var product_cat_type = $(this).val();
	$.ajax({
		type: "post",
		url: "<?=base_url()?>admin/get_category_by_type/"+product_cat_type,
		dataType: "json",
		success: function (response) {
			if(response.status == 1){
				$('#parent').html(response.data)
				
			}
		}
	});	
})
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