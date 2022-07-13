<aside class="sidebar col-xs-12 col-sm-3">

    <style>
        .sidebar ul, .sidebar ol {
            margin: 0px;
            padding: 0px;
            font-size: 16px;

        }
        .sidebar ul li{
            padding: 5px 0px 5px 10px;
            background: #eee;
            margin: 5px 0px 5px 0px;
        }
    </style>
    <!-- Blog category -->
    <div class="block blog-module">
        <div class="sidebar-bar-title">
            <h3><?=$this->lang->line("Profile Summery")?> </h3>
        </div>
        <div class="block_content">
            <!-- layered -->
            <div class="layered layered-category">
                <div class="layered-content">
                    <ul class="tree-menu">
                        <li><i class="fa fa-angle-right"></i>&nbsp; <a href="{base_url}my_account"><?=$this->lang->line("My Profile")?></a></li>
                        <li><i class="fa fa-angle-right"></i>&nbsp; <a href="{base_url}my_order"><?=$this->lang->line("My Orders")?></a></li>
                        <li><i class="fa fa-angle-right"></i>&nbsp; <a href="{base_url}my_wallet"><?=$this->lang->line("My Wallet")?></a></li>
                        <li><i class="fa fa-angle-right"></i>&nbsp; <a href="{base_url}view_cart"><?=$this->lang->line("My Cart")?></a></li>
                        <li><i class="fa fa-angle-right"></i>&nbsp; <a  href="{base_url}wishlist"><?=$this->lang->line("My Wishlist")?></a></li>
						<?php if(!empty($this->config->item('is_reward'))){ ?>
                        <li><i class="fa fa-angle-right"></i>&nbsp; <a  href="{base_url}my_rewards"><?=$this->lang->line("My Rewards")?></a></li>
						<?php } ?>
                        <li><i class="fa fa-angle-right"></i>&nbsp; <a  href="{base_url}my_address"><?=$this->lang->line("My Address")?></a></li>
<!--                                    <li><i class="fa fa-angle-right"></i>&nbsp; <a href="#"><?=$this->lang->line("Chart With Us")?></a></li>
                        <li><i class="fa fa-angle-right"></i>&nbsp; <a href="#"><?=$this->lang->line("Share With Friends")?></a></li>-->
                    </ul>
                </div>
            </div>
            <!-- ./layered -->
        </div>
    </div>

</aside>