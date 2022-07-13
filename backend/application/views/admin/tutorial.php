<?php  $this->load->view("admin/common/head"); 
$datas  =    json_decode($result); 
?>

<body>
    <div class="animated yt-loader"></div>
    <div class="wrapper">
        <!-- side -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel" <?php if($this->session->userdata('language') == "arabic"){ echo 'style="float:left"'; } ?>>
            <!-- head-->
            <?php  $this->load->view("admin/common/header"); ?>
            <!-- content -->
            <div class="content">
                <div class="container-fluid">
                    <?php if(isset($message) && $message!=""){
                            echo $message;
                        } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <?php  foreach($datas as $row){   ?>
                                    <div class="card-content">
                                        
                                        <h4 class="card-title"><?=$row->title?></h4>
                                        <div class="toolbar">
                                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?=base64_decode($row->description)?>
                                            </div>
                                        </div>
                                        <div class="row"  style="margin-top:10px">
                                            <div class="col-md-12">
                                                <iframe width="100%" height="500" src="<?=$row->video_url?>"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                </div>
            </div>
            <!-- Foot -->
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/utils.js"); ?>"></script>

</html>