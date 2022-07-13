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
        <!--sider -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        
        <div class="main-panel">
            <!--head -->
            <?php  $this->load->view("admin/common/header"); ?>
            <!--content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <div class="msg"></div>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Feature Brand Slider");?></h4>
                                    <a class="pull-right btn btn-primary" href="<?php echo site_url("admin/add_feature_Banner"); ?>"><?php echo $this->lang->line("ADD");?></a>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-left"><?php echo $this->lang->line("Slider Title");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Image");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Banner Size");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Banner Type");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-left" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-left"><?php echo $this->lang->line("Slider Title");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Image");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Banner Size");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Banner Type");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-left" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($allslider as $bus){ 
                                                    $image = $bus->slider_image;
                                                    if(!empty($bus->slider_title)){
                                                        $name = $this->db->query("Select * from feature_slider_type where type_id = '".$bus->slider_title."' ")->row();
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $name->type_name; ?></td>
                                                        <td class="text-left" align="center">
                                                             <div class="cat-img" style="width: 127px; display: inline-flex;">
                                                                 <img width="40%" height="40%" src="<?php echo $this->config->item('base_url').'uploads/sliders/'.$image ?>" />
                                                             </div>
                                                         </td> 
                                                         <td>
                                                            <?php   if($bus->image_type == 0){
                                                                        echo $this->lang->line("Small");
                                                                    }
                                                                    elseif($bus->image_type == 1){
                                                                        echo $this->lang->line("FullSize");
                                                                    }
                                                            ?>
                                                         </td>
                                                         <td>
                                                            <?php   if($bus->banner_type == 1){
                                                                        echo $this->lang->line("4 Small + 1 Big Banner");
                                                                    }
                                                                    elseif($bus->banner_type == 2){
                                                                        echo $this->lang->line("4 Small Banner");
                                                                    }
                                                                    elseif($bus->banner_type == 3){
                                                                        echo $this->lang->line("3 Small + 1 Big Banner");
                                                                    }
                                                                    elseif($bus->banner_type == 4){
                                                                        echo $this->lang->line("1 Slider Big Banner");
                                                                    }
                                                                    elseif($bus->banner_type == 5){
                                                                        echo $this->lang->line("1 Big Banner");
                                                                    }
                                                            ?>
                                                         </td>
                                                         
                                                         
                                                        <td class="text-left"><?php if($bus->slider_status=="1"){echo "Active";}else{echo "DeActive";} ?></td>
                                                        
                                                        <td class="td-actions text-left"><div class="">
                                                            <?php echo anchor('admin/edit_feature_banner/'.$bus->id,  '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>

                                                            <?php echo anchor('admin/delete_feature_banner/'.$bus->id,  '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                                                <i class="material-icons">close</i>
                                                            </button>', array("class"=>"delete-curd", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                                
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
                    <!-- end row -->
                </div>
            </div>
            <!--footer -->
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
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

</html>