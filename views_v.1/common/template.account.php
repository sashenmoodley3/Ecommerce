<?php
$demo = $_SERVER["REQUEST_URI"];
$arr = explode('?', $demo); 
if(!empty($this->session->flashdata('login_load_msg'))  || ($arr[1] == 'register')){ ?>
<style>
    .show-md-login{ display:none; }
    .show-md-signup{display:block;}
</style>    
<?php } ?>

<!-- Main Container -->
<section class="main-container col1-layout">
    <div class="main container">
        <div class="page-content">
            <div class="account-login">
                <div class="col-xs-12 col-md-6 show-md-up">
                    <div class="blurb ">
                        <h2 class="blurb__title"> <?=$this->lang->line("Benefits of Sign In")?> </h2>
                        <div class="blurb__img">
                            <img class="img-responsive" src="<?=base_url()?>assets/images/signin_img.jpg" alt="">
                        </div>
                
                        <div class="blurb__content clearfix blurb__content-cntr">
                            <p><?=$this->config->item('name')?> seeks to be a one-stop shopping destination for entire communities, meeting all their daily needs.</p><p class="margin-reset"><?=$this->config->item('name')?> will offers a wide section of products in the following categories:</p><div class="blurb__content-left"> <ul> <li>Foods</li><li>Garments</li><li>Bed and Bath linen</li><li>Stationery</li><li>Footwear</li></ul> </div><div class="blurb__content-right"> <ul> <li>Toiletries and Beauty Products</li><li>Kitchenware</li><li>Toys and Games</li><li>Home Appliances</li></ul> </div>
                        </div>
                    </div>
                
                
                    </div>
                    <div class="col-xs-12 col-md-6 show-md-login">
                    <div class="signin-wrapper">
                        <?php echo form_open(base_url() . 'login'); ?>
                        <h4 class="form__title-signin"><?=$this->lang->line("Sign in / Register to continue shopping")?></h4>
                        <div class="form signin-form">
                            <div class="new-reg reg">
                                <?=$this->lang->line("NEW USER ? REGISTER NOW")?>
                            </div>
                            <div class="form__divider">
                                <span class="form__divider--text"><?=$this->lang->line("OR")?></span>
                            </div>
                            <?php 
                                if(!empty(form_error('process_login'))){
                                    echo '<div class="alert alert-danger" role="alert">'.form_error('process_login').'</div>';
                                }
                            ?>
                            <div class="form-controls">
                              <label for="mobileNumber" class="form__label required-field spacing-bottom-tiny">  <?=$this->lang->line("Mobile Number")?> </label>
                              <div class="form__input--group">
                                <!-- <span class="form__input-prefix">+27</span> -->
                                <input type="number" value="{mobile_no}" maxlength="10" pattern="\d{10}" required="true" name="mobile_no" id="mobile_no" class="form__input mobileNumberClass mobileNumber" autofocus="">
                                <span class="mobilenumber-error"> <?php echo form_error('mobile_no'); ?></span>
                              </div>
                            </div>
                            
                            <div class="sign-In-password-show-hide-field">
                                <div class="js-signin-password">
                                    <div class="form-controls">
                                      <label class="form__label required-field spacing-bottom-tiny" for="password"><?=$this->lang->line("Password")?></label>
                                      <input class="form__input signin_showInput" id="password_login" type="password" name="password" value="{password}" placeholder="" required="true" maxlength="" data="required" autocomplete="off" datapreval="">
                                    </div>
                                    <span class="mobilepassword-error"><?=$this->lang->line("Enter min 6 or max 60 characters!")?></span>
                                </div>
                                <div class="show-hide-password-block">
                                  <input type="checkbox" name="showHide" class="showHideReg showHide">
                                  <label for="showHide" id="showHideLabel" class="showHideRegLabel"><?=$this->lang->line("Show")?></label>
                                </div>
                            </div>
                            <div class="signin__alternate form__control--pull-up">
                              <a class="signin--forgot-password modal-link" href="<?=base_url()?>forget_account_password" title=""><?=$this->lang->line("Forgot Password")?>?</a>
                            </div>
                            <div class="form__btn js-form-btn-signin">
                                <button type="submit" class="button"><i class="fa fa-lock"></i>&nbsp; <span><?=$this->lang->line("Login")?></span></button>
                            </div>
                            <div class="signin__register-link">
                                <span><?=$this->lang->line("New Customer")?>?</span>
                                <a href="javascript:;" class="reg" title="Register"><?=$this->lang->line("Register")?></a> 
                            </div>
                            
                            
                        </div>
						<?php echo form_close(); ?>
                        
                        
                    </div>
                    
                </div>
                
                    <div class="col-xs-12 col-md-6 show-md-signup">
                    <div class="signin-wrapper">
                        <?php echo form_open(base_url() . 'registration'); ?>
                        <h4 class="form__title-signin"><?=$this->lang->line("Register")?></h4>
                        <div class="form signin-form">
                            <?php 
                                if(!empty(form_error('process_registration'))){
                                    echo '<div class="alert alert-danger" role="alert">'.form_error('process_registration').'</div>';
                                }
                            ?>
                             <?php 
                                if(!empty($this->session->flashdata('error_msg'))){
                                    echo '<div class="alert alert-danger" role="alert">'.$this->session->flashdata('error_msg').'</div>';
                                }
                            ?>
                            <?php 
                                if(!empty($this->session->flashdata('login_load_msg'))){
                                    echo '<div class="alert alert-success" role="alert">'.$this->session->flashdata('login_load_msg').'</div>';
                                }
                            ?>
                            
                            <div class="form-controls">
                              <label for="reg_profilename" class="form__label required-field spacing-bottom-tiny">  <?=$this->lang->line("Full Name")?><span class="required">*</span> </label>
                                <input class="form__input firstName_reg" type="text" size="50" id="reg_profilename" name="reg_profilename" value="{reg_profilename}" placeholder="Enter your Full Name" required="true" maxlength="" data="required" autocomplete="off" autofocus="" datapreval="">
                            </div>
                            <span class="mobilenumber-error"><?= form_error('reg_profilename'); ?></span>
                            
                            <!--<div class="form-controls">-->
                            <!--  <label for="reg_profilelname" class="form__label required-field spacing-bottom-tiny"><?=$this->lang->line("Last Name")?><span class="required">*</span> </label>-->
                            <!--    <input class="form__input lastName_reg" type="text" size="50" id="reg_profilelname" name="reg_profilelname" value="" placeholder="Enter your Last Name" required="true" maxlength="" data="required" autocomplete="off" autofocus="" datapreval="">-->
                            <!--</div>-->
                            <!--<span class="mobilenumber-error"><?= form_error('reg_profilelname'); ?></span>-->
                            
                            <div class="form-controls">
                              <label for="mobileNumber" class="form__label required-field spacing-bottom-tiny"><?=$this->lang->line("Mobile Number")?><span class="required">*</span> </label>
                              <div class="form__input--group">
                                <!-- <span class="form__input-prefix"><?=$this->config->item('country_phone_code')?></span> -->
                                <input type="number" value="{reg_mobile_no}" maxlength="10" pattern="\d{10}" required="true" name="reg_mobile_no" id="reg_mobile_no" class="form__input mobileNumberClass mobileNumber" autofocus="">
                              </div>
                            </div>
                            <span class="mobilenumber-error"> <?php echo form_error('reg_mobile_no'); ?></span>
                            <span id="showsendotp" style="color:green"> <?=$this->lang->line("OTP send")?> !!  <br></span>
                            <span id="errorotp" style="color:red"> <?=$this->lang->line("Already Exist")?> <br></span>
                            <span id="showresendotp" style="color:green"> <?=$this->lang->line("OTP Resend")?> !!  <br></span>
                            
                            <div class="form-controls" id="sendotp">
                                <label for="send_otp" class="form__label required-field spacing-bottom-tiny"><?=$this->lang->line("OTP")?><span class="required">*</span> </label>
                                <input class="form__input send_otp" type="text" id="send_otp" name="send_otp" value="" placeholder="Enter your Last Name"  ><!--maxlength="" required="true" data="required" autocomplete="off" autofocus="" datapreval=""-->
                                <a  id="resend" class="btn btn-primary" style="color:#fff"><?=$this->lang->line("Resend OTP")?></a>
                            </div>
                            <span class="mobilenumber-error"><?= form_error('send_otp'); ?></span>
                            
                            
                            <div class="sign-In-password-show-hide-field">
                                <div class="js-signin-password">
                                    <div class="form-controls">
                                      <label class="form__label required-field spacing-bottom-tiny" for="reg_password"><?=$this->lang->line("Password")?>*</label>
                                      <input class="form__input reg_showInput password_reg" pattern=".{6,}" title="Six or more characters" type="password" id="reg_password" type="reg_password" name="reg_password" value="{reg_password}" placeholder="" required="true" maxlength="" data="required" autocomplete="off" datapreval="">
                                    </div>
                                </div>
                                <div class="show-hide-password-block">
                                  <input type="checkbox" name="showHide" class="showHideReg showHide">
                                  <label for="showHide" id="showHideLabel" class="showHideRegLabel"><?=$this->lang->line("Show")?></label>
                                </div>
                            </div>
                            <span class="mobilepassword-error"><?= form_error('reg_password'); ?></span>
                            
                            
                            <!--<div class="sign-In-password-show-hide-field">-->
                            <!--    <div class="js-signin-password">-->
                            <!--        <div class="form-controls">-->
                            <!--          <label class="form__label required-field spacing-bottom-tiny" for="reg_passconf"><?=$this->lang->line("Confirm Password")?></label>-->
                            <!--          <input class="form__input signin_confPass" type="password" pattern=".{6,}" title="Six or more characters" id="reg_passconf" type="reg_passconf" name="reg_passconf" value="{reg_passconf}" placeholder="" required="true" maxlength="" data="required" autocomplete="off" datapreval="">-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="show-hide-password-block">-->
                            <!--      <input type="checkbox" name="showHide" class="showHideConf showHide">-->
                            <!--      <label for="showHide" id="showHideLabel" class="showHideRegLabel"><?=$this->lang->line("Show")?></label>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<span class="mobilepassword-error"><?= form_error('reg_passconf'); ?></span>-->
                            
                            <div class="form-controls">
                                  <label class="form__label  spacing-bottom-tiny" for="email"><?=$this->lang->line("Email")?>*</label>
                                  <input class="form__input email_reg" type="email" name="reg_useremail" id="reg_useremail" value="{reg_useremail}" placeholder="xyz@email.com" maxlength="" data="autocomplete=&quot;off&quot;" datapreval="">
                            </div>
                            <span class="mobilepassword-error"><?= form_error('reg_useremail'); ?></span>
                            
                            <div class="form-controls">
                                  <label class="form__label  spacing-bottom-tiny" for="email"><?=$this->lang->line("Referral Code")?></label>
                                  <input class="form__input email_reg" type="text" name="reg_referral_code" id="reg_referral_code" value="{reg_referral_code}" placeholder="" maxlength="" data="autocomplete=&quot;off&quot;" datapreval="">
                            </div>
                            <span class="mobilepassword-error"><?= form_error('reg_referral_code'); ?></span>
                            
                            <div class="note form__control">
                                 <label for="tcAgree" class="reg_private_policy"><input type="checkbox" required="" class="form__input tcAgree" name="reg_private_policy" id="reg_private_policy" aria-required="true">
                            		 I Agree to the 
                            		 <a class="link-alternate" href="<?=base_url()?>terms_conditions" target="_blank"><?=$this->lang->line("Terms & Conditions")?></a>  <?=$this->config->item('name');?>.
                            	</label>
                                <span class="regtnc-error"><?= form_error('reg_private_policy'); ?></span>
                            </div>

                            <div class="note form__control">
                                 <label for="tcAgree" class="reg_private_policy"><input type="checkbox" required="" class="form__input tcAgree" name="reg_private_policy" id="reg_private_policy" aria-required="true">
                            		 I Agree for Mnandi Retail Solutions to send me SMS & Email notifications. 
                            	</label>
                                <span class="regtnc-error"><?= form_error('reg_private_policy'); ?></span>
                            </div>
                            
                            
                            <div class="form__btn js-form-btn-signin">
                                <button class="button"><i class="fa fa-user"></i>&nbsp; <span><?=$this->lang->line("Register")?></span></button>
                            </div>
                            <div class="signin__register-link">
                                <span>Already Account</span>
                                <a href="javascript:;" class="reg_in" title="Register"><?=$this->lang->line("Sign In")?></a> 
                            </div>
                            <!--<label class="inline" for="rememberme">-->
                            <!--    <input type="checkbox" value="forever" id="rememberme" name="login_remember_me" value="on"> Remember me-->
                            <!--</label>-->
                            <?php echo form_close(); ?>
                            <!-- <div class="register-benefits">
                                <h5><?=$this->lang->line("Sign up today and you will be able to")?> :</h5>
                                <ul>
                                    <li><?=$this->lang->line("Speed your way through checkout")?></li>
                                    <li><?=$this->lang->line("Track your orders easily")?></li>
                                    <li><?=$this->lang->line("Keep a record of all your purchases")?></li>
                                </ul>
                            </div> -->
                        </div>
                        
                        
                    </div>
				</div>
			
				<div class="col-xs-12 col-md-6">
				</div>
                
                <div class="col-xs-12 col-md-6">
					<div class="form signin-form">
					<?php 
					
					if(!empty($this->config->item('facebook_app_id')) && !empty($this->config->item('facebook_app_secret'))){
					?>
					 <a href="<?php echo $this->facebook->login_url(); ?>" class="btn fb" style="background-color: #3B5998;">
					  <i class="fa fa-facebook fa-fw"></i> <?=$this->lang->line("Login with Facebook")?>
					 </a>
					<?php } ?>
					<?php 
					if(!empty($this->config->item('google_client_id')) && !empty($this->config->item('google_client_secret'))){
					?>
					<a href="<?php echo $this->google->login_url(); ?>" class="btn google"><i class="fa fa-google fa-fw">
					  </i> <?=$this->lang->line("Login with Google")?>
					</a>
					<?php } ?>
					
					
					</div>
                </div>
                
                
                
                
              <?php /*  <div class="box-authentication">
                    <?php echo form_open(base_url() . 'registration'); ?>
                    <h4>Register</h4><p>Create your very own account</p> 
                    <?php
                    //echo form_error('process_registration', '<div class="text-warning">', '</div>');
                    echo form_error('process_registration');
                    ?>
                     <?php    echo $this->session->flashdata('login_load_msg'); 
                    ?>
                    <label for="reg_profilename">First Name<span class="required">*</span> : </label>
                    <?= form_error('reg_profilename', '', ''); ?>
                    <input type="text" class="form-control"
                           id="reg_profilename" 
                           name="reg_profilename" 
                           value="{reg_profilename}" size="50" />
                           
                     <label for="reg_profilename">Last Name<span class="required">*</span> : </label>
                    <?= form_error('reg_profilename', '', ''); ?>
                    <input type="text" class="form-control"
                           id="" 
                           name="" 
                           value="" size="50" />
                    
                    <label for="reg_mobile_no">Mobile No.<span class="required">*</span> :</label>                   
                    <!--                    <div class='error_msg text-warning'></div>-->
                    <?php echo form_error('reg_mobile_no'); ?>
                    <input id="reg_mobile_no" type="text" class="form-control"
                           name="reg_mobile_no" 
                           value="{reg_mobile_no}">
                           
                           
                    <span id="showsendotp" style="color:green"> OTP send !!  <br></span>
                    <span id="errorotp" style="color:red"> Already Exist <br></span>
                    
                    <span id="showresendotp" style="color:green"> OTP Resend !!  <br></span>
                        
                     <div id="sendotp">     
                        <label for="send_otp">OTP.<span class="required">*</span> :</label>                   
                        <!--                    <div class='error_msg text-warning'></div>-->
                        <?php echo form_error('send_otp'); ?>
                        <input id="send_otp" type="text" class="form-control" required
                               name="send_otp" 
                           value="">
                           <br>
                         <a  id="resend" class="btn btn-primary" style="color:#fff">Resend OTP</a>
                    </div> 
                    
                    


                    <label for="reg_password">Password<span class="required">*</span> :</label>
                    <?= form_error('reg_password', '', ''); ?>
                    <input type="password"  class="form-control"
                           id="reg_password" 
                           name="reg_password" value="{reg_password}" size="50" />

                    <label id="reg_passconf">Password Confirm<span class="required">*</span> :</label>
                    <?= form_error('reg_passconf', '', ''); ?>
                    <input type="password" class="form-control" 
                           id="reg_passconf" 
                           name="reg_passconf" value="{reg_passconf}" size="50" />
                           
                           

                     <label for="reg_useremail">Email : </label>
                    <?php
                    //echo form_label('Email : ');
                    $data = array(
                        'id' => 'reg_useremail',
                        'type' => 'text',
                        'name' => 'reg_useremail',
                        'value' => '{reg_useremail}',
                        'class' => 'form-control'
                    );
                    echo form_error('reg_useremail', '', '');
                    echo form_input($data); 
                    ?>    

                    <label id="reg_referral_code">Referral Code :</label>
                    <?= form_error('reg_referral_code', '', ''); ?>
                    <input type="text" class="form-control" id="reg_referral_code" name="reg_referral_code" value="{reg_referral_code}" size="50" />

                    <label for="reg_private_policy">
                        <?= form_error('reg_private_policy', '', ''); ?>
                        <input type="checkbox" class="form-control"
                               id="reg_private_policy" name="reg_private_policy" 
                               value="yes" style="width: 20px; float: left; margin-right: 6px; height: auto;"/>
                        <i class="primary"></i>I Read or Accept Private & Policy<span class="required">*</span>
                    </label>

                    <br/>

                    <button class="button"><i class="fa fa-user"></i>&nbsp; <span>Register</span></button>
                    <div class="register-benefits">
                        <h5>Sign up today and you will be able to :</h5>
                        <ul>
                            <li>Speed your way through checkout</li>
                            <li>Track your orders easily</li>
                            <li>Keep a record of all your purchases</li>
                        </ul>
                    </div>
                </div> */?>
            </div>
        </div>

    </div>
