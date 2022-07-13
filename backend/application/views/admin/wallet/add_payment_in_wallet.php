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
        a.action-btn-detail{
                padding: 10px;
                border-radius: 50%;
        }
        a.action-btn-edit{
                padding: 11px 5px;
                border-radius: 50%;
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">search</i>
                                </div>
                                <div class="card-content">
                                    <div class="toolbar">
                                        <form name="advance_search" action="" method="post" >
                                            <div class="row" style="margin-top: 50px;">
                                                <div class="col-md-3">
                                                    <div class="label-floating">
                                                        <label class="label-on-left"><?php echo $this->lang->line("Payment");?> (in Rs.)</label>
                                                        <input  type="text" value="<?=set_value('payment')?>"  name="payment" id="payment" class="form-control"  placeholder="<?php echo $this->lang->line("Payment");?>"/>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="label-floating">
                                                        <label class="label-on-left"><?php echo $this->lang->line("Description");?> </label>
                                                        <input  type="text" value="<?=set_value('description')?>"  name="description" id="description" class="form-control"  placeholder="<?php echo $this->lang->line("Description");?>"/>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6"  style="margin-top: 0px;float:left;">
                                                        <input type="submit" class="btn btn-danger" name="bulk_wallet_payment_submit" value="Submit"/>
                                                        
                                                </div>
                                            </div>
                                        <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" >
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="select_all" value=""/></th> 
                                                        <th class="text-center"><?php echo $this->lang->line("ID");?></th>
<!--                                                        <th class="text-center"><?php echo $this->lang->line("Company Name");?></th>-->
                                                        <th class="text-center"><?php echo $this->lang->line("Name");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Email");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Mobile");?></th>
<!--                                                        <th class="text-center"><?php echo $this->lang->line("Package");?></th>-->
<!--
                                                        <th class="text-center"><?php echo $this->lang->line("Version");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Amount");?></th>
-->
<!--                                                        <th class="text-center"><?php echo $this->lang->line("Status");?></th>-->
<!--                                                        <th class="text-center"><?php echo $this->lang->line("Action");?></th>-->
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th class="text-center"><?php echo $this->lang->line("ID");?></th>
<!--                                                        <th class="text-center"><?php echo $this->lang->line("Company Name");?></th>-->
                                                        <th class="text-center"><?php echo $this->lang->line("Name");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Email");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Mobile");?></th>
<!--                                                        <th class="text-center"><?php echo $this->lang->line("Package");?></th>-->
<!--
                                                        <th class="text-center"><?php echo $this->lang->line("Version");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Amount");?></th>
-->
<!--                                                        <th class="text-center"><?php echo $this->lang->line("Status");?></th>-->
<!--                                                        <th class="text-center"><?php echo $this->lang->line("Action");?></th>-->
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php 
                                                        $i=1;
                                                    //print_r($userData);
                                                    foreach(@$userData as $users){ //print_r($users); exit; ?>
                                                    <tr>
                                                        <td><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $users->user_id; ?>"/></td>
                                                        <td class="text-center"><?php echo $i; ?></td>
<!--                                                        <td class="text-center"><a id="view" data-name="viewUser" data-id="<?=$users->user_id?>" href="javascript:void(0)"><?php echo $users->user_name; ?></a></td> -->
                                                        <td class="text-center"><a id="view" data-name="viewUser" data-id="<?=$users->user_id?>" href="javascript:void(0)"><?php echo $users->user_fullname; ?></a></td> 
                                                        <td class="text-center"><?php echo $users->user_email; ?></td>
                                                        <td class="text-center"><?php echo $users->user_phone; ?></td>
<!--                                                        <td class="text-center"><?php echo $users->pkg_id; ?></td>-->
<!--                                                        <td class="text-center"><a id="view" data-name="viewVersion" data-id="<?=$users->version?>" href="javascript:void(0)"><?php echo $users->version; ?></a></td>-->
<!--                                                        <td class="text-center"><?=!empty($users->pakg_amount) ? $users->pakg_amount : 0; ?></td>-->
                                                        
                                                        
                                                       
<!--
                                                        <td class="text-center">
														<?php 
														if($users->user_status == "2"){
															?>
															<span class="label label-warning">Explired</span>
															<?php 
															} 
															elseif($users->user_status == "1"){
															?>
															<span class="label label-success">Active</span>
															<?php 
															} 
															else { 
															?>
															<span class="label label-danger">In Active</span>
															<?php } ?>
															</td>
-->
                                                   
    
<!--
                                                        <td class="td-actions text-center"><div class="btn-group">
                                                                <?php echo anchor('editUser/'.$users->user_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>
                                                                <?php if(@$users->user_status == "1"){ ?>
                                                                    <?php echo anchor('deactiveUser/'.$users->user_id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                                                    <i class="material-icons">close</i>
                                                                    </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure you want to deactive account?')")); ?>
                                                                <?php } else{ ?>    
                                                                    <?php echo anchor('activeUser/'.$users->user_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                    <i class="material-icons">check</i>
                                                                    </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure you want to active account?')")); ?>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
-->
                                                    </tr>
                                                    <?php $i = $i+1; } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </form>
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                </div> 
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


    
<script type="text/javascript">
   $(document).ready(function() {
        
        fetchOrder();
        
    });
    
    function fetchOrder(){    
         table = $('#datatables').DataTable({

//			"processing": true, //Feature control the processing indicator.
//			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [],
//             "bFilter": false,//Initial no order.

			// Load data for the table's content from an Ajax source
//			"ajax": {
//				"url": "<?php //echo site_url('admin/fetchOrders')?>",
//				"type": "GET",
//                
//				"data": function ( data ) {
//					 data.from = $('#txtDate').val();
//					 data.to = $('#txtDate2').val();
//                    
//                    //$('#datatable_filter').style("display","none");
//					// data.LastName = $('#LastName').val();
//					// data.address = $('#address').val();
//				}
//			},

			//Set column definition initialisation properties.
			"columnDefs": [
				{
					"targets": [ 4 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
			],
			
			"pageLength": 100,
              "lengthMenu": [ [100, 500, 1000, -1], [100, 500, 1000, "All"] ],

		});
       
    }
    
    
    ////////////////////////Bulk Action Perform ////////////////////
$(document).ready(function(e){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
	
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });

})
  
    
</script>

</html>