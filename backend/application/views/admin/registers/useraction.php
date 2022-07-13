<?php  $this->load->view("admin/common/head"); ?>
    <style>
        .check{
            
               
            margin-left: 93px;
            margin-top: -20px;
            width: 15px;
            
        }
        .border-dark{
            padding: 10px 0px 0px 0px;
            border-top:1px #ccc solid;
            border-bottom:1px #ccc solid;
        }
        table.custom-table > thead > tr > th{
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }
        .mybtn{text-align:center;}
        .mybtn .dt-buttons>button{
        webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        position: relative;
        border: 0;
        border-radius: 3px;
        padding: 6px;
        font-weight: 400;
        color: #ffffff;
        font-style: inherit;
        font-variant: inherit;
        font-size: inherit;
        font-family: inherit;
        line-height: inherit;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.26);
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),-webkit-transform .4s cubic-bezier(.25,.8,.25,1);
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1),transform .4s cubic-bezier(.25,.8,.25,1);
        }
        .mybtn .dt-buttons>button:nth-child(1){
        background-color: #e91e63;
        }
        .mybtn .dt-buttons>button:nth-child(2){
        background-color: #2196f3;
        margin-left: 3x;
        }
        .mybtn .dt-buttons>button:nth-child(3){
        background-color: #4caf50;
        margin-left: 3px;
        }
        .mybtn .dt-buttons>button:nth-child(4){
        background-color: #e91e63;
        margin-left: 3px;
        }
        
        .myselect label, .mysearch label{color: #292929;}
        .myselect select{height: 35px; width: 100%; padding: 0 5px;}
        
        .mysearch label{display:block;}
        .mysearch input{width:100% !important; border:1px solid #cccccc; height: 35px; padding: 0 12px;}
        a.action-btn-detail{
                padding: 10px;
                border-radius: 50%;
        }
        a.action-btn-edit{
                padding: 11px 5px;
                border-radius: 50%;
        }
        
    </style>
    </head>

    <body>
        <div class="wrapper">
            <?php $this->load->view("admin/common/sidebar"); ?>
            <div class="main-panel">
                <?php $this->load->view("admin/common/header"); ?>

                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">

                                    <div class="card-header card-header-tabs" data-background-color="rose">
                                        <div class="nav-tabs-navigation">
                                            <div class="nav-tabs-wrapper">
                                                <!--span class="nav-tabs-title">Tasks:</span-->
                                                <ul class="nav nav-tabs" data-tabs="tabs">
                                                    <li class="col-lg-4 col-md-4 profile" style="text-align:center">
                                                        <a href="#profile">
                                                            <i class="material-icons">group</i><?php echo $this->lang->line("Profile"); ?> 
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                    <li class="col-lg-4 col-md-4 message"  style="text-align:center">
                                                        <a href="#messages" >
                                                            <i class="material-icons">stars</i> <?php echo "Wallet";//$this->lang->line("Wallet & Rewards"); ?>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                    <li class="col-lg-4 col-md-4 setting" style="text-align:center">
                                                        <a href="#settings">
                                                            <i class="material-icons">cloud</i> <?php echo $this->lang->line("Past Orders"); ?>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-content" >
                                        <div class="tab-content">
                                            <?php echo $this->session->flashdata("message"); ?>

                                            <div class="tab-pane profile1">
                                                <div class="col-md-12">
                                                    <div class="social text-center">
                                                        <h4> <?php echo $this->lang->line("Profile Detail"); ?> </h4>
                                                    </div>
                                                    <form class="form" method="post" action="">
                                                        <?php foreach ($user as $user) { ?>
                                                            <div class="card-content">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">face</i><span class="height"><?php echo $this->lang->line("Name"); ?> </span>
                                                                    </span>
                                                                    <div class="form-group is-empty"><input name="name" type="text" style="margin-top: 25px;" class="form-control" placeholder="Full Name..." value="<?= $user->user_fullname; ?>"><span class="material-input"></span></div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">email</i> <?php echo $this->lang->line("Email"); ?>
                                                                    </span>
                                                                    <div class="form-group is-empty"><input name="email" type="email" style="margin-top: 25px;" class="form-control" placeholder="Email..." value="<?= $user->user_email; ?>"><span class="material-input"></span></div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">smartphone</i><?php echo $this->lang->line("Phone"); ?>
                                                                    </span>
                                                                    <div class="form-group is-empty"><input name="phone" type="number" style="margin-top: 25px;" placeholder="Phone Number" class="form-control"  value="<?= $user->user_phone; ?>"><span class="material-input"></span></div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">lock_outline</i><?php echo $this->lang->line("Password"); ?>  &nbsp;
                                                                    </span>
                                                                    <div class="form-group is-empty">
                                                                        <input name="password" type="password" style="margin-top: 25px;" placeholder="Password..." class="form-control" 
                                                                               value="">
                                                                        <span class="material-input"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">navigation</i><?php echo $this->lang->line("Area"); ?>  &nbsp;
                                                                    </span>
                                                                    <div class="form-group is-empty">
                                                                        <select class="form-control" name="society" style="margin-top: 25px;">
                                                                            <?php
                                                                            $qry = $this->db->query("SELECT * FROM `socity`");
                                                                            foreach ($qry->result() as $society) {
                                                                                ?>
                                                                                <option value="<?= $society->socity_id ?>" <?php
                                                                                if ($society->socity_id == $user->socity_id) {
                                                                                    echo "selected";
                                                                                }
                                                                                ?>><?= $society->socity_name ?></option>
                                                                                    <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">home</i><?php echo $this->lang->line("Home"); ?> 
                                                                    </span>
                                                                    <div class="form-group is-empty">
                                                                        <input name="home" type="text" style="margin-top: 25px;" class="form-control" placeholder="House Number"  value="<?= $user->house_no; ?>">
                                                                        <span class="material-input"></span>
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                                        

                                                                <div class="input-group">
                                                                    <label>
                                                                    <span class="checkbox-material"></span> 
                                                                        <span style="color:#000">
                                                                            <?php echo $this->lang->line("Status"); ?>
                                                                        </span>
                                                                    <div class="form-group is-empty">
                                                                    <input  type="checkbox"  name="status" <?php
                                                                        if ($user->status == 1) {
                                                                            echo "checked";
                                                                        }
                                                                        ?>>    
                                                                    </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="footer text-center">
                                                            <input type="submit" name="profile" class="btn btn-primary btn-round" value="<?= $this->lang->line('Update Detail'); ?>">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-pane col-md-12 message1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="form" method="post" action="">
                                                            <div class="input-group col-md-6">
                                                                
                                                                <div class="form-group is-empty">
                                                                    <h4>Current Balance : <?= $user->wallet; ?></h4>
                                                                    <hr>
                                                                    <select name="type_wallet" class="form-control" required>
                                                                        <option>Select</option>
                                                                        <option value="add"> Credit ( + )</option>
                                                                        <option value="remove">Debit ( - )</option>
                                                                    </select>
                                                                    <input required  name="wallet" type="text" style="margin-top: 25px;" class="form-control" placeholder="Amount" value="">
                                                                    <span class="material-input"></span>
                                                                </div>
                                                            </div>
                                                            <!--<div class="input-group col-md-6">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">stars</i> <span class="height"><?php //echo $this->lang->line("Rewards");  ?></span>
                                                                </span>
                                                                <div class="form-group is-empty"><input name="rewards" type="text" style="margin-top: 25px;" class="form-control" placeholder="Email..." value="<?= $user->rewards; ?>"><span class="material-input"></span></div>
                                                            </div>-->
                                                            <div class="footer text-center">
                                                                <input type="submit" name="amount" class="btn btn-primary btn-round" value="Update Detail">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php $this->load->view("admin/registers/orderslist2"); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane setting1">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header card-header-icon" data-background-color="purple">
                                                            <i class="material-icons">assignment</i>
                                                        </div>
                                                        <div class="card-content">
                                                            <h4 class="card-title"><?php echo $this->lang->line("Order Detail"); ?> </h4>
                                                            <div class="toolbar">
                                                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                                            </div>
                                                            <div class="material-datatables">
                                                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center"><?php echo $this->lang->line("Order"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Customer Name"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Socity"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Customer Phone"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Date"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Time"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Order Amount"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Status"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Action"); ?></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th class="text-center"><?php echo $this->lang->line("Order"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Customer Name"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Socity"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Customer Phone"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Date"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Time"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Order Amount"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Status"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Action"); ?></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                    <tbody>
                                                                        <?php 
                                                                        if(count($order) > 0){ 
                                                                            foreach ($order as $order) { ?>
                                                                            <tr>
                                                                                <th class="text-center"><?php echo $order->sale_id; ?></th>
                                                                                <th class="text-center"><?php echo $order->user_fullname; ?></th>
                                                                                <th class="text-center"><?php echo $order->socity_name; ?></th>
                                                                                <th class="text-center"><?php echo $order->user_phone; ?></th>
                                                                                <th class="text-center"><?php echo $order->on_date; ?></th>
                                                                                <th class="text-center"><?php echo date("H:i A", strtotime($order->delivery_time_from)) . " - " . date("H:i A", strtotime($order->delivery_time_to)); ?></th>
                                                                                <th class="text-center"><?php echo $order->total_amount; ?></th>
                                                                                <th class="text-center">
                                                                                    <?php
                                                                                    if ($order->status == 0) {
                                                                                        echo "<span class='label label-default'>Pending</span>";
                                                                                    } else if ($order->status == 1) {
                                                                                        echo "<span class='label label-success'>Confirm</span>";
                                                                                    } else if ($order->status == 2) {
                                                                                        echo "<span class='label label-info'>Delivered</span>";
                                                                                    } else if ($order->status == 3) {
                                                                                        echo "<span class='label label-danger'>cancel</span>";
                                                                                    } else if ($order->status == 4) {
                                                                                        echo "<span class='label label-success'>Complete</span>";
                                                                                    }
                                                                                    ?>
                                                                                </th>

                                                                                <td class="td-actions text-center"><div class="btn-group">
                                                                                        <?php echo anchor('admin/orderdetails/' . $order->sale_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                                <i class="material-icons">assignment</i>
                                                                            </button>', array("class" => "")); ?>

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } }
                                                                        else{

                                                                          echo '<tr><td colspan="7" style="text-align:center">Record  Not Found !!</td></tr>'  ;
                                                                        }?>
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
<?php
/*
?>
                                    <div class="card-content" style="display:block;">
                                        <div class="tab-content">
                                            <div class="tab-pane col-md-12">
                                                <form class="form" method="post" action="">
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">money</i> &nbsp;<span class="height"><?php echo $this->lang->line("Wallet"); ?></span>
                                                        </span>
                                                        <div class="form-group is-empty"><input name="wallet" type="text" style="margin-top: 25px;" class="form-control" placeholder="Full Name..." value="<?= $user->wallet; ?>"><span class="material-input"></span></div>
                                                    </div>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">stars</i> <span class="height"><?php echo $this->lang->line("Rewards"); ?></span>
                                                        </span>
                                                        <div class="form-group is-empty"><input name="rewards" type="text" style="margin-top: 25px;" class="form-control" placeholder="Email..." value="<?= $user->rewards; ?>"><span class="material-input"></span></div>
                                                    </div>
                                                    <div class="footer text-center">
                                                        <input type="submit" name="amount" class="btn btn-primary btn-round" value="Update Detail">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="tab-content">
                                            <div class="tab-pane" id="settings">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header card-header-icon" data-background-color="purple">
                                                            <i class="material-icons">assignment</i>
                                                        </div>
                                                        <div class="card-content">
                                                            <h4 class="card-title"><?php echo $this->lang->line("Order Detail"); ?> </h4>
                                                            <div class="toolbar">
                                                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                                            </div>
                                                            <div class="material-datatables">
                                                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center"><?php echo $this->lang->line("Order"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Customer Name"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Socity"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Customer Phone"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Date"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Time"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Order Amount"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Status"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Action"); ?></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th class="text-center"><?php echo $this->lang->line("Order"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Customer Name"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Socity"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Customer Phone"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Date"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Time"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Order Amount"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Status"); ?></th>
                                                                            <th class="text-center"><?php echo $this->lang->line("Action"); ?></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                    <tbody>
                                                                        <?php foreach ($order as $order) { ?>
                                                                            <tr>
                                                                                <th class="text-center"><?php echo $order->sale_id; ?></th>
                                                                                <th class="text-center"><?php echo $order->user_fullname; ?></th>
                                                                                <th class="text-center"><?php echo $order->socity_name; ?></th>
                                                                                <th class="text-center"><?php echo $order->user_phone; ?></th>
                                                                                <th class="text-center"><?php echo $order->on_date; ?></th>
                                                                                <th class="text-center"><?php echo date("H:i A", strtotime($order->delivery_time_from)) . " - " . date("H:i A", strtotime($order->delivery_time_to)); ?></th>
                                                                                <th class="text-center"><?php echo $order->total_amount; ?></th>
                                                                                <th class="text-center">
                                                                                    <?php
                                                                                    if ($order->status == 0) {
                                                                                        echo "<span class='label label-default'>Pending</span>";
                                                                                    } else if ($order->status == 1) {
                                                                                        echo "<span class='label label-success'>Confirm</span>";
                                                                                    } else if ($order->status == 2) {
                                                                                        echo "<span class='label label-info'>Delivered</span>";
                                                                                    } else if ($order->status == 3) {
                                                                                        echo "<span class='label label-danger'>cancel</span>";
                                                                                    } else if ($order->status == 4) {
                                                                                        echo "<span class='label label-success'>Complete</span>";
                                                                                    }
                                                                                    ?>
                                                                                </th>

                                                                                <td class="td-actions text-center"><div class="btn-group">
                                                                                        <?php echo anchor('admin/orderdetails/' . $order->sale_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                                <i class="material-icons">assignment</i>
                                                                            </button>', array("class" => "")); ?>

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
                                        </div>
                                    </div>
<?php
*/
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->load->view("admin/common/footer"); ?>
            </div>
        </div>
        <?php $this->load->view("admin/common/fixed"); ?>
    </body>
    <!--   Core JS Files   -->
    
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="<?php echo base_url($this->config->item("new_theme") . "/assets/js/demo.js"); ?>"></script>
   
    <script>
        $(document).ready(function () {
            $(".profile1").show();
            $(".message1").hide();
            $(".setting1").hide();

            $(".profile").click(function () {
                $(".profile1").show();
                $(".message1").hide();
                $(".setting1").hide();
            });

            $(".message").click(function () {
                $(".profile1").hide();
                $(".message1").show();
                $(".setting1").hide();
            });

            $(".setting").click(function () {
                $(".profile1").hide();
                $(".message1").hide();
                $(".setting1").show();
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatables').DataTable({
                 "order": [[0, "desc"]],
                 "dom": "<'row border-dark'<'col-sm-2 myselect'l><'col-sm-3 mybtn'B><'#cat.col-sm-2 myselect'><'col-sm-5 mysearch'f>>" 
                        + "<'row'<'col-sm-12'i>>" 
                        + "<'row'<'col-sm-12'tr>>" 
                        + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
               // dom: 'Bfrtip',
               buttons: [
                    'csvHtml5',
                    'pdfHtml5'
                ],

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
        });

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</html>