<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="col-xs-12 col-sm-9 ">
    <div class="my-account">
        <div class="page-title">
            <h2><?=$this->lang->line("My Order")?></h2>
        </div>
        <div class="table-responsive">
            <?php if(!empty($user_order_list)):
			
			
			?>
            <table id="datatables" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="th-details"><?=$this->lang->line("Order Id")?></th>
                        <th class="th-details"><?=$this->lang->line("Placed On")?></th>
                        <th class="th-details"><?=$this->lang->line("Time")?></th>
                        <th class="th-price"><?=$this->lang->line("Price")?></th>
                        <th class="th-price"><?=$this->lang->line("Items")?></th>
                        <th class="th-details"><?=$this->lang->line("Status")?></th>
                        <th class="th-total th-add-to-cart" ><?=$this->lang->line("Action")?></th>
                        <th class="th-total th-add-to-cart" ><?=$this->lang->line("History")?></th>
                        <th class="th-total th-add-to-cart" ><?=$this->lang->line("Invoice")?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //var_dump($user_order_list);
                    foreach ($user_order_list as $key => $user_order):
                        $order_id = $user_order->sale_id;
                        $on_date = $user_order->on_date;
                        $delivered_date = $user_order->order_deliverd_date;
                        $refund_time_limit  =   '+'.$this->config->item('refund_time_limit').' hours';
						
                        $next_48 = date('Y-m-d H:i:s', strtotime($refund_time_limit, strtotime($delivered_date) ));
                        
                        $delivery_time_from = $user_order->delivery_time_from;
                        $delivery_time_to = $user_order->delivery_time_to;
                        $order_status = $user_order->status;
                        $total_amount = $user_order->total_amount;
                        $total_items = $user_order->total_items;
						// if($user_order->free_delivery_amount > $user_order->total_amount){
						// 	$total_amount = ($user_order->total_amount+$user_order->delivery_charge);
						// }
						// else{
						// 	$total_amount = $user_order->total_amount;
						// }

                    ?>
                    <tr>
                        <td class="th-product"><a href="<?=base_url()?>order_tracking/<?=$order_id?>"><?=$order_id?></a></td>
                        <td class="th-product"><?= $on_date == '1970-01-01' ? '' : $on_date?></td>
                        <td class="th-product"><?=$on_date == '1970-01-01' ? '' : $delivery_time_from.'-'.$delivery_time_to?></td>
                        <td class="th-price">R.<?=$total_amount?></td>
                        <td class="th-price"><?=$total_items?></td>
                        <td class="th-product">
                            <?php
                            if ($order_status == 0) {
                                echo "<span class='label label-default'>Pending</span>";
                            } 
							else if ($order_status == 1) {
                                echo "<span class='label label-info'>Confirm</span>";
                            } 
							else if ($order_status == 2 || $order_status == 5) {
                                echo "<span class='label label-warning'>Dispatched</span>";
                            } 
							else if ($order_status == 3) {
                                echo "<span class='label label-danger'>Cancel</span>";
                            } 
							else if ($order_status == 4) {
                                echo "<span class='label label-success'>Delivered</span>";
                            }
                            else if ($order_status == -1) {
                                echo "<span class='label label-warning'>Return</span>";
                            }
                            ?>
                            
                        </td>
                         
                        <td class="th-product">
                            <?php if ($order_status == 0 || $order_status == 1) { ?>
                                <button class="button"><a href="{base_url}home/cancel_order/<?=$order_id?>">Cancel Order</a></button>
                            <?php } ?>
                            <?php 
                                $date = date('Y-m-d H:i:s');
                          
                                if(($date <= $next_48) && $order_status == 14 ){ //TODO remove 1
								?>
                                   <button class="button"> <a href="{base_url}home/returnOrder/<?=$order_id?>">Return Order</a> </button>
								<?php  
								}
								if($order_status == -1){ 
								?>
                                   <button class="button"><a href="{base_url}home/returnOrder/<?=$order_id?>">Return Process</a></button>
								<?php  
								}
                            ?>
                        </td>
                        <td><a href="<?=base_url()?>history/<?=$order_id?>"><i class="fa fa-file-text-o" aria-hidden="true"></i></a></td>
                        
                        
                        <td>
                            <?php 
                               
                                $date = date('Y-m-d H:i:s');
                                if( $order_status == 4 ) //($next_48 <= $date) &&
                               { ?>
                            <a href="<?=base_url()?>invoice/<?=$order_id?>"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                            <?php  }
                            ?>
                        </td>
                        
                        
                        
                        
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php else:?>
            <div class="table-responsive text-center">
                <h3><?=$this->lang->line("Order Empty")?></h3>
                <hr/>
<!--                <a class="continue-btn" href="{base_url}/home"><i class="fa fa-arrow-left"> </i>&nbsp; Continue shopping</a> -->
            </div>
            <?php endif;?>
            <div class="cart_navigation">
                <a class="continue-btn" href="{base_url}/shop"><i class="fa fa-arrow-left"> </i>&nbsp; <?=$this->lang->line("Continue shopping")?></a> 
            </div>
            <div class="cart_navigation">
                <a class="checkout-btn" href="{base_url}/checkout"><i class="fa fa-check"></i> <?=$this->lang->line("Proceed to checkout")?></a> 
            </div>
            <!-- <div class="register-benefits">
                <h5><?=$this->lang->line("Mange Profile today and you will be able to")?> :</h5>
                <ul>
                    <li><?=$this->lang->line("Speed your way through checkout")?></li>
                    <li><?=$this->lang->line("Track your orders easily")?></li>
                    <li><?=$this->lang->line("Keep a record of all your purchases")?></li>
                </ul>
            </div> -->
        </div>
    </div>


</div>
<script type="text/javascript" src="{base_url}assets/js/jquery.min.js"></script>
 <!--  DataTables.net Plugin    -->
    <script src="{base_url}assets/js/jquery.datatables.js"); ?>"></script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script>
        $(document).ready(function () {
            
            $('#datatables').DataTable({
                 "order": [[0, "desc"]],
                 "dom": "<'row border-dark'<'col-sm-2 myselect'l><'col-sm-3 mybtn'B><'#cat.col-sm-2 myselect'><'col-sm-5 mysearch'f>>" 
                        + "<'row'<'col-sm-12'i>>" 
                        + "<'row'<'col-sm-12'tr>>" 
                        + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
               // dom: 'Bfrtip',
               buttons: [
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
        });

       
    </script>
