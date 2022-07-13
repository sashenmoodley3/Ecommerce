<?php $pageStr  =   explode('/',$_SERVER['REQUEST_URI']);
$pageName       =   $pageStr[2];
//echo $pageName; exit;

$seoData        =   $this->db->query("SELECT * FROM seo_setting")->row(); //rint_r($seoData); exit;
$canonicalurl   =   (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$tagline        =   $this->config->item('tagline');
$tagline        =   $this->config->item('name').' : '.$tagline;
$title          =   $seoData->title;
$description    =   !empty($seoData->description) ? $seoData->description :'Buy Products online at '.$this->config->item('name').' And Get Them Delivered At Your Doorstep. Best Quality Always Ensured';
$image          =   $this->config->item('base_url').$this->config->item('images_url')."company/".''.$this->config->item('logo');

$keywords       =   $seoData->keywords;
$amp            =   $seoData->amp;
$microformats   =   $seoData->microformats;



if($pageName == 'product' && $pageStr[2] !='view_cart'){
    $getProduct             = $getProduct[0];
    //print_r($getProduct); exit;
    $product_id             = $getProduct['product_id'];
    $product_name           = $getProduct['product_name']; 
    $tagline                = $product_name." : Buy ".$product_name." Online @ Best Price | ".$this->config->item('name')." - Daily Discounts Daily Savings -".$this->config->item('name');  
    $pro1                   = explode(',',$getProduct['product_image']);
    $image                  = $product_img_url. $pro1[0];
    $product_type           = $getProduct['product_type'];
    $product_call           = $getProduct['product_call'];
    $product_slug           = $getProduct['product_slug'];
    $category_title         = $getProduct['title'];
    $category_slug          = $getProduct['slug'];
    $description            = strip_tags($getProduct['product_description']);
    $text                   = $product_name.', '.$getProduct['unit_value'].' '.$getProduct['unit']; 
    $productUrl             = urlencode($this->config->item('base_url')."product/". $product_slug);
    $title                  = $text.' Online At Best Price - '.$this->config->item('name');  
}

?>
<head>
    <!-- Basic page needs -->
    <meta charset="utf-8">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
	<title><?=$tagline;?></title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="<?=$description?>">
    <meta name="keywords" content="<?=$keywords?>"/>
    <!-- Mobile specific metas  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta http-equiv="Accept-CH" content="DPR, Width, Viewport-Width">
    <meta data-react-helmet="true" property="og:url" content="<?=$canonicalurl?>"/>
    <meta data-react-helmet="true" property="og:type" content="website"/>
    <meta data-react-helmet="true" property="og:title" content="<?=$title?>"/>
    <meta data-react-helmet="true" property="og:description" content="<?=$description?>"/>
    <meta data-react-helmet="true" property="og:image" content="<?=$image?>"/>
    <meta data-react-helmet="true" name="twitter:card" content="summary_large_image"/>
    <link data-react-helmet="true" rel="canonical" href="<?=$canonicalurl?>"/>
    <link rel="apple-touch-icon" href="<?=array_search("_favicon",array_column($web_setting, 'key','value'));?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="<?=$title?> PWA">
    <meta name="theme-color" content="#FFFFFF"/>
    <link rel='manifest' href='manifest.json'>
    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';
        const el = document.createElement('pwa-update');
        document.body.appendChild(el);
    </script>
    <script src="<?=base_url()?>/pwabuilder-sw-register.js"></script>
    <script src="<?=base_url()?>/pwabuilder-sw.js"></script>
    <!-- Favicon  -->
    <link rel="shortcut icon" type="image/x-icon" href="<?=array_search("_favicon",array_column($web_setting, 'key','value'));?>">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Style -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/style.css">
    <link rel="stylesheet" media="screen, projection" href="<?=base_url()?>/assets/css/drift-basic.css">
    <link rel="stylesheet" media="screen, projection" href="<?=base_url()?>/assets/css/addtohomescreen.css">
    <script type="module" src="https://cdn.jsdelivr.net/npm/@pwabuilder/pwainstall@latest/dist/pwa-install.min.js"></script>
    <!-- AMP Code Start-->
    <?=$amp?>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <!-- AMP Code Finish--> 
    <!-- Micro Data Start-->
    <?=$microformats?>
    <!-- Micro Data Finish-
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]--> 
    <style>
        footer{
            background : <?=$this->config->item('footer')?>;
            border-top: 1px solid <?=$this->config->item('footer_border')?>;
        }
        footer .footer-links ul li a, footer p, .email .fa-envelope:before, .phone .fa-phone:before, .address .fa-map-marker:before{
            color :<?=$this->config->item('footer_text_color')?> !important;
        }
        .mini-cart .basket a .fa-shopping-basket:before, .product-item .item-inner .item-info .add-to-cart, .product-item .item-inner .item-info .add-to-carts, .button-primary,  .product-item .item-inner .item-info .add-to-cartss,  .product-item .item-inner .item-info .add-to-cartsss, .mega-menu-title, .mega-menu-title h3:after
        {
            background : <?=$this->config->item('button_colors')?>;
            color:<?=$this->config->item('button_text_color')?>;
        }
        .mini-cart .basket a:hover .fa-shopping-basket:before, .product-item .item-inner .item-info .add-to-cart:hover, .product-item .item-inner .item-info .add-to-carts:hover, .button-primary:hover, #search button:hover, .product-item .item-inner .item-info .add-to-cartss:hover, .product-item .item-inner .item-info .add-to-cartsss:hover
        {
            background : <?=$this->config->item('button_hover_colors')?>;
            color:<?=$this->config->item('button_hover_text_colors')?>;
        }
        .footer-coppyright, .coppyright, .coppyright a{
                /* border-top: 1px solid <?=$this->config->item('footer_coppyright')?>; */
                background-color: <?=$this->config->item('footer_coppyright')?>;
                color:<?=$this->config->item('footer')?>;
        }
       .mini-cart .basket a, .product-item .item-inner .item-info .item-title a:hover, .special-price .price, .save-prices{
            color:<?=$this->config->item('text_hover_color')?> !important;
        }
        nav, .item-price select, footer{
            border-color: <?=$this->config->item('text_hover_color')?> !important;
        }
        footer h3{
            color: <?=$this->config->item('footer_text_color')?> !important;
        }
         .addtohome{
            float: left;
            position: relative;
            top: 9px;
            background: #333;
            cursor: pointer;
            padding: 0px;
            margin: 0px;
            border: 1px solid;
            left: 15%;
            border-right: 1px solid;
        }
        @media only screen and (max-width: 600px) {
           .addtohome{
               top: 21px;
               left:10%;
           }
        }
        
        
