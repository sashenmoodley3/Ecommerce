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
                                
                            <div class="col-md-6">
                                <?php  $q = $this->db->query("Select * from mail_template WHERE  type = 1 AND status = 1 ")->row();
                                      
                                       ?>
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select class="form-control" name="type1" id="type">
                                                <option value="">--Choose--</option>
                                                    <?php foreach($type as $k=>$v){ ?>
                                                        <option <?php  if($k == '1') { echo "selected"; } ?>  value="<?=$k?>"><?=$v?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo "Description";?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description1" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q)) { echo $q->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                
                            <div class="col-md-6">
                                <?php  $q2 = $this->db->query("Select * from mail_template WHERE  type = 2 AND status = 1 ")->row();?>
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select class="form-control" name="type2" id="type">
                                                <option value="">--Choose--</option>
                                                    <?php foreach($type as $k=>$v){ ?>
                                                        <option <?php if($k == '2') { echo "selected"; } ?>  value="<?=$k?>"><?=$v?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo "Description";?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description2" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q2)) { echo $q2->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                
                            <div class="col-md-6">
                                <?php  $q3 = $this->db->query("Select * from mail_template WHERE  type = 3 AND status = 1 ")->row();?>
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select class="form-control" name="type3" id="type">
                                                <option value="">--Choose--</option>
                                                    <?php foreach($type as $k=>$v){ ?>
                                                        <option <?php if($k == '3') { echo "selected"; }?>  value="<?=$k?>"><?=$v?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo "Description";?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description3" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q3)) { echo $q3->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                
                            <div class="col-md-6">
                                <?php  $q4 = $this->db->query("Select * from mail_template WHERE  type = 4 AND status = 1")->row();?>
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select class="form-control" name="type4" id="type">
                                                <option value="">--Choose--</option>
                                                    <?php foreach($type as $k=>$v){ ?>
                                                        <option <?php if($k == '4') { echo "selected"; } ?>  value="<?=$k?>"><?=$v?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo "Description";?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description4" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q4)) { echo $q4->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                                
                            <div class="col-md-6">
                                <?php  $q5 = $this->db->query("Select * from mail_template WHERE  type = 5 AND status = 1 ")->row();?>
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select class="form-control" name="type5" id="type">
                                                <option value="">--Choose--</option>
                                                    <?php foreach($type as $k=>$v){ ?>
                                                        <option <?php if($k == '5') { echo "selected"; } ?>  value="<?=$k?>"><?=$v?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo "Description";?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description5" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q5)) { echo $q5->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                                
                            <div class="col-md-6">
                                <?php  $q6 = $this->db->query("Select * from mail_template WHERE  type = 6 AND status = 1")->row();?>
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select class="form-control" name="type6" id="type">
                                                <option value="">--Choose--</option>
                                                    <?php foreach($type as $k=>$v){ ?>
                                                        <option <?php  if($k == '6') { echo "selected"; } ?>  value="<?=$k?>"><?=$v?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo "Description";?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description6" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q6)) { echo $q6->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                                
                            <div class="col-md-6">
                                <?php  $q7 = $this->db->query("Select * from mail_template WHERE  type = 7 AND status = 1")->row();?>
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select class="form-control" name="type7" id="type">
                                                <option value="">--Choose--</option>
                                                    <?php foreach($type as $k=>$v){ ?>
                                                        <option <?php  if($k == '7') { echo "selected"; } ?>  value="<?=$k?>"><?=$v?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo "Description";?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description7" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q7)) { echo $q7->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                                
                            <div class="col-md-6">
                                <?php  $q8 = $this->db->query("Select * from mail_template WHERE  type = 8 AND status = 1")->row();?>
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select class="form-control" name="type8" id="type">
                                                <option value="">--Choose--</option>
                                                    <?php foreach($type as $k=>$v){ ?>
                                                        <option <?php  if($k == '8') { echo "selected"; } ?>  value="<?=$k?>"><?=$v?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo "Description";?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description8" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>">  <?php if(!empty($q8)) { echo $q8->description; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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