<!-- Main Container -->
<section class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <?php $this->load->view("home/page/account.section/left.menu.php"); ?>
            <div class="col-main col-sm-9 col-xs-12">
                <div class="my-account">
                    <div class="page-title">
                        <h2><?=$this->lang->line("My Wishlist")?></h2>
                    </div>
                    <div class="wishlist-item table-responsive">
                        <table class="col-md-12">
                            <thead>
                                <tr>
                                    <th class="th-delate"><?=$this->lang->line("Remove")?></th>
                                    <th class="th-product"><?=$this->lang->line("Images")?></th>
                                    <th class="th-details"><?=$this->lang->line("Product Name")?></th>
                                    <th class="th-total th-add-to-cart"><?=$this->lang->line("Add to Cart")?> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                 $user_id  = $this->session->userdata('user_id');
                                 $wishlist_user   =  $this->db->query("select * from btl_wishlist w INNER JOIN products p on p.product_id = w.product_id where status = 1 and  user_id = '".$user_id."' and trash=0 ")->result();
                                   
                                if(!empty($wishlist_user)){
                                foreach($wishlist_user as $value){ 
                                    $pro1               = explode(',',$value->product_image);
                                    $product_image      = $product_img_url. $pro1[0];
                                    $q_variants         = $this->db->query("Select * from product_varient where product_id = '".$value->product_id."'");
							        $variants_pro       = $q_variants->result_array();
							        if(!empty($variants_pro[0]['pro_var_images'])){
                                        $product_image  = base_url().'backend/uploads/products/'.$variants_pro[0]['pro_var_images'];
                                    }
                                   
                                    ?>
                                <tr>
                                    <td class="th-delate"><a href="<?=base_url()?>remove_wishlist/<?=$value->product_id?> ">X</a></td>
                                    <td class="th-product" ><a href="<?=base_url()?>product/<?=$value->product_slug?>"><img src="<?=$product_image?>" alt="cart"></a></td>
                                    <td class="th-details" style="    text-align: center;"><p><a href="<?=base_url()?>product/<?=$value->product_slug?>"><?=$value->product_name?></a></p></td>
                                    <th class="td-add-to-cart"><a href="<?=base_url()?>product/<?=$value->product_slug?>"><?=$this->lang->line('View Product')?></a></th>
                                </tr>
                                <?php } }else{?>
                                <tr>
                                    <td colspan="4"><b><?=$this->lang->line("NO RESULT FOUND")?></b></td>
                                </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>