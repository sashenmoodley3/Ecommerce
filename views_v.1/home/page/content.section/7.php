<div class="container">
    <div class="row"> 
        <!-- our clients Slider -->
        <div class="col-md-12 col-xs-12">
            <div class="our-clients">
                <div class="slider-items-products">
                    <div id="our-clients-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col6"> 
                            <?php
                            //var_dump($getCategoriesShort);
                            foreach ($getFeatureBanner as $key => $value):
                                $image =$slider_img_url.$value['slider_image'];
                                //$image =$category_img_url.$value->image;
                                /*
                                $category_id = $value['category_id'];
                                $category_title = $value['title'];
                                $product_image = $product_img_url.$value['product_image'];
                                $product_name = $value['product_name'];
                                $product_unit = $value['unit'];
                                $product_mrp = $value['mrp'];
                                $product_price = $value['price'];
                                $difference_price = $value['difference_price'];
                                 * 
                                 */
                        ?>
                            <div class="item"> <a href="#"><img src="<?=$image?>" width="250" height="100" alt="Image"></a> </div>
                        <?php
                        endforeach;
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/*
 * 
    <!-- Item -->
    <div class="item"> <a href="#"><img src="{base_url}assets/images/brand1.png" alt="Image"></a> </div>
    <div class="item"> <a href="#"><img src="{base_url}assets/images/brand2.png" alt="Image"></a> </div>
    <!-- End Item --> 

    <!-- Item -->
    <div class="item"> <a href="#"><img src="{base_url}assets/images/brand3.png" alt="Image"></a> </div>

    <!-- End Item -->
    <div class="item"> <a href="#"><img src="{base_url}assets/images/brand1.png" alt="Image"></a> </div>
    <div class="item"> <a href="#"><img src="{base_url}assets/images/brand2.png" alt="Image"></a> </div>
    <!-- End Item -->

    <!-- Item -->
    <div class="item"> <a href="#"><img src="{base_url}assets/images/brand3.png" alt="Image"></a> </div>
 */
?>