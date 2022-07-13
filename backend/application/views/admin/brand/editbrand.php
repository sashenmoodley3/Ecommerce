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
                                    <h4 class="card-title"><?php echo $this->lang->line("Edit Brand");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3"><?php echo $this->lang->line("Brand Title");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="brand_title" class="form-control" value="<?php echo $getcat->title; ?>"/>
                                                    <input type="hidden" name="brand_id" class="form-control" placeholder="Brand id" value="<?php echo $getcat->id; ?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Brand Icon");?> </label>
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
                                                            <input type="file" name="brand_img">
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
                                                    <input type="radio" name="brand_status" value="0" <?php if($getcat->status == 0){ echo 'checked'; } ?> class="col-md-3"/>
                                                    <label class="col-md-6"><?php echo $this->lang->line("Deactive");?></label>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                    <input type="radio" name="brand_status" value="1" <?php if($getcat->status != 0){ echo 'checked'; } ?> class="col-md-3"/>
                                                    <label class="col-md-6"><?php echo $this->lang->line("Active");?></label>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="savebrand" value="<?php echo $this->lang->line("Save Brand");?>">
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
</html>