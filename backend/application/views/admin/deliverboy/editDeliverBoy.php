<?php  $this->load->view("admin/common/head"); ?>
    <style>
        .border-dark{
            padding: 10px 0px 0px 0px;
            border-top:1px #ccc solid;
            border-bottom:1px #ccc solid;
        }
        table.custom-table > thead > tr > th{
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }
        .mybtn{text-align:center;}
        .mybtn .dt-buttons>button{
        webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        position: relative;
        border: 0;
        border-radius: 3px;
        padding: 6px;
        font-weight: 400;
        color: #ffffff;
        font-style: inherit;
        font-variant: inherit;
        font-size: inherit;
        font-family: inherit;
        line-height: inherit;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.26);
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),-webkit-transform .4s cubic-bezier(.25,.8,.25,1);
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),transform .4s cubic-bezier(.25,.8,.25,1);
        }
        .mybtn .dt-buttons>button:nth-child(1){
        background-color: #e91e63;
        }
        .mybtn .dt-buttons>button:nth-child(2){
        background-color: #2196f3;
        margin-left: 3x;
        }
        .mybtn .dt-buttons>button:nth-child(3){
        background-color: #4caf50;
        margin-left: 3px;
        }
        .mybtn .dt-buttons>button:nth-child(4){
        background-color: #e91e63;
        margin-left: 3px;
        }
        
        .myselect label, .mysearch label{color: #292929;}
        .myselect select{height: 35px; width: 100%; padding: 0 5px;}
        
        .mysearch label{display:block;}
        .mysearch input{width:100% !important; border:1px solid #cccccc; height: 35px; padding: 0 12px;}
        a.action-btn-detail{
                padding: 10px;
                border-radius: 50%;
        }
        a.action-btn-edit{
                padding: 11px 5px;
                border-radius: 50%;
        }
        .col-lg-3 {
            width: 14%;
        }
        
    </style>

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
                        <form id="add2" form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            <?php if($this->session->userdata('language') == "arabic")
                                {
                                ?>
                                    <div class="col-md-3">
                                    </div>
                                <?php
                                }
                            ?>
                            <?php
                                $q = $this->db->query("SELECT * FROM `language_setting`  WHERE `id`=1 " );
                                $rows = $q->row();
                                if($rows->status==1)
                                {
                                    $setting=0;
                                }
                                else
                                {
                                    $setting='style="display:none"';
                                }
                            ?>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Deliver Boy</h4>
									<div class="row"  style="margin-top:50px">
										
										<div class="col-md-3">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyname");?>: *</label>
												<input type="text" required name="user_name" value="<?=$deliverdata->user_name?>" id="user_name" class="form-control"  placeholder="Name"/>
											<span class="material-input"></span></div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyPhone");?>: *</label>
												<input type="number" required name="user_phone" value="<?=$deliverdata->user_phone?>" id="user_phone" class="form-control"  placeholder="Phone Number"/>
												<span class="material-input" id="error_phone" ></span>
											</div>
										</div>
									   <div class="col-md-3">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyEmail");?>: *</label>
												<input type="email" required name="user_email"  value="<?=$deliverdata->user_email?>" id="user_email" class="form-control"  placeholder="Email"/>
											<span class="material-input"></span></div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyPassword");?>: </label>
												<input type="password" required name="user_password" value="" id="user_password" class="form-control"  placeholder="Password"/>
											<span class="material-input"></span></div>
										</div>
									</div>
                                    
                                    <div class="row"  style="margin-top:50px">
										<div class="col-md-3">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyCountry");?>: *</label>
												<input type="text" required name="user_country" id="user_country" class="form-control"  placeholder="Country" value="<?php echo $deliverdata->user_country; ?>"/>
												<!-- <select class="text-input form-control" name="user_country" id="user_country" required>
													<option value=""><?php echo $this->lang->line("Select Country");?></option>
													<?php  
														$q = $this->db->query("SELECT * FROM country");
														$rows = $q->result_array();
														foreach($rows as $row){ 
															$data =  $deliverdata->user_country == $row['id'] ? 'selected':'';
															echo '<option value="'.$row['id'].'" '.$data.' >'.$row['name'].'</option>';
										
														}
														?>
														
												</select> -->
											<span class="material-input"></span></div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyState");?>: *</label>
												<input type="text" required name="user_state" id="user_state" class="form-control"  placeholder="Province" value="<?php echo $deliverdata->user_state; ?>"/>
												<!-- <select class="text-input form-control" name="user_state" id="user_state">
													<option value=""><?php echo $this->lang->line("Select State");?></option>
													<option value="<?=$deliverdata->user_state?>" selected><?=$deliverdata->state_name?></option>
												</select> -->
											<span class="material-input"></span></div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyCity");?>: *</label>
                                                <input type="text" required name="user_city" id="user_city" class="form-control"  placeholder="city" value="<?php echo $deliverdata->user_city; ?>"/>
												<!-- <select class="text-input form-control" name="user_city" id="user_city">
													<option value=""><?php echo $this->lang->line("Select City");?></option>
													<option value="<?=$deliverdata->user_city?>" selected><?=$deliverdata->city_name?></option>
												</select> -->
											<span class="material-input"></span></div>
										</div>
										
										<div class="col-md-3">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyPincode");?>: *</label>
												<input type="text" required name="user_pincode" id="user_pincode" class="form-control" value="<?=$deliverdata->user_pincode?>"  placeholder="Pincode"/>
											<span class="material-input"></span></div>
										</div>
									</div>
									
									<div class="row" style="margin-top:50px" >
										<div class="col-md-6">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoyAddress");?></label>
												<textarea name="deliverboy_address" class="textarea"  id="editor" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;" maxlength="1250"><?=$deliverdata->user_address?></textarea>
											<span class="material-input"></span></div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group label-floating is-empty">
												<label class="label-on-left"><?php echo $this->lang->line("deliverBoydescription");?></label>
												<textarea name="deliverboy_description" class="textarea"  id="editor" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;" maxlength="1250"><?=$deliverdata->deliverboy_description?></textarea>
											<span class="material-input"></span></div>
										</div>
									</div>
								   
									
									<div class="row" style="margin-top:50px">
										<div class="col-md-9">
											<legend></legend>
											<label class="col-md-3 label-on-left"><?php echo $this->lang->line("deliverboy Image");?>: *</label>
											<div class="fileinput fileinput-new text-center" data-provides="fileinput">
												<?php if(!empty($deliverdata->deliverBoyImage)){ ?>
												<div class="fileinput-new thumbnail">
													<img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'/uploads/deliver/'.$deliverdata->deliverBoyImage ?>">
												</div>
												<?php } ?>
													<div class="fileinput-preview fileinput-exists thumbnail"></div>
												<div>
													<span class="btn btn-rose btn-round btn-file">
														<span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
														<span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
														<input type="file" name="deliverBoyImage">
														<div class="ripple-container"></div>
													</span>
													<a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-9">
											<div class="form-group label-floating is-empty">
												<label class="control-label"></label>
											<input type="radio" name="user_status" value="1"  <?php if($deliverdata->user_status == 1) { echo "checked"; } ?>/>
											<label style="margin-left:20px"><?php echo $this->lang->line("Actvie");?></label>
											<span class="material-input"></span></div>
										</div>
									</div>
									<div class="row">                                            
										<div class="col-md-9">
											<div class="form-group label-floating is-empty">
												<label class="control-label"></label>
											<input type="radio" name="user_status"  value="0"  <?php if($deliverdata->user_status == 0) { echo "checked"; } ?> />
											<label style="margin-left:20px"><?php echo $this->lang->line("Deactive"); ?></label>
											<span class="material-input"></span></div>
										</div>
									</div>
									
								  
									<div class="row">
										<label class="col-md-3"></label>
										<div class="col-md-9">
											<div class="form-group form-button">
												<input type="submit" class="btn btn-fill btn-rose" name="adddeliverboy" value="Edit Deliver Boy">
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
   
   <script>
   //var BASE_URL  = BASE_URL+'backend/';
       var BASE_URL  = '<?=base_url();?>';
   $(document).ready(function() {
        $('#user_country').change(function(){
                var country = $(this).val();
                $.get(BASE_URL+"admin/getStateByCountry",{ country:country},function(data){
                if(data != "No Exist") {
                    $( "#user_state" ).html( data );
                 }
    			
            });
    
        });
        
        $('#user_state').change(function(){
                var state = $(this).val();
                $.get(BASE_URL+"admin/getCityByState",{ state:state},function(data){
                if(data != "No Exist") {
                    $( "#user_city" ).html( data );
                 }
    			
            });
    
        });
          
        $("#add2").validate({
            rules: {
                user_phone: {
                    required: true,
                    number: true
                   
                },
                user_password:{
                    required: true,
                   
                },
                user_name:{
                    required: true,
                    noSpace: true
                }
            }
        });
        
        $('#user_phone').change(function(){
                var phone = $("#user_phone").val();
                $.get(BASE_URL+"Admin/check_phone_deliverBoy",{ phone:phone},function(data){
                   
                if(data != "No Exist") {
                    $( "#error_phone" ).html( data );
                    $('#user_phone').val('');
                    return false;
                }
    			else{
    				$( "#error_phone" ).html('');
    			}
            });
    
        });
   });
     

   function update_price(price_id,tax_id,pro_price_id) {
       
       var projected_price   = parseFloat($('#'+price_id).val()) + ( (parseFloat($('#'+price_id).val()) *  parseFloat($('#'+tax_id).val()))/100 );
        $('#'+pro_price_id).val(projected_price);
   }
</script>
<script>
	initSample();
</script>
</html>