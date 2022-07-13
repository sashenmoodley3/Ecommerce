<style>
    .brand{
        height: 150px;
        overflow-y: auto;
    }
    .buttonload {
      background-color: #4CAF50; /* Green background */
      border: none; /* Remove borders */
      color: white; /* White text */
      padding: 12px 24px; /* Some padding */
      font-size: 16px; /* Set a font-size */
    }

    /* Add a right margin to each icon */
    #btn-loader .fa {
      margin-left: -12px;
      margin-right: 8px;
    }
</style>
<?php
$webItem = trim($this->config->item('shop_one_row_item_show'));
$classses = ''; 
if($webItem == "2"){
    $classses = "item col-lg-6 col-md-6 col-sm-6 col-xs-6";
}
elseif($webItem == "3"){
    $classses = "item col-lg-4 col-md-4 col-sm-6 col-xs-6";
}
elseif($webItem == "4"){
    $classses = "item col-lg-3 col-md-3 col-sm-6 col-xs-6";
}
elseif($webItem == "5"){
    $classses = "item col-lg-2 col-md-3 col-sm-6 col-xs-6 col5";
}
else{
    $classses = "item col-lg-4 col-md-4 col-sm-6 col-xs-6 col5";
}

if ($this->session->userdata("product")) {
    $product_arr = json_decode($this->session->userdata("product"), TRUE);
}

if($this->config->item('currency'))
{
    $currency = $this->config->item('currency');
}

                              
$q = $this->db->query("select * from `front_filter`");
$filters = $q->row();
//    echo "<pre>";
//    print_r($filters);



?>
<!-- Main Container -->
<div class="main-container col2-left-layout">
    <div class="container">
        <div class="row">
            <aside class="sidebar col-sm-3 col-xs-12 filter" style="margin-top: 20px;">
				<?php
					// echo '<pre>';
					// print_r($getCategories);
					// echo '</pre>';
                ?>
				
			  <div class="block shop-by-side">
				<div class="sidebar-bar-title">
				  <h3>Shop By</h3>
				</div>
				<div class="block-content">
				<!--				  <p class="block-subtitle">Shopping Options</p>-->
                <?php
				
					if(!empty($filters->category)){                         
                      
						if(!empty($getCategories)){
                ?>
				  <div class="layered-Category">
					<h2 class="saider-bar-title">Category</h2>
					<div class="layered-content">
					  <ul class="check-box-list">
                    <?php
                      
						  
                            $i=0;
                          foreach($getCategories as $catego)
                          {

                    ?>
						<li class="leval<?=$catego->leval;?>">
						  <input class="filter category" type="checkbox" id="category<?=$i;?>" name="category[]" value="<?=$catego->slug;?>" <?php if(!empty($filter_category_array)) {if (in_array($catego->slug, @$filter_category_array)){ echo "checked";}}?>>
						  <label for="category<?=$i;?>"> <span class="button"></span> <?=ucfirst($catego->title);?> </label>
						</li>
                    <?php
                              $i++;
                          }
                      
                    ?>
						
					  </ul>
					</div>
				  </div>
                <?php
					   
                       }
                       
                    }
                ?>

                <?php
                   if(!empty($filters->brand))
                    {                         
                      
                ?>
				  <div class="layered-Category">
					<h2 class="saider-bar-title">Brands</h2>
					<div class="layered-content">
					  <ul class="check-box-list">
                    <?php
                      if(!empty($get_brands))
                      {
                          //print_r($color_array);
                            $i=0;
                          foreach($get_brands as $brand)
                          {
                    ?>
						<li>
						  <input class="filter brand_chk" type="checkbox" id="brand<?=$i;?>" name="chk_brand[]" value="<?=$brand->slug;?>" <?php if(!empty($brand_array)) {if (in_array($brand->slug, @$brand_array)){ echo "checked";}}?>>
						  <label for="brand<?=$i;?>"> <span class="button"></span> <?=ucfirst($brand->title);?> </label>
						</li>
                    <?php
                              $i++;
                          }
                      }
                    ?>
						
					  </ul>
					</div>
				  </div>
                <?php
                      
                       
                    }
                ?>
                
