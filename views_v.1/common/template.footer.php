<style>
    
</style>
<footer>
<div class="footer-newsletter"></div>
    <div class="row">
      <div class="container">
        <div class="col-sm-6 col-md-4 col-xs-12 col-lg-3">
          <div class="footer-logo"><a href="{base_url}/home"><img src="<?=array_search("_logo_footer",array_column($web_setting, 'key','value'));?>" alt="fotter logo"></a> </div>
          <p><?=$this->config->item('about')?></p>
        </div>
        <div class="col-sm-6 col-md-4 col-xs-12 col-lg-3 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title"><?=$this->lang->line("Quick Links")?> <a class="expander visible-xs" href="#TabBlock-1">+</a></h3>
            <div class="tabBlock" id="TabBlock-1">
              <ul class="list-links list-unstyled ">
                <li><a href="{base_url}terms_conditions"><?=$this->lang->line("Terms & Conditions")?> </a></li>
                <!-- <li><a href="{base_url}refundpolicy"><?=$this->lang->line("Refund Policy")?></a></li>-->
                <li><a href="{base_url}faq">Terms of Purchase</a></li> 
                <li><a href="{base_url}policy"><?=$this->lang->line("Privacy Policy")?></a></li>
                <li><a href="https://www.mnandiretail.com/"><?=$this->lang->line("about us")?></a></li>
                <li><a href="{base_url}contact_us"><?=$this->lang->line("Contact Us")?></a></li>

              </ul>
            </div>
			
          </div>
        </div>
        <div class="col-sm-6 col-md-2 col-xs-12 col-lg-3 collapsed-block social">
            <h3 class="links-title">Address  <a class="expander visible-xs" href="#TabBlock-1">+</a></h3>
          <div class="footer-content">
            <div class="email"> <i class="fa fa-envelope"></i>
              <p><?=array_search("_email",array_column($web_setting, 'key','value'));?></p>
            </div>
            <div class="phone"> <i class="fa fa-phone"></i>
              <p><?=array_search("_contect",array_column($web_setting, 'key','value'));?></p>
            </div>
            <div class="address"> <i class="fa fa-map-marker"></i>
              <p> <?=array_search("_address",array_column($web_setting, 'key','value'));?></p>
            </div>
          </div>
		  <ul class="inline-mode left">
             <?php if(!empty($this->config->item('fb')) && $this->config->item('fb') !='#'){ ?>
				<li class="social-network fb"><a title="Connect us on Facebook" rel="nofollow" target="_blank" href="<?=array_search("_fb_link",array_column($web_setting, 'key','value'));?>"><i class="fa fa-facebook"></i></a></li>
				<?php }   
				if(!empty($this->config->item('twitter')) && $this->config->item('twitter') !='#'){ ?>
				<li class="social-network tw"><a title="Connect us on Twitter" rel="nofollow" target="_blank" href="<?=array_search("_tw_plus_link",array_column($web_setting, 'key','value'));?>"><i class="fa fa-twitter"></i></a></li>
				<?php }   
				if(!empty($this->config->item('linkedn')) && $this->config->item('linkedn') !='#'){ ?>
				<li class="social-network linkedin"><a title="Connect us on Linkedin" rel="nofollow" target="_blank" href="<?=array_search("_linkedin_link",array_column($web_setting, 'key','value'));?>"><i class="fa fa-linkedin"></i></a></li>
				<?php }   
				if(!empty($this->config->item('insta')) && $this->config->item('insta') !='#'){ ?>
				<li class="social-network instagram"><a title="Connect us on Instagram" rel="nofollow" target="_blank" href="<?=array_search("_instagram_link",array_column($web_setting, 'key','value'));?>"><i class="fa fa-instagram"></i></a></li>
				<?php } ?>
			  </ul>
        </div>
        <div class="col-sm-6 col-md-2 col-xs-12 col-lg-3 collapsed-block ">
         
           <!-- <h3 class="links-title">Our Apps	</h3>
         
          
            <div class="android_app">
                <a target="_blank" rel="nofollow"  href="<?=$this->config->item('app_url')?>">
                <img src="<?=base_url()?>assets/images/user.png" alt="android app link" style="width: 190px;">
                </a>
            </div> -->
            
			<?php if($this->config->item('deliver_boy_app_url')){ ?>
			<div class="android_app">
                <a target="_blank" href="<?=$this->config->item('deliver_boy_app_url');?>">
                    <img src="<?=base_url()?>assets/images/Delivery-Boy.png" alt="Deliver Boy App link" style="width: 190px;">
                </a>
            </div>
			<?php } ?>
			<!-- <div class="android_app">
                <a target="_blank" href="<?=array_search("_pwa_link",array_column($web_setting, 'key','value'));?>">
                    <img src="<?=base_url()?>assets/images/pwaapplication.png" alt="PWA App link" style="width: 190px;">
                </a>
            </div> -->
			<!--<div class="android_app pwa">
                <a target="_blank" href="<?=array_search("_pwa_link",array_column($web_setting, 'key','value'));?>">
                    <img src="<?=base_url()?>backend/uploads/company/<?=$this->config->item('lite_app_icon')?>" alt="PWA App link">
                    <small><b>Lite</b></small>
                </a>
            </div>-->
        </div>
      </div>
    </div>
    <div  class="footer-coppyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-xs-12 coppyright">
			<b>© COPYRIGHT Mnandi Retail Solutions 2021 | Version</b> <?=$this->config->item('web_version')?>
			<br>
			<?=array_search("_copy_right",array_column($web_setting, 'key','value'));?>
		  </div>
        </div>
      </div>
    </div>
  </footer>

