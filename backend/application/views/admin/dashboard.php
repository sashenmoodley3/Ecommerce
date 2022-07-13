<?php  $this->load->view("admin/common/head"); 

$sevendaySale   =   $this->db->query("SELECT SUM(total_amount) as seven FROM sale WHERE date(sale.created_at) >= DATE(NOW()) - INTERVAL 7 DAY AND sale.created_at <= DATE(NOW())- INTERVAL 6 DAY")->row_array();
$sixdaySale     =   $this->db->query("SELECT SUM(total_amount) as six FROM sale WHERE date(sale.created_at) >= DATE(NOW()) - INTERVAL 6 DAY AND sale.created_at <= DATE(NOW())- INTERVAL 5 DAY")->row_array();
$fivedaySale    =   $this->db->query("SELECT SUM(total_amount) as five FROM sale WHERE date(sale.created_at) >= DATE(NOW()) - INTERVAL 5 DAY AND sale.created_at <= DATE(NOW())- INTERVAL 4 DAY")->row_array();
$fourdaySale    =   $this->db->query("SELECT SUM(total_amount) as four FROM sale WHERE date(sale.created_at) >= DATE(NOW()) - INTERVAL 4 DAY AND sale.created_at <= DATE(NOW())- INTERVAL 3 DAY")->row_array();
$threedaySale   =   $this->db->query("SELECT SUM(total_amount) as three FROM sale WHERE date(sale.created_at) >= DATE(NOW()) - INTERVAL 3 DAY AND sale.created_at <= DATE(NOW())- INTERVAL 2 DAY")->row_array();
$twodaySale     =   $this->db->query("SELECT SUM(total_amount) as two FROM sale WHERE date(sale.created_at) >= DATE(NOW()) - INTERVAL 2 DAY AND sale.created_at <= DATE(NOW())- INTERVAL 1 DAY")->row_array();
$onedaySale     =   $this->db->query("SELECT SUM(total_amount) as one FROM sale WHERE date(sale.created_at) >= DATE(NOW()) - INTERVAL 1 DAY AND sale.created_at <= DATE(NOW())")->row_array();
$zerodaySale    =   $this->db->query("SELECT SUM(total_amount) as zero FROM sale WHERE date(sale.created_at) = DATE(NOW())")->row_array();
$total_product  =   $this->db->query("SELECT count(product_id) as total_product FROM products WHERE trash=0")->row_array();
$total_categories = $this->db->query("SELECT count(id) as total_categories FROM categories")->row_array();
$count_brand    =   $this->db->query("SELECT count(id) as total_brand FROM tbl_brand WHERE 1 AND trash = 0")->row();
$total_brand    =   $count_brand->total_brand;

$seven          =   !empty($sevendaySale['seven']) ? $sevendaySale['seven'].', ' : '';
$six            =   !empty($sixdaySale['six']) ? $sixdaySale['six'].', ' : '';
$five           =   !empty($fivedaySale['five']) ? $fivedaySale['five'].', ' : '';
$four           =   !empty($fourdaySale['four']) ? $fourdaySale['four'].', ' : '';
$three          =   !empty($threedaySale['three']) ? $threedaySale['three'].', ' : '';
$two            =   !empty($twodaySale['two']) ? $twodaySale['two'].', ' : '';
$one            =   !empty($onedaySale['one']) ? $onedaySale['one'].', ' : '';
$zero           =   !empty($zerodaySale['zero']) ? $zerodaySale['zero'].', ' : '';
$data           =    $zero.$one.$two.$three.$four.$five.$six.$seven;

//echo "ramakant-".$data."-singh";

