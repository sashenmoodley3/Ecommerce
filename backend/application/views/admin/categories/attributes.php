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
                        <form id="form1" name="form1"  action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <?php
                                
                                if ($this->uri->segment(3) == FALSE)
                                {
                                    $label = "Add";
                                    $btn_name = "addattribute";
                                    //echo "ramxdfgbfgbf";
                                    //$product_id = 0;
                                }
                                else
                                {
                                    $attribute_value_id = $this->uri->segment(3);
                                    $label = "Edit";
                                    $btn_name = "editattribute";
                                    
                                    $q = $this->db->query("select * from `attribute_values` WHERE attribute_value_deleted = 0 and attribute_value_id=" . $attribute_value_id);
                                    $edit_attribute_values = $q->row();
//                                    echo "<pre>";
//                                    print_r($attribute_values);
                                }
                                ?>
                                <div class="card-content">
                                    <h4 class="card-title"><?=$label;?> Attribute Value</h4>
                                        
                                        <div class="row">
                                           
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Select Attribute");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    
                                                     <input type="hidden" name="attribute_value_id" class="form-control" value="<?=@$attribute_value_id;?>" data-validation-required-message="">
                                                    
                                                    <select onchange="filter(this.value)" class="text-input form-control" name="attribute" id="attribute" required>
													<option value=""><?php echo $this->lang->line("--Select Attribute--");?></option>
													<?php
														if(!empty($attributes))
                                                        {
                                                            foreach($attributes as $row){ 
                                                                echo '<option value="'.$row['attribute_id'].'" ';
                                                                
                                                                if(!empty($edit_attribute_values))
                                                                {
                                                                    if($edit_attribute_values->attribute_id==$row['attribute_id'])
                                                                    {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                
                                                                echo ' >'.ucfirst($row['attribute_name']).'</option>';
                                                            }
                                                        }
														?>
														
												</select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Select Product Category");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control" name="product_cat_type" required>
                                                        <option value=""><?php echo $this->lang->line("--Select Product Category--");?></option>
                                                        <?php
                                                            $q = $this->db->query("SELECT a.* FROM `product_cat_type` a  WHERE a.`status`=1");
                                                            $rows = $q->result();
                                                        //print_r($rows);
                                                            if(count($rows)>0)
                                                            {
                                                                foreach($rows as $row){
                                                        ?>
<option value="<?php echo $row->product_cat_type_id; ?>" <?php if( $row->product_cat_type_id==@$edit_attribute_values->attribute_values_product_cat_type_id){echo "selected"; } ?> ><?php echo $row->title; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        
                                                        ?>
                                                    </select>
													<span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Enter Attribute Value");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    
                                                    <input type="text" id="text_type" value="<?php if(!empty($edit_attribute_values))
                                                                { echo $edit_attribute_values->attribute_value;} ?>" name="attribute_value" class="form-control" required data-validation-required-message="Attribute Value is required">
													<span class="material-input"></span></div>
                                            </div>
                                        </div>
                                    
                                   
                                    
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Enable Status"); ?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    
                                                    <input style="height:30px;width:20px;" type="checkbox" value="1"  name="attribute_value_status" <?php
                                                           if(!empty($edit_attribute_values))
                                                            {                         
                                                               if($edit_attribute_values->attribute_value_status==1)
                                                               echo "checked";
                                                            }
                                                                        ?>> 
													<span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                       <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose add-curd" name="<?=$btn_name;?>" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Attribute Value List");?></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Sr. No.");?></th>
                                                    <th><?php echo $this->lang->line("Attribute Name");?> </th>
                                                    <th><?php echo $this->lang->line("Product Category Name");?> </th>
                                                    <th><?php echo $this->lang->line("Attribute Value");?> </th>
                                                    <th><?php echo $this->lang->line("Status");?></th>
                                                    <th><?php echo $this->lang->line("Created At");?></th>
                                                    
                                                    <th class="text-right"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Sr. No.");?></th>
                                                    <th><?php echo $this->lang->line("Attribute Name");?> </th>
                                                    <th><?php echo $this->lang->line("Product Category Name");?> </th>
                                                    <th><?php echo $this->lang->line("Attribute Value");?> </th>
                                                    <th><?php echo $this->lang->line("Status");?></th>
                                                    <th><?php echo $this->lang->line("Created At");?></th>
                                                    <th class="text-right"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php 
                                                $i=1;
                                                foreach($attribute_values as $attribute){ 
//                                                echo "<pre>";
//                                                    print_r($attribute);
//                                                    echo $attribute->attribute_values_id;
//                                                    echo "<br>";
                                                ?>
                                                
                                                    <tr>
                                                        <td class="text-center"><?php echo $i;?></td>

                                                        <td><?php echo ucfirst($attribute->attribute_name); ?></td>
                                                        <td><?php echo ucfirst($attribute->title); ?></td>
                                                        <td><?php if($attribute->attribute_name=="color"){ echo '<div style="width: 30px;height: 25px;background-color: '.$attribute->attribute_value.';"></div>';}else{ echo ucfirst($attribute->attribute_value);}?></td>
                                                        <td><?php if($attribute->attribute_value_status == "1"){ ?><span class="label label-success"> <?php echo $this->lang->line("Active");?></span><?php } else { ?><span class="label label-danger"> <?php echo $this->lang->line("Deactive");?></span><?php } ?></td>
                                                        <td><?php echo date("d-m-Y h:i:s", strtotime($attribute->attribute_value_created)); ?></td>
                                                        <td class="td-actions text-right"><div class="btn-group">
                                                            <?php echo anchor('admin/attributes/'.@$attribute->attribute_value_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>

                                                            <?php echo anchor('admin/delete_attribute_values/'.@$attribute->attribute_value_id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                                                <i class="material-icons">close</i>
                                                            </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                                
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    $i++;                                                 } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
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
    
    function filter(text_type_value)
    {
        
        if(text_type_value==1)
        {
//            alert("ram");
             document.getElementById("text_type").type="color";
            document.getElementById("text_type").style.width="40px";
                
        }
        else{
             document.getElementById("text_type").type="text";
            document.getElementById("text_type").value="";
            document.getElementById("text_type").style.width="600px";
        }

    }
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