<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']    = "csv";
$route['default_controller']    = 'admin';
$route['404_override']          = 'admin/_404';
$route['translate_uri_dashes']  = FALSE;
$route['superadmin']            = 'superadmin';
$route['superdashboard']        = 'superadmin/superdashboard';
/*************** SUPERADMIN USER ROUTE ******************/
$route['userList']              =  'superadmin/userList'; 
$route['addUser']               =  'superadmin/addUser'; 
$route['editUser/(:any)']       =  'superadmin/editUser/$1'; 
$route['deactiveUser/(:any)']   =  'superadmin/deactiveUser/$1'; 
$route['activeUser/(:any)']     =  'superadmin/activeUser/$1'; 
$route['bulkUserAction']        =  'superadmin/bulkUserAction';
$route['viewVersion']           =   'superadmin/viewVersion';
$route['viewUser']              =   'superadmin/viewUser';
/*************** SUPERADMIN Version ROUTE ******************/
$route['versionfeatures']       =  'superadmin/versionfeatures'; 
$route['addVersion']            =  'superadmin/addVersion'; 
$route['editVersion/(:any)']    =  'superadmin/editVersion/$1'; 
$route['deactiveVersion/(:any)']=  'superadmin/deactiveVersion/$1'; 
$route['activeVersion/(:any)']  =  'superadmin/activeVersion/$1'; 
$route['deleteVersion/(:any)']  =  'superadmin/deleteVersion/$1'; 
$route['bulkVersionAction']     =  'superadmin/bulkVersionAction';
/*************** SUPERADMIN Video Tutorial ROUTE ******************/
$route['videotutorial']         =  'superadmin/videotutorial'; 
$route['addTutorial']           =  'superadmin/addTutorial'; 
$route['editTutorial/(:any)']   =  'superadmin/editTutorial/$1'; 
$route['deactiveTutorial/(:any)']=  'superadmin/deactiveTutorial/$1'; 
$route['activeTutorial/(:any)'] =  'superadmin/activeTutorial/$1'; 
$route['deleteTutorial/(:any)'] =  'superadmin/deleteTutorial/$1'; 
$route['bulkTutorialAction']    =  'superadmin/bulkTutorialAction';
$route['viewTutorial']          =   'superadmin/viewTutorial';
/*************** SUPERADMIN Enquiry  ROUTE ******************/
$route['enquirylist']           =  'superadmin/enquirylist'; 
$route['viewEnquiry']           =  'superadmin/viewEnquiry'; 
$route['deactiveEnquiry/(:any)']=  'superadmin/deactiveEnquiry/$1'; 
$route['activeEnquiry/(:any)']  =  'superadmin/activeEnquiry/$1'; 
$route['deleteEnquiry/(:any)']  =  'superadmin/deleteEnquiry/$1'; 
/*************** SUPERADMIN Support ROUTE ******************/
$route['support']               =  'superadmin/support'; 
$route['viewSupport']           =  'superadmin/viewSupport'; 
$route['closeSupport/(:any)']   =  'superadmin/closeSupport/$1'; 
$route['openSupport/(:any)']    =  'superadmin/openSupport/$1'; 
$route['deleteSupport/(:any)']  =  'superadmin/deleteSupport/$1'; 
$route['bulkSupportAction']     =  'superadmin/bulkSupportAction';
$route['viewSupport']          =   'superadmin/viewSupport';
/*************** SUPERADMIN Upgrade Request ROUTE ******************/
$route['upgradelist']           =  'superadmin/upgradelist'; 
$route['viewRequest']           =  'superadmin/viewRequest'; 
$route['rjectRequest/(:any)']   =  'superadmin/rjectRequest/$1'; 
$route['approveRequest/(:any)'] =  'superadmin/approveRequest/$1'; 
$route['deleteRequest/(:any)']  =  'superadmin/deleteRequest/$1'; 
$route['bulkRequestAction']     =  'superadmin/bulkRequestAction';
/*************** SUPERADMIN Plan Category ROUTE ******************/
$route['plancategory']           =  'superadmin/plancategory'; 
$route['viewCategory']           =  'superadmin/viewCategory'; 
$route['addPlanCategory']        =  'superadmin/addPlanCategory'; 
$route['editPlanCategory/(:any)']=  'superadmin/editPlanCategory/$1'; 
$route['activeCategory/(:any)']  =  'superadmin/activeCategory/$1'; 
$route['deactiveCategory/(:any)']=  'superadmin/deactiveCategory/$1'; 
$route['deleteCategory/(:any)']  =  'superadmin/deleteCategory/$1'; 
$route['bulkCategoryAction']     =  'superadmin/bulkCategoryAction';
/*************** SUPERADMIN Plan ROUTE ******************/
$route['planlist']               =  'superadmin/planlist'; 
$route['viewPlan']               =  'superadmin/viewPlan'; 
$route['addPlan']                =  'superadmin/addPlan'; 
$route['editPlan/(:any)']        =  'superadmin/editPlan/$1'; 
$route['activePlan/(:any)']      =  'superadmin/activePlan/$1'; 
$route['deactivePlan/(:any)']    =  'superadmin/deactivePlan/$1'; 
$route['deletePlan/(:any)']      =  'superadmin/deletePlan/$1'; 
$route['bulkPlanAction']         =  'superadmin/bulkPlanAction';
$route['transactions']           =  'superadmin/transactions';
















$route['admin/UpdateAdminStatus/(:any)']    =   'admin/UpdateAdminStatus/$1';
$route['admin/fetchproducts']   = 'DataTableController/fetchproducts';
$route['admin/products/(:any)/(:any)'] = 'ProcessController/ActionProductDelete/$1/$2';

$route['admin/fetchOrders']     = 'DataTableController/fetchOrders';
$route['admin/products/(:any)/(:any)'] = 'ProcessController/ActionProductDelete/$1/$2';

$route['admin/fetchRegisters']  = 'DataTableController/fetchRegisters';

$route['admin/user/(:any)/(:any)'] = 'ProcessController/ActionUserDelete/$1/$2';

$route['admin/fetchTransaction'] = 'DataTableController/fetchTransaction';
