<div class="col-xs-12 col-sm-9 ">
    <div class="my-account">
        <div class="page-title">
            <h2><?=$this->lang->line("My Address")?></h2>
        </div>
        <div class="wishlist-item table-responsive">
            <?php if(!empty($address)):
                foreach($address as $row){ 
                    $address_id         =    $row->location_id;
                    $pincode            =    !empty($row->pincode) ? '-'.$row->pincode : '';
                    $house_no           =    $row->house_no;
                    $receiver_name      =    $row->receiver_name;
                    $receiver_mobile    =    $row->receiver_mobile;
                    $state              =    !empty($row->state) ? ', '.$row->state : '';
                    $city               =    !empty($row->city) ? ', '.$row->city : '';
                    $landmark           =    !empty($row->landmark) ? ', '.$row->landmark : '';
                    $socity_name        =    !empty($row->socity_name) ? ', '.$row->socity_name : '';
                    
            ?>
                <div class="col-md-5" style="border:1px solid #ccc; padding:8px; margin-right:10px; min-height: 190px; max-height: 190px; margin-top: 6px;">
						<div class="pull-right text-success" style="font-size: 25px;">
						<?php
						
						if(!empty($row->default_address)){
							?>
							<i class="fa fa-check-circle"></i>
							<?php
						}

						?>
						</div>
                        <p><strong><?=$this->lang->line("Name")?> : </strong> <?=$receiver_name?></p>
                        <p><strong><?=$this->lang->line("Mobile No.")?> : </strong> <?=$receiver_mobile?></p>
                        <p><strong><?=$this->lang->line("Address")?> : </strong> <?=$house_no.$landmark.$socity_name.$city.$state.$pincode?></p>
                        <div style="text-align: center;">
                            <a class="btn btn-danger" href="{base_url}deleteaddres/<?=$address_id?>"><i class="fa fa-trash"></i></a>
                            <a class="btn btn-primary" href="{base_url}edit_addres/<?=$address_id?>"><i class="fa fa-edit"></i></a>
                        </div>
                </div>
            
            <?php } endif;?>
        </div>
    </div>
</div>
<!-- jquery js --> 
<script type="text/javascript" src="{base_url}assets/js/jquery.min.js"></script> 