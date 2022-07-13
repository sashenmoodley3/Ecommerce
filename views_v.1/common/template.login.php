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
					<div class="row no-gutters">
						<div class="col-md-5">
							<img src="<?php echo base_url("backend/new_theme/assets/newlogin/login.jpg")?>" alt="login" class="login-card-img">
						</div>
						<div class="col-md-7">
							<div class="card-body">
								<div style="text-align: center;" class="brand-wrapper">
									<img src="<?php echo base_url("backend/new_theme/assets/newlogin/logo.PNG")?>"  class="logo">
								</div>
								<div  class="form signin-form show-md-login">
									<p class="login-card-description">Sign into your account</p>
									<?php 
										if(!empty(form_error('process_login'))){
											echo '<div class="alert alert-danger" role="alert">'.form_error('process_login').'</div>';
										}
									?>
									<?php echo form_open(base_url() . 'login'); ?>
									
									
									<div class="form-group">
										<input type="text" value="{mobile_no}" maxlength="10" pattern="\d{10}" required="true" name="mobile_no" id="mobile_no" class="form-control mobileNumberClass" placeholder="<?=$this->lang->line("Mobile Number")?>" autofocus="">
										<span class="mobilenumber-error"> <?php echo form_error('mobile_no'); ?></span>
									</div>
									
									<div class="form-group">
										<div class="input-group mb-3">
											<input class="form-control showpass" type="password" name="password" value="{password}" placeholder="<?=$this->lang->line("Password")?>" required="true" autocomplete="off" >
											
											<div class="input-group-append">
												<span class="input-group-text">
													<label class="showHideRegLabel">
														<input type="checkbox" name="showHide" class="showHideReg">
														<?=$this->lang->line("Show")?>
													</label>
												</span>
											</div>
										</div>
										
										<span class="mobilenumber-error"> <?php echo form_error('password'); ?></span>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-block login-btn mb-4"><i class="fa fa-lock"></i>&nbsp; <span><?=$this->lang->line("Login")?></span></button>
									</div>
									
									<div class="form-group">
										<div class="float-left">
											<a class="signin--forgot-password modal-link" href="<?=base_url()?>forget_account_password" title=""><?=$this->lang->line("Forgot Password")?>?</a>
										</div>
										
										<div class="float-right">
											<span><?=$this->lang->line("New Customer")?>?</span>
											<a href="{base_url}registration" class="reg" title="Register"><?=$this->lang->line("Register")?></a> 
										</div>
										
										<div class="clearfix"></div>
										
									</div>
									
									
									<?php echo form_close(); ?>
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
