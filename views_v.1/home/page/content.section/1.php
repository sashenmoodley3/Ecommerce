<?php
$webItem        =   trim($this->config->item('one_row_item'));
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
?>
<style>
    .img {
        border: 0;
        max-width: 34%;
    }
    
</style>
<!--div class="jtv-service-area">
    <div class="container">
      <div class="row">
        <div class="col col-md-3 col-sm-6 col-xs-12">
          <div class="block-wrapper ship">
            <div class="text-des">
              <div class="icon-wrapper"><i class="fa fa-truck"></i></div>
              <div class="service-wrapper">
                <h3>World-Wide Shipping</h3>
                <p>On order over $99</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col col-md-3 col-sm-6 col-xs-12 ">
          <div class="block-wrapper return">
            <div class="text-des">
              <div class="icon-wrapper"><i class="fa fa-refresh"></i></div>
              <div class="service-wrapper">
                <h3>30 Days Return</h3>
                <p>Moneyback guarantee </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col col-md-3 col-sm-6 col-xs-12">
          <div class="block-wrapper support">
            <div class="text-des">
              <div class="icon-wrapper"><i class="fa fa-umbrella"></i></div>
              <div class="service-wrapper">
                <h3>SUPPORT 24/7</h3>
                <p>Call us: ( +123 ) 456 789</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col col-md-3 col-sm-6 col-xs-12">
          <div class="block-wrapper user">
            <div class="text-des">
              <div class="icon-wrapper"><i class="fa fa-user"></i></div>
              <div class="service-wrapper">
                <h3>MEMBER DISCOUNT</h3>
                <p>25% on order over $199</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div-->
