<?php
//print_r($setting); exit;
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

$zivo_panel             =   !empty($cset['zivo_panel']) ? $cset['zivo_panel'] : '';
$tag_zivo_panel         =   'zivo_panel';

$facebook_panel         =   !empty($cset['facebook_panel']) ? $cset['facebook_panel'] : '';
$tag_facebook_panel     =   'facebook_panel';

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

$tag_logo1               =   'company_logo1';
$logo1                  =   !empty($cset['company_logo1']) ? $cset['company_logo1'] : '';

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
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
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
                                    <h4 class="card-title"><?php echo $this->lang->line("Firebase Setting");?></h4>
                                        <div class="row " style="margin-top:50px">
                                            
                                            <div class="col-md-12">
                                                <label class="label-on-left"><?php echo $this->lang->line("Firebase Key");?>:</label>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <textarea name="firebase[<?=$tag_firebase_key?>]" class="textarea" required  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $firebase_key; ?></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                            <!--<div class="col-md-12">-->
                                            <!--    <label class="label-on-left"><?php echo $this->lang->line("Google Adwords");?>:</label>-->
                                            <!--    <div class="form-group label-floating is-empty">-->
                                            <!--        <label class="control-label"></label>-->
                                            <!--        <textarea name="firebase[<?=$tag_firebase_addwords?>]" class="textarea" required  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $firebase_addwords; ?></textarea>-->
                                            <!--    <span class="material-input"></span></div>-->
                                            <!--</div>-->
                                            <div class="col-md-12">
                                                <label class="label-on-left"><?php echo $this->lang->line("Google Analytics");?>:</label>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <textarea name="firebase[<?=$tag_firebase_analytics?>]" class="textarea" required  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $firebase_analytics; ?></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="label-on-left"><?php echo $this->lang->line("Google Admob");?>:</label>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <textarea name="firebase[<?=$tag_firebase_addmob?>]" class="textarea" required  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $firebase_addmob; ?></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                            
                                            <div class="row">
                                                <?php
                                                    $panel      =   '';
                                                    $panel_tag  =   '';
                                                    if(!empty($tawk_panel)){
                                                        $panel      =   $tawk_panel;
                                                        $panel_tag  =   $tag_tawk_panel;
                                                    }
                                                    elseif(!empty($zivo_panel)){
                                                        $panel      =   $zivo_panel;
                                                        $panel_tag  =   $tag_zivo_panel;
                                                    }
                                                    elseif(!empty($facebook_panel)){
                                                        $panel      =   $facebook_panel;
                                                        $panel_tag  =   $tag_facebook_panel;
                                                    }
                                                ?>
                                                <div class="col-md-6">
                                                    <label class=" label-on-left"><?php echo $this->lang->line("Select Chat Panel");?></label>
                                                    <div class="form-group label-floating is-empty">
                                                        <select class="text-input form-control" name="chat_panels" id="chat_panels">
                                                            <option value=""><?php echo $this->lang->line("Select Chat Panel");?></option>
                                                            <option data-id="<?=$tawk_panel; ?>" value="tawk_panel" <?=!empty($tawk_panel)? 'selected': ''?>><?=$this->lang->line("Tawk Panel");?></option>
                                                            <option data-id="<?=$zivo_panel; ?>" value="zivo_panel" <?=!empty($zivo_panel)? 'selected': ''?>><?=$this->lang->line("Zivo Panel");?></option>
                                                            <option data-id="<?=$facebook_panel; ?>" value="facebook_panel" <?=!empty($facebook_panel)? 'selected': ''?>><?=$this->lang->line("Facebook Panel");?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                <div class="col-md-6">
                                                    <label class="label-on-left"><?php echo $this->lang->line("Chat Script");?>:</label>
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <textarea name="firebase[<?=$panel_tag?>]" id="tag_chat_panels" class="textarea" required  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $panel; ?></textarea>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="label-on-left"><?php echo $this->lang->line("Facebook Pixel ID");?>:</label>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="firebase[<?=$tag_facebook_pixel?>]" value="<?php echo $facebook_pixel; ?>" class="form-control" required  style="background: transparent; width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="label-on-left"><?php echo $this->lang->line("Facebook Event ID");?>:</label>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="firebase[<?=$tag_facebook_event?>]" value="<?php echo $facebook_event; ?>" class="form-control" required  style="background: transparent;  width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                <span class="material-input"></span></div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="label-on-left"><?php echo $this->lang->line("Tag Manager");?>:</label>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="firebase[<?=$tag_tag_manager?>]" value="<?php echo $tag_manager; ?>" class="form-control" required  style="background: transparent; width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                <span class="material-input"></span>
                                                </div>
                                            </div>

                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="<?php echo $this->lang->line("Update");?>" />
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
</script>
<script>
    $(document).on('change','#chat_panels',function(e){
        var select_panel    =   $(this).val();
        var select_value    =   $(this).find(':selected').data('id');
        console.log(select_value);
        $('#tag_chat_panels').attr('name','firebase['+select_panel+']');
        $('#tag_chat_panels').html(select_value);
    });
</script>
</html>