<?php  $this->load->view("admin/common/head"); ?>
<style>
    .custom-datatable .col-sm-6:nth-child(2) .dataTables_filter label.form-group{
        display:block;
    }
    .custom-datatable .col-sm-6:nth-child(2) .dataTables_filter label.form-group input{
        display:block;
        width:100%;
    }
</style>
<style type="text/css">
    .ui-datepicker-trigger{
        height: 25px !important;
        width: 25px !important
    }
    #ui-datepicker-div{
        background-color: #fff;
        padding:20px;
    }
    a.ui-datepicker-next.ui-corner-all {
        float: right;
    }
    .ui-datepicker-title
    {
        text-align:center;
    }
    th {
        text-align: center;
        padding:4px;
    }
    .ui-datepicker-next::after {
      content: " >>";
    }
    .ui-datepicker-prev::before {
      content: " <<";
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
                    <div class="row">
                        <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="rose">
                                            <i class="material-icons">today</i>
                                        </div>
                                        <div class="card-content">
                                            <h4 class="card-title"><?php echo $this->lang->line("Date");?></h4>
                                            <div class="form-group">
                                                <label class="label-control"></label>
                                                <input type="text" name="date" id='txtDate' class="form-control datetimepicker" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="rose">
                                            <i class="material-icons">library_books</i>
                                        </div>
                                        <div class="card-content">
                                            <h4 class="card-title"><?php echo $this->lang->line("Start Hour");?></h4>
                                            <div class="form-group">
                                                <label class="label-control"></label>
                                                <input type="text" name="opening_time" class="form-control timepicker"  />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="rose">
                                            <i class="material-icons">av_timer</i>
                                        </div>
                                        <div class="card-content">
                                            <h4 class="card-title"><?php echo $this->lang->line("End Hour");?></h4>
                                            <div class="form-group">
                                                <label class="label-control"></label>
                                                <input type="text" name="closing_time" class="form-control timepicker"  />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4"></label>
                                    <div class="col-md-4">
                                        <div class="form-group form-button text-center">
                                            <input type="submit" name="addcatg" value="<?php echo $this->lang->line("ADD");?>"  class="btn btn-fill btn-rose" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <!--div class="card">
                                <div class="card-content">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <legend>Progress Bars</legend>
                                            <div class="progress progress-line-primary">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                            <div class="progress progress-line-info">
                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                            <div class="progress progress-line-danger">
                                                <div class="progress-bar progress-bar-success" style="width: 35%">
                                                    <span class="sr-only">35% Complete (success)</span>
                                                </div>
                                                <div class="progress-bar progress-bar-warning" style="width: 20%">
                                                    <span class="sr-only">20% Complete (warning)</span>
                                                </div>
                                                <div class="progress-bar progress-bar-danger" style="width: 10%">
                                                    <span class="sr-only">10% Complete (danger)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <legend>Sliders</legend>
                                            <div id="sliderRegular" class="slider"></div>
                                            <div id="sliderDouble" class="slider slider-info"></div>
                                        </div>
                                    </div>
                                </div>
                            </div-->
                            <!-- end card -->
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Closing Date");?></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Closing Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("From-To");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                  <th class="text-center"><?php echo $this->lang->line("Closing Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("From-To");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($schedule as $time){ ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $time->date; ?></td>
                                                        <td class="text-center"><?php echo date("h:i A",strtotime($time->from_time))." to ".date("h:i A",strtotime($time->to_time)); ?></td>
                                                        <td class="td-actions text-center"><div class="btn-group">
                                                            <?php echo anchor('admin/delete_closing_date/'.$time->id,  '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
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
                                <!-- end content-->
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none">
                        <div class="col-md-12">
                            
                            <div class="card">
                                <div class="card-content">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <legend><?php echo $this->lang->line("Progress Bars");?></legend>
                                            <div class="progress progress-line-primary">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                            <div class="progress progress-line-info">
                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                            <div class="progress progress-line-danger">
                                                <div class="progress-bar progress-bar-success" style="width: 35%">
                                                    <span class="sr-only">35% Complete (success)</span>
                                                </div>
                                                <div class="progress-bar progress-bar-warning" style="width: 20%">
                                                    <span class="sr-only">20% Complete (warning)</span>
                                                </div>
                                                <div class="progress-bar progress-bar-danger" style="width: 10%">
                                                    <span class="sr-only">10% Complete (danger)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <legend><?php echo $this->lang->line("Sliders");?></legend>
                                            <div id="sliderRegular" class="slider"></div>
                                            <div id="sliderDouble" class="slider slider-info"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>

<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders();
        demo.initFormExtendedDatetimepickers();
    });

    $(document).ready(function() {

    $("#txtDate").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd-mm-yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});

    $(document).ready(function() {

    $("#txtDate2").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd-mm-yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});
</script>

</html>