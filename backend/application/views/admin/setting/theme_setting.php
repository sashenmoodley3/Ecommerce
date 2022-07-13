<?php  $this->load->view("admin/common/head"); ?>
    <link href="//cdnjs.cloudflare.com/ajax/libs/octicons/3.5.0/octicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap-color.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/color.css"); ?>" rel="stylesheet">

<body>
    <div class="wrapper">
        <!--sider -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        
        <div class="main-panel">
            <!--head -->
            <?php  $this->load->view("admin/common/header"); ?>
            <!--content -->
            <div class="content">
                <div class="container-fluid">
					<div class="msg"></div>
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal"  id="form1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="purple">
                                        <i class="material-icons">settings</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->config->item("title");?></h4>
                                        <div class="toolbar">
                                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                                        </div>
                                        
                                        <div class="material-datatables">
                                            <table class="table" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><?php echo $this->lang->line("ID"); ?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Title");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Type");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Value");?></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-center"><?php echo $this->lang->line("ID"); ?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Title");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Type");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Value");?></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php foreach($settings as $set){   
                                                        $hash   =   substr($set->meta_value,0,1);
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $set->id; ?></td>
                                                            <td class="text-center"><?php echo $set->meta_key; ?></td>
                                                            <td class="text-center"><?php echo $set->meta_type; ?></td>
                                                            <td class="text-center"><input type="text" <?=$hash =='#' ? 'class="simple-color-picker"' : 'class="'.$set->meta_key.'"';?> name="setting[<?php echo $set->meta_key; ?>]" 
                                                            value="<?=$set->meta_value; ?>"></td>  
                                                            
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group form-button" style="text-align:center">
                                        <input type="submit" class="btn btn-fill btn-rose edit-curd" name="addcatg" value="<?php echo $this->lang->line("Update");?>" />
                                    </div>
                                    <!-- end content-->
                                </div>
                                <!--  end card  -->
                            </div>
                            <!-- end col-md-12 -->
                        </div>
                    </form>
                    <!-- end row -->
                </div>
            </div>
            <!--footer -->
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>

<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/color.js"); ?>"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script>
  $(function () {
      $('.simple-color-picker').colorpicker();
  });
</script>

</html>