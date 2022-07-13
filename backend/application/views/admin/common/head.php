<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo $this->config->item('base_url').'uploads/company/'.$this->config->item('favicon') ?>" />
    <title><?php echo $this->config->item('name').' : '.$this->config->item('title');?></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!--  Social tags      -->
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
    
    
    <!-- Dynamic Css -->
<style>
    .sidebar:before, .sidebar:after, .off-canvas-sidebar:before, .off-canvas-sidebar:after{
        background: <?=$this->config->item('left_drawer')?> !important;
    }
    .sidebar .nav li > a:hover, .sidebar .nav li > a:focus, .off-canvas-sidebar .nav li > a:hover, .off-canvas-sidebar .nav li > a:focus, .sidebar .nav li > a:hover i{
        background: <?=$this->config->item('left_drawer_hover')?> !important;
        color:<?=$this->config->item('left_drawer_font_hover')?> !important;
    }
    .sidebar .nav li > a, .off-canvas-sidebar .nav li > a{
        color:<?=$this->config->item('left_drawer_font')?> !important;
    }
    .sidebar .nav li:hover > a, .sidebar .nav li.active > [data-toggle="collapse"], .off-canvas-sidebar .nav li:hover > a, .off-canvas-sidebar .nav li.active > [data-toggle="collapse"]{
        color:<?=$this->config->item('left_drawer_font_hover')?> !important;
    }
    .sidebar .nav li.active > a, .sidebar .nav li.active > a i, .off-canvas-sidebar .nav li.active > a, .off-canvas-sidebar .nav li.active > a i{
        color:<?=$this->config->item('left_drawer_active_font_color')?> !important;
        background: <?=$this->config->item('left_drawer_active')?> !important;
    }
    .sidebar .nav i, .off-canvas-sidebar .nav i{
         color:<?=$this->config->item('left_drawer_font')?> !important;
    }
    .sidebar .nav li:hover a >  i, .off-canvas-sidebar .nav li:hover a > i{
         color:<?=$this->config->item('left_drawer_font_hover')?> !important;
    }
    body{
        background-color: <?=$this->config->item('view_background')?>;
        color: <?=$this->config->item('defult_font_color')?>;
    }
    .card [data-background-color]{
        background: <?=$this->config->item('card_header_icon_background')?> !important;
        color:<?=$this->config->item('card_header_icon_color')?> !important;
    }
</style>
</head>