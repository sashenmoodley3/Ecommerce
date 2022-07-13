<?php  $this->load->view("admin/common/head"); ?>
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
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <div class="" style="margin-bottom:15px;">
                                    <h4 class="card-title" style="display: inline-block;"><?php echo $this->lang->line("deliver_boy");?></h4>
                                    <a class="pull-right btn btn-primary" href="<?php echo site_url("admin/add_deliverboy"); ?>"><?php echo $this->lang->line("AdddeliverBoy");?></a>
                                    <!--<a href="<?php echo site_url("csv"); ?>">CSV</a>-->
                                    </div>
                                    <div class="toolbar">
                                        <div class="row">
                                                
                                            <div class="col-md-2 pull-right">
                                                <div class=" col-md-12 input-group input-daterange">
<!--                                                        <div>Status</div>-->
                                                    <span id="select_status"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables custom-datatable">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover custom-table" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                  
                                                    <th class="text-left"><?php echo $this->lang->line("ID");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("deliverBoyname");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("deliverBoyEmail");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("deliverBoyPhone");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("deliverboyDate");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <!--<th class="text-center">&nbsp;</th>-->
                                                    <th class="text-left"><?php echo $this->lang->line("ID");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("deliverBoyname");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("deliverBoyEmail");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("deliverBoyPhone");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("deliverboyDate");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php 
												$i=1;
												foreach($deliverdata as $deliver){
													$doc = $this->db->query("select * from delivery_boy_doc where delivery_boy_id = '".$deliver->id."' ")->result();
												// echo '<pre>';
												// print_r($deliver);
												// echo '</pre>';
												?>
                                                <tr>
                                                   
                                                    <td class="text-left"><?php echo $deliver->deliverBoy_id; ?></td>
                                                    <td class="text-left"><?php echo $deliver->user_name; ?></td> 
                                                    <td class="text-left"><?php echo $deliver->user_email; ?></td>
                                                    <td class="text-left"><?php echo $deliver->user_phone; ?></td>
                                                    <td class="text-left"><?php echo date("d-m-Y", strtotime($deliver->created_at)); ?></td>
                                                    
                                                    
                                                   
                                                    <td class="text-left">
													
													
													<?php 
													if($deliver->user_status==0){
														echo anchor('admin/enable_dboy/'.$deliver->id, '<button style="margin:3px; padding:3px;" type="button" rel="tooltip" class="btn btn-danger btn-round" title="Active" data-original-title="Active"><i class="material-icons">thumb_down</i> </button>', array("class"=>"", "title" => "Active", "onclick"=>"return confirm('Are you sure you want to Disable Deliver Boy
?')"));
                                                    }else{
                                                    
														echo anchor('admin/disable_dboy/'.$deliver->id, '<button style="margin:3px; padding:3px;" type="button" rel="tooltip" class="btn btn-success btn-round" title="In Active" data-original-title="In Active">
														<i class="material-icons">thumb_up</i>
														</button>', array("class"=>"", "title" => "In Active", "onclick"=>"return confirm('Are you sure you want to Enable Deliver Boy
?')"));
														
													} 
													?>
													
													
													</td>
                                               

                                                    <td class="td-actions text-left">
													<div class="btn-group">
													
													<a href="#" data-toggle="modal" data-target="#dbModal<?php echo $i; ?>">
													<button type="button" rel="tooltip" title="Document" class="btn btn-success btn-round">
													<i class="material-icons">list</i>
													</button>
													</a>
													
													
													
                                                    <?php echo anchor('admin/deliverBoy_orders/'.$deliver->id, '<button type="button" rel="tooltip" class="btn btn-success btn-round" title="Order Details"><i class="material-icons">info</i></button>', array("class"=>"")); ?>
                                                        
													<?php echo anchor('admin/edit_deliverBoy/'.$deliver->id, '<button type="button" rel="tooltip" class="btn btn-success btn-round" title="Edit"><i class="material-icons" >edit</i></button>', array("class"=>"")); ?>

													<?php echo anchor('admin/delete_deliverboy/'.$deliver->id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round" title="Delete"><i class="material-icons" >close</i></button>', array("class"=>"", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                            
                                                        </div>
														
														<div class="modal fade" id="dbModal<?php echo $i; ?>">
														<div class="modal-dialog modal-dialog-centered modal-lg">
															<div class="modal-content ">
																<div class="modal-header">
																<h4 class="modal-title" style="text-align:center;"><b>Document</b><button type="button" style="" class="close" data-dismiss="modal">&times;</button></h4> 
															</div> 
															<div class="modal-body">
																
															
															<div class="row">
																<div class="col-md-12">
																<?php if(!empty($deliver->deliverBoyImage)){ ?>
																	<h5>Profile Image</h5>
                                                                    <img  src="<?php echo site_url('uploads/deliver/'.$deliver->deliverBoyImage);?>" data-src="" style="width:150px;"  alt="" class="lazyload img-responsive post-image myImg"/>
                                                                <?php }?>
																</div>
															</div>
															<div class="row">
																<?php
																	
																foreach($doc as $key => $do){
																	$label = $do->id_proof_name;
																	
																	if(!empty($do->image_file)){
																		$ext = substr(strrchr($do->image_file,'.'),1);
																		
																		
																		if(($key)%2 == 0){
																			?>
																			</div>
																			<div class="row">
																			<?php
																		}

																		?>
																<div class="col-md-6">
																<div class="row">
																<div class="col-md-6">
																<h5><?php echo $label; ?></h5>
																<?php 
																if($ext == 'pdf'){ ?>
                                                                    <a href="<?php echo site_url('uploads/deliver/'.$do->image_file);?>" class="" target="_blank">PDF File</a>
																	<?php
																}
																else{
																	?>
                                                                    <img  src="<?php echo site_url('uploads/deliver/'.$do->image_file);?>" data-src="" style="width:100%;"  alt="" class="lazyload img-responsive post-image myImg"/>
																	<?php
																}
																?>
																</div>
																<div class="col-md-6">
																<h5><?php echo $label; ?> Back</h5>
																<?php 
																if(!empty($do->image_file)){
																	$ext_back = substr(strrchr($do->image_file_back,'.'),1);
																	if($ext_back == 'pdf'){ ?>
																		<a href="<?php echo site_url('uploads/deliver/'.$do->image_file_back);?>" class="" target="_blank">PDF File</a>
																		<?php
																	}
																	else{
																		?>
																		<img  src="<?php echo site_url('uploads/deliver/'.$do->image_file_back);?>" data-src="" style="width:100%;"  alt="" class="lazyload img-responsive post-image myImg"/>
																		<?php
																	}
																}
																?>
																</div>
																</div>
																<?php 

													if($do->status==1){
														echo '<button style="margin:3px; padding:3px;" type="button" rel="tooltip" class="btn btn-success btn-round" title="Verified" data-original-title="Verified"><i class="material-icons">done</i> </button>';
                                                    }
													else{
														echo anchor('admin/enable_dboy_doc/'.$do->id, '<button style="margin:3px; padding:3px;" type="button" rel="tooltip" class="btn btn-danger btn-round" title="Verify" data-original-title="Verify"><i class="material-icons">done</i> </button>', array("class"=>"verify_doc", "title" => "Verify", "onclick"=>"return confirm('Are you sure you want to Verify Deliver Boy Documents
														?')"));
													}
																


																?>
																	
																	</div>
                                                                <?php

													
																}
																
																
																
																
																}


																?>
																 
																
																
																</div>
																
															</div>
														</div>
													</div>
														
                                                    </td>
                                                </tr>
                                                <?php $i++; } ?>
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
<!--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>-->
 <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#datatables').DataTable({
            "order": [[0, "desc"]],
            "dom": "<'row border-dark'<'col-sm-2 myselect'l><'col-sm-3 mybtn'B><'#cat.col-sm-2 myselect'><'col-sm-5 mysearch'f>>" 
                        + "<'row'<'col-sm-12'i>>" 
                        + "<'row'<'col-sm-12'tr>>" 
                        + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
               // dom: 'Bfrtip',
           buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],

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
        $("#datatables thead th").each(function (i) {
                if (false) {
                    var select = $('<select><option value=""></option></select>')
                            .appendTo($(this))
                            .on('change', function () {
                                table.column(i)
                                        .search($(this).val())
                                        .draw();
                            });

                    table.column(i).data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                }
            });
            
        // var select = $('<select class="form-control">\n\
        //                                 <option value="">--Select Deliver Boy --</option>\n\
                                      
        //                             </select>')
        //             .appendTo($('#cat'))
        //             .on('change', function () {
        //                 table.column(1)
        //                         .search($(this).val())
        //                         .draw();
        //             });
        //     table.column(1).data().unique().sort().each(function (d, j) {
        //         select.append('<option value="' + d + '">' + d + '</option>')
        //     });
        //var table = $('#datatables').DataTable();

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
    
       // Bulk Clicking on Table Checkboxes
    $("#bulk_action_checkbox").on("click", function(e){
    	check_status = this.checked;
        $(".bulk_action_checkbox_individual").each( function(){
            $(this).prop("checked",check_status);
        });
    });
    
    // function show_doc_modal(modal_name,action_id) {
        // var BASE_URL = '<?php echo site_url()?>';
        // $.get(BASE_URL+"Admin/get_html_order_details",{order_id:action_id},function(data){
            // $('#order_details').html(data);

            // $('#'+modal_name).modal('show');

        // });

    // }
    
</script>

</html>