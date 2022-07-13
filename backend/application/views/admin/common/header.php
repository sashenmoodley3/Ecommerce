<?php
$count_new_sale    =   $this->db->query("SELECT count(sale_id) as total FROM sale WHERE is_admin_saw = 0")->row();
$total_new_sale    =   $count_new_sale->total;
$backend_colour_button     = getButtonColour($this->setting_model->get_themesettings('back'));

function getButtonColour($values) {
    foreach($values as $value) {
        if($value->meta_key=='button_background'){
            return $value->meta_value;
        }
    }
}   

?>

<style type="text/css">
.navbar .navbar-nav > li > a:hover, 
.navbar .navbar-nav > li > a:focus    
{
    color:white;
}

.navbar .navbar-nav > .open > a, .navbar .navbar-nav > .open > a:hover, .navbar .navbar-nav > .open > a:focus{
	background-color: #d1823a !important;
}
.count{
    font-size: 12px;
    /* font-weight: 900; */
    position: absolute;
    border: solid blue;
    border-radius: 60%;
    height: 18px;
    min-width: 18px;
    background: blue;
    top: -3px;
    right: -3px;
    z-index: 99999;
    line-height: 13px;
}

/*
.blink {
  animation: blink-animation 1s steps(5, start) infinite;
  -webkit-animation: blink-animation 1s steps(5, start) infinite;
}
@keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
@-webkit-keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
    */
.dropdown-menu .dropdown-item, .dropdown-menu li>a {
        position: relative;
        width: auto;
        display: flex;
        flex-flow: nowrap;
        align-items: center;
        color: #333;
        font-weight: 400;
        text-decoration: none;
        font-size: 15px;
        border-radius: .125rem;
        margin: 0 .3125rem;
        transition: all .15s linear;
        min-width: 7rem;
        padding: .625rem 1.25rem;
        overflow: hidden;
        line-height: 1.428571;
        text-overflow: ellipsis;
        word-wrap: break-word;
    }
    .navbar .navbar-nav .dropdown-menu-right {
        transform-origin: 100% 0;
    }
    .dropdown-divider {
    height: 0;
    margin: .5rem 0;
    overflow: hidden;
    border-top: 1px solid #e9ecef;
}
.navbar .navbar-nav > li > a {
    color: inherit;
    padding-top: 15px;
    padding-bottom: 15px;
    font-weight: 500;
    font-size: 12px;
    text-transform: uppercase;
    border-radius: 3px;
}
.navbar .navbar-nav > li > .dropdown-menu.dropdown-menu-right.notify {
    height: 300px;
    overflow-y: auto;
}

</style>
<nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> <?php echo $this->lang->line("Dashboard");?> </a>
                    </div>
                    
                    
                    <div class="collapse navbar-collapse">
                        
                        <?php if(!empty($this->config->item('notification_msg'))){ ?>
                            <div class="nav text-center" style="display: inline-block;  top: 13px; position: relative; text-align: center;">
                                <i class="text-danger blink_me fa fa-bell" style="font-size: 16px"></i> 
                                <?=$this->config->item('notification_msg')?>
                            </div>
                        <?php } 
                        if($this->config->item('product_setup') == 'demo'){ ?> 
                            <div class="nav text-center" style="display: inline-block;  top: 13px; position: relative; text-align: center;">
                                <i class="text-danger blink_me fa fa-exclamation-triangle" style="font-size: 16px"></i>
                                For demo purpose many operations including deletion,emailing,file uploading are <strong>DISABLED</strong>
                            </div>
                        <?php } ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a style="background-color:<?php echo $backend_colour_button ?>" href="<?=base_url('../')?>" target="_blank" title="Visit Website">
                                    <i class="fa fa-map-marker"></i>
                                    <p class="hidden-lg hidden-md">Visit Website</p>
                                </a>
                            </li>
                            <?php 
                                $notification = $this->config->item('notification');
                                if(isset($notification) && !empty($notification)):?>
                            <!--<li class="dropdown user user-menu"><!-- class="dropdown-toggle" data-toggle="dropdown" -->
                            <!--    <a href="<?php echo site_url("admin/orders"); ?>"
                            <!--       title="Pending Orders">-->
                            <!--        <span class=""><i class="fa fa-bell" aria-hidden="true">-->
                            <!--                <span class="badge badge-light" style="position: relative;margin-top: -25px;margin-left: -6px;background-color: red;">-->
                            <!--                    <?=$notification?>
                            <!--                </span></i></span>-->
                            <!--    </a>-->
                            <!--    <ul class="dropdown-menu dropdown-menu-right">-->
                            <!--       <li>-->
                                    
                            <!--       </li>-->
                            <!--       <li>-->
                                    
                            <!--       </li>-->
                            <!--    </ul>-->
                            <!--</li>-->
                            <?php endif;?>
                            <li>
                                <a style="background-color:<?php echo $backend_colour_button ?>" href="<?=base_url()?>admin/edit_mainadmin/<?php echo _get_current_user_id($this)?>" title="Profile">
                                    <i class="fa fa-user"></i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                            </li>
                            
                            <?php
                                $all_new_orders    =   $this->db->query("SELECT * FROM sale WHERE is_admin_saw = 0")->result_array();
                                //$all_new_orders    =   $count_new_sale->total;
                                   //print_r($all_new_orders);
                            ?>
                            
                            
                            <li class="nav-item dropdown">
                                <a style="background-color:<?php echo $backend_colour_button ?>"  title="New Orders" class="nav-link order_ajax" href="<?=base_url()?>admin/edit_mainadmin/<?php echo _get_current_user_id($this)?>" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="count blink">
                                      <?=$total_new_sale?$total_new_sale:"0";?>
                                    </span>
