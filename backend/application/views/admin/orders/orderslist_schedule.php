<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme") . "/assets/img/apple-icon.png"); ?>" />
        <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme") . "/assets/img/favicon.png"); ?>" />
        <title>Ora Super</title>
        <!-- Canonical SEO -->
        <link rel="canonical" href="//www.creative-tim.com/product/material-dashboard-pro" />

        <!-- Bootstrap core CSS     -->
        <link href="<?php echo base_url($this->config->item("new_theme") . "/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
        <link href="<?php echo base_url($this->config->item("new_theme") . "/assets/css/fullcalendar.min.css"); ?>" rel="stylesheet" />
        <!--  Material Dashboard CSS    -->
        <link href="<?php echo base_url($this->config->item("new_theme") . "/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
        <!--  CSS for Demo Purpose, don't include it in your project     -->
        <link href="<?php echo base_url($this->config->item("new_theme") . "/assets/css/demo.css"); ?>" rel="stylesheet" />
        <!--     Fonts and icons     -->
        <link href="<?php echo base_url($this->config->item("new_theme") . "/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
        <link href="<?php echo base_url($this->config->item("new_theme") . "/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
        <style>
        .border-dark{
            padding: 5px 0px 0px 0px;
            border-top:1px #ccc solid;
            border-bottom:1px #ccc solid;
        }
        table.custom-table > thead > tr > th{
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }
        .mybtn{text-align:center;}
        .mybtn .dt-buttons>button, .mybtn .dt-buttons>a{
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
    	.mybtn .dt-buttons>a{
    	    background-color: #e91e63;
    	}
    	
    	.myselect label, .mysearch label{color: #292929;}
    	.myselect select{height: 35px; width: 100%; padding: 0 5px;}
    	
    	.mysearch label{display:block;}
    	.mysearch input{width:80% !important; border:1px solid #cccccc; height: 35px; padding: 0 12px;}
    	
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
            <?php $this->load->view("admin/common/sidebar"); ?>

            <div class="main-panel">
                <!--head -->
                <?php $this->load->view("admin/common/header"); ?>
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
                                    <form id="add2" form="" action="<?php echo site_url("admin/exports_invoice"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Orders List"); ?></h4>
                                        <div  class="toolbar">
                                            <div class="row">
                                                <div class="col-md-5 pull-right">
                                                    <div class="input-group input-daterange">
                                                        <input type="text" id="min-date" name="fromdate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
                                                        <div class="input-group-addon">to</div>
                                                        <input type="text" id="max-date" name="todate" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 pull-right">
                                                <div class=" col-md-12 input-group input-daterange">
                                                        <span id="select_status"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                        <div class="material-datatables">
                                            <table id="example" class="table table-striped table-no-bordered table-hover custom-table" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><?php echo "ID";?></th>
                                                        <th class="text-center"><?php echo "User";?></th>
                                                        <th class="text-center"><?php echo "Product Name";?></th>
                                                        <th class="text-center"><?php echo "Product Qty";?></th>
                                                        <th class="text-center"><?php echo "Schedule Day"; ?> </th>
                                                        <th class="text-center"><?php echo "Schedule Time"; ?> </th>
                                                        <th class="text-center"><?php echo "Schedule Status"; ?></th>
                                                        <th class="text-center"><?php echo "Created on"; ?></th>
														<th class="text-center"><?php echo "Created By"; ?></th>
														<th class="text-center"><?php echo "Action"; ?></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                       <th class="text-center"><?php echo "ID";?></th>
                                                        <th class="text-center"><?php echo "User";?></th>
                                                        <th class="text-center"><?php echo "Product Name";?></th>
                                                        <th class="text-center"><?php echo "Product Qty";?></th>
                                                        <th class="text-center"><?php echo "Schedule Day"; ?> </th>
                                                        <th class="text-center"><?php echo "Schedule Time"; ?> </th>
                                                        <th class="text-center"><?php echo "Schedule Status"; ?></th>
                                                        <th class="text-center"><?php echo "Created on"; ?></th>
														<th class="text-center"><?php echo "Created By"; ?></th>
														<th class="text-center"><?php echo "Action"; ?></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>

                                                    <?php  foreach ($today_orders as $order) { ?>
                                                        <tr>
                                                            <td><?php echo $order->schedule_id; ?></td>
                                                            <td><?php echo ucfirst($order->user_fullname); ?></td>
                                                            <td><?php echo $order->product_name; ?></td>
                                                            <td><?php echo $order->schedule_product_qty; ?></td>
															<?php  $days=  json_decode($order->schedule_day);
																	$all = array();
																	
																	foreach ($days as $v){
																		if($v == '1'){
																			$d = 'Monday';
																		}elseif($v == '2'){
																			$d = 'Tuesday';
																		}elseif($v == '3'){
																			$d = 'Wednesday';
																		}elseif($v == '4'){
																			$d = 'Thursday';
																		}elseif($v == '5'){
																			$d = 'Friday';
																		}elseif($v == '6'){
																			$d = 'Saturday';
																		}elseif($v == '7'){
																			$d = 'Sunday';
																		}
																		$all[] = array(
																			'day' => $d
																		);
																	} 
																	//$daystest = implode(',',$all);
																	?>
															
															
                                                            <td><?php 
                                                            $day = '';  
                                                            foreach ($all as $T){ 
                                                                if(empty($day)){ 
                                                                    $day =  $T['day']; 
                                                                }
                                                                else{ 
                                                                    $day = $day.', '.$T['day']; 
                                                                } 
                                                            }  echo $day;?> </td>
                                                            <td><?= $order->schedule_time; ?></td>
                                                            <td><?php echo  $order->schedule_status==1 ? 'Active' : 'Blocked'	?></td>
                                                          
                                                            <td><?=$order->crt_at?></td>
                                                            <td><?=$order->crt_by?></td>
															
                                                            <td><!--<a href="<?php echo site_url("admin/orderdetails/" . $order->schedule_id); ?>" class="btn btn-success action-btn-detail" title="Order Details"> -->
                                                            <!--<i class="material-icons">info</i></a>-->
                                                                <div class="dropdown" style="display:inline;">
                                                                    <a class="btn btn-success action-btn-edit dropdown-toggle" data-toggle="dropdown" title="More Actions"> <i class="material-icons">edit</i>
                                                                        <span class="caret"></span></a>
                                                                    <ul class="dropdown-menu">
                                                                     

                                                                        <li>
                                                                            <a href="<?php echo site_url("admin/delete_order_schedule/" . $order->schedule_id); ?>"> <?php echo 'Cancel Schedule order'; ?></a>
                                                                        </li>
                
                                                                       
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
<?php $this->load->view("admin/common/footer"); ?>
            </div>
        </div>
        <!--fixed -->
<?php $this->load->view("admin/common/fixed"); ?>
    </body>
    
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="<?php echo base_url($this->config->item("new_theme") . "/assets/js/demo.js"); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
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
            table.on('click', '.edit', function () {
                $tr = $(this).closest('tr');

                var data = table.row($tr).data();
                alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
            });

            // Delete a record
            table.on('click', '.remove', function (e) {
                $tr = $(this).closest('tr');
                table.row($tr).remove().draw();
                e.preventDefault();
            });

            //Like record
            table.on('click', '.like', function () {
                alert('You clicked on Like button');
            });

            $('.card .material-datatables label').addClass('form-group');
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function () {
            // Bootstrap datepicker
            // Extend dataTables search
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var min = $('#min-date').val();
                        var max = $('#max-date').val();
                        var createdAt = data[7] || 0; // Our date column in the table

                        if (
                                (min == "" || max == "") ||
                                (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
                                ) {
                            return true;
                        }
                        return false;
                    }
            );

            $('.input-daterange input').each(function () {
                $(this).datepicker('clearDates');
            });
            table = $('#example').DataTable({
                "order": [[0, "desc"]],
                "dom": "<'row border-dark'<'col-sm-2 myselect'l><'col-sm-3 mybtn'B><'#cat.col-sm-2 myselect'><'col-sm-5 mysearch'f>>" 
                        + "<'row'<'col-sm-12'i>>" 
                        + "<'row'<'col-sm-12'tr>>" 
                        + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                //dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
            $("#example thead th").each(function (i) {
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
            // var select = $('<select class="">\n\
            //                             <option value="">Select Order Status</option>\n\
            //                             <option value="Pending">Pending</option>\n\
            //                             <option value="Confirm">Confirm</option>\n\
            //                             <option value="Out">Out</option>\n\
            //                             <option value="Cancel">Cancel</option>\n\
            //                             <option value="Complete">Complete</option>\n\
            //                         </select>')
            //         .appendTo($('#cat'))
            //         .on('change', function () {
            //             table.column(7)
            //                     .search($(this).val())
            //                     .draw();
            //         });
/*
            table.column(10).data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '">' + d + '</option>')
            });
            */
// Re-draw the table when the a date range filter changes
            $('.date-range-filter').change(function () {
                table.draw();
            });

            $('#my-table_filter').hide();

        });
    </script>

</html>