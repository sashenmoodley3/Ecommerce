<?php  $this->load->view("admin/common/head"); 
$q  =   $data; 
?>
</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Rewards Setting");?></h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="label-control"><?php echo $this->lang->line("Is Reward Enable");?></label>
													<br>
													<label>
												   <input type="checkbox" name="is_reward" value="1" <?=!empty($q->is_reward)? 'checked' : ''?>> Yes
												   </label>
												</div>
											</div>
                                        </div>
										<h4><?php echo $this->lang->line("Rewards Value");?></h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="label-control"><?php echo $this->lang->line("Amount On Sale").'('.$this->config->item('currency').')';?></label>
												   <input type="text" name="amount_on_sale" class="form-control" value="<?=!empty($q->amount_on_sale) ?  $q->amount_on_sale : ''?>"> 
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="label-control"><?php echo $this->lang->line("Point On Sale");?></label>
												   <input type="text" name="point_on_sale" class="form-control" value="<?=!empty($q->point_on_sale) ?  $q->point_on_sale : ''?>"> 
												</div>
											</div>
                                        </div>
										<h4><?php echo $this->lang->line("Redeem Setting");?></h4>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="label-control"><?php echo $this->lang->line("Point To Wallet");?></label>
												   <input type="text" name="point_to_wallet" class="form-control" value="<?=!empty($q->point_to_wallet) ?  $q->point_to_wallet : ''?>"> 
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="label-control"><?php echo $this->lang->line("Amount To Wallet").'('.$this->config->item('currency').')';?></label>
												   <input type="text" name="amount_to_wallet" class="form-control" value="<?=!empty($q->amount_to_wallet) ?  $q->amount_to_wallet : ''?>"> 
												</div>
											</div>
                                        </div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="label-control"><?php echo $this->lang->line("Min Point Transfer");?></label>
												   <input type="text" name="min_point_transfer" class="form-control" value="<?=!empty($q->min_point_transfer) ?  $q->min_point_transfer: ''?>"> 
												</div>
											</div>
											
                                        </div>
                                    </div>
                                    <div class="card-footer">
										<div class="form-group form-button">
											<input type="submit" name="savecat" value="<?php echo $this->lang->line("Save");?>" class="btn btn-fill btn-rose" />
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                   
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->
<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
<script type="text/javascript">
 CKEDITOR.replace( 'description' );
</script>
</html>