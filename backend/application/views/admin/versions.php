<?php  $this->load->view("admin/common/head"); 
$userData  =    json_decode($userData); 
?>
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
                    <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('message'); 
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <div class="" style="margin-bottom:15px;">
                                    <h4 class="card-title" style="display: inline-block;"><?php echo $this->lang->line("View Version");?></h4>
                                    </div>
                                    <div class="toolbar">
                                            <h6 style="text-align:center; font-weight:bold">Your Current Version is :- <?=$this->config->item('web_version');?></h6>
                                    </div>
                                    <div class="material-datatables custom-datatable">
                                            <table id="datatables" class="table table-striped table-no-bordered table-hover custom-table" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left"><?php echo $this->lang->line("ID");?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Version Code");?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Version Features");?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Action");?></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-left"><?php echo $this->lang->line("ID");?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Version Code");?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Version Features");?></th>
                                                        <th class="text-left"><?php echo $this->lang->line("Action");?></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php 
                                                        $i=1;
                                                    if(!empty($userData)){
                                                    foreach(@$userData as $users){ //print_r($users); exit; ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $i; ?></td>
                                                        <td class="text-left"><a id="view" data-name="viewVersion" data-id="<?=$users->version_code?>" href="javascript:void(0)"><?php echo $users->version_code; ?></a></td> 
                                                        <td class="text-left"><?php echo base64_decode($users->description); ?></td> 
                                                        <td class="td-actions text-left"><div class="btn-group">
                                                            <?php if($this->config->item('web_version') != $users->version_code && $users->upgradeStatus ==''){
                                                                        echo anchor('admin/upgradeVersion/'.$users->id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                                                            <i class="material-icons">assignment_turned_in</i>
                                                                            </button>', array("class"=>"", "title" => "Upgrade Software", "onclick"=>"return confirm('Are you sure you want to Upgrade Version ?')")); 
                                                                   } 
                                                                   else{  
                                                                        if($users->upgradeStatus == "1"){ 
																			
																			if($this->config->item('web_version') < $users->version_code){
																				if($this->config->item('web_version') < $users->version_code){
																				?>
																					<span class="label label-info">Approved</span>
																					<br>
																					<br>
																					<?php 
																					if(file_exists(FCPATH."\\uploads\\version\\version".$users->version_code.".zip")){
																						?>
																					<a class="btn btn-info" href="<?= base_url('admin/downloadVersionExtract/'.$users->version_code); ?>" ><?php echo $this->lang->line("Version Install");?></a>
																					<?php 
																					}
																					else if(!empty($users->version_file)){
																						?>
																						<a class="btn btn-warning" href="<?= base_url('admin/downloadVersionFile/'.$users->version_file.'/'.$users->version_code); ?>" ><?php echo $this->lang->line("Version Download");?></a>
																						<?php 
																					
																					}
																					
																				}
																				else{
																				?>
																					<span class="label label-success">Installed</span>
																					<?php 
																				}
																			}
																			else{
																			?>
																				<span class="label label-success">Installed</span>
																				<?php 
																			}
																			?>
																			
																			
                                                                        <?php
																		}
																		elseif($users->upgradeStatus == "2") {
																			?>
                                                                            <span class="label label-danger">Reject</span>
                                                                        <?php 
																		} elseif($users->upgradeStatus == "0") {
																			?>
                                                                            <span class="label label-primary">Pending</span>
                                                                        <?php 
																		}
                                                                   }
                                                            ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i = $i+1; } } ?>
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
<!--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>-->
 <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#datatables').DataTable({
            "order": [[1, "desc"]],
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
       
        $('.card .material-datatables label').addClass('form-group');
    });
  

</script>

</html>