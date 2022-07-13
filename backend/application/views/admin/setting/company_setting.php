<?php

$cset = [];
foreach($setting as $set){
	$cset[$set->titles] = $set->value;
}


$tag_titles             =   'company_title';
$titles                 =   !empty($cset['company_title']) ? $cset['company_title'] : '';

$tag_logo               =   'company_logo';
$logo                   =   !empty($cset['company_logo']) ? $cset['company_logo'] : '';

$tag_favicon            =   'company_favicon';
$favicon                =   !empty($cset['company_favicon']) ? $cset['company_favicon'] : '';

$tag_taglaine           =   'company_taglaine';
$taglaine               =   !empty($cset['company_taglaine']) ? $cset['company_taglaine'] : '';

$tag_referal            =   'company_referal';
$referal                =   !empty($cset['company_referal']) ? $cset['company_referal'] : '';

$tag_sms_url            =   'sms_url';
$sms_url                =   !empty($cset['sms_url']) ? $cset['sms_url'] : '';

$tag_sms_user           =   'sms_user';
$sms_user               =   !empty($cset['sms_user']) ? $cset['sms_user'] : '';

$tag_sms_pass           =   'sms_pass';
$sms_pass               =   !empty($cset['sms_pass']) ? $cset['sms_pass'] : '';

$tag_app_version        =   'app_version';
$app_version            =   !empty($cset['app_version']) ? $cset['app_version'] : '';

$tag_app_url            =   'app_url';
$app_url                =   !empty($cset['app_url']) ? $cset['app_url'] : '';

$tag_wallet_deduction   =   'wallet_deduction';
$wallet_deduction       =   !empty($cset['wallet_deduction']) ? $cset['wallet_deduction'] : '';

$tag_company_email      =   'company_email';
$company_email          =   !empty($cset['company_email']) ? $cset['company_email'] : '';

$tag_company_mobile     =   'company_mobile';
$company_mobile         =   !empty($cset['company_mobile']) ? $cset['company_mobile'] : '';

$tag_order_deduction    =   'minimum_order_deduction';
$order_deduction        =   !empty($cset['minimum_order_deduction']) ? $cset['minimum_order_deduction'] : '';

$tag_delivery_start_time=   'delivery_start_time';
$delivery_start_time    =   !empty($cset['delivery_start_time']) ? $cset['delivery_start_time'] : '';

$tag_delivery_end_time  =   'delivery_end_time';
$delivery_end_time      =   !empty($cset['delivery_end_time']) ? $cset['delivery_end_time'] : '';

$tag_company_whatsappno =   'company_whatsappno';
$company_whatsappno     =   !empty($cset['company_whatsappno']) ? $cset['company_whatsappno'] : '';

$tag_fb                 =   'fb';
$fb                     =   !empty($cset['fb']) ? $cset['fb'] : '';

$tag_insta              =   'insta';
$insta                  =   !empty($cset['insta']) ? $cset['insta'] : '';

$tag_twitter            =   'twitter';
$twitter                =   !empty($cset['twitter']) ? $cset['twitter'] : '';

$tag_linkedn            =   'linkedn';
$linkedn                =   !empty($cset['linkedn']) ? $cset['linkedn'] : '';

$tag_youtube            =   'youtube';
$youtube                =   !empty($cset['youtube']) ? $cset['youtube'] : '';

$tag_rewards            =   'rewards';
$rewards                =   !empty($cset['rewards']) ? $cset['rewards'] : '';

$firebase_key           =   !empty($cset['firebase_key']) ? $cset['firebase_key'] : '';
$tag_firebase_key       =   'firebase_key';

$firebase_addwords      =   !empty($cset['firebase_addword']) ? $cset['firebase_addword'] : '';
$tag_firebase_addwords  =   'firebase_addword';

$firebase_analytics     =   !empty($cset['firebase_analytics']) ? $cset['firebase_analytics'] : '';
$tag_firebase_analytics =   'firebase_analytics';

$firebase_addmob        =   !empty($cset['firebase_addmob']) ? $cset['firebase_addmob'] : '';
$tag_firebase_addmob    =   'firebase_addmob';

$currency               =   !empty($cset['currency']) ? $cset['currency'] : '';
$tag_currency           =   'currency';