$shortProduct   =   $this->db->query("SELECT product_varient.*, products.product_name, products.product_id, product_varient.stock_inv as stock,  categories.title 
FROM product_varient 
                        			INNER JOIN products ON products.product_id = product_varient.product_id
                        			INNER JOIN categories ON categories.id = products.category_id 
                                    LEFT  JOIN (select SUM(qty) as c_qty,product_id from sale_items 
                                    INNER JOIN sale ON sale.sale_id= sale_items.sale_id AND sale.status !=3 group by product_id) as consuption on consuption.product_id = product_varient.product_id 
                                    LEFT JOIN(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = product_varient.product_id 
                                    WHERE 1 AND products.trash = 0");
$shortProduct_result    =   $shortProduct->result();    
$count_short    =   0;
foreach($shortProduct_result as $short_pro){
    if($short_pro->stock <= $this->config->item('out_of_stock_quantity')){
        $count_short  += 1;
    }
    
}
?>
<style>
	.tiles .card-content {
        height: 145px;
    }
	.tiles .card-footer {
        height: 65px;
    }
	canvas{
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	.animated {
        -webkit-animation-duration: 2s;
        animation-duration: 2s;
        -moz-user-select: none;
        -ms-user-select: none;
        -webkit-user-select: none;
    }
    
    .yt-loader {
        -webkit-animation-name: horizontalProgressBar;
        animation-name: horizontalProgressBar;
        -webkit-animation-timing-function: ease;
        animation-timing-function: ease;
        background: #ef534e;
        height: 3px;
        left: 0;
        top: 0;
        width: 0%;
        z-index: 9999;
        position:relative;
    }
    
    .yt-loader:after{
      display: block;
      position: absolute;
      content:'';
      right: 0px;
      width: 100px;
      height: 100%;
      box-shadow: #ef534e 1px 0 6px 1px;
      opacity: 0.5;
    }
    @keyframes horizontalProgressBar
    {
        0%   {width: 0%;}
        20%  {width: 10%;}
        30%  {width: 15%;}
        40%  {width: 18%;}
        50%  {width: 20%;}
        60%  {width: 22%;}
        100% {width: 100%;}
    }
	</style>
<body>
    <div class="animated yt-loader"></div>
    <div class="wrapper">
        <!-- side -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel" <?php if($this->session->userdata('language') == "arabic"){ echo 'style="float:left"'; } ?>>
            <!-- head-->
            <?php  $this->load->view("admin/common/header"); ?>
            <!-- content -->
            <div class="content">
                <div class="container-fluid">
                    <?php if(isset($message) && $message!=""){
                            echo $message;
                        } ?>
                    
                    <div class="row tiles" style="margin-top: 50px;">
                        <div class="col-lg-3 col-md-6 col-sm-6">
							<!--<a href="<?php echo site_url("admin/orders"); ?>">-->
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Daily Orders");?></p>
                                    <?php
                                        $date=date("Y-m-d");
                                   // echo "SELECT SUM(total_amount) as total FROM sale WHERE date(created_at)='".$date."'";
                                        $d = $this->db->query("SELECT SUM(total_amount) as total FROM sale WHERE status = 4 and date(created_at)='".$date."'");
                                        $row=$d->row_array();
                                        //print_r($row);
                                    ?>
                                    <h3 class="card-title"><?php if(empty($row['total'])){ echo 0;} else{echo $row['total'];} ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <?php 
                                        $e = $this->db->query("SELECT SUM(total_amount) as total FROM sale WHERE status = 4"); 
                                        $row= $e->row_array(); ?>
                                        <i class="material-icons">money</i><?php echo $this->lang->line("Total Revenue Till Date");?><span style="margin-right:0px !important">&emsp;&emsp;<?php echo number_format($row['total'],'2','.','') ?></span>
                                    </div>
                                </div>
                            </div>
                            <!--</a>-->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="rose">
                                    <i class="material-icons">group</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Totalnumberofusers");?></p>
                                    <?php 
                                        $c = $this->db->query("SELECT * FROM registers"); ?>
                                    <h3 class="card-title"><?php echo $c->num_rows(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="rose">
                                    <i class="material-icons">add_shopping_cart</i>
                                </div>
                                
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Totalnumberoftodayorder");?></p>
                                    <?php 
                                        $date=date("Y-m-d");
                                        $a = $this->db->query("SELECT * FROM sale WHERE on_date='".$date."'"); 
                                        
                                    ?>
                                    <h3 class="card-title"><?php echo $a->num_rows(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="rose">
                                    <i class="material-icons">shopping_cart</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Totalnumberofdeliveredorder");?></p>
                                    <?php 
                                        $c = $this->db->query("SELECT * FROM sale WHERE status=4 "); ?>
                                    <h3 class="card-title"><?php echo $c->num_rows(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">network_check</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Total Product");?></p>
                                    <?php /*
                                        $d = $this->db->query("SELECT SUM(total_amount) as total FROM sale WHERE status=4 AND on_date='".$date."'");
                                        $row=$d->row_array();*/?>
                                    <h3 class="card-title"><?php if(empty($total_product['total_product'])){ echo 0;} else{echo $total_product['total_product'];} ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">category</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Total Category");?></p>
                                    <?php /*
                                        $d = $this->db->query("SELECT SUM(total_amount) as total FROM sale WHERE status=4 AND on_date='".$date."'");
                                        $row=$d->row_array();*/?>
                                    <h3 class="card-title"><?php if(empty($total_categories['total_categories'])){ echo 0;} else{echo $total_categories['total_categories'];} ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">multiline_chart</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Product Short");?></p>
                                    <h3 class="card-title"><?=$count_short?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">grade</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Total Brand");?></p>
                                    <h3 class="card-title"><?=$total_brand?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">add_shopping_cart</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Total pending Order");?></p>
                                    
                                    <?php 
                                        $c1 = $this->db->query("SELECT * FROM sale WHERE status=0 "); ?>
                                    <h3 class="card-title"><?php echo $c1->num_rows(); ?></h3>
<!--                                    <h3 class="card-title"><?=$total_brand?></h3>-->
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">remove_shopping_cart</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Total Cancelled Order");?></p>
                                    <?php 
                                        $c2 = $this->db->query("SELECT * FROM sale WHERE status=3 "); ?>
                                    <h3 class="card-title"><?php echo $c2->num_rows(); ?></h3>
