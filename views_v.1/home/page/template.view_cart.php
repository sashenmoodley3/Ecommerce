 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Main Container -->
<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="cart">

                <div class="page-content page-order">
                    <div class="page-title">
                        <h2><?=$this->lang->line("Shopping Cart")?></h2>
                    </div>
                    <?php
                    
                    if (!empty($get_cart_product_arr)):
                        ?>
                        <div class="order-detail-content order_detail">
                            <div class="table-responsive">
                                <table class="table table-bordered cart_summary" id="cart_summary">
                                    <thead>
                                        <tr>
                                            <th class="cart_product"><?=$this->lang->line("Product")?></th>
                                            <th><?=$this->lang->line("Description")?></th>
                                            <th><?=$this->lang->line("Unit price")?></th>
                                            <th>Stock</th>
                                            <th><?=$this->lang->line("Qty")?></th>
                                            <th><?=$this->lang->line("Total")?></th>
                                            <th  class="action"><i class="fa fa-trash-o"></i></th>
                                            <!-- <th><?=$this->lang->line("Saving")?></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  //print_r($get_cart_product_arr);
                                        $total_order_price = 0;
                                        $saveprice          =0;
                                        foreach ($get_cart_product_arr as $key => $product):
                                            $qty                    = $product['buy_qty'];
                                            $product_id             = $product['product_id'];
                                            $product_varient_id     = $product['varient_id'];
                                            $product_name           = $product['product_name'];
                                            $product_description    = $product['product_description'];
                                             
                                            
                                            $pro1                   = explode(',', $product['product_image']);
                                            $product_image          = $product_img_url. $pro1[0];
                                            
                                            $category_id            = $product['category_id'];
                                            $in_stock               = $product['in_stock'];
                                            $stock_amount           = $product['stock_inv'];
                                            $mrp                    = $product['mrp'];
                                            $unit_value             = $product['unit'];
                                            $unit                   = $product['qty'];
                                            $increament             = $product['increament'];
                                            $rewards                = $product['rewards'];
                                            $tax                    = $product['tax'];
                                            $product_price          = $product['price'];
                                            $mrp                    = $product['mrp'];
                                            $q_variants             = $this->db->query("Select * from product_varient where product_id = '".$product_id."' AND varient_id='".$product_varient_id."'")->row();
                                            if (!empty($q_variants->pro_var_images)) {
                                                $product_image  = base_url().'backend/uploads/products/'.$q_variants->pro_var_images;
                                            }
                                            
                                            
                                            $q = $this->db->query("SELECT deal_price FROM deal_product WHERE deal_product.product_id = '".$product_id."' AND pro_var_id = '".$product_varient_id."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                                        AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
                                            $del_price = $q->row();
                                            
                                            if (!empty($del_price)) {
                                                $product_price          = $del_price->deal_price;
                                                $difference_price       = $mrp - $del_price->deal_price;
                                                $total_product_price    = $product_price * $qty;
                                                $total_order_price      += $total_product_price;
                                                $single_price           =   $product_price;
                                            } else {
                                                $product_price = $product_price;
                                                $difference_price       = $mrp - $product_price;
                                                $total_product_price = $product_price * $qty;
                                                $total_order_price += $total_product_price;
                                                $single_price           =   $product_price;
                                            }
                                            //echo $unit.' >> '.$unit_value;
                                            $qty_in_kg = $unit;
                                            $unit_in_kg = $unit_value;
                                            if (($unit_value == "gram") || ($unit_value == "gm") || ($unit_value == "GM")) {
                                                $qty_in_kg = ($unit) / 1000;
                                                $unit_in_kg = "Kg";
                                            }
                                            
                                            $product_price          =   number_format((float)$product_price, 2, '.', '');
                                            $total_product_price    =   number_format((float)$total_product_price, 2, '.', '');
                                            $saveprice              +=  $difference_price*$qty;
                                            $q_slug                 =   $this->db->query("SELECT product_slug FROM products WHERE product_id = '".$product_id."'")->row();
                                            $product_slug           =   $q_slug->product_slug;
                                            $productUrl             =   $this->config->item('base_url')."product/". $product_slug;
                                            ?>
                                            <tr id="list_<?=$product_varient_id?>">
                                                <td class="cart_product cart_products">
                                                    <div class="mobile-show"> <span> <?=$this->lang->line("Product")?></span></div>
					                                <a href="<?=$productUrl?>" target="_blank"><img src="<?= $product_image ?>" alt="Product"></a>
					                           </td>
                                                <td class="cart_description cart_products">
                                                    <div class="mobile-show"> <span> <?=$this->lang->line("Description")?></span></div>
                                                    <p class="product-name"><a href="<?=$productUrl?>" target="_blank"><?= $product_name ?></a></p>
                                                    <?php
                                                    if (!empty($in_stock)):
                                                        echo '<p class="availability in-stock"><span class="label">In stock</span></p>';
                                                    else:
                                                        echo '<p class="availability out-of-stock"><span class="label">No stock</span></p>';
                                                    endif;
                                                    ?>
                                                </td>
                                                
                                                <td class="price cart_products">
                                                    <div class="mobile-show"> <span><?=$this->lang->line("Price")?> </span></div>
                                                     <span>   <?=$this->config->item('currency')?> <?= $product_price ?> /- 
                                                        <small><?= $unit . " " . $unit_value ?></small>
                                                    </span>
                                                </td>
                                                <td class="qty cart_products">
                                                    <div class="mobile-show"> <span>Stock</span></div> 
                                                    <span id="stock_id_<?=$product_varient_id?>"> <?= $stock_amount ?></span>
                                                </td>
                                                <td class="qty cart_products">
                                                    <div class="mobile-show"> <span><?=$this->lang->line("Qty")?> </span></div>
                                                    <input type="hidden" name="product_qty" id="product_qty_<?=$product_varient_id?>" value="<?=$qty?>">
                                                    <input type="hidden" name="product_id" id="product_id1_<?=$product_varient_id?>" value="<?=$product_id?>">
                                                    <input type="hidden" name="product_varient_id" id="product_varient_id1_<?=$product_varient_id?>" value="<?=$varientid?>">
                                                    <input type="hidden" name="price" id="price1_<?=$product_varient_id?>" value="<?=$single_price?>" class="priceee">
                                                    <input type="hidden" name="unit" id="unit1_<?=$product_varient_id?>" value="<?=$unit?>" class="units">
                                                    <input type="hidden" name="unit_value" id="unit_value1_<?=$product_varient_id?>" value="<?=$unit_value?>" class="unit_value">
                                                    <input type="hidden" name="total_product_price" id="total_product_price_<?=$product_varient_id?>" value="<?=$total_product_price?>" class="total_product_price">
                                                    <input type="hidden" name="difference_price" id="difference_price_<?=$product_varient_id?>" value="<?=$difference_price?>" class="difference_price">
                                                    
                                                    <div  class="view_button  <?=empty($in_stock) ? '' : 'dec';?> qtybutton " data-id="<?=$product_id?>" data-varient="<?=$product_varient_id?>" <?=empty($in_stock) ? 'disabled' : '';?>><i class="fa fa-minus">&nbsp;</i></div>
                                                        <input class="form-control input-sm qty_box" type="text" readonly value="<?=empty($in_stock) ? 0 : $qty ?>" id="qty1_<?=$product_varient_id?>">
                                                    <div class="view_buttonplus  <?=empty($in_stock) ? '' : 'inc';?> qtybutton"  data-id="<?=$product_id?>" data-varient="<?=$product_varient_id?>" <?=empty($in_stock) ? 'disabled' : '';?>><i class="fa fa-plus">&nbsp;</i></div>
                                                </td>
                                                <td class="price cart_products">
                                                    <div class="mobile-show"> <span><?=$this->lang->line("Total Price")?> </span></div>
        <!--                                                    <small>(<?= $qty_in_kg . " " . $unit_in_kg ?>)*(<?= $qty ?> Qty)</small><br/>-->
                                                    <span id="single_price_<?=$product_varient_id?>"><?=$this->config->item('currency')?> <?= $total_product_price ?>/-</span><small id="show_qty_<?=$product_varient_id?>">(<?= $qty * $qty_in_kg . " " . $unit_in_kg ?>)</small>
                                                </td>
                                                <td class="action"><a data-id="<?=$product_id?>" data-varient="<?=$product_varient_id?>" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a></td>
                                                <!-- <td class="cart_products">
                                                    <div class="mobile-show"> <span><?=$this->lang->line("Save Price")?> </span></div>
                                                    <span class="uiv2-savings-rate difference_<?=$product_varient_id?>"><?=$this->config->item('currency').' '.number_format((float)($difference_price*$qty), 2, '.', '');?></span>
                                                </td> -->
                                            </tr>
                                            <?php
                                            
                                        endforeach;
                                        ?>
    
                                    </tbody>
                                </table>
                                 <table class="table table-bordered cart_summary" id="cart_summary">
                                    <tbody>
                                        <tr>
                                           <td colspan="4" rowspan="2" class="hidden-sm hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <!-- <td colspan="1"><p class="delivery"><?=$this->lang->line("Delivery Charges")?><i class="fa fa-question quest-info"></i></p></td>
                                            <td colspan="1"><p class="delivery">**</p></td> -->
                                            <!-- <td></td> -->
                                        </tr>
                                        <tr><input type="hidden" name="total" id="total" value="<?=$total_order_price?>" class="total">
                                            <input type="hidden" name="saveprice" id="saveprice" value="<?=$saveprice?>" class="saveprice">
                                            <td colspan="1"><strong><?=$this->lang->line("Total")?></strong></td>
                                            <td colspan="1"><strong><?=$this->config->item('currency')?> <span id="total_amount"><?=number_format((float)$total_order_price, 2, '.', ''); ?> </span></strong></td>
                                            <!-- <td><div class="uiv2-yousaved-wrap"><span><?=$this->lang->line("You saved")?>!</span><span id="totalSaving"><?=$this->config->item('currency').' '.number_format((float)$saveprice, 2, '.', '')?></span></div></td> -->
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="delivery-msg">** Your minimum order value should be **<?=$this->config->item('currency').' '.$this->config->item('minmum order amount');?></p>
                            </div>
                            <div class="cart_navigation">
                                <a class="continue-btn" href="home"><i class="fa fa-arrow-left"> </i>&nbsp; <?=$this->lang->line("Continue shopping")?></a> 
                            </div>
                            <div class="cart_navigation">
                                <a class="checkout-btn" href="checkout"><i class="fa fa-check"></i> <?=$this->lang->line("Proceed to checkout")?></a> 
                            </div>
                        </div>
                        <?php
                    else:
                        $this->load->view('home/page/checkout.section/template.empty_cart.php');
                    endif;
                    ?>
                    <div class="order-detail-content empty_order" style="display:none">
                        <div class="table-responsive text-center">
                            <h5> <?=$this->lang->line("Cart Empty")?></h5>
                            <a class="continue-btn" href="home"><i class="fa fa-arrow-left"> </i>&nbsp;  <?=$this->lang->line("Continue shopping")?></a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
 $(document).on('click','.dec', function(e){
     var product_id         =   $(this).data('id');
     var varation_id        =   $(this).data('varient');
     var qty                =   $('#qty1_'+varation_id).val();
     var old_qty            =   $('#product_qty_'+varation_id).val();
     if( !isNaN( qty ) && qty > 1 ){
         qty  = parseInt(qty)-1;
         $('#qty1_'+varation_id).val(qty);
        var price           =   $('#price1_'+varation_id).val(); 
        var unit            =   $('#unit1_'+varation_id).val();    
        var unit_value      =   $('#unit_value1_'+varation_id).val();
        var toPr_price      =   $('#total_product_price_'+varation_id).val();
        var total           =   $('#total').val(); 
        var saveprice       =   $('#saveprice').val(); 
        var difference_price=   $('#difference_price_'+varation_id).val();
        var savepriceR       =   (parseFloat(saveprice)-(parseFloat(difference_price)*parseInt(old_qty)));
        var increseVal      =   price*parseInt(qty);
        var difference_price=   difference_price*parseInt(qty);
        var IncToAmount     =   parseFloat((parseFloat(total) - parseFloat(toPr_price))+parseFloat(increseVal));
        var savePrice       =   savepriceR+difference_price;
        var qty_in_kg       =   (unit*parseInt(qty));
        var unit_in_kg      =   unit_value;
        if ((unit_value == "gram") || (unit_value == "gm") || (unit_value == "GM")) {
            qty_in_kg = (unit*parseInt(qty))/1000;
            unit_in_kg = "Kg";
        }
        

        addToCart(product_id,varation_id,price,unit,unit_value,qty,'minus'); 
        $('#product_qty_'+varation_id).val(qty);
        $('#saveprice').val(savePrice);
        $('#total').val(IncToAmount);
        $('#total_amount').html(IncToAmount.toFixed(2)+'/-');
        $('#total_product_price_'+varation_id).val(increseVal);
        $('#single_price_'+varation_id).html("<?=$this->config->item('currency')?> "+increseVal.toFixed(2)+'/-');
        $('.difference_'+varation_id).html("<?=$this->config->item('currency')?> "+difference_price.toFixed(2));
        $('#totalSaving').html("<?=$this->config->item('currency')?> "+savePrice.toFixed(2));
        $('#show_qty_'+varation_id).html(' ('+qty_in_kg+''+unit_in_kg+')')     
         
     }
     return false;
 })
 
 $(document).on('click', '.inc', function(e){
     debugger;
     var product_id         =   $(this).data('id');
     var varation_id        =   $(this).data('varient');
     var qty                = $('#qty1_'+varation_id).val();
     var old_qty            =   $('#product_qty_'+varation_id).val();
     var stock              =  $('#stock_id_'+varation_id).html()

     if (parseInt(qty) >= parseInt(stock)) {
        return;
     }
     
     if( !isNaN( qty )){
         qty  = parseInt(qty)+1;
         $('#qty1_'+varation_id).val(qty);
        var price           =   $('#price1_'+varation_id).val(); 
        var unit            =   $('#unit1_'+varation_id).val();    
        var unit_value      =   $('#unit_value1_'+varation_id).val();
        var toPr_price      =   $('#total_product_price_'+varation_id).val();
        var total           =   $('#total').val(); 
        var saveprice       =   $('#saveprice').val(); 
        var difference_price=   $('#difference_price_'+varation_id).val();
        var savepriceR       =   (parseFloat(saveprice)-(parseFloat(difference_price)*parseInt(old_qty)));
        var increseVal      =   price*parseInt(qty);
        var difference_price=   difference_price*parseInt(qty);
        var IncToAmount     =   parseFloat((parseFloat(total) - parseFloat(toPr_price))+parseFloat(increseVal));
        var savePrice       =   savepriceR+difference_price;
        var qty_in_kg       =   (unit*parseInt(qty));
        var unit_in_kg      =   unit_value;
        if ((unit_value == "gram") || (unit_value == "gm") || (unit_value == "GM")) {
            qty_in_kg = (unit*parseInt(qty))/1000;
            unit_in_kg = "Kg";
        }
        addToCart(product_id,varation_id,price,unit,unit_value,qty,'plus');
        $('#product_qty_'+varation_id).val(qty);
        $('#saveprice').val(savePrice);
        $('#total').val(IncToAmount);
        $('#total_amount').html(IncToAmount.toFixed(2)+'/-');
        $('#total_product_price_'+varation_id).val(increseVal);
        $('#single_price_'+varation_id).html("<?=$this->config->item('currency')?> "+increseVal.toFixed(2)+'/-');
        $('.difference_'+varation_id).html("<?=$this->config->item('currency')?> "+difference_price.toFixed(2));
        $('#totalSaving').html("<?=$this->config->item('currency')?> "+savePrice.toFixed(2));
        $('#show_qty_'+varation_id).html(' ('+qty_in_kg+''+unit_in_kg+')');
     } 
     return false;
 })  
    
</script>

<?php /* ?>
<div class="order-detail-content order_detail">
                            <div class="row">
                                <div class="col-md-1">
                                    <h2 class="cart-details--heading">Item</h2>
                                </div>
                                <div class="col-md-3">
                                    <h2 class="cart-details--heading">Description</h2>
                                </div>
                                <div class="col-md-1">
                                    <h2 class="cart-details--heading">Unit price</h2>
                                </div>
                                <div class="col-md-2">
                                    <h2 class="cart-details--heading">Qty</h2>
                                </div>
                                <div class="col-md-2">
                                    <h2 class="cart-details--heading">Total</h2>
                                </div>
                                <div class="col-md-1">
                                    <h2 class="cart-details--heading"><i class="fa fa-trash-o"></i></h2>
                                </div>
                                <div class="col-md-2">
                                    <h2 class="cart-details--heading">Saving</h2>
                                </div>
                            </div>
                            <?php  //print_r($get_cart_product_arr);
                                $total_order_price = 0;
                                $saveprice          =0;
                                foreach ($get_cart_product_arr as $key => $product):
                                    $qty                    = $product['buy_qty'];
                                    $product_id             = $product['product_id'];
                                    $product_varient_id     = $product['varient_id'];
                                    $product_name           = $product['product_name'];
                                    $product_description    = $product['product_description'];


                                    $pro1                   = explode(',',$product['product_image']);
                                    $product_image          = $product_img_url. $pro1[0];

                                    $category_id            = $product['category_id'];
                                    $in_stock               = $product['in_stock'];
                                    $mrp                    = $product['mrp'];
                                    $unit_value             = $product['unit'];
                                    $unit                   = $product['qty'];
                                    $increament             = $product['increament'];
                                    $rewards                = $product['rewards'];
                                    $tax                    = $product['tax'];
                                    $product_price          = $product['price'];
                                    $mrp                    = $product['mrp'];
                                    //echo $this->session->userdata('price');

                                    // $unit                   = $this->session->userdata('unit');
                                    // $product_price          = $this->session->userdata('price');
                                    // $unit_value             = $this->session->userdata('unit_value');


                                    //$total_product_price = $product_price * $qty;
                                   // $total_order_price += $total_product_price;

                                    $q = $this->db->query("SELECT deal_price FROM deal_product WHERE deal_product.product_id = '".$product_id."' AND pro_var_id = '".$product_varient_id."'");
                                    $del_price = $q->row();

                                    if(!empty($del_price)){
                                        $product_price          = $del_price->deal_price;
                                        $difference_price       = $mrp - $del_price->deal_price;
                                        $total_product_price    = $product_price * $qty;
                                        $total_order_price      += $total_product_price;
                                        $single_price           =   $product_price;

                                    } else {
                                        $product_price = $product_price;
                                        $difference_price       = $mrp - $product_price;
                                        $total_product_price = $product_price * $qty;
                                        $total_order_price += $total_product_price;
                                        $single_price           =   $product_price;
                                    }
                                    //echo $unit.' >> '.$unit_value;
                                    $qty_in_kg = $unit;
                                    $unit_in_kg = $unit_value;
                                    if (($unit_value == "gram") || ($unit_value == "gm") || ($unit_value == "GM")) {
                                        $qty_in_kg = ($unit) / 1000;
                                        $unit_in_kg = "Kg";
                                    }

                                    $product_price          =   number_format((float)$product_price, 2, '.', '');
                                    $total_product_price    =   number_format((float)$total_product_price, 2, '.', '');
                                    $saveprice              +=  $difference_price*$qty;
                                    $q_slug                 =   $this->db->query("SELECT product_slug FROM products WHERE product_id = '".$product_id."'")->row();
                                    $product_slug           =   $q_slug->product_slug;
                                    $productUrl             =   $this->config->item('base_url')."product/". $product_slug;
                                    ?>
                                    <div class="row" id="list_<?=$product_varient_id?>">
                                        <div class="col-xs-2 col-sm-2 col-md-1 ">
                                            <a href="<?=$productUrl?>" target="_blank"><img src="<?= $product_image ?>" alt="Product"></a>
                                        </div>
                                        <div class="col-xs-10 col-sm-10 col-md-3">
                                            <p class="product-name"><a href="<?=$productUrl?>" target="_blank"><?= $product_name ?></a></p>
                                            <?php
                                            if (!empty($in_stock)):
                                                echo '<p class="availability in-stock"><span class="label">In stock</span></p>';
                                            else:
                                                echo '<p class="availability out-of-stock"><span class="label">No stock</span></p>';
                                            endif;
                                            ?>
                                        </div>
                                        <div class="col-xs-5 col-md-2">
                                            <span>
                                                <?=$this->config->item('currency')?> <?= $product_price ?> /-
                                                <small><?= $unit . " " . $unit_value ?></small>
                                            </span>
                                        </div>
                                        <div class="col-xs-5 col-md-2">
                                            <input type="hidden" name="product_qty" id="product_qty_<?=$product_varient_id?>" value="<?=$qty?>">
                                            <input type="hidden" name="product_id" id="product_id1_<?=$product_varient_id?>" value="<?=$product_id?>">
                                            <input type="hidden" name="product_varient_id" id="product_varient_id1_<?=$product_varient_id?>" value="<?=$varientid?>">
                                            <input type="hidden" name="price" id="price1_<?=$product_varient_id?>" value="<?=$single_price?>" class="priceee">
                                            <input type="hidden" name="unit" id="unit1_<?=$product_varient_id?>" value="<?=$unit?>" class="units">
                                            <input type="hidden" name="unit_value" id="unit_value1_<?=$product_varient_id?>" value="<?=$unit_value?>" class="unit_value">
                                            <input type="hidden" name="total_product_price" id="total_product_price_<?=$product_varient_id?>" value="<?=$total_product_price?>" class="total_product_price">
                                            <input type="hidden" name="difference_price" id="difference_price_<?=$product_varient_id?>" value="<?=$difference_price?>" class="difference_price">

                                            <div  class="view_button  <?=empty($in_stock) ? '' : 'dec';?> qtybutton " data-id="<?=$product_id?>" data-varient="<?=$product_varient_id?>" <?=empty($in_stock) ? 'disabled' : '';?>><i class="fa fa-minus">&nbsp;</i></div>
                                                <input class="form-control input-sm qty_box" type="text" readonly value="<?=empty($in_stock) ? 0 : $qty ?>" id="qty1_<?=$product_varient_id?>">
                                            <div class="view_buttonplus  <?=empty($in_stock) ? '' : 'inc';?> qtybutton"  data-id="<?=$product_id?>" data-varient="<?=$product_varient_id?>" <?=empty($in_stock) ? 'disabled' : '';?>><i class="fa fa-plus">&nbsp;</i></div>
                                        </div>
                                        <div class="col-xs-5 col-md-2">
                                            <span id="single_price_<?=$product_varient_id?>"><?=$this->config->item('currency')?> <?= $total_product_price ?>/-</span><small id="show_qty">(<?= $qty * $qty_in_kg . " " . $unit_in_kg ?>)</small>
                                        </div>
                                        <div class="col-xs-3 col-md-1">
                                            <a data-id="<?=$product_id?>" data-varient="<?=$product_varient_id?>" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="col-xs-5 col-md-2">
                                            <span class="uiv2-savings-rate difference_<?=$product_varient_id?>"><?=$this->config->item('currency').' '.number_format((float)($difference_price*$qty), 2, '.', '');?></span>
                                        </div>
                                    </div>
                                <?php

                                    endforeach;
                                ?>
<?php */ ?>