$sender_amount          =   !empty($cset['sender_amount']) ? $cset['sender_amount'] : '';
$tag_sender_amount      =   'sender_amount';

$email_host             =   !empty($cset['email_host']) ? $cset['email_host'] : '';
$tag_email_host         =   'email_host';

$email_username         =   !empty($cset['email_username']) ? $cset['email_username'] : '';
$tag_email_username     =   'email_username';

$email_password         =   !empty($cset['email_password']) ? $cset['email_password'] : '';
$tag_email_password     =   'email_password';

$email_smtp             =   !empty($cset['email_smtp']) ? $cset['email_smtp'] : '';
$tag_email_smtp         =   'email_smtp';

$email_port             =   !empty($cset['email_port']) ? $cset['email_port'] : '';
$tag_email_port         =   'email_port';

$address                =   !empty($cset['address']) ? $cset['address'] : '';
$tag_address            =   'address';

$about                  =   !empty($cset['about']) ? $cset['about'] : '';
$tag_about              =   'about';

$tawk_panel             =   !empty($cset['tawk_panel']) ? $cset['tawk_panel'] : '';
$tag_tawk_panel         =   'tawk_panel';

$facebook_pixel         =   !empty($cset['facebook_pixel']) ? $cset['facebook_pixel'] : '';
$tag_facebook_pixel     =   'facebook_pixel';

$facebook_event         =   !empty($cset['facebook_event']) ? $cset['facebook_event'] : '';
$tag_facebook_event     =   'facebook_event';

$tag_manager            =   !empty($cset['tag_manager']) ? $cset['tag_manager'] : '';
$tag_tag_manager        =   'tag_manager';

$pwa_app                =   !empty($cset['pwa_app']) ? $cset['pwa_app'] : '';
$tag_pwa_app            =   'pwa_app';

$splash_screen          =   !empty($cset['splash_screen']) ? $cset['splash_screen'] : '';
$tag_splash_screen      =   'splash_screen';

$intro_screen           =   !empty($cset['intro_screen']) ? $cset['intro_screen'] : '';
$tag_intro_screen       =   'intro_screen';

$app_icon               =   !empty($cset['app_icon']) ? $cset['app_icon'] : '';
$tag_app_icon           =   'app_icon';

$web_one_row_item_show  =   !empty($cset['web_one_row_item_show']) ? $cset['web_one_row_item_show'] : '';
$tag_web_one_row_item_show =   'web_one_row_item_show';

$time_slot              =   !empty($cset['time_slot']) ? $cset['time_slot'] : '';
$tag_time_slot          =   'time_slot';

$lite_app_icon          =   !empty($cset['lite_app_icon']) ? $cset['lite_app_icon'] : '';
$tag_lite_app_icon      =   'lite_app_icon';

$refund_time_limit      =   !empty($cset['refund_time_limit']) ? $cset['refund_time_limit'] : '';
$tag_refund_time_limit  =   'refund_time_limit';

$vat                    =   !empty($cset['vat']) ? $cset['vat'] : '';
$tag_vat                =   'vat';

$country_phone_code     =   !empty($cset['country_phone_code']) ? $cset['country_phone_code'] : '';
$tag_country_phone_code =   'country_phone_code';

$flavor                 =   !empty($cset['add_product_text_box']) ? $cset['add_product_text_box'] : '';
$tag_flavor             =   'add_product_text_box';

$out_of_stock_quantity      =   !empty($cset['out_of_stock_quantity']) ? $cset['out_of_stock_quantity'] : '';
$tag_out_of_stock_quantity  =   'out_of_stock_quantity';

$facebook_app_id      	=   !empty($cset['facebook_app_id']) ? $cset['facebook_app_id'] : '';
$tag_facebook_app_id  	=   'facebook_app_id';

$facebook_app_secret      =   !empty($cset['facebook_app_secret']) ? $cset['facebook_app_secret'] : '';
$tag_facebook_app_secret  =   'facebook_app_secret';

$google_client_id      =   !empty($cset['google_client_id']) ? $cset['google_client_id'] : '';
$tag_google_client_id  =   'google_client_id';

$google_client_secret      =   !empty($cset['google_client_secret']) ? $cset['google_client_secret'] : '';
$tag_google_client_secret  =   'google_client_secret';

