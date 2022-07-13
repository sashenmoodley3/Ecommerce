<?php  $this->load->view("admin/common/head"); ?>
    
</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('message'); 
                    ?>
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Ticket");?></h4>
                                        <div class="row">
										<div class="col-md-9">
                                            <?php
											// echo '<pre>';
											// print_r($records);
											// echo '</pre>';
											
											if(!empty($records)){
												foreach($records as $row){
													if ($row['type'] == 1) {
													?>
													<i class="fa fa-user"></i> <strong><?php echo $row['user_name'] ?>
														: </strong>
													<span>(<?php echo date('d M, Y h:i A', strtotime($row['create_date'])); ?>)</span>
													<br>
													<span class="desc"><?php echo $row['message']; ?></span><br><br>
												<?php } else { ?>
													<i class="fa fa-envelope"></i> <strong>Super Admin : </strong>
													<span>(<?php echo date('d M, Y h:i A', strtotime($row['create_date'])); ?>)</span>
													<br>
													<span class="desc"><?php echo $row['message']; ?></span><br><br>
												<?php }
													
													// if($row['type'] == '1'){
														// echo $row['user_name'].' '.$row['message'];
													// }
													// else{
														// echo 'Super Admin '.$row['message'];
													// }
												}
												
											}
											
											?>
                                        </div>
                                        </div>
										<br>
										<br>
										<br>
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Message");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <textarea name="message" id="message"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" class="form-control" required/><?php echo set_value('message') ?></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <button type="submit" class="btn btn-fill btn-rose"><?php echo $this->lang->line("Send");?></button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
</script>
</html>