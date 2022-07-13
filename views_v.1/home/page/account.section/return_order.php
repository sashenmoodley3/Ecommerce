<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="col-xs-12 col-sm-9 ">
    <div class="my-account">
        <?php   if(empty($request)){ ?>    
      <div class="row col-main">
            <div class="heading">
                <h4><?=$this->lang->line("Return Request")?></h4> 
            </div>
          
            <div class="col-sm-12 ">
                <div class="">
                    <form method="post" action="<?=base_url()?>home/returnOrder/<?=$user_order?>" enctype="multipart/form-data">
                     <?php    echo $this->session->flashdata('message'); 
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <label for="reason"><?=$this->lang->line("Refund Or Replace")?><span class="required">*</span></label>
                        <select class="text-input form-control" style="height:30px;" id="requestfor" name="requestfor">
                            <option value="">--Request for--</option>
                            <option value="refund">Refund</option>
                            <option value="repalce">Repalce</option>
                        </select>
                        
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label for="reason"><?=$this->lang->line("Reason")?><span class="required">*</span></label>
                        <textarea name="reason" class="form-control" id="reason" style="height: 55px;"><?php echo set_value('reason'); ?></textarea>
                    </div>
                    <div class="col-md-4 col-sm-6">
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
                        <th class="th-details text-left"> <?=$this->lang->line("ID")?> </th>
                        <th class="th-details"><?=$this->lang->line("Order Id")?></th>
                        <th class="th-details"><?=$this->lang->line("Request For")?></th>
                        <th class="th-details"><?=$this->lang->line("Request On")?></th>
                        <th class="th-details"><?=$this->lang->line("Reason")?></th>
                        <th class="th-details"><?=$this->lang->line("Response")?></th>
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
                        $description        = $value->description;
                        $requestfor        = $value->requestfor;
                        $on_date            = $value->request_date;
                        $order_status       = $value->status;
                        $pic                = $value->pic;
                        $order_id           = $value->order_id;
                        $sr++;
                        
						if ($order_status == 0) {
							$status = "<span class='label label-default'>Pending</span>";
						} 
						else if ($order_status == 1) {
							$status = "<span class='label label-info'>Confirm</span>";
						} 
						else if ($order_status == 2) {
							$status = "<span class='label label-danger'>Reject</span>";
						} 
						else if ($order_status == 3 || $order_status == 4) {
							$status = "<span class='label label-warning'>Arriving</span>";
						}
						else if ($order_status == 5) {
							$status = "<span class='label label-warning'>In Transit</span>";
						}
						else if ($order_status == 6) {
							$status = "<span class='label label-danger'>Denied</span>";
						}
						else if ($order_status == 7) {
							$status = "<span class='label label-success'>Returned</span>";
						}
						
					
                    ?>
                    <tr>
                        <td class="th-product"><?=$sr?></td>
                        <td class="th-product"><a href="#"><?=$order_id?></a></td>
                        <td class="th-product"><?=ucfirst($requestfor)?></td>
                        <td class="th-product"><?=$on_date?></td>
                        <td class="th-product"><?=$reson?></td>
                        <td class="th-product"><?=$description?></td>
                        <td class="th-price">
						<?php if(!empty($pic)){ ?>
							<img id="myImgdf" src="<?=base_url()?>/backend/uploads/returnOrder/<?=$pic?>" style="width:100px">
						<?php } ?>
						</td>
                        <td class="th-price"><?=$status?></td>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            
            </div>
            <?php endif;?>
        </div> 
      </div>
    
	
	</div>
</div>
  


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