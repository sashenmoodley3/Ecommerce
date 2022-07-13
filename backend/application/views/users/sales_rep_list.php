<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="//www.creative-tim.com/product/material-dashboard-pro" />

    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
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
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("All Users");?></h4>
                                    <a class="pull-right" href="<?php echo site_url("users/add_sales_rep"); ?>"><?php echo $this->lang->line("ADD SALES REP");?>.</a>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                      <th class="text-center"><?php echo $this->lang->line("Store Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Employee Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Mobile No");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("User Email");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <!--th class="text-center">Action</th-->
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                     <th class="text-center"><?php echo $this->lang->line("Store Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Employee Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Mobile No");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("User Email");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <!--th class="text-center">Action</th-->
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($users as $user){ ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $user->user_fullname; ?></td>
                                                        <td class="text-center"><?php echo $user->user_name; ?></td>
                                                        <td class="text-center"><?php echo $user->user_phone; ?></td>
                                                        <td class="text-center"><?php echo $user->user_email; ?></td>
                                                        <td class="text-center">
                                                            <div class="togglebutton">
                                                                <input type="checkbox" data-table="users" data-status="user_status" data-idfield="user_id"  data-id="<?php echo $user->user_id; ?>" id='cb_<?php echo $user->user_id; ?>' type='checkbox' <?php echo ($user->user_status==1)? "checked" : ""; ?> disabled/>
                                                                <label class='tgl-btn' for='cb_<?php echo $user->user_id; ?>'>
                                                                    
                                                                </label>
                                                            </div>
                                                        </td>
                                                        
                                                        <td class="td-actions text-center"><div class="btn-group">
                                                            <?php echo anchor('users/edit_sales_rep/'.$user->user_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>

                                                            <?php echo anchor('users/delete_user/'.$user->user_id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                                                <i class="material-icons">close</i>
                                                            </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                                
                                                            </div>
                                                        </td-->
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