<?php  $this->load->view("admin/common/head"); ?>
<style>
.urlclick {
	width: 350px;
	white-space: nowrap;
}
.urlclick .urlpath {
	width: 230px;
    padding: 10px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    margin: 10px 0;
    border: 1px solid #9c27b0;
}
.urlclick .urlcopy {
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
                            <div class="msg"></div>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <div class="toolbar">
										<h4 class="card-title"><?php echo $this->lang->line("Images Collection");?></h4>
										<a class="pull-right btn btn-primary" href="<?php echo site_url("admin/addimage"); ?>"><?php echo $this->lang->line("ADD");?></a>
                                        
                                    </div>
                                    <div class="row">
										<div class="col-md-12">
											<div class="material-datatables table-responsive">
												<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0">
													<thead>
														<tr>
															<th class="text-left"><?php echo $this->lang->line("Image");?></th>
															<th class="text-left"><?php echo $this->lang->line("Image Url");?></th>
															<th class="text-left" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<th class="text-left"><?php echo $this->lang->line("Image");?></th>
															<th class="text-left"><?php echo $this->lang->line("Image Url");?></th>
															<th class="text-left" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
														</tr>
													</tfoot>
													<tbody>
														<?php
														foreach($allimages as $row){
															$img = '';
															$flpath = FCPATH.'/uploads/images/'.$row->image;
															if(!empty($row->image) && file_exists($flpath)){
																$img = $this->config->item('base_url').'/uploads/images/'.$row->image;
															}

															?>
														<tr>
															<td class="text-left" align="center">
																<?php if(!empty($img)){ ?>
																<div class="cat-img" style="width: 150px;">
																	<img src="<?php echo $img ?>" />
																</div>
																<?php } ?>
															</td> 
															<th class="text-left">
																<div class="urlclick">
																  <span class="pull-left urlpath"><?php echo $img; ?></span>
																  <div class="pull-right btn btn-primary urlcopy">Copy Url</div>
																</div>
															</td>
															<td class="td-actions text-left">
																<div class="">
																	<?php echo anchor('admin/editimage/'.$row->id,  '<button type="button" rel="tooltip" class="btn btn-success btn-round"> <i class="material-icons">edit</i>
																	</button>', array("class"=>"")); ?>

																	<?php echo anchor('admin/deleteimage/'.$row->id,  '<button type="button" rel="tooltip" class="btn btn-danger btn-round"> <i class="material-icons">close</i>
																	</button>', array("class"=>"delete-curd", "onclick"=>"return confirm('Are you sure delete?')")); ?>
																	
																</div>
															</td>
														</tr>
														<?php 
														
														}
														?>
													</tbody>
												</table>
											</div>
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
		
		$(".urlclick .urlcopy").on('click', function(event){
			var $tempElement = $("<input>");
			$("body").append($tempElement);
			$tempElement.val($(this).closest(".urlclick").find("span").text()).select();
			document.execCommand("Copy");
			$tempElement.remove();
			alert("URL copied!");
		});
		
    });
</script>

</html>