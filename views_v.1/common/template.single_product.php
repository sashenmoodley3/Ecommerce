<!-- Breadcrumbs -->
<style>
    .varient li{
        display: inline-block;
/*    border: 3px solid #ddd;*/
    }
     .varient li label{
    border: 3px solid #ddd;
    float: left;
    margin-right: 5px;
    padding: 5px;
    border-radius: 50%;
    }
    
    .varient li input:checked + label,
    .varient li label:hover{
    border: 3px solid #3e4095;
    
    }
    
    
/*
    .varient li label{
        margin-bottom: 0;
    }
*/
</style>
<?php

if(!empty($getProduct[0])){
    if ($this->session->userdata("product")) {
        $product_arr = json_decode($this->session->userdata("product"), TRUE);
    }
    
    $getProduct             = $getProduct[0];
    $product_id             = $getProduct['product_id'];
    $product_name           = $getProduct['product_name'];
    $product_description    = $getProduct['product_description'];
    $short_description      = $getProduct['short_description'];
    $pro1                   = explode(',',$getProduct['product_image']);
    $product_image          = $product_img_url. $pro1[0];
    $category_id            = $getProduct['category_id'];
    $in_stock               = $getProduct['in_stock'];
    $product_wishlist       = $getProduct['wishlist'];
     
    $dataCount = 0;
    $dataCounthtml = '';
    $buttonLang     =   $this->lang->line('Add To Cart');
    if(!empty($product_arr)){
        foreach ($product_arr as $key => $product_session) {
            if (in_array($product_id, $product_session)) {
                $dataCount  +=1;
                $dataCounthtml   = '<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">'.$dataCount.'</span></a></div>';
            }
        }
    } 
     
     
    // $product_price = $getProduct['price'];
    // $product_mrp = $getProduct['mrp'];
    // $unit_value = $getProduct['unit_value'];
    // $product_unit = $getProduct['unit'];
    
    $q_variants             = $this->db->query("Select * from product_varient where product_id = '".$product_id."' and stock_inv>0");
    $variants_pro           = $q_variants->result_array();
    
    if(empty($variants_pro))
    {
        $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."'");
         $variants_pro       = $q_variants->result_array();
    }
    
    $eleid                  = $variants_pro[0]['product_id']; 
    $product_mrp            = number_format((float)$variants_pro[0]['mrp'], 2, '.', '');
    $product_price          = number_format((float)$variants_pro[0]['price'], 2, '.', '');//$value['price'];
    $product_unit           = $variants_pro[0]['unit'];
    $product_unit_value     = $variants_pro[0]['qty'];
    $varientid              = $variants_pro[0]['varient_id'];
    $stock                  = $variants_pro[0]['stock_inv'];
    $var_size             = $variants_pro[0]['var_size'];
    $var_color             = $variants_pro[0]['var_color'];
    $var_use_for             = $variants_pro[0]['var_use_for'];
    $var_material             = $variants_pro[0]['var_material'];
    
    if(!empty($variants_pro[0]['pro_var_images'])){
        $product_image  = base_url().'backend/uploads/products/'.$variants_pro[0]['pro_var_images'];
    }
    $imagesarr      =   array();
    $imagesArrs     =   array();
    foreach ($variants_pro as $key => $valuekey) {
        if(!empty($valuekey['pro_var_images'])){
             $imagesArrs[]    =   base_url().'backend/uploads/products/'.$valuekey['pro_var_images'];
        }
    }
    foreach($pro1 as $rows){
        $imagesArrs[]       =   $product_img_url.$rows;
    }
    
    //print_r($imagesArrs);
    $product_type           = $getProduct['product_type'];
    $product_call           = $getProduct['product_call'];
    $product_slug           = $getProduct['product_slug'];
    $category_title         = $getProduct['title'];
    $category_slug          = $getProduct['slug'];
    
    $q                      = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
    $del_price              = $q->row();
    		//print_r($del_price);
    if(!empty($del_price)){
    	$difference_price   = $variants_pro[0]['mrp'] - $del_price->deal_price;	
    	$product_price      = number_format((float)$del_price->deal_price, 2, '.', '');
    	$single_price       = $del_price->deal_price;
    } else {
    	$difference_price   = $variants_pro[0]['mrp'] - $variants_pro[0]['price'];
    	$product_price      = number_format((float)$variants_pro[0]['price'], 2, '.', '');
    	$single_price       = $variants_pro[0]['price'];
    }
    
	$outofstock         ='';
	if($stock < 1 || empty($in_stock)){
        $buttonLang     =   $this->lang->line('Out Of Stock');
        $outofstock     =   '<div class="out_stock"><img src="'.$this->config->item('base_url').'assets/images/out-of-stock1.png"></div>';
    }
    
    $calculatePerc          =   round((($difference_price*100)/$variants_pro[0]['mrp']),2);
    $percent                =   0;
    if($calculatePerc > 0){
        $percent            =   "You Save:".$calculatePerc.'%';
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
    
    $text           =   $product_name.', '.$getProduct['unit_value'].' '.$getProduct['unit']; 
    $simpleUrl      =   $this->config->item('base_url')."product/". $product_slug;
    $productUrl     =    urlencode($this->config->item('base_url')."product/". $product_slug);
    $whishlist          =   0;
    $q_whishList         = $this->db->query("SELECT * FROM `btl_wishlist` WHERE product_id='".$product_id."' AND user_id ='".$this->session->userdata('user_id')."'");
    $whishList           = $q_whishList->result_array();
    if(count($whishList) > 0){
        $whishlist       =  1;
    }
    
    $notifyme          =   0;
    $q_notifyme         = $this->db->query("SELECT * FROM `product_notifyme` WHERE product_id='".$product_id."' AND user_id ='".$this->session->userdata('user_id')."'");
    $notifyme_result     = $q_notifyme->result_array();
    if(count($notifyme_result) > 0){
        $notifyme       =  1;
    }
}
if($product_name !=''){
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v7.0"></script>
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
            <ul>
                <li class="home"> <a title="Go to Home Page" href="{base_url}home">Home</a><span>&raquo;</span></li>
                <li class=""> <a title="Go to Home Page" href="{base_url}shop">Shop</a><span>&raquo;</span></li>
                <li><strong><?=$product_name?></strong></li>
            </ul>
            <!-- <div class="_1YmWw">
                <span class="_1bexe"><?=$this->lang->line("Share on")?></span>
                <a  class="_30asG" target="_blank" href="https://wa.me/?text=<?=$productUrl?>">
                    <img src="<?=base_url()?>assets/images/whatsapp.png"  style="width:20px">
                </a>
                <a href="https://www.instagram.com/?url=<?=$simpleUrl?>" target="_blank" rel="noopener">
                    <img src="<?=base_url()?>/assets/images/instagram.png" style="width:20px">
                </a>
                <a class="_30asG fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=$productUrl?>&amp;src=sdkpreparse">
                  <img id="fb_share" class="_2LYDy" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='21' height='20' viewBox='0 0 21 20'%3E %3Cg fill='none' fill-rule='nonzero' transform='translate(.5)'%3E %3Ccircle cx='9.929' cy='9.929' r='9.929' fill='%233B5998'/%3E %3Cpath fill='%23FFF' d='M12.425 10.318h-1.772v6.49H7.97v-6.49H6.692V8.036H7.97V6.56c0-1.055.501-2.708 2.708-2.708l1.988.008v2.214h-1.442c-.237 0-.57.119-.57.622V8.04h2.006l-.234 2.279z'/%3E %3C/g%3E %3C/svg%3E" alt="facebook">
                </a>
                <a class="_30asG" href="https://twitter.com/intent/tweet?text=<?=$text?>   &amp;url=<?=$productUrl?>" target="_blank" rel="noopener noreferrer">
                      <img class="_2LYDy" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='21' height='20' viewBox='0 0 21 20'%3E %3Cg fill='none' fill-rule='nonzero' transform='translate(.528)'%3E %3Ccircle cx='9.929' cy='9.929' r='9.929' fill='%2355ACEE'/%3E %3Cpath fill='%23F1F2F2' d='M16.01 7.136a4.735 4.735 0 0 1-1.362.373 2.38 2.38 0 0 0 1.043-1.313c-.458.272-.966.47-1.507.576a2.374 2.374 0 0 0-4.044 2.165 6.737 6.737 0 0 1-4.892-2.48 2.373 2.373 0 0 0 .734 3.169 2.357 2.357 0 0 1-1.074-.298v.03c0 1.15.818 2.11 1.903 2.327a2.365 2.365 0 0 1-1.071.041 2.376 2.376 0 0 0 2.217 1.649 4.762 4.762 0 0 1-3.514.982 6.713 6.713 0 0 0 3.638 1.067c4.365 0 6.752-3.617 6.752-6.753 0-.103-.002-.206-.007-.307a4.813 4.813 0 0 0 1.185-1.228z'/%3E %3C/g%3E %3C/svg%3E" alt="twitter">
                </a>
                <a class="_30asG" href="mailto:?subject=<?=$text?>   &amp;body=<?=$text?>   <?=$productUrl?>" target="_blank" rel="noopener noreferrer">
                    <img class="_2LYDy" src="data:image/svg+xml,%3Csvg width='20px' height='20px' viewBox='0 0 20 20' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E %3C!-- Generator: Sketch 53.2 (72643) - https://sketchapp.com --%3E %3Ctitle%3Egoogle-plus%3C/title%3E %3Cdesc%3ECreated with Sketch.%3C/desc%3E %3Cdefs%3E %3Cpolygon id='path-1' points='0.00015 -5e-05 12 -5e-05 12 7.7524 0.00015 7.7524'%3E%3C/polygon%3E %3C/defs%3E %3Cg id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3E %3Cg id='7_404_-pd-page' transform='translate(-1265.000000, -139.000000)'%3E %3Cg id='Social-media' transform='translate(1174.000000, 139.000000)'%3E %3Cg id='google-plus' transform='translate(91.014205, 0.000000)'%3E %3Cellipse id='XMLID_30_' fill='%23BA5252' fill-rule='nonzero' cx='9.92884956' cy='10.0170175' rx='9.92884956' ry='9.84175439'%3E%3C/ellipse%3E %3Cg id='Group-3' transform='translate(3.985795, 6.000000)'%3E %3Cmask id='mask-2' fill='white'%3E %3Cuse xlink:href='%23path-1'%3E%3C/use%3E %3C/mask%3E %3Cg id='Clip-2'%3E%3C/g%3E %3Cpath d='M0.55565,7.08095 L0.55565,1.37445 C0.55565,1.28595 0.65115,1.23045 0.72815,1.27345 L5.96265,4.21295 C5.99765,4.23295 6.04115,4.23295 6.07615,4.21295 L11.27165,1.28395 C11.34865,1.24045 11.44415,1.29595 11.44415,1.38445 L11.44415,7.08095 C11.44415,7.14495 11.39215,7.19645 11.32815,7.19645 L0.67165,7.19645 C0.60765,7.19645 0.55565,7.14495 0.55565,7.08095 M11.05965,0.76645 L6.07565,3.57545 C6.04015,3.59495 5.99715,3.59495 5.96215,3.57545 L0.94315,0.76645 C0.83915,0.70795 0.88015,0.54945 0.99965,0.54945 L11.00315,0.54945 C11.12215,0.54945 11.16365,0.70745 11.05965,0.76645 M0.00015,0.23145 L0.00015,7.52095 C0.00015,7.64895 0.10365,7.75245 0.23165,7.75245 L11.76865,7.75245 C11.89615,7.75245 12.00015,7.64895 12.00015,7.52095 L12.00015,0.23295 C12.00015,0.10495 11.89615,0.00145 11.76865,0.00145 L0.23165,-5e-05 C0.10365,-5e-05 0.00015,0.10345 0.00015,0.23145' id='Fill-1' fill='%23FFFFFF' mask='url(%23mask-2)'%3E%3C/path%3E %3C/g%3E %3C/g%3E %3C/g%3E %3C/g%3E %3C/g%3E %3C/svg%3E" alt="email">
                </a>
            </div> -->
        </div>
      </div>
    </div>
  </div>
<?php 
} 
if($product_name !=''){
	$rating = !empty($value['rating'])? $value['rating'] : '0';
?>
  <!-- Breadcrumbs End --> 
  <!-- Main Container -->
  <div class="main-container col1-layout">
    <div class="container">
      <div class="row">
        <div class="col-main">
          <div class="product-view-area">
            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
                <div class="icon-new-label">
                    <?php echo  $product_call == 1 ? '<img src="'.$this->config->item('base_url').'assets/images/swadeshi.png">' :''; ?>
                </div>
                <span class="<?=$class?> ng-scope" title="<?=$title?>" ng-if="vm.selectedProduct.p_type === '<?=$p_type?>' ">&nbsp;</span>
                <div class="large-image"> 
                    <a href="" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20" style="margin: 0px auto;">
                      <img class="drift-demo-trigger" data-zoom="<?=$product_image?>?w=1200&amp;ch=DPR&amp;dpr=2" src="<?=$product_image?>?w=400&amp;ch=DPR&amp;dpr=2" alt="products" style=" margin: 0px auto;"> </a> 
                </div>
					  <!--<div class="short-description">-->
					  <!--  <?=$product_description?></div>-->
                <div class="flexslider flexslider-thumb">
                    <ul class="previews-list slides">
                    <?php foreach($imagesArrs as $rows){  ?>
                      <li><a href='<?=$rows?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?=$rows?>' "><img src="<?=$rows?>" alt = "Thumbnail 2"/></a></li>
                    <?php } ?>  
                    </ul>
                </div>
              
              <!-- end: more-images --> 
              
            </div>
            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 product-details-area detailsd">
                <div class="product-name">
                  <a class="_2zLWN _3bj9B" href="{base_url}shop?category=<?=$category_slug?>"><?=$category_title?></a>
                  <h1><?=$product_name?></h1>
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
                <div class="price-box">
                    <p class="special-price"> <span class="price-label"><?=$this->lang->line('Price');?>:</span> <span class="price" id="<?php echo "id" . $eleid; ?>"> <?=$this->config->item('currency')?> <?=$product_price?>/- </span></p>
                    <p class="old-price"> <span class="price-label"><?=$this->lang->line('MRP');?>:</span> <span class="price" id="<?php echo "regid" . $eleid; ?>"> <?=$this->config->item('currency')?> <?=$product_mrp?>/- </span> <?= !empty($percent) ? '<span id="offer" style="color:#ba5252"><small id="prooffer">'.$percent.'</small></span>' : ''?></p>
                    
                    <?php
                    $q_cat         = $this->db->query("Select * from categories where slug = '".$category_slug."'");
									$q_cat_info       = $q_cat->row_array();
//    print_r($q_cat_info);
//    echo $q_cat_info["product_cat_type_id"];
                    $product_cat_type_array = array("126", "127", "128");
//                    print_r($product_cat_type_array);
//    echo $q_cat_info["product_cat_type_id"];
                    if (in_array($q_cat_info["product_cat_type_id"], $product_cat_type_array))
                    {
//                        echo "Select av.attribute_value from product_varient left join attribute_values av on av.attribute_value_id = product_varient.var_color where product_id = '".$product_id."' and stock_inv>0 group by product_varient.var_color";
                        $q_variants1             = $this->db->query("Select av.*, product_varient.* from product_varient left join attribute_values av on av.attribute_value_id = product_varient.var_color where product_id = '".$product_id."' and stock_inv>0 group by product_varient.var_color");
                        $variants_color_pro           = $q_variants1->result_array();
//                        print_r($variants_pro11);
                    ?>
                        <div class="product-color-size-area">
                            <?php
                            if(count($variants_color_pro)>0)
                            {
                                if(!empty($variants_color_pro[0]["attribute_value"]))
                                {
                            ?>
                            <div class="color-area">
                              <h2 class="saider-bar-title">Color</h2>
                              <div class="varient">
                                <ul>
                                    <?php
                                    $i = 0;
                                    foreach($variants_color_pro as $variant_color)
                                    {
                                        $product_mrp            = number_format((float)$variant_color["mrp"], 2, '.', '');
                                        $product_price          = number_format((float)$variant_color["price"], 2, '.', '');
//        
                                        $difference_price11 = ($variant_color["mrp"] - $variant_color["price"]);
//        
        $calculatePerc11          =   round((($difference_price11*100)/$product_mrp),2);
    $percent11                =   0;
    if($calculatePerc11 > 0){
        $percent11            =   "You Save:".$calculatePerc11.'%';
    }
                                    ?>
                                    <li>
                                        
                                        <input style="opacity:0;width: 0;height: 0;" class="filter color_chk" type="checkbox" id="color<?=$i;?>" name="chk_color()" value="<?=$variant_color["varient_id"]?>">
                                        <label class="filter_image" data-image="<?=base_url().'backend/uploads/products/'.$variant_color["pro_var_images"]?>" for="color<?=$i;?>" data-save="<?=$percent11;?>"  data-proid="<?=$variant_color["product_id"];?>" data-variantid="<?=$variant_color["varient_id"];?>" data-id="color<?=$i;?>" data-price="<?=$product_price;?>" data-mrp="<?=$product_mrp;?>" data-difference="<?=$difference_price11;?>"> <span class="button"></span><div style="width: 20px;height: 20px;background-color: <?=$variant_color["attribute_value"]?>"></div></label>
                                    </li>
                                   
                                    <?php
                                        $i++;
                                    }
                                    ?>

                                </ul>
                              </div>
                            </div>
                            <span class="clearfix"></span>
                            <?php
                                }
                            }
                        
                            $q_variants11             = $this->db->query("Select av.*, product_varient.* from product_varient left join attribute_values av on av.attribute_value_id = product_varient.var_size where product_id = '".$product_id."' and stock_inv>0 group by product_varient.var_size");
                            $variants_size_pro           = $q_variants11->result_array();
                            if(count($variants_size_pro)>0)
                            {
                                if(!empty($variants_size_pro[0]["attribute_value"]))
                                {
                            ?>                            
                            <div class="col-lg-2 col-md-2" style="padding-left:0;">
                              <h2 class="saider-bar-title">Size</h2>
                              <div class="varient">
                                <ul>
                                    
                                    <?php
                                    $i = 0;
                                    foreach($variants_size_pro as $variant_size)
                                    {
                                    ?>
                                    <li>
                                        
                                        <input style="opacity:0;width: 0;height: 0;" class="filter size_chk" type="checkbox" id="size<?=$i;?>" name="chk_size()" value="<?=$variant_size["attribute_value"]?>">
                                        <label for="size<?=$i;?>"> <span class="button"></span><?=$variant_size["attribute_value"]?></label>
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
                        
                            $q_variants11   = $this->db->query("Select av.*, product_varient.* from product_varient left join attribute_values av on av.attribute_value_id = product_varient.var_material where product_id = '".$product_id."' and stock_inv>0 group by product_varient.var_material");
                            $variants_material_pro           = $q_variants11->result_array();
                        //echo "ram-".$variant_material[0]["attribute_value"]."-";
                            if(count($variants_material_pro)>0)
                            {
                                if(!empty($variant_material[0]["attribute_value"]))
                                {
                            ?>                            
                            <div class="col-lg-2 col-md-2" style="padding-left:0;">
                              <h2 class="saider-bar-title">Material</h2>
                              <div class="varient">
                                <select name="" id="">
                                    <option value="">Select</option>
                                    <?php
                                    $i = 0;
                                    foreach($variants_material_pro as $variant_material)
                                    {
                                    ?>
                                    <option value=""><?=ucfirst($variant_material["attribute_value"])?></option> 
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </select>
                              </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    <?php
                    }
                    else
                    {
                    ?>
                        <section class="irDHq">
                        <div class="_1LiCn">
                            <?php
                            foreach ($variants_pro as $key => $value) {
                                $class  =   '';
                                $qty    =   1;
                                    if(!empty($product_arr)){
                                        foreach ($product_arr as $key => $product_session) {
                                            if (in_array($value['varient_id'], $product_session)) {
                                                $class  = 'h7E8k';
                                                $qty    =  $product_session['buy_qty'];
                                            }
                                        }
                                    }
                                	$product_price_v = number_format((float)$value['price'], 2, '.', '');
            						$product_mrp_v = number_format((float)$value['mrp'], 2, '.', '');
            						$q_v = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$value['varient_id']."' AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.start_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.start_time)  <= NOW()
                                AND CONCAT(DATE_FORMAT(STR_TO_DATE(deal_product.end_date,'%d/%m/%Y'), '%Y-%m-%d'),' ',deal_product.end_time) >= NOW()");
            						$del_price_v = $q_v->row();
            						if(!empty($del_price_v)){
            							$difference_price_v = $value['mrp'] - $del_price_v->deal_price;	
            							$product_price_v = number_format((float)$del_price_v->deal_price, 2, '.', '');
            							$single_price_v  = $del_price_v->deal_price;
            						} else {
            							$difference_price_v = $value['mrp'] - $value['price'];
            							$product_price_v = number_format((float)$value['price'], 2, '.', '');
            							$single_price_v  = $value['price'];
            						}
            						$images     =   !empty($value['pro_var_images']) ? base_url().'backend/uploads/products/'.$value['pro_var_images'] : '';
                                ?>
                            <div class="_2Z6Vt   rippleEffect <?=$class?>">
                                <div class="_34ICY">
                                    <span>
                                    <div class="_3Yybm"> <?php echo $value['qty']." ".$value['unit']; ?></div>
                                    <div id="stock_<?=$value['varient_id']?>" class="_3Yybm"> Stock: <?php echo $value['stock_inv'] ?></div>
                                    </span>
                                    <!-- <div class="_3Yybm"> <?php echo $value['qty']." ".$value['unit']; ?></div> -->
                                    
                                <?php 
                                $filter_array = array("var_size", "var_color", "var_material", "var_use_for");
                                foreach($filter_array as $filters)
                                {
                                    if(!empty($value[$filters]))
                                    {
                                        $q_v1 = $this->db->query("Select * from attribute_values where attribute_value_id = '".$value[$filters]."'");
                                        $attribute_value = $q_v1->row();
                                        echo '<div class="_3Yybm"> Size: '.ucfirst($attribute_value->attribute_value).' </div>';
                                    }
                                }
                                    
                                ?>
                                    <div class="_30D1l"><?php echo $value['flavor']?></div>
                                </div>
                                <div class="_1K6b_">
                                    <div>
                                        <span class="_2j_7u" data-value="<?=$value['qty']?>" data-vid="<?php echo $value['purchase_id']; ?>"
										data-price="<?php echo $product_price_v; ?>"
										data-mrp  = "<?php echo $product_mrp_v; ?>"
										data-difference  = "<?php echo $difference_price_v; ?>"
										data-units  = "<?php echo $value['unit']; ?>"
										data-idd="<?php echo $value['product_id']; ?>" 
										data-varient="<?php echo $value['varient_id']; ?>"
										data-image  = "<?=$images?>"
										data-single = "<?=$single_price_v?>"><?=$this->config->item('currency').'<!-- --> '.$product_price_v?></span>
                                        <span class="_1lWqh"></span>
                                    </div>
                                </div>
                                <div class="_1DBJl"></div>
                            </div>
                            <?php
                            }
                        ?>
                        </div>
                    </section> 
                    <?php
                    }
                    ?>
                    
                </div>
              <div class="ratings">
                <div class="rating"> 
                    
                    <?php
                    if (!empty($in_stock)  && $stock >= 1):
                        echo '<p class="availability in-stock pull-right">Availability: <span>In Stock</span></p>';
                    else:
                        echo '<p class="availability out-of-stock pull-right">Availability: <span class="label">No stock</span></p>';
                    endif;
                    ?>
                    <a href="javascript:void(0)" id="<?=$product_id?>" class="add_to_wishlist button-icon-white" > <i class="fa fa-heart" id="das_<?=$product_id?>"  style="<?=!empty($whishlist) ? 'color:red' :'color:black'?>"></i> </a>  
                </div>
              
              <div class="short-description">
                <h2>Quick Overview</h2>
				<?=$short_description?>
               
              </div>
              <div class="product-variation">
                  <div class="cart-plus-minus">
                        <input type="hidden" name="product_id" id="product_id1_<?=$product_id?>" value="<?=$product_id?>">
                        <input type="hidden" name="product_varient_id" id="product_varient_id1_<?=$product_id?>" value="<?=$varientid?>">
                        <input type="hidden" name="price" id="price1_<?=$product_id?>" value="<?=$single_price?>" class="priceee">
                        <input type="hidden" name="unit" id="unit1_<?=$product_id?>" value="<?=$product_unit_value?>" class="units">
                        <input type="hidden" name="unit_value" id="unit_value1_<?=$product_id?>" value="<?=$product_unit?>" class="unit_value">
                        <input type="hidden" name="var_size" id="var_size1_<?=$product_id?>" value="<?=$product_unit?>" class="var_size">
                        <input type="hidden" name="var_color" id="var_color1_<?=$product_id?>" value="<?=$product_unit?>" class="var_color">
                        <input type="hidden" name="var_material" id="var_material1_<?=$product_id?>" value="<?=$product_unit?>" class="var_material">
                        <input type="hidden" name="var_use_for" id="var_use_for1_<?=$product_id?>" value="<?=$product_unit?>" class="var_use_for">

                    <label for="qty"><?=$this->lang->line("Quantity")?>:</label>
                    <?php
                    if (!empty($in_stock) && $stock >= 1):
                    ?>
                    <div class="numbers-row">
                      <div onClick="var result = document.getElementById('qty1_<?=$product_id?>'); var qty1_<?=$product_id?> = result.value; if( !isNaN( qty1_<?=$product_id?> ) &amp;&amp; qty1_<?=$product_id?> &gt; 1 ) result.value--;return false;" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                      <input type="text" class="qty" title="Qty" required value="<?=$qty>1 ? $qty :1?>" maxlength="12" id="qty1_<?=$product_id?>" name="qty">
                      <div onClick="var result = document.getElementById('qty1_<?=$product_id?>'); var qty1_<?=$product_id?> = result.value; if( !isNaN( qty1_<?=$product_id?> )) result.value++;return false;" class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                    </div>
                    <?php
                    else:
                    ?>
                        <div class="numbers-row">
                          <div onClick="var result = document.getElementById('qty1_<?=$product_id?>'); var qty1_<?=$product_id?> = result.value; if( !isNaN( qty1_<?=$product_id?> ) &amp;&amp; qty1_<?=$product_id?> &gt; 1 ) result.value--;return false;" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                          <input type="text" class="qty" title="Qty"  required  value="0" id="qty1_<?=$product_id?>" name="qty">
                          <div onClick="var result = document.getElementById('qty1_<?=$product_id?>'); var qty1_<?=$product_id?> = result.value; if( !isNaN( qty1_<?=$product_id?> )&& qty1_<?=$product_id?><0) result.value++;return false;" class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                        </div>
                    <?php
                    endif;
                    ?>
                                            
                  </div>
                 
                        
                  <?php
                     //echo $in_stock;
                        if (!empty($in_stock) && $stock >= 1){
                            $chkout_btn_id = "btnSrch1";
                        }
                        else
                        {
                            $chkout_btn_id = "";
                        }
                    ?>
                  
                  
                  <a class="button pro-add-to-cart" id="<?=$chkout_btn_id?>" title="Add to Cart" data-id="<?=$product_id?>" ><span><i class="fa fa-shopping-basket"></i> <?=$buttonLang?></span></a>
                <div style="clear:both; margin-bottom:20px; padding-top:20px;">
                     <?php
                        if (empty($in_stock) && $stock < 1):
                    ?>
                    <input style="width:20px; height:20px;" data-id="<?=$notifyme?>" type="checkbox" <?php if($notifyme==1){echo "checked";}?>  value="<?=$product_id?>" id="notifyme"/><span style="font-size:20px;">&nbsp;Notify me when product will available for sale. </span>
                </div>
                  <?php
                        endif;
                    ?>
                <div class="short-description">
					    <?=$product_description?></div>
                
              </div>
<!--              <div class="product-cart-option">
                <ul>
                  <li><a href="#"><i class="fa fa-heart"></i><span>Add to Wishlist</span></a></li>
                  <li><a href="#"><i class="fa fa-retweet"></i><span>Add to Compare</span></a></li>
                  <li><a href="#"><i class="fa fa-envelope"></i><span>Email to a Friend</span></a></li>
                </ul>
              </div>-->
            </div>
          </div>
        </div>
        
            <?php
               
                if(!empty($this->session->userdata('user_id')))
                {
            ?>
        <div class="clearfix1"></div>
        <div class="product-overview-tab">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <div class="product-tab-inner">
                  <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
<!--                    <li class="active"> <a href="#description" data-toggle="tab"> Description </a> </li>-->
                    <li class="active"> <a href="#reviews" data-toggle="tab" aria-expanded="true">Reviews</a> </li>
<!--
                    <li><a href="#product_tags" data-toggle="tab">Tags</a></li>
                    <li> <a href="#custom_tabs" data-toggle="tab">Custom Tab</a> </li>
-->
                  </ul>
                  <div id="productTabContent" class="tab-content">
<!--
                    <div class="tab-pane fade in active" id="description">
                      <div class="std">
                        <p>Proin lectus ipsum, gravida et mattis vulputate, 
                          tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in 
                          faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend 
                          laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla
                          luctus malesuada tincidunt. Nunc facilisis sagittis ullamcorper. Proin 
                          lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et 
                          lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et 
                          ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus 
                          adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada 
                          tincidunt. Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, 
                          gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. 
                          Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                          cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl 
                          ut dolor dignissim semper. Nulla luctus malesuada tincidunt.</p>
                        <p> Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer enim purus, posuere at ultricies eu, placerat a felis. Suspendisse aliquet urna pretium eros convallis interdum. Quisque in arcu id dui vulputate mollis eget non arcu. Aenean et nulla purus. Mauris vel tellus non nunc mattis lobortis.</p>
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor, lorem et placerat vestibulum, metus nisi posuere nisl, in accumsan elit odio quis mi. Cras neque metus, consequat et blandit et, luctus a nunc. Etiam gravida vehicula tellus, in imperdiet ligula euismod eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>
                      </div>
                    </div>
-->
                    <div id="reviews" class="tab-pane fade active in">
                      <div class="col-sm-5 col-lg-5 col-md-5">
                        <div class="reviews-content-left">
                          <h2>Customer Reviews</h2>
                            
                            <?php   
					@$q_review_list         = $this->db->query("Select * from rating_table where product_id = '".$product_id."' and review_status='0' and review_trash='0' ORDER BY `review_id` DESC limit 5");
									@$pro_all_review_list       = @$q_review_list->result_array();

								if(!empty(@$pro_all_review_list))	{						
                                   foreach (@$pro_all_review_list as $review) {
                                        $rating = $review['rating'];
                                       if($rating==5)
                                       {
                                           $rating_status = "Amazing";
                                       }
                                       else if($rating==4)
                                       {
                                           $rating_status = "Excellent";
                                       }
                                       else if($rating==3)
                                       {
                                           $rating_status = "Good";
                                       }
                                       else if($rating==2)
                                       {
                                           $rating_status = "Fair";
                                       }
                                       else
                                       {
                                           $rating_status = "Poor";
                                       }
                                                                             
                               
                            ?>
                            
                          <div class="review-ratting">
                            <p><a href="#"><?=$rating_status;?></a> Review by <?=$review['username'];?></p>
                            <table>
                              <tbody>
                                <tr>
<!--                                  <th>Rating</th>-->
                                  <td><div class="rating">
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
                                      </div></td>
                                </tr>  
                                  <tr>
<!--                                  <th>Description</th>-->
                                  <td colspan="2"><div class="Description">
                                      <?php
                                       
                                            echo $review['description'];
                                      ?>
                                      </div></td>
                                </tr>  
                              </tbody>
                            </table>
                            <p class="author"><small><?php if($review['updated_date']==""){ echo date("d-m-Y h:i:s", strtotime($review['created_date']));}else{  echo date("d-m-Y h:i:s", strtotime($review['updated_date']));}?></small> </p>
                          </div>                          
                            <?php
                                       }
                                      }
                              
                            ?>
                            
                        </div>
                      </div>
                    
                        <?php
						
						$rating = 0;
                        $confirm_purcahse_pro = $this->db->query("SELECT * FROM `sale_items` join sale on sale.sale_id = sale_items.sale_id and sale_items.product_id='".$product_id."' WHERE sale.user_id='".$this->session->userdata('user_id')."'");
						$confirm_purcahse_pro_result = $confirm_purcahse_pro->result_array();
						
                        if(!empty($confirm_purcahse_pro_result))
                        {
                           
                                //print_r($confirm_user_review_result);
                                //echo $confirm_user_review_result->rating;
                        ?>
                    
                              <div class="col-sm-7 col-lg-7 col-md-7">
                                <div class="reviews-content-right">
								<?php 
								 @$confirm_user_review         = $this->db->query("SELECT * FROM `rating_table` WHERE product_id='".$product_id."' and user_id='".$this->session->userdata('user_id')."' and review_status ='0' and review_trash='0'");
								@$confirm_user_review_result       = $confirm_user_review->row();
								// print_r($confirm_user_review_result);
								if (!empty($confirm_user_review_result) ){
								?>
                                    <div id="review_content">
                                        <div><h2>Your Review :</h2> </div>                                      

										<div > 
											<p style="color:black;">
<!--                                                <h2>Rating</h2>-->
											</p>
											<div class="rating" style="font-size:25px;">
												
											  <?php
											   //echo $rating."-";
													$rating = $confirm_user_review_result->rating;
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
											<div >
											<p class="Description" style="color:black;"><h2>Description</h2></p>
											<p style="font-size:20px;">
													  <?php

															echo $confirm_user_review_result->description;
													  ?>
												...<a href="javasciprt:void(0)" title="Edit Review" id="review_edit" style="font-size:15px;"><i class="fa fa-edit"></i></a>
											</p>
													  </div>
											<p class="author"><small><?php if($review['updated_date']==""){ echo date("d-m-Y h:i:s", strtotime($review['created_date']));}else{  echo date("d-m-Y h:i:s", strtotime($review['updated_date']));}?></small> </p>
										</div>  
                                            
               
                                    </div>
								<?php } ?>
									<div style="<?php echo !empty($confirm_user_review_result)? 'display:none;' : ''; ?>" id="review_form">
                                          <h2><?php if(@$rating!=""){ echo "Update";}else{ echo "Write";}?> Your Own Review</h2>
                                          <form method="post" action="#" name="frm_rating">
                                            <h3>You're reviewing:</h3>
                                            <h4>How do you rate this product?<em>*</em></h4>
                <!--                            <div class="table-responsive reviews-table">-->
                                              <p class="error" id="ratting_error_msg">  </p>
                                              <div class="ratingg">
                                                <input id="star5" <?php if($rating==5){ echo "checked";}?> name="star" type="radio" value="5" class="radio-btn hide" />
                                                <label for="star5"  style="font-size:40px;">☆</label>
                                                <input id="star4" <?php if($rating==4){ echo "checked";}?> name="star" type="radio" value="4" class="radio-btn hide" />
                                                <label for="star4" style="font-size:40px;">☆</label>
                                                <input id="star3" <?php if($rating==3){ echo "checked";}?> name="star" type="radio" value="3" class="radio-btn hide" />
                                                <label for="star3" style="font-size:40px;">☆</label>
                                                <input id="star2" <?php if($rating==2){ echo "checked";}?> name="star" type="radio" value="2" class="radio-btn hide" />
                                                <label for="star2" style="font-size:40px;">☆</label>
                                                <input id="star1" <?php if($rating==1){ echo "checked";}?> name="star" type="radio" value="1" class="radio-btn hide" />
                                                <label for="star1" style="font-size:40px;">☆</label>
                                                <div class="clear"></div>

                                            </div>
                <!--                            </div>-->
                                            <div class="form-area">
                                              <div class="form-element">                                
                                                  <input type="hidden" value="<?php echo $this->session->userdata('user_name');?>" id="hide_username">
                                                  <input type="hidden" value="<?php echo $this->session->userdata('user_id');?>" id="hide_userid">
                                                  <input type="hidden" value="<?php if(@$rating!=""){ echo "update";}else{ echo "insert";} ?>" id="hide_review_submit_type">
                                              </div>

                                              <div class="form-element">
                                                  <p class="error" id="review_desc_error_msg">  </p>
                                                <label>Review Description <em>*</em></label>
                                                <textarea id="review_desc"><?php echo $confirm_user_review_result->description;?></textarea>
                                              </div>
                                              <div class="buttons-set">
                                                <button data-id="<?=$product_id?>" class="button review_submit submit" title="Submit Review" type="submit"><span><i class="fa fa-thumbs-up"></i> &nbsp;Review Submit</span></button>
                                              </div>
                                            </div>
                                          </form>
                                    </div>
                                
								</div>
                              </div>
                        <?php  
                        }
						?>
                    </div>
<!--
                    <div class="tab-pane fade" id="product_tags">
                      <div class="box-collateral box-tags">
                        <div class="tags">
                          <form id="addTagForm" action="#" method="get">
                            <div class="form-add-tags">
                              <div class="input-box">
                                <label for="productTagName">Add Your Tags:</label>
                                <input class="input-text" name="productTagName" id="productTagName" type="text">
                                <button type="button" title="Add Tags" class="button add-tags"><i class="fa fa-plus"></i> &nbsp;<span>Add Tags</span> </button>
                              </div>
                              input-box 
                            </div>
                          </form>
                        </div>
                        tags
                        <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom_tabs">
                      <div class="product-tabs-content-inner clearfix">
                        <p><strong>Lorem Ipsum</strong><span>&nbsp;is
                          simply dummy text of the printing and typesetting industry. Lorem Ipsum
                          has been the industry's standard dummy text ever since the 1500s, when 
                          an unknown printer took a galley of type and scrambled it to make a type
                          specimen book. It has survived not only five centuries, but also the 
                          leap into electronic typesetting, remaining essentially unchanged. It 
                          was popularised in the 1960s with the release of Letraset sheets 
                          containing Lorem Ipsum passages, and more recently with desktop 
                          publishing software like Aldus PageMaker including versions of Lorem 
                          Ipsum.</span></p>
                      </div>
                    </div>
-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
            <?php } ?>
      </div>
    </div>
  </div>
  </div>
  <?php } else { ?>
	  
	<div class="main-container col1-layout">
		<div class="container">
			<div class="row">
				<div class="col-main text-center">
					
				<h1><?=$this->lang->line("No Product Found")?></h1>
					
				</div>
			</div>
		</div>
	</div>
	  
  <?php }?>
  
<?php  if(!empty($relatedProduct)) { ?>
  
  <div class="container">
    <div class="special-products">
        <div class="page-header">
            <h2><?=$this->lang->line("Related Products")?></h2>
        </div>
        <div class="special-products-pro">
            <div class="slider-items-products">
                <div id="special-products-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col4">
                        <?php
						 
                        foreach ($relatedProduct as $key => $value):
                            if($product_id == $value['product_id']){
                                continue;
                            }
                            $category_id        = $value['category_id'];
                            $category_title     = $value['title'];
                            $pro1               = explode(',',$value['product_image']);
                            $product_image      = $product_img_url . $pro1[0];
                            
                            $product_id         = $value['product_id'];
                            $product_name       = $value['product_name'];
                            $dataCount = 0;
                            $dataCounthtml = '';
                            $buttonLang     =   'Add To Cart';
                            if(!empty($product_arr)){
                                foreach ($product_arr as $key => $product_session) {
                                    if (in_array($product_id, $product_session)) {
                                        $dataCount       = $product_session['buy_qty'];
                                        $dataCounthtml   = '<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-basket"></i><span class="badge">'.$dataCount.'</span></a></div>';
                                        $buttonLang      = "Added To Cart";
                                        
                                    }
                                }
                            }
                            
                            
                            
                            $product_wishlist   = $value['wishlist'];
                                    
                            //$q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."'");
                            
                            $q_variants             = $this->db->query("Select * from product_varient where product_id = '".$product_id."' and stock_inv>0");
                            $variants_pro           = $q_variants->result_array();
                            
                            if(empty($variants_pro))
                            {
                                $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$product_id."'");
                                 $variants_pro       = $q_variants->result_array();
                            }
                                    
                                    
                                    
							$variants_pro       = $q_variants->result_array();
							$eleid              = $variants_pro[0]['product_id']; 
							$product_mrp        = number_format((float)$variants_pro[0]['mrp'], 2, '.', '');
                            $product_price      = number_format((float)$variants_pro[0]['price'], 2, '.', '');//$value['price'];
                            $product_unit       = $variants_pro[0]['unit'];
                            $product_unit_value = $variants_pro[0]['qty'];
                            $varientid          = $variants_pro[0]['varient_id'];
                            $stock              = $variants_pro[0]['stock_inv'];
                            $flavor             = $variants_pro[0]['flavor'];
                            $var_size             = $variants_pro[0]['var_size'];
                            $var_color             = $variants_pro[0]['var_color'];
                            $var_use_for             = $variants_pro[0]['var_use_for'];
                            $var_material             = $variants_pro[0]['var_material'];
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
							$outofstock         =   '';
							if($stock < 1 || empty($in_stock)){
                                $buttonLang     =   "Out Of Stock"; 
                                $outofstock     =   '<div class="out_stock"><img src="'.$this->config->item('base_url').'assets/images/out-of-stock1.png"></div>';
                            }
							
							$q                  = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$variants_pro[0]['varient_id']."'");
							$del_price          = $q->row();
							$offerdiv           =   '';
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
							
							$rating = !empty($value['rating'])? $value['rating'] : '0';
							
                            ?>
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
                                    <?=$offerdiv?>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"> 
                                                <a title="<?= $product_name ?>" href="{base_url}product/<?=$product_slug?>"><?= $product_name ?></a><a  style="height: 19px;" class="product-listing__save--price <?php echo "fl3_" . $eleid; ?>"><?=$flavor?></a> 
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
                                                    </div>
                                                    <!--<div><span class="price-label">You Save:</span> <span class="small" id="<?php echo "diffid" . $eleid; ?>"><?=$difference_price?></span></div>-->
                                                    
                                                    <select class="form-control onsel sss" id="<?php echo $product_id; ?>">
														<?php
															foreach ($variants_pro as $key => $valuess) {
																
																$product_price_v = number_format((float)$valuess['price'], 2, '.', '');
																$product_mrp_v = number_format((float)$valuess['mrp'], 2, '.', '');
																$q_v = $this->db->query("Select deal_price from deal_product where product_id = '".$product_id."' AND pro_var_id='".$valuess['varient_id']."'");
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
  
  <style>
      select.form-control:not([size]):not([multiple]) {
        height: 3.5rem;
    }
  </style>
  

<script>
    $(document).ready(function(){
        $('.add_to_wishlist').click(function(){
            var product_id = $(this).attr('id');
            //var BASE_URL  = "http://kriscenttechnohub.com/kart-grocery-supermarket/";
            
            var BASE_URL  = "{base_url}";
            $.get(BASE_URL+"addToWishlist",{ product_id:product_id},function(data){
            
              if(data == "0"){
                  $('#das_'+product_id).css('color','black')
              }else if(data == "1"){
                  $('#das_'+product_id).css('color','red')
              }else if(data == "2"){
                  
                  window.location.href = BASE_URL+"login";
              }
                
            });
            
        })
        
        $('#notifyme').click(function(){
            
            var product_id = $(this).attr('value');
            var data_id = $(this).attr('data-id');
            
            if(data_id==0)
            {
                filter = "add";
            }
            else{
                filter = "remove";
            }
            
            //var BASE_URL  = "https://kriscent.in/product/kart-grocery-supermarket/";
             var BASE_URL  = "{base_url}";
            //alert("ram"+product_id);
            $.get(BASE_URL+"notifyme",{product_id:product_id, filter:filter},function(data){
            //alert(data);
                 if(data == "2"){                  
                      window.location.href = BASE_URL+"login";
                  }
                
                
            });
            
        })
        
    });
     $(document).on('click', ".rippleEffect", function (e) {
       
		e.preventDefault();
		var button      =   $(this);
		$('.rippleEffect').removeClass('h7E8k');
		$(this).addClass('h7E8k');
		console.log($(this).find('._2j_7u'));
		var vid         =   $(this).find('._2j_7u').data('vid');
		var idd         =   $(this).find('._2j_7u').data('idd');
		var price       =   $(this).find('._2j_7u').data('price');
		var mrp         =   $(this).find('._2j_7u').data('mrp');
		var units       =   $(this).find('._2j_7u').data('units');
		var unit_value  =   $(this).find('._2j_7u').data('unit_value');
		var varient     =   $(this).find('._2j_7u').data('varient');
		var single      =   $(this).find('._2j_7u').data('single');
		var unit_value  =   $(this).find('._2j_7u').data('value');
		var image       =   $(this).find('._2j_7u').data('image');

		if(image !=''){
		    $('.drift-demo-trigger').data('zoom',image);
		    $('.drift-demo-trigger').attr('src',image);
		}
		
		$("#id" + idd).text("<?=$this->config->item('currency')?> "+price+" /-");
		$("#regid" + idd).text("<?=$this->config->item('currency')?> "+mrp+" /-");
		
		
		$('#product_id1_'+ idd).val(idd);
		$('#product_varient_id1_'+ idd).val(varient);
		$('#price1_'+ idd).val(single);
		$('#unit1_'+ idd).val(unit_value);
		$('#unit_value1_'+ idd).val(units);

            
    });
    
    $(document).on('click', ".filter_image", function (e) {
//       alert("yes");
		e.preventDefault();
		var button      =   $(this);
//		$('.rippleEffect').removeClass('h7E8k');
//		$(this).addClass('h7E8k');
//		console.log($(this).find('._2j_7u'));
//		var vid         =   $(this).find('._2j_7u').data('vid');
//		var idd         =   $(this).find('._2j_7u').data('idd');
//		var price       =   $(this).find('._2j_7u').data('price');
//		var mrp         =   $(this).find('._2j_7u').data('mrp');
//		var units       =   $(this).find('._2j_7u').data('units');
//		var unit_value  =   $(this).find('._2j_7u').data('unit_value');
//		var varient     =   $(this).find('._2j_7u').data('varient');
//		var single      =   $(this).find('._2j_7u').data('single');
//		var unit_value  =   $(this).find('._2j_7u').data('value');
		var image       =   $(this).data('image');
        var chkbox_id       =   $(this).data('id');
        var proid       =   $(this).data('proid');
        var price       =   $(this).data('price');
        var mrp       =   $(this).data('mrp');
        var save       =   $(this).data('save');
        var variantid       =   $(this).data('variantid');
        
//alert("yes"+variantid);
        $(".color_chk").prop('checked', false);
        $("#"+chkbox_id).prop('checked', true);
        $("#id"+proid).html(price);
        $("#regid"+proid).html(mrp);
        $("#prooffer").html(save);
        $('#product_id1_'+ proid).val(proid);
		$('#product_varient_id1_'+ proid).val(variantid);
		$('#price1_'+ proid).val(price);
        
		if(image !=''){
		    $('.drift-demo-trigger').data('zoom',image);
		    $('.drift-demo-trigger').attr('src',image);
		}
		
//		$("#id" + idd).text("<?=$this->config->item('currency')?> "+price+" /-");
//		$("#regid" + idd).text("<?=$this->config->item('currency')?> "+mrp+" /-");
//		
//		
//		$('#product_id1_'+ idd).val(idd);
//		$('#product_varient_id1_'+ idd).val(varient);
//		$('#price1_'+ idd).val(single);
//		$('#unit1_'+ idd).val(unit_value);
//		$('#unit_value1_'+ idd).val(units);

            
    });
    
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
		if(image !=''){
		    $('#pro_img'+idd).data('src',image);
		    $('#pro_img'+idd).attr('src',image);
		}
		
		
		$('#product_id'+ idd).val(idd);
		$('#product_varient_id'+ idd).val(varient);
		$('#price'+ idd).val(single);
		$('#unit'+ idd).val(unit_value);
		$('#unit_value'+ idd).val(units);
		

		$("#id" + idd).text("<?=$this->config->item('currency')?> "+price+"/-");
		
		$("#regid" + idd).text("<?=$this->config->item('currency')?> "+mrp+"/-");
		$("#diffid" + idd).text(difference);

            
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
        		     $('#cart'+product_id).find('i').removeClass('icon-loader').addClass('fa fa-shopping-basket');
        		     $('.cart-total').html(response.total_item+' item');        		     
        		     $('#cart-sidebar').html(response.html);        		     
        		     $('#total_order_price').html(response.total_order_price);
        		     $('#cart'+product_id).html('<i class="fa fa-shopping-basket"></i><span> Added to Cart</span>');
        		     $('#cart2_'+product_id).html('<i class="fa fa-shopping-basket"></i><span> Added to Cart</span>');
        		     $('#cart_'+product_id).html('<i class="fa fa-shopping-basket"></i><span> Added to Cart</span>');
        		     $('#cart3_'+product_id).html('<i class="fa fa-shopping-basket"></i><span> Added to Cart</span>');
        		     
        		     
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
    
    
    $(document).on('click','#review_edit', function(e){
        
        //alert("click");
        $('#review_form').show();
        $('#review_content').hide();
    });
    
    $(document).on('click','.review_submit', function(e){
        e.preventDefault();
        var product_id  =   $(this).data('id');
        var user_name   =   $('#hide_username').val();
        var user_id     =   $('#hide_userid').val(); 
        var review_submit_type     =   $('#hide_review_submit_type').val();
        var rating        = document.forms.frm_rating.star.value;        
        var desc        = document.forms.frm_rating.review_desc.value;


        if(product_id !='' && user_id !=''){
            //alert("in"+rating);
            //$(this).find('i').removeClass('fa fa-shopping-basket').addClass('icon-loader');
            $.ajax({
        		type: "post",
        		//url: "{base_url}add_cart",
                url: "{base_url}add_review",
        		data: {product_id:product_id,user_id:user_id,review_submit_type:review_submit_type,user_name:user_name,ratting:rating,desc:desc},
        		dataType: "json",
        		success: function (response) {
                   
                    //var ason = JSON.parse(response);
                     //alert(ason);
                    if(response.response==1)
                    {
                        window.location.reload();
                    }
                    else{
                        //alert("ram");
                        //alert(response.msg[0]);
                        $('#ratting_error_msg').html(response.msg.ratting);
                        $('#review_desc_error_msg').html(response.msg.desc);
                        
                        //alert(response.msg.ratting);
                    }
        		    
        		}
            });
        }
        else{
            //var BASE_URL  = "{base_url}";
            window.location.href = "{base_url}login";
        }
    });
    
</script>
