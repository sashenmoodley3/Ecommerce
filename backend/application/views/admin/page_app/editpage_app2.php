<?php  $this->load->view("admin/common/head"); ?>
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
    <?php  $this->load->view("admin/common/sidebar"); ?>
    <div class="main-panel">
        <?php  $this->load->view("admin/common/header"); ?>
        <div class="content">
            <div class="container-fluid">
                <?php  if(isset($error)){ echo $error; }
                echo $this->session->flashdata('message');
                ?>
                <div class="row">
                    <form id="add_page_form" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                        <?php if($this->session->userdata('language') == "arabic")
                        {
                            ?>
                            <div class="col-md-3">
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Purchase products");?></h4>
                                    <div class="row" style="margin-top:50px">

                                        <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Page Title :");?> *</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="page_title" class="form-control" placeholder="<?php echo $this->lang->line("Page Title");?>" value="<?php echo $onepage->pg_title; ?>"/>
                                                <input type="hidden" name="page_id" class="form-control" placeholder="Page id" value="<?php echo $onepage->id; ?>"/>
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Page Description.");?>.</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty" id="sample">
                                                <textarea   name="page_descri" id="page_descri" class="form-control " placeholder="<?php echo $this->lang->line("Place some text here");?>"><?php echo $onepage->pg_descri; ?></textarea>
                                                <span class="material-input"></span></div> <!--id="editor"-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3"></label>
                                        <div class="col-md-9">
                                            <div class="form-group form-button">
                                                <input type="submit" class="btn btn-fill btn-rose" name="savepageapp" value="<?php echo $this->lang->line("Save");?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php  $this->load->view("admin/common/footer"); ?>
    </div>
</div>
<?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->



<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js">

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>

<script type="text/javascript">
 CKEDITOR.replace( 'page_descri' );
</script>
</html>