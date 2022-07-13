<?php  $this->load->view("admin/common/head"); ?>
    <style>
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
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php if (isset($error)) {
                            echo $error;
                        }
                        echo $this->session->flashdata('message'); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">home</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Socity");?></h4>
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                         <div class="row">
                                            <label class="col-md-4 label-on-right">Select Delivery Days: </label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select multiple="" id="days" name="days[]" class="form-control">
                                                    <?php 
                                                        $days_Arr       = explode(', ', $socity->delivery_days);
                                                        $days_arrList   = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"); 
                                                        for($i = 0; $i < count($days_arrList); $i++) {
                                                            if(in_array($days_arrList[$i], $days_Arr)){
                                                                echo '<option value="'.$days_arrList[$i].'" selected>'.$days_arrList[$i].'</option>';
                                                            }
                                                            else{
                                                                 echo '<option value="'.$days_arrList[$i].'">'.$days_arrList[$i].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 label-on-right"><?php echo $this->lang->line("Socity Name :");?></label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="socity_name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 label-on-right"><?php echo $this->lang->line("Pincode / Area code :");?></label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="pincode" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 label-on-right"><?php echo $this->lang->line("Delivery Charge");?> </label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="number" name="delivery" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label class="col-md-4 label-on-right"><?php echo $this->lang->line("Free Delivery Charge Amount");?> </label>
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="number" name="free_delivery_amount" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <button type="submit" class="btn btn-fill btn-rose" name="addcatg" value="Add Society"><?php echo $this->lang->line("ADD");?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Society List");?></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line("ID");?></th>
                                                    <th><?php echo $this->lang->line("Socity Name :");?></th>
                                                    <th><?php echo $this->lang->line("Pincode / Area code :");?></th>
                                                    <th><?php echo $this->lang->line("Delivery Charge");?></th>
                                                    <th><?php echo $this->lang->line("Free Delivery Charge Amount");?></th>
                                                    <th>Delivery Days</th>
                                                    <th class="text-right"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th><?php echo $this->lang->line("ID");?></th>
                                                    <th><?php echo $this->lang->line("Socity Name :");?></th>
                                                    <th><?php echo $this->lang->line("Pincode / Area code :");?></th>
                                                    <th><?php echo $this->lang->line("Delivery Charge");?></th>
                                                    <th><?php echo $this->lang->line("Free Delivery Charge Amount");?></th>
                                                     <th>Delivery Days</th>
                                                    <th class="text-right"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($socities as $socity){ ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $socity->socity_id; ?></td>
                                                        <td><?php echo $socity->socity_name; ?></td>
                                                        <td><?php echo $socity->pincode; ?></td>
                                                        <td><?php echo $socity->delivery_charge; ?></td>
                                                        <td><?php if(!empty($socity->free_delivery_amount)){echo $socity->free_delivery_amount; }else{ echo "0";}?></td>
                                                        <td><?php echo $socity->delivery_days; ?></td>
                                                        <td class="td-actions text-right"><div class="btn-group">
                                                            <?php echo anchor('admin/edit_socity/'.$socity->socity_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>

                                                            <?php echo anchor('admin/delete_socity/'.$socity->socity_id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                                                <i class="material-icons">close</i>
                                                            </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                                
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
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
</html>