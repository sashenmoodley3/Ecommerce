<?php
$total_order_price = 0;

if (is_array($getLoginUserAddresses))
{
    //var_dump($getLoginUserAddresses);
    foreach ($getLoginUserAddresses as $key => $value) 
    {
        if($value->default_address==1)
        {
            $location_id = $value->location_id;
            $house_no = $value->house_no;
            $receiver_name = $value->receiver_name;
            $receiver_mobile = $value->receiver_mobile;
            $delivery_charge = $value->delivery_charge;
            $free_delivery_amount = $value->free_delivery_amount;
            $pincode         = $value->pincode;
            $default_address         = $value->default_address;
        }
    }
}

if($get_cart_product_arr)
{    
    foreach ($get_cart_product_arr as $key => $product){
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
        $q_variants             = $this->db->query("Select * from product_varient where product_id = '".$product_id."' AND varient_id='".$product_varient_id."'")->row();
        if(!empty($q_variants->pro_var_images)){
            $product_image  = base_url().'backend/uploads/products/'.$q_variants->pro_var_images;
        }
        //echo $this->session->userdata('price');

        // $unit                   = $this->session->userdata('unit');
        // $product_price          = $this->session->userdata('price');
        // $unit_value             = $this->session->userdata('unit_value');


        //$total_product_price = $product_price * $qty;
       // $total_order_price += $total_product_price;

        //$q = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id = '".$product_varient_id."'");

        $q = $this->db->query("SELECT deal_price FROM deal_product WHERE product_id = '".$product_id."' AND pro_var_id = '".$product_varient_id."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
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
       
    }
}

 //echo $total_order_price;
        // add delivery charges in order_price
        if($delivery_charge > 0 &&  $total_order_price<$free_delivery_amount){
             $final_order_price  = $total_order_price+$delivery_charge;
        }
        else
        {
             $final_order_price  = $total_order_price;
        }
?>
<aside class="right sidebar col-sm-3 col-xs-12">
    <div class="well">
      <h4><?=$this->lang->line("Your Checkout")?></h4>
      <div>
            <div class="margin-bottom-5"><?=$this->lang->line("Have a voucher code")?></div>
            <div class="margin-bottom-5 text-primaries appled_coupan" style="display:none"></div>
            <div class="input-group">
                <input type="hidden" id="coupanapplyedid" name="coupanapplyedid" value="">
                <input type="text" style="height: 34px;text-transform: uppercase;" class="form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" qa="enterCodeCKO" ng-model="input.voucher_code" placeholder="Enter voucher code" ng-disabled="is_voucher_applied"  style="">
                <span class="input-group-btn">
                    <a class="btn btn-default btn-voucher" qa="applyBtnCKO" type="submit">
                        <span style="letter-spacing: .5px; font-size: 11px;" id="applyCoupan" class="ng-binding"><?=$this->lang->line("APPLY")?></span>
                    </a>
                </span>
            </div>
        <hr/>
        <table style="width:100%" class="order-summary">
            <tbody>
                <tr>
                    <td><?=$this->lang->line("Total Amount")?>  </td>
                    <td id="subtotal" class="text-right">
                        <!--<script>document.getElementById("final_total_order_price").innerHTML = document.getElementById("total_order_price").innerHTML</script>-->
                        <?=$this->config->item('currency');?> <span id="final_total_order_price"><?=$total_order_price;?></span>
                    </td>
                </tr>
                <tr>
                    <td><?=$this->lang->line("Delivery Charge")?>    </td>
                    <td id="subtotal" class="text-right">
                        <span  id="chk_final_shipping_charges">
                           
                            <?php
                                if($delivery_charge > 0 &&  $total_order_price<$free_delivery_amount){
                                    echo $this->config->item('currency')." ".$delivery_charge;
                                }
                                else
                                {
                                    echo $this->lang->line("FREE");
                                }
                            ?>
                        
                        
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><?=$this->lang->line("Voucher Discount")?></td>
                    <td class="text-right padding-bottom-5" id="voucherapplied">
                        <a  onClick="showVoucherList()" qa="vouchDiscCKO" style="text-decoration: underline; cursor:pointer">
                            <strong><?=$this->lang->line("Apply Voucher")?></strong>
                        </a>
                    </td>
                    <td class="text-right padding-bottom-5 ng-hide" id="vouchDiscCKO" style="">
                         <?=$this->config->item('currency');?> <span id="evoucher_credit_amount">0</span>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="padding-top-15 padding-bottom-5">
                        <strong><?=$this->lang->line("Total Amount Payable")?></strong>
                    </td>
                    <td class="text-right padding-top-15 padding-bottom-5" qa="totalAmtCKO">
                        <strong><?=$this->config->item('currency');?> </strong><strong><span id="final_total_price"><?=$final_order_price;?></span></strong>
                    </td>
                </tr>
                <tr ng-if="order_summary.total_saving > 0" class="ng-scope" style="">
                    <td class="no-padding">
                        <strong class="text-primary "><?=$this->lang->line("Your Total Savings")?></strong>
                    </td>
                    <td class="text-right no-padding">
                        <strong class="text-primary">
                            <?=$this->config->item('currency');?>
                            <span id="save_price"><script>document.getElementById("save_price").innerHTML = document.getElementById("saveprice").value</script></span>
                        </strong>
                    </td>
                </tr>
        </table>
          

      </div>
      
    </div>
     
    <div class="order-detail-content">
        <div class="cart_navigation">
            <button type="submit" class="button pull-right"><span>Place Order</span></button>   
            <a class="btn btn-success continue-btn" href="home"><i class="fa fa-arrow-left"> </i>&nbsp; <?=$this->lang->line("Continue shopping")?></a> 
        </div>
    </div>
</aside>


<?php /* <div class="sidebar-checkout block">
        <div class="sidebar-bar-title">
            <h3></h3>
        </div>
        <div class="block-content">
            <dl>
			

                <dt class="complete">  <span class="separator">|</span> <a href="#">Time</a> </dt>
                <dd class="complete">
                    <address>
                        Shipping Date : <br/><em id="view_shipping_date" class="text-center" style="font-size: 14px;"><!--15-3-2019--><span class="error" for="view_shipping_date"></span></em><br/>
                        Shipping TimeFrom : <br/><em id="view_shipping_time_from" style="font-size: 14px;"><!--01:30 PM--><span class="error" for="view_shipping_time">Plz Select Shipping Time.</span></em></em><br>
                        Shipping TimeTo : <br/><em id="view_shipping_time_to" style="font-size: 14px;"><!--01:30 PM--><span class="error" for="view_shipping_time">Plz Select Shipping Time.</span></em></em><br>
                    </address>
                </dd>
                <dt class="complete"> Shipping Address <span class="separator">|</span> <a href="#">Change</a> </dt>
                <dd class="complete">
                    <address id="view_shipping_address">
                        <span class="error" >Plz Select Shipping Address.</span>
                        <!--
                        Receiver Name : <em>Deo Jone</em><br/>
                        Society : <em>Company Name</em><br>
                        M. No. : <em>9602009656</em><br/>
                        Delivery Charges : <em>Rs.0</em> <br>
                        -->
                    </address>
                </dd>
                <dt class="complete"> 
                    Shipping Method <span class="separator">|</span> <a href="#">Change</a> 
                </dt>
                <dd class="complete"> User Wallet Amount <br>
                    <span class="price">
                        <?=$this->config->item('currency') ?> <span class="used_wallet_amount">0</span>
                    </span> 
                </dd>
                <dd class="complete"> Flat Rate - Fixed <br>
                    <span class="price">
                        <?=$this->config->item('currency') ?> <span class="existing_cart_amount" id="final_total_order_price">
                            <script>
                                document.getElementById("final_total_order_price").innerHTML = document.getElementById("total_order_price").innerHTML</script>
                            </span>
                    </span>
                </dd>
                <dt> Payment Method </dt>
                <dd class="complete">Cash On Delivery</dd>
            </dl>
            <button type="submit" class="button pull-right"><span>Place Order</span></button>
            <!--<button id="rzp-button1" class="btn btn-primary">Pay with Razorpay</button>-->
              
                    
        </div>
        
    </div> */?>