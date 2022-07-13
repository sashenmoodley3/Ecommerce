<?php
//var_dump($_REQUEST);
?>

<div class="col-xs-12 col-sm-9">
    <div class="center_column">
        <div class="contact-form-box">
            <h4><?=$this->lang->line("Mange Profile")?></h4><p><?=$this->lang->line("Mange over own account")?></p>
            <div class="msg"></div>
            <div class="row">
                
                <div class="col-lg-6" style="border-right: 1px solid #eaeaea;">
                    <?php 
                    echo form_open(base_url() . 'my_account',array('id'=>'#form1')); 
                    if(form_error('process_registration')){
                        echo form_error('process_registration');
                    }
                    
                    // if(!empty($this->session->flashdata('login_load_msg')))
                    // {
                    //     echo $this->session->flashdata('login_load_msg');
                    // }
                    ?>
                    
                    <div class="form-selector">
                        <label for="update_profile_useremail"><?=$this->lang->line("Email")?> : </label>
                        <?php
                        //echo form_label('Email : ');
                        $data = array(
                            'id' => 'update_profile_useremail',
                            'type' => 'text',
                            'name' => 'update_profile_useremail',
                            'value' => '{update_profile_useremail}',
                            'class' => 'form-control',
                            'readonly'=> 'readonly'
                        );
                        echo form_error('update_profile_useremail', '', '');
                        echo form_input($data);
                        ?>    
                    </div>
                    <div class="form-selector">
                        <label for="update_profile_profilename"><?=$this->lang->line("Full Name")?><span class="required">*</span> : </label>
                        <?= form_error('update_profile_profilename', '', ''); ?>
                        <input type="text" class="form-control"
                               id="update_profile_profilename" 
                               required
                               name="update_profile_profilename" 
                               value="{update_profile_profilename}" size="50" />
                    </div>
                    <br/>
                    <div class="form-selector">
                        <button class="button edit-curd"><i class="fa fa-user"></i>&nbsp; <span><?=$this->lang->line("Update")?></span></button>
                    </div>
                    <?php echo form_close(); ?>
                    <br/>
                    <?php echo form_open(base_url() . 'mobile_verified',array('id'=>'#form3')); ?>
                    <div class="form-selector">
                        <label for="update_profile_mobile_no"><?=$this->lang->line("Mobile No.")?><span class="required">*</span> :</label>
                        <?php echo form_error('update_profile_mobile_no'); ?>
                        <input id="update_profile_mobile_no" type="text" class="form-control"
                               name="update_profile_mobile_no" <?=$update_mobile_verified?'readonly':''?>
                               value="{update_profile_mobile_no}" readonly>
                        <?php
                        if($update_mobile_verified==0):
                        ?>
                        
                        <br/>
                        <div class="form-selector">
                            <h5><?php
                            echo $this->session->flashdata('conform_otp_msg'); 
                            $this->session->keep_flashdata('conform_otp_msg_1');
                            $this->session->tempdata('conform_otp_msg_2');
                            ?></h5> 
                        <?php
                            //echo 'robin';
                            //echo $mobile_verification_code;
                            //echo date("Y-m-d H:i:s");
                            if(!empty($mobile_verification_code)){
                                echo '<input id="mobile_verified_otp" type="text" class="form-control"
                                                name="mobile_verified_otp"><br/>';
                                //echo '<button type="submit" class="button" name="conform_otp"  value="conform_otp"><i class="fa fa-user"></i>&nbsp; <span>Conform OTP</span></button>&nbsp;&nbsp;';
                                //echo '<button type="submit" class="button" name="resend_otp"  value="resend_otp"><i class="fa fa-user"></i>&nbsp; <span>Resend OTP</span></button>';
                            }
                            else {
                                //echo '<button type="submit" class="button" name="send_otp" value="send_otp"><i class="fa fa-user"></i>&nbsp; <span>Send OTP</span></button>';
                            }
                        ?>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <div class="col-lg-6 ">

                    <?php echo form_open(base_url() . 'changepass',array('id'=>'#form2')); //changepass ?>
                    <?php
                        //echo form_error('error_msg', '<div class="text-warning">', '</div>');
                        echo form_error('changePassword');
                        echo $this->session->flashdata('changePassword');
                        echo $this->session->flashdata('error_msg');
                       
                    ?>
                    <div class="form-selector">
                        <label for="update_profile_password_cur"><?=$this->lang->line("Current Password")?> :</label>
                        <?= form_error('update_profile_password_cur', '', ''); ?>
                        <input type="password"  class="form-control"
                               id="update_profile_password_cur" 
                               name="update_profile_password_cur" value="" size="50" />
                    </div>

                    <div class="form-selector">
                        <label for="update_profile_password"><?=$this->lang->line("New Password")?> :</label>
                        <?= form_error('update_profile_password', '', ''); ?>
                        <input type="password"  class="form-control"
                               id="update_profile_password" 
                               name="update_profile_password" value="{update_profile_password}" size="50" />
                    </div>

                    <div class="form-selector">
                        <label id="update_profile_passconf"><?=$this->lang->line("Password Confirm")?><span class="required">*</span> :</label>
                        <?= form_error('update_profile_passconf', '', ''); ?>
                        <input type="password" class="form-control" 
                               id="update_profile_passconf" 
                               name="update_profile_passconf" value="{update_profile_passconf}" size="50" />
                    </div>
                    <br/>
                    <div class="form-selector">
                        <button class="button edit-curd"><i class="fa fa-user"></i>&nbsp; <span><?=$this->lang->line("Change Password")?></span></button>
                    </div>
                    
                    <?php echo form_close(); ?>

                    <!-- <div class="register-benefits">
                        <h5><?=$this->lang->line("Mange Profile today and you will be able to")?> :</h5>
                        <ul>
                            <li><?=$this->lang->line("Speed your way through checkout")?></li>
                            <li><?=$this->lang->line("Track your orders easily")?></li>
                            <li><?=$this->lang->line("Keep a record of all your purchases")?></li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>


    </div>



</div>