<!--                                  <p class="">New Orders/p>-->
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right notify" aria-labelledby="navbarDropdownProfile">
                                    
                                <?php 
                                    foreach($all_new_orders as $new_order)
                                    { 
                                        $order_detail = "New Order #".$new_order["sale_id"]. " of ".$this->config->item('currency')." ".number_format($new_order["total_amount"], 2, ".","")." has arrived.";
                                    
                                    ?>
                                  <a style="width: 300px; border-bottom:1px solid #ccc;" class="dropdown-item" href="<?php echo site_url("admin/orderdetails/". $new_order["sale_id"])?>"><?=$order_detail;?></a>
                                <?php } ?>
                                  
                                </div>
                            </li>
                            
<!--
                            <li class="nav-item dropdown">
                                <a  title="Profile" class="nav-link" href="<?=base_url()?>admin/edit_mainadmin/<?php echo _get_current_user_id($this)?>" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="material-icons">person</i>
                                  <p class="hidden-lg hidden-md">Profile/p>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                  <a class="dropdown-item" href="<?=base_url()?>admin/edit_mainadmin/<?php echo _get_current_user_id($this)?>">Profile</a>
                                  
                                  <a class="dropdown-item" href="<?php echo site_url("admin/signout") ?>">Log out</a>
                                </div>
                            </li>
-->
                            <li>
                                <a style="background-color:<?php echo $backend_colour_button ?>" href="<?php echo site_url("admin/signout") ?>" title="Logout">
                                    <i class="fa fa-sign-out"></i>
                                    <p class="hidden-lg hidden-md">Logout</p>
                                </a>
                            </li>
                        </ul>
                        <!--<form class="navbar-form navbar-right" role="search">-->
                        <!--    <div class="form-group form-search is-empty">-->
                        <!--        <input type="text" class="form-control" placeholder="Search">-->
                        <!--        <span class="material-input"></span>-->
                        <!--    </div>-->
                        <!--    <button type="submit" class="btn btn-white btn-round btn-just-icon">-->
                        <!--        <i class="material-icons">search</i>-->
                        <!--        <div class="ripple-container"></div>-->
                        <!--    </button>-->
                        <!--</form>-->
                    </div>
                    
                    
                </div>
            </nav>
            

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //alert("1");
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         //alert("ram");
         var update = new Date().getTime() - time;
        
		if(update >= 60000)
		{
			 //alert("fresh");
			 // window.location.reload(true);
			 
			 
		}
		else 
		{
			setTimeout(refresh, 10000);
		}
     }

     setInterval(refresh, 10000);
	 
	  setInterval(function (){
		 $.ajax({
				type: "post",
				url: "<?=base_url()?>admin/order_notification",
				dataType: "json",
				success: function (response) {
					if(response.status == 1){
						$('.order_ajax .count').text(response.data)
						
					}
				}
			});	
	  }, 10000)
    });
</script>