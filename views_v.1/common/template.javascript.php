<a href="#" id="back-to-top" title="Back to top"><i class="fa fa-angle-up"></i></a> 
<!-- jquery js --> 
<script type="text/javascript" src="{base_url}assets/js/jquery.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> 
<!-- bootstrap js --> 
<script type="text/javascript" src="{base_url}assets/js/bootstrap.min.js"></script> 
<script src="{base_url}assets/js/jquery.validation/jquery.validate.min.js" type="text/javascript"></script>
<!-- Auto Search -->
<!--<script src="{base_url}assets/js/jquery.mockjax.js" type="text/javascript"></script>-->
<script type="text/javascript" src="{base_url}assets/js/bootstrap-typeahead.js"></script> 

<!-- owl.carousel.min js --> 
<script type="text/javascript" src="{base_url}assets/js/owl.carousel.min.js"></script> 

<!-- bxslider js --> 
<script type="text/javascript" src="{base_url}assets/js/jquery.bxslider.js"></script> 

<!--cloud-zoom js --> 
<script type="text/javascript" src="{base_url}assets/js/cloud-zoom.js"></script>
<!-- flexslider js --> 
<script type="text/javascript" src="{base_url}assets/js/jquery.flexslider.js"></script>
<!-- Slider Js --> 
<script type="text/javascript" src="{base_url}assets/js/revolution-slider.js"></script> 

<!-- megamenu js --> 
<script type="text/javascript" src="{base_url}assets/js/megamenu.js"></script> 
<script type="text/javascript">
    /* <![CDATA[ */
    var mega_menu = '0';

    /* ]]> */
    

</script> 

<!-- jquery.mobile-menu js --> 
<script type="text/javascript" src="{base_url}assets/js/mobile-menu.js"></script> 

<!--jquery-ui.min js --> 
<script type="text/javascript" src="{base_url}assets/js/jquery-ui.js"></script> 

<!-- main js --> 
<script type="text/javascript" src="{base_url}assets/js/main.js"></script> 

<!-- countdown js --> 
<script type="text/javascript" src="{base_url}assets/js/countdown.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.min.css" />
<script src="{base_url}assets/js/bootstrap-notify.min.js"></script>
<script src="{base_url}assets/js/min-password-strength.js"></script>
<script src="{base_url}assets/js/min-validate.js"></script>
<script src="{base_url}assets/js/Drift.js"></script>
<script>
	new Drift(document.querySelector('.drift-demo-trigger'), {
		paneContainer: document.querySelector('.detailsd'),
		inlinePane: 900,
		inlineOffsetY: -85,
		containInline: true,
		hoverBoundingBox: true
	});
</script>
<script>
$(document).ready(function() {
   $('#example').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );
    $(document).ready(function () {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var op = {
            format: "yyyy-mm-dd",
            todayHighlight: true,
            startDate: today,
            //endDate: end,
            autoclose: true
        };
        // $('#shipping_date').datepicker(op);
        // $("#shipping_date").datepicker("setDate",today);
        /*
        $('#datepicker1').datepicker(op);
        $('#datepicker1').datepicker(op);
        $('#datepicker2').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            startDate: today,
            endDate: end,
            autoclose: true
        });

        $('#datepicker1,#datepicker2').datepicker('setDate', today);
        */
    });
</script>
<!-- Revolution Slider --> 
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.tp-banner').revolution({
            delay: 9000,
            startwidth: 1920,
            startheight: 790,
            hideThumbs: 10,
            sliderType:"standard",
            dottedOverlay: "none",
            navigationType: false,
            navigationStyle: "preview1",

            hideArrowsOnMobile: "on",

            touchenabled: "on",
            onHoverStop: "on",
            spinner: "spinner4"
        });
    });
</script> 

<!-- Hot Deals Timer 1--> 
<script type="text/javascript">
    var dthen1 = new Date("12/25/16 11:59:00 PM");
    start = "08/04/15 03:02:11 AM";
    start_date = Date.parse(start);
    var dnow1 = new Date(start_date);
    if (CountStepper > 0)
        ddiff = new Date((dnow1) - (dthen1));
    else
        ddiff = new Date((dthen1) - (dnow1));
    gsecs1 = Math.floor(ddiff.valueOf() / 1000);
    var iid1 = "countbox_1";
    CountBack_slider(gsecs1, "countbox_1", 1);
</script>
<!-- lazy Loader--> 
<script type="text/javascript" src="{base_url}assets/js/jquery_lazy/jquery.lazy.min.js"></script>
<script>

    $(function () {
        var loadedElements = 0;
        $('.lazy').lazy({
            beforeLoad: function (element) {
                //console.log('image "' + (element.data('src')) + '" is about to be loaded');
            },
            afterLoad: function (element) {
                loadedElements++;
                //console.log('image "' + (element.data('src')) + '" was loaded successfully');
            },
            onError: function (element) {
                loadedElements++;
               // console.log('image "' + (element.data('src')) + '" could not be loaded');
            },
            onFinishedAll: function () {
               // console.log('finished loading ' + loadedElements + ' elements');
                //console.log('lazy instance is about to be destroyed')
            }
        });
    });

</script>



<script >

$('.big_menu ul').addClass('dropdown-menu maga_drop_down');
$("#menu-item-104").append($("#maga"));$("#menu-item-104").append($("#mob_maga"));
$(document).ready(function(){
	$('.toggle-menu').click(function(){$('.menu-right').addClass('active');});
	$('.menu-right .close-icon').click(function(){$('.menu-right').removeClass('active');
});
$(window).scroll(function(){if($(this).scrollTop()>=50){$('.down-top-up').fadeIn(200);}else{$('.down-top-up').fadeOut(200);}});$('.down-top-up').click(function(){$('body,html').animate({scrollTop:0},500);});});
function openCity(evt, sername) {
	// Declare all variables
	var i, tabcontent, tablinks;

	// Get all elements with class="tabcontent" and hide them
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	// Get all elements with class="tablinks" and remove the class "active"
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
	tablinks[i].className = tablinks[i].className.replace(" active", "");
	}

	// Show the current tab, and add an "active" class to the link that opened the tab
	document.getElementById(sername).style.display = "block";
	evt.currentTarget.className += " active";
}


</script>

<script src="{base_url}assets/js/rocket-loader.min.js"></script>