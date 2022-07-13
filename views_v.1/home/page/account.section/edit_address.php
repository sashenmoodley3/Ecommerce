<!DOCTYPE html>
<html>
<body>
<!-- Main Container -->
<?php 
    $location =  $this->db->query('select * from user_location  where location_id = "'.$address.'"')->row();
?>
<div class="col-xs-12 col-sm-9 ">
    <?php
    echo $this->session->flashdata('message');
        $attributes = array('id' => 'addAddressFrm');
        echo form_open(base_url() . 'edit_addres/'.$address, $attributes);
    ?>
    <div class="row">
        <div class="col-md-6">
            <input id="user_id" type="hidden" class="form-control" required name="user_id"  value="<?=$location->user_id?>"> 
            <input id="location_id" type="hidden" class="form-control" required name="location_id" value="<?=$location->location_id?>">
            <label for="address_user_name"><?=$this->lang->line("Name")?><span class="required">*</span></label>
            <?php echo form_error('address_user_name'); ?>
            <input id="address_user_name" type="text" class="form-control" required name="address_user_name" value="<?=$location->receiver_name?>">
        </div>
        <div class="col-md-6">
            <label for="address_mobile_no"><?=$this->lang->line("Mobile No.")?><span class="required">*</span></label>
            <?php echo form_error('address_mobile_no'); ?>
            <input id="address_mobile_no" required type="number" maxlength="10" pattern="\d{10}" class="form__input mobileNumberClass mobileNumber" autofocus="" class="form-control" name="address_mobile_no" value="<?=$location->receiver_mobile?>">
        </div>
    </div>
    <div class="row">	
        <div class="col-md-6">
            <label for="address_pincode"><?=$this->lang->line("Pincode")?><span class="required">*</span></label>
            <?php echo form_error('address_pincode'); ?>
            <input id="address_pincode" required type="number" maxlength="6" pattern="\d{6}" class="form__input mobileNumberClass mobileNumber" autofocus="" class="form-control" name="address_pincode" value="<?=$location->pincode?>">
        </div>
		<div class="col-md-6">
            <label for="default_address"><?=$this->lang->line("Default Address")?></label>
			<br>
            <input type="checkbox" <?php echo !empty($location->default_address)? 'checked' : ''; ?> class="form-control default_address" name="default_address" value="1" style="width: auto; float: left; margin-right: 10px; margin: 0px 7px 0px 0px; background: transparent; display: inherit; box-shadow: none;">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="address_address"><?=$this->lang->line("Address")?><span class="required">*</span></label>
            <?php echo form_error('address_address'); ?>
            <textarea  class="form-control" required name="address_address" rows="10"><?=$location->house_no?></textarea>
        </div>
    
    </div>
    <div class="row">	
        <div class="col-md-4">
            <label>Map Value Latitude<span class="required">*</span></label>
            <input id="address_lat" required class="form__input mobileNumberClass mobileNumber" autofocus="" class="form-control" name="address_lat" value="<?=$location->lat?>">
        </div>
        <div class="col-md-4">
            <label>Map Value Longitude<span class="required">*</span></label>
            <input id="address_lang" required class="form__input mobileNumberClass mobileNumber" autofocus="" class="form-control" name="address_lang" value="<?=$location->lang?>">
        </div>
        <div class="col-md-4">
            <button style="margin-top:24px; background:#314E85;" name="getcord" class="button" onclick="locate()" ><span>Get Map Values</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <button class="button pro-add-to-cart" title="Edit Address" type="submit"><span><?=$this->lang->line("Edit Address")?>  </button>
        </div>
    </div>
    <hr>
    <?php echo form_close(); ?>
</div>
<!-- Main Container End --> 

<script>
     function locate(e){
        event.preventDefault();
        if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){ 
                var currentLatitude = position.coords.latitude;
                var currentLongitude = position.coords.longitude;

                $("#address_lat").val(currentLatitude);
                $("#address_lang").val(currentLongitude);
            });
        }
    }
</script>

</body>
</html>