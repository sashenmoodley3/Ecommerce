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
        
        /*        rating and review css for single product*/
        .txt-center {
          text-align: center;
        }
        .hide {
          display: none;
        }

        .clear {
          float: none;
          clear: both;
        }

        .ratingg {
            width: 240px;
            unicode-bidi: bidi-override;
            margin-top: 10px;
            direction: rtl;
            text-align: left;
            position: relative;
        }

        .ratingg > label {
            float: right;
            display: inline;
            padding: 0;
            margin: 0;
            position: relative;
            width: 1.1em;
            cursor: pointer;
            color: #000;
        }

        .ratingg > label:hover,
        .ratingg > label:hover ~ label,
        .ratingg > input.radio-btn:checked ~ label {
            color: transparent;
        }

        .ratingg > label:hover:before,
        .ratingg > label:hover ~ label:before,
        .ratingg > input.radio-btn:checked ~ label:before,
        .ratingg > input.radio-btn:checked ~ label:before {
            content: "\2605";
            position: absolute;
            left: 0;
            color: #FFD700;
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
                    <div class="row">
                       
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Enquiry List");?></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Sr. No.");?></th>
                                                    <th style="width:140px;"><?php echo $this->lang->line("Product Name");?></th>
                                                    <th><?php echo $this->lang->line("Name");?></th>
                                                    <th ><?php echo $this->lang->line("Email");?></th>
                                                    <th><?php echo $this->lang->line("Mobile");?></th>
                                                    <th style="width:110px;"><?php echo $this->lang->line("Rating");?></th>
                                                    <th style="width:110px;"><?php echo $this->lang->line("Description");?></th>
                                                    <th><?php echo "Review Date";?></th>
                                                    <th><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Sr. No.");?></th>
                                                    <th style="width:140px;"><?php echo $this->lang->line("Product Name");?></th>
                                                    <th><?php echo $this->lang->line("Name");?></th>
                                                    <th><?php echo $this->lang->line("Email");?></th>
                                                    <th><?php echo $this->lang->line("Mobile");?></th>
                                                    <th style="width:110px;"><?php echo $this->lang->line("Rating");?></th>
                                                    <th style="width:110px;"><?php echo $this->lang->line("Description");?></th>
                                                    <th><?php echo "Review Date";?></th>
                                                    <th><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $sr_no=0;
                                                foreach($product_reviews as $reviews)
                                                {
                                                    //print_r($reviews);
                                                    $sr_no++; 
                                                    $rating = $reviews->rating;
                                                    $disable_rating = 5-$rating;
                                                    $active_star="";
                                                    $inactive_star="";
                                   
                                                    for($i = 0; $i<$rating; $i++)
                                                    { //echo "-".$i;
                                                        $active_star .= '<i class="fa fa-star"></i>';
                                                    }

                                                    for($i = 0; $i<$disable_rating; $i++)
                                                    {
                                                        $inactive_star .= '<i class="fa fa-star-o"></i>';
                                                    }
                                                
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $sr_no; ?></td>
                                                        <td><?php echo $reviews->product_name; ?></td>
                                                        <td><?php echo $reviews->username; ?></td>
                                                        <td><?php echo $reviews->user_email; ?></td>
                                                        <td><?php echo $reviews->user_phone; ?></td>
                                                        <td class="rating" style="color: #FFD700;"><?php echo $active_star.$inactive_star; ?></td>
                                                        <td><?php echo $reviews->description; ?></td>
                                                        <td><?php echo date("d-m-Y h:i:s", strtotime($reviews->created_date)); ?></td>
                                                        <td><?php 
                                                    
                                                    //echo $reviews->review_status;
                                                    if($reviews->review_status==0){
														echo anchor('admin/disable_review/'.$reviews->review_id, '<button style="margin:3px; padding:3px;" type="button" rel="tooltip" class="btn btn-danger btn-round" title="Review Disable" data-original-title="Request Reject">
														<i class="material-icons">thumb_down</i>
														</button>', array("class"=>"", "title" => "Review Disable", "onclick"=>"return confirm('Are you sure you want to Disable Review?')"));
                                                    }else{
                                                    
														echo anchor('admin/enable_review/'.$reviews->review_id, '<button style="margin:3px; padding:3px;" type="button" rel="tooltip" class="btn btn-success btn-round" title="Review Enable" data-original-title="Review Enable">
														<i class="material-icons">thumb_up</i>
														</button>', array("class"=>"", "title" => "Review Enable", "onclick"=>"return confirm('Are you sure you want to Enable Review?')"));
														
													} 
                                                    echo 
														anchor('admin/delete_review/'.$reviews->review_id, '<button style="margin:3px; padding:3px;" type="button" rel="tooltip" class="btn btn-danger btn-round" title="Review Delete" data-original-title="Review Delete">
														<i class="material-icons">delete</i>
														</button>', array("class"=>"", "title" => "Review Delete", "onclick"=>"return confirm('Are you sure you want to Enable Review?')"));
                                                            
                                                            
                                                    ?></td>
                                                        
                                                    </tr>
                                                <?php }
                                                if ($sr_no == 0){
                                                   echo "<tr><td colspan='7' class='text-center'> No Record Present</td></tr>";
                                                }



                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
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
//				"url": "<?php echo site_url('admin/fetchOrders')?>",
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
					"targets": [ 7 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
			],
			
			"pageLength": 50,
              "lengthMenu": [ [100, 500, 1000, -1], [100, 500, 1000, "All"] ],

		});
       
    }
</script>

</html>