<!--                --attribute filter start from here---->
                <?php
				
                $cat_type =$this->input->get("cat_type");
                //echo $cat_slug."0";
				echo '<input type="hidden" id="cat_type" name="cat_type" value="'.@$cat_type.'" />';
                if(!empty($cat_type))
                {
                   if(!empty($filters->attributes))
                    {                         
                       
					  // echo "1";
						$q = $this->db->query("select * from `attributes`");
						$attributes = $q->result_array();
//                           echo "<pre>";
//    print_r($attributes);
						if(!empty($attributes))
						{
							foreach($attributes as $attribute)
							{
							
			?>                    
			  
					<?php
							//$current_arr = $this->input->get();
							//print_r($arr);
							
							$linir_arr = array('color');
								
							$sql = "select product_cat_type_id from categories where slug in('".$cat_slug."')";
							$query = $this->db->query($sql);

							$data = $query->result_array();
							$category_ids_array  = $data;
								//print_r($category_ids_array);
								
							$category_ids  = array_column($data, 'product_cat_type_id');
							$category_ids1 = implode(",",$category_ids);
								//echo "select * from `attribute_values` where attribute_id='".$attribute["attribute_id"]."' and attribute_values_product_cat_type_id in('".$category_ids1."')";
							$q1 = $this->db->query("select * from `attribute_values` where attribute_id='".$attribute["attribute_id"]."' and attribute_values_product_cat_type_id in('".$category_ids1."')");
							$attributes_values = $q1->result_array();
//                           echo "<pre>";
//    print_r($attributes);
								if(!empty($attributes_values))
								{
									$var_array = $attribute["attribute_name"]."_array";
									//print_r($$var_array);
									echo '<div class="layered-Category">
										<h2 class="saider-bar-title">'.ucfirst($attribute["attribute_name"]).'</h2>
										<div class="layered-content">';
										
										if(in_array($attribute["attribute_name"], $linir_arr)){
										  echo '<ul class="check-box-list learner check-box-hide">';
										}
										else{
										  echo '<ul class="check-box-list">';
										}
									
									$i=0;
									foreach($attributes_values as $attributes_value)
									{
										
					?>
							<li>
								<?php
									if($attribute["attribute_name"]!="color")
									{
								?>
							  <input class="filter <?=$attribute["attribute_name"];?>_chk" type="checkbox" id="<?=$attribute["attribute_name"];?><?=$i;?>" name="chk_<?=$attribute["attribute_name"];?>()" value="<?=$attributes_value["attribute_value"];?>" <?php if(!empty($$var_array)) {if (in_array($attributes_value["attribute_value"], @$$var_array)){ echo "checked";}}?>>
							  <label for="<?=$attribute["attribute_name"];?><?=$i;?>"> <span class="button"></span> <?=ucfirst($attributes_value["attribute_value"]);?> </label>
								<?php
									}
										else
										{
									?>
											<input class="filter <?=$attribute["attribute_name"];?>_chk" type="checkbox" id="<?=$attribute["attribute_name"];?><?=$i;?>" name="chk_<?=$attribute["attribute_name"];?>()" value="<?=$attributes_value["attribute_value_id"];?>" <?php if(!empty($$var_array)) {if (in_array($attributes_value["attribute_value_id"], @$$var_array)){ echo "checked";}}?>>
							  <label for="<?=$attribute["attribute_name"];?><?=$i;?>"> 
							  <div style="width: 30px;height: 25px;background-color: <?=$attributes_value["attribute_value"];?>"></div></label>
								<?php
										}
								?>
						  </li>
					  
					<?php
										$i++;
									}
									echo '</ul>
				</div>
			  </div>';
								}
							
				   
					?>
					
				  
			<?php
							}
						}
				   
                       
                    }
                }
                ?>
<!--                --attribute filter end here---->
				  
                <?php
                   if(!empty($filters->review))
                    {                         
                       
                ?>
				  <div class="layered-Category">
					<h2 class="saider-bar-title">Reviews</h2>
					<div class="layered-content">
					  <ul class="check-box-list rating">
						<li>
						  <input class="filter review_chk" type="checkbox" id="review<?=$i;?>" value="5" name="chk_review()" <?php if(!empty($review_array)){if (in_array(5, @$review_array)){ echo "checked";}}?>>
						  <label for="review<?=$i;?>"> <span class="button"></span> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> </label>
						</li>
						<li>
						  <input class="filter review_chk" type="checkbox" id="jtv2" name="jtvc" value="4" <?php if(!empty($review_array)){if (in_array(4, @$review_array)){ echo "checked";}}?>>
						  <label for="jtv2"> <span class="button"></span> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> </label>
						</li>
						<li>
						  <input class="filter review_chk" type="checkbox" id="jtv3" name="jtvc" value="3" <?php if(!empty($review_array)){if (in_array(3, @$review_array)){ echo "checked";}}?>>
						  <label for="jtv3"> <span class="button"></span> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> </label>
						</li>
						<li>
						  <input class="filter review_chk" type="checkbox" id="jtv4" name="jtvc" value="2" <?php if(!empty($review_array)){if (in_array(2, @$review_array)){ echo "checked";}}?>>
						  <label for="jtv4"> <span class="button"></span> <i class="fa fa-star"></i><i class="fa fa-star"></i> </label>
						</li>
						<li>
						  <input class="filter review_chk" type="checkbox" id="jtv5" name="jtvc" value="1" <?php if(!empty($review_array)){if (in_array(1, @$review_array)){ echo "checked";}}?>>
						  <label for="jtv5"> <span class="button"></span> <i class="fa fa-star"></i> </label>
						</li>
						
					  </ul>
					</div>
				  </div>
                <?php
                       
                       
                    }
                ?>
                
                <?php
                   if(!empty($filters->price))
                    {                         
                       
                ?>
				  <div class="slider-range layered-Category">
                      <h2 class="saider-bar-title">Price</h2>
<!--
					<div data-label-reasult="Range:" data-min="0" data-max="500" data-unit="$" class="slider-range-price" data-value-min="50" data-value-max="350"></div>
					<div class="amount-range-price">Range: $10 - $550</div>
-->
					<ul class="check-box-list">
					  <li>
						<input class="filter price_chk" type="checkbox" id="p1" name="cc" value="0-999" <?php if(!empty($filter_price_array)){if (in_array("0-999", @$filter_price_array)){ echo "checked";}}?> />
						<label for="p1"> <span class="button"></span> <?=$currency?>0 - <?=$currency?>999 </label>
					  </li>
					  <li>
						<input class="filter price_chk" type="checkbox" id="p2" name="cc" value="1000-4999" <?php if(!empty($filter_price_array)){if (in_array("1000-4999", @$filter_price_array)){ echo "checked";}}?>/>
						<label for="p2"> <span class="button"></span> <?=$currency?>1,000 - <?=$currency?>4,999 </label>
					  </li>
					  <li>
						<input class="filter price_chk" type="checkbox" id="p3" name="cc" value="5000-9999" <?php if(!empty($filter_price_array)){if (in_array("5000-9999", @$filter_price_array)){ echo "checked";}}?>/>
						<label for="p3"> <span class="button"></span> <?=$currency?>5,000 - <?=$currency?>9,999 </label>
					  </li>
                        <li>
						<input class="filter price_chk" type="checkbox" id="p4" name="cc" value="10000-50000" <?php if(!empty($filter_price_array)){if (in_array("10000-50000", @$filter_price_array)){ echo "checked";}}?>/>
						<label for="p4"> <span class="button"></span> <?=$currency?>10,000 - <?=$currency?>50,000 </label>
					  </li>
					</ul>
				  </div>
                <?php
                       
                    }
                ?>
				</div>
			  </div>
