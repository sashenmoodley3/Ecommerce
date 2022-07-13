<?php  $this->load->view("admin/common/head"); ?>
<link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet" />
    <style>
        .border-dark{
            padding: 10px 0px 0px 0px;
            border-top:1px #ccc solid;
            border-bottom:1px #ccc solid;
        }
        table.custom-table > thead > tr > th{
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }
        .mybtn{text-align:center;}
        .mybtn .dt-buttons>button{
    	webkit-user-select: none;
    	-moz-user-select: none;
    	-ms-user-select: none;
    	user-select: none;
    	position: relative;
    	border: 0;
    	border-radius: 3px;
    	padding: 6px;
    	font-weight: 400;
    	color: #ffffff;
    	font-style: inherit;
    	font-variant: inherit;
    	font-size: inherit;
    	font-family: inherit;
    	line-height: inherit;
    	box-shadow: 0 2px 5px 0 rgba(0,0,0,.26);
    	transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),-webkit-transform .4s cubic-bezier(.25,.8,.25,1);
    	transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),transform .4s cubic-bezier(.25,.8,.25,1);
    	}
    	.mybtn .dt-buttons>button:nth-child(1){
    	background-color: #e91e63;
    	}
    	.mybtn .dt-buttons>button:nth-child(2){
    	background-color: #2196f3;
    	margin-left: 3x;
    	}
    	.mybtn .dt-buttons>button:nth-child(3){
    	background-color: #4caf50;
    	margin-left: 3px;
    	}
    	.mybtn .dt-buttons>button:nth-child(4){
    	background-color: #e91e63;
    	margin-left: 3px;
    	}
    	
    	.myselect label, .mysearch label{color: #292929;}
    	.myselect select{height: 35px; width: 100%; padding: 0 5px;}
    	
    	.mysearch label{display:block;}
    	.mysearch input{width:100% !important; border:1px solid #cccccc; height: 35px; padding: 0 12px;}
    	
    	
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
                    <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('message'); 
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("All App Users");?></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table table-border table-striped custom-table datatable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("User ID");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Created At");?></th>
                                                            <!-- <th class="text-left">Created By</th> -->
                                                            <th class="text-left"><?php echo $this->lang->line("Name");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Phone");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Referral Code");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Referral By Code");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Total Orders");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Wallet");?></th>
        <!--                                                    <th class="text-left"><?php echo $this->lang->line("Total Rewards");?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Total Order Amount");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Action");?></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("User ID");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Created At");?></th>
                                                            <!-- <th class="text-left">Created By</th> -->
                                                            <th class="text-left"><?php echo $this->lang->line("Name");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Phone");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Referral Code");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Referral By Code");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Total Orders");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Wallet");?></th>
        <!--                                                    <th class="text-left"><?php echo $this->lang->line("Total Rewards");?></th>-->
                                                            <th class="text-left"><?php echo $this->lang->line("Total Order Amount");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status");?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Action");?></th>
                                                            
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
<div id="user_action" class="modal fade delete-modal" role="dialog">
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
    $(document).ready(function() {
       table = $('#datatable').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/fetchRegisters')?>",
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
					"targets": [ 6,7,8,10], //first column / numbering column
					"orderable": false, //set not orderable
				},
			],
			
			"pageLength": 100,
              "lengthMenu": [ [100, 500, 1000, -1], [100, 500, 1000, "All"] ],

		});
    });
</script>

</html>