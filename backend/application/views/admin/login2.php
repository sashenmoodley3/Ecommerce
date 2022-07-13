<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Portal</title>
  <!-- Favicon  -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url()?>new_theme/assets/newlogin/login.css" type="text/css" media="all" />
</head>
<body>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="<?php echo base_url($this->config->item("new_theme")."/assets/newlogin/login.jpg")?>" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div style="text-align: center;" class="brand-wrapper">
                <img src="<?php echo base_url($this->config->item("new_theme")."/assets/newlogin/logo.PNG")?>"  class="logo">
              </div>
              <p class="login-card-description">Sign into your account</p>
              <form method="post" action="">
                  <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                  </div>
                  <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
                </form>
                <nav  class="login-card-footer-nav">
					<a href="https://www.mnandiretail.com" >© 2021 | Mnandi Retail Solutions</a></p>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>