<!--
			  <div class="block product-price-range ">
				<div class="sidebar-bar-title">
				  <h3>Price</h3>
				</div>
				<div class="block-content">
				  <div class="slider-range">
					<div data-label-reasult="Range:" data-min="0" data-max="500" data-unit="$" class="slider-range-price" data-value-min="50" data-value-max="350"></div>
					<div class="amount-range-price">Range: $10 - $550</div>
					<ul class="check-box-list">
					  <li>
						<input type="checkbox" id="p1" name="cc" />
						<label for="p1"> <span class="button"></span> $20 - $50<span class="count">(0)</span> </label>
					  </li>
					  <li>
						<input type="checkbox" id="p2" name="cc" />
						<label for="p2"> <span class="button"></span> $50 - $100<span class="count">(0)</span> </label>
					  </li>
					  <li>
						<input type="checkbox" id="p3" name="cc" />
						<label for="p3"> <span class="button"></span> $100 - $250<span class="count">(0)</span> </label>
					  </li>
					</ul>
				  </div>
				</div>
			  </div>
-->
			  
			</aside>
            <div class="col-main col-sm-9 col-xs-12 " >
                <?php
                if(!empty($getProducts))
                {
                ?>
                    <div class="shop-inner">
					<span class="filter_option" href="javascript:void(0)"> <i class="fa fa-filter"></i> </span>
                    <div class="page-title">
                        <h2><?=$this->lang->line("Shop Now")?></h2>
                    </div>
					<div class="toolbar">
					  <div class="view-mode">
						<ul>
						  <li class="active" id="prod_grid"> <a href="javascript:void(0)"> <i class="fa fa-th-large"></i> </a> </li>
						  <li id="prod_list"> <a href="javascript:void(0)"> <i class="fa fa-th-list"></i> </a> </li>
						</ul>
					  </div>
                        <?php
                            if(!empty(@$totalProducts))
                            {   
                                //echo $totalProducts;
                                $total_pages = ceil($totalProducts/9);
                             
//                                if(!empty($current_page))
//                                {
//                                    $current_page +=    1;
//                                    if($total_pages>$current_page)
//                                    {
//                                        $current_page +=    1;
//                                    }
//                                    else
//                                    {
//                                        $current_page = $current_page;
//                                    }
//                                }
//                                else
//                                {
//                                    $current_page=0;
//                                }
                            }
                        ?>
                            <input type="hidden" id="hid_current_page" value="2">
                            <input type="hidden" id="hid_total_page" value="<?php if(!empty($total_pages)){ echo $total_pages;}else{ echo 0;}?>">
					  <div class="sorter">
						<div class="short-by">
						  <label id="ram">Sort By:</label>
                            
						  <select id="order_by" name="order_by" onchange="filter()">
							<option value="">Sort By</option>
							<option value="name1" <?php if(!empty($filter_order_by)){if (strpos(@$filter_order_by, "name1")!==false){ echo "selected";}}?>>Name: A to Z</option>
                            <option value="name2" <?php if(!empty($filter_order_by)){if (strpos(@$filter_order_by, "name2")!==false){ echo "selected";}}?>>Name: Z to A</option>
							<option value="price1" <?php if(!empty($filter_order_by)){if (strpos(@$filter_order_by, "price1")!==false){ echo "selected";}}?>>Price: Low To High</option>
							<option value="price2" <?php if(!empty($filter_order_by)){if (strpos(@$filter_order_by, "price2")!==false){ echo "selected";}}?>>Price: High To Low</option>
<!--							<option>Size</option>-->
						  </select>
						</div>
<!--
						<div class="short-by page">
						  <label>Show:</label>
						  <select>
							<option selected="selected">18</option>
							<option>20</option>
							<option>25</option>
							<option>30</option>
						  </select>
						</div>
-->
					  </div>
					</div>
					
                    <div class="product-grid-area">
                        <ul class="products-grid">
                            <?php
                            foreach ($getProducts as $key => $value):
                                
                                $category_id        = $value['category_id'];
                                $category_title     = $value['title'];
                                $product_id         = $value['product_id'];
                                $pro1               = explode(',',$value['product_image']);
                                $product_image      = $product_img_url. $pro1[0];
                                $product_name       = $value['product_name'];
                                $dataCount = 0;
                                $dataCounthtml = '';
                                $buttonLang     =   $this->lang->line('Add To Cart');
                                $offerdiv       =   '';
                                if(!empty($product_arr)){
                                    foreach ($product_arr as $key => $product_session) {
                                        if (in_array($product_id, $product_session)) {
                                            $dataCount       = $product_session['buy_qty'];
                                            $dataCounthtml   = '<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">'.$dataCount.'</span></a></div>';
                                            $buttonLang       = $this->lang->line('Added To Cart');
                                            
                                        }
                                    }
                                }
                            	$q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."' and stock_inv>0");
    							$variants_pro       = $q_variants->result_array();
                            
                                if(empty($variants_pro))
                                {
                                    $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."'");
                                     $variants_pro       = $q_variants->result_array();
                                }
                            
    							$eleid              = $variants_pro[0]['product_id']; 
    							$product_mrp        = number_format((float)$variants_pro[0]['mrp'], 2, '.', '');
                                $product_price      = number_format((float)$variants_pro[0]['price'], 2, '.', '');//$value['price'];
                                $product_unit       = $variants_pro[0]['unit'];
                                $product_unit_value = $variants_pro[0]['qty'];
                                $varientid          = $variants_pro[0]['varient_id'];
                                $flavor             = $variants_pro[0]['flavor'];
                                if(!empty($variants_pro[0]['pro_var_images'])){
                                    $product_image  = base_url().'backend/uploads/products/'.$variants_pro[0]['pro_var_images'];
                                }
                                $in_stock           = $value['in_stock'];
							    $stock              = $variants_pro[0]['stock_inv'];
                                $outofstock         =   '';
                                //if($stock < 1 || empty($in_stock)){
                                //if($in_stock < 1 && empty($q_variants)){
                                if($stock < 1 || empty($in_stock)){
                                    $buttonLang     =   $this->lang->line('Out Of Stock');
                                    $outofstock     =   '<div class="out_stock" style="z-index: 999;"><img src="'.$this->config->item('base_url').'assets/images/out-of-stock1.png"></div>';
                                }
                            
							    $product_type       = $value['product_type'];
    							$product_call       = $value['product_call'];
    							$product_slug       = $value['product_slug'];
    							
    							$q                  = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$variants_pro[0]['varient_id']."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
    							$del_price          = $q->row();
    							if(!empty($del_price)){
    								$difference_price   = $variants_pro[0]['mrp'] - $del_price->deal_price;	
    								$product_price      = number_format((float)$del_price->deal_price, 2, '.', '');
    								$single_price       = $del_price->deal_price;
    								if($difference_price > 0){
    								    $percent        =   round(($difference_price*100)/ $variants_pro[0]['mrp'],2);
    								    $offerdiv       =   '<div class="save-prices">GET <span class="ng-binding">'.$percent.'</span>% OFF <span class="asterisk-icon"></span></div>';
    								}
    							} else {
    								$difference_price   = $variants_pro[0]['mrp'] - $variants_pro[0]['price'];
    								$product_price      = number_format((float)$variants_pro[0]['price'], 2, '.', '');
    								$single_price       = $variants_pro[0]['price'];
    								if($difference_price > 0){
    								    $percent        =   round(($difference_price*100)/ $variants_pro[0]['mrp'],2);
    								    $offerdiv       =   '<div class="save-prices">GET <span class="ng-binding">'.$percent.'</span>% OFF <span class="asterisk-icon"></span></div>';
    								}
    							}
    							
							
							    if($product_type == 1){
    							    $class          =   "veg-icon";   
    							    $title          =   "Vegetarian";
    							    $p_type         =   "veg";
    							}
    							elseif($product_type == 2){
    							    $class          =   "non-veg-icon"; 
    							    $title          =   "Non Vegetarian";
    							    $p_type         =   "non-veg";
    							}
    							else{
    							    $class          =   ""; 
    							    $title          =   "";
    							    $p_type         =   "";
    							}
    							$whishlist          =   0;
    							$q_whishList         = $this->db->query("SELECT * FROM `btl_wishlist` WHERE product_id='".$product_id."' AND user_id ='".$this->session->userdata('user_id')."'");
    							$whishList           = $q_whishList->result_array();
    							if(count($whishList) > 0){
    							    $whishlist       =  1;
    							}
								
								$rating = !empty($value['avg_rating'])? $value['avg_rating'] : '0';
								
							
                            ?>
                            <li class="<?=$classses?>">
                                <div class="product-item">
                                    <div class="item-inner" style="<?=!empty($in_stock) && $stock >= 1 ? '' : 'opacity: .3;' ?>">
                                        <div class="product-thumbnail">
                                            <div class="icon-new-label">
                                                <?php echo  $product_call == 1 ? '<img src="'.$this->config->item('base_url').'assets/images/swadeshi.png">' :''; ?>
                                            </div>
                                            <span class="<?=$class?> ng-scope" title="<?=$title?>" ng-if="vm.selectedProduct.p_type === '<?=$p_type?>' ">&nbsp;</span>
                                            <div class="pr-img-area"> 
                                                <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>">
                                                    <figure> 
                                                        <img class="first-img lazyOwl" id="pro_img_<?=$product_id?>" height="225" width="225"
                                                             src="<?= $product_image ?>" alt=""> 
                                                        <!--img class="hover-img lazy" height="225" width="225"
                                                             data-src="<?= $product_image ?>" alt=""-->
                                                    </figure></a> 
                                                   
    
                                            </div>
                                            <?=$outofstock?>
                                            <?php /* <div class="pr-info-area">
                                                <div class="pr-button text-center">
                                                   
                                                    <div class="mt-button quick-view"> <a href="{base_url}product/<?=$product_id?>"> <i class="fa fa-link"></i> </a> </div>
                                                    <div class="mt-button add_to_compare"> 
                                                        <!-- <a href="{base_url}compare"> <i class="fa fa-signal"></i> </a> -->
                                                    </div>
                                                </div>
                                            </div> <?php */?>
                                        </div>
                                        <?=$offerdiv?>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"> 
                                                    <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>"><?= $product_name ?></a> 
                                                    <a  style="height: 19px;" class="product-listing__save--price <?php echo "fl_" . $eleid; ?>"><?=$flavor?></a>
													<div class="rating">
													  <?php
													   //echo $rating."-";
															$disable_rating = 5-$rating;
												   
															for($i = 0; $i<$rating; $i++)
															{ //echo "-".$i;
																echo '<i class="fa fa-star"></i>';
															}
												   
															for($i = 0; $i<$disable_rating; $i++)
															{
																echo '<i class="fa fa-star-o"></i>';
															}
													  ?>
													</div>
                                                </div>
                                                <div class="item-content">
                                                    <div class="item-price">
                                                        <div class="price-box">
                                                            <div id="product-listingsave<?=$eleid?>">
                                                                <?php if($dataCount <=0 && $difference_price > 0){ ?>
                                                                    <div data-id="<?=$difference_price?>" class="product-listing__save ">save <span class="product-listing__save--price"><?=$this->config->item('currency')?><span class="save-price" id="<?php echo "diffid" . $eleid; ?>"><?=$difference_price?></span></span></div>
                                                                <?php } elseif($dataCount > 0){
                                                                    echo $dataCounthtml;
                                                                } ?>
                                                            </div>
                                                            <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"  id="<?php echo "id" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_price ?></span></span> </p>
                                                            <!-- <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price" id="<?php echo "regid" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_mrp ?>/- </span> </p> -->
															<div id="<?php echo "stock_" . $eleid; ?>" style="float:right;">Stock <?=$stock?></div>
                                                        </div>
                                                        <!--<div><span class="price-label">You Save:</span> <span class="small" id="<?php echo "diffid" . $eleid; ?>"><?=$difference_price?></span></div>-->
                                                        
											<select class="form-control onsel sss" id="<?php echo $product_id; ?>">
											<?php
												foreach ($variants_pro as $key => $valuess) {
													
													$product_price_v = number_format((float)$valuess['price'], 2, '.', '');
													$product_mrp_v = number_format((float)$valuess['mrp'], 2, '.', '');
													$q_v = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$valuess['varient_id']."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
	AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
													$del_price_v = $q_v->row();
													if(!empty($del_price_v)){
														$difference_price_v = $valuess['mrp'] - $del_price_v->deal_price;	
														$product_price_v = number_format((float)$del_price_v->deal_price, 2, '.', '');
														$single_price_v  = $del_price_v->deal_price;
													} else {
														$difference_price_v = $valuess['mrp'] - $valuess['price'];
														$product_price_v = number_format((float)$valuess['price'], 2, '.', '');
														$single_price_v  = $valuess['price'];
													}
													$flavor     =   $valuess['flavor'];
													$images     =   !empty($valuess['pro_var_images']) ? base_url().'backend/uploads/products/'.$valuess['pro_var_images'] : '';
													$stocks     =   $valuess['stock_inv'];
														?>
														<option value="<?php echo $valuess['qty']; ?>"
														data-vid="<?php echo $valuess['purchase_id']; ?>"
														data-price="<?php echo $product_price_v; ?>"
														data-mrp  = "<?php echo $product_mrp_v; ?>"
														data-difference  = "<?php echo $difference_price_v; ?>"
														data-units  = "<?php echo $valuess['unit']; ?>"
														data-idd="<?php echo $valuess['product_id']; ?>" 
														data-varient="<?php echo $valuess['varient_id']; ?>"
														data-image  = "<?=$images?>"
														data-flavor = "<?=$flavor?>"
														data-stock = "<?=$stocks?>"
														data-single = "<?=$single_price_v?>">  <?php echo $valuess['qty']." ".$valuess['unit']; ?> - <?=$this->config->item('currency').' '.$product_price_v?> </option>

														<?php
													}
												
												?>
											</select>
                                                    </div>
                                                    <div class="pro-action">
														<input type="hidden" name="product_id" id="product_id<?=$product_id?>" value="<?=$product_id?>">
														<input type="hidden" name="product_varient_id" id="product_varient_id<?=$product_id?>" value="<?=$varientid?>">
														<input type="hidden" name="price" id="price<?=$product_id?>" value="<?=$single_price?>" class="priceee">
														<input type="hidden" name="unit" id="unit<?=$product_id?>" value="<?=$product_unit_value?>" class="units">
														<input type="hidden" name="unit_value" id="unit_value<?=$product_id?>" value="<?=$product_unit?>" class="unit_value">
														<input type="hidden" name="qty" id="qty<?=$product_id?>" value="1" class="qty">
														<button type="submit" class="add-to-carts" <?=!empty($in_stock)  && $stock >= 1 ? '' : 'disabled' ?> id="cart<?=$product_id?>" data-id="<?=$product_id?>"><i class="fa fa-shopping-basket"></i><span><?=$buttonLang?></span></button>
                                                        <div class="product-listing__quantity--add">
                                                            <a href="javascript:void(0)" id="<?=$product_id?>" class="add_to_wishlist button-icon-white" > <i class="fa fa-heart" id="das_<?=$product_id?>"  style="<?=!empty($whishlist) ? 'color:red' :'color:black'?>"></i> </a>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php
                        endforeach;
                        ?>
                            
                        </ul>
                        <div id='btn-loader' class='col-sm-10 text-center' style="display:none;"> <button class='buttonload'><i class='fa fa-spinner fa-spin'></i>Loading </button></div>
                        
                    </div>
                    <div class="pagination-area " style="left:0;right:0;">
                        
                    </div>
                </div>
                <?php
                }
                else
                {
                ?>
                      <div class="error_pagenotfound"> 
                        <b>Product Not Found!</b> <em>Product Could not be Found here.</em>
                </div>
                <?php
                }
                ?>
            </div>	
            

		</div>
    </div>
