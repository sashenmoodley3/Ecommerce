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
                                    <h4 class="card-title">All Ads List</h4>
                                    <!--a class="pull-right" href="<?php echo site_url(""); ?>">ADD NEW STORE</a-->
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td class="text-center">S. No.</td>
                                                    <th class="text-center">Ad Name</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-center">S. No.</td>
                                                    <th class="text-center">Ad Name</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                                
                                            </tfoot>
                                            <tbody>
                                                    <?php $sr = 1; foreach($ads->result() as $ads){ ?>
                                                    <tr>
                                                        <td class="text-center"><?=$sr++;?></td>
                                                        <td class="text-center"><?php echo $ads->name; ?></td>
                                                        <td class="text-center">
                                                            
                                                                <label>
                                                                    <input type="checkbox" name="status" disabled <?php if($ads->status==1){ echo "checked"; } ?>>
                                                                </label>
                                                            
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo anchor('admin/edit_ads/'.$ads->id, '<button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="Edit">
                                                                    <i class="material-icons">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </button>',  array("class"=>"")); ?>
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