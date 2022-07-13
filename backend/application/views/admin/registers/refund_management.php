<?php  $this->load->view("admin/common/head"); 
?>
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
        
    
        /* Style the Image Used to Trigger the Modal */
        #myImg {
          border-radius: 5px;
          cursor: pointer;
          transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        #imgModel {
          display: none; /* Hidden by default */
          position: fixed; /* Stay in place */
          z-index: 1050; /* Sit on top */
          padding-top: 100px; /* Location of the box */
          left: 0;
          top: 0;
          width: 100%; /* Full width */
          height: 100%; /* Full height */
          overflow: auto; /* Enable scroll if needed */
          background-color: rgb(0,0,0); /* Fallback color */
          background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (Image) */
        #imgModel .modal-content {
          margin: auto;
          display: block;
          width: 80%;
          max-width: 700px;
        }

        /* Caption of Modal Image (Image Text) - Same Width as the Image */
        #caption {
          margin: auto;
          display: block;
          width: 80%;
          max-width: 700px;
          text-align: center;
          color: #ccc;
          padding: 10px 0;
          height: 150px;
        }

        /* Add Animation - Zoom in the Modal */
        #imgModel .modal-content, #caption {
          animation-name: zoom;
          animation-duration: 0.6s;
        }

        @keyframes zoom {
          from {transform:scale(0)}
          to {transform:scale(1)}
        }

        /* The Close Button */
        #imgModel .close {
          position: absolute;
          top: 15px;
          right: 35px;
          color: #f1f1f1;
          font-size: 40px;
          font-weight: bold;
          transition: 0.3s;
          opacity: 1;
        }

        #imgModel .close:hover,
        #imgModel .close:focus {
          color: #bbb;
          text-decoration: none;
          cursor: pointer;
        }

        /*        product detail popup css start*/
        
             

            .openmodal {
                background-color: white;
                color: black;
                width: 30vw
            }

            :-moz-any-link:focus {
                outline: none
            }

        
/*        product detail popup css end*/
        
        /* tooltip css start*/
        
/*
        .tooltip {
          position: relative;
          display: inline-block;
          border-bottom: 1px dotted black;
        }
*/

        .tooltip1 .tooltiptext {
          visibility: hidden;
          width: auto;
          background-color: #eeeeee;
          color: #000;
          text-align: center;
          border-radius: 6px;
          padding: 15px;

          /* Position the tooltip */
          position: absolute;
          z-index: 1;
        }

        .tooltip1:hover .tooltiptext {
          visibility: visible;
        }
        /* tooltip css end*/

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
<!--
                             <div class="col-md-6 text-left refund-success-msg">
			                                                         
			                 </div>
