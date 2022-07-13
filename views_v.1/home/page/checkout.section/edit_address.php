<div id="address_form" 
     class="quick_popup-wrap" 
     style="display: block; position: fixed;top: 15%; display: none">
    <div class="quick_popup-overlay" id="quick_view_popup-overlay"></div>
    <div class="quick_popup-outer" id="quick_view_popup-outer">

        <?php
        $attributes = array('id' => 'addAddressFrm');
        echo form_open(base_url() . 'add_address', $attributes);
        ?>
        <div id="quick_view_popup-content">
            <div style="width:auto;height:auto;overflow: auto;position:relative;">
                <div class="product-view-area">
                    <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
                        <div>
                            <h4><?=$this->lang->line("Address")?></h4>
                            <?php echo form_error('process_login'); ?>
                            <p class="before-login-text"><?=$this->lang->line("Add! Delivery Account")?></p>

                            <label for="address_user_name"><?=$this->lang->line("Name")?><span class="required">*</span></label>
                            <?php echo form_error('address_user_name'); ?>
                            <input id="address_user_name" type="text" class="form-control"
                                   required
                                   name="address_user_name" 
                                   value="{address_user_name}">
                            <br/>
                            <label for="address_mobile_no"><?=$this->lang->line("Mobile No.")?><span class="required">*</span></label>
                            <?php echo form_error('address_mobile_no'); ?>
                            <input id="address_mobile_no" required type="text" class="form-control"
                                   name="address_mobile_no" 
                                   value="{address_mobile_no}">
                            <br/>

                            <label for="socity_id"><?=$this->lang->line("Society/Flat")?></label>
                            <?php
                            $society_data = $this->oauth_model->get_all_society();
//                            print_r($society_data);?>

                            <select id="socity_id" type="text" class="form-control" name="socity_id" style="height: auto" required>
                            <option value="" selected disabled> <?=$this->lang->line("Please Select Society")?> <span class="required">*</span></option>
                            <?php foreach ($society_data as $society){ ?>
                            <option value="<?=$society->socity_id?>"><?=$society->socity_name?></option>
                            <?php } ?>
                            </select>

                            <?php   echo form_error('address_society'); ?>

                            <br/>
                            <label for="address_pincode"><?=$this->lang->line("Pincode")?></label>
                            <?php echo form_error('address_pincode'); ?>
                            <input id="address_pincode" type="text" class="form-control"
                                   name="address_pincode"
                                   value="{address_pincode}">
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
                        <div class="product-details-area">

                            <div class="product-color-size-area">
                                <label for="address_address"><?=$this->lang->line("Address")?><span class="required">*</span></label>
                                <?php echo form_error('address_address'); ?>
                                <textarea  class="form-control" 
                                           required
                                           name="address_address" rows="10">{address_address}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 text-center">
                    <button class="button pro-add-to-cart" title="Add to Cart" type="submit"><span><?=$this->lang->line("Add Address")?></button>
                </div>
                <!--product-view--> 

            </div>
        </div>
        <?php echo form_close(); ?>
        <a style="display: inline;" 
           data-event="close" data-target=".quick_popup-wrap"
           class="quick_popup-close" 
           id="quick_view_popup-close" href="home"><i class="fa fa-times-circle"></i></a> </div>
</div>