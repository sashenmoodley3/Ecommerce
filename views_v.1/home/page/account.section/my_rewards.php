<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="col-xs-12 col-sm-9 ">
    <div class="my-account">
        <div class="page-title">
            <h2><?=$this->lang->line("My Rewards")?></h2>
            <div class="">
                <h5><?=$this->lang->line("Total Rewards")?>: <span class="" style="font-size: 16px;color: #fe7e29;font-weight: 900;"><?=$reward?></span></h5>

            </div>
        </div>
        <div class="wishlist-item table-responsive">
            <h5><?=$this->lang->line("Rewards")?> :</h5>
            <p>
			<?=$this->config->item('reward_point_to_wallet')?>
			<?=$this->lang->line("Point")?> = 
			<?=$this->config->item('reward_amount_to_wallet');?> 
			<?=$this->config->item('currency');?> 
			
			
			</p>
			<p>
			
			<?php 
			
			$reward_min_transfer = $this->config->item('reward_min_point_transfer');
			if(!empty($reward_min_transfer) && $reward_min_transfer < $reward){ 
				$reward_point_to_wallet = $this->config->item('reward_point_to_wallet');
				$reward_amount_to_wallet = $this->config->item('reward_amount_to_wallet');
				$total_amount = 0;
				if(!empty($reward_amount_to_wallet) && !empty($reward_point_to_wallet)){
					$total_amount = $reward*$reward_amount_to_wallet/$reward_point_to_wallet;
				}
				if(!empty($total_amount)){
			?>
				<a class="btn btn-success" href="{base_url}redeem_reward"><?=$this->lang->line("Redeem Amount")?> (<?=$total_amount?><?=$this->config->item('currency');?>) </a>
            <?php 
				}
			}
			?>
			</p>
            <h5><?=$this->lang->line("Rewards History")?> :</h5>
            <?php if(!empty($reward_history)):?>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="th-details"><?=$this->lang->line("Date")?></th>
                        <th class="th-details"><?=$this->lang->line("Point")?></th>
                        <th class="th-price"><?=$this->lang->line("Amount")?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //var_dump($user_order_list);
                    foreach ($reward_history as $key => $value):
                        $point = $value->point;
                        $amount = $value->amount;
                        $created_date = $value->created_date;
                    ?>
                    <tr>
                        <td class="th-product"><?=$created_date?></td>
                        <td class="th-product"><?=$point?></td>
                        <td class="th-product"><?=$amount?></td>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php endif;?>
            
        </div>
    </div>
</div>
<!-- jquery js --> 
<script type="text/javascript" src="{base_url}assets/js/jquery.min.js"></script> 