<?php //print_r($getSlider);

if(!empty($getSlider)){

	
	//echo $slide[slider_title];
	//echo " ";
	//echo base_url()."backend/uploads/sliders";

?>

<div class="slider">
    <div class="tp-banner-container clearfix" >
        <div class="tp-banner" >
            <ul>
			<?php foreach($getSlider as $slide){ 
			    $subcat   =  $this->db->query("SELECT * FROM categories WHERE id ='".$slide['sub_cat']."' ")->row();
			   // print_r($subcat); exit;
			if($slide['slider_status']!=0){
			?>
                <!-- SLIDE 1 -->
                <li data-transition="slidehorizontal" data-slotamount="5" data-masterspeed="700" >
                    <!-- MAIN IMAGE -->
                    <a target="_blank" href="<?=base_url().'shop/'.$subcat->slug?>">
                    <img src="<?php echo base_url()."backend/uploads/sliders/". $slide['slider_image'];?>" alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" class="img-responsive" ></a>
                    <!-- LAYERS --></li>
			<?php }
			
			}?>
            </ul>
        </div>
    </div>
</div>
<?php }?>
<!-- LAYER NR. 1 -->
                   <!-- <div class="tp-caption very_big_white skewfromrightshort fadeout"
                         data-x="150"
                         data-y="100"
                         data-speed="500"
                         data-start="1200"
                         data-easing="Circ.easeInOut"
                         style=" font-size:70px; font-weight:800; color:#fff;"><?php //echo $slide[slider_title];?>
					</div> -->