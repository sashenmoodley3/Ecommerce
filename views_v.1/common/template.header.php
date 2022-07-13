<header>
    <div class="header-container">
        <!--div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-md-5 hidden-xs"> 
                        <!-- Default Welcome Message -->
                        <!--<div class="welcome-msg ">Welcome to Genius! </div>-->
                        <!--span class="phone hidden-sm">Call Us: <?=array_search("_contect",array_column($web_setting, 'key','value'));?></span> </div>

                    <!-- top links -->
                    <!--div class="headerlinkmenu col-lg-8 col-md-7 col-sm-8 col-xs-12">
                        <div class="links">
                            <?= !empty($menu['account']) ? $menu['account']['html'] : ''; ?>
                            <?php //echo !empty($menu['wishlist']) ? $menu['wishlist']['html'] : ''; ?>
                            <?= !empty($menu['login']) ? $menu['login']['html'] : $menu['logout']['html']; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div-->
        <div class="row">
            <div class="container">
                <div class="col-sm-3 col-md-3 col-xs-4 visible-lg visible-md">
                    <!-- Header Logo -->
                    <div class="logo"><a title="Kart" href="{base_url}home">
                            <img alt="Kart"
                                 src="<?=array_search("_logo_header",array_column($web_setting, 'key','value'));?>" style="max-height: 100px;"></a> </div>
                    <!-- End Header Logo -->
                </div>
                <div style="padding:12px;" class="col-xs-8 col-sm-9 col-md-9 col-lg-9  visible-lg visible-md">
                    <div class="col-lg-3 col-xs-12  headerlinkmenu">
                        <!-- PWA INSTALL BUTTON  START-->
                        <!--<div class="addtohome">-->
                        <!--    <a class="_3NH1qf" title="Add to Home Screen">-->
                        <!--        <pwa-install showopen="">-->
                        <!--            <img alt="Add to Home Screen" class="_2PBiNc" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIiIGhlaWdodD0iMTUiIHZpZXdCb3g9IjAgMCAxMiAxNSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Im0yNTQuMTIgNTMuNjE3Yy4wMjkgMS4wMS4xMDEgMi4zODIuMTUgMi42OC4wMjUuMTUyLjE1Ni4yNjMuMzEuMjYzbC42NzIuMDIxYy4xNTQgMCAuMTc1LS4xMTEuMTk5LS4yNjQuMDQ5LS4zMDQuMTIyLTEuNjkyLjE1MS0yLjY5NyAxLS4wMjkgMi4zOTItLjEwMiAyLjY5Ny0uMTUxLjE1My0uMDI0LjI2NC0uMDQ1LjI2NC0uMTk5bC0uMDIxLS42NzJjMC0uMTU0LS4xMTEtLjI4NS0uMjYzLS4zMS0uMjk4LS4wNDktMS42NjktLjEyMS0yLjY4LS4xNS0uMDMxLS45ODYtLjEwMi0yLjMxMi0uMTQ5LTIuNjE1LS4wMjQtLjE1My0uMDQ0LS4yNjYtLjItLjI2NmwtLjY2OS0uMDIxYy0uMTU1IDAtLjI4Ni4xMTItLjMxLjI2NC0uMDQ4LjI5OS0uMTE5IDEuNjQxLS4xNDkgMi42NC0uOTk4LjAzLTIuMzQuMTAyLTIuNjQuMTQ5LS4xNTMuMDI0LS4yNjQuMTU2LS4yNjQuMzFsLjAyMS42NjljMCAuMTU1LjExMy4xNzYuMjY2LjIuMzAzLjA0NyAxLjYyOS4xMTggMi42MTUuMTQ5bTUuNzY1IDYuMzgzaC05LjYyMWMtLjQxMyAwLS43NjUtLjI2Ny0uODMxLS42MzMtLjE2Ni0uOTEzLS40MzUtNC43MDEtLjQzNS02Ljg2NyAwLTIuMTA0LjI3My01LjkzMi40MzgtNi44NjQuMDY1LS4zNjcuNDE4LS42MzYuODMyLS42MzZoOS42MTNjLjQxNiAwIC40NzEuMjcxLjUzNS42NC4xNjUuOTU2LjQ0MiA0LjgzNS40NDIgNi44NiAwIDIuMTEzLS4yNzIgNS45MzUtLjQzOCA2Ljg2NS0uMDY1LjM2Ny0uMTIuNjM1LS41MzQuNjM1IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMjQ5LTQ1KSIgZmlsbD0iI2ZmZiIvPjwvZz48L3N2Zz4=">-->
                        <!--        </pwa-install>-->
                        <!--    </a>-->
                        <!--</div>-->
                        <!-- PWA INSTALL BUTTON  FINESH-->
                        <div class="account-text">
                            <?= !empty($menu['account']) ? $menu['account']['html'] : ''; ?>
                            <?php //echo !empty($menu['wishlist']) ? $menu['wishlist']['html'] : ''; ?>
                            <?= !empty($menu['login']) ? $menu['login']['html'] : $menu['logout']['html']; ?>
                        </div>
                    </div>
                    <!-- TODO ADD Language
                    <div class="col-lg-3 col-xs-12 visible-lg visible-md headerlinkmenu" style="position: relative; top: 9px;">
                        <select class="form-control" name="lang" id="lang">
                            <?php 
                                $sql  =   $this->db->query("SELECT * FROM language_setting")->result_array();
                                foreach($sql as $rows){
                                    $selected   =   $rows['language_name'] == $this->session->userdata('lang') ? 'selected' : '';
                                    echo '<option value="'.$rows['language_name'].'"'.$selected.'>'.ucfirst ($rows['language_name']).'</option>';
                                }
                            ?>
                        </select>
                    </div> -->
                </div>
                <div class="col-xs-9 col-sm-7 col-md-7 col-lg-7 top-search visible-lg visible-md">
                    <!-- Search -->

                    <div class="top-search">
                        <div id="search">
                            <form action="{base_url}search">
                                <div class="input-group" style="overflow: inherit;">
                                    <?php /* <select id="select_dropdown_category" class="cate-dropdown hidden-xs" name="slug">
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
                                            if (is_array($sub_cat)) {
                                                foreach ($sub_cat as $k => $val):
                                                    $category_title = "&nbsp;&nbsp;&nbsp;" . $val->title;
                                                    $category_slug = $val->slug;
                                                    $category_image = $category_img_url. $val->image;
                                                    if (isset($val->sub_cat)) {
                                                        $sub_cat = $val->sub_cat;
                                                    } else {
                                                        $sub_cat = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $category_slug ?>"><?= $category_title ?></option>
                                                    <?php
                                                endforeach;
                                            }
                                            ?>
                                            <option value="<?= $category_slug ?>"><?= $category_title ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                        
                                    </select> */ ?>
