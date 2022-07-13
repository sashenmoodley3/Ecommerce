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
                                    <h4 class="card-title"><?php echo $this->lang->line("All Stock");?></h4>
                                    <!--a class="pull-right" href="<?php echo site_url(""); ?>">ADD NEW STORE</a-->
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables custom-datatable">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-left"><?php echo $this->lang->line("ID"); ?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Product Name");?></th>
                                                    <th class="text-left"><?php echo "Category";?></th>
                                                    <th class="text-left"><?php echo "Stock";?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-left"><?php echo $this->lang->line("ID"); ?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Product Name");?></th>
                                                    <th class="text-left"><?php echo "Category";?></th>
                                                    <th class="text-left"><?php echo "Stock";?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php   foreach($stock_list as $product){ 
                                                        $varients = $this->db->query("select * from product_varient where product_id =  '".$product->product_id."' ")->result();?>
                                                    <tr style="padding: 5px 0px">
                                                        <td class="text-left"><?php echo $product->static_product_id; ?></td>
                                                        <td class="text-left"><?php echo ucwords($product->product_name); ?></td>
                                                        <td class="text-left"><?php echo ucwords($product->title); ?></td>
                                                        <td class="text-left">
                                                            <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <tr>
                                                                    <th class="text-left">Quantity (Unit)</th>
                                                                    <th class="text-left">Price</th>
                                                                    <th class="text-left">Stock</th>
                                                                    <th class="text-left">Tax</th>
                                                                    <th class="text-left">MRP</th>
                                                                    
                                                                </tr>
                                                                  <?php 
                                                                    foreach($varients as $k=>$value){ 
                                                                        $price          = $value->price;
                                                                        $qty            = $value->qty;
                                                                        $unit           = $value->unit;
                                                                        $stock_inv      = $value->stock_inv;
                                                                        $tax            = $value->tax;
                                                                        $mrp            = $value->mrp;?>
                                                                <tr>
                                                                    <td>
                                                                         <?php if($unit == 'ML'){
                                                                                    $un =  "ML";
                                                                                }else if($unit == 'LTR'){
                                                                                   $un = "LTR"; 
                                                                                }else if($unit == 'GM'){
                                                                                   $un = "GM"; 
                                                                                }else if($unit == 'KG'){
                                                                                   $un = "KG"; 
                                                                                } ?>
                                                                        <?=$qty."(".$un.")"; ?> </td>
                                                                         <td><?=$price; ?> </td>
                                                                         <td><?=$stock_inv; ?> </td>
                                                                         <td><?=$tax; ?></td> 
                                                                         <td><?=$mrp; ?> </td>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </table>
                                                        
                                                        
                                                        
                                                        
                                                        </td>
                                                        <td class="td-actions text-left"><div class="btn-group">
                                                            <?php echo anchor('admin/edit_purchase/'.$product->product_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">edit</i>
                                                        </button>', array("class"=>"","target"=>"_blank")); ?>

                                                           
                                                            
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

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        var table = $('#datatables').DataTable({
            "order": [[0, "desc"]],
                 "dom": "<'row border-dark'<'col-sm-4 myselect'l><'col-sm-4 mybtn'B><'col-sm-4 mysearch'f>>" 
                        + "<'row'<'col-sm-12'i>>" 
                        + "<'row'<'col-sm-12'tr>>" 
                        + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
               // dom: 'Bfrtip',
               buttons: [
                    'excelHtml5',
                    'csvHtml5',
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
    
    
</script>

</html>