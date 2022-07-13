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
            <?php  $q = $this->db->query("Select * from seo_setting where id = 1 ")->row();  ?>
            <div class="content">
                <div class="container-fluid">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Title");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                           <input type="text" name="title" class="form-control" value="<?php if(!empty($q)) { echo $q->title; } ?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Keywords");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                           <input type="text" name="keywords" class="form-control" value="<?php if(!empty($q)) { echo $q->keywords; } ?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Description");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q)) { echo $q->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("AMP code");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="amp" id="amp" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q)) { echo $q->amp; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Microformats");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="microformats" id="microformats" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q)) { echo $q->microformats; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row">-->
                        <!--    <div class="col-md-12">-->
                        <!--        <div class="card">-->
                        <!--            <div class="card-header card-header-icon" data-background-color="rose">-->
                        <!--                <i class="material-icons">library_books</i>-->
                        <!--            </div>-->
                        <!--            <div class="card-content">-->
                        <!--                <h4 class="card-title"><?php echo $this->lang->line("Schema");?></h4>-->
                        <!--                <div class="form-group">-->
                        <!--                    <label class="label-control"></label>-->
                        <!--                    <textarea name="schema_data" id="schema_data" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q)) { echo $q->schema_data; } ?></textarea>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                       
                       
                        
                        
                        <div class="row">
                                <label class="col-md-4"></label>
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