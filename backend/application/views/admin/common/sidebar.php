  <?php $name = $this->uri->segment(2); ?>
    <div class="sidebar" data-color="white"  data-background-color="white" >

      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
        Tip 2: you can also add an image using data-image tag
    -->
        <div class="logo">
            <a href="<?=$this->config->item('base_url')?>index.php/admin/dashboard" class="simple-text logo-normal">
               <?php 
                    $z = _get_current_user_id($this);
    
                    $img=$this->db->query("SELECT * FROM `users` where user_id='".$z."' ") ;
                    $image= $img->result();
                    //echo $z;
                    foreach($image as $row){
                ?>
                <img src="<?php echo $this->config->item('base_url').'/uploads/company/'.$this->config->item('logo'); ?>" style="width: 200px;"/>
                <?php } ?>
            </a>
        
        </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item <?php if($name == 'dashboard') { echo "active"; } ?>  ">
            <a class="nav-link" href="<?php echo site_url("admin/dashboard"); ?>">
              <i class="material-icons">dashboard</i>
              <p><?=$this->lang->line("Dashboard");?></p>
            </a>
          </li>

          <?php $in = ''; if( ($name == 'listbrand' || $name == 'category_type' || $name == 'listcategories') ||  ($name == 'products') ||  ($name == 'product_image_upload') ||  ($name == 'category_image_upload') ||  ($name == 'stock') ||  ($name == 'catalog') ||  ($name == 'coupons') ||  ($name == 'dealofday')) {  $in = "in"; } ?>
          <li>
                <a data-toggle="collapse" href="#catalog">
                    <i class="material-icons">restaurant_menu</i>
                    <p><?php echo $this->lang->line("Catalog");?>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse  <?=$in?>" id="catalog">
                    <ul class="nav">
                    <?php $innnn = ''; if( $name == 'listbrand' || $name == 'category_type' || $name == 'listcategories' || $name == 'products' || $name == 'product_image_upload' || $name == 'category_image_upload') {  $innnn = "in"; } ?>
        
                        <li>
                            <a data-toggle="collapse" href="#pagesExampleses">
                                
                                <p><?php echo $this->lang->line("Product");?>
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse <?=$innnn?>" id="pagesExampleses">
                                <ul class="nav">
                                    <li  class="<?php if($name == 'listbrand') { echo "active"; } ?>">
                                        <a href="<?php echo site_url("admin/listbrand"); ?>">
                                            <!-- <i class="material-icons">category</i> -->
                                            <p><?php echo $this->lang->line("Brand");?></p>
                                        </a>
                                    </li>
                                    <li  class="<?php if($name == 'category_type') { echo "active"; } ?>">
                                        <a href="<?php echo site_url("admin/category_type"); ?>">
                                            <!-- <i class="material-icons">category</i> -->
                                            <p><?php echo $this->lang->line("Category Type");?></p>
                                        </a>
                                    </li>
                                    <li  class="<?php if($name == 'listcategories') { echo "active"; } ?>">
                                        <a href="<?php echo site_url("admin/listcategories"); ?>">
                                            <!-- <i class="material-icons">category</i> -->
                                            <p><?php echo $this->lang->line("Categories");?></p>
                                        </a>
                                    </li>
                                    <li  class="<?php if($name == 'category_image_upload') { echo "active"; } ?>">
                                        <a href="<?php echo site_url("admin/category_image_upload"); ?>">
                                            <!-- <i class="material-icons">category</i> -->
                                            <p><?php echo $this->lang->line("Categories Image Upload");?></p>
                                        </a>
                                    </li>
                                    <li class="<?php if($name == 'products') { echo "active"; } ?>">
                                        <a href="<?php echo site_url("admin/products"); ?>">
                                            <!-- <i class="material-icons"> restaurant_menu</i> -->
                                            <p><?php echo $this->lang->line("Products");?></p>
                                        </a>
                                    </li>
                                    <li class="<?php if($name == 'product_image_upload') { echo "active"; } ?>">
                                        <a href="<?php echo site_url("admin/product_image_upload"); ?>">
                                            <p><?php echo $this->lang->line("Products Image Upload");?></p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item <?php if($name == 'coupons') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/coupons"); ?>">
                              <!--<i class="material-icons">theaters</i>-->
                              <p><?=$this->lang->line("Coupons");?></p>
                            </a>
                        </li>

                        <li class="nav-item <?php if($name == 'dealofday') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/dealofday"); ?>">
                              <!--<i class="material-icons">date_range</i>-->
                              <p><?=$this->lang->line("Deal Products");?></p>
                            </a>
                        </li>
                        <li class="<?php if($name == 'stock') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/stock"); ?>">
                              <!--<i class="fa fa-sun-o" aria-hidden="true"></i>-->
                              <p><?=$this->lang->line("Inventory");?></p>
                            </a>
                        </li>  
                    </ul>
                </div>
            </li>
            <?php $in = ''; if( ($name == 'sales') || ($name == 'orders') ||  ($name == 'refund_management') || ($name == 'registers') || ($name == 'socity') || ($name == 'pincode') || ($name == 'transaction')) {  $in = "in"; } ?>
          <li>
                <a data-toggle="collapse" href="#sales">
                     <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    <p><?php echo $this->lang->line("Sales");?>
                        <b class="caret"></b>
                    </p>
                </a>
                 <div class="collapse  <?=$in?>" id="sales">
                    <ul class="nav">
                        <li  class="<?php if($name == 'orders') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/orders"); ?>">
                              <!--<i class="material-icons">content_paste</i>-->
                              <p><?=$this->lang->line("Orders");?></p>
                            </a>
                        </li>
                        <li class="<?php if($name == 'refund_management') { echo "active"; } ?>">
                                <a href="<?php echo site_url("admin/refund_management"); ?>">
                                    <p><?=$this->lang->line("Return Request");?></p>
                                </a>
                            </li>
                        
                        <li class="nav-item  <?php if($name == 'registers') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/registers"); ?>">
                              <!--<i class="material-icons">person</i>-->
                              <p><?=$this->lang->line("Users");?></p>
                            </a>
                         </li>
                         <li  class="<?php if($name == 'transaction') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/transaction"); ?>">
                              <!--<i class="material-icons">content_paste</i>-->
                              <p><?=$this->lang->line("Transaction");?></p>
                            </a>
                        </li>
