<?php
 $order_id  = $this->session->userdata('order_id');
 $price     = $this->session->userdata('order_price');
 $delivery_charge     = $this->session->userdata('delivery_charge');
 $name      = $this->session->userdata('customer_name');
 $email     = $this->session->userdata('customer_email');
 $user_id   = $this->session->userdata('user_id');
 $row       = $this->db->query('select * from registers WHERE user_id ="'.$user_id.'"  ')->row();

$marchent_id    =   $this->config->item('marchecnt_id');
$marchent_key   =   $this->config->item('marchent_key');
if($this->config->item('currency') == '₹'){
    $currency   =   'INR';
}
else{
    $currency   =   $this->config->item('currency');
}
?>
<button id="rzp-button1" class="btn btn-primary" style=" margin: 33px auto; text-align: center; display: block;">Pay with Razorpay</button>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
                       
                        var options = {
                            "key": "<?=$marchent_key?>", // Enter the Key ID generated from the Dashboard
                            "amount": <?=($price+$delivery_charge)*100?>, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
                            "currency": '<?=$currency?>',
                            "name": "<?=$this->config->item('name')?>",
                            "description": "<?=$this->config->item('tagline')?>",
                            "image": "<?=base_url()?>/uploads/company/<?=$this->config->item('logo')?>",
                            "receipt": <?=$order_id?>,//This is a sample Order ID. Create an Order using Orders API. (https://razorpay.com/docs/payment-gateway/orders/integration/#step-1-create-an-order). Refer the Checkout form table given below
                            "handler": function (response){
                                console.log(response);
                                 var paymentid   =   response.razorpay_payment_id;
                                 window.location.href="<?=base_url()?>home/paymentReportCustomer/"+paymentid+"/"+<?=$order_id?>;
                            },
                            "prefill": {
                                "name": '<?=$name?>',
                                "email": '<?=$email?>',
                                "contact": '<?=$row->user_phone?>'
                            },
                            "notes": {
                                "address": "note value"
                            },
                            "theme": {
                                "color": "#ffc107"
                            }
                    
                        };
                       // alert(response)
                        var rzp1 = new Razorpay(options);
                        document.getElementById('rzp-button1').onclick = function(e){
                            rzp1.open();
                            e.preventDefault();
                        }
                    
                    
                        $(document).ready(function () {
                            $('#rzp-button1').click();
                            $('#rzp-button1').trigger('click');
                    
                        })
                    </script>
 