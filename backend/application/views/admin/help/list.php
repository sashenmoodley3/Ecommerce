<?php  $this->load->view("admin/common/head"); ?>
<link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet" />
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
        
/*        product detail popup css start*/
        
             

            .openmodal {
                background-color: white;
                color: black;
                width: 30vw
            }

            :-moz-any-link:focus {
                outline: none
            }

/*
            button:active {
                outline: none
            }

            button:focus {
                outline: none
            }

            .btn:focus {
                box-shadow: none
            }
*/
        
/*        product detail popup css end*/
        
        /* tooltip css start*/
        
/*
        .tooltip {
          position: relative;
          display: inline-block;
          border-bottom: 1px dotted black;
        }
*/

        .tooltip1 .tooltiptext {
          visibility: hidden;
          width: auto;
          background-color: #eeeeee;
          color: #000;
          text-align: center;
          border-radius: 6px;
          padding: 15px;

          /* Position the tooltip */
          position: absolute;
          z-index: 1;
        }

        .tooltip1:hover .tooltiptext {
          visibility: visible;
        }
        /* tooltip css end*/
        
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
                                    <h4 class="card-title"><?php echo $this->lang->line("List");?></h4>
                                    <div class="toolbar">
                                        <a class="pull-right btn btn-primary" style="" href="<?php echo site_url("admin/help_form"); ?>">
											<?php echo $this->lang->line("ADD");?>
										</a>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table table-border table-striped custom-table datatable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("S.No"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Ticket"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Subject"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Action"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="text-left"><?php echo $this->lang->line("S.No"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Ticket"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Subject"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Status"); ?></th>
                                                            <th class="text-left"><?php echo $this->lang->line("Action"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        $no = 0;
														if(!empty($records)){
														foreach($records as $row){
														  $no++;
														
														?>
														<tr>
															<td><?php echo $no;?></td>
															<td><?php echo $row['tkt_id'];?></td>
															<td><?php echo $row['subject'];?></td>
															<td><?php echo $row['status'];?></td>
															<td>
															
															
																<a href="<?php echo base_url('admin/help_details/'.$row['tkt_id']) ?>"  title="Reply" class="btn btn-warning"> <i class="material-icons">edit</i>
																	</a>
																
															
															
															
															
															</td>
														</tr>
														<?php 
														}
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


    
<script type="text/javascript">
   
    
    
    $(document).ready(function() {
        
        var table = $('#datatable').DataTable();
        
    });
   
   
    
</script>


</html>



