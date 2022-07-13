<?php  $this->load->view("admin/common/head"); 
$q  =   $data; 
?>
</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Title");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                           <input type="text" name="title" class="form-control" value="<?=!empty($q->title) ?  $q->title : ''?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Description Type");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select id="desc_type" class="form-control js-example-basic-multiple" name="desc_type">
        									  <option  value=""><?php echo $this->lang->line("--Select Description Type--");?></option>
        									  <option  value="image" <?=$q->desc_type=='image' ? 'selected' :''?>><?php echo $this->lang->line("Image");?></option>
        									  <option  value="video" <?=$q->desc_type=='video' ? 'selected' :''?>><?php echo $this->lang->line("Video");?></option>
        									  <option  value="description" <?=$q->desc_type=='description' ? 'selected' :''?>><?php echo $this->lang->line("Description");?></option>
        									</select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">library_books</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Description");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <textarea name="description" id="description" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>"><?=!empty($q->desc) ?  base64_decode($q->desc) : ''?> </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                                <label class="col-md-4"></label>
                                <div class="col-md-9">
                                    <div class="form-group form-button">
                                        <input type="submit" name="savecat" value="<?php echo $this->lang->line("Save");?>" class="btn btn-fill btn-rose" />
                                    </div>
                            </div>
                        </div>
                    </form>
                   
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->
<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
<script type="text/javascript">
 CKEDITOR.replace( 'description' );
</script>
</html>