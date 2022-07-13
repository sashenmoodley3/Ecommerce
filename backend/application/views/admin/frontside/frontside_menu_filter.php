<?php  $this->load->view("admin/common/head"); 

?>
   

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php  
//                    if(isset($response)){ echo $response; }
                        echo $this->session->flashdata('response'); 
                    ?>
                    <div class="msg"></div>
                    <div class="row">
                        
                            

                        <div class="col-md-12">
                            <form id="form1" name="form1"  action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                                <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <?php
                                
                                    $q = $this->db->query("select * from `front_menu` ");
                                    $menus = $q->row();
//                                    echo "<pre>";
//                                    print_r($attribute_values);
                               
                                ?>
                                <div class="card-content">
                                    <h4 class="card-title">Add Menus</h4>
                                        
                                        <div class="row">                                           
                                            <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Categories");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="category" <?php
                                                               if(!empty($menus))
                                                                {                         
                                                                   if($menus->category==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            

                                            <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Home");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="home" <?php
                                                               if(!empty($menus))
                                                                {                         
                                                                   if($menus->home==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Contact Us");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="contact_us" <?php
                                                               if(!empty($menus))
                                                                {                         
                                                                   if($menus->contact_us==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("About Us");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="about_us" <?php
                                                               if(!empty($menus))
                                                                {                         
                                                                   if($menus->about_us==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
<!--                                            
                                             <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Boy's");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="boys" <?php
                                                               if(!empty($menus))
                                                                {                         
                                                                   if($menus->boys==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Kid's");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="kids" <?php
                                                               if(!empty($menus))
                                                                {                         
                                                                   if($menus->kids==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
-->
                                            
                                             <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Brands");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="brand" <?php
                                                               if(!empty($menus))
                                                                {                         
                                                                   if($menus->brand==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Shop");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="shop" <?php
                                                               if(!empty($menus))
                                                                {                         
                                                                   if($menus->shop==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                        </div>                                            
                                       <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose add-curd" name="update_menus" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        
                        <div class="col-md-12">
                            <form id="form1" name="form1"  action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                                <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <?php
                                
                                
                                    $q = $this->db->query("select * from `front_filter` ");
                                    $filters = $q->row();
//                                    echo "<pre>";
//                                    print_r($attribute_values);
                               
                                ?>
                                <div class="card-content">
                                    <h4 class="card-title">Add Filters</h4>
                                        
                                        <div class="row">                                           
                                            <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Reviews");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="review" <?php
                                                               if(!empty($filters))
                                                                {                         
                                                                   if($filters->review==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Price");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="price" <?php
                                                                if(!empty($filters))
                                                                {                         
                                                                   if($filters->price==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Attributes");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="attributes" <?php
                                                               if(!empty($filters))
                                                                {                         
                                                                   if($filters->attributes==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Brands");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="brand" <?php
                                                                if(!empty($filters))
                                                                {                         
                                                                   if($filters->brand==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                             <div class="col-md-3">
                                                <label class="col-md-6 label-on-left"><?php echo $this->lang->line("Categories");?></label>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>

                                                        <input style="height:30px;width:20px;" type="checkbox" value="1"  name="category" <?php
                                                                if(!empty($filters))
                                                                {                         
                                                                   if($filters->category==1)
                                                                   echo "checked";
                                                                }
                                                                            ?>> 
                                                        <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose add-curd" name="update_filters" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>

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

<script type="text/javascript">
    $(document).ready(function() {
//        md.initSliders()
//        demo.initFormExtendedDatetimepickers();
    });
</script>

<script>
//	initSample();
</script>

</html>