<!--
                        <li  class="<?php if($name == 'socity') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/socity"); ?>">
                              <i class="material-icons">content_paste</i>
                              <p><?=$this->lang->line("Socity");?></p>
                            </a>
                        </li>
-->
                        <li  class="<?php if($name == 'pincode') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/pincode"); ?>">
                              <!--<i class="material-icons">content_paste</i>-->
                              <p><?=$this->lang->line("Pincode");?></p>
                            </a>
                        </li>
                        
                        
                    </ul>
                </div>
            </li>
             
			<?php $in = ''; if( ($name == 'deliverBoy') ) {  $in = "in"; } ?>
          <li>
                <a data-toggle="collapse" href="#dboy">
                     <i class="fa fa-truck" aria-hidden="true"></i>
                    <p><?php echo $this->lang->line("Delivery Boy");?>
                        <b class="caret"></b>
                    </p>
                </a>
                 <div class="collapse  <?=$in?>" id="dboy">
                    <ul class="nav">
                        <li class="nav-item <?php if($name == 'deliverBoy') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/deliverBoy"); ?>">
                              <!--<i class="fa fa-user-secret" aria-hidden="true"></i>-->
                              <p><?=$this->lang->line("Delivery Boy");?></p>
                            </a>
                        </li>
                        
                        
                    </ul>
                </div>
            </li>
            
            <?php $in = ''; if( ($name == 'wallet_management') ) {  $in = "in"; } ?>
           <li>
                <a data-toggle="collapse" href="#wallet_managementa">
                   <i class="fa fa-google-wallet" aria-hidden="true"></i>
                    <p><?=$this->lang->line("Wallet Management");?>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse  <?=$in?>" id="wallet_managementa">
                    <ul class="nav">
                            <li  class="<?php if($name == 'wallet_management') { echo "active"; } ?>">
                                <a href="<?php echo site_url("admin/wallet_management"); ?>">
                                    <p><?php echo $this->lang->line("Wallet");?></p>
                                </a>
                            </li>
                            
                    </ul>
                </div>
            </li>
            
            <?php $inn = ''; 
                  $name1 = $this->uri->segment(3);
            if( ($name == 'setting')  
                || ($name == 'theme_setting') 
                || $name == 'company_setting' 
                || $name == 'language_status' 
                || $name == 'payment' 
                || $name == 'time_slot' 
                || $name == 'closing_hours'
                || $name == 'sms_template_setting'
                || $name == 'mail_template_setting'
                || $name == 'firebase_setting'
                || $name == 'billing_setting'
                || $name == 'seo_setting'
                || $name == 'popup_setting'
                || $name == 'rewards_setting') 
            {  $inn = "in"; } ?>
        
            <li>
                <a data-toggle="collapse" href="#setteing">
                    <i class="material-icons">settings</i>
                    <p><?php echo "Setting";?>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse  <?=$inn?>" id="setteing">
                    <ul class="nav">
                    <li class="<?php if($name == 'company_setting') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/company_setting"); ?>"><?php echo $this->lang->line("Company Setting");?></a>
                    </li>
                    <li class="<?php if($name == 'setting') { echo "active"; } ?>">
                         <a href="<?php echo site_url("admin/setting"); ?>"><?php echo $this->lang->line("Order Limit Setting");?></a>
                    </li>
                    <li class="<?php if($name1 == '1') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/theme_setting/1"); ?>"><?php echo $this->lang->line("App Setting");?></a>
                    </li>
                    <li class="<?php if(($name1 == '2')) { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/theme_setting/2"); ?>"><?php echo $this->lang->line("Frontend Setting");?></a>
                    </li>
                    <li class="<?php if( ($name1 == '3')) { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/theme_setting/3"); ?>"><?php echo $this->lang->line("Backend Theme Setting");?></a>
                    </li>
                    <?php $innnn = ''; if( $name == 'time_slot' || $name == 'closing_hours') {  $innnn = "in"; } ?>
        
                    <li>
                        <a data-toggle="collapse" href="#pagesExamples">
                            
                            <p><?php echo $this->lang->line("Delivery Schedule Hours");?>
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse <?=$innnn?>" id="pagesExamples">
                            <ul class="nav">
                                <li class="<?php if($name == 'time_slot') { echo "active"; } ?>">
                                    <a href="<?php echo site_url("admin/time_slot"); ?>"> <?php echo $this->lang->line("Time Slot");?></a>
                                </li>
                                <li class="<?php if($name == 'closing_hours') { echo "active"; } ?>">
                                    <a href="<?php echo site_url("admin/closing_hours"); ?>"><?php echo $this->lang->line("Closing Hours");?></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="<?php if($name == 'language_status') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/language_status"); ?>"><?php echo $this->lang->line("language Setting");?></a>
                    </li>
                    <li class="<?php if($name == 'payment') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/payment"); ?>"><?php echo $this->lang->line("Payment Integration");?></a>
                    </li>
                    <li class="<?php if($name == 'mail_template_setting') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/mail_template_setting"); ?>"><?php echo $this->lang->line("Mail Template");?></a>
                    </li>
                    <li class="<?php if($name == 'sms_template_setting') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/sms_template_setting"); ?>"><?php echo $this->lang->line("SMS Template");?></a>
                    </li>
                    <li class="<?php if($name == 'firebase_setting') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/firebase_setting"); ?>"><?php echo $this->lang->line("Integration");?></a>
                    </li>
                    <li class="<?php if($name == 'billing_setting') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/billing_setting"); ?>"><?php echo $this->lang->line("Invoice Template");?></a>
                    </li>
                    <li class="<?php if($name == 'seo_setting') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/seo_setting"); ?>"><?php echo $this->lang->line("SEO Setting");?></a>
                    </li>
                    <li class="<?php if($name == 'popup_setting') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/popup_setting"); ?>"><?php echo $this->lang->line("Popup Setting");?></a>
                    </li>
                    <li class="<?php if($name == 'rewards_setting') { echo "active"; } ?>">
                        <a href="<?php echo site_url("admin/rewards_setting"); ?>"><?php echo $this->lang->line("Rewards Setting");?></a>
                    </li>
                    
                    
                    </ul>
                </div>
            </li>
          
          
         
          
          <?php $in = ''; if( ($name == 'listslider') ||  ($name == 'banner') ||($name == 'feature_banner') || ($name == 'feature_banner_type') || ($name == 'allpageapp') || ($name == 'listimages') || ($name == 'attributes') || ($name == 'frontside')) {  $in = "in"; } ?>
          <li>
            <a data-toggle="collapse" href="#cms">
                <i class="material-icons">perm_media</i>
                <p><?php echo $this->lang->line("CMS");?>
                    <b class="caret"></b>
                </p>
            </a>
            <div class="collapse <?=$in?>" id="cms">
                <ul class="nav">
					<?php $innnn = ''; if( $name == 'listslider' || $name == 'banner' || $name == 'feature_banner_type' || $name == 'feature_banner') {  $innnn = "in"; } ?>
                     <li>
                        <a data-toggle="collapse" href="#cmsExamples">
                            
                            <p><?php echo $this->lang->line("Slider");?>
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse <?=$innnn?>" id="cmsExamples">
                            <ul class="nav">
                                <li  class="<?php if($name == 'listslider') { echo "active"; } ?>">
                                    <a href="<?php echo site_url("admin/listslider"); ?>"><?php echo $this->lang->line("Main Slider");?></a>
                                </li>
                                <!--li class="<?php if($name == 'banner') { echo "active"; } ?>">
                                    <a href="<?php echo site_url("admin/banner"); ?>"><?php echo $this->lang->line("Secondary Slider");?></a>
                                </li-->
                                
                                <li class="<?php if($name == 'feature_banner_type') { echo "active"; } ?>">
                                    <a href="<?php echo site_url("admin/feature_banner_type"); ?>"><?=$this->lang->line("Feature Slider Type");?></a>
                                </li>
                                <li class="<?php if($name == 'feature_banner') { echo "active"; } ?>">
                                    <a href="<?php echo site_url("admin/feature_banner"); ?>"><?php echo $this->lang->line("Feature Brand Slider");?></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item <?php if($name == 'allpageapp') { echo "active"; } ?>">
                        <a class="nav-link" href="<?php echo site_url("admin/allpageapp"); ?>">
                          <!--<i class="material-icons">bubble_chart</i>-->
                          <p><?=$this->lang->line("Pages");?></p>
                        </a>
                     </li>
		     <li class="nav-item <?php if($name == 'listimages') { echo "active"; } ?>">
                        <a class="nav-link" href="<?php echo site_url("admin/listimages"); ?>">
                          <p><?=$this->lang->line("Images Collection");?></p>
                        </a>
                    </li>
                     <li class="nav-item <?php if($name == 'attributes') { echo "active"; } ?>">
                        <a class="nav-link" href="<?php echo site_url("admin/attributes"); ?>">
                          <!--<i class="material-icons">bubble_chart</i>-->
                          <p><?=$this->lang->line("Attributes");?></p>
                        </a>
                     </li>
                    
                    <li class="nav-item <?php if($name == 'frontside') { echo "active"; } ?>">
                        <a class="nav-link" href="<?php echo site_url("admin/frontside"); ?>">
                          <!--<i class="material-icons">bubble_chart</i>-->
                          <p><?=$this->lang->line("Frontside");?></p>
                        </a>
                    </li>
				</ul>
			</div>
		</li>
	  
	 
	  
		  <?php $in = ''; if( ($name == 'rewards') || ($name == 'reward_history')) {  $in = "in"; } ?>
		  <li>
            <a data-toggle="collapse" href="#rewards">
                <i class="material-icons">content_paste</i>
                <p><?php echo $this->lang->line("Rewards");?>
                    <b class="caret"></b>
                </p>
            </a>
			<div class="collapse <?=$in?>" id="rewards">
                <ul class="nav">
					<li class="nav-item <?php if($name == 'rewards') { echo "active"; } ?>">
                        <a class="nav-link" href="<?php echo site_url("admin/rewards"); ?>">
                          <!--<i class="material-icons">bubble_chart</i>-->
                          <p><?=$this->lang->line("Rewards");?></p>
                        </a>
                    </li>
                    <li class="nav-item <?php if($name == 'reward_history') { echo "active"; } ?>">
                        <a class="nav-link" href="<?php echo site_url("admin/reward_history"); ?>">
                          <!--<i class="material-icons">bubble_chart</i>-->
                          <p><?=$this->lang->line("Rewards Redeem");?></p>
                        </a>
                    </li>
                </ul>
            </div>
          </li>
         
          <li class="nav-item <?php if($name == 'enquiry') { echo "active"; } ?>">
            <a class="nav-link" href="<?php echo site_url("admin/enquiry"); ?>">
              <i class="material-icons">library_books</i>
              <p><?=$this->lang->line("Enquiry");?></p>
            </a>
          </li>
            
         <li class="nav-item <?php if($name == 'product_reviews') { echo "active"; } ?>">
            <a class="nav-link" href="<?php echo site_url("admin/product_reviews"); ?>">
              <i class="material-icons">library_books</i>
              <p><?=$this->lang->line("Product Reviews");?></p>
            </a>
          </li>
          <!-- <li class="nav-item <?php if($name == 'ads') { echo "active"; } ?>">-->
          <!--  <a class="nav-link" href="<?php echo site_url("admin/ads"); ?>">-->
          <!--    <i class="material-icons">aspect_ratio</i>-->
          <!--    <p><?=$this->lang->line("Ads");?></p>-->
          <!--  </a>-->
          <!--</li>-->
          <li class="nav-item <?php if($name == 'notification') { echo "active"; } ?>">
            <a class="nav-link" href="<?php echo site_url("admin/notification"); ?>">
                <i class="material-icons">notifications_active</i>
                <p><?php echo $this->lang->line("Notification");?></p>
            </a>
          </li>
          <li class="nav-item <?php if($name == 'change_password') { echo "active"; } ?>">
            <a class="nav-link" href="<?php echo site_url("admin/change_password"); ?>">
                <i class="material-icons">lock</i>
                <p><?php echo $this->lang->line("Change Password");?></p>
            </a>
          </li>
          <!--<li class="nav-item <?php if($name == 'tutorial') { echo "active"; } ?>">-->
          <!--  <a class="nav-link" href="<?php echo site_url("admin/tutorial"); ?>">-->
          <!--      <i class="fa fa-film"></i>-->
          <!--      <p><?php echo $this->lang->line("Tutorial");?></p>-->
          <!--  </a>-->
          <!--</li>-->
          <!--<li class="nav-item <?php if($name == 'versions') { echo "active"; } ?>">-->
          <!--  <a class="nav-link" href="<?php echo site_url("admin/versions"); ?>">-->
          <!--      <i class="fa fa-film"></i>-->
          <!--      <p><?php echo $this->lang->line("Software Version");?></p>-->
          <!--  </a>-->
          <!--</li>-->
          
          <!--<li class="nav-item <?php if($name == 'help') { echo "active"; } ?>">-->
          <!-- <a class="nav-link" href="<?php echo site_url("admin/help"); ?>">-->
          <!--      <i class="material-icons">info</i>-->
          <!--      <p><?php echo $this->lang->line("Raise a Ticket");?></p>-->
          <!--  </a>-->
          <!--</li>-->
          <!-- <li>
                <a data-toggle="collapse" href="#ClientPanel">
                     <i class="fa fa-server" aria-hidden="true"></i>
                    <p><?php echo $this->lang->line("Client Panel");?>
                        <b class="caret"></b>
                    </p>
                </a>
                 <div class="collapse  <?=$in?>" id="ClientPanel">
                    <ul class="nav">
                        <li class="nav-item <?php if($name == 'payment_detail') { echo "active"; } ?>">
                           <a class="nav-link" href="<?php echo site_url("admin/payment_detail"); ?>">
                                <p><?php echo $this->lang->line("Payment Detail");?></p>
                            </a>
                          </li>
                        
                        <li class="nav-item <?php if($name == 'tutorial') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/tutorial"); ?>">                           
                                <p><?php echo $this->lang->line("Tutorial");?></p>
                            </a>
                          </li>
                          <li class="nav-item <?php if($name == 'versions') { echo "active"; } ?>">
                            <a class="nav-link" href="<?php echo site_url("admin/versions"); ?>">
                                <p><?php echo $this->lang->line("Software Version");?></p>
                            </a>
                          </li>

                          <li class="nav-item <?php if($name == 'help') { echo "active"; } ?>">
                           <a class="nav-link" href="<?php echo site_url("admin/help"); ?>">
                                <p><?php echo $this->lang->line("Raise a Ticket");?></p>
                            </a>
                          </li>                       
                        
                    </ul>
                </div>
            </li> -->
          
          
        </ul>
      </div>
    </div>
    
    
    <style>
    .perfect-scrollbar-on .main-panel, .perfect-scrollbar-on .sidebar {
    height: 100%;
    max-height: 100%;
}

.main-panel, .sidebar, .sidebar-wrapper {
    transition-property: top,bottom,width;
    transition-duration: .2s,.2s,.35s;
    transition-timing-function: linear,linear,ease;
    -webkit-overflow-scrolling: touch;
}
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: auto;
    z-index: 2;
    width: 260px;
    background: #fff;
    box-shadow:inherit;
}
@media screen and (max-width: 600px) {
    .sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: auto;
    z-index: 2;
    width: 260px;
    background: #fff;
    box-shadow:inherit;
}
    
}
   
    </style>