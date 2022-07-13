<!-- Main Container -->
<section class="main-container col2-right-layout">
    <div class="main container">
        
        <?php
        if(!empty($place_order_detalis)):
        ?>
        <form id="frm_checkout" action="place_order" method="post">
            <div class="row">
                <div class="col-main col-sm-12 col-xs-12">
                    <div class="page-content checkout-page">
                        <?php
                        if (isset($page_1)) {
                            $this->load->view($page_1);
                        }
                        ?>

                    </div>
                </div>
            </div>
        </form>
        <?php
        else:
            $this->load->view('home/page/checkout.section/template.empty_cart.php');
        endif;
        ?>
    </div>
</section>
<?php
if (isset($add_address)) {
    $this->load->view($add_address);
}
?>