<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// $config['facebook_app_id']              = '374037937178180';
// $config['facebook_app_secret']          = '669da0ea757e5bd342f047332f73557f';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'facebook_login';
$config['facebook_logout_redirect_url'] = 'logout';
$config['facebook_permissions']         = array('public_profile', 'email'); // 'public_profile', 'publish_actions', 'email')
$config['facebook_graph_version']       = 'v8.0'; // v2.6
$config['facebook_auth_on_load']        = TRUE; 
