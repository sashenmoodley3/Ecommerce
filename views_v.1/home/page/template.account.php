<section class="blog_post">
    <div class="container">
        <?php if($this->config->item('product_setup') == 'demo'){ ?>
            <div class="nav text-center" style="top: -13px; position: relative; text-align: center;">
                <i class="text-danger blink_me fa fa-exclamation-triangle" style="font-size: 16px"></i>
                For demo purpose many operations including deletion,emailing,file uploading are <strong>DISABLED</strong>
            </div>
        <?php } ?>
            
        <!-- row -->
        <div class="row">
            <?php $this->load->view("home/page/account.section/left.menu.php"); ?>
            <?php $this->load->view($page_1); ?>
        </div>
    </div>
</section>