<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $config['google']['client_id']        = '388620024448-28mkv5bq6l0cpeeioprcesgm1du53p7l.apps.googleusercontent.com';
// $config['google']['client_secret']    = '5kq-_iLxLm52oCyaKBLcxTKe';
$config['google']['redirect_uri']     = 'google_login';
$config['google']['application_name'] = 'Kart';
$config['google']['api_key']          = '';
$config['google']['scopes']           = array('email','profile');
	