-->
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                
                               
                                
                                <div class="card-content">
                                    <div class="" style="margin-bottom:15px;">
                                    <h4 class="card-title" style="display: inline-block;"><?php echo "Return Request";?></h4>
                                   
                                    </div>
                                   
                                    <div class="material-datatables custom-datatable table-responsive">
                                        <table id="datatable" class="table table-striped table-no-bordered table-hover custom-table" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                    <!--<th class="text-center">-->
                                                    <!--    <div class="checkbox checkbox-inline checkbox-success display-check">-->
                                                    <!--        <input type="checkbox" name="bulk_action_checkbox" id="bulk_action_checkbox">-->
                                                    <!--        <label for="bulk_action_checkbox"><strong>Select</strong></label>-->
                                                    <!--    </div>-->
                                                    <!--</th>-->
                                                    <tr>
                                                        <th class="text-left">No.</th>
                                                        
                                                        <th class="text-left"><?php echo $this->lang->line("Customer"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Order Id"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Order Amount")." (in ".$this->config->item('currency').")"; ?> </th>
                                                        <th class="text-left"><?php echo $this->lang->line("Image"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Request Date"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Request For"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Reason"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Description"); ?></th>
														<th class="text-left"><?php echo $this->lang->line("Delivery Boy"); ?>
                                                        <th class="text-left"><?php echo $this->lang->line("Status"); ?> </th>
                                                        <th class="text-left"><?php echo $this->lang->line("Action"); ?> </th>
                                                    </tr>
                                            </thead>
                                            <tfoot>
                                                    <tr>
                                                        <th class="text-left">No.</th>
                                                        
                                                        <th class="text-left"><?php echo $this->lang->line("Customer"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Order Id"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Order Amount")." (in ".$this->config->item('currency').")"; ?> </th>
                                                        <th class="text-left"><?php echo $this->lang->line("Image"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Request Date"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Request For"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Reason"); ?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Description"); ?></th>
														<th class="text-left"><?php echo $this->lang->line("Delivery Boy"); ?>
                                                        <th class="text-left"><?php echo $this->lang->line("Status"); ?> </th>
                                                        <th class="text-left"><?php echo $this->lang->line("Action"); ?> </th>
                                                    </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                    $count =1;
                                                    foreach ($refund_history as $history) {
														$boy = "";
														if (!empty($history->delivery_boy_id)) {
															$deliver_boy = $this->db->query("select * from delivery_boy where id = '".$history->delivery_boy_id."' ")->row();
															$boy  = $deliver_boy->user_name;
															
														}
                                                        
                                                        $customer_tooltip_content = "<b>Name: </b>".ucfirst($history->user_fullname)."<br><b>Email: </b>".$history->user_email."<br><b>Mobile: </b>".$history->user_phone;
                                                        
                                                        $product_image  = site_url().'uploads/returnOrder/'.$history->pic;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><?=$count++;?></td>
                                                            <td class="text-left"><div class="tooltip1" style="opacity: 6;text-align:left;"><b><?php echo ucfirst($history->user_fullname);?></b>
                                                              <span class="tooltiptext" style="text-align:left;"><?php echo @$customer_tooltip_content;?></span>
                                                            </div>
                                                                </td>
                                                            <th class="text-left"><?=$history->order_id?></th>
                                                            <th class="text-left">
                                                                <?php if(!empty($history->total_amount)){ echo number_format($history->total_amount, 2, ".","");}else{echo "0.00";}?>
                                                            </th>
                                                           
                                                           
                                                            <th class="text-left">
                                                                <?php if(!empty($product_image)){ ?>
                                                                    <img  src="<?php echo $product_image;?>" data-src="" style="height:100px; width:100px;"  alt="" class="lazyload img-responsive post-image myImg"/>
                                                                <?php }?>

                                                            </th>
                                                            
                                                            <td class="text-left"><?=$history->request_date?></td>
                                                            <td class="text-left"><?=ucfirst($history->requestfor)?></td>
                                                            <td class="text-left"><?=$history->reason?></td>
                                                            <td class="text-left"><?=$history->description?></td>
															<td><?php echo $boy; ?></td>
                                                            <td class="text-left"><?php
															$status = '';
															if ($history->refund_status == 0) {
																$status = "<span class='label label-default'>Pending</span>";
															} 
															else if ($history->refund_status == 1) {
																$status = "<span class='label label-info'>Confirm</span>";
															} 
															else if ($history->refund_status == 2) {
																$status = "<span class='label label-danger'>Reject</span>";
															} 
															else if ($history->refund_status == 3) {
																$status = "<span class='label label-warning'>Arriving</span>";
															}
															else if ($history->refund_status == 4) {
																$status = "<span class='label label-warning'>Hold</span>";
															}
															else if ($history->refund_status == 5) {
																$status = "<span class='label label-warning'>In Transit</span>";
															}
															else if ($history->refund_status == 6) {
																$status = "<span class='label label-danger'>Denied</span>";
															}
															else if ($history->refund_status == 7) {
																$status = "<span class='label label-success'>Received</span>";
															}
															// else if ($history->refund_status == 8) {
																// $status = "<span class='label label-success'>Successful</span>";
															// }
															
															echo $status;
															
                                                                ?>
                                                            </td>
															
                                                            <td>
                                                                
                                                                
                                                                <div class="dropdown" style="display:inline;">
                                                                    
																	<a href="#" data-toggle="modal" onclick="show_product_modal_view('ProductModal',<?=@$history->order_id?>)" class="btn btn-success action-btn-detail" title="Order Details" ><i class="material-icons">list</i></a> 
                                                                    
                                                                    <a class="btn btn-success action-btn-edit dropdown-toggle" data-toggle="dropdown" title="More Actions"> <i class="material-icons">edit</i>
                                                                        <span class="caret"></span></a>
                                                                        <ul class="dropdown-menu">
                                                                            <?php
                                                                            if ($history->refund_status == 0) {
                                                                            ?>
                                                <li><a data-toggle='modal' onclick="show_modal_view_req_rejct('myModal',<?=$history->refund_id?>)" >Request Reject</a></li>
                                                                                
                                                <li><a data-toggle='modal' onclick="show_modal_view_ass_del_boy('myModal',<?=$history->refund_id?>)">Assign to Delivery Boy</a></li>
                                                                            <?php
                                                                            } 
                                                                            if ($history->refund_status == 1) {
                                                                            ?>
                                            <li><a href="<?= base_url('Admin/dboy_arriving/'.$history->refund_id)?>"  >Delivery Boy Arriving</a></li>
                                                                            <?php
                                                                            }
																			if ($history->refund_status == 5) {
                                                                            ?>
                                            <li><a href="<?= base_url('Admin/dboy_received/'.$history->refund_id)?>" >Product Received</a></li>
                                                                            <?php
                                                                            } 
																			
                                                                            ?>
                                                                        </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
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

<!-- The Modal -->
<div id="imgModel" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>


<div id="myModal" class="modal fade myModal" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center user_details">
			
			</div>
		</div>
	</div>
</div>  


<div id="RefundMsgModal" class="modal fade myModal" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center refund-success-msg">
			
			</div>
		</div>
	</div>
</div> 


<script type="text/javascript">
    
    $(document).ready(function() {
        
        fetchOrder();
        
    });
    
    function fetchOrder(){ 
        //alert("ram");
         table = $('#datatable').DataTable({
             "bFilter": true,//Initial no order.
			"pageLength": 100,
              "lengthMenu": [ [100, 500, 1000, -1], [100, 500, 1000, "All"] ],

		});
       
    }
    
    function show_modal_view_ass_del_boy(modal_name,action_id) {
        //alert("delivery boy");
        var BASE_URL = '<?=base_url()?>';
        $.get(BASE_URL+"Admin/get_html_assign_deliveryBoy_refund_process",{ action_id:action_id},function(data){
           // alert(data);
            $('.user_details').html(data);
            $('#'+modal_name).modal('show');
        });

    }
    
    function show_modal_view_req_rejct(modal_name,action_id) {
        //alert("req reject");
        var BASE_URL = '<?=base_url()?>';
        $.get(BASE_URL+"Admin/get_html_refund_request_reject",{ action_id:action_id},function(data){
            
            $('.user_details').html(data);
            $('#'+modal_name).modal('show');
        });

    }
    
    
    /* function show_modal_view_refund_product_accept(action_id, order_id, user_id) {
        var BASE_URL = '<?=base_url()?>';
        $.get(BASE_URL+"Admin/get_html_refund_product_accept",{ action_id:action_id, order_id:order_id, user_id:user_id},function(data){
            $('.refund-success-msg').html(data);
            $('#RefundMsgModal').modal('show');
			setTimeout(function(){
				location.reload();
			})
        }, 3000);

    } */
    
    function show_product_modal_view(modal_name,action_id) {
        //alert(action_id);
        var BASE_URL = '<?php echo site_url()?>';
        $.get(BASE_URL+"Admin/get_html_return_order_details",{order_id:action_id},function(data){
            //alert(data);
            $('#order_details').html(data);

            $('#'+modal_name).modal('show');

        });

    }
    
	// Get the modal
    var modal = document.getElementById("imgModel");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    //var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    $('.myImg').click(function(){
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    });	

    /*img.onclick = function(){
      modal.style.display = "block";
      modalImg.src = this.src;
      captionText.innerHTML = this.alt;
    }*/

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    /*span.onclick = function() {
      modal.style.display = "none";
    }*/

    $('.close').click(function() {
      modal.style.display = "none";
    });
    
</script>

</html>


<div class="container d-flex justify-content-center mt-100">
    <!-- Button to Open the Modal --> 
<!--<button type="button" class="btn openmodal" data-toggle="modal" data-target="#modal1"> Click here </button> -->
<!-- The Modal -->
    <div class="modal fade" id="ProductModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ">
                <div id="order_details">
                
                
                </div>
                
            </div>
        </div>
    </div>
</div>




