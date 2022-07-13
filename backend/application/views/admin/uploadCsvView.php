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
                        <form action="<?php echo site_url();?>/admin/uploadData" method="post" enctype="multipart/form-data" name="form1" id="form1" class="form-horizontal" >
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Product</h4>
                                    <a class="pull-right" href="<?php echo base_url();?>/uploads/tableName.xlsx" style="margin:  0px 10px;padding: 0px 10px;border: 1px solid;">Sample Sheet &nbsp; <i class="fa fa-thumb-tack"> </i> </a>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Choose your .xlsx file:</label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="" alt="">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new">Select .xlsx File</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="userfile" required="" />
                                                    <div class="ripple-container"></div></span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <button  type="submit" class="btn btn-fill btn-rose" name="submit">Save</button>
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