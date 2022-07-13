<?php  $this->load->view("admin/common/head"); ?>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">coin</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"> Detail</h4>
                                    <?php foreach($ads->result() as $ads){ ?>
                                    <form class="form-horizontal" action="" method="post">
                                        <div class="row">
                                            <label class="col-md-2 label-on-left">Name</label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input name="name" value="<?php echo $ads->name; ?>" readonly type="text" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row">
                                            <label class="col-md-2 label-on-left">URL</label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input name="ads_url" value="<?php echo $ads->ads_url; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row">
                                            <label class="col-md-2 label-on-left">Content</label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input name="ads_content" value="<?php echo $ads->ads_content; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-2 label-on-left">Status</label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                     <input type="checkbox" name="status" <?php if($ads->status==1)echo "checked";?> style="    margin-top: 17px;"> 
                                                </div>
                                            </div>
                                            
                                           
                                            
                                        </div>
                                        <div class="row">
                                            <label class="col-md-2"></label>
                                            <div class="col-md-8">
                                                <div class="form-group form-button">
                                                    <button name="pp" type="submit" class="btn btn-fill btn-rose">SAVE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
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
</html>