<?php if(!empty($getTopSellingProducts)){ ?>
<div class="container">
    <div class="special-products">
        <div class="page-header">
            <h2><?=$this->lang->line("Top Selling Products")?></h2>
        </div>
        <div class="special-products-pro">
            <div class="slider-items-products">
                <div id="special-products-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col4">
                        <?php
						 //print_r($getTopSellingProducts );
                        foreach ($getTopSellingProducts as $key => $value):
                            $category_id        = $value['category_id'];
                            $category_title     = $value['title'];
                            $pro1               = explode(',',$value['product_image']);
                            $product_image      = $product_img_url . $pro1[0];
                            
                            $product_id         = $value['product_id'];
                            $product_name       = $value['product_name'];
                            $dataCount = 0;
                            $dataCounthtml = '';
                            $buttonLang     =   $this->lang->line('Add To Cart');
                            if(!empty($product_arr)){
                                foreach ($product_arr as $key => $product_session) {
                                    if (in_array($product_id, $product_session)) {
                                        $dataCount       = $product_session['buy_qty'];
                                        $dataCounthtml   = '<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">'.$dataCount.'</span></a></div>';
                                        $buttonLang      = $this->lang->line('Added To Cart');
                                        
                                    }
                                }
                            }
                            
                            
                            
                            $product_wishlist   = $value['wishlist'];
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
                            //$stock              = $variants_pro[0]['stock_inv'];
                            if(!empty($variants_pro[0]['pro_var_images'])){
                                    $product_image  = base_url().'backend/uploads/products/'.$variants_pro[0]['pro_var_images'];
                                }
                            
							$product_type       = $value['product_type'];
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
							$product_call       = $value['product_call'];
							$product_slug       = $value['product_slug'];
							$in_stock           = $value['in_stock'];
							$stock              = $variants_pro[0]['stock_inv'];
							$outofstock         =   '';
							$offerdiv           =   '';
							//if($stock < 1 || empty($in_stock)){$q_variants
                            //if($in_stock < 1 && empty($q_variants)){
                            if($stock < 1 || empty($in_stock)){
                                $buttonLang     =   $this->lang->line('Out Of Stock'); 
                                $outofstock     =   '<div class="out_stock"><img src="'.$this->config->item('base_url').'assets/images/out-of-stock1.png"></div>';
                            }
							
							$q                  = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$variants_pro[0]['varient_id']."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
							
							$del_price          =   0;
							if($q->num_rows() > 0){
							    $del_price          = $q->row();
							}
							
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
							$whishlist          =   0;
							$q_whishList         = $this->db->query("SELECT * FROM `btl_wishlist` WHERE product_id='".$product_id."' AND user_id ='".$this->session->userdata('user_id')."'");
							$whishList           = $q_whishList->result_array();
							if(count($whishList) > 0){
							    $whishlist       =  1;
							}
                            ?>
                            <div class="product-item">
                                <div class="item-inner"  style="<?=!empty($in_stock)  && $stock >= 1 ? '' : 'opacity: .3;' ?>">
                                    <div class="product-thumbnail">
                                        <div class="icon-new-label">
                                            <?php echo  $product_call == 1 ? '<img src="'.$this->config->item('base_url').'assets/images/swadeshi.png">' :''; ?>
                                        </div>
                                        <span class="<?=$class?> ng-scope" title="<?=$title?>" ng-if="vm.selectedProduct.p_type === '<?=$p_type?>' ">&nbsp;</span>
                                        <div class="pr-img-area"> 
                                            <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>">
                                                <figure> 
                                                    <img class="first-img lazyOwl" id="pro_img<?=$product_id?>" height="225" width="225"
                                                         data-src="<?= $product_image ?>" alt=""> 
                                                    <!--img class="hover-img lazy" height="225" width="225"
                                                         data-src="<?= $product_image ?>" alt=""-->
                                                </figure></a> 
                                               

                                        </div>
                                        <?=$outofstock?>
                                        <!--div class="pr-info-area">
                                            <div class="pr-button">
                                                <div class="mt-button add_to_wishlist">
                                                        <a href="{base_url}wishlist"> <i class="fa fa-heart"></i> </a> 
                                                </div>
                                                <div class="mt-button quick-view"> <a href="{base_url}product/<?=$product_id?>"> <i class="fa fa-link"></i> </a> </div>
                                                <div class="mt-button add_to_compare"> 
    <!--                                                        <a href="{base_url}compare"> <i class="fa fa-signal"></i> </a> -->
                                                <!--/div>
                                            </div>
                                        </div-->
                                    </div>
                                    <?php if(!empty($in_stock) && $stock >= 1){
                                            echo $offerdiv;
                                        
                                        } ?>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"> 
                                                <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>"><?= $product_name ?></a> 
                                                <a style="height: 19px;" class="product-listing__save--price <?php echo "fl" . $eleid; ?>"><?=$flavor?></a>
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
                                                    
                                                    <select class="form-control onsel sss"
                                                                                id="<?php echo $product_id; ?>">
                                                                            <?php
                                                                                foreach ($variants_pro as $key => $valuess) {
                                                                                    
                                                        								$product_price_v = number_format((float)$valuess['price'], 2, '.', '');
                                                        								$product_mrp_v = number_format((float)$valuess['mrp'], 2, '.', '');
                                                        								$q_v = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$valuess['varient_id']."'  AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
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
                                                        							    $stocks      = $valuess['stock_inv'];
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
                                                                                            data-stock = "<?php echo $valuess['stock_inv']; ?>"
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
                                                        <button type="submit" class="add-to-carts" <?=!empty($in_stock) && $stock >= 1 ? '' : 'disabled' ?> id="cart<?=$product_id?>" data-id="<?=$product_id?>"><i class="fa fa-shopping-basket"></i><span> <?=$buttonLang?></span></button> </a>
                                                    <div class="product-listing__quantity--add">
                                                        <a href="javascript:void(0)" id="<?=$product_id?>" class="add_to_wishlist button-icon-white" > <i class="fa fa-heart" id="das_<?=$product_id?>"  style="<?=!empty($whishlist) ? 'color:red' :'color:black'?>"></i> </a>  
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php
    $type_name = $this->db->query('SELECT feature_slider_type.type_id, feature_slider_type.type_name FROM  feature_slider_type
                                    INNER JOIN feature_slider ON feature_slider.slider_title = feature_slider_type.type_id
                                    WHERE feature_slider.banner_type = 3 AND feature_slider.slider_status=1 AND feature_slider.trash =0 group by feature_slider_type.type_id ORDER BY feature_slider_type.type_id LIMIT 0,3')->result_array();
?>
<?php if(!empty($type_name)){ 
    
?>   
    <div class="container">
        <?php foreach($type_name as $rows){   
            $sql_cat = "SELECT 
                    feature_slider.id as id,
                    feature_slider.image_type as image_type,
                    feature_slider.slider_title as slider_title,
                    feature_slider.slider_url as slider_url,
                    feature_slider.slider_image as slider_image,
                    feature_slider.sub_cat as sub_cat,
                    feature_slider.sub_type,
                    feature_slider.slider_status as slider_status,
                    feature_slider.banner_type,
                    categories.title as cat_title,
                    tbl_brand.title as brand_title,
                    products.product_name as product_name,
                    categories.slug as slug,
                    tbl_brand.slug as brand_slug,
                    products.product_slug as product_slug
                    FROM feature_slider 
                    LEFT JOIN categories ON categories.id = feature_slider.sub_cat AND categories.status = 1 AND feature_slider.sub_type='category'
                    LEFT JOIN tbl_brand  ON tbl_brand.id = feature_slider.sub_cat AND tbl_brand.status = 1 AND feature_slider.sub_type='brand'
                    LEFT JOIN products  ON products.product_id = feature_slider.sub_cat AND products.trash = 0 AND feature_slider.sub_type='product'
                    WHERE feature_slider.slider_title = '" . $rows['type_id'] . "' AND feature_slider.banner_type='3' AND feature_slider.slider_status=1 AND feature_slider.trash =0";
                    //echo $sql_cat; exit;
            $q2 = $this->db->query($sql_cat);
            if($q2->num_rows() > 0){
        ?>
            <div class="col-md-12 col-xs-12 mt10"> 
                <div class="row">
                    <div class="page-header">
                        <h2><?=$rows['type_name'];?></h2>
                    </div>
                    <?php
                        //var_dump($getCategoriesShort);
                            
                            $slider = $q2->result_array();
                            $small  = '';
                            $big    = '';
                            foreach($slider as $row){
                                if($row['sub_type'] == 'category'){
                                    $href   =   base_url()."search?slug=".$row['slug']."&search=";
                                }elseif($row['sub_type'] == 'brand'){
                                    $href   =   base_url()."search?slug=".$row['brand_slug']."&search=";
                                }elseif($row['sub_type'] == 'product'){
                                    $href   =   base_url()."search?slug=".$row['product_slug']."&search=";
                                }
                                $href       =   $href.'&type='.$row['sub_type'];
                                $image  =   base_url().$this->config->item('images_url').'sliders/'.$row['slider_image'];
                                if($row['image_type'] == 1){
                                    $small    .=   '<div class="col-md-4 col-xs-12 lineart">
                                					<a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                					</a>
                                    			</div>';
                                }
                                else if($row['image_type'] == 0){
                                    $big    .=   '<div class="col-xs-12 mt-20">
                                                    <div class="item ">
                                    					<a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                    					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                    					</a>
                                					</div>
                                    			</div>';
                                }
                               
                                
                                 
                                
                            }
                            echo '<div class="landing-banner-widget">'.$small.'</div><div class="landing-banner-widget">'.$big.'</div>';
                    ?>
                </div>  
            </div>
         <?php } } ?>
    </div>
<?php   } ?>
</br/>

 <?php if(!empty($getRecentAddProduct)){ ?>
<div class="container">
        <div class="row">
            <div class="col-main col-sm-12 col-xs-12">
                <div class="shop-inner">
                    <div class="page-title">
                        <h2><?=$this->lang->line("Recent Product")?></h2>
                    </div>
                    <div class="product-grid-area">
                        <ul class="products-grid">
                            <?php
                            foreach ($getRecentAddProduct as $key => $value):
                                
                                $category_id        = $value['category_id'];
                                $category_title     = $value['title'];
                                $product_id         = $value['product_id'];
                                $stock       	    = $value['in_stock'];
                                $dataCount = 0;
                                $dataCounthtml = '';
                                $buttonLang    = $this->lang->line('Add To Cart');
                                if(!empty($product_arr)){
                                    foreach ($product_arr as $key => $product_session) {
                                        if (in_array($product_id, $product_session)) {
                                            $dataCount       =  $product_session['buy_qty'];
                                            $dataCounthtml   = '<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">'.$dataCount.'</span></a></div>';
                                            $buttonLang      = $this->lang->line('Added To Cart');
                                        }
                                    }
                                }
                                $pro1               = explode(',',$value['product_image']);
                                $product_image      = $product_img_url. $pro1[0];
                                $product_name       = $value['product_name'];
                                $product_wishlist   = $value['wishlist'];
                                
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
                                
                            
							    $product_type       = $value['product_type'];
    							$product_call       = $value['product_call'];
    							$product_slug       = $value['product_slug'];
    							$in_stock           = $value['in_stock'];
							    $stock              = $variants_pro[0]['stock_inv'];
    							
    							
    							$outofstock         =   '';
    							//if($stock < 1 || empty($in_stock)){
                                //if($in_stock < 1 && empty($q_variants)){
                                if($stock < 1 || empty($in_stock)){
                                    
                                    $buttonLang     =   $this->lang->line('Out Of Stock'); 
                                    $outofstock     =   '<div class="out_stock"><img src="'.$this->config->item('base_url').'assets/images/out-of-stock1.png"></div>';
                                }
    							
    							$q                  = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$variants_pro[0]['varient_id']."'  AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
    							$del_price          = $q->row();
    							$offerdiv           =   '';
    							if(!empty($del_price)){
    								$difference_price   = $variants_pro[0]['mrp'] - $del_price->deal_price;	
    								if($difference_price > 0){
    								    $percent        =   round(($difference_price*100)/ $variants_pro[0]['mrp'],2);
    								    $offerdiv       =   '<div class="save-prices">GET <span class="ng-binding">'.$percent.'</span>% OFF <span class="asterisk-icon"></span></div>';
    								}
    								$product_price      = number_format((float)$del_price->deal_price, 2, '.', '');
    								$single_price       = $del_price->deal_price;
    							} else {
    								$difference_price   = $variants_pro[0]['mrp'] - $variants_pro[0]['price'];
    								if($difference_price > 0){
    								    $percent        =   round(($difference_price*100)/ $variants_pro[0]['mrp'],2);
    								    $offerdiv       =   '<div class="save-prices">GET <span class="ng-binding">'.$percent.'</span>% OFF <span class="asterisk-icon"></span></div>';
    								}
    								$product_price      = number_format((float)$variants_pro[0]['price'], 2, '.', '');
    								$single_price       = $variants_pro[0]['price'];
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
    							
                            ?>
                            <li class="<?=$classses?>">
                                <div class="product-item">
                                    <div class="item-inner"  style="<?=!empty($in_stock) &&  $stock >= 1 ? '' : 'opacity: .3;' ?>">
                                        <div class="product-thumbnail">
                                            <div class="icon-new-label">
                                                <?php echo  $product_call == 1 ? '<img src="'.$this->config->item('base_url').'assets/images/swadeshi.png">' :''; ?>
                                            </div>
                                            <span class="<?=$class?> ng-scope" title="<?=$title?>" ng-if="vm.selectedProduct.p_type === '<?=$p_type?>' ">&nbsp;</span>
                                            <div class="pr-img-area"> 
                                                <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>">
                                                    <figure> 
                                                        <img class="first-img lazyOwl" id="pro_img2_<?=$product_id?>" height="225" width="225"
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
                                        <?php if(!empty($in_stock) && $stock >= 1){
                                            echo $offerdiv;
                                        
                                        } ?>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"> 
                                                    <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>"><?= $product_name ?></a> <a  style="height: 19px;" class="product-listing__save--price <?php echo "fl2_" . $eleid; ?>"><?=$flavor?></a>
                                                </div>
                                                <div class="item-content">
                                                    <div class="item-price">
                                                        <div class="price-box">
                                                            <div id="product-listingsave<?=$eleid?>">
                                                                <?php if($dataCount <=0 && $difference_price > 0){ ?>
                                                                    <div data-id="<?=$difference_price?>" class="product-listing__save">save <span class="product-listing__save--price"><?=$this->config->item('currency')?><span class="save-price" id="<?php echo "diffid2_" . $eleid; ?>"><?=$difference_price?></span></span></div>
                                                                <?php } elseif($dataCount > 0){
                                                                    echo $dataCounthtml;
                                                                } ?>
                                                            </div>
                                                            <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"  id="<?php echo "id2_" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_price ?></span></span> </p>
                                                            <!-- <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price" id="<?php echo "regid2_" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_mrp ?>/- </span> </p> -->
                                                            <div id="<?php echo "stock_2" . $eleid; ?>" style="float:right;">Stock <?=$stock?></div>
                                                        </div>
                                                        <!--<div><span class="price-label">You Save:</span> <span class="small" id="<?php echo "diffid" . $eleid; ?>"><?=$difference_price?></span></div>-->
                                                        
                                                                    <select class="form-control recent_product sss"
                                                                                    id="<?php echo $product_id; ?>">
                                                                                <?php
                                                                                    foreach ($variants_pro as $key => $valuess) {
                                                                                        
                                                            								$product_price_v = number_format((float)$valuess['price'], 2, '.', '');
                                                            								$product_mrp_v = number_format((float)$valuess['mrp'], 2, '.', '');
                                                            								$q_v = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$valuess['varient_id']."'  AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
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
                                                                                            $stocks      = $valuess['stock_inv'];
                                                            							
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
                                                                                                data-stock = "<?php echo $valuess['stock_inv']; ?>"
                                                                                                data-single = "<?=$single_price_v?>">  <?php echo $valuess['qty']." ".$valuess['unit']; ?> - <?=$this->config->item('currency').' '.$product_price_v?> </option>
                                        
                                                                                        <?php
                                                                                    }
                                                                                
                                                                                ?>
                                                                            </select>
                                                    </div>
                                                    <div class="pro-action">
                                                            <input type="hidden" name="product_id" id="product_id2_<?=$product_id?>" value="<?=$product_id?>">
                                                            <input type="hidden" name="product_varient_id" id="product_varient_id2_<?=$product_id?>" value="<?=$varientid?>">
                                                            <input type="hidden" name="price" id="price2_<?=$product_id?>" value="<?=$single_price?>" class="priceee">
                                                            <input type="hidden" name="unit" id="unit2_<?=$product_id?>" value="<?=$product_unit_value?>" class="units">
                                                            <input type="hidden" name="unit_value" id="unit_value2_<?=$product_id?>" value="<?=$product_unit?>" class="unit_value">
                                                            <input type="hidden" name="qty" id="qty2_<?=$product_id?>" value="1" class="qty">
                                                            <button type="submit" class="add-to-cartss" <?=!empty($in_stock)  && $stock >= 1 ? '' : 'disabled' ?> id="cart2_<?=$product_id?>" data-id="<?=$product_id?>"><i class="fa fa-shopping-basket"></i><span> <?=$buttonLang?></span></button> </a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?> 

<br/>
<?php
$type_name = $this->db->query('SELECT feature_slider_type.type_id, feature_slider_type.type_name FROM  feature_slider_type
                                    INNER JOIN feature_slider ON feature_slider.slider_title = feature_slider_type.type_id
                                    WHERE feature_slider.banner_type = 2 AND feature_slider.slider_status=1 AND feature_slider.trash =0 group by feature_slider_type.type_id LIMIT 1')->result_array();
?>
<?php if(!empty($type_name)){ ?>   
    <div class="container">
        <?php foreach($type_name as $rows){   
            $sql_cat = "SELECT 
                    feature_slider.id as id,
                    feature_slider.image_type as image_type,
                    feature_slider.slider_title as slider_title,
                    feature_slider.slider_url as slider_url,
                    feature_slider.slider_image as slider_image,
                    feature_slider.sub_cat as sub_cat,
                    feature_slider.sub_type,
                    feature_slider.slider_status as slider_status,
                    feature_slider.banner_type,
                    categories.title as cat_title,
                    tbl_brand.title as brand_title,
                    products.product_name as product_name,
                    categories.slug as slug,
                    tbl_brand.slug as brand_slug,
                    products.product_slug as product_slug
                    FROM feature_slider 
                    LEFT JOIN categories ON categories.id = feature_slider.sub_cat AND categories.status = 1 AND feature_slider.sub_type='category'
                    LEFT JOIN tbl_brand  ON tbl_brand.id = feature_slider.sub_cat AND tbl_brand.status = 1 AND feature_slider.sub_type='brand'
                    LEFT JOIN products  ON products.product_id = feature_slider.sub_cat AND products.trash = 0 AND feature_slider.sub_type='product'
                        WHERE feature_slider.slider_title = '" . $rows['type_id'] . "' AND feature_slider.banner_type='2' AND feature_slider.slider_status=1 AND feature_slider.trash =0";
                        //echo $sql_cat; exit;
            $q4 = $this->db->query($sql_cat);
            if($q4->num_rows() > 0){
        ?>
            <div class="col-md-12 col-xs-12"> 
                <div class="row">
                    <div class="page-header">
                        <h2><?=$rows['type_name'];?></h2>
                    </div>
                     <?php
                        //var_dump($getCategoriesShort);
                            
                            $slider = $q4->result_array();
                            $smallss  = '';
                            foreach($slider as $row){
                                if($row['sub_type'] == 'category'){
                                    $href   =   base_url()."search?slug=".$row['slug']."&search=";
                                }elseif($row['sub_type'] == 'brand'){
                                    $href   =   base_url()."search?slug=".$row['brand_slug']."&search=";
                                }elseif($row['sub_type'] == 'product'){
                                    $href   =   base_url()."search?slug=".$row['product_slug']."&search=";
                                }
                                $href       =   $href.'&type='.$row['sub_type'];
                                $image  =   base_url().$this->config->item('images_url').'sliders/'.$row['slider_image'];
                                if($row['image_type'] == 1 || $row['image_type'] == 0){
                                    $smallss    .=   '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 col ng-scope mt-5">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12 col-xs-12 col">
                                            					<a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                            					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                            					</a>
                                            				</div>
                                            			</div>
                                    			</div>';
                                }
                                
                               
                                
                                 
                                
                            }
                            echo '<div class="landing-banner-widget">'.$smallss.'</div>';
                    ?>
                    
               
               
                </div>  
            </div>
         <?php } } ?>
    </div>
<?php } ?>
<br/>

<?php

    $type_name = $this->db->query('SELECT feature_slider_type.type_id, feature_slider_type.type_name FROM  feature_slider_type
                                    INNER JOIN feature_slider ON feature_slider.slider_title = feature_slider_type.type_id
                                    WHERE feature_slider.banner_type = 1 AND feature_slider.slider_status=1 AND feature_slider.trash =0 group by feature_slider_type.type_id')->result_array();
?>
<?php if(!empty($type_name)){ ?>   
    <div class="container">
        <?php foreach($type_name as $rows){   
            $sql_cat = "SELECT 
                    feature_slider.id as id,
                    feature_slider.image_type as image_type,
                    feature_slider.slider_title as slider_title,
                    feature_slider.slider_url as slider_url,
                    feature_slider.slider_image as slider_image,
                    feature_slider.sub_cat as sub_cat,
                    feature_slider.sub_type,
                    feature_slider.slider_status as slider_status,
                    feature_slider.banner_type,
                    categories.title as cat_title,
                    tbl_brand.title as brand_title,
                    products.product_name as product_name,
                    categories.slug as slug,
                    tbl_brand.slug as brand_slug,
                    products.product_slug as product_slug
                    FROM feature_slider 
                    LEFT JOIN categories ON categories.id = feature_slider.sub_cat AND categories.status = 1 AND feature_slider.sub_type='category'
                    LEFT JOIN tbl_brand  ON tbl_brand.id = feature_slider.sub_cat AND tbl_brand.status = 1 AND feature_slider.sub_type='brand'
                    LEFT JOIN products  ON products.product_id = feature_slider.sub_cat AND products.trash = 0 AND feature_slider.sub_type='product'
                        WHERE feature_slider.slider_title = '" . $rows['type_id'] . "' AND feature_slider.banner_type='1' AND feature_slider.slider_status=1 AND feature_slider.trash =0";
                //echo $sql_cat; exit;
            $q3 = $this->db->query($sql_cat);
        
            if($q3->num_rows() > 0){
        ?>
            <div class="col-md-12 col-xs-12"> 
                <div class="row">
                    <div class="page-header">
                        <h2><?=$rows['type_name'];?></h2>
                    </div>
                    <?php
                        //var_dump($getCategoriesShort);
                           
                            $slider = $q3->result_array();
                            $smalls  = '';
                            $bigs    = '';
                            foreach($slider as $row){
                                if($row['sub_type'] == 'category'){
                                    $href   =   base_url()."search?slug=".$row['slug']."&search=";
                                }elseif($row['sub_type'] == 'brand'){
                                    $href   =   base_url()."search?slug=".$row['brand_slug']."&search=";
                                }elseif($row['sub_type'] == 'product'){
                                    $href   =   base_url()."search?slug=".$row['product_slug']."&search=";
                                }
                                $href       =   $href.'&type='.$row['sub_type'];
                                $image  =   base_url().$this->config->item('images_url').'sliders/'.$row['slider_image'];
                                if($row['image_type'] == 1){
                                    $smalls    .=   '<div class="col-md-3 col-sm-4 col-xs-6">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12 col-xs-12 col">
                                            					<a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                            					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                            					</a>
                                            				</div>
                                            			</div>
                                    			    </div>';
                                }
                                else if($row['image_type'] == 0){
                                    $bigs    .=   '<div class="col-md-6 col-sm-8 col-xs-12 col">
                                    					<a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                    					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                    					</a>
                                    			    </div>';
                                }
                               
                                
                                 
                                
                            }
                            echo '<div class="landing-banner-widget">'.$bigs.'</div><div class="landing-banner-widget">'.$smalls.'</div>';
                    ?>

                </div>  
            </div>
         <?php } } ?>
    </div>
<?php  } ?>
<br/>
<?php
//print_r($getDealProducts); exit;
if(!empty($getDealProducts)){
?>
<div class="main-container col1-layout">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12">
                <div class="home-tab">
                    <ul class="nav home-nav-tabs home-product-tabs" style="padding: 10px;">
                        <li class="active"><a href="#featured" data-toggle="tab" aria-expanded="false"><?=$this->lang->line("Today Best Offer")?></a></li>
                        <li class="divider"></li>
                        <!--                        <li> <a href="#top-sellers" data-toggle="tab" aria-expanded="false">Top Sellers</a> </li>-->
                    </ul>
                    <div id="productTabContent" class="tab-content">
                        <div class="tab-pane active in" id="featured">
                            <div class="featured-pro">
                                <div class="slider-items-products">
                                    <div id="featured-slider" class="product-flexslider hidden-buttons">
                                        <div class="slider-items slider-width-col4">
                                            <?php 
                                            foreach ($getDealProducts as $key => $value):
                                                $category_id        = $value['category_id'];
                                                $category_title     = $value['title'];
                                                $product_id         = $value['product_id'];
                                                $dataCount = 0;
                                                $dataCounthtml = '';
                                                $buttonLang     = $this->lang->line('Add To Cart');
                                                if(!empty($product_arr)){
                                                    foreach ($product_arr as $key => $product_session) {
                                                        if (in_array($product_id, $product_session)) {
                                                           $dataCount        = $product_session['buy_qty'];
                                                            $dataCounthtml   = '<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">'.$dataCount.'</span></a></div>';
                                                            $buttonLang      = $this->lang->line('Added To Cart');
                                                            
                                                        }
                                                    }
                                                }
                                                
                                                
                                                
                                                $pro1               = explode(',',$value['product_image']);
                                                $product_image      = $product_img_url . $pro1[0];
                                                $product_wishlist   = $value['wishlist'];
                                               // echo $product_img_url; die;
                                                $product_name       = $value['product_name'];
                                                $filter             = '';
                                                $varientid          = '';
                                                if(!empty($value['varient_id'])){
                                                    $varientid      =   $value['varient_id'];
                                                    $filter         =   " AND pro_var_id='".$value['varient_id']."'";
                                                }
                                                $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."' and stock_inv>0 ".$filter."");
                    							$variants_pro       = $q_variants->result_array();
                                            
                                                if(empty($variants_pro))
                                                {
                                                    $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."'");
                                                     $variants_pro       = $q_variants->result_array();
                                                }
                             
                    							//print_r($variants_pro);
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
                                                
                                                $product_type       = $value['product_type'];
                                                $product_call       = $value['product_call'];
                                                $product_slug       = $value['product_slug'];
                                                
												$dealprice_price    = $value['deal_price'];
												$offerdiv           =   '';
												//echo $dealprice_price;
												if(!empty($dealprice_price)){
                    								$difference_price   = $variants_pro[0]['mrp'] - $dealprice_price;	
                    								$product_price      = number_format((float)$dealprice_price, 2, '.', '');
                    								$single_price       = $dealprice_price;
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
                                                $start_time             = $value['start_time'];
                                                $end_time               = $value['end_time'];
                                                $in_stock               = $value['in_stock'];
							                    $stock                  = $variants_pro[0]['stock_inv'];
                                                
                                                $outofstock             =   '';
                                                //if($stock < 1 || empty($in_stock)){
                                                //if($in_stock < 1 && empty($q_variants)){
                                                if($stock < 1 || empty($in_stock)){
                                                    $buttonLang     =   $this->lang->line('Out Of Stock'); 
                                                    $outofstock     =   '<div class="out_stock"><img src="'.$this->config->item('base_url').'assets/images/out-of-stock1.png"></div>';
                                                }
												
                                                $present_time           = date('d-m-Y H:i ', time());
												$enddate                = $value['end_date']. " " .$value['end_time'];
												$test                   = str_replace("/","-",$enddate);
												$status ='';
												if(strtotime($present_time) <= strtotime($test)){ 
												    $status = 1; //running 
												}
                                                else { 
                                                    $status = 0; //expired
												    continue;
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
                                                
                                                ?>

                                                <div class="product-item">
                                                    <div class="item-inner"  style="<?=!empty($in_stock)  && $stock >= 1 ? '' : 'opacity: .3;' ?>">
                                                        <div class="product-thumbnail">
                                                            <div class="icon-new-label">
                                                                <?php echo  $product_call == 1 ? '<img src="'.$this->config->item('base_url').'assets/images/swadeshi.png">' :''; ?>
                                                            </div>
                                                            <span class="<?=$class?> ng-scope" title="<?=$title?>" ng-if="vm.selectedProduct.p_type === '<?=$p_type?>' ">&nbsp;</span>
                                                            <div class="pr-img-area"> 
                                                                <a title="<?= $product_name ?>" href="{base_url}product/<?= $product_slug ?>">
                                                                    <figure> 
                                                                        <img class="first-img lazyOwl" id="pro_img_<?=$product_id?>" height="225" width="225"
                                                                             data-src="<?= $product_image ?>" alt=""> 
                                                                        <!--<img class="hover-img lazy" height="225" width="225"-->
                                                                        <!--     data-src="<?= $product_image ?>" alt="">-->
                                                                    </figure></a> 
                                                            </div>
                                                            <?=$outofstock?>
                    <!--                                        <div class="pr-info-area">-->
                    <!--                                            <div class="pr-button">-->
                    <!--                                                <div class="mt-button add_to_wishlist">-->
                    <!--                                                        <a href="{base_url}wishlist"> <i class="fa fa-heart"></i> </a> -->
                    <!--                                                </div>-->
                    <!--                                                <div class="mt-button quick-view"> <a href="{base_url}product/<?= $product_id ?>"> <i class="fa fa-link"></i> </a> </div>-->
                    <!--                                                <div class="mt-button add_to_compare"> -->
                        <!--                                                        <a href="{base_url}compare"> <i class="fa fa-signal"></i> </a> -->
                    <!--                                                </div>-->
                    <!--                                            </div>-->
                    <!--                                        </div>-->
                                                        </div>
                                                        <?php if(!empty($in_stock) && $stock >= 1){
                                                                echo $offerdiv;
                                                            
                                                            } ?>
                                                        <div class="item-info">
                                                            <div class="info-inner">
                                                                <div class="item-title"> 
                                                                    <a title="<?= $product_name ?>" href="{base_url}product/<?= $product_slug ?>"><?= $product_name ?></a>  <a  style="height: 19px;" class="product-listing__save--price <?php echo "fl_" . $eleid; ?>"><?=$flavor?></a></div>
                                                                <div class="item-content">
    <!--                                                                    <div class="rating"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>-->
                                                                    <div class="item-price">
                                                                        <div class="price-box">
                                                                            <div id="product-listingsave<?=$eleid?>">
                                                                                <?php if($dataCount <=0 && $difference_price > 0){ ?>
                                                                                <div data-id="<?=$difference_price?>" class="product-listing__save ">save <span class="product-listing__save--price"><?=$this->config->item('currency')?><span class="save-price" id="<?php echo "diffid_" . $eleid; ?>"><?=$difference_price?></span></span></div>
                                                                                <?php } elseif($dataCount > 0){
                                                                                    echo $dataCounthtml;
                                                                                } ?>
                                                                            </div>
                                                                            <p class="special-price"> <span class="price-label">Deal Price</span> <span class="price" id="<?php echo "id_" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_price ?></span> </p>
                                                                            <!-- <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price" id="<?php echo "regid_" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_mrp ?>/- </span> </p> -->
                                                                            <div id="<?php echo "stock_" . $eleid; ?>" style="float:right;">Stock <?=$stock?></div>
                                                                        </div>

                                                                        <select class="form-control change_option sss" id="<?php echo $product_id; ?>">
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
                                                        							//	$difference_price_s = $product_mrp - $product_price;
                                                        								$images     =   !empty($valuess['pro_var_images']) ? base_url().'backend/uploads/products/'.$valuess['pro_var_images'] : '';
                                                        							    $stocks      = $valuess['stock_inv'];
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
                                                                                            data-stock = "<?php echo $valuess['stock_inv']; ?>"
                                                                                            data-single = "<?=$single_price_v?>">  <?php echo $valuess['qty']." ".$valuess['unit']; ?> - <?=$this->config->item('currency').' '.$product_price_v?> </option>
                                    
                                                                                    <?php
                                                                                }
                                                                            
                                                                            ?>
                                                                        </select>
                                                                        
                                                                    </div>
                                                                    <div class="pro-action">
                                                                        <input type="hidden" name="product_id" id="product_id_<?=$product_id?>" value="<?=$product_id?>">
                                                                        <input type="hidden" name="product_varient_id" id="product_varient_id_<?=$product_id?>" value="<?=$varientid?>">
                                                                        <input type="hidden" name="price" id="price_<?=$product_id?>" value="<?=$single_price?>" class="priceee">
                                                                        <input type="hidden" name="unit" id="unit_<?=$product_id?>" value="<?=$product_unit_value?>" class="units">
                                                                        <input type="hidden" name="unit_value" id="unit_value_<?=$product_id?>" value="<?=$product_unit?>" class="unit_value">
                                                                        <input type="hidden" name="qty" id="qty_<?=$product_id?>" value="1" class="qty">
                                                                        <button type="submit" class="add-to-cart" <?=!empty($in_stock)  && $stock >= 1 ? '' : 'disabled' ?> id="cart_<?=$product_id?>" data-id="<?=$product_id?>"><i class="fa fa-shopping-basket"></i><span> <?=$buttonLang?></span></button>
                                                                        <div class="product-listing__quantity--add">
                                                                            <a href="javascript:void(0)" id="<?=$product_id?>" class="add_to_wishlist button-icon-white" > <i class="fa fa-heart" id="das_<?=$product_id?>"  style="<?=!empty($whishlist) ? 'color:red' :'color:black'?>"></i> </a>  
                                                                        </div>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            endforeach;
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php /*<div class="tab-pane fade" id="top-sellers">
                            <div class="top-sellers-pro">
                                <div class="slider-items-products">
                                    <div id="top-sellers-slider" class="product-flexslider hidden-buttons">
                                        <div class="slider-items slider-width-col4 ">
                                            <?php
                                            foreach ($getTopSellingProducts as $key => $value):
                                                $category_id = $value['category_id'];
                                                $category_title = $value['title'];
                                                $product_image = "../backend/uploads/products/" . $value['product_image'];
                                                $product_name = $value['product_name'];
                                                $product_unit = $value['unit'];
                                                $product_mrp = $value['mrp'];
                                                $product_price = $value['price'];
                                                $difference_price = $value['difference_price'];
                                                ?>

                                                <div class="product-item">
                                                    <div class="item-inner">
                                                        <div class="product-thumbnail">
                                                            <div class="icon-sale-label sale-left">Sale</div>
                                                            <div class="icon-new-label new-right">New</div>
                                                            <div class="pr-img-area"> <a title="Ipsums Dolors Untra" href="{base_url}product/<?= $product_id ?>">
                                                                    <figure> 
                                                                        <img class="first-img  lazyOwl" height="225" width="225"
                                                                             data-src="<?= $product_image ?>" alt=""> 
                                                                        <img class="hover-img lazy" height="225" width="225"
                                                                             data-src="<?= $product_image ?>" alt="">
                                                                    </figure>
                                                                </a> </div>
                                                            <div class="pr-info-area">
                                                                <div class="pr-button">
                                                                    <div class="mt-button add_to_wishlist"> <a href="wishlist.php"> <i class="fa fa-heart"></i> </a> </div>
                                                                    <div class="mt-button add_to_compare"> <a href="compare.php"> <i class="fa fa-signal"></i> </a> </div>
                                                                    <div class="mt-button quick-view"> <a href="quick_view.php"> <i class="fa fa-link"></i> </a> </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="item-info">
                                                            <div class="info-inner">
                                                                <div class="item-title"> <a title="Ipsums Dolors Untra" href="{base_url}product/<?= $product_id ?>">Ipsums Dolors Untra </a> </div>
                                                                <div class="item-content">
                                                                    <div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
                                                                    <div class="item-price">
                                                                        <div class="price-box"> <span class="regular-price"> <span class="price">$125.00</span> </span> </div>
                                                                    </div>
                                                                    <div class="pro-action">
                                                                        <a href="{base_url}product/<?= $product_id ?>"><button type="button" class="add-to-cart"><i class="fa fa-shopping-basket"></i><span> Add to Cart</span></button> </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            endforeach;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> */?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
} ?>

<?php
    $type_name = $this->db->query('SELECT feature_slider_type.type_id, feature_slider_type.type_name FROM  feature_slider_type
                                    INNER JOIN feature_slider ON feature_slider.slider_title = feature_slider_type.type_id
                                    WHERE feature_slider.banner_type = 3 AND feature_slider.slider_status=1 AND feature_slider.trash =0 group by feature_slider_type.type_id ORDER BY feature_slider_type.type_id LIMIT 3,20')->result_array();
?>
<?php if(!empty($type_name)){ 
    
?>   
    <div class="container">
        <?php foreach($type_name as $rowsx){   
            $sql_cat = "SELECT 
                    feature_slider.id as id,
                    feature_slider.image_type as image_type,
                    feature_slider.slider_title as slider_title,
                    feature_slider.slider_url as slider_url,
                    feature_slider.slider_image as slider_image,
                    feature_slider.sub_cat as sub_cat,
                    feature_slider.sub_type,
                    feature_slider.slider_status as slider_status,
                    feature_slider.banner_type,
                    categories.title as cat_title,
                    tbl_brand.title as brand_title,
                    products.product_name as product_name,
                    categories.slug as slug,
                    tbl_brand.slug as brand_slug,
                    products.product_slug as product_slug
                    FROM feature_slider 
                    LEFT JOIN categories ON categories.id = feature_slider.sub_cat AND categories.status = 1 AND feature_slider.sub_type='category'
                    LEFT JOIN tbl_brand  ON tbl_brand.id = feature_slider.sub_cat AND tbl_brand.status = 1 AND feature_slider.sub_type='brand'
                    LEFT JOIN products  ON products.product_id = feature_slider.sub_cat AND products.trash = 0 AND feature_slider.sub_type='product'
                    WHERE feature_slider.slider_title = '" . $rowsx['type_id'] . "' AND feature_slider.banner_type='3' AND feature_slider.slider_status=1 AND feature_slider.trash =0";
                    //echo $sql_cat; exit;
            $q2 = $this->db->query($sql_cat);
            if($q2->num_rows() > 0){
        ?>
            <div class="col-md-12 col-xs-12"> 
                <div class="row">
                    <div class="page-header">
                        <h2><?=$rowsx['type_name'];?></h2>
                    </div>
                    <?php
                        //var_dump($getCategoriesShort);
                            
                            $slider = $q2->result_array();
                            $small  = '';
                            $big    = '';
                            foreach($slider as $row){
                                if($row['sub_type'] == 'category'){
                                    $href   =   base_url()."search?slug=".$row['slug']."&search=";
                                }elseif($row['sub_type'] == 'brand'){
                                    $href   =   base_url()."search?slug=".$row['brand_slug']."&search=";
                                }elseif($row['sub_type'] == 'product'){
                                    $href   =   base_url()."search?slug=".$row['product_slug']."&search=";
                                }
                                $href       =   $href.'&type='.$row['sub_type'];
                                $image  =   base_url().$this->config->item('images_url').'sliders/'.$row['slider_image'];
                                if($row['image_type'] == 1){
                                    $small    .=   '<div class="col-md-4 col-xs-12 lineart">
                                					<a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                					</a>
                                    			</div>';
                                }
                                else if($row['image_type'] == 0){
                                    $big    .=   '<div class="col-xs-12 mt-20">
                                                    <div class="item ">
                                    					<a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                    					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                    					</a>
                                					</div>
                                    			</div>';
                                }
                               
                                
                                 
                                
                            }
                            echo '<div class="landing-banner-widget">'.$small.'</div><div class="landing-banner-widget">'.$big.'</div>';
                    ?>
                </div>  
            </div>
         <?php } } ?>
    </div>
<?php   } ?>
</br/>

<style>
    select.form-control:not([size]):not([multiple]) {
    height: 3.5rem;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
     $(document).on('change', ".onsel", function (e) {
       debugger;
		e.preventDefault();
		var unit_value = $(this).find(':selected').val();
		var vid = $(this).find(':selected').data('vid');
		var idd = $(this).find(':selected').data('idd');
		var price = $(this).find(':selected').data('price');
		
		var mrp = $(this).find(':selected').data('mrp');
		var difference = $(this).find(':selected').data('difference');
		var units = $(this).find(':selected').data('units');
		var varient = $(this).find(':selected').data('varient');
		var single  = $(this).find(':selected').data('single');
		var image  = $(this).find(':selected').data('image');
        var stock  = $(this).find(':selected').data('stock');

		if(image !=''){
		    $('#pro_img'+idd).data('src',image);
		    $('#pro_img'+idd).attr('src',image);
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
		$(".fl" + idd).text($(this).find(':selected').data('flavor'));
        
            
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
        		data: {product_id:product_id,product_varient_id:varient_id,price:price,unit:unit,unit_value:unit_value,qty:qty,stock:stock},
        		dataType: "json",
        		success: function (response) {
                    debugger;
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