<div class="mobile-bottom"></div>
<div class="footer-mstyle1 theme-clearfix visible-sm visible-xs" id="footer">
         <div class="footer-container">
             <div class="footer-menu clearfix">
    			<div class="menu-item">
    				<div class="footer-home">
    					<a href="<?=base_url()?>" title="Home">
    						<span class="icon-menu"></span>
    						<span class="menu-text">Home</span>
    					</a>
    				</div>
    			</div>
			<div class="menu-item">
				<div class="footer-search">
					<a href="javascript:void(0)" title="Search" class="search-form">
						<span class="icon-menu"></span>
						<span class="menu-text">Search</span>
					</a>
						<div class="top-form top-search">
		                    <div class="topsearch-entry">
					            <form method="get" id="searchform_special" action="<?=base_url()?>shop/">
        				            <div>
            							<div class="cat-wrapper">
            						        <label class="label-search">
            							        <select name="category" class="s1_option">
            								        <option value="">All Categories</option>
            								         <?php
                                                        foreach ($getCategoriesShort as $key => $value):
                                                            //$category_id = $value['id'];
                                                            $category_title = $value->title;
                                                            $category_slug = $value->slug;
                                                            $category_url = "{base_url}shop/$category_slug";
                                                            //$category_image = "../backend/uploads/category/" . $value->image;
                                                            if (isset($value->sub_cat)) {
                                                                $sub_cat = $value->sub_cat;
                                                            } else {
                                                                $sub_cat = '';
                                                            }
                                                            ?>
            								                <option value="<?=$category_slug?>"><?= $category_title ?></option>
            								            <?php endforeach; ?>
            								        						
            								    </select>
            						        </label>
            					        </div>
            						    <input type="text" value="" name="s" id="s" placeholder="Search here...">
            					        <button type="submit" title="Search" class="fa fa-search button-search-pro form-button"></button>
            					        <input type="hidden" name="search_posttype" value="product">
        			            </div>
			                </form>
					    </div>
	                </div>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-cart">
					<a href="<?=base_url()?>view_cart">
						<div class="emarket-minicart-mobile">
		                    <span class="icon-menu"></span>
		                    <span class="minicart-number cart-total">{total_cart_item}</span>		
		                    <span class="menu-text">Cart</span>
                        </div>					
                    </a>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-myaccount">
					<a href="<?=base_url()?>my_account" title="My Account">
						<span class="icon-menu"></span>
						<span class="menu-text">Account</span>
					</a>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-shop">
					<a href="<?=base_url()?>shop" title="More">
						<span class="icon-menu"></span>
						<span class="menu-text">shop</span>
					</a>
				</div>
			</div>
			<div class="menu-item-hidden"></div>
		</div>
<!--<div class="footer-fix-nav shadow">
         <div class="row mx-0">
            <div class="col-xs-2 col">-->
            <!--   <a href="<?=base_url()?>"><img src="<?=base_url()?>assets/images/home.png" style="width: 25px;"></a>-->
            <!--</div>-->
            <!--<div class="col-xs-2 col border-0">-->
            <!--   <a href="<?=base_url()?>shop"><img src="<?=base_url()?>assets/images/shop.png"  style="width: 25px;"></a>-->
            <!--</div>-->
            <!--<div class="col-xs-2 col active">-->
            <!--   <a class="toggle hc-nav-trigger hc-nav-1" href="#" role="button" aria-controls="hc-nav-1"><img src="<?=base_url()?>assets/images/category.png"  style="width: 25px;"></a>-->
            <!--</div>-->
            <!--<div class="col-xs-2 col">-->
            <!--   <a href="<?=base_url()?>view_cart"><img src="<?=base_url()?>assets/images/cart.png"  style="width: 25px;"></a>-->
            <!--</div>-->
            <!--<div class="col-xs-2 col">-->
            <!--   <a href="<?=base_url()?>my_account"><img src="<?=base_url()?>assets/images/profile.png"  style="width: 25px;"></a>-->
            <!--</div>
         </div>
      </div>-->


<div class="orientation-div"> <div class="orientation"> <div class="content"> <img src="<?=base_url()?>assets/images/landscape-m.png" alt="<?=$title?>"> <br> Please rotate your device </div> <div class="alert-text"> We don't support landscape mode yet. Please go back to portrait mode for the best experience </div> </div> </div>