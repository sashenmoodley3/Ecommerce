<?php
$order_id = $place_order_detalis['order_id'];
$fromtime = $place_order_detalis['fromtime'];
$totime = $place_order_detalis['totime'];
$date = $place_order_detalis['delivery_date'];
$total_price = $place_order_detalis['order_price'];
$delivery_charge = $place_order_detalis['delivery_charge'];
?>
<div class="page-title">
    <h2>Place Order</h2>
</div>
<h4 class="checkout-sep">Order Message</h4>
<div class="box-border">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h5 style="color: #00a859;">
                <i class="fa fa-check-circle text-primary"></i> Your order No #" . <?=$order_id?> . " is successful.</h5>
           <?php if($this->config->item('time_slot') == 1){ ?>
            <p> Expect delivery between</p>
            <ul>
                <li><label><?=$fromtime?>  to  <?=$totime?>  on  <?=$date?>  </label></li>
            </ul>
            <?php } else{ echo "Order will be delivered soon! ";  } ?>
            <h5>Total item cost R<?=$total_price?></h5>
            <h5 style='margin-bottom: 15px;'>Total delivery cost R<?=$delivery_charge?></h5>
            <h4 style="color: #00a859; margin-bottom: 15px;">Thanks for shopping with Us.</h4>
            <!-- <ul>
                <li><label>Go To<a class="button"  href="{base_url}/my_order"><i class="icon-login"></i>&nbsp; <span>Order Details</span></a></label></li>
            </ul> -->
            
            <a href="{base_url}/my_order" style="background: #00a859;color: #fff;
               padding: 6px 16px;font-size: 12px;border: 1px solid #00a859;transition: all 0.3s linear;-moz-transition: all 0.3s linear;-webkit-transition: all 0.3s linear;"><i class="fa fa-angle-double-right"></i>&nbsp; 
                <span>My Order</span></a><br/><br/><br/>
            <a href="{base_url}shop" style="background: #00a859;color: #fff;
               padding: 6px 16px;font-size: 12px;border: 1px solid #00a859;transition: all 0.3s linear;-moz-transition: all 0.3s linear;-webkit-transition: all 0.3s linear;"><i class="fa fa-angle-double-left"></i>&nbsp; 
                <span>Continue</span></a>
        </div>
    </div>
</div>