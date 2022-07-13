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
                                    <h4 class="card-title" style="display: inline-block;"><?php echo $this->lang->line("All Products");?></h4>
                                    <a class="pull-right btn btn-primary" href="<?php echo site_url("admin/add_products"); ?>"><?php echo $this->lang->line("ADD");?></a>
                                    <a class="pull-right btn btn-primary" href="<?php echo site_url("admin/csv"); ?>" ><?php echo $this->lang->line("BULK UPLOAD");?></a>
                                    <!--<a href="<?php echo site_url("admin/csv"); ?>">CSV</a>-->
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
                                                    <th class="text-center"><?php echo "ID";?></th>
                                                    <th class="text-center"><?php echo "Url";?></th>
                                                    <th class="text-center"><?php echo "Content";?></th>
                                                    <th class="text-center"><?php echo "Image";?></th>
                                                    <th class="text-center"><?php echo "Status";?></th>
                                                    <th class="text-center"><?php echo "Action";?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center"><?php echo "ID";?></th>
                                                    <th class="text-center"><?php echo "Url";?></th>
                                                    <th class="text-center"><?php echo "Content";?></th>
                                                    <th class="text-center"><?php echo "Image";?></th>
                                                    <th class="text-center"><?php echo "Status";?></th>
                                                    <th class="text-center"><?php echo "Action";?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($advertisement as $product){ ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $product->static_product_id; ?></td>
                                                    <td class="text-center"><?php echo $product->product_name; ?></td> 
                                                    <td class="text-center"><?php echo $product->title; ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars_decode(($product->product_description)); ?></td>
                                                    <td class="text-center"><?php if($product->in_stock == "1"){ ?><span class="label label-success">In Stock</span><?php } else { ?><span class="label label-danger">Out of Stock</span><?php } ?></td>
                                                    <td class="td-actions text-center">
                                                        <div class="btn-group">
                                                            <?php echo anchor('admin/edit_products/'.$product->product_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>
    
                                                                <?php echo anchor('admin/delete_product/'.$product->product_id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                                                <i class="material-icons">close</i>
                                                            </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
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
            
        var select = $('<select class="form-control">\n\
                                        <option value="">--Select Category Name--</option>\n\
                                    </select>')
                    .appendTo($('#cat'))
                    .on('change', function () {
                        table.column(2)
                                .search($(this).val())
                                .draw();
                    });
            table.column(2).data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '">' + d + '</option>')
            });
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
    
    // $("#bulk_action_button").on("click", function(e){
    // 	bulk_action_type 			=	$('#bulk_action_type').val();
    // 	if(bulk_action_type){
    // 		if($(".bulk_action_checkbox_individual:checked").length>0){
    // 			ids 			=	[];
	   //         $('.bulk_action_checkbox_individual').each(function(){
	   //             if($(this).is(':checked')){
	   //         		// Checked Page ID
	   //         		checked_id 	=	$(this).val();
	   //                 ids.push(checked_id);
	   //             }
	   //         });
	   //         if(ids.length>0){
    
</script>

</html>