<!-- Home Slider Start -->
<?php $this->load->view("common/slider/template.home.slider.php"); ?>
<!-- service section -->
<?php //$this->load->view("home/page/content.section/service.section.php"); ?>
<!--special-products-->
<?php $this->load->view("home/page/content.section/1.php"); ?>

<?php $this->load->view("home/page/content.section/2.php"); ?>
<!-- main container -->
<?php $this->load->view("home/page/content.section/3.php"); ?>
<!-- Static Banner -->
<?php $this->load->view("home/page/content.section/4.php"); ?>
<!-- Testimonials Box -->
<?php //$this->load->view("home/page/content.section/5.php"); ?>
<?php //$this->load->view("home/page/content.section/7.php"); ?>
<!--featured brands-->
<!-- Admin Popup Show - START -->

            <?php
            if(!empty($this->config->item('popup_desc')))
            {
            ?>
                <style>
                    .close-btn{
                        position: absolute;
                        right: -37px;
                        border: 1px solid;
                        border-radius: 92%;
                        width: 20px;
                        height: 20px;
                        text-align: center;
                        color: #fff;
                        top: -23px;
                    }
                    .modal-body p{
                        margin: 0px;
                        padding: 5px;
                    }
                </style>
                <a class="AdminView" data-toggle="modal" data-target="#popup_view"></a>
                <div class="modal fade product_view" id="popup_view" role="dialog">
                    <div class="modal-dialog" style="margin:100px auto">
                        <div class="modal-content">
                            <div class="modal-body" style="padding: 0px;">
                                <a href="#" data-dismiss="modal" class="class pull-right close-btn"><span class="glyphicon glyphicon-remove"></span></a>
                                <?php
                                    $popup_desc_type  = $this->config->item('popup_desc_type');
                                    $popup_desc = base64_decode($this->config->item('popup_desc'));
                                    if($popup_desc_type=="description"){
                                        echo $popup_desc;
                                    }
                                    else if($popup_desc_type=="image"){
                                        if(strpos($popup_desc, '<img')){
                                            echo $popup_desc;
                                        }
                                        else{
                                            echo  '<img src="'.$popup_desc.'" class="img-responsive">';
                                        }
                                    }
                                    else if($popup_desc_type=="video"){ ?>
                                        <iframe src="<?=$popup_desc;?>" >
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Admin Popup Show - END -->