</div>
<style>

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script >
    function filter(){
		var order_by = $("#order_by").val();
		var cat_type = $("#cat_type").val();
	
		var page=1;
		var path="";
		var price="";
		var review="";
		var category="";
		var brand="";
		var size="";
		var color="";
		var material="";
		var use_for="";
		
//        alert("ram-"+cat_slug);
        
        $('.size_chk:checked').each(function () {
			if(size=="")
			{
				size = $(this).val();
			}
			else{
				size = size+"+"+$(this).val();
			}
		   
	   });
        
        $('.color_chk:checked').each(function () {
			if(color=="")
			{
				color = $(this).val();
			}
			else{
				color = color+"+"+$(this).val();
			}
		   
	   });
        
        $('.material_chk:checked').each(function () {
			if(material=="")
			{
				material = $(this).val();
			}
			else{
				material = material+"+"+$(this).val();
			}
		   
	   });
        
        $('.use_for_chk:checked').each(function () {
			if(use_for=="")
			{
				use_for = $(this).val();
			}
			else{
				use_for = use_for+"+"+$(this).val();
			}
		   
	   });
        
		$('.price_chk:checked').each(function () {
			if(price=="")
			{
				price = $(this).val();
			}
			else{
				price = price+"+"+$(this).val();
			}
		   
	   });
		
		
		$('.review_chk:checked').each(function () {
		   
			if(review=="")
			{
				review = $(this).val();
			}
			else{
				review = review+"+"+$(this).val();
			}
	   });
		
		
		$('.category:checked').each(function () {
		   
			if(category=="")
			{
				category = $(this).val();
			}
			else{
				category = category+"+"+$(this).val();
			}
	   });
		$('.brand_chk:checked').each(function () {
		   
			if(brand=="")
			{
				brand = $(this).val();
			}
			else{
				brand = brand+"+"+$(this).val();
			}
	   });
		//alert(brand);
        
        
        if(use_for!="")
		{
			if(path!="")
			{
				path = path+"&";
			}
//            alert(path);
			path = path+"use_for="+use_for;
		}
        
        if(color!="")
		{
			if(path!="")
			{
				path = path+"&";
			}
//            alert(path);
			path = path+"color="+color;
		}
        
        if(size!="")
		{
			if(path!="")
			{
				path = path+"&";
			}
//            alert(path);
			path = path+"size="+size;
		}
        
        if(material!="")
		{
			if(path!="")
			{
				path = path+"&";
			}
//            alert(path);
			path = path+"material="+material;
		}
        
        if(cat_type!="")
        {
            //alert(cat_type);
            if(path!="")
			{
				path = path+"&";
			}
            path = path+"cat_type="+cat_type;
        }
        
        if(category!="")
        {
            //alert(cat_slug);
            if(path!="")
			{
				path = path+"&";
			}
            path = path+"category="+category;
        }
        
		if(brand!="")
		{
            if(path!="")
			{
				path = path+"&";
			}
			path = path+"brand="+brand;
		}
		
		if(review!="")
		{
			if(path!="")
			{
				path = path+"&";
			}
			path = path+"review="+review;
		}
		
		if(price!="")
		{
			if(path!="")
			{
				path = path+"&";
			}
			path = path+"price="+price;
		}
		
		if(order_by!="" && order_by!=undefined)
		{
			if(path!="")
			{
				path = path+"&";
			}
			path = path+"order_by="+order_by;
		}
		
		if(page!="")
		{
			if(path!="")
			{
				path = path+"&";
			}
			path = path+"page="+page;
		}
		
		
		
		//alert(path);
		var BASE_URL  = "{base_url}shop?";
		var fullpath = BASE_URL+path;
		//alert(fullpath);
		window.location.href = fullpath;
	}
	$(document).ready(function() {
		var currentHeight = "";
		var a= 1;
		$(window).scroll(function() {
			var current_page_no = parseInt($("#hid_current_page").val());
			var windowTop = $(this).scrollTop();
			var footer = $('footer');
			var endTop = footer.offset().top - footer.height()-300;

			if (windowTop > endTop && a<current_page_no) {

				currentHeight = windowTop;
				newTop = endTop ;

				var total_page = parseInt($("#hid_total_page").val());
				//alert(current_page_no);
				var queryString = window.location.search;

				var urlParams = new URLSearchParams(queryString);


				var cat_type = urlParams.get('cat_type');
				var category = urlParams.get('category');
				var brand = urlParams.get('brand');
				var price = urlParams.get('price');
				var review = urlParams.get('review');
				var order_by = urlParams.get('order_by');
				var page = urlParams.get('page');
				page = current_page_no;

				console.log(a+"-"+current_page_no);

				var BASE_URL  = "{base_url}";
				//alert(BASE_URL+"shop_products");
				if(total_page>=current_page_no && a!=current_page_no)
				{                      
					a = current_page_no
					$.ajax({
						url: BASE_URL+"shop_products",
						global: false,
						type: 'get',
						data: {cat_type:cat_type, category:category, brand:brand, price:price, review:review, order_by:order_by, page:page},
						async: false, //blocks window close
						beforeSend: function(msg){
							$('#btn-loader').show();
						  },
						success: function(data) {
							setTimeout(function() {
								$('#btn-loader').hide();
								$(".products-grid").append(data);
								 current_page_no = current_page_no+1;
								$("#hid_current_page").val(current_page_no);
								if($('#prod_list').hasClass('active')){
									$('#prod_list').trigger('click')
								}
							}, 2000);

						}
					});

				}

			}

		});
		
		$('.filter_option').on('click', function(){
			$('.sidebar').toggle();
		})
		
		if ($(window).width() > 768) {
			$(window).scroll(function() {
				// var sidebar = $('.main-container');
				var nav = $('nav');
				var sidebar = $('.sidebar');
				var footer = $('footer');
				var space = 90; // arbitrary value to create space between the window and widget
				var startTop = nav.offset().top
				var endTop = footer.offset().top - sidebar.height() - space;
				
				var windowTop = $(this).scrollTop();
				var sidebarTop = sidebar.offset().top + 500;
				console.log('windowTop: '+windowTop)
				console.log('sidebarTop: '+sidebarTop)
				console.log('startTop: '+startTop)
				console.log('endTop: '+endTop)
				
				if (windowTop == 0) {
					newTop = 0;
				} 
				else if (windowTop > startTop - space && windowTop < endTop - space) {
					newTop = windowTop - space;
				} 
				else if (windowTop > endTop + space) {
					newTop = endTop - space;
				}
				
				sidebar.stop().animate({
					'top': newTop
				});
				
			});
			
		}
		
		var myString = '<?php echo $classses; ?>'
		classses=myString.replace('item ', '');
		$('#prod_list').click(function(event){
			event.preventDefault();
			$('.product-grid-area').addClass('product-list-area');
			$('.products-grid').addClass('products-list');
			$('.products-grid .item').removeClass(classses);
			$('#prod_list').addClass('active');
			$('#prod_grid').removeClass('active');
		});
		$('#prod_grid').click(function(event){
			event.preventDefault();
			$('.product-grid-area').removeClass('product-list-area');
			$('.products-grid').removeClass('products-list');
			$('.products-grid .item').addClass(classses);
			$('#prod_grid').addClass('active');
			$('#prod_list').removeClass('active');
		});
	});
