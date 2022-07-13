<style>
    .brand{
        height: 150px;
        overflow-y: auto;
    }
</style>
<?php
//print_r($get_brands);
//print_r($brand_array);
//print_r($review_array);
//print_r($filter_price_array);


$webItem        =   trim($this->config->item('shop_one_row_item_show'));
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



?>
<!-- Main Container -->

            

                <?php
                if(!empty($getProducts))
                {
                ?>
                    
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
                            
<!--                        <ul class="products-grid">-->
                            <?php
                            foreach ($getProducts as $key => $value):
                                
                                $category_id        = $value['category_id'];
                                $category_title     = $value['title'];
                                $product_id         = $value['product_id'];
                                $pro1               = explode(',',$value['product_image']);
                                $product_image      = base_url().'backend/uploads/products/'. $pro1[0];
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
                                                <a title="<?= $product_name ?>" href="<?=base_url()?>product/<?=$product_slug?>">
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
                                                   
                                                    <div class="mt-button quick-view"> <a href="<?=base_url()?>product/<?=$product_id?>"> <i class="fa fa-link"></i> </a> </div>
                                                    <div class="mt-button add_to_compare"> 
                                                        <!-- <a href="<?=base_url()?>compare"> <i class="fa fa-signal"></i> </a> -->
                                                    </div>
                                                </div>
                                            </div> <?php */?>
                                        </div>
                                        <?=$offerdiv?>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"> 
                                                    <a title="<?= $product_name ?>" href="<?=base_url()?>product/<?=$product_slug?>"><?= $product_name ?></a> 
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
                                                            <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"  id="<?php echo "id" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_price ?></span> </p>
                                                            <!-- <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price" id="<?php echo "regid" . $eleid; ?>"> <?=$this->config->item('currency')?> <?= $product_mrp ?>/- </span> </p> -->
                                                        </div>
                                                        <!--<div><span class="price-label">You Save:</span> <span class="small" id="<?php echo "diffid" . $eleid; ?>"><?=$difference_price?></span></div>-->
                                                        
                                                                    <select class="form-control onsel sss"
                                                                                    id="<?php echo $product_id; ?>">
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

<!--                        </ul>-->
                    
                <?php
                }
                ?>
            


<!-- Main Container End --> 