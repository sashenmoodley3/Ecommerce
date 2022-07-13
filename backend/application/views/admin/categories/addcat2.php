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
                                    <h4 class="card-title"><?php echo $this->lang->line("Add Categories");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 "><?php echo $this->lang->line("Categories Title");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="cat_title" placeholder="Categories Title" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" <?= $setting ?> >
                                            <label class="col-md-3 "><?php echo $this->lang->line("Arabic Categories Title");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="arb_cat_title" placeholder="Categories Title" class="form-control" />
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
                                                        <option value="<?php echo $row->product_cat_type_id; ?>" <?php if(isset($_POST["product_cat_type"]) && $_POST["product_cat_type"]==$row->product_cat_type_id){echo "selected"; } ?> ><?php echo $row->title; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Parent Category");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control" name="parent" id="parent">
                                                        <option value="0"> <?php echo $this->lang->line("Select Category"); ?></option>
                                                        
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Category Icon");?>:</label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img src="<?=base_url()?>new_theme/assets/img/3b93b61b.png" alt="Selected Image">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" name="cat_img">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i><?php echo $this->lang->line("Remove");?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" name="cat_status" value="1" class="col-md-3" checked/><label class="col-md-6"><?php echo $this->lang->line("Active");?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" name="cat_status" value="0" class="col-md-3" /><label class="col-md-6"><?php echo $this->lang->line("Deactive");?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="<?php echo $this->lang->line("Add Category");?>">
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