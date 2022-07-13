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
                                    <div class="toolbar">
										<h4 class="card-title"><?php echo $this->lang->line("All Coupon List");?></h4>
										<a class="pull-right btn btn-primary" href="<?php echo site_url("admin/add_coupons"); ?>"> <?php echo $this->lang->line("ADD");?></a>
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
									<div class="clearfix"></div>
                                    <div class="material-datatables ">
										<div class="table-responsive">
											<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
												<thead>
													<tr>
														<th><?php echo $this->lang->line("S.No");?></th>
													   
														<th><?php echo $this->lang->line("Coupon Name");?></th>
														<th> <?php echo $this->lang->line("Coupon Code");?> </th>
														<th><?php echo $this->lang->line("valid_from");?></th>
														
														<th><?php echo $this->lang->line("valid_to");?></th>
														<th><?php echo $this->lang->line("discount_type");?></th>
														
														<th><?php echo $this->lang->line("Discount Value");?></th>
														<th><?php echo $this->lang->line("minimum_cart_amt");?></th>
														<th><?php echo $this->lang->line("uses_restriction");?></th>
														<th><?php echo $this->lang->line("max_limit");?></th>
														<th><?php echo $this->lang->line("coupon_description");?></th>
														
														<th><?php echo $this->lang->line("Coupon Status");?></th>
														
														<th class="text-center" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														 <th><?php echo $this->lang->line("S.No");?></th>
													 
														<th><?php echo $this->lang->line("Coupon Name");?></th>
														<th> <?php echo $this->lang->line("Coupon Code");?> </th>
														<th><?php echo $this->lang->line("Valid From");?></th>
														
														<th><?php echo $this->lang->line("valid_to");?></th>
														<th><?php echo $this->lang->line("discount_type");?></th>
														
														<th><?php echo $this->lang->line("Discount Value");?></th>
														<th><?php echo $this->lang->line("minimum_cart_amt");?></th>
														<th><?php echo $this->lang->line("uses_restriction");?></th>
														<th><?php echo $this->lang->line("max_limit");?></th>
														<th><?php echo $this->lang->line("coupon_description");?></th>
														
														<th><?php echo $this->lang->line("coupon_status");?></th>
														
														<th class="text-center" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
													</tr>
												</tfoot>
												<tbody>
													<?php foreach($coupons as $coupon){ 
															?>
														<tr>
															<td><?= $coupon->coupon_id; ?></td>
															
															<td><?= $coupon->coupon_name;?></td>
															<td><?= $coupon->coupon_code;?></td>
															<td><?= date("d-m-Y", strtotime($coupon->valid_from)); ?></td>
															
															<td><?= date("d-m-Y", strtotime($coupon->valid_to));?></td>
															<td><?= $coupon->discount_type; ?></td>
															<td><?= $coupon->discount_value;?></td>
															
															<td><?= $coupon->minimum_cart_amt;?></td>
															<td><?= $coupon->uses_restriction;?></td>
															<td><?= $coupon->max_limit;?></td>
															
															<td><?= base64_decode($coupon->coupon_description);?></td>
															
															<td><?= $coupon->coupon_status;?></td>
															<td class="td-actions text-right"><div class="">
																<?php echo anchor('admin/editCoupon/'.$coupon->coupon_id,  '<button type="button" rel="tooltip" class="btn btn-success btn-round">
																	<i class="material-icons">edit</i>
																</button>', array("class"=>"")); ?>

																<?php echo anchor('admin/deleteCoupon/'.$coupon->coupon_id,  '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
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