/*        rating and review css for single product*/
        .txt-center {
          text-align: center;
        }
        .hide {
          display: none;
        }

        .clear {
          float: none;
          clear: both;
        }

        .ratingg {
            width: 240px;
            unicode-bidi: bidi-override;
            margin-top: 10px;
            direction: rtl;
            text-align: left;
            position: relative;
        }

        .ratingg > label {
            float: right;
            display: inline;
            padding: 0;
            margin: 0;
            position: relative;
            width: 1.1em;
            cursor: pointer;
            color: #000;
        }

        .ratingg > label:hover,
        .ratingg > label:hover ~ label,
        .ratingg > input.radio-btn:checked ~ label {
            color: transparent;
        }

        .ratingg > label:hover:before,
        .ratingg > label:hover ~ label:before,
        .ratingg > input.radio-btn:checked ~ label:before,
        .ratingg > input.radio-btn:checked ~ label:before {
            content: "\2605";
            position: absolute;
            left: 0;
            color: #FFD700;
        }
    </style>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <?php if(!empty($this->config->item('facebook_pixel'))){ ?>
     <!-- Facebook Pixel Code -->
        <script>
              !function(f,b,e,v,n,t,s)
              {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
              n.callMethod.apply(n,arguments):n.queue.push(arguments)};
              if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
              n.queue=[];t=b.createElement(e);t.async=!0;
              t.src=v;s=b.getElementsByTagName(e)[0];
              s.parentNode.insertBefore(t,s)}(window, document,'script',
              'https://connect.facebook.net/en_US/fbevents.js');
              fbq('init', '<?=$this->config->item('facebook_pixel');?>');
              fbq('track', 'PageView');
        </script>
        <noscript>
          <img height="1" width="1" style="display:none" 
               src="https://www.facebook.com/tr?id=<?=$this->config->item('facebook_pixel');?>&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    <?php } ?>
    <!-- Google Tag Manager -->
    <?php if(!empty($this->config->item('tag_manager'))){ ?>
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','<?=$this->config->item('tag_manager');?>');
        </script>
    <?php } ?>
    <!-- End Google Tag Manager -->
</head>