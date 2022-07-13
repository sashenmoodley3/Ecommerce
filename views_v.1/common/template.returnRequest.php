<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>

    /* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
  <!-- Main Container -->
  <section class="main-container col1-layout">
    <div class="main container">
    <?php   if(empty($request)){ ?>    
      <div class="row col-main">
            <div class="heading">
                <h4><?=$this->lang->line("Return Request")?></h4> 
            </div>
          
            <div class="col-sm-8 col-sm-offset-2">
                <div class="">
                    <form method="post" action="<?=base_url()?>home/returnOrder/<?=$user_order?>" enctype="multipart/form-data">
                     <?php    echo $this->session->flashdata('message'); 
                    ?>
                    <div class="col-md-6 col-sm-6">
                        <label for="reason"><?=$this->lang->line("Reason")?><span class="required">*</span></label>
                        <textarea name="reason" class="form-control" id="reason" style="height: 55px;"></textarea>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="image"><?=$this->lang->line("Picture")?><span class="required">*</span></label>
                        <input type="file" id="image" class="form-control" name="pic">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <br/>
                        <button type="submit" class="button"><i class="fa fa-lock"></i>&nbsp; <span><?=$this->lang->line("Submit")?></span></button>
                   </div>
                    </form>
                </div>
              
            </div>
      </div>
      <?php } ?>
      <br/>
      <div class="row">
        <div class="col-md-12">   
            <?php   if(!empty($request)):?>
            <table id="datatables" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="th-details"> <?=$this->lang->line("ID")?> </th>
                        <th class="th-details"><?=$this->lang->line("Order Id")?></th>
                        <th class="th-details"><?=$this->lang->line("Request On")?></th>
                        <th class="th-details"><?=$this->lang->line("Reason")?></th>
                        <th class="th-price"><?=$this->lang->line("Image")?></th>
                        <th class="th-details"><?=$this->lang->line("Status")?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //var_dump($user_order_list);
                    $sr = 1;
                    foreach ($request as $key => $value):
                        $reson              = $value->reason;
                        $on_date            = $value->request_date;
                        $order_status       = $value->status;
                        $pic                = $value->pic;
                        $order_id           = $value->order_id;
                        $sr++;
                        if($order_status == 0){
                            $status =  "Pending";
                        }
                        elseif($order_status == 1){
                            $status =  "Return Request Accepted";
                        }
                        elseif($order_status == 2){
                            $status =  "Return Request Cancelled";
                            $color = "background-color:red;";
                        }
                        elseif($order_status == 3){
                            $status =  "Return Request Comfirmed";
                            $color = "background-color:green;";
                        }
                    ?>
                    <tr>
                        <td class="th-product"><?=$sr?></td>
                        <td class="th-product"><a href="#"><?=$order_id?></a></td>
                        <td class="th-product"><?=$on_date?></td>
                        <td class="th-product"><?=$reson?></td>
                        <td class="th-price"><img id="myImgdf" src="<?=base_url()?>/backend/uploads/returnOrder/<?=$pic?>" style="width:100px"></td>
                        <td class="th-price" style="font-size:16px;"><span class="label label-info" style="<?=$color;?>"><?=$status?></span></td>
                      
                        
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php else:?>
            <div class="table-responsive text-center">
                <h3><?=$this->lang->line("Request Empty")?></h3>
                <hr/>
            <!--                <a class="continue-btn" href="{base_url}/home"><i class="fa fa-arrow-left"> </i>&nbsp; Continue shopping</a> -->
            </div>
            <?php endif;?>
        </div> 
      </div>
    </div>
  </section>
  <!-- The Modal -->


<div id="myModalimage" class="modal">
<!--<div class="modal-dialog modal-dialog-centered">-->
    <div class="modal-content">
  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
<!--</div>-->
</div>
</div>
    
<script type="text/javascript" src="{base_url}assets/js/jquery.min.js"></script>
 <!--  DataTables.net Plugin    -->
    <script src="{base_url}assets/js/jquery.datatables.js"); ?>"></script>
    <script>
        $(document).ready(function () {
            
            $('#datatables').DataTable({
                 "order": [[0, "desc"]],
                 "dom": "<'row border-dark'<'col-sm-2 myselect'l><'col-sm-3 mybtn'B><'#cat.col-sm-2 myselect'><'col-sm-5 mysearch'f>>" 
                        + "<'row'<'col-sm-12'i>>" 
                        + "<'row'<'col-sm-12'tr>>" 
                        + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
               // dom: 'Bfrtip',
               buttons: [
                    'csvHtml5',
                    'pdfHtml5'
                ],

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
        });

        // Get the modal
        var modal = document.getElementById("myModalimage");
        
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImgdf");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
          modal.style.display = "block";
          modalImg.src = this.src;
          captionText.innerHTML = this.alt;
        }
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        } 
    </script>