</script>
<script>
    $(document).ready(function(){
        
        $('.filter').click(function(){
            filter();
        })
        
        
        $('.add_to_wishlist').click(function(){
            var product_id = $(this).attr('id');
            //var BASE_URL  = "http://kriscenttechnohub.com/kart-grocery-supermarket/";
            var BASE_URL  = "{base_url}";
            $.get(BASE_URL+"addToWishlist",{ product_id:product_id},function(data){
            
              if(data == "0"){
                  $('#das_'+product_id).css('color','black')
              }else if(data == "1"){
                  $('#das_'+product_id).css('color','red')
              }else if(data == '2'){
                  
                  window.location.href = BASE_URL+"login";
              }
                
            });
            
        })
        
        
       
    });
    $(document).on('change', ".onsel", function (e) {
       debugger;
		e.preventDefault();
		var unit_value = $(this).find(':selected').val();
		var vid = $(this).find(':selected').data('vid');
		var idd = $(this).find(':selected').data('idd');
		var price = $(this).find(':selected').data('price');
		var stock  = $(this).find(':selected').data('stock');
		
		var mrp = $(this).find(':selected').data('mrp');
		var difference = $(this).find(':selected').data('difference');
		var units = $(this).find(':selected').data('units');
		var varient = $(this).find(':selected').data('varient');
		var single  = $(this).find(':selected').data('single');
		var image  = $(this).find(':selected').data('image');

		if(image !=''){
		    $('#pro_img_'+idd).data('src',image);
		    $('#pro_img_'+idd).attr('src',image);
		}
		
		$('#product_id'+ idd).val(idd);
		$('#product_varient_id'+ idd).val(varient);
		$('#price'+ idd).val(single);
		$('#unit'+ idd).val(unit_value);
		$('#unit_value'+ idd).val(units);

		$("#stock_"+idd).html("Stock " + stock);
		

		$("#id" + idd).text("<?=$this->config->item('currency')?> "+price+"/-");
		
		$("#regid" + idd).text("<?=$this->config->item('currency')?> "+mrp+"/-");
		$("#diffid" + idd).text(difference);
        $(".fl_" + idd).text($(this).find(':selected').data('flavor'));
            
    });
    $(document).on('click','.add-to-carts', function(e){
		debugger;
        e.preventDefault();
        var product_id  =   $(this).data('id');
        var varient_id  =   $('#product_varient_id'+product_id).val();
        var price       =   $('#price'+product_id).val();
        var unit        =   $('#unit'+product_id).val();
        var unit_value  =   $('#unit_value'+product_id).val();
        var qty         =   $('#qty'+product_id).val();
		var stock       =   parseInt($('#stock_'+product_id).html().replace(/[^0-9]/g, ''));

        if(product_id !='' && varient_id !=''){
            $(this).find('i').removeClass('fa fa-shopping-basket').addClass('icon-loader');
            $.ajax({
        		type: "post",
        		url: "{base_url}add_cart",
        		data: {product_id:product_id,product_varient_id:varient_id,price:price,unit:unit,unit_value:unit_value,qty:qty, stock:stock},
        		dataType: "json",
        		success: function (response) {
        		     $('#cart'+product_id).find('i').removeClass('icon-loader').addClass('fa fa-shopping-basket');
        		     $('.cart-total').html(response.total_item+' item');        		     
        		     $('#cart-sidebar').html(response.html);        		     
        		     $('#total_order_price').html(response.total_order_price);
        		     $('#cart'+product_id).html('<i class="fa fa-shopping-basket"></i><span> <?=$this->lang->line('Added To Cart');?></span>');
        		     $('#cart2_'+product_id).html('<i class="fa fa-shopping-basket"></i><span> <?=$this->lang->line('Added To Cart');?></span>');
        		     $('#cart_'+product_id).html('<i class="fa fa-shopping-basket"></i><span> <?=$this->lang->line('Added To Cart');?></span>');
        		     $('#cart3_'+product_id).html('<i class="fa fa-shopping-basket"></i><span> <?=$this->lang->line('Added To Cart');?></span>');
        		     if($('#product-listingsave'+product_id).find('.badge').length > 0){
        		         var data   =   parseInt($('#product-listingsave'+product_id).find('.badge').html());
        		         data       =   (data + 1);
        		         $('#product-listingsave'+product_id).html('<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">'+data+'</span></a></div>');
        		     }
        		     else{
        		         $('#product-listingsave'+product_id).html('<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">1</span></a></div>');
        		     }
        		     
        		    //  $.notify({
                    // 	message: 'Product Added To Cart'
                    // },{
                    // 	type: 'success',
                    // 	placement: {
                    // 		from: "bottom",
                    // 		align: "right"
                    // 	},
                    // });
        		    //location.reload();
        		}
            });
        }
    });
</script>
<!-- Main Container End --> 