<!--                                    <h3 class="card-title"><?=$total_brand?></h3>-->
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">add_shopping_cart</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Total Returned Order");?></p>
                                    <?php 
                                        $c3 = $this->db->query("SELECT * FROM refund_request WHERE status=8  "); ?>
                                    <h3 class="card-title"><?php echo $c3->num_rows(); ?></h3>
<!--                                    <h3 class="card-title"><?=$total_brand?></h3>-->
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">transform</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Total Returned Request");?></p>
                                    <?php 
                                        $c4 = $this->db->query("SELECT * FROM sale where `status` = '-1'"); ?>
                                    <h3 class="card-title"><?php echo $c4->num_rows(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                                                

                                                

                                                

                        
                       
                        <!--div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="blue">
                                    <i class="material-icons">star</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php /*echo $this->lang->line("Today Reward");*/?></p>
                                    <?php /*
                                        $f = $this->db->query("SELECT SUM(total_rewards) as total FROM sale WHERE status=4 AND on_date='".$date."'");
                                        $row=$f->row_array();*/?>
                                    <h3 class="card-title"><?php /*if(empty($row['total'])){ echo 0;} else{echo $row['total'];} */?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <?php /*
                                        $g = $this->db->query("SELECT SUM(total_rewards) as total FROM sale WHERE status=4"); 
                                        $row= $g->row_array();*/?>
                                        <i class="material-icons">star</i><?php /*echo $this->lang->line("Total Rewards Till Date");*/?><span style="margin-right:0px !important">&emsp;&emsp;&emsp;<?php /*echo $row['total'] */?></span>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    
                    <?//="ramakant-".$zero.",-".$one.",-".$two.",-".$three.",-".$four.",-".$five.",-".$six.",-".$seven."-singh";?>
<!--                    <br>-->
                    <?//="SELECT SUM(total_amount) as zero FROM sale WHERE date(sale.created_at) = DATE(NOW())"?>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="card card-chart">
                            <div class="card-header card-header-success">
                              <canvas id="canvas"></canvas>
                            </div>
                            <div class="card-body">
                              <h4 class="card-title"><?=$this->lang->line("Daily Sales")?></h4>
                              <!--<p class="card-category">-->
                              <!--  <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>-->
                            </div>
                            <div class="card-footer">
                              <div class="stats">
                                <i class="material-icons">access_time</i> updated
                              </div>
                            </div>
                          </div>
                        </div>
            <!--            <div class="col-md-4">-->
            <!--              <div class="card card-chart">-->
            <!--                <div class="card-header card-header-warning">-->
            <!--                  <div class="ct-chart" id="websiteViewsChart"></div>-->
            <!--                </div>-->
            <!--                <div class="card-body">-->
            <!--                  <h4 class="card-title">Email Subscriptions</h4>-->
            <!--                  <p class="card-category">Last Campaign Performance</p>-->
            <!--                </div>-->
            <!--                <div class="card-footer">-->
            <!--                  <div class="stats">-->
            <!--                    <i class="material-icons">access_time</i> campaign sent 2 days ago-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--            </div>-->
            <!--            <div class="col-md-4">-->
            <!--              <div class="card card-chart">-->
            <!--                <div class="card-header card-header-danger">-->
            <!--                  <div class="ct-chart" id="completedTasksChart"></div>-->
            <!--                </div>-->
            <!--                <div class="card-body">-->
            <!--                  <h4 class="card-title">Completed Tasks</h4>-->
            <!--                  <p class="card-category">Last Campaign Performance</p>-->
            <!--                </div>-->
            <!--                <div class="card-footer">-->
            <!--                  <div class="stats">-->
            <!--                    <i class="material-icons">access_time</i> campaign sent 2 days ago-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--</div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Today Order");?>:</h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
<!--                                                    <th class="text-center">--><?php //echo $this->lang->line("Socity");?><!--</th>-->
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Time");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
<!--                                                    <th class="text-center">--><?php //echo $this->lang->line("Socity");?><!--</th>-->
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Time");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($today_orders as $order ){ ?>
                                                <tr>
                                                    <th class="text-center"><?php echo $order->sale_id; ?></th>
                                                    <th class="text-center"><?php echo $order->user_fullname; ?></th>
<!--                                                    <th class="text-center">--><?php //echo $order->socity_name; ?><!--</th>-->
                                                    <th class="text-center"><?php echo $order->user_phone; ?></th>
                                                    <th class="text-center"><?php echo $order->on_date; ?></th>
                                                    <th class="text-center"><?php echo date("H:i A", strtotime($order->delivery_time_from))." - ".date("H:i A", strtotime($order->delivery_time_to)); ?></th>
                                                    <th class="text-center"><?php echo $order->total_amount; ?></th>
                                                    <th class="text-center">
                                                        <?php if($order->status == 0){
                                                            echo "<span class='label label-default'>Pending</span>";
                                                        }else if($order->status == 1){
                                                            echo "<span class='label label-success'>Confirm</span>";
                                                        }else if($order->status == 2){
                                                            echo "<span class='label label-info'>Delivered</span>";
                                                        }else if($order->status == 3){
                                                            echo "<span class='label label-danger'>cancel</span>";
                                                        }  ?>
                                                    </th>

                                                    <td class="td-actions text-center"><div class="btn-group">
                                                            <?php echo anchor('admin/orderdetails/'.$order->sale_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">assignment</i>
                                                        </button>', array("class"=>"")); ?>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Next Orders to be Deliver");?></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
<!--                                                    <th class="text-center">--><?php //echo $this->lang->line("Socity");?><!--</th>-->
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Time");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
<!--                                                    <th class="text-center">--><?php //echo $this->lang->line("Socity");?><!--</th>-->
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Time");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($today_deli_orders as $order){ ?>
                                                <tr>
                                                    <th class="text-center"><?php echo $order->sale_id; ?></th>
                                                    <th class="text-center"><?php echo $order->user_fullname; ?></th>
<!--                                                    <th class="text-center">--><?php //echo $order->socity_name; ?><!--</th>-->
                                                    <th class="text-center"><?php echo $order->user_phone; ?></th>
                                                    <th class="text-center"><?php echo $order->on_date; ?></th>
                                                    <th class="text-center"><?php echo date("H:i A", strtotime($order->delivery_time_from))." - ".date("H:i A", strtotime($order->delivery_time_to)); ?></th>
                                                    <th class="text-center"><?php echo $order->total_amount; ?></th>
                                                    <th class="text-center">
                                                        <?php if($order->status == 0){
                                                            echo "<span class='label label-default'>Pending</span>";
                                                        }else if($order->status == 1){
                                                            echo "<span class='label label-success'>Confirm</span>";
                                                        }else if($order->status == 2){
                                                            echo "<span class='label label-info'>Delivered</span>";
                                                        }else if($order->status == 3){
                                                            echo "<span class='label label-danger'>cancel</span>";
                                                        }  ?>
                                                    </th>

                                                    <td class="td-actions text-center"><div class="btn-group">
                                                            <?php echo anchor('admin/orderdetails/'.$order->sale_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">assignment</i>
                                                        </button>', array("class"=>"")); ?>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    
                    <!-- Short Product List -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Short Product List");?></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class=""><?php echo $this->lang->line("id");?></th>
                                                    <th class=""><?php echo $this->lang->line("Product Name");?></th>
                                                    <th class=""><?php echo $this->lang->line("Product Variation");?></th>
                                                    <th class=""><?php echo $this->lang->line("Category");?></th>
                                                    <th class=""><?php echo $this->lang->line("Stock");?></th>
                                                    <th class=""><?php echo $this->lang->line("Update Stock");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class=""><?php echo $this->lang->line("id");?></th>
                                                    <th class=""><?php echo $this->lang->line("Product Name");?></th>
                                                    <th class=""><?php echo $this->lang->line("Product Variation");?></th>
                                                    <th class=""><?php echo $this->lang->line("Category");?></th>
                                                    <th class=""><?php echo $this->lang->line("Stock");?></th>
                                                    <th class=""><?php echo $this->lang->line("Update Stock");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($shortProduct_result as $products){ 
                                                    if($products->stock <= $this->config->item('out_of_stock_quantity')){
                                                ?>
                                                <tr>
                                                    <th class=""><?php echo $products->product_id; ?></th>
                                                    <th class=""><?php echo $products->product_name; ?></th>
                                                    <th class=""><?php echo $products->qty.''.$products->unit; ?></th>
                                                    <th class=""><?php echo $products->title; ?></th>
                                                    <th class=""><?php echo $products->stock; ?></th>
                                                    <td class="td-actions"><div class="btn-group">
                                                            <?php echo anchor('admin/edit_purchase/'.$products->product_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">edit</i>
                                                        </button>', array("class"=>"")); ?>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php }  } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                </div>
            </div>
            <!-- Foot -->
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/utils.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>
<script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
        } );
    </script>
    
<script>
		var MONTHS = ['1', '2', '3', '4', '5', '6', '7'];
		var config = {
			type: 'line',
			data: {
				labels: ['1', '2', '3', '4', '5', '6', '7'],
				datasets: [{
					label: 'sales',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						<?=$data?>
					],
					fill: false,
				}]
			},
			options: {
				
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					x: {
						display: true,
						scaleLabel: {
                            
							display: true,
							labelString: 'Month'
						}
					},
					y: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});

			});

			window.myLine.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var colorName = colorNames[config.data.datasets.length % colorNames.length];
			var newColor = window.chartColors[colorName];
			var newDataset = {
				label: 'Dataset ' + config.data.datasets.length,
				backgroundColor: newColor,
				borderColor: newColor,
				data: [],
				fill: false
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
			}

			config.data.datasets.push(newDataset);
			window.myLine.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				var month = MONTHS[config.data.labels.length % MONTHS.length];
				config.data.labels.push(month);

				config.data.datasets.forEach(function(dataset) {
					dataset.data.push(randomScalingFactor());
				});

				window.myLine.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myLine.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first

			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myLine.update();
		});
	</script>

</html>