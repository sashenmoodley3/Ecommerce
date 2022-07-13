<?php  $this->load->view("admin/common/head"); ?>
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
                        <form form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            <?php if($this->session->userdata('language') == "arabic")
                                {
                                ?>
                                <div class="col-md-6">
                                </div>
                                <?php
                                }
                                ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">message</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Notification");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Title");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="title" id="title" required class="input form-control" placeholder="<?php echo $this->lang->line("Place some text here");?>">
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Image Url");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="url" name="image_url" id="image_url" class="input form-control" required>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Notification");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <textarea name="descri" class="textarea" required placeholder=" <?php echo $this->lang->line("Place some text here");?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="<?php echo $this->lang->line("Send");?>" />
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