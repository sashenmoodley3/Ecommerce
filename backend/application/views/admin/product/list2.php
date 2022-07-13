<?php  $this->load->view("admin/common/head"); ?>
<link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet" />   
<style>
        .border-dark{
            padding: 10px 0px 0px 0px;
            border-top:1px #ccc solid;
            border-bottom:1px #ccc solid;
        }
</style>
</head>

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
                        echo $this->session->flashdata('message'); 
                    ?>
                    <div class="msg"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <div class="" style="margin-bottom:15px;">
                                        <h4 class="card-title" style="display: inline-block;"><?php echo $this->lang->line("All Products");?></h4>
                                        <a class="pull-right btn btn-primary" href="<?php echo site_url("admin/add_products"); ?>"><?php echo $this->lang->line("ADD");?></a>
                                        <a class="pull-right btn btn-primary" href="<?php echo site_url("admin/csv"); ?>" ><?php echo $this->lang->line("BULK UPLOAD");?></a>
                                        <!--<a href="<?php echo site_url("admin/csv"); ?>">CSV</a>-->
                                        
                                        <!--<div class="col-md-4">-->
                                        <!--    <div class="form-group label-floating is-empty">-->
                                        <!--        <select class="text-input form-control" name="company[<?=$tag_currency?>]">-->
                                        <!--            <option value=""><?php echo $this->lang->line("Select Currency");?></option>-->
                                                    
                                        <!--            </option>-->
                                        <!--        </select>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        
                                        
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
        						                <table id="datatable" class="table table-border table-striped custom-table datatable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line("ID");?></th>
                                                            <th><?php echo $this->lang->line("product title");?></th>
                                                            <th><?php echo $this->lang->line("cat title");?></th>
                                                            <th><?php echo $this->lang->line("Product Category Name");?></th>
                                                            <th><?php echo $this->lang->line("Brand");?></th>
                                                            <th><?php echo $this->lang->line("Product Description");?></th>
                                                            <th><?php echo $this->lang->line("Status");?></th>
                                                            <th><?php echo $this->lang->line("Action");?></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th><?php echo $this->lang->line("ID");?></th>
                                                            <th><?php echo $this->lang->line("product title");?></th>
                                                            <th><?php echo $this->lang->line("cat title");?></th>
                                                            <th><?php echo $this->lang->line("Product Category Name");?></th>
                                                            <th><?php echo $this->lang->line("Brand");?></th>
                                                            <th><?php echo $this->lang->line("Product Description");?></th>
                                                            <th><?php echo $this->lang->line("Status");?></th>
                                                            <th><?php echo $this->lang->line("Action");?></th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
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

<div id="products_action" class="modal fade delete-modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="<?=base_url()?>assets/img/sent.png" alt="" width="50" height="46">
                <h3>Are you sure want to perform this action ?</h3>
                <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                    <a id="href_value" href="#"  class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var table;
    $(document).ready(function() {
       	
       table = $('#datatable').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/fetchproducts')?>",
				"type": "GET",
				"data": function ( data ) {
					// data.country = $('#country').val();
					// data.FirstName = $('#FirstName').val();
					// data.LastName = $('#LastName').val();
					// data.address = $('#address').val();
				}
			},

			//Set column definition initialisation properties.
			"columnDefs": [
				{
					"targets": [ 0,5 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
			],
			
			"pageLength": 100,
              "lengthMenu": [ [100, 500, 1000, -1], [100, 500, 1000, "All"] ],
            
           
		});
	    
	   
    });
    
       // Bulk Clicking on Table Checkboxes
    $("#bulk_action_checkbox").on("click", function(e){
    	check_status = this.checked;
        $(".bulk_action_checkbox_individual").each( function(){
            $(this).prop("checked",check_status);
        });
    });
    
    
    
</script>

</html>