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
                    <div class="row">
                        <div class="col-md-12">
                            
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <div class="" style="margin-bottom:15px;">
                                    <h4 class="card-title" style="display: inline-block;"><?php echo $this->lang->line("Wish List");?></h4>
<!--
                                    <a class="pull-right btn btn-primary" style="" href="<?php echo site_url("admin/addbrand"); ?>">
                                        <?php echo $this->lang->line("ADD");?>
                                    </a>
-->
                                    </div>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables custom-datatable">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Sr. No.");?></th>
                                                    <th><?php echo $this->lang->line("Product Id");?></th>
                                                    <th><?php echo $this->lang->line("Product Image");?></th>
                                                    <th><?php echo $this->lang->line("Product Name");?></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Sr. No.");?></th>
                                                    <th><?php echo $this->lang->line("Product Id");?></th>
                                                    <th><?php echo $this->lang->line("Product Image");?></th>
                                                    <th><?php echo $this->lang->line("Product Name");?></th>
                                                    
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                    if(!empty($allwishlist))
                                                    {
                                                        $sr_no = 1;
                                                        foreach(@$allwishlist as $wishlist){ 
                                                            $pro1               = explode(',',$wishlist->product_image);
                                                            $product_image      = base_url().'uploads/products/'. $pro1[0];
                                                            $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$wishlist->product_id."'");
                                                            $variants_pro       = $q_variants->result_array();
                                                            if(!empty($variants_pro[0]['pro_var_images'])){
                                                                $product_image  = base_url().'uploads/products/'.$variants_pro[0]['pro_var_images'];
                                                            }
                                                    
                                                
                                                ?>
                                                <tr>

                                                    <td ><?php echo $sr_no; ?></td>
                                                    <td><?php echo $wishlist->id; ?></td>
                                                    <td><?php if(!empty(@$product_image)){ ?><div class="cat-img" style="width: 50px; height: 50px;"><img width="100%" height="100%" src="<?php echo $product_image; ?>" /></div> <?php } ?></td>
                                                    <td><?php echo $wishlist->product_name; ?></td>
                                                    

                                                </tr>
                                                <?php 
                                                        $sr_no++;}
                                                    }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
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

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/bootstrap-notify.min.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
    
    $(document).on('click','#homepage', function(){
        var homepage    =   $(this).val();
        if(homepage !=''){
            $.ajax({
            		type: "post",
            		url: "<?=base_url()?>admin/homepage_list",
            		data: {homepage:homepage},
            		dataType: "json",
            		success: function (response) {
            		    if(response.status == 1){
            		        var datamessage     =   '';
            		        if(response.data == 1){
            		            datamessage     =   "Category added on home page successfully";  
            		        }
            		        else{
            		            datamessage     =   "Category removed on home page successfully";
            		        }
            		        $.notify({
                            	message: datamessage
                            },{
                            	type: 'success',
                            	placement: {
                            		from: "bottom",
                            		align: "right"
                            	},
                            });
            		    }
            		    else{
            		        $.notify({
                            	message: 'Please Try Again'
                            },{
                            	type: 'error',
                            	placement: {
                            		from: "bottom",
                            		align: "right"
                            	},
                            });
            		    }
            		}
                });
        }
         
    })
    
</script>

</html>