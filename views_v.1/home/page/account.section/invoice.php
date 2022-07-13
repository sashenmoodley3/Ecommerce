<?php //print_r($user_order_list);

$orderList  =   $user_order_list[0];


?>
<style>
    @media print {

  body {
    margin: 0;
    color: #000;
    background-color: #fff;
  }

</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="col-xs-12 col-sm-9 ">
    <div class="my-account">
        <div class="page-title">
            <h2><?=$this->lang->line("My Order")?></h2>
        </div>
        <div id="invoice">

            <div class="hidden-print">
                <div class="text-right">
                    <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print / Download</button>
                </div>
            </div>
            <div class="invoice overflow-auto" style="
    overflow: scroll;>
                <div style="min-width: 600px">
                    <header>
                        <div class="row">
                            <div class="col-sm-3">
                                    <img src="<?=base_url()?>backend/uploads/company/<?=$this->config->item('company_logo1')?>" data-holder-rendered="true" />
                            </div>
                            <div class="col-sm-9 company-details">
                                <h2 class="name">
                                    <?=$this->config->item('name')?>
                                </h2>
                                <div><?=$this->config->item('address')?></div>
                                <div><?=$this->config->item('mobile')?></div>
                                <div><?=$this->config->item('email')?></div>
                            </div>
                        </div>
                    </header>
                    <main>
                        <div class="row contacts">
                            <div class="col-sm-6 invoice-to">
                                <div class="text-gray-light"><?=$this->lang->line("INVOICE TO")?>:</div>
                                <h2 class="to"><?=$orderList['receiver_name']?></h2>
                                <div class="address"><?=$orderList['house_no']?>, <?=$orderList['socity_name']?></div>
                                <div class="email"><a href="tel:<?=$orderList['receiver_mobile']?>"><?=$orderList['receiver_mobile']?></a></div>
                            </div>
                            <div class="col-sm-6 invoice-details">
                                <h1 class="invoice-id"><?=$this->lang->line("INVOICE")?> #<?php echo strtoupper(substr($this->config->item('name'),0,2)).'000'.$orderList['sale_id'];  ?></h1>
                                <div class="date"><?=$this->config->item('vat')?>: <?=$this->config->item('tax_no')?></div>
                                <div class="date"><?=$this->lang->line("Date of Invoice")?>: <?=date('d M, Y', strtotime($orderList['created_at']))?></div>
                            </div>
                        </div>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-left"><?=$this->lang->line("Item")?></th>
                                    <th class="text-right"><?=$this->lang->line("PRICE")?></th>
                                    <th class="text-right"><?=$this->lang->line("QTY")?></th>
                                    <th class="text-right"><?=$this->lang->line("SUBTOTAL")?></th>
                                    <th class="text-right">VAT</th>
                                    <th class="text-right"><?=$this->lang->line("TOTAL")?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //print_r($user_orderItem_list);
                                    $sn=1;
                                    $subtotal=0;
                                    $calculate_Vat=0;
                                    foreach($user_orderItem_list as $row){
//                                        echo "<pre>";
//                                        print_r($row);
                                    ?>
                                <tr>
                                    <td class="no"><?=$sn?></td>
                                    <td class="text-left">
                                        <?php
                                            $productimg     =   explode(',', $row['product_image']);
                                        ?>
                                        
                                        
                                        
                                        <img src="<?=base_url()?>backend/uploads/products/<?=$productimg[0]?>" style="height:100px;">
                                        <span><?=$row['product_name']?></span>
                                        
                                    </td>
                                    <td class="unit">
                                        <?php $single_item_price  = $row['price'];?> 
                                        <?=$this->config->item('currency').number_format($single_item_price, 2, '.', '').'('.$row['qty_in_kg'].' '.$row['unit'].')'?>
                                    </td>
                                    <td class="qty"><?=$row['qtys']?></td>
                                    <td class="text-center">
                                                    <?php echo $this->config->item("currency"); ?>
                                                    <?php $subtotalVal =$row['qtys'] * $single_item_price;
                                            
                                                    echo number_format(($row['qtys'] * $single_item_price),2);
                                                    //$total_price += ($items->qtys * $single_item_price);
                                                    //echo '>>'.$total_price;
                                                        $subtotal += $subtotalVal;
                                                    ?>
                                                </td>
                                    
                                    <td class="qty"><?php echo $this->config->item("currency"); ?>
                                                    <?php  //echo $items->tax;
                                                   
                                                    $Vat_amount = (($row['tax'] / 100) * $single_item_price) * $row['qtys'];
                                                    
                                                    $Vat_amount = number_format($Vat_amount, 2);
                                                    $calculate_Vat += $Vat_amount;
                                            
                                                    echo $Vat_amount." (".$row['tax']."%)";
                                            
                                                    ?></td>
                                    
                                    <td class="total"><?=$this->config->item('currency')?><?=number_format($row['price']*$row['qtys'] + $Vat_amount, 2, '.', '')?></td>
                                </tr>
                            <?php $sn =$sn+1; } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2"><?=$this->lang->line("SUBTOTAL")?></td>
                                    <td><?=$this->config->item('currency').number_format($subtotal, 2, '.', '')?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2"><?=$this->lang->line("VAT")?></td>
                                    <td><?=$this->config->item('currency').number_format($calculate_Vat, 2, '.', '')?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2"><?=$this->lang->line("GRAND TOTAL")?></td>
                                    <td><?=$this->config->item('currency').number_format($subtotal + $calculate_Vat, 2, '.', '')?></td>
                                </tr>
                                <tr>
								<?php 
								$delivery_charge = !empty($orderList['delivery_charge']) ? $orderList['delivery_charge'] : 0;
								if($orderList['free_delivery_amount'] <= $orderList['total_amount']){
									$delivery_charge = 0;
								}

								?>
                                    <td colspan="4"></td>
                                    <td colspan="2"><?=$this->lang->line("Delivery Charges")?></td>
                                    <td><?= !empty($delivery_charge) ? $this->config->item('currency').number_format($delivery_charge, 2, '.', '') : '<label class="text-primeries">Free</label>'?></td>
                                </tr>
                                <?php if(!empty($orderList['coupan_amount_use'])){ ?>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2"><?=$this->lang->line("Apply Coupan")?></td>
                                    <td><?=$this->config->item('currency').number_format($orderList['coupan_amount_use'], 2, '.', '')?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2"><?=$this->lang->line("Wallet Anmount")?></td>
                                    <td>-<?=$this->config->item('currency').number_format($orderList['wallet_amount'], 2, '.', '')?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2">Payable Amount</td>
                                    <td><?=$this->config->item('currency')?><?=number_format((($orderList['total_amount']+$delivery_charge)-$orderList['coupan_amount_use']), 2, '.', '')?></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        
                    </main>
                    
                </div>
                <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                <div></div>
            </div>
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

    $(document).on('click','#printInvoice', function(e){
         var Contents_Section = document.getElementById('invoice').innerHTML;
         var originalContents = document.body.innerHTML;
    
         document.body.innerHTML = Contents_Section;
    
         window.print();
    
         document.body.innerHTML = originalContents;
    });    
    </script>
