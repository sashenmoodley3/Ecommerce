<?php  $this->load->view("admin/common/head"); ?>

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
                                    <h4 class="card-title">All Payment Gateway List</h4>
                                    <!--a class="pull-right" href="<?php echo site_url(""); ?>">ADD NEW STORE</a-->
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">S. No.</th>
                                                    <th class="text-center">Payment Getaway Name</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">S. No.</th>
                                                    <th class="text-center">Payment Getaway Name</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                                
                                            </tfoot>
                                            <tbody>
                                                <?php /*foreach($paypal->result() as $paypal){ ?>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">PayPal</td>
                                                        <td class="text-center">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="status" disabled <?php if($paypal->status==1){ echo "checked"; } ?>>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo anchor('admin/paypal_detail/', '<button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="Edit">
                                                                    <i class="material-icons">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </button>',  array("class"=>"")); ?>
                                                        </td>
                                                        
                                                    </tr>
                                                    <?php }*/ ?>
                                                    <?php
                                                    $s  =   1;
                                                            foreach($rozar as $razor){
                                                     ?>
                                                    <tr>
                                                        <td class="text-center"><?=$s?></td>
                                                        <td class="text-center"><?=$razor->gateway_name?></td>
                                                        <td class="text-center">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input disabled type="checkbox" name="status"  <?php if($razor->status==1){ echo "checked";} ?>>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo anchor('admin/razorpay_detail/'.$razor->id, '<button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="Edit">
                                                                    <i class="material-icons">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </button>',  array("class"=>"")); ?>
                                                        </td>
                                                    </tr>
                                                    <?php $s++; } ?>
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