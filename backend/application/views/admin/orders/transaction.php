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
                                    <h4 class="card-title"><?php echo $this->lang->line("Transaction");?></h4>
                                    <div class="toolbar">
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Transaction List"); ?></h4>
                                        <div  class="toolbar">
                                            <div class="row">
                                                <div class="col-md-5 pull-right">
                                                    <div class="input-group input-daterange">
                                                        <input type="text" id="txtDate" name="fromdate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
                                                        <div class="input-group-addon">to</div>
                                                        <input type="text" id="txtDate2" name="todate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="datatables" class="table table-border table-striped custom-table datatable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("Date"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Order Id"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Customer Name"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Transaction Id"); ?> </th>
                                                            <th class="text-left"><?php echo $this->lang->line("Description"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Order Amount"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Order Type"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("Date"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Order Id"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Customer Name"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Transaction Id"); ?> </th>
                                                            <th class="text-left"><?php echo $this->lang->line("Description"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Order Amount"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Order Type"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status"); ?></th>
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

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    
<script type="text/javascript">
   $(document).ready(function() {
        fetchOrder();
    });
    $(document).on('blur','#txtDate2', function(){
        var table = $('#datatables').DataTable();
        table.destroy();
        fetchOrder();
    });
    function fetchOrder(){    
         table = $('#datatables').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
                          
            "dom": "<'row border-dark'<'col-sm-2 myselect'l><'col-sm-3 mybtn'B><'#cat.col-sm-2 myselect'><'col-sm-5 'f>>" 
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

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/fetchTransaction')?>",
				"type": "GET",
				"data": function ( data ) {
					 data.from = $('#txtDate').val();
					 data.to = $('#txtDate2').val();
					// data.LastName = $('#LastName').val();
					// data.address = $('#address').val();
				}
			},
             //responsive: true,
			//Set column definition initialisation properties.
			"columnDefs": [
				{
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
			],
			
			"pageLength": 100,
            "lengthMenu": [ [100, 500, 1000, -1], [100, 500, 1000, "All"] ],

		});
       
    }
    
$(document).ready(function() {

    $("#txtDate").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});

    $(document).ready(function() {

    $("#txtDate2").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});
</script>
</html>


<div id="myModal" class="modal fade myModal" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center user_details">
			
			</div>
		</div>
	</div>
</div>