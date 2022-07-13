<?php
	$demo = $_SERVER["REQUEST_URI"];
	$arr = explode('?', $demo); 
	 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Admin Portal</title>
		<!-- Favicon  -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=base_url()?>backend/new_theme/assets/newlogin/login.css" type="text/css" media="all" />
	</head>
	<body>
		<main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
			<div class="container">
				<div class="card login-card">
					<div style="height: 650px; overflow-y: scroll;" class="row no-gutters">
						<div class="col-md-5">
							<img src="<?php echo base_url("backend/new_theme/assets/newlogin/login.jpg")?>" alt="login" class="login-card-img">
						</div>
						<div class="col-md-7">
							<div class="card-body">
								<div style="text-align: center;" class="brand-wrapper">
									<img src="<?php echo base_url("backend/new_theme/assets/newlogin/logo.PNG")?>"  class="logo">
								</div>
								
								
								<div class="form signin-form show-md-signup">
									<p class="login-card-description"><?=$this->lang->line("Register")?></p>
									
									<?php 
										if(!empty(form_error('process_registration'))){
											echo '<div class="alert alert-danger" role="alert">'.form_error('process_registration').'</div>';
										}
									?>
									<?php 
										if(!empty($this->session->flashdata('error_msg'))){
											$error_msg = $this->session->flashdata('error_msg');
											if(!empty($error_msg['message'])){
												echo '<div class="alert alert-danger" role="alert">'.$error_msg['message'].'</div>';
											}
										}
									?>
									<?php 
										if(!empty($this->session->flashdata('login_load_msg'))){
											echo '<div class="alert alert-success" role="alert">'.$this->session->flashdata('login_load_msg').'</div>';
										}
									?>
									<?php echo form_open(base_url() . 'registration'); ?>
									<div class="form-group">
										<input class="form-control firstName_reg" type="text" size="50" id="reg_profilename" name="reg_profilename" value="{reg_profilename}" placeholder="<?=$this->lang->line("Full Name")?>" required="true" maxlength="" data="required" autocomplete="off" autofocus="" >
										<span class="mobilenumber-error"><?= form_error('reg_profilename'); ?></span>
									</div>	
									<div class="form-group">
										<input type="text" value="{reg_mobile_no}" maxlength="10" pattern="\d{10}" required="true" name="reg_mobile_no" id="reg_mobile_no" class="form-control mobileNumberClass" autofocus="" placeholder="<?=$this->lang->line("Mobile Number")?>" autocomplete="off">
										<span class="mobilenumber-error"> <?php echo form_error('reg_mobile_no'); ?></span>
									</div>	
									<div class="form-group">
										<div class="input-group">
											<input class="form-control showpass" pattern=".{6,}" type="password" type="reg_password" name="reg_password" value="{reg_password}" placeholder="<?=$this->lang->line("Password")?>*" required="true" maxlength="" data="required" autocomplete="off">
											<div class="input-group-append">
												<span class="input-group-text">
													<label class="showHideRegLabel">
														<input type="checkbox" name="showHide" class="showHideReg">
														<?=$this->lang->line("Show")?>
													</label>
												</span>
											</div>
										</div>
										<span class="mobilepassword-error"><?= form_error('reg_password'); ?></span>
									</div>	
									<div class="form-group">
										<input class="form-control email_reg" type="email" name="reg_useremail" id="reg_useremail" value="{reg_useremail}" placeholder="<?=$this->lang->line("Email")?>*" maxlength="" autocomplete="off">
										<span class="mobilepassword-error"><?= form_error('reg_useremail'); ?></span>
									</div>	
									<!-- <div class="form-group">
										<input class="form-control email_reg" type="text" name="reg_referral_code" id="reg_referral_code" value="{reg_referral_code}" placeholder="<?=$this->lang->line("Referral Code")?>" maxlength="">
										<span class="mobilepassword-error"><?= form_error('reg_referral_code'); ?></span>
									</div>	 -->
									<div style="font-size: smaller;" class="form-group">
										<label class="reg_private_policy"><input type="checkbox" required="" class="tcAgree" name="reg_private_policy" id="reg_private_policy" aria-required="true">
											I Agree to the 
											<a class="link-alternate" href="<?=base_url()?>terms_conditions" target="_blank"><?=$this->lang->line("Terms & Conditions")?></a>  <?=$this->config->item('name');?>.
										</label>
										<span class="regtnc-error"><?= form_error('reg_private_policy'); ?></span>
									</div>	
									<div style="font-size: smaller;" class="form-group">
										<label style="" class="reg_private_policy"><input type="checkbox" required="" class="tcAgree" name="reg_private_policy" id="reg_private_policy" aria-required="true">
											I Agree for Mnandi Retail Solutions to send me SMS & Email notifications. 
										</label>
										<span class="regtnc-error"><?= form_error('reg_private_policy'); ?></span>
									</div>	
									<div class="form-group">
										<button class="btn btn-block login-btn mb-4"><i class="fa fa-user"></i>&nbsp; <span><?=$this->lang->line("Register")?></span></button>
									</div>	
									<div style="font-size: smaller;" class="form-group">
										<span>Already Account</span>
										<a href="{base_url}login" class="reg_in" title="Register"><?=$this->lang->line("Sign In")?></a> 
									</div>
									
								</div>
								
								<nav  class="login-card-footer-nav">
									<a href="https://www.mnandiretail.com" >© 2021 | Mnandi Retail Solutions</a></p>
								</nav>
							</div>
							
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
        
    });
	
	
	
	$(document).on("keypress",".mobileNumberClass",function(b){
		var a=(b.which)?b.which:b.keyCode;
		if(a>31&&(isNaN(String.fromCharCode(a))||$(this).val().length>9)){
			return false
			
		}return true
		
	});
	
	
	$(document).on("click", ".showHideReg",function(e){
		if($(this).parents('.input-group').find('.showpass').attr("type")==="password"){
			$(this).parents('.input-group').find('.showpass').attr("type","text");
		}else{
			$(this).parents('.input-group').find('.showpass').attr("type","password");
		}
		
	});

	
</script>


</body>
</html>
