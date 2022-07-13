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
								
								<p class="login-card-description"><?=$this->lang->line("Forgot Password")?></p>
								<?php echo $this->session->flashdata('message'); ?>
								<?php echo form_open(base_url() . 'forget_account_password'); ?>
							   
								<div class="form-group">
									<input type="text" value="" maxlength="10" pattern="\d{10}" required="true" name="mobile_no" id="mobile_no" class="form-control mobileNumberClass" placeholder="<?=$this->lang->line("Mobile Number")?>" autofocus="">
									<span class="mobilenumber-error"> <?php echo form_error('mobile_no'); ?></span>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-block login-btn mb-4"><i class="fa fa-lock"></i>&nbsp; <span><?=$this->lang->line("Submit")?></span></button>
								</div>
								<div class="form-group">
									<a href="{base_url}login" class="reg_in" title="Register"><?=$this->lang->line("Sign In")?></a> 
								</div>
								<?php echo form_close(); ?>
								
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
	

	
</script>


</body>
</html>