$delivery_date_after_days       =   !empty($cset['delivery_date_after_days']) ? $cset['delivery_date_after_days'] : '';
$tag_delivery_date_after_days   =   'delivery_date_after_days';

$tag_logo1               	=   'company_logo1';
$logo1                  	=   !empty($cset['company_logo1']) ? $cset['company_logo1'] : '';

$tag_tax_no             	=   'tax_no';
$tax_no                  	=   !empty($cset['tax_no']) ? $cset['tax_no'] : '';

$tag_shop_one_row_item_show =   'shop_one_row_item_show';
$shop_one_row_item_show     =   !empty($cset['shop_one_row_item_show']) ? $cset['shop_one_row_item_show'] : '';

$tag_deliver_boy_app_url =   'deliver_boy_app_url';
$deliver_boy_app_url     =   !empty($cset['deliver_boy_app_url']) ? $cset['deliver_boy_app_url'] : '';

?>
<?php  $this->load->view("admin/common/head"); ?>
<style>
    .border{
        border: 1px solid #3e3a3a;
        padding: 21px;
    }
       
</style>
</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('success_req'); 
                    ?>
					<div class="msg"></div>
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal"  id="form1">
                            <?php if($this->session->userdata('language') == "arabic")
                                {
                                ?>
                                <div class="col-md-3">
                                </div>
                                <?php
                                }
                                ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Company Setting");?></h4>
                                        <div class="row " style="margin-top:20px">
                                            
                                            <div class="col-md-6">
                                                <label class="label-on-left"><?php echo $this->lang->line("Title");?>:</label>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="company[<?=$tag_titles?>]" value="<?php echo $titles; ?>" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="label-on-left"><?php echo $this->lang->line("Tag Line");?>:</label>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="company[<?=$tag_taglaine?>]" value="<?php echo $taglaine; ?>" class="form-control" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col-md-6">
                                            <label class="label-on-left"><?php echo $this->lang->line("Comapny Email");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_company_email?>]" value="<?php echo $company_email; ?>" class="form-control"  />
                                            <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Comapny Mobile");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_company_mobile?>]" value="<?php echo $company_mobile; ?>" class="form-control"/>
                                            <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                    <div class="row"  style="margin-top:20px">
                                            
                                            <div class="col-md-3">
                                                <label><?php echo $this->lang->line("Company Logo");?>:</label>
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <?php if(!empty($logo)){ ?>
                                                            <img width="100%" height="100%" src="<?= base_url('uploads/company/'.$logo); ?>" />
                                                        <?php } ?>
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" name="company_logo">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label><?php echo $this->lang->line("Company Logo Extra");?>:</label>
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <?php if(!empty($logo1)){ ?>
                                                            <img width="100%" height="100%" src="<?= base_url('uploads/company/'.$logo1); ?>" />
                                                        <?php } ?>
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" name="company_logo1">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label><?php echo $this->lang->line("Company Favicon");?>:</label>
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <?php if(!empty($favicon)){ ?>
                                                            <img width="100%" height="100%" src="<?= base_url('uploads/company/'.$favicon); ?>" />
                                                        <?php } ?>
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" name="company_favicon">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label><?php echo $this->lang->line("Lite Application Logo");?>:</label>
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <?php if(!empty($lite_app_icon)){ ?>
                                                            <img width="100%" height="100%" src="<?= base_url('uploads/company/'.$lite_app_icon); ?>" />
                                                        <?php } ?>
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" name="lite_app_icon">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("App Integration");?></h4>
                                    <div class="row " style="margin-top:20px">
                                        <div class="col-md-6">
                                            <label class="label-on-left"><?php echo $this->lang->line("App Url");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_app_url?>]" value="<?php echo $app_url; ?>" class="form-control"  />
                                            <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class=" label-on-left"><?php echo $this->lang->line("App Version");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_app_version?>]" value="<?php echo $app_version; ?>" class="form-control"/>
                                            <span class="material-input"></span></div>
                                        </div>
									</div>
									<div class="row " style="margin-top:20px">
                                        <div class="col-md-6">
                                            <label class="label-on-left"><?php echo $this->lang->line("Deliver Boy App Url");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_deliver_boy_app_url?>]" value="<?php echo $deliver_boy_app_url; ?>" class="form-control"  />
                                            <span class="material-input"></span></div>
                                        </div>
										<div class="col-md-6">
                                            <label class="label-on-left"><?php echo $this->lang->line("Pwa App Url");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_pwa_app?>]" value="<?php echo $pwa_app; ?>" class="form-control"  />
                                            <span class="material-input"></span></div>
                                        </div>
                                        
                                    </div>
                                 </div>
                            </div>
                            
                            
                            
                            <!--<div class="card">-->
                            <!--    <div class="card-header card-header-icon" data-background-color="rose">-->
                            <!--        <i class="material-icons">contacts</i>-->
                            <!--    </div>-->
                            <!--    <div class="card-content">-->
                            <!--        <h4 class="card-title"><?php echo $this->lang->line("App Images");?></h4>-->
                            <!--        <div class="row " style="margin-top:20px">-->
                            <!--           <div class="col-md-3">-->
                            <!--                <label><?php echo $this->lang->line("App Icon");?>:</label>-->
                            <!--                <legend></legend>-->
                            <!--                <div class="fileinput fileinput-new text-center" data-provides="fileinput">-->
                            <!--                    <div class="fileinput-new thumbnail">-->
                            <!--                        <?php /* 
                            <!--                        if(!empty($app_icon)){-->
                            <!--                                echo '<img width="100%" height="100%" src="'.base_url('uploads/company/'.$app_icon).'" />';    -->
                            <!--                        }?>-->
                            <!--                    </div>-->
                            <!--                    <div class="fileinput-preview fileinput-exists thumbnail"></div>-->
                            <!--                    <div>-->
                            <!--                        <span class="btn btn-rose btn-round btn-file">-->
                            <!--                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>-->
                            <!--                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>-->
                            <!--                            <input type="file" name="app_icon">-->
                            <!--                        </span>-->
                            <!--                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>-->
                            <!--                    </div>-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--            <div class="col-md-3">-->
                            <!--                <label><?php echo $this->lang->line("Splash Screen");?>:</label>-->
                            <!--                <legend></legend>-->
                            <!--                <div class="fileinput fileinput-new text-center" data-provides="fileinput">-->
                            <!--                    <div class="fileinput-new thumbnail">-->
                            <!--                        <?php -->
                            <!--                        if(!empty($splash_screen)){-->
                            <!--                            echo '<img width="100%" height="100%" src="'.base_url('uploads/company/'.$splash_screen).'" />';-->
                            <!--                        }?>-->
                            <!--                    </div>-->
                            <!--                    <div class="fileinput-preview fileinput-exists thumbnail"></div>-->
                            <!--                    <div>-->
                            <!--                        <span class="btn btn-rose btn-round btn-file">-->
                            <!--                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>-->
                            <!--                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>-->
                            <!--                            <input type="file" name="splash_screen">-->
                            <!--                        </span>-->
                            <!--                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>-->
                            <!--                    </div>-->
                            <!--                </div>-->
                            <!--            </div>-->
                                        
                            <!--            <div class="col-md-6">-->
                            <!--                <label><?php echo $this->lang->line("Intro Screen");?>:</label>-->
                            <!--                <legend></legend>-->
                            <!--                <div class="fileinput fileinput-new text-center" data-provides="fileinput">-->
                            <!--                    <div class="fileinput-new thumbnail">-->
                            <!--                        <?php -->
                            <!--                        $cart_screen    =   json_decode($intro_screen);-->
                            <!--                        if(!empty($cart_screen) && count($cart_screen) > 0){ -->
                            <!--                            $i =0;-->
                            <!--                            foreach($cart_screen as $screen){ -->
                            <!--                                if($i == 2){-->
                            <!--                                    echo '<br/><div style="clear:both"></div>';-->
                            <!--                                }-->
                            <!--                                echo '<img style="width:" src="'.base_url('uploads/company/'.$screen).'" />';  -->
                            <!--                                $i = $i+1;-->
                            <!--                            } -->
                            <!--                        } */?>-->
                                                    
                            <!--                    </div>-->
                            <!--                    <div class="fileinput-preview fileinput-exists thumbnail"></div>-->
                            <!--                    <div>-->
                            <!--                        <span class="btn btn-rose btn-round btn-file">-->
                            <!--                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>-->
                            <!--                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>-->
                            <!--                            <input type="file" name="intro_screen[]" multiple>-->
                            <!--                        </span>-->
                            <!--                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>-->
                            <!--                    </div>-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--     </div>-->
                            <!--</div>-->
                            
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("SMS Integration");?></h4>
                                    <div class="row " style="margin-top:20px">
                                        <div class="col-md-4">
                                            <label class="label-on-left"><?php echo $this->lang->line("SMS URL");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_sms_url?>]" value="<?php echo $sms_url; ?>" class="form-control"  />
                                            <span class="material-input"></span></div>
                                        </div>
                                    
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("SMS User Name");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_sms_user?>]" value="<?php echo $sms_user; ?>" class="form-control"/>
                                            <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="label-on-left"><?php echo $this->lang->line("SMS Password");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_sms_pass?>]" value="<?php echo $sms_pass; ?>" class="form-control"  />
                                            <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Email Integration");?></h4>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Email Host");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_email_host?>]" value="<?php echo $email_host; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Email Username");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_email_username?>]" value="<?php echo $email_username; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Email Password");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_email_password?>]" value="<?php echo $email_password; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Email SMTP");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_email_smtp?>]" value="<?php echo $email_smtp; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Email Port");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_email_port?>]" value="<?php echo $email_port; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Other Integration");?></h4>
                                    <div class="row " style="margin-top:20px">
                                        <div class="col-md-2">
                                            <label class="label-on-left"><?php echo $this->lang->line("Referral Amount");?> :</label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_referal?>]" value="<?php echo $referal; ?>" class="form-control"  />
                                            <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="label-on-left"><?php echo $this->lang->line("Sender Amount");?> :</label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_sender_amount?>]" value="<?php echo $sender_amount; ?>" class="form-control"  />
                                            <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Wallet Deduction");?> (Percentage): </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_wallet_deduction?>]" value="<?php echo $wallet_deduction; ?>" class="form-control"/>
                                            <span class="material-input"></span></div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Order Deduction");?> Rs.: </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_order_deduction?>]" value="<?php echo $order_deduction; ?>" class="form-control"/>
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Product Extra Field");?>: </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_flavor?>]" value="<?php echo $flavor; ?>" class="form-control" placeholder=" if required then put value other wise blank"/>
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class=" label-on-left"><?php echo $this->lang->line("WhatsApp No");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_company_whatsappno?>]" value="<?php echo $company_whatsappno; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                                <label class=" label-on-left"><?php echo $this->lang->line("Select Currency");?></label>
                                                <div class="form-group label-floating is-empty">
                                                    <select class="text-input form-control" name="company[<?=$tag_currency?>]">
                                                        <option value=""><?php echo $this->lang->line("Select Currency");?></option>
                                                        <?php
                                                            $sql = $this->db->query("SELECT * FROM currencies");
                                                            $rows = $sql->result();
                                                            foreach($rows as $row){
                                                                if($currency == $row->id){
                                                                    echo '<option selected value="'.$row->id.'">'.$row->country.'( '.$row->code.' - '.$row->symbol.')</option>';
                                                                }
                                                                else{
                                                                    echo '<option  value="'.$row->id.'">'.$row->country.'( '.$row->code.' - '.$row->symbol.')</option>';
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
										<div class="col-md-3">
                                                <label class=" label-on-left"><?php echo $this->lang->line("Delivery Date After Days");?></label>
                                                <div class="form-group label-floating is-empty">
                                                    <select class="text-input form-control" name="company[<?=$tag_delivery_date_after_days?>]">
                                                        <option value=""><?php echo $this->lang->line("Select Days");?></option>
                                                        <?php
                                                            
                                                            foreach(range(1,10) as $val){
                                                                if($delivery_date_after_days == $val){
                                                                    echo '<option selected value="'.$val.'">'.$val.'</option>';
                                                                }
                                                                else{
                                                                    echo '<option value="'.$val.'">'.$val.'</option>';
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Time Slot");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="checkbox" name="company[<?=$tag_time_slot?>]" id="time_slot" value="<?=$time_slot == 1 ? 1: 0?>" <?=$time_slot == 1 ? 'checked':''?> >
                                                <input type="hidden" name="company[<?=$tag_time_slot?>]" id="time_slot_1" value="<?=$time_slot?>">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Tax title");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_vat?>]" value="<?php echo $vat; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
										<div class="col-md-2">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Tax No.");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_tax_no?>]" value="<?php echo $tax_no; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Country Phone Code");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_country_phone_code?>]" value="<?php echo $country_phone_code; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                            
                            
                            
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Social Links");?></h4>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Facebook");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_fb?>]" value="<?php echo $fb; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Instagram");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_insta?>]" value="<?php echo $insta; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("YouTube");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_youtube?>]" value="<?php echo $youtube; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("twiter");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_twitter?>]" value="<?php echo $twitter; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("linkden");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_linkedn?>]" value="<?php echo $linkedn; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                            
                                        </div>
                                </div>
                            </div>
                            
							<div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Product Setting");?></h4>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col-md-3">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Front Website One Row Product Show");?> : </label>
                                            <div class="form-group label-floating is-empty">
												<select class="text-input form-control" name="company[<?=$tag_web_one_row_item_show?>]">
													<option value=""><?php echo $this->lang->line("Select Item");?></option>
													<option value="3" <?= $web_one_row_item_show == "3" ? 'selected':''?>>3</option>
													<option value="4" <?= $web_one_row_item_show == "4" ? 'selected':''?>>4</option>
													<option value="5" <?= $web_one_row_item_show == "5" ? 'selected':''?>>5</option>
												</select>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Shop Page One Row Product Show");?> : </label>
                                            <div class="form-group label-floating is-empty">
												<select class="text-input form-control" name="company[<?=$tag_shop_one_row_item_show?>]">
													<option value=""><?php echo $this->lang->line("Select Item");?></option>
													<option value="2" <?= $shop_one_row_item_show == "2" ? 'selected':''?>>2</option>
													<option value="3" <?= $shop_one_row_item_show == "3" ? 'selected':''?>>3</option>
													<option value="4" <?= $shop_one_row_item_show == "4" ? 'selected':''?>>4</option>
												</select>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Refund Order time limit ( in hours)");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_refund_time_limit?>]" value="<?php echo $refund_time_limit; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Out of Stock Quantity");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_out_of_stock_quantity?>]" value="<?php echo $out_of_stock_quantity; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Front Website Content");?></h4>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col-md-6">
                                            <label class="label-on-left"><?php echo $this->lang->line("Footer About");?>:</label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <textarea name="company[<?=$tag_about?>]" class="textarea" required  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $about; ?></textarea>
                                            <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="label-on-left"><?php echo $this->lang->line("Address");?>:</label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <textarea name="company[<?=$tag_address?>]" class="textarea" required  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $address; ?></textarea>
                                            <span class="material-input"></span></div>
                                        </div>
                                        
                                    </div>

                                    
                                </div>
                            </div>
                        
							<div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Social Login Details");?></h4>
                                    <h6><?php echo $this->lang->line("Facebook");?></h5>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Facebook App ID");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_facebook_app_id?>]" value="<?php echo $facebook_app_id; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Facebook App Secret");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_facebook_app_secret?>]" value="<?php echo $facebook_app_secret; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									<h6><?php echo $this->lang->line("Google");?></h5>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Google Client ID");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_google_client_id?>]" value="<?php echo $google_client_id; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" label-on-left"><?php echo $this->lang->line("Google Client Secret");?> : </label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="company[<?=$tag_google_client_secret?>]" value="<?php echo $google_client_secret; ?>" class="form-control"/>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									<div class="row">
                                        <label class="col-md-3"></label>
                                        <div class="col-md-9">
                                            <div class="form-group form-button">
                                                <input type="submit" class="btn btn-fill btn-rose edit-curd" name="addcatg" value="<?php echo $this->lang->line("Update");?>" />
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
<!--   Core JS Files   -->
<script src="<?php echo base_url($this->config->item('new_theme')); ?>/ckeditor/ckeditor.js" type="text/javascript"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
     
        <script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                ckeditor.replace('editor1');
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
    $(document).on('click','#time_slot', function(e){
        var time_slot   =   $(this).val();
        if(time_slot == 1){
            $('#time_slot').val(0);
            $('#time_slot_1').val(0);
        }
        else{
            $('#time_slot').val(1);
            $('#time_slot_1').val(1);
        }
    })
</script>
</html>