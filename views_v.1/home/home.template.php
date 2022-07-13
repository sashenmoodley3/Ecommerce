<!DOCTYPE html>
<?php
$head = "common/template.head.php";
$mobile_nav = "common/template.mobile.nav.php";
$body_content = $this->config->item('body_content');
if (empty($body_content)) {
    $body_content = "home/page/home.content.php";
}
$header = "common/template.header.php";
$footer = "common/template.footer.php";
$javascript = "common/template.javascript.php";
//var_dump($top_selling_products);
$total_order_price = 0;
?>
<html lang="en">
    <head>
        <!--        <link href="{base_url}/assets/css/app.min.css" rel="stylesheet" type="text/css"/>-->
        <link href="{base_url}/assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <?php $this->load->view("$head"); ?>
        <style>
            .error {
                color: red;
            }
        </style>
    </head>
    <body class="cms-index-index cms-<?= !empty($this->uri->segment(1))? $this->uri->segment(1) : 'home'?>">
        <?php if(!empty($this->config->item('tag_manager'))){ ?>
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?=$this->config->item('tag_manager');?>"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
        <?php } ?>
        <div id="sidebar"></div>
        
        <?php $this->load->view("$mobile_nav"); ?>
        <!-- mobile menu -->
        <div id="page">
            <!-- Header -->
            <?php $this->load->view("$header"); ?>
            <!-- body -->
            <?php $this->load->view("$body_content"); ?>
            <!-- Footer -->
            <a class="voucherList" data-toggle="modal" data-target="#vouchers"></a>
            <div class="modal fade" id="vouchers" role="dialog">
                <div class="modal-dialog modal-lg">
                  <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Apply voucher</h4>
                        </div>
                        <div class="modal-body" id="voucherList">
                          
                        </div>
                    </div>
                  
                </div>
            </div>
            <?php $this->load->view("$footer"); ?>
                
            <script src="{base_url}/assets/js/addtohomescreen.js"></script>
            <!-- The core Firebase JS SDK is always required and must be listed first -->
            <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>
            
            <!-- TODO: Add SDKs for Firebase products that you want to use
                 https://firebase.google.com/docs/web/setup#available-libraries -->
            <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-analytics.js"></script>
            <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-messaging.js"></script>
        <?php if(!empty($this->config->item('tawk_panel'))){ ?>
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/<?=$this->config->item('tawk_panel')?>/default';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        
        </script>
        <!--End of Tawk.to Script-->
        <?php } ?>
        <script>
			$('.datalist').on('click', function(e){
                var ullist  =   $(this).children('ul')[0]['localName'];
                if($(this).find(ullist).css('display') == 'none'){
                    $(this).find('.expand').removeClass('fa-chevron-down').addClass('fa-chevron-up').addClass('open');
                }
                else{
                    $(this).find('.expand').removeClass('fa-chevron-up').removeClass('open').addClass('fa-chevron-down');
                }
                $(this).find(ullist).toggle('slow');
            })
			
            $(document).ready(function(e){
                 setTimeout(function(){ 
                    $('.AdminView').trigger('click');
                 }, 3000);
            })
            function homeBack(){
                this.sendToApp({'type': 'close'});
            }
            if($("body").hasClass("cms-home")){
                if($("body").find('#headerback')){}
                else{
                    $(".panel-header").remove('<span class="back-icon" id="headerback" style="cursor:pointer"></span>');
                }
            } 
            else{
                $('.mm-label').css('width','calc(100% - 158px)');
                //$(".panel-header").prepend('<span class="back-icon" id="headerback" style="cursor:pointer"></span>');
            }

            $(document).on('click','.back-icon', function(e){
                window.history.back();
            })
        
            $(document).on('click','#go_back_dashboard',function(e){
                homeBack();
            });
            $(document).on("click",".menu_icon",function(e){
                e.preventDefault();
                if($('body').hasClass('cms-home')){
                    homeBack();
                } else {
                    var historyLenght = window.history.length;
                    if(historyLenght == 1){
                        homeBack(); 
                        return false;                   
                    }
                    window.history.go(-1);
                }
            });
        
        
            $(document).on('click','.search-form', function(e){
                $('.top-form').toggleClass('open');
            })
            
        
            $(document).on('keyup','#txtCountry',function(){
                var searchkey   =   $(this).val();
                //console.log(searchkey);
                if(searchkey !='' && searchkey.length > 1){
                    $.ajax({
                		type: "post",
                		url: "{base_url}search_process",
                		data: {searchkey:searchkey},
                		dataType: "json",
                		success: function (response) {
                		    if(response.status == 1){
                		        $('.header-dropdown--search').css('display','block');
                		        $('.ps-active-y').html(response.html);
                		    }
                		    else{
                		        $('.header-dropdown--search').css('display','none');
                		    }
                		}
                    });
                }
                else{
    		        $('.header-dropdown--search').css('display','none');
    		    }
            }) 
        </script>
        
       

        <?php //$this->load->view($popup); ?>
        <?php $this->load->view("$javascript"); 
        
        if(!empty($this->session->flashdata('mess'))){  ?>
            <script>
                $.notify({
                    	message: '<?php echo $this->session->flashdata('mess');?>'
                    },{
                    	type: 'success',
                    	placement: {
                    		from: "top",
                    		align: "right"
                    	},
            });
            </script>
            <?php
            }
            ?>
            
        <script>
              // Your web app's Firebase configuration
              
              var firebaseConfig = {
                    // apiKey: "AIzaSyBCP__OPx7xBDNeg2r84LOcqHazPY0Inhg",
                    // authDomain: "kriscent-kartsupermarket.firebaseapp.com",
                    // databaseURL: "https://kriscent-kartsupermarket.firebaseio.com",
                    // projectId: "kriscent-kartsupermarket",
                    // storageBucket: "kriscent-kartsupermarket.appspot.com",
                    // messagingSenderId: "1035543561350",
                    // appId: "1:1035543561350:web:9220d5e7147713758f7d07",
                    // measurementId: "G-D2NGL7J02E"
                    apiKey: "AIzaSyC2wtgs4lUpGNTWryU0TpaTE7CE8-pULwc",
                    authDomain: "mnandiretailsolutions.firebaseapp.com",
                    projectId: "mnandiretailsolutions",
                    storageBucket: "mnandiretailsolutions.appspot.com",
                    messagingSenderId: "249319490337",
                    appId: "1:249319490337:web:21a1c40b2573f59ebab460",
                    measurementId: "G-N0G62JW2R0",
                  databaseURL: "https://mnandiretailsolutions-default-rtdb.europe-west1.firebasedatabase.app/",
            
              };
              // Initialize Firebase
              firebase.initializeApp(firebaseConfig);
              firebase.analytics();
              // Retrieve Firebase Messaging object.
            const messaging = firebase.messaging();
            // Add the public key generated from the console here.
            messaging.usePublicVapidKey("BJ26kqar1BfDAyeklTfIknejejQNrsBspFwUkmiWTE6eygFQB2WQw5eYvH88EFLWZQQskjw3R6VII0C-jpZi4qY");
            
            
            
            
            // Get Instance ID token. Initially this makes a network call, once retrieved
            // subsequent calls to getToken will return from cache.
            messaging.getToken().then((currentToken) => {
              if (currentToken) {
                sendTokenToServer(currentToken);
                updateUIForPushEnabled(currentToken);
              } else {
                // Show permission request.
                console.log('No Instance ID token available. Request permission to generate one.');
                // Show permission UI.
                updateUIForPushPermissionRequired();
                setTokenSentToServer(false);
              }
            }).catch((err) => {
              console.log('An error occurred while retrieving token. ', err);
              showToken('Error retrieving Instance ID token. ', err);
              setTokenSentToServer(false);
            });
            
            
            // Callback fired if Instance ID token is updated.
            messaging.onTokenRefresh(() => {
              messaging.getToken().then((refreshedToken) => {
                console.log('Token refreshed.');
                // Indicate that the new Instance ID token has not yet been sent to the
                // app server.
                setTokenSentToServer(false);
                // Send Instance ID token to app server.
                sendTokenToServer(refreshedToken);
                // ...
              }).catch((err) => {
                console.log('Unable to retrieve refreshed token ', err);
                showToken('Unable to retrieve refreshed token ', err);
              });
            });
            
            
            
            // Handle incoming messages. Called when:
            // - a message is received while the app has focus
            // - the user clicks on an app notification created by a service worker
            //   `messaging.setBackgroundMessageHandler` handler.
            messaging.onMessage((payload) => {
              console.log('Message received. ', payload);
              // ...
            });
            
             $(document).on('click','._3NH1qf', function(e){
                addToHomescreen();
            })
            var unregisterSW = function(forceReload) {
    			navigator.serviceWorker.getRegistration().then(function(registration) {
    				var serviceWorkerUnregistered=false;
    				if(registration) {
    					registration.unregister();
    					serviceWorkerUnregistered=true;
    				}
    				(serviceWorkerUnregistered || forceReload);
    			});
    		}
            /* navigator.cookieEnabled means cookies are enabled */
    		if (navigator.cookieEnabled) {
    			if ('serviceWorker' in navigator && navigator.userAgent.indexOf("Mobile")!==-1) {
    				if(window.location.hostname === '<?=$this->config->item('base_url');?>') {
    					unregisterSW(true);
    				} else {
    					navigator.serviceWorker.register('/sw.js').then(function(registration) {
    						console.log('ServiceWorker registration successfull with scope: ', registration.scope);
    					})
    					.catch(function(err) {
    						window.Sentry &&
    						window.Sentry.captureException &&
    						window.Sentry.captureException(err);
    						console.error('ServiceWorker registration failed: ', err);
    					});
    					navigator.serviceWorker.ready.then(function(swRegistration) {
    						window.heartBeatPushFailed = true;
    						return swRegistration.sync && swRegistration.sync.register('heart-beat-for-push').then(function() {
    							// registration succeeded
    							window.heartBeatPushFailed = false;
    							console.log('Sync registration successfull for web push Heart beat');
    						}, function(err) {
    							console.log('Sync registration failed for web push Heart beat: ' + err);
    						});
    					})
    					.catch(function(err) {
    						console.log('Sync registration failed for web push Heart beat: ' + err);
    					});
    				}
    			} else if('serviceWorker' in navigator && navigator.userAgent.indexOf("Mobile")===-1) {
    				unregisterSW();
    			}
    		}
        </script>
        <script>
            $(document).ready(function () {
                $(document).delegate('[data-event="close"]', "click", function (e) {
                    e.preventDefault();
                    $($(this).data('target')).css({'display': 'none'});
                });
                $(document).delegate('[data-event="click"]', "click", function (e) {
                    e.preventDefault();
                    $($(this).data('target')).css({'display': 'block'});
                });

                /*************Checkout ******************/
                $(document).on("click", '#shipping_wallet',  function (e) {
                    
                    if ($('#existing_wallet_amount').val() === "0.00" || $('#existing_wallet_amount').val() === 0) {
                        e.preventDefault();
                        $.notify({
                                	message: 'You have R 0.00 in your wallet'
                                },{
                                	type: 'danger',
                                	placement: {
                                		from: "top",
                                		align: "right"
                                	},
                                });
                        return;
                    }
                   
                    if ($(this).is(":checked")) {
                        var coupan_amount_use =   $('#coupan_amount_use').val();
                        var used_wallet_amount  =   $(this).data('used-wallet-amount');
                        var existing_wallet_amount = $('#existing_wallet_amount').val();
                        var existing_cart_amount =   $('#existing_cart_amount').val() - coupan_amount_use;
                        var shipping_charges =   parseFloat($('#final_shipping_charges').val());
                        var newShippingCharge = existing_cart_amount - used_wallet_amount;

                        if (existing_wallet_amount < existing_cart_amount) {
                            var remaining = (existing_cart_amount - (used_wallet_amount));
                        } else {
                            var remaining = (existing_cart_amount - (used_wallet_amount + newShippingCharge));
                        }    

                        //var remaining           =   (existing_cart_amount - used_wallet_amount);
                        $('.existing_cart_amount').html(remaining);
                        $('.view_wallet_info').css({'display': 'inline'});

                        var existingWalletAmount = $('#existing_wallet_amount').val();

                        if (existingWalletAmount - existing_cart_amount > 0) {
                            var remainingString = 'Remaining Wallet R ' + parseFloat(existingWalletAmount - existing_cart_amount).toFixed(2); 
                        } else {
                            var remainingString = 'remaining Wallet R 0.00';
                        }

                        $('#remain_wallet').html(remainingString);
                        
                        //alert($(this).data('remaining'));
                        //$('.used_wallet_amount').html($(this).data('usedWalletAmount'));
                        $('#final_total_price').html(remaining);
                        //$('.used_wallet_amount').css({'display':'inline'});
                    } else {
                        //console.log("in");
                        var coupan_amount_use =   $('#coupan_amount_use').val();
                        var shipping_charges=   parseFloat($('#final_shipping_charges').val());
                        var existing_cart_amount=   parseFloat($('#existing_cart_amount').val()) - coupan_amount_use;
                        var final_shipping_charges=   $('#final_shipping_charges').val();
                        var used_wallet_amount=   $('#used_wallet_amount').val();
                        
                        //alert("total_all="+existing_cart_amount+"+"+used_wallet_amount+"+"+coupan_amount_use+"+"+final_shipping_charges);
                        
                        amount = parseFloat(existing_cart_amount);
                        shipping_charges1=   parseFloat(shipping_charges);
                        //alert("amount="+amount);
                        amount1 = (existing_cart_amount);
                        //amount1 = (existing_cart_amount);
                        $('.existing_cart_amount').html(amount1);
                        $('.view_wallet_info').css({'display': 'none'});
                        $('.used_wallet_amount').html('0');
                        $('#final_total_price').html(amount1);
                        //$('.used_wallet_amount').css({'display':'none'});
                    }
                    //alert();
                });
                $("#frm_checkout").validate();
                $("#addAddressFrm").validate();


                // Assign handlers immediately after making the request,
                // and remember the jqXHR object for this request

                /*
                 $(document).delegate("#quick_view_popup-close", "click", function(e){
                 e.preventDefault();
                 //                    $('#quick_view_popup-wrap').css({'display':'none'});
                 //                    $('#quick_view_popup-wrap').html('');
                 $( '#quick_view_popup-wrap' ).remove();
                 });
                 $(document).delegate(".quick_view,.quick-view", "click", function(e){
                 e.preventDefault();
                 var jqxhr = $.ajax({
                 url: "http://localhost/basket2homes/web_app/quick_view",
                 beforeSend: function (xhr) {
                 //xhr.overrideMimeType("text/plain; charset=x-user-defined");
                 //$(document).append('<div id="quick_view_popup-overlay"></div>');
                 }
                 }).done(function (data) {
                 //alert("success");
                 $('body').append(data)
                 })
                 .fail(function () {
                 //alert("error");
                 })
                 .always(function () {
                 //alert("complete");
                 });
                 // Set another completion function for the request above
                 jqxhr.always(function () {
                 //alert("second complete");
                 });
                 });
                 */
            });
           
            function js_dmy_to_ymd(dateInDmy,seprator,newSeprator) { 
                    var dateArr = dateInDmy.split(seprator);
                    var day     = dateArr[0];
                    var month   = dateArr[1];
                    var year    = dateArr[2];

                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day     = '0' + day;

                    var dateInYmd   = year+'-'+month+'-'+day;
                    return dateInYmd;
                }
            function js_ymd_to_dmy(dateInDmy,seprator,newSeprator) { 
                var dateArr = dateInDmy.split(seprator);
                var day     = dateArr[2];
                var month   = dateArr[1];
                var year    = dateArr[0];

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day     = '0' + day;

                var dateInYmd   = day+'/'+month+'/'+year;
                return dateInYmd;
            }
            function js_mdy_to_ymd(dateInDmy,seprator,newSeprator) { 
                var dateArr = dateInDmy.split(seprator);
                var month   = dateArr[1];
                var day     = dateArr[0];
                var year    = dateArr[2];

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day     = '0' + day;

                var dateInYmd   = year+newSeprator+month+newSeprator+day;
                return dateInYmd;
            }
            <?php if($this->config->item('time_slot') == 1){ ?>
            var date = new Date();
            
            var delivery_date = parseInt('<?php echo !empty($this->config->item("delivery_date_after_days"))? $this->config->item("delivery_date_after_days") : 0 ; ?>');
			if(isNaN(delivery_date)){
				delivery_date = 0;
			}
			// alert(delivery_date)
            date.setDate(date.getDate()+delivery_date);
			
			// alert(date)
                $("#shipping_date").datepicker({
                    todayBtn:  1,
                    setDate: date,
                    startDate: date,
                    autoclose: true,
                    format   : 'dd-mm-yyyy',
                    daysOfWeekDisabled: "0,1,2,3,5,6"
                }).on('changeDate', function (selected) {
                    var date            =   js_mdy_to_ymd($(this).val(),'-','-');
                    var cdate           =   $('#cdate').val();
                    var fdate           =   $('#fdate').val();
                    var fromtime        =   $('#shipping_time_from').val()+':00';
					
                    var totime          =   $('#shipping_time_to').val()+':00';
                    var timefrom        =   '<?php echo $shopclosetime->from_time;?>';
                    var timeto          =   '<?php echo $shopclosetime->to_time;?>';
					
                    var shopopentime    =   '<?=$shopopentime->opening_time?>';
                    var shopclosetime   =   '<?=$shopopentime->closing_time?>';
					//alert(shopopentime);
                    $('#view_shipping_date').html($(this).val());
					// alert((this).val())
					// alert(cdate)
					// alert(date)
                    if(date >= cdate){
                        if(date != fdate){
                             $.ajax({
                                type: "POST",
                                url: '<?= base_url() ?>getordertime',
                                dataType : "json",
                                data: {date : date},
                                success: function(result){
                                    $('#shipping_time_from').empty();
                                    var option      =   '<option value="" selected="">Select Delivery Time</option>';
                                    if(result.status == 1){
                                            $('.selecttime').show();
                                            var optionlength  = result.times.length;
                                            for(var i=0; i< optionlength; i++){
                                                option  += '<option value="'+result.times[i]+'">'+result.times[i]+'</option>';   
                                            }
											$('#shipping_time_from').html(option);
											$('#show_closingerror').html('');
                                    
                                    }
									else{
										$('.selecttime').hide();
										$('#show_closingerror').html('Today We Are Closed');
									}
                                    


                                }
                            });
                         }
                         else{
                            if(timefrom < fromtime && timeto > totime){
                                swal({
                                    title: 'Error!',
                                    text: 'Shop is Currently Close !!',
                                    icon: "error",
                                    timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                                $('.place_order').attr('disabled','disabled');
                            }
                            else if(shopopentime > fromtime && shopclosetime < totime){
                                $.notify({
                                	message: 'Shop is Currently Close !!'
                                },{
                                	type: 'danger',
                                	placement: {
                                		from: "bottom",
                                		align: "right"
                                	},
                                });
                                $('.place_order').attr('disabled','disabled');
                            }
                            else{
                                $('.place_order').removeAttr('disabled');
                            }
                         }
                    }
                    else{
                        // $.notify({
                    	    // message: 'Please Current date or Greater then !!'
                        // },{
                        	// type: 'danger',
                        	// placement: {
                        		// from: "bottom",
                        		// align: "right"
                        	// },
                        // });
                        // $('#shipping_date').datepicker('update', date);
						// $('#shipping_date').datepicker('setDate', date);

                    }
                   
                });
            <?php } ?>
			 $(document).ready(function () {
				$("#shipping_date").datepicker("setDate",date);
			 })
             $(document).on('change', '#shipping_time_from', function(e){
                    var selectedTime    =   $(this).val();
                    var selectedTimeArr =   selectedTime.split('-');        
                    $('#view_shipping_time_from').html(selectedTimeArr[0]);
                    $('#view_shipping_time_to').html(selectedTimeArr[1]);
             }); 
             
             
             $(document).on('click','.remove-cart', function(e){
                 var product_id             =   $(this).data('id');
                 var product_varient_id     =   $(this).data('varient');
                 if(product_id !='' && product_varient_id !=''){
                     $.ajax({
                		type: "post",
                		url: "{base_url}delete_cart",
                		data: {product_id:product_id,product_varient_id:product_varient_id},
                		dataType: "json",
                		success: function (response) {
                		    $('.cart-total').html(response.total_item+' item');        		     
                		    $('#total_order_price').html(response.total_order_price.toFixed(2));
                		    $('#list_'+product_varient_id).remove();
                		    $('#list_'+product_varient_id).closest("tr").remove();
                		    $('#total_amount').html(response.total_order_price.toFixed(2));
                		    $('#cart'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		    $('#cart2_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		    $('#cart_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		    $('#cart3_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		    if($('#product-listingsave'+product_id).find('.badge').length > 0){
                		         var data   =   parseInt($('#product-listingsave'+product_id).find('.badge').html());
                		         data       =   (data - 1);
                		         $('#product-listingsave'+product_id).html('<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-bag"></i><span class="badge">'+data+'</span></a></div>');
                		     }
                		     else{
                		         $('#product-listingsave'+product_id).html('<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-bag"></i><span class="badge">0</span></a></div>');
                		     }
                		    if(response.status == 0){
                		        $('.order_detail').css('display','none');
                		        $('.empty_order').css('display','block');
                		    }
                		    else{
                		        $('.order_detail').css('display','block');
                		        $('.empty_order').css('display','none');
                		    }
                		    //  $.notify({
                            // 	message: 'Product Removed From Cart'
                            // },{
                            // 	type: 'success',
                            // 	placement: {
                            // 		from: "bottom",
                            // 		align: "right"
                            // 	},
                            // });
                		}
                     });
                 }
                 
                 
             })
             
             
            $(document).on('change', ".select_option_item", function (e) {
                debugger;
                //console.log($(this).find(':selected').val());
        		e.preventDefault();
        		var unit_value = $(this).find(':selected').val();
        		var vid = $(this).find(':selected').data('vid');
        		var idd = $(this).find(':selected').data('idd');
        		var price = $(this).find(':selected').data('price');
        		
        		var mrp = $(this).find(':selected').data('mrp');
        		var difference = $(this).find(':selected').data('difference');
        		var units = $(this).find(':selected').data('units');
        		var varient = $(this).find(':selected').data('varient');
        		var single  = $(this).find(':selected').data('single');
        		$('#product_id1_'+ idd).val(idd);
        		$('#product_varient_id1_'+ idd).val(varient);
        		$('#price1_'+ idd).val(single);
        		$('#unit1_'+ idd).val(unit_value);
        		$('#unit_value1_'+ idd).val(units);
        		
                
        		$("#ids" + idd).text("<?=$this->config->item('currency')?> "+mrp+"/-");
        		$("#regids" + idd).text("<?=$this->config->item('currency')?> "+price+"/-");
                $(".fls" + idd).text($(this).find(':selected').data('flavor'));
                    
            });
             
            $(document).on('click','#btnSrch1', function(e){
                debugger;
                e.preventDefault();
                var butoon      =   $(this);
                var product_id  =   $(this).data('id');
                var varient_id  =   $('#product_varient_id1_'+product_id).val();
                var price       =   $('#price1_'+product_id).val();
                var unit        =   $('#unit1_'+product_id).val();
                var unit_value  =   $('#unit_value1_'+product_id).val();
                var qty         =   $('#qty1_'+product_id).val();
                var stock       =   parseInt($('#stock_'+product_id).html().replace(/[^0-9]/g, ''));

                if(product_id !='' && varient_id !=''){
                    $(this).find('i').removeClass('fa fa-shopping-bag').addClass('icon-loader');
                    $.ajax({
                		type: "post",
                		url: "{base_url}add_cart",
                		data: {product_id:product_id,product_varient_id:varient_id,price:price,unit:unit,unit_value:unit_value,qty:qty,stock:stock},
                		dataType: "json",
                		success: function (response) {
                		     $(butoon).find('i').removeClass('icon-loader').addClass('fa fa-shopping-bag');
                		     $('.cart-total').html(response.total_item+' item');        		     
                		     $('#cart-sidebar').html(response.html);        		     
                		     $('#total_order_price').html(response.total_order_price.toFixed(2));
                		     $('#cart'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		     $('#cart2_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		     $('#cart_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		     $('#cart3_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		     if($('#product-listingsave'+product_id).find('.badge').length > 0){
                		         var data   =   parseInt($('#product-listingsave'+product_id).find('.badge').html());
                		         data       =   (data + 1);
                		         $('#product-listingsave'+product_id).html('<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-bag"></i><span class="badge">'+data+'</span></a></div>');
                		     }
                		     else{
                		         $('#product-listingsave'+product_id).html('<div class="product-added-to-cart__icon-wrap"><a class="product-added-to-cart__icon-cta cart-icon" href="javascript:;"><i class="fa fa-shopping-bag"></i><span class="badge">1</span></a></div>');
                		     }
                		    // $.notify({
                            // 	message: 'Product Added To Cart'
                            // },{
                            // 	type: 'success',
                            // 	placement: {
                            // 		from: "bottom",
                            // 		align: "right"
                            // 	},
                            // });
                		    //location.reload();
                		}
                    });
                }
            });
            
           $(document).on('click', function(e) {
                if ( ! $(e.target).closest('#search').length ) {
                    $('#header-dropdown').css('display','none');
                }
            });
             
            
            
            
            function addToCart(product_id,varient_id,price,unit,unit_value,qty, key){
                
                if(product_id !='' && varient_id !=''){
                    $.ajax({
                		type: "post",
                		url: "{base_url}add_carts",
                		data: {product_id:product_id,product_varient_id:varient_id,price:price,unit:unit,unit_value:unit_value,qty:qty,key:key},
                		dataType: "json",
                		success: function (response) {
                		     $('#cart-sidebar').html(response.html);        		     
                		     $('#total_order_price').html(response.total_order_price);
                		     $('#cart'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		     $('#cart2_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		     $('#cart_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		     $('#cart3_'+product_id).html('<i class="fa fa-shopping-bag"></i><span> Add to Cart</span>');
                		     if(key == 'minus'){
                		        //  $.notify({
                                //     	message: 'Product quantity remove to cart'
                                //     },{
                                //     	type: 'success',
                                //     	placement: {
                                //     		from: "bottom",
                                //     		align: "right"
                                //     	},
                                // });
                		     }
                		     else{
                		        // $.notify({
                                //     	message: 'Product quantity add To Cart'
                                //     },{
                                //     	type: 'success',
                                //     	placement: {
                                //     		from: "bottom",
                                //     		align: "right"
                                //     	},
                                // });
                		     }
                		    
                		}
                    });
                }
            }
            
            
            $(document).on("click","#changePersonalDetails",function(){
                var newpwd=$("#showHidePassword").val();
                var oldpwd=$("#oldPassword").val();
                if(newpwd.length>=6&&newpwd.length<=60){
                    if(newpwd==oldpwd){
                        showGenericError("New password should not be same as old password.")
                        
                    }else{
                        $(this).prop("disabled",true);
                        get_userChangePassword()
                        
                    }
                    
                }
                
            });
            $(document).on("click","#showHideOldpwd",function(e){
                if($("#oldPassword").attr("type")==="password"){
                    $("#oldPassword").attr("type","text");
                    $("#showHideOldpwd").attr("checked","checked")
                    
                }else{
                    $("#oldPassword").attr("type","password");
                    $("#showHideOldpwd").removeAttr("checked")
                    
                }
                
            });
            $(document).on("click","#showHidepwd",function(e){
                if($("#showHidePassword").attr("type")==="password"){
                    $("#showHidePassword").attr("type","text");
                    $("#showHidepwd").attr("checked","checked")
                    
                }else{
                    $("#showHidePassword").attr("type","password");
                    $("#showHidepwd").removeAttr("checked")
                    
                }
                
            });
            $(document).on("click",".showHideReg",function(e){
                if($(".reg_showInput").attr("type")==="password"){
                    $(".reg_showInput").attr("type","text");
                    $(".showHideReg").attr("checked","checked")
                    
                }else{
                    $(".reg_showInput").attr("type","password");
                    $(".showHideReg").removeAttr("checked")
                    
                }
                if($(".update-pwdInput").attr("type")==="password"){
                    $(".update-pwdInput").attr("type","text");
                    $(".showHideReg").attr("checked","checked")
                    
                }
                else{
                    $(".update-pwdInput").attr("type","password");
                    $(".showHideReg").removeAttr("checked")
                    
                }
                
            });
            $(document).on("click",".showHideReg",function(e){
                if($(".signin_showInput").attr("type")==="password"){
                    $(".signin_showInput").attr("type","text");
                    $(".showHideReg").prop('checked', true);
                    
                }else{
                    $(".signin_showInput").attr("type","password");
                    $(".showHideReg").removeAttr("checked")
                    
                }
                
            });
            $(document).on("click",".showHideConf",function(e){
                if($(".signin_confPass").attr("type")==="password"){
                    $(".signin_confPass").attr("type","text");
                    $(".showHideConf").prop('checked', true);
                    
                }else{
                    $(".signin_confPass").attr("type","password");
                    $(".showHideConf").removeAttr("checked")
                    
                }
                
            });
            $(document).on("wheel", "input[type=number]", function (e) {
                $(this).blur();
            });
            
            
        function radio_check(id){
            //alert(id);
            $( "#visa" ).prop( "checked", false );
            $( "#mastercardd" ).prop( "checked", false );
            $( "#mastercard" ).prop( "checked", false );
            $( "#"+id ).prop( "checked", true );
            if(id=="radio_button_5")
            {
                //$(".well-wallet").hide();
            }
            else
            {
               // $(".well-wallet").show();
            }
        }

        function toggleVoucherTermsAndConditions(id){
            var div = document.getElementById('collapse_'+id);
            console.log(div);
            if (div.style.display !== 'none') {
                div.style.display = 'none';
            }
            else {
                div.style.display = 'block';
            }
        }    
            
        function showVoucherList(){
            var hello = "hello";
            $.ajax({
        		type: "post",
        		url: "{base_url}voucherList",
        		data: {user:hello},
        		dataType: "json",
        		success: function (data) {
        		    
        		  if(data.response == 1){
        		      
        		      $('#voucherList').html(data.Couponslist);
        		      $('#vouchers').modal('show');
        		      console.log(data);
        		  }
        		  else{
        		      $('#voucherList').html('Vouchers Not Available !!');
        		  }
        		}
            });
        }  
        
        $(document).on('click','.btn-voucher', function(e){
            var coupanCode              =   $('.ng-pristine').val();
            var existing_cart_amount    = $('#existing_cart_amount').val();
            var finalAmount    = $('#final_total_price').html();

            // if(finalAmount === "0.00" || finalAmount === "0" || finalAmount === 0 || finalAmount === 0.00){
            //     $('.appled_coupan').css('display','block');
    		//     $('.appled_coupan').removeClass('text-primaries').addClass('text-danger');
    		//     $('.appled_coupan').html('Your total can not be R0.00');
            //     return;
            // }

            if ($("#shipping_wallet").is(":checked")) {
                    $("#shipping_wallet").trigger('click')
                } 

            if(coupanCode !=''){
                $.ajax({
            		type: "post",
            		url: "{base_url}applyVoucher",
            		data: {amt:existing_cart_amount,coupanCode:coupanCode},
            		dataType: "json",
            		success: function (data) {
            		  if(data.response == 1){
                         if (document.getElementById('shipping_wallet').checked) {
                                var html              =   data.datas;
                               var discountAmount    =   parseFloat(html.coupon_discount_amt).toFixed(2);
                               var final_total_price = $('#final_total_price').html() - discountAmount;
            		       } else {
                                var html              =   data.datas;
                                var discountAmount    =   parseFloat(html.coupon_discount_amt).toFixed(2);
                                var final_total_price =   html.remainingAmount;
                           }
                            //$('#existing_cart_amount').val(final_total_price);
            		        $('.appled_coupan').css('display','block');
            		        $('.appled_coupan').removeClass('text-danger').addClass('text-primaries');
            		        $('.appled_coupan').html('Discount will be applied on successful payment');
        		            $('.ng-pristine').val(coupanCode);
        		            $('.ng-pristine').attr('readonly','readonly');
        		            $('#applyCoupan').html('REMOVE');
        		            $('#applyCoupan').addClass("removecoupan");
            		        $('#voucherapplied').addClass('ng-hide');
        		            $('#vouchDiscCKO').removeClass('ng-hide');
        		            $('#evoucher_credit_amount').html(discountAmount);
        		            $('#final_total_price').html(final_total_price);
        		            $('#coupan_amount_use').val(discountAmount);
        		            $('#coupanapplyedid').val(html.coupon_apply_id);
        		            $('.btn-voucher').addClass('removecoupans').removeClass('btn-voucher');
            		  }
            		  else{
            		      $('.appled_coupan').css('display','block');
            		      $('.appled_coupan').removeClass('text-primaries').addClass('text-danger');
            		      $('.appled_coupan').html(data.msg);
            		  }
            		}
                });
            }
            else{
    		    $('.appled_coupan').css('display','block');
    		    $('.appled_coupan').removeClass('text-primaries').addClass('text-danger');
    		    $('.appled_coupan').html('Vouchers Not Available !!');
    		}
             
        })
        
        
        function applyCoupan(id){
            
            var existing_cart_amount    = $('#existing_cart_amount').val();
            var remaing_cart_amount    = $('#remaing_cart_amount').val();
            var coupanCode              = $('#coupan_code_'+id).html();
            var final_shipping_charges = $('#final_shipping_charges').val();
            if(id!=''){
                
                $('.coupan_error').html("");
                $('.coupan_error').css('display','none');
                $('.panel-voucher').removeClass('panel-primary').addClass('panel-default');
                $('.bb-icon').removeClass('bb-icon-radio-active').addClass('bb-icon-radio-inactive');
                //$('.bb-icon').removeClass('bb-icon-radio-inactive').addClass('bb-icon-radio-active');
                 $('#active_radio_panel_'+id).removeClass('bb-icon-radio-inactive').addClass('bb-icon-radio-active');
                $('#panel_'+id).removeClass('panel-default').addClass('panel-primary');
                $.ajax({
            		type: "post",
            		url: "{base_url}applyVoucher",
            		data: {id:id,amt:existing_cart_amount,coupanCode:coupanCode},
            		dataType: "json",
            		success: function (data) {
            		  if(data.response == 1){
            		      var html              =   data.datas;
            		      //var discountAmount    =   parseFloat(html.coupon_discount_amt).toFixed(2);
            		      var discountAmount    =   html.coupon_discount_amt;
            		      var final_total_price =   html.remainingAmount;
            		      //alert("ram-total-remain"+final_total_price+"-"+final_shipping_charges+"-"+discountAmount);
            		      
            		      if (document.getElementById('shipping_wallet').checked) {
            		           //alert("checked12"+total_amount);
            		           var total_amount  =   $('#remaing_cart_amount').val();
            		           total_amount  = total_amount  -discountAmount;
            		       }
            		       else
            		       {
            		           var total_amount  =   $('#existing_cart_amount').val();
            		           total_amount  = total_amount  -discountAmount;
            		       }
                          
                          if(final_shipping_charges>0)
                          {
                              total_amount  = parseFloat(total_amount) + parseFloat(final_shipping_charges);
                          }
                          
                          total_amount    =   parseFloat(total_amount).toFixed(2);
                          discountAmount    =   parseFloat(discountAmount).toFixed(2);
            		      
            		     // alert("ram-total-remain"+total_remain);
            		      
            		          //  existing_cart_amount = existing_cart_amount-discountAmount;
                		      //     remaing_cart_amount = remaing_cart_amount-discountAmount;
                		           
                		           
                		           //var total_remain = final_total_price+final_shipping_charges-discountAmount; 
                		           
                		          // $('#remaing_cart_amount').val(remaing_cart_amount);
                		          // $('#existing_cart_amount').val(existing_cart_amount);
            		      
                		      //if (("#shipping_wallet:checked")) {
                		      //     alert("checked"+total_amount);
                		      //     final_total_price = remaing_cart_amount -discountAmount;
                		      // }
                		      // else
                		      // {
                		      //      final_total_price = final_total_price -discountAmount;
                		      // }
            		      
            		      
            		        //$('#remaing_cart_amount').val(remaing_cart_amount-discountAmount+final_shipping_charges);
            		        
            		        $('.appled_coupan').css('display','block');
            		        $('.appled_coupan').removeClass('text-danger').addClass('text-primaries');
            		        $('.appled_coupan').html('Discount will be applied on successful payment');
            		        $('.ng-pristine').val(coupanCode);
            		        $('.ng-pristine').attr('readonly','readonly');
            		        $('#applyCoupan').html('REMOVE');
            		        $('#applyCoupan').addClass("removecoupan");
            		        $('#coupan_error_'+id).html(data.msg);
            		        $('#coupan_error_'+id).css('display','block');
            		        $('#voucherapplied').addClass('ng-hide');
            		        $('#vouchDiscCKO').removeClass('ng-hide');
            		        $('#evoucher_credit_amount').html(discountAmount);
            		        $('#final_total_price').html(total_amount);
            		        $('.existing_cart_amount').html(total_amount);
            		        $('#existing_cart_amount').val(final_total_price);
            		        $('#coupan_amount_use').val(discountAmount);
            		        $('#coupanapplyedid').val(html.coupon_apply_id);
            		        $('.btn-voucher').addClass('removecoupans').removeClass('btn-voucher');
            		        //$('#vouchers').modal('hide');
            		  }
            		  else{
            		      $('.appled_coupan').css('display','block');
            		     $('#coupan_error_'+id).html(data.msg);
            		     $('#coupan_error_'+id).css('display','block');
            		     $('.appled_coupan').removeClass('text-primaries').addClass('text-danger');
            		     $('.appled_coupan').html(data.msg);
            		  }
            		}
                });
            }
        }
        
        
        $(document).on('click','.removecoupans', function(e){
            
            var coupanCode              =   $('.ng-pristine').val();
            var coupon_apply_id         =   $('#coupanapplyedid').val();
            if(coupanCode !=''){
                 $.ajax({
            		type: "post",
            		url: "{base_url}removeCoupon",
            		data: {coupanCode:coupanCode,coupon_apply_id:coupon_apply_id},
            		dataType: "json",
            		success: function (data) {
                        
            		  if(data.response == 1){
                          var final_shipping_charges  =   $('#final_shipping_charges').val();
            		      var discountamount = $('#evoucher_credit_amount').html();
            		     // $("#shipping_wallet").checked
            		      
            		       if (document.getElementById('shipping_wallet').checked) {
            		           //alert("checked12"+total_amount);
            		           var total_amount  =   $('#remaing_cart_amount').val();
            		           var existing_cart_amount  =   $('#existing_cart_amount').val();
            		           total_amount      =   (parseFloat(total_amount)+parseFloat(final_shipping_charges)).toFixed(2);
            		           //existing_cart_amount      =   (parseFloat(existing_cart_amount) - parseFloat(discountamount)).toFixed(2);
                               
            		       }
            		       else
            		       {
            		           var total_amount1  =   $('#existing_cart_amount').val();
            		           total_amount      =   (parseFloat(total_amount1)).toFixed(2);
                               
                               existing_cart_amount11     =   (parseFloat(total_amount1)).toFixed(2);
            		           existing_cart_amount      =existing_cart_amount11;
            		       }
            		      
            		      
            		       console.log(total_amount);
            		       console.log(discountamount);

                           isCouponUsed = false;
            		      
            		      console.log(total_amount);
            		      $('.appled_coupan').css('display','block');
            		      $('#vouchDiscCKO').addClass('ng-hide');
            		      $('#voucherapplied').removeClass('ng-hide');
            		      $('#final_total_price').html(total_amount);
            		      $('.ng-pristine').val('');
            		      $('.ng-pristine').removeAttr('readonly');
            		      $('#applyCoupan').html('APPLY');
            		      $('#applyCoupan').removeClass("removecoupan");
            		      $('.removecoupans').addClass('btn-voucher').removeClass('removecoupans');
            		      $('.appled_coupan').removeClass('text-danger').addClass('text-primaries');
            		      $('.appled_coupan').html(data.msg);
            		      $('#coupan_amount_use').val(0);
            		      $('.existing_cart_amount').html(total_amount);
            		     // alert("total"+total_amount);
            		      $('#final_total_price').html(total_amount);
            		        
            		       $('#existing_cart_amount').val(existing_cart_amount);
            		       $('#evoucher_credit_amount').html("0.00");
            		      
            		      //var remaing_cart_amount =$('#remaing_cart_amount').val();
            		      //remaing_cart_amount = parseFloat(remaing_cart_amount)+parseFloat(discountamount);
            		      //alert(remaing_cart_amount);
            		      //$('#remaing_cart_amount').val(remaing_cart_amount);
            		  }
            		}
                });
                
               
            }

            if ($("#shipping_wallet").is(":checked")) {
                    $("#shipping_wallet").trigger('click')
                } 
        })
            
        $(document).ready(function(){
            $('.add_to_wishlist').click(function(){
                var product_id = $(this).attr('id');
                $.get("{base_url}addToWishlist",{ product_id:product_id},function(data){
                
                  if(data == "0"){
                      $('#das_'+product_id).css('color','black')
                  }else if(data == "1"){
                      $('#das_'+product_id).css('color','red')
                  }else if(data == '2'){
                      window.location.href = "{base_url}login";
                  }
                    
                });
                
            })
            
        });    
            
        $('.hc-nav-trigger').click(function(e){
            $('body').addClass('mmPushBody');
            $('#mobile-menu').css('left','0px');
            $('#mobile-menu').css('display','block');
            $('#mobile-menu').css('height','12589px');
            $('#mobile-menu').css('overflow','hidden');
            //$('#page').css('left', '250px');
            
        })

        function closeNav(){
            $('.mm-toggle').trigger('click');
        }
        
         $(document).on('change','#lang', function(){
                var lang = $(this).find(':selected').val();
                console.log(lang);
                $.get("{base_url}change_language",{ lang:lang},function(data){
                  if(data == "0"){
                       $.notify({
                    	message: 'Not Change Language'
                    },{
                    	type: 'error',
                    	placement: {
                    		from: "bottom",
                    		align: "right"
                    	},
                    });
                  }else if(data == "1"){
                     window.location.href = '{base_url}';
                  }
                    
                });
        });  
        
        
        $(document).ready(function(){
			// $('.mega-menu-title h3').on('mouseover', function(){
				// $('.mega-menu-category').show()
			// })
			// $('.mega-menu-title h3').on('mouseout', function(){
				// $('.mega-menu-category').hide()
			// })
			
			// $('.mega-menu-category').on('mouseover', function(){
				// $('.mega-menu-category').show()
			// })
			// $('.mega-menu-category').on('mouseout', function(){
				// $('.mega-menu-category').hide()
			// })
		})
			
        
            
        </script>
        
<?php if($this->config->item('product_setup') == 'demo'){ ?> 
<script>
$('.add-curd').click(function(e){
    e.preventDefault();
    if($('#form1').valid()){
        $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Successfully </strong>Change. (This is Demo Version so this functionality not available) </div>');
        //$('#form1')[0].reset();
    }
    else if($('#form2').valid()){
        $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Successfully </strong>Change. (This is Demo Version so this functionality not available) </div>');
    }
    else if($('#form2').valid()){
        $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Successfully </strong>Change. (This is Demo Version so this functionality not available) </div>');
    }
})
$('.edit-curd').click(function(e){
    e.preventDefault();
    if($('#form1').valid()){
        $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Successfully </strong>Update. (This is Demo Version so this functionality not available) </div>');
        //$('#form1')[0].reset();
    }
    else if($('#form2').valid()){
        $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Successfully </strong>Update. (This is Demo Version so this functionality not available) </div>');
    }
    else if($('#form2').valid()){
        $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Successfully </strong>Update. (This is Demo Version so this functionality not available) </div>');
    }
    
})


$('.delete-curd').click(function(e){
    e.preventDefault();
    if(confirm('Are you sure delete?')){
        $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Successfully </strong>Delete. (This is Demo Version so this functionality not available)</div>');
    }
    
})
</script>   
<?php } ?>        
        
        
    </body>
</html>
