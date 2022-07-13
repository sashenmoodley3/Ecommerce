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
    $sql = $this->db->query('select fs.*, type.type_name from feature_slider fs left join feature_slider_type type on fs.slider_title = type.type_id where fs.slider_status = 1 limit 3 ')->result_array();
   
    $type_name = $this->db->query('select type.type_name from  feature_slider_type type  where type.type_id = 1')->row();
?>
<?php if(!empty($sql)){ ?>   
    <div class="container">
        <div class="row"> 
            <div class="col-md-12 col-xs-12">
                <div class="page-header">
                    <h2><?=$type_name->type_name?></h2>
                </div>
                <div class="our-clients">
                <div class="slider-items-products">
                    <div id="our-clients-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col6"> 
                            <?php
                            //var_dump($getCategoriesShort);
                            foreach ($sql as $key => $value):
                                $image =$slider_img_url.$value['slider_image'];
                               
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
<?php } ?>
<?php
    $sql_banner = $this->db->query('select b.* from banner b  where b.slider_status = 1 limit 1')->row_array();
?>
<?php if(!empty($sql_banner)){ 
    $image =$slider_img_url.$sql_banner['slider_image'];?>   
    <div class="container">
        <div class="row"> 
            <div class="col-md-12 col-xs-12">
                <a href="#"><img src="<?=$image?>" height="100" alt="Image"></a>
                <div class="our-clients">
                <div class="slider-items-products">
                    <div id="our-clients-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col12"> 
                            <?php
                                
                               
                            ?>
                            <div class="item">  </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
<?php } ?>  
  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('.add_to_wishlist').click(function(){
            var product_id = $(this).attr('id');
            var BASE_URL  = "http://kriscenttechnohub.com/kart-grocery-supermarket/";
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
		var vid = $(this).find(':selected').data('vid');
		var idd = $(this).find(':selected').data('idd');
		var price = $(this).find(':selected').data('price');
		
		var mrp = $(this).find(':selected').data('mrp');
		var difference = $(this).find(':selected').data('difference');
		
		var units = $(this).find(':selected').data('units');
		

		$("#id" + idd).text("R "+price+"/-"+units);
		
		$("#regid" + idd).text("R "+mrp+"/-"+units);
		$("#diffid" + idd).text("R "+difference);

            
    });
</script>