</section>
<!-- Main Container End --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var BASE_URL  = "http://kriscenttechnohub.com/kart-grocery-supermarket/";
        $('#sendotp').hide();
        
        $('#showresendotp').hide();
        $('#showsendotp').hide();
        $('#errorotp').hide();
        
        $('#reg_mobile').change(function(){
            var mobile = $('#reg_mobile').val();
            
             $.get(BASE_URL+"mobile_verifiaction",{ mobile:mobile},function(data){
             
              if(data == "Done"){
                  $('#sendotp').show();
                   $('#showsendotp').show();
                  $('#errorotp').hide();
              }else{
                  $('#errorotp').show();
                  $('#showsendotp').hide();
                  $('#sendotp').hide();
                  $('#reg_mobile_no').val('');
              }
                
            });
            
        })
        $('#resend').click(function(){
            var mobile = $('#reg_mobile_no').val();
            
             $.get(BASE_URL+"mobile_verifiaction",{ mobile:mobile},function(data){
             
              if(data == "Done"){
                   $('#showsendotp').hide();
                  $('#showresendotp').show();
              }else{
                  $('#showresendotp').hide();
              }
                
            });
            
        })
    });
     
    $(document).on('click','.reg', function(e){
        $('.show-md-login').css('display','none');
        $('.show-md-signup').css('display','block');
    })
    $(document).on('click','.reg_in', function(e){
        $('.show-md-signup').css('display','none');
        $('.show-md-login').css('display','block');
    })
    
    
    
    $(document).on("keypress",".mobileNumberClass",function(b){
        var a=(b.which)?b.which:b.keyCode;
        if(a>31&&(isNaN(String.fromCharCode(a))||$(this).val().length>9)){
            return false
            
        }return true
        
    });
</script>

<script>
    
    
</script>