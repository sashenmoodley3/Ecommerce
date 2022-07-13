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
<div class="space-50"></div>
<div class="svelte-1ap4ad2 clickforPayment" data-typeid="65" data-typeapp="card" data-payid="8" id="paypal-button-container">
    <!--img src="https://astroshubh.in/assets/images/paypal1.jpg" alt="Paypal"--> 
    <div class="ref-text svelte-1ap4ad2"></div>
 </div>
<div class="space-50"></div>
<script src="https://www.paypal.com/sdk/js?client-id=<?=$this->config->item('paypal_id')?>&currency=<?=$currency?>" data-sdk-integration-source="button-factory"></script>
<script>
  paypal.Buttons({
      style: {
          shape: 'rect',
          color: '',
          layout: 'horizontal',
          label: '',
          tagline: false
          
      },
      createOrder: function(data, actions) {
          return actions.order.create({
              purchase_units: [{
                  amount: {
                      value: '<?=($price+$delivery_charge)?>'
                  }
              }]
          });
      },
      onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
              alert('Transaction completed by ' + details + '!');
          });
      }
  }).render('#paypal-button-container');
  
  
   $(document).ready(function () {
        setTimeout(function(){
            console.log('hello');
            $('.svelte-1ap4ad2').trigger('click');
       }, 4000);
    
    
    })
</script>