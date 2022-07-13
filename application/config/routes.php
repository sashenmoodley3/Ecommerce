<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'home/index';

/******** Home *************/
$route['home/(:any)'] = 'home/index';
$route['maintenance']   = 'home/maintenance'; 
$route['search_process'] = 'home/search_process';
$route['search'] = 'home/search_view_page/$i';
$route['shop'] = 'home/shop';//single_product
$route['shop/(:any)'] = 'home/shop/$1';//single_product
$route['shop_products'] = 'home/shop_products';//single_product
$route['shop_products/(:any)'] = 'home/shop_products/$1';//single_product
$route['paytm_response'] = 'home/paytm_response';

$route['my_order_tracking/(:any)'] = 'home/my_order_tracking/$1';//single_product
$route['contact_us'] = 'home/contact_us';
$route['terms_conditions'] = 'home/terms_conditions';
$route['policy'] = 'home/policy';
$route['about_us'] = 'home/about_us';
$route['forget_account_password'] = 'home/forget_account_password';
$route['voucherList'] = 'home/voucherList';
$route['applyVoucher'] = 'home/applyVoucher';
$route['removeCoupon'] = 'home/removeCoupon';

$route['mobile_verifiaction'] = 'home/mobile_verifiaction';

$route['enquiry'] = 'home/enquiry';

$route['addToWishlist'] = 'home/addToWishlist';
$route['notifyme'] = 'home/notifyme';
$route['faq'] = 'home/faq';
$route['refundpolicy'] = 'home/refundpolicy';
$route['wishlist'] = 'home/wishlist';
$route['remove_wishlist/(:any)'] = 'home/remove_wishlist/$1';
$route['compare'] = 'home/compare';
$route['product/(:any)'] = 'home/product/$1';//single_product
$route['quick_view'] = 'home/quick_view';


$route['delete_cart'] = 'home/delete_cart';//single_product
$route['add_cart'] = 'home/add_cart';//single_product
$route['add_review'] = 'home/add_review';//single_product review
$route['add_carts'] = 'home/add_carts';//single_product
$route['view_cart'] = 'home/view_cart';
$route['checkout'] = 'home/checkout';
$route['place_order'] = 'home/place_order';
$route['getordertime'] = 'home/getordertime';

$route['orderinfo'] = 'home/orderinfo';

$route['orderpaymentpaypal'] = 'home/orderpaymentpaypal';
$route['orderPayment'] = 'home/orderPayment';
$route['order_payment'] = 'home/order_payment';
$route['orderpaymentpaytm']     = 'home/orderpaymentpaytm';

$route['my_wallet'] = 'home/my_wallet';
$route['recharge_wallet'] = 'home/recharge_wallet';
$route['rechargewalletpaytm/(:any)/(:any)'] = 'home/rechargewalletpaytm/$1/$2';
$route['payment_success'] = 'home/payment_success';
$route['recharge_paytm_response'] = 'home/recharge_paytm_response';
$route['my_rewards'] = 'home/my_rewards';
$route['redeem_reward'] = 'home/redeem_reward';
$route['my_order'] = 'home/my_order';
$route['my_address'] = 'home/my_address';
$route['deleteaddres/(:any)'] = 'home/deleteaddres/$1';
$route['edit_addres/(:any)'] = 'home/edit_addres/$1';
$route['invoice/(:any)']     = 'home/invoice/$1';
$route['history/(:any)']     = 'home/history/$1';
//$route['update_profile'] = 'home/updateProfileProcess';
$route['order_tracking/(:num)'] = 'home/my_order_tracking/$1';


$route['add_address'] = 'home/add_address';

$route['my_account'] = 'home/account';//'home/my_account';
$route['account'] = 'home/account';
$route['changepass'] = 'home/changepass';

$route['signup'] = $route['registration'] =  'home/registration';
$route['signin'] = $route['login'] =  'home/login';
$route['facebook_login'] = 'home/facebook_login';
$route['google_login'] = 'home/google_login';
$route['logout'] = 'home/logout';
$route['forgot-password'] = 'home/forget_account_password';
$route['change_language'] = "home/change_language";  
$route['check_user_status'] = 'home/check_user_status';
/******** Home *************/
/*
$route['default_controller'] = 'home';
$route['(:any)/index.php'] = $route['index/(:any)'] = $route['default_controller'];
*/
$route['404_override'] = 'home/_404';
//$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;
