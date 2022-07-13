
  
<!--Container -->
<div class="error-page">
    <div class="container">
        <div class="error_pagenotfound"> 
                <div id="printableArea" class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                           cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th colspan="8"
                                                class="text-center"><?php echo "Order Details"; ?></th>

                                        </tr>
                                        </thead>
                                      
                                        <tbody>
                                        <tr>
                                            <td colspan="8">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <div><img style="width: 45%;"
                                                                      src="<?php echo $this->config->item('base_url').'uploads/company/'.$this->config->item('favicon'); ?>">
                                                            </div>
                                                            <strong> <?php echo $this->lang->line("Order Id : "); ?><?php echo $order->sale_id; ?></strong>
                                                            <br/>

                                                            <strong>  <?php echo $this->lang->line("Order Date : "); ?><?php echo date('d-m-Y', strtotime($order->on_date)); ?></strong>
                                                            <br/>

                                                        </td>
                                                        <td>
                                                            <strong> <?php echo $this->lang->line("Delivery Details :"); ?></strong><br/>
                                                            <strong>Name:<?php echo $order->receiver_name; ?>
                                                                ,
                                                                <br/> Mobile: <?php echo $order->receiver_mobile; ?>
																
															,
															<br/>Email: <?php echo $order->user_email; ?>
                                                            </strong>
                                                            <br/>
                                                            <strong>  <?php echo $this->lang->line("Address :"); ?></strong>
                                                            <address>
                                                                <!--                                                                        -->
                                                                <?php echo $order->socity_name; ?><br />
                                                                <?php echo $order->delivery_address; ?><br />
                                                                <?php echo $order->pincode; ?>
                                                            </address>
                                                            <?php echo $this->lang->line("Delivery Time :"); ?> <?php echo $order->delivery_time_from . " to " . $order->delivery_time_to; ?></p>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-center">Category</th>
                                            <th class="text-center"><?php echo $this->lang->line("Product Name"); ?></th>
                                            <th class="text-center">Discription</th>
                                            <!--<th class="text-center">S/C</th>-->
                                            <th class="text-center">B/Code</th>
                                            <th class="text-center">Rate<br></th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center"><?php echo $this->config->item("currency"); ?>Amount</th>
                                            <th class="text-center">Vat</th>
                                        </tr>
                                        <?php
                                        $total_price    =   0;
                                        $total_qty      =   0;
                                        $calculate_Vat =   0;
                                        $count_pro      =   count($order_items);
                                        //print_r($order_items); 
                                        foreach ($order_item as $items) {
                                            $single_item_price  = ($items->item_price *100)/(100+ $items->tax);
                                            $price_without_tax = ( $items->qty * ($items->item_price *100)/(100+ $items->tax)) ;
//                                                                                    print_r($items);die();
                                            ?>
                                            <tr class="text-center">
                                                <td><?=$items->category_name; ?></td>
                                                <td  style="width: 20%"><?=$items->product_name; ?> </td>
                                                <td style="width: 20%"><?=strip_tags($items->product_description); ?> </td>
                                                <!--<td><?=$items->prod_ware_location; ?> </td>-->
                                                <td><?=$items->prod_sku_code; ?> </td>
                                                <td><?=$this->config->item("currency");?><?=number_format($single_item_price,2); ?> </td>
                                                <td><?php 
                                                    echo $items->qty; 
                                                    $total_qty +=$items->qty;
                                                    ?> 
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $this->config->item("currency"); ?>
                                                    <?php echo number_format(($items->qty * $single_item_price),2);
                                                    $total_price = $total_price + ($items->qty * $single_item_price);
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php  echo $items->tax;
                                                    
                                                    $calculate_Vat += ($items->qty*$items->item_price)- ( $items->qty * ($items->item_price *100)/(100+ $items->tax)); ?>
                                                    
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
                                            <td class="text-left" colspan="3"><strong> Total amount</strong> : </td>
                                            <td class="text-left"><strong class=""><?php echo $this->config->item("currency"); ?>
                                                    <?php echo number_format($price_without_tax,2, '.', ''); ?>
                                                </strong>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-left" colspan="3"><strong> Total Vat </strong> :</td>
                                            <td class="text-left"> <strong class=""><?php echo $this->config->item("currency"); ?><?php 
                                                echo number_format($calculate_Vat,2, '.', '');
                                            ?></strong></td>
                                        </tr>
                                        
                                        <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <td colspan="3"><strong class="text-left"><?php echo $this->lang->line("Delivery Charges"); ?> :</strong></td>
                                            <td class="text-left">
                                                <strong class="">
                                                    <?php echo $this->config->item("currency"); ?>
                                                    <?php 
                                                        $delivery_charge = $order->delivery_charge; 
                                                        echo "+".number_format((float)$delivery_charge, 2, '.', '');
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
                                            <td colspan="3"><strong
                                                        class="text-left">Wallet Used  :</strong></td>
                                            <td class="text-left">
                                                <strong class="">
                                                    <?php echo $this->config->item("currency"); ?> 
                                                    <?php
                                                    $wallet_amount  =   0;
                                                    if(!empty($order->dr_id)){
                                                        $wallet_amount = $order->dr_id;
                                                    }
                                                        
                                                    
                                                        if(empty($wallet_amount) && $wallet_amount == 0 ){
                                                            $wallet_amount = '0';
                                                        }
                                                         echo  "- ".$wallet_amount." ";
                                                         //echo $this->config->item("currency");
                                                        ?>
                                                </strong>
                                            </td>
                                        </tr>

                                        
                                        
                                        
                                        
                                        <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <td colspan="3"><strong
                                                        class="text-left">Payable Amount
                                                    :</strong></td>
                                            <td class="text-left">
                                                <strong class="">
                                                    <?php echo $this->config->item("currency"); ?> 
                                                    <?php 
                                                        $net = $price_without_tax + $calculate_Vat + $delivery_charge - $wallet_amount;
                                                        
                                                        echo number_format((float)$net, 2, '.', '');
                                                        ?>
                                                        
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
        </div>
      
    </div>
</div>
 <!-- Container End -->