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
                    <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">money</i>
                                </div>
                                 <?php foreach($razor->result() as $razor){ ?>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $razor->gateway_name; ?> Detail</h4>
                                   
                                    <form class="form-horizontal" action="" method="post">
                                        <div class="row">
                                            <label class="col-md-2 label-on-left">API KEY</label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="hidden" value="<?php echo $razor->id; ?>" name="id">
                                                    <input name="api_key" value="<?php echo $razor->api_key; ?>" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-2 label-on-left">MERCHANT ID</label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input name="marchecnt_id" value="<?php echo $razor->marchecnt_id; ?>" type="text" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-2 label-on-left">MERCHANT KEY</label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input name="marchent_key" value="<?php echo $razor->marchent_key; ?>" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-2 label-on-left">GATEWAY URL</label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input name="gateway_url" value="<?php echo $razor->gateway_url; ?>" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-2"></label>
                                            <div class="col-md-8" style="margin-top:  20px;">
                                                <div class="checkbox form-horizontal-checkbox">
                                                    <label>
                                                        <input type="checkbox" name="status" <?php if($razor->status==1)echo "checked";?>> STATUS
                                                    </label>
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
                                   
                                </div> <?php } ?>
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