<?php  $this->load->view("admin/common/head"); ?>
</head>

<body>
<div class="wrapper">
    <!--sider -->
    
    <?php
     //print_r($order);die();
    $this->load->view("admin/common/sidebar"); ?>

    <div class="main-panel">
        <!--head -->
        <?php $this->load->view("admin/common/header"); ?>
        <!--content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($error)) {
                            echo $error;
                        }
                        echo $this->session->flashdata('success_req');
                        
                        
                        
                        if(!empty($order)){
                        
                        ?>
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="purple">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title"><?php echo $this->lang->line("Order Detail"); ?></h4>
                                <!--a class="pull-right" href="<?php echo site_url(""); ?>">ADD NEW STORE</a-->
                                <div class="toolbar">
                                    <button class="btn btnt-primary pull-right" onclick="printDiv('printableArea')">Print / Download
                                    </button>
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div id="printableArea" class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                           cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th colspan="8"
                                                class="text-center"><?php echo $this->lang->line("Invoice"); ?></th>

                                            <!--th class="text-center" style="width: 100px;"> <?php echo $this->lang->line("Action"); ?></th-->
											
											<input type="hidden" id="order_id" value="<?php echo $order->sale_id; ?>">
                                        </tr>
                                        </thead>
                                        
                                        <tbody>
                                        <tr>
                                            <td colspan="8">
                                                <table class="table">
                                                    <tr>
                                                        <td style="width:679px">
                                                            <div><img style="width: 45%;"
                                                                      src="<?php echo $this->config->item('base_url').'uploads/company/'.$this->config->item('company_logo1'); ?>">
                                                            </div>
                                                          
                                                            <br/>
                                                            <strong> <?php echo $this->lang->line("Order Id : "); ?><?php echo $order->sale_id; ?></strong>
                                                            <br/>

                                                            <strong>  <?php echo $this->lang->line("Order Date : "); ?> <?php echo date('d-m-Y', strtotime($order->on_date)); ?></strong><br/>
                                                            
                                                            <strong> <?php echo $this->config->item('vat'); ?>: <?php echo $this->config->item('tax_no'); ?></strong>
                                                            <br/>
                                                            <br/>
                                                            <br/>

                                                        </td>
                                                        <td style="width:325px">
                                                            <!--<strong> <?php echo $this->lang->line("Delivery Details :"); ?></strong><br/>-->
                                                            <strong>Name:</strong><?php echo !empty($order->receiver_name) ? $order->receiver_name : $order->user_fullname; ?>,<br />
                                                            <strong>Mobile:</strong> <?php echo $order->receiver_mobile; ?>,<br />
                                                            <strong>Email:</strong> <?php echo $order->user_email; ?>,<br />
                                                            <strong><?php echo $this->lang->line("Delivery Time :"); ?></strong> <?php echo $order->delivery_time_from . " to " . $order->delivery_time_to; ?><br />
                                                            
                                                        
                                                        </td>
                                                        <td style="width:325px">
                                                            
                                                            <strong>  <?php echo $this->lang->line("Address :"); ?></strong>
                                                            <address>
                                                                <!--                                                                        -->
                                                                <?php echo $order->house_no; ?><br />
                                                                <?php echo $order->delivery_address; ?><br />
                                                                <?php echo $order->pincode; ?>
                                                            </address>
                                                            
                                                        </td>
                                                        

                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <!--<th class="text-center"><?php echo $this->lang->line("Category"); ?></th>-->
                                            <th class="text-center"><?php echo $this->lang->line("Product Name"); ?></th>
                                            <!--<th class="text-center"><?php echo $this->lang->line("Discription"); ?>Discription</th>-->
                                             <th class="text-center">Unit</th>
                                            <th class="text-center"><?php echo $this->lang->line("B/Code"); ?></th>
                                            <th class="text-center"><?php echo $this->lang->line("Price"); ?><br></th>
                                            <th class="text-center"><?php echo $this->lang->line("Qty"); ?></th>
                                            <th class="text-center"><?php echo $this->lang->line("SubTotal"); ?><br></th>  
                                            <th class="text-center"><?= $this->config->item('vat')?></th>
                                            <th class="text-center"><?php echo $this->lang->line("Total"); ?></th>
                                        </tr>
                                        <?php
                                        $total_price    =   0;
                                        $total_qty      =   0;
                                        $calculate_Vat =   0;
                                        $count_pro      =   count($order_items);
                                        //print_r($order_items); 
                                        foreach ($order_items as $items) {
                                           
                                            $subtotal =0;
                                            $single_item_price  = $items->item_price; //($items->item_price *100)/(100+ $items->tax);
                                            
                                            $price_without_tax  = $items->qtys * $items->item_price; //( $items->qtys * ($items->item_price *100)/(100+ $items->tax)) ;
											
											$item_product_name = $items->product_name;
                                            if(!empty($items->flavor)){
                                                $item_product_name = $items->product_name.' ('.$items->flavor.')';
                                            }

                                            ?>
                                            <tr class="text-center">
                                                <!--<td><?=$items->category_name; ?></td>-->
                                                <td  style="width: 20%"><?=$item_product_name; ?> </td>
                                                <!--<td style="width: 20%"><?=strip_tags($items->product_description); ?> </td>-->
                                                <td><?=$items->qty.' '.$items->unit; ?> </td>
                                                <td><?=$items->prod_sku_code; ?> </td>
                                                <td><?=$this->config->item("currency");?><?=number_format($single_item_price,2); ?> </td>
                                                <td><?php 
                                                    echo $items->qtys; 
                                                    $total_qty +=$items->qtys;
                                                    ?> 
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $this->config->item("currency"); ?>
                                                    <?php $subtotal =$items->qtys * $single_item_price;
                                            
                                                    echo number_format(($items->qtys * $single_item_price),2);
                                                    //$total_price += ($items->qtys * $single_item_price);
                                                    //echo '>>'.$total_price;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $this->config->item("currency"); ?>
                                                    <?php  //echo $items->tax;
                                                    
                                                    $Vat_amount = (($items->tax / 100) * $items->item_price) * $items->qtys;   //($items->qtys*$items->item_price)- ( $items->qtys * ($items->item_price *100)/(100+ $items->tax)); 
                                                    
                                                    //$Vat_amount = number_format($Vat_amount, 2);
                                                    $calculate_Vat += $Vat_amount;
                                            
                                                    echo number_format($Vat_amount, 2)." (".$items->tax."%)";
                                            
                                                    ?>
                                                    
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $this->config->item("currency"); ?>
                                                    <?php //echo $subtotal =number_format(($items->qtys * $single_item_price),2);
                                                    //echo $total_price += ($items->qtys * $single_item_price);
                                             $total= ($items->qtys * $items->item_price) + $Vat_amount;
                                           echo number_format((($items->qtys * $items->item_price) + $Vat_amount),2);
                                            
                                            $total_price +=$total;
                                                    //echo '>>'.$total_price;
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center" colspan="2"><strong> <?php echo $this->lang->line("Total amount"); ?></strong> : </td>
                                            <td class="text-center"><strong class=""><?php echo $this->config->item("currency"); ?>
                                                    <?php echo number_format($total_price,2, '.', ''); ?>
                                                </strong>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center" colspan="2"><strong> <?php echo $this->lang->line("Total"); ?> <?= $this->config->item('vat')?> </strong> :</td>
                                            <td class="text-center"> <strong class=""><?php echo $this->config->item("currency"); ?><?php 
                                                echo number_format($calculate_Vat,2, '.', '');
                                            ?></strong></td>
                                        </tr>
                                        
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="2"  class="text-center"><strong><?php echo $this->lang->line("Delivery Charges"); ?> :</strong></td>
                                            <td class="text-center">
                                                <strong class="">
                                                    <?php echo $this->config->item("currency"); ?>
                                                    <?php 
                                                    $delivery_charge    =   0;
                                                    if($order->free_delivery_amount > $total_price){
                                                         $delivery_charge = $order->delivery_charge;
                                                    }
                                                        
                                                        echo "+".number_format((float)$delivery_charge, 2, '.', '');
                                                    ?>
                                                    </strong>
                                            </td>
                                        </tr>
                                        
                                        <!-- <tr>
                                                <td><strong> <?php echo $this->lang->line("Total Odrer GST"); ?></strong> : </td>
                                                <td><?php echo $this->config->item("currency").number_format($calculate_Vat,2, '.', ''); ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <td colspan="2"  class="text-center"><strong><?php echo $this->lang->line("Delivery Charges"); ?> :</strong></td>
                                            <td class="text-center">
                                                <strong class="">
                                                    <?php echo $this->config->item("currency"); ?>
                                                    <?php 
                                                    $delivery_charge    =   0;
                                                    if($order->free_delivery_amount > $total_price){
                                                         $delivery_charge = $order->delivery_charge;
                                                    }
                                                        
                                                        echo "+".number_format((float)$delivery_charge, 2, '.', '');
                                                    ?>
                                                    </strong>
                                            </td>
                                        </tr> -->
                                        
                                        <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <td colspan="2" class="text-center"><strong
                                                        ><?php echo $this->lang->line("Coupan Amount"); ?>  :</strong></td>
                                            <td class="text-center">
                                                <strong class="">
                                                    <?php echo $this->config->item("currency"); ?> 
                                                    <?php
                                                    $coupan_amount  =   $order->coupan_amount_use;
                                                    if(empty($order->coupan_amount_use) && $order->coupan_amount_use == 0 ){
                                                            $coupan_amount = 0.00;
                                                        }
                                                        
                                                        echo "-".number_format((float)$coupan_amount, 2, '.', '');
                                                         //echo  $coupan_amount;
                                                         //echo $this->config->item("currency");
                                                        ?>
                                                </strong>
                                            </td>
                                        </tr>


                                        <!--<tr>
                                            <td colspan="2">
                                                <strong class="pull-right"><?php echo "Use Wallet" ?> :</strong>
                                            </td>
                                            <td class="text-center">
                                                <strong class="">
                                                <?php echo $this->config->item("currency"); ?><?php 
                                                $wallet = 0;
                                                if(!empty($order->dr_id)){
                                                    $wallet = $order->dr_id;
                                                }
                                                $wallet = number_format((float)$wallet, 2, '.', '');
                                                echo  "-".$wallet;
                                                                    
                            
                                                $wallet = $total_price - $order->total_amount;
                                                ?>
                                                </strong>
                                            </td>
                                        </tr>-->


                                        <!--<tr>
                                            <td colspan="2"><strong>
                                                        <td class="pull-right">Discount(Rs.):
                                                    </strong></td>
                                           <td class="text-center">
                                               <strong class="">
                                               <?php echo $this->config->item("currency"); ?> 
                                                    <?php
                                                        $discount_data = -($total_price - $order->total_amount);
                                                     "-".  number_format((float)$discount_data , 2, '.', '') ; ?>
                                                </strong>
                                            </td>
                                        </tr>-->
                                        
                                        <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <td colspan="2"  class="text-center"><strong
                                                       ><?php echo $this->lang->line("Wallet Used"); ?>  :</strong></td>
                                            <td class="text-center">
                                                <strong class="">
                                                    <?php echo $this->config->item("currency"); ?> 
                                                    <?php
                                                    $wallet_amount  =   0.00;
                                                    if(!empty($order->wallet_amount)){
                                                        $wallet_amount = $order->wallet_amount;
                                                    }
                                                        
                                                    
                                                        if(empty($wallet_amount) && $wallet_amount == 0 ){
                                                            $wallet_amount = 0.00;
                                                        }
                                                         // echo  $wallet_amount;
                                                         echo "-".number_format((float)$wallet_amount, 2, '.', '');
														 
                                                        ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <td colspan="2"  class="text-center"><strong><?php echo $this->lang->line("Payable Amount"); ?>
                                                    :</strong></td>
                                            <td class="text-center">
                                                <strong class="">
                                                    <?php echo $this->config->item("currency"); ?> 
                                                    <?php 
                                                        $net = (($total_price + $delivery_charge) - $wallet_amount)-$coupan_amount;
                                                        
                                                        echo number_format((float)$net, 2, '.', '');
                                                        ?>
                                                        
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end content-->
                        </div>
                        <!--  end card  -->
                        <?php } ?>
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
<!--   Core JS Files   -->

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme") . "/assets/js/demo.js"); ?>"></script>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
		 
        $('#datatables').DataTable({
            dom: 'Bfrtip',
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

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
    });

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>


</html>