<?php                                
    $q = $this->db->query("select * from `front_menu` ");
    $menus = $q->row();
//    echo "<pre>";
//    print_r($menus);

?>
<!-- Header -->
<!-- mobile menu -->
<div id="mobile-menu">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">x</a>
    <a id="profile-link" href="{base_url}my_account"> 
        <div id="customer-profile"> 
            <div id="customer-profile-left" class="avatar-icon"> 
                <div id="customer-avatar-icon" class="nav-sprite"></div> 
            </div> 
            <div id="customer-profile-right"> 
                <div id="customer-name"> Hello, Sign in </div> 
            </div> 
        </div> 
    </a>
    <div id="ham_menu_content">
        <div id="hmenu-top-section" style="padding-top: 0px;"> 
                <span>
                    <a class="redirectLogin" href="{base_url}my_account">Account</a>
                </span> 
                <span>
                    <a class="redirectLogin" href="{base_url}my_order">Orders</a>
                </span> 
        </div>
        <div id="hmenu-top-section" style="padding-top: 0px;"> 
                <span>
                    <a class="redirectLogin" href="{base_url}my_rewards">Rewards</a>
                </span> 
                <span>
                    <a class="redirectLogin" href="{base_url}my_wallet">Wallet</a>
                </span> 
        </div>
        <div id="hmenu-top-section" style="padding-top: 0px;"> 
                <span>
                    <a class="redirectLogin" href="{base_url}my_address">Address</a>
                </span>
        </div>

        <!-- Navigation -->
            <ul>
				<li><a href="{base_url}home" class="home1"><?=$this->lang->line("Home")?></a></li>
				<?php if(!empty($menus->shop)){   ?> 
                <li><a href="{base_url}shop"><?=$this->lang->line("Shop")?></a></li>
				<?php } ?>
				<?php if(!empty($menus->category)){   ?> 
                <li><a href="/" onclick="return false;"><?=$this->lang->line("Shop by category")?></a>
                    <ul class="nav">
                        <?php
                        foreach ($cat_array as $value):
                            
                            $cattypeurl = "{base_url}shop?cat_type=".$value->slug."&page=1";
                            
                            ?>
                            <li class="nosub">
                                <a href="<?= $cattypeurl ?>"><?= $value->title ?></a>
                                <?php
                                if (!empty($value->cat)):
                                    ?>
                                <ul>
                                    <?php
                                    foreach ($value->cat as $cat):
                                        $caturl = "{base_url}shop?cat_type=".$value->slug."&category=".$cat->slug."&page=1";
                                        ?>
                                        <li <?= empty($cat->sub_cat) ? 'class="nosub" ' : 'class="datalist"' ?>> 
											<a href="<?= $caturl ?>"> <?= $cat->title  ?></a> 
											<?php
											if (!empty($cat->sub_cat)):
												?>
											<ul>
												<?php
												foreach ($cat->sub_cat as $sub_cat):
													$subcaturl = "{base_url}shop?cat_type=".$sub_cat->slug."&category=".$cat->slug."&page=1";
													?>
													<li> 
														<a href="<?= $subcaturl ?>"> <?= $sub_cat->title  ?></a> 
													
													</li>
												<?php endforeach; ?>
											</ul>
												<?php
											endif;
											?>
										</li>
                                    <?php endforeach; ?>
                                </ul>
                                    <?php
                                endif;
                                ?>
                            </li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </li>
				<?php } ?>
				<?php if(!empty($menus->brand)){   ?> 
                <li><a href="/" onclick="return false;"><?=$this->lang->line("Brand")?></a>
                    <ul class="nav">
                        <?php
                            foreach ($getallbrand as $key => $values):
                                $brand_title    = $values->title;
                                $brand_slug     = $values->slug;
                                $brand_url      = "{base_url}shop/$brand_slug";
                                ?>
                                <li>
                                    <a href="<?= $brand_url ?>"><?= $brand_title ?></a>
                                </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
				<?php } ?>
                <li style="margin-top: 75%;"><a href="{base_url}terms_conditions" class="home1">Terms & Conditions</a></li>
                <li><a href="{base_url}policy" class="home1">Privacy Policy</a></li>
            </ul>
             <!-- <p class="mobile-copyright" style="text-align: center;">
                <b>Version</b> <?=$this->config->item('web_version')?><br/>
                <?=array_search("_copy_right_mobile",array_column($web_setting, 'key','value'));?>
            </p> -->
    </div>
</div>
<!-- end mobile menu -->