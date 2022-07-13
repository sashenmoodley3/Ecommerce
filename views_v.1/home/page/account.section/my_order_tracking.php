<?php
$user_order_info = (object)$user_order_info[0];

$order_id = $user_order_info->sale_id;
$on_date = $user_order_info->on_date;
$delivery_time_from = $user_order_info->delivery_time_from;
$delivery_time_to = $user_order_info->delivery_time_to;
$order_status = $user_order_info->status;
$total_amount = $user_order_info->total_amount;
$total_items = $user_order_info->total_items;

$order_items = $order_items[0];
$product_name  =  $order_items->product_name;
$product_qty = $order_items->qty;
$product_price = $order_items->price;

//var_dump($user_order_info);
//print_r($order); 

?>
<style>
    .stepwizard-row {
        text-align: center;
    }
    .stepwizard-step {
        float: left;
        width: 32%;
    }
</style>
<div class="col-xs-12 col-sm-9 ">
    <div class="my-account">
        <div class="page-title">
            <h2><?=$this->lang->line("My Order")?></h2>
        </div>
        <div class="row setup-content" id="step-1">
                <div class="col-md-12 ">
                    <div class="account-login">
                        <div class="col-md-6">

                            <p class="before-login-text"><?=$this->lang->line("Order Id")?>: <span class="text-dark"> <?=$order_id?> </span> </p>
                            <p class="before-login-text"><?=$this->lang->line("Order On")?>: <span class="text-dark"> <?=$on_date?> </span> </p>


                        </div>

                        

                        <div class="col-md-6">
                            <p class="before-login-text"><?=$this->lang->line("Time")?> : <span class="text-dark"> <?=$delivery_time_from?> - <?=$delivery_time_to?> </span> </p>
                          
                        </div>

                       
                        <div class="col-md-6">
                            <p class="before-login-text"><?=$this->lang->line("Product Name")?> : <span class="text-dark"> <?=$product_name?></span> </p>
                              <p class="before-login-text"><?=$this->lang->line("Total Items")?>: <span class="text-dark"> <?=$total_items?></span> </p>
                        </div>
                    

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="mtb-20"><?=$this->config->item('currency');?> <span><?=$total_amount?>/-</span></h3>

                                </div>
                                <div class="col-md-6">
                                    <p class="text-success mtb-20 "><?=$this->lang->line("Cash On Delivery")?></p>
                                </div>


                            </div>

                        </div>
                        <div class="col-md-12">
                            <?php
                            if ($order_status == 0) {
                                echo "<span class='label label-default'>Pending</span>";
                                //echo 'Pending';
                            } else if ($order_status == 1) {
                                echo "<span class='label label-success'>Confirm</span>";
                                //echo 'Confirm';
                            } else if ($order_status == 2) {
                                echo "<span class='label label-info'>Out</span>";
                                //echo 'Out';
                            } else if ($order_status == 3) {
                                echo "<span class='label label-danger'>Cancel</span>";
                                //echo 'Cancel';
                            } else if ($order_status == 4) {
                                echo "<span class='label label-info'>complete</span>";
                                //echo 'Complete';
                            }
                            ?>
<!--                            <button class="button"> <span>Pending </span></button>-->
                        </div>
                        <div class="col-md-12">
<!--                            <p class="before-login-text mtb-20">Tracking Status Date: <span class="text-dark"> 123456 </span> </p>-->

                        </div>
<!--                        <div class="col-md-12">

                            <div class="stepwizard-row setup-panel ">
                                <div class="stepwizard-step">
                                    <a   type="button" class="btn btn-primary btn-circle">1</a>
                                    <p>29-02-2019</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a  type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                                    <p>Step 2</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a  type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                                    <p>Step 3</p>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
    </div>

</div>