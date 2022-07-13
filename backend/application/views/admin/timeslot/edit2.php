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

</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Opening Hour");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <input type="text" name="opening_time" class="form-control timepicker" value="<?php echo (!empty($schedule) &&  $schedule->opening_time != "" ) ?  date("h:i A",strtotime( $schedule->opening_time )) :  ""; ?>" />
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
                                        <h4 class="card-title"><?php echo $this->lang->line("Closing Hour");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <input type="text" name="closing_time" class="form-control timepicker" value="<?php echo (!empty($schedule) && $schedule->closing_time != "") ?  date("h:i A",strtotime( $schedule->closing_time )) :  ""; ?>" />
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
                                        <h4 class="card-title"><?php echo $this->lang->line("Interval(Min)");?></h4>
                                        <div class="form-group">
                                            <label class="label-control"></label>
                                            <select name="interval" class="form-control timepicker">
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 30) { echo "selected"; } ?> >30</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 60) { echo "selected"; } ?> >60</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 120) { echo "selected"; } ?> >120</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 150) { echo "selected"; } ?> >150</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 180) { echo "selected"; } ?> >180</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 210) { echo "selected"; } ?> >210</option>
                                                <option <?php if(!empty($schedule) && $schedule->time_slot == 240) { echo "selected"; } ?> >240</option>
                                            </select>
                                            <!--<option <?php if(!empty($schedule) && $schedule->time_slot == 05) { echo "selected"; } ?> >05</option>-->
                                                <!--<option <?php if(!empty($schedule) && $schedule->time_slot == 10) { echo "selected"; } ?> >10</option>-->
                                                <!--<option <?php if(!empty($schedule) && $schedule->time_slot == 15) { echo "selected"; } ?> >15</option>-->
                                                <!--<option <?php if(!empty($schedule) && $schedule->time_slot == 20) { echo "selected"; } ?> >20</option>-->
                                                <!--<option <?php if(!empty($schedule) && $schedule->time_slot == 25) { echo "selected"; } ?> >25</option>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3"></label>
                                <div class="col-md-9">
                                    <div class="form-group form-button">
                                        <input type="submit" name="savecat" value="<?php echo $this->lang->line("Save");?>" class="btn btn-fill btn-rose" />
                                    </div>
                                </div>
                            </div>
                        </form>
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

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
</script>
</html>