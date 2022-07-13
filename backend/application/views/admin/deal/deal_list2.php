<?php  $this->load->view("admin/common/head"); ?>
<style>
    .custom-datatable .col-sm-6:nth-child(2) .dataTables_filter label.form-group {
        display: block;
    }
    .custom-datatable .col-sm-6:nth-child(2) .dataTables_filter label.form-group input {
        display: block;
        width: 100%;
    }
</style>

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
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <div class="" style="margin-bottom:15px;">
                                    <h4 class="card-title" style="display: inline-block;"><?php echo "Deal List";?></h4>
                                    <a class="pull-right btn btn-primary" href="<?php echo site_url("admin/add_dealproduct"); ?>"><?php echo $this->lang->line("ADD");?></a>
                                    <!--a class="pull-right" href="<?php echo site_url(""); ?>">ADD NEW STORE</a-->
                                    </div>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables custom-datatable">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-left"><?php echo $this->lang->line("Product Name");?></th>
<!--                                                    <th class="text-center"><?php echo $this->lang->line("Price");?></th>-->
                                                    <th class="text-left"><?php echo $this->lang->line("Start Date");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Start Time");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("End Date");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("End Time");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Expire");?></th>
                                                    <th class="text-left" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                     <th class="text-left"><?php echo $this->lang->line("Product Name");?></th>
<!--                                                    <th class="text-center"><?php echo $this->lang->line("Price");?></th>-->
                                                    <th class="text-left"><?php echo $this->lang->line("Start Date");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Start Time");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("End Date");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("End Time");?></th>
                                                    <th class="text-left"><?php echo $this->lang->line("Expire");?></th>
                                                    <th class="text-left" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($deal_products as $product){ ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $product->product_name; ?></td>
<!--                                                        <td class="text-center"><?php echo $product->deal_price; ?></td>-->
                                                        <td class="text-left"><?php echo $product->start_date; ?></td>
                                                        <td class="text-left"><?php echo $product->start_time; ?></td>
                                                        <td class="text-left"><?php echo $product->end_date; ?></td>
                                                        <td class="text-left"><?php echo $product->end_time; ?></td>
                                                        <?php 
                                                            date_default_timezone_set('Africa/Johannesburg');
                                                            
                                                            $present = date('Y-m-d H:i ', time());
                                                            $date1 = str_replace('/', '-', $product->start_date);
                                                            $date2 = str_replace('/', '-', $product->end_date);
                                                            
                                                            $date1 = date('Y-m-d', strtotime($date1))." ".$product->start_time;
                                                            $date2 = date('Y-m-d', strtotime($date2))." ".$product->end_time;
                                                        ?>
                                                        <td class="text-left">
                                                          <?php 
                                                          if($date1 <= $present && $present <= $date2)
                                                                        { echo 'Running'; }
                                                                    else if($date1 > $present)
                                                                        {echo "Is going to";}
                                                                    else
                                                                        {echo 'Expired';} 

                                                                    //echo "[ ".strtotime('$present')." ] [ ".strtotime($date1)." ] [ ".strtotime($date2)." ]";
                                                            ?>
                                                        </td>
                                                        
                                                        <td class="td-actions text-left"><div class="">
                                                            <?php echo anchor('admin/edit_deal_product/'.$product->id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>

                                                            <?php echo anchor('admin/delete_deal_product/'.$product->id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
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