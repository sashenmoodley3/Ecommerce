<!--div class="banner-static">
    <div class="container">
        <div class="row">
            <?php  foreach($getFeatureBanner  as $k=> $v){
                $id         = $v['id'];
                $image      = $v['slider_image'];
                $url        = base_url()."backend/uploads/sliders/";
                $cat        = $v['sub_cat'];
                $title      = $v['slider_title'];
                $sql = "select * from feature_slider where id ='" . $id . "' limit 0,1";
                $sql = "select 
                    feature_slider.id as id,
                    feature_slider.image_type as image_type,
                    feature_slider.slider_title as slider_title,
                    feature_slider.slider_url as slider_url,
                    feature_slider.slider_image as slider_image,
                    feature_slider.sub_cat as sub_cat,
                    feature_slider.slider_status as slider_status,
                    categories.title as cat_title,
                    categories.slug as slug
                        from feature_slider 
                    LEFT JOIN categories ON categories.id = feature_slider.sub_cat AND categories.status = 1
                        where feature_slider.id = '" . $id . "' limit 0,1";
                $q = $this->db->query($sql);
                $slider = $q->row();
                $href = base_url()."search?slug=".$slider->slug."&search=";
            ?>
           
                <div class="col-sm-4 col-sms-12">
                    <a href="<?=$href?>">
                        <div class="banner-box banner-box2"> <img src="<?=$url.$image?>" alt="">
                            <div class="box-hover">
                                <div class="banner-title"><?=$title?></div>
                                <span>Save up to 45% off</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
            
            
            <!--<div class="col-sm-4 col-sms-12">-->
            <!--    <div class="banner-box banner-box1"> <a href="#"><img src="{base_url}assets/images/banner_staic1.jpg" alt=""></a>-->
            <!--        <div class="box-hover">-->
            <!--            <div class="banner-title">Healthy Summer</div>-->
            <!--            <span>Save up to 45% off</span> </div>-->
            <!--    </div>-->
            <!--</div>-->
            
            
            <!--<div class="col-sm-4 col-sms-12">-->
            <!--    <div class="banner-box banner-box3"> <a href="#"><img src="{base_url}assets/images/banner_staic3.jpg" alt=""></a>-->
            <!--        <div class="box-hover">-->
            <!--            <div class="banner-title">MADE FRESH DAILY</div>-->
            <!--            <span>Welcome to Foodstore!</span> </div>-->
            <!--    </div>-->
            <!--</div>-->
            
            
        <!--/div>
    </div>
</div-->