<!--                                    <input type="text" 
                                           class="col-md-12 form-control" 
                                           placeholder="Search cities..." 
                                           autocomplete="off" />-->
                                    <input id="txtCountry" autocomplete="off" type="text" class="form-control" placeholder="<?=$this->lang->line("Aapko Kya Chahiye?")?> " name="search">
                                    <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                    <div class="header-dropdown header-dropdown--search" id="header-dropdown" style="display: none;">
                                        <ul class="search-dropdown cart-details__scroll ps-container ps-theme-default ps-active-y">
                                        </ul>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- End Search -->
                </div>
                <!-- top cart -->
                <div class="col-lg-2 col-xs-3 top-cart visible-lg visible-md">
                    <div class="top-cart-contain">
                        <div class="mini-cart">
                            <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle"> 
                                <a href="{base_url}view_cart">
                                    <div class="cart-icon"><i class="fa fa-shopping-basket"></i></div>
                                    <div class="shoppingcart-inner hidden-xs"><span class="cart-title"><?=$this->lang->line("Cart")?></span> <span class="cart-total">{total_cart_item} <?=$this->lang->line("Item")?></span></div>
                                </a></div>
                            <div>
                                <div class="top-cart-content">
                                    <div class="block-subtitle hidden-xs"><?=$this->lang->line("Recently added item")?></div>
                                    <ul id="cart-sidebar" class="mini-products-list">
                                        <?php
                                        //print_r($get_cart_product_arr); 
                                        $total_order_price = 0;
                                        foreach ($get_cart_product_arr as $key => $product):
                                            $qty                    = $product['buy_qty'];
                                            $product_id             = $product['product_id'];
                                            $product_varient_id     = $product['varient_id'];
                                            $product_name           = $product['product_name'];
                                            $product_description    = $product['product_description'];
                                            $pro1                   = explode(',',$product['product_image']);
                                            $product_image          = $product_img_url . $pro1[0];
                                            $category_id            = $product['category_id'];
                                            $in_stock               = $product['in_stock'];
                                            $product_price          = $product['price'];
                                            $mrp                    = $product['mrp'];
                                            $unit_value             = $product['qty'];
                                            $unit                   = $product['unit'];
                                            $increament             = $product['increament'];
                                            $rewards                = $product['rewards'];
                                            $tax                    = $product['tax'];
                                            $product_slug           = $product['product_slug'];
                                            
                                            $q_variants             = $this->db->query("Select * from product_varient where product_id = '".$product_id."' AND varient_id='".$product_varient_id."'")->row();
                                            if(!empty($q_variants->pro_var_images)){
                                                $product_image  = base_url().'backend/uploads/products/'.$q_variants->pro_var_images;
                                            }
                                            
                                            
                                           //$total_product_price = $product_price * $qty;
                                            //$total_order_price += $total_product_price;
											
											//$q                      = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."'  AND pro_var_id = '".$product_varient_id."'");
                                           
                                           $q = $this->db->query("SELECT deal_price FROM deal_product WHERE product_id = '".$product_id."' AND pro_var_id = '".$product_varient_id."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                                        AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
											$del_price              = $q->row();
											
											if(!empty($del_price)){
												$product_price      = $del_price->deal_price;
												$total_product_price = $product_price * $qty;
												$total_order_price  += $total_product_price;
																		
											} else {
												$product_price      = $product['price'];
												$total_product_price = $product_price * $qty;
												$total_order_price  += $total_product_price;
											}
											$producturl     =   $this->config->item('base_url')."product/". $product_slug
                                            ?>
                                            
                                            <li class="item odd" id="list_<?=$product_varient_id?>"> 
                                                <a href="<?=$producturl?>" title="<?= $product_name ?>" 
                                                   class="product-image">
                                                    <img class = "lazy" 
                                                         src="<?= $product_image ?>" 
                                                         alt="<?= $product_name ?>" width="65"></a>
                                                <div class="product-details"> 
                                                    <a style="" data-id="<?=$product_id?>" data-varient="<?=$product_varient_id?>" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a>
                                                    <p class="product-name">
                                                        <a href="<?=$producturl?>"><?= $product_name ?></a> 
                                                    </p>
                                                    <span style="display: block;"><?=$unit_value.' '.$unit?></span>
                                                    <strong><?= $qty ?></strong> x <span class="price"><?=$this->config->item('currency');?> <?= $product_price ?></span> </div>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                    <div class="top-subtotal"><?=$this->lang->line("Subtotal")?> : <span class="price"><?=$this->config->item('currency');?> <span id="total_order_price"><?= $total_order_price ?></span></span></div>
                                    <div class="actions">
                                        <a href="{base_url}checkout" class="btn-checkout">
                                            <i class="fa fa-check"></i><span><?=$this->lang->line("Checkout")?></span>
                                        </a>
                                        <a href="{base_url}view_cart" class="view-cart">
                                            <i class="fa fa-shopping-basket"></i> <span><?=$this->lang->line("View Cart")?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- end header -->
<?php 

// echo '<pre>';
// print_r($getbrand1);
// echo '</pre>';
// getbrand1
// getallbrand
$lirow = 12;
$brandarr = $getallbrand;
$item_width = '230';
$inner_width = '0';
$column_row = '0';
if(!empty($brandarr)){
	$tot_row = count($brandarr);
	if(!empty($tot_row)){
		$tot_column = ceil($tot_row/$lirow);
		$inner_width = $tot_column*$item_width;
		$column_row = ceil($tot_row/$tot_column);
	}
}


$ii=0;
$cat_type = [];
if(!empty($cat_array)){  
	foreach($cat_array as $cat_arr){
		if(!empty($cat_arr->cat)){   
			$cat_type[$ii]['title'] = $cat_arr->title;
			$cat_type[$ii]['slug'] = $cat_arr->slug;
			$cat_type[$ii]['product_cat_type_id'] = $cat_arr->product_cat_type_id;
			$cat_type[$ii]['type'] = 'cat_type';
			$ii++;
			foreach($cat_arr->cat as $cat2){
				// $cat_type[$ii] = $cat2;
				$cat_type[$ii]['id'] = $cat2->id;
				$cat_type[$ii]['title'] = $cat2->title;
				$cat_type[$ii]['slug'] = $cat2->slug;
				$cat_type[$ii]['product_cat_type_id'] = $cat2->product_cat_type_id;
				$cat_type[$ii]['cat_type_slug'] = $cat_arr->slug;
				$cat_type[$ii]['type'] = 'cat';
				
				$ii++;
				// if(!empty($cat2->sub_cat)){   
					// foreach($cat2->sub_cat as $sub_cat){
						// $cat_type[$ii]['id'] = $sub_cat->id;
						// $cat_type[$ii]['title'] = $sub_cat->title;
						// $cat_type[$ii]['slug'] = $sub_cat->slug;
						// $cat_type[$ii]['product_cat_type_id'] = $sub_cat->product_cat_type_id;
						// $cat_type[$ii]['cat_type_slug'] = $sub_cat->slug;
						// $cat_type[$ii]['type'] = 'sub_cat';	
						// $ii++;
				   // }
				
				// }
		   }
		
		}
	}
}

$cat_type_arr = $cat_type;
$cat_type_item_width = '230';
$cat_type_inner_width = '0';
$cat_type_column_row = '0';
if(!empty($cat_type_arr)){
	$cat_type_tot_row = count($cat_type_arr);
	if(!empty($cat_type_tot_row)){
		$cat_type_tot_column = ceil($cat_type_tot_row/$lirow);
		$cat_type_inner_width = $cat_type_tot_column*$cat_type_item_width;
		$cat_type_column_row = ceil($cat_type_tot_row/$cat_type_tot_column);
	}
}

// echo '<pre>';
// print_r($cat_type);
// echo '</pre>';
// die;

?>

<style>

li.mega-drop-down .menu-items {
	min-width: <?php echo $item_width ?>px;
}
li.mega-drop-down .menu-items .menu-inner {
    width: <?php echo $inner_width ?>px;
}
li.mega-drop-down .menu-items .menu-item {
    width: <?php echo $item_width ?>px;
}

li.mega-drop-down.categories  .menu-items {
	min-width: <?php echo $cat_type_item_width ?>px;
}
li.mega-drop-down.categories  .menu-items .menu-inner {
    width: <?php echo $cat_type_inner_width ?>px;
}
li.mega-drop-down.categories  .menu-items .menu-item {
    width: <?php echo $cat_type_item_width ?>px;
}


</style>
<!-- Navbar -->
<nav>
<?php                                
    $q = $this->db->query("select * from `front_menu` ");
    $menus = $q->row();
//    echo "<pre>";
//    print_r($menus);

?>
    <div class="container">
        <div class="row">
            
			<div class="col-md-12 col-xs-12">
                <?php
				
				// $cat_array = [];
				// $q = $this->db->query("SELECT * FROM `product_cat_type` WHERE status = 1 ");
				// $return_array = array();
				// $cat_type = $q->result();
				// if(!empty($cat_type)){  
					   // foreach($cat_type as $key => $cat_tp){
						   // $q1 = $this->db->query("SELECT * FROM `categories` WHERE status = 1 AND product_cat_type_id = '".$cat_tp->product_cat_type_id."'");
							// $return_array = array();
							// $cats = $q1->result();
							// if(!empty($cats))
							// {   
								// $cat_array[$key] = $cat_tp;
								// $cat_array[$key]->cat = $cats;
							
							// }
					   // }
				// }
				
				// echo '<pre>';
				// print_r($cat_array);
				// die;
				
				
                   
                ?> 
                
                <div class="mm-toggle-wrap panel-header">
                    <span class="menu_icon" onclick="homeBack();" style="display:none;"></span>
                    <div class="mm-toggle"> <i class="fa fa-align-justify" style="color: #a9a6a6;"></i> </div>
                    <span class="mm-label">
                        <a title="Kart" href="{base_url}home">
                            <img alt="Kart" src="<?=array_search("_logo_header",array_column($web_setting, 'key','value'));?>" style="width: 108px;">
                        </a> 
                    </span> 
                    <div class="login_section"> 
                        <a href="{base_url}my_account" id="top_signin">
                            <i class="fa fa-user"></i>
                        </a> 
                        <a href="{base_url}logout" class="shopping">
                             <i class="fa fa-lock"></i>
                        </a> 
                        <!-- <span class="minicart-number cart-total">{total_cart_item}</span> -->
                    </div>
                </div>
                <div class="top-forms top-search open col-md-3 col-xs-12 ">
                    <div class="topsearch-entry">
                        <form method="get" id="searchform_special" action="<?=base_url()?>shop/">
                            <div>
                                <input type="text" value="" name="search" id="s" placeholder="Search here...">
                                <button type="submit" title="Search" class="fa fa-search button-search-pro form-button"></button>
                                <input type="hidden" name="search_posttype" value="product">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mega-container visible-lg visible-md visible-sm">
					
					<ul class="exo-menu">
						<?php if(!empty($menus->category)) { ?> 
						<li class="mega-drop-down categories">
							<a href="#">
								<div class="title title_font mt-root-item">
									<span class="title-text"> <i class="fa fa-bars" aria-hidden="true"></i>
 <?=$this->lang->line("Shop by category")?></span>
								</div>
							</a>
							<div class="fadeIn mega-menu menu-items">
								<div class="mega-menu-wrap">
									<div class="menu-inner">
										<ul class="menu-item">
										 <?php
											if(!empty($cat_type)){
												foreach ($cat_type as $k => $val){
													$clss = '';
													if(!empty($val['type']) && $val['type'] == 'cat_type'){
														$clss = 'cat_type';
														$caturl = "{base_url}shop?cat_type=".$val['slug']."&page=1";
													}
													elseif(!empty($val['type']) && $val['type'] == 'cat'){
														$clss = 'cat';
														$caturl = "{base_url}shop?cat_type=".$val['cat_type_slug']."&category=".$val['slug']."&page=1";
													}
													else{
														$clss = 'sub_cat';
														$caturl = "{base_url}shop?cat_type=".$val['cat_type_slug']."&category=".$val['slug']."&page=1";
													}
													
													
													?>
													<li class="<?php echo $clss ?>"> <a href="<?= $caturl ?>"> <?= ucfirst($val['title']) ?></a> </li>
													<?php 
													
													if(($k+1)%$cat_type_column_row==0){
														echo '</ul><ul class="menu-item">';
													}
												}
											}
											
											
											
											?>
										</ul>
									</div>
								</div>	
							</div>
						
						
						</li>
						<?php } ?>
						<?php /* if(!empty($menus->home)) { ?> 
						<li class="mega-drop-down">
                            <a href="{base_url}home">
								<div class="title title_font mt-root-item">
									<span class="title-text"><?=$this->lang->line("Home")?></span>
								</div>
							</a>
                        </li>
						<?php } */ ?>
						<?php /* if(!empty($menus->shop)) { ?> 
                        <li class="mega-drop-down">
							<a href="{base_url}shop?page=1">
								<div class="title title_font mt-root-item">
									<span class="title-text"><?=$this->lang->line("Shop")?></span>
								</div>
							</a>
                        </li>
						<?php } */ ?>
						<?php if(!empty($menus->brand)) { ?> 
						<li class="mega-drop-down ">
							<a href="#">
								<div class="title title_font mt-root-item">
									<span class="title-text"><?=$this->lang->line("Brand")?></span>
								</div>
							</a>
							<div class="fadeIn mega-menu menu-items">
								<div class="mega-menu-wrap">
									<div class="menu-inner">
										<ul class="menu-item">
										 <?php
											if(!empty($brandarr)){
												foreach ($brandarr as $k => $val){
													$category_title = $val->title;
													$category_slug = $val->slug;
													$category_url = "{base_url}shop?brand=".$category_slug."&page=1";
													?>
													<li> <a href="<?= $category_url ?>"> <?= $category_title ?></a> </li>
											<?php 
													if(($k+1)%$column_row==0){
														echo '</ul><ul class="menu-item">';
													}
												}
											}
											
											
											
											?>
										</ul>
									</div>
								</div>	
							</div>
						</li>
						<?php } ?>
						<?php /* if(!empty($menus->contact_us)) { ?> 
						<li class="mt-root">
							<a href="{base_url}contact_us">
								<div class="title title_font mt-root-item">
									<span class="title-text"><?=$this->lang->line("Contact Us")?></span> 
								</div>
							</a>
                        </li>
						<?php } ?>
						<?php if(!empty($menus->about_us)) { ?> 
                        <li class="mt-root">
							<a href="{base_url}about_us">
								<div class="title title_font mt-root-item">
									<span class="title-text"><?=$this->lang->line("about us")?></span>
								</div>
							</a>
                        </li>
						<?php } */ ?>
						
						<?php 
						if(!empty($menu_cat_array)) {
							foreach($menu_cat_array as $cat_val){
							?> 
                        <li class="mt-root">
							<a href="{base_url}shop?cat_type=<?php echo $cat_val->slug ?>&page=1">
								<div class="title title_font mt-root-item">
									<span class="title-text"><?=$cat_val->title?></span>
								</div>
							</a>
                        </li>
						<?php 
							}
						}
						?>
						
						
						
					</ul>
			
					
					
                </div>
            
           
                
			
			</div>
        </div>
    </div>
</nav>
<!-- end nav -->