<?php  $this->load->view("admin/common/head"); ?>
<style>
    .custom-datatable .col-sm-6:nth-child(2) .dataTables_filter label.form-group{
        display:block;
    }
    .custom-datatable .col-sm-6:nth-child(2) .dataTables_filter label.form-group input{
        display:block;
        width:100%;
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
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                       
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Name");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <input type="text" name="name" class="form-control " value="<?php echo (!empty($details) &&  $details->name != "" ) ?  $details->name :  ""; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("gstin");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <input type="text" name="gstin" class="form-control" value="<?php echo (!empty($details) && $details->gstin != "") ?  $details->gstin  :  ""; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">av_timer</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("address");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <input type="text" name="address" class="form-control" value="<?php echo (!empty($details) && $details->address != "") ?  $details->address  :  ""; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">av_timer</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("mobile");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <input type="number" name="mobile" class="form-control"  value="<?php echo (!empty($details) && $details->mobile != "") ?  $details->mobile  :  ""; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">av_timer</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("email");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <input type="email" name="email" class="form-control" value="<?php echo (!empty($details) && $details->email != "") ?  $details->email  :  ""; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">av_timer</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("taxslab");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <input type="number" name="tax_slab" class="form-control" value="<?php echo (!empty($details) && $details->tax_slab != "") ?  $details->tax_slab  :  ""; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("logo");?>:</label>
                            <div class="col-md-9">
                                <legend></legend>
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img width="100%" height="100%" src="<?= base_url('uploads/company/'.$details->logo); ?>" />
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-rose btn-round btn-file">
                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                            <input type="file" name="logo">
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                                <label class="col-md-3"></label>
                                <div class="col-md-9">
                                    <div class="form-group form-button">
                                        <input type="submit" name="savecat" value="<?php echo $this->lang->line("Save");?>" class="btn btn-fill btn-rose" />
                                    </div>
                                </div>
                            </div>
                    </form>
                   
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