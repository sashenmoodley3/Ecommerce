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
                    <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('success_req'); 
                    ?>
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="purple">
                                        <i class="material-icons">settings</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Currency Setting"); ?></h4>
                                        <div class="toolbar">
                                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                                        </div>
                                        
                                        <div class="material-datatables">
                                            <table class="table" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><?php echo $this->lang->line("ID"); ?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Country");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Currency");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("1 Doller");?></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-center"><?php echo $this->lang->line("ID"); ?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Country");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Currency");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("1 Doller");?></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php foreach($setting as $set){   
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $set->id; ?></td>
                                                            <td class="text-center"><?php echo $set->country; ?></td>
                                                            <td class="text-center"><?php echo $set->code.' - '.$set->symbol; ?></td>
                                                            <td class="text-center"><input type="text" name="currency[<?php echo $set->id; ?>]"  value="<?=$set->current_amount; ?>"></td>  
                                                            
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group form-button" style="text-align:center">
                                        <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="<?php echo $this->lang->line("Update");?>" />
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
  $('#datatables').DataTable();
</script>

</html>