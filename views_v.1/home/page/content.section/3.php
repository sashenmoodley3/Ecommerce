<?php
if ($this->session->userdata("product")) {
    $product_arr = json_decode($this->session->userdata("product"), TRUE);
}
//print_r($getDealProducts); 
 if(!empty($getCategoryWiseProduct)){ 
     $i = 0;  $j = 1; 
    foreach ($getCategoryWiseProduct  as $keyvalue):
       if(!empty($keyvalue['product'])){
        
?>
<?php
    
    $type_name = $this->db->query('SELECT feature_slider_type.type_id, feature_slider_type.type_name FROM  feature_slider_type
                                    INNER JOIN feature_slider ON feature_slider.slider_title = feature_slider_type.type_id
                                    WHERE feature_slider.banner_type = 4 AND feature_slider.slider_status=1 AND feature_slider.trash =0 group by feature_slider_type.type_id LIMIT '.$j.', 1')->result_array();
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
                                WHERE feature_slider.slider_title = '" . $rows['type_id'] . "' AND feature_slider.banner_type='4' AND feature_slider.slider_status=1 AND feature_slider.trash =0";
                                //echo $sql_cat; exit;
                    $q5 = $this->db->query($sql_cat);
                    if($q5->num_rows() > 0){
                ?>
                    <div class="col-md-12 col-xs-12"> 
                        <div class="row">
                            <div class="page-header">
                                <h2><?=$rows['type_name'];?></h2>
                            </div>
                            <div class="col ng-scope mt-5">
                                <div class="row">
                                    <div id="latest-news-slider">
                                        <div class="slider-items">
                                            <?php
                                            //var_dump($getCategoriesShort);
                                                
                                                $slider = $q5->result_array();
                                                $smallsss  = '';
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
                                                        echo    '<div class="item" >
                                                                    <a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                                					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                                				    </a>
                                                				</div>';
                                                    }
                                                }
                                    
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                 <?php } } ?>
            <br/>
        </div>
        <?php } unset($type_name); ?>
    <div class="container">
        <div class="row">
            <div class="col-main col-sm-12 col-xs-12">
                <div class="shop-inner">
                    <div class="page-title">
                        <h2><?=$keyvalue['category_title']?> <?=$this->lang->line("Product")?></h2>
                    </div>
                    <div class="product-grid-area">
                        <ul class="products-grid">
                        <?php
                            foreach ($keyvalue['product'] as $key => $value):
                                //echo $i;
                               // print_r($value);
                                $category_id        = $value['category_id'];
                                $category_title     = $value['title'];
                                $product_id         = $value['product_id'];
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
                                $pro1               = explode(',',$value['product_image']);
                                $product_image      = $product_img_url. $pro1[0];
                                $product_name       = $value['product_name'];
                                $stock       	    = $value['stock'];
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
    							$outofstock         ='';
    							//if($stock < 1 && empty($in_stock)){
                                //if($in_stock < 1 && empty($q_variants)){
                                if($stock < 1 || empty($in_stock)){
                                    $buttonLang     =   $this->lang->line('Out Of Stock'); 
                                    $outofstock     =   '<div class="out_stock"><img src="'.$this->config->item('base_url').'assets/images/out-of-stock1.png"></div>';
                                }
    							
    							$q                  = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$variants_pro[0]['varient_id']."'  AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
    							$del_price          = $q->row();
    							$offerdiv           = '';
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
                            ?>
                            <li class="item col-lg-2 col-md-3 col-sm-6 col-xs-6 ">
                                <div class="product-item">
                                    <div class="item-inner" style="<?=!empty($in_stock)  &&  $stock >= 1 ? '' : 'opacity: .3;' ?>">
                                        <div class="product-thumbnail">
                                            <div class="icon-new-label">
                                                <?php echo  $product_call == 1 ? '<img src="'.$this->config->item('base_url').'assets/images/swadeshi.png">' :''; ?>
                                            </div>
                                            <span class="<?=$class?> ng-scope" title="<?=$title?>" ng-if="vm.selectedProduct.p_type === '<?=$p_type?>' ">&nbsp;</span>
                                            <div class="pr-img-area"> 
                                                <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>">
                                                    <figure> 
                                                        <img class="first-img lazyOwl" id="pro_img3_<?=$product_id?>" height="225" width="225"
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
                                                    <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>"><?= $product_name ?></a><a  style="height: 19px;" class="product-listing__save--price <?php echo "fl3_" . $eleid; ?>"><?=$flavor?></a>
                                                </div>
                                                <div class="item-content">
                                                    <div class="item-price">
                                                        <div class="price-box">
                                                            <div id="product-listingsave<?=$eleid?>">
                                                                <?php if($dataCount <=0 && $difference_price > 0){ ?>
                                                                    <div data-id="<?=$difference_price?>" class="product-listing__save">save <span class="product-listing__save--price"><?=$this->config->item('currency')?><span class="save-price" id="<?php echo "diffid3_" . $eleid; ?>"><?=$difference_price?></span></span></div>
                                                                <?php } elseif($dataCount > 0){
                                                                    echo $dataCounthtml;
                                                                } ?>
                                                            </div>
                                                            <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"  id="<?php echo "id3_" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_price ?></span></span> </p>
                                                            <!-- <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price" id="<?php echo "regid3_" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_mrp ?>/- </span> </p> -->
                                                        </div>
                                                        <!--<div><span class="price-label">You Save:</span> <span class="small" id="<?php echo "diffid" . $eleid; ?>"><?=$difference_price?></span></div>-->
                                                        
                                                                    <select class="form-control recent_products sss"
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
                                                            <input type="hidden" name="product_id" id="product_id3_<?=$product_id?>" value="<?=$product_id?>">
                                                            <input type="hidden" name="product_varient_id" id="product_varient_id3_<?=$product_id?>" value="<?=$varientid?>">
                                                            <input type="hidden" name="price" id="price3_<?=$product_id?>" value="<?=$single_price?>" class="priceee">
                                                            <input type="hidden" name="unit" id="unit3_<?=$product_id?>" value="<?=$product_unit_value?>" class="units">
                                                            <input type="hidden" name="unit_value" id="unit_value3_<?=$product_id?>" value="<?=$product_unit?>" class="unit_value">
                                                            <input type="hidden" name="qty" id="qty3_<?=$product_id?>" value="1" class="qty">
                                                            <button type="submit" class="add-to-cartsss" <?=!empty($in_stock) && $stock >= 1 ?  '' : 'disabled' ?> id="cart3_<?=$product_id?>" data-id="<?=$product_id?>"><i class="fa fa-shopping-basket"></i><span> <?=$buttonLang?></span></button> </a>
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
                            
                            
                            
                            
                            <?php $i = $i+1; endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } $j =  $j+1; endforeach;  } ?>


<?php
    $type_name = $this->db->query('SELECT feature_slider_type.type_id, feature_slider_type.type_name FROM  feature_slider_type
                                    INNER JOIN feature_slider ON feature_slider.slider_title = feature_slider_type.type_id
                                    WHERE feature_slider.banner_type = 4 AND feature_slider.slider_status=1 AND feature_slider.trash =0 group by feature_slider_type.type_id LIMIT 1')->result_array();
?>
<?php if(!empty($type_name)){ ?>   
<br/>
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
                        WHERE feature_slider.slider_title = '" . $rows['type_id'] . "' AND feature_slider.banner_type='4' AND feature_slider.slider_status=1 AND feature_slider.trash =0";
                        //echo $sql_cat; exit;
            $q5 = $this->db->query($sql_cat);
            if($q5->num_rows() > 0){
        ?>
            <div class="col-md-12 col-xs-12"> 
                <div class="row">
                    <div class="page-header">
                        <h2><?=$rows['type_name'];?></h2>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col ng-scope mt-5">
                        <div class="row">
                            <div id="latest-news-slider">
                                <div class="slider-items">
                                    <?php
                                    //var_dump($getCategoriesShort);
                                        
                                        $slider = $q5->result_array();
                                        $smallsss  = '';
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
                                                echo    '<div class="item" >
                                                            <a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                        					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'">
                                        				    </a>
                                        				</div>';
                                            }
                                        }
                            
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
               
               
                </div>  
            </div>
         <?php } } ?>
    </div>
<?php } ?>
<br/>

<?php
    $type_name = $this->db->query('SELECT feature_slider_type.type_id, feature_slider_type.type_name FROM  feature_slider_type
                                    INNER JOIN feature_slider ON feature_slider.slider_title = feature_slider_type.type_id
                                    WHERE feature_slider.banner_type = 5 AND feature_slider.slider_status=1 AND feature_slider.trash =0 group by feature_slider_type.type_id')->result_array();
?>

<?php if(count($type_name) > 0){ ?>   
    <div class="container">
        <?php  foreach($type_name as $rows){   
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
                        WHERE feature_slider.slider_title = '" . $rows['type_id'] . "' AND feature_slider.banner_type='5' AND feature_slider.slider_status=1 AND feature_slider.trash =0";
                        //echo $sql_cat; exit;
            $q1 = $this->db->query($sql_cat);
            //echo $q->num_rows(); 
            if($q1->num_rows() > 0){
        ?>
            <div class="col-md-12 col-xs-12"> 
                <div class="row">
                    <div class="page-header">
                        <h2><?=$rows['type_name'];?></h2>
                    </div>
                    <?php
                        //var_dump($getCategoriesShort);
                            
                                $slider = $q1->result_array();
                                $bigd    = '';
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
                                        $bigd    .=   '<div class="col-md-6 col-xs-6 mt-20">
                                        					<a href="'.$href.'" title="'.$row['cat_title'].'" class="">
                                        					    <img class="img-responsive desktop-banner" src="'.$image.'" alt="'.$row['cat_title'].'" ">
                                        					</a>
                                        			</div>';
                                    }
                                   
                                    
                                     
                                    
                                }
                                echo '<div class="landing-banner-widget">'.$bigd.'</div>';
                    ?>
                </div>  
            </div>
         <?php } } ?>
    </div>
<?php   } ?>
<br/>





<style>
    select.form-control:not([size]):not([multiple]) {
    height: 3.5rem;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
     $(document).on('change', ".change_option", function (e) {
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

		if(image !=''){
		    $('#pro_img_'+idd).data('src',image);
		    $('#pro_img_'+idd).attr('src',image);
		}
		
		$('#product_id_'+ idd).val(idd);
		$('#product_varient_id_'+ idd).val(varient);
		$('#price_'+ idd).val(single);
		$('#unit_'+ idd).val(unit_value);
		$('#unit_value_'+ idd).val(units);

		$("#id_" + idd).text("<?=$this->config->item('currency')?> "+price+"/-");
		
		$("#regid_" + idd).text("<?=$this->config->item('currency')?> "+mrp+"/-");
		$("#diffid_" + idd).text(difference);
		$(".fl_" + idd).text($(this).find(':selected').data('flavor'));

            
    });
    $(document).on('click','.add-to-cart', function(e){
        debugger;
        e.preventDefault();
        var product_id  =   $(this).data('id');
        var varient_id  =   $('#product_varient_id_'+product_id).val();
        var price       =   $('#price_'+product_id).val();
        var unit        =   $('#unit_'+product_id).val();
        var unit_value  =   $('#unit_value_'+product_id).val();
        var qty         =   $('#qty_'+product_id).val();
        var stock       =   parseInt($('#stock_'+product_id).html().replace(/[^0-9]/g, ''));

        if(product_id !='' && varient_id !=''){
            $(this).find('i').removeClass('fa fa-shopping-basket').addClass('icon-loader');
            console.log(product_id+' >> '+varient_id+' >> '+price+' >> '+unit+' >> '+unit_value+' >> '+qty);
            $.ajax({
        		type: "post",
        		url: "{base_url}add_cart",
        		data: {product_id:product_id,product_varient_id:varient_id,price:price,unit:unit,unit_value:unit_value,qty:qty,stock:stock},
        		dataType: "json",
        		success: function (response) {
        		     $('#cart_'+product_id).find('i').removeClass('icon-loader').addClass('fa fa-shopping-basket');
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
        		     $.notify({
                    	message: 'Product <?=$this->lang->line('Added To Cart');?>'
                    },{
                    	type: 'success',
                    	placement: {
                    		from: "bottom",
                    		align: "right"
                    	},
                    });
        		     
        		    //location.reload();
        		}
            });
        }
    });
    
    $(document).on('change', ".recent_product", function (e) {
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
		    $('#pro_img2_'+idd).data('src',image);
		    $('#pro_img2_'+idd).attr('src',image);
		}
		
        $("#stock_2"+idd).html("Stock " + stock);
		
		$('#product_id2_'+ idd).val(idd);
		$('#product_varient_id2_'+ idd).val(varient);
		$('#price2_'+ idd).val(single);
		$('#unit2_'+ idd).val(unit_value);
		$('#unit_value2_'+ idd).val(units);
		$("#id2_" + idd).text("<?=$this->config->item('currency')?> "+price+"/-");
		
		$("#regid2_" + idd).text("<?=$this->config->item('currency')?> "+mrp+"/-");
		$("#diffid2_" + idd).text(difference);
        $(".fl2_" + idd).text($(this).find(':selected').data('flavor'));
            
    });
    
    $(document).on('change', ".recent_products", function (e) {
       
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

		if(image !=''){
		    $('#pro_img3_'+idd).data('src',image);
		    $('#pro_img3_'+idd).attr('src',image);
		}
		$('#product_id3_'+ idd).val(idd);
		$('#product_varient_id3_'+ idd).val(varient);
		$('#price3_'+ idd).val(single);
		$('#unit3_'+ idd).val(unit_value);
		$('#unit_value3_'+ idd).val(units);

		$("#id3_" + idd).text("<?=$this->config->item('currency')?> "+price+"/-");
		
		$("#regid3_" + idd).text("<?=$this->config->item('currency')?> "+mrp+"/-");
		$("#diffid3_" + idd).text(difference);
		$(".fl3_" + idd).text($(this).find(':selected').data('flavor'));

            
    });
    
    $(document).on('click','.add-to-cartss', function(e){
        debugger;
        e.preventDefault();
        var bottons     =   $(this);    
        var product_id  =   $(this).data('id');
        var varient_id  =   $('#product_varient_id2_'+product_id).val();
        var price       =   $('#price2_'+product_id).val();
        var unit        =   $('#unit2_'+product_id).val();
        var unit_value  =   $('#unit_value2_'+product_id).val();
        var qty         =   $('#qty2_'+product_id).val();
        var stock       =   parseInt($('#stock_2'+product_id).html().replace(/[^0-9]/g, ''));

        if(product_id !='' && varient_id !=''){
            $(this).find('i').removeClass('fa fa-shopping-basket').addClass('icon-loader');
            $.ajax({
        		type: "post",
        		url: "{base_url}add_cart",
        		data: {product_id:product_id,product_varient_id:varient_id,price:price,unit:unit,unit_value:unit_value,qty:qty,stock:stock},
        		dataType: "json",
        		success: function (response) {
        		     $(bottons).find('i').removeClass('icon-loader').addClass('fa fa-shopping-basket');
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
        		     $.notify({
                    	message: 'Product <?=$this->lang->line('Added To Cart');?>'
                    },{
                    	type: 'success',
                    	placement: {
                    		from: "bottom",
                    		align: "right"
                    	},
                    });
        		    //location.reload();
        		}
            });
        }
    });
    
    $(document).on('click','.add-to-cartsss', function(e){
        debugger;
        e.preventDefault();
        var bottons     =   $(this);    
        var product_id  =   $(this).data('id');
        var varient_id  =   $('#product_varient_id3_'+product_id).val();
        var price       =   $('#price3_'+product_id).val();
        var unit        =   $('#unit3_'+product_id).val();
        var unit_value  =   $('#unit_value3_'+product_id).val();
        var qty         =   $('#qty3_'+product_id).val();
        var stock       =   parseInt($('#stock_'+product_id).html().replace(/[^0-9]/g, ''));

        if(product_id !='' && varient_id !=''){
            $(this).find('i').removeClass('fa fa-shopping-basket').addClass('icon-loader');
            $.ajax({
        		type: "post",
        		url: "{base_url}add_cart",
        		data: {product_id:product_id,product_varient_id:varient_id,price:price,unit:unit,unit_value:unit_value,qty:qty,stock:stock},
        		dataType: "json",
        		success: function (response) {
        		     $(bottons).find('i').removeClass('icon-loader').addClass('fa fa-shopping-basket');
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
        		     $.notify({
                    	message: 'Product <?=$this->lang->line('Added To Cart');?>'
                    },{
                    	type: 'success',
                    	placement: {
                    		from: "bottom",
                    		align: "right"
                    	},
                    });
        		    //location.reload();
        		}
            });
        }
    });
</script>