<?php  $this->load->view("admin/common/head"); ?>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php  
						// if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('message'); 
                    ?>
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal"  id="form1" name="form1">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <?php
                                    echo $this->session->flashdata('success_req'); ?>
                                    <div class="msg"></div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Edit Image");?></h4>
                                        
									<div class="row">
										<label class="col-md-3 label-on-left"><?php echo $this->lang->line("Image");?>(<?=$this->config->item('images_file_size')/1024 ?>KB): *</label>
										<div class="col-md-9">
											<legend></legend>
											<div class="fileinput fileinput-new text-center" data-provides="fileinput">
												<div class="fileinput-new thumbnail">
													<img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'/uploads/images/'.$row->image ?>">
												</div>
													<div class="fileinput-preview fileinput-exists thumbnail"></div>
												<div>
													<span class="btn btn-rose btn-round btn-file">
														<span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
														<span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
														<input type="file" name="image" >
														<div class="ripple-container"></div>
													</span>
													<a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i><?php echo $this->lang->line("Remove"); ?></a>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<label class="col-md-3"></label>
										<div class="col-md-9">
											<div class="form-group form-button">
												<input type="submit" name="saveimage" value="<?php echo $this->lang->line("Update Image");?>" class="btn btn-fill btn-rose edit-curd" >                                                </div>
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