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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['Client/View/(:any)'] = 'Client/View/$1';


// Router for Project
$route['Client/Project/(:any)'] = 'Client/Project/$1';
$route['Client/storeProject/(:any)'] = 'Client/storeProject/$1';
$route['Client/(:any)/editProject/(:any)'] = 'Client/editProject/$1/$2';
$route['Client/updateProject/(:any)'] = 'Client/updateProject/$1';

// Router for Gift
$route['Client/Gift/(:any)'] = 'Client/Gift/$1';
$route['Client/storeGift/(:any)'] = 'Client/storeGift/$1';
$route['Client/(:any)/editGift/(:any)'] = 'Client/editGift/$1/$2';
$route['Client/updateGift/(:any)'] = 'Client/updateGift/$1';

// Router for Complaint
$route['Client/Complaint/(:any)'] = 'Client/Complaint/$1';
$route['Client/storeComplaint/(:any)'] = 'Client/storeComplaint/$1';
$route['Client/(:any)/editComplaint/(:any)'] = 'Client/editComplaint/$1/$2';
$route['Client/updateComplaint/(:any)'] = 'Client/updateComplaint/$1';
$route['Client/(:any)/destroyComplaint/(:any)'] = 'Client/destroyComplaint/$1/$2';

// Router for File
$route['Client/File/(:any)'] = 'Client/File/$1';
$route['Client/storeFile/(:any)'] = 'Client/storeFile/$1';
$route['Client/(:any)/editFile/(:any)'] = 'Client/editFile/$1/$2';
$route['Client/updateFile/(:any)'] = 'Client/updateFile/$1';



// Router for Benefit
$route['Project/Benefit/(:any)'] = 'Project/Benefit/$1';
$route['Project/storeBenefit/(:any)'] = 'Project/storeBenefit/$1';
$route['Project/(:any)/editBenefit/(:any)'] = 'Project/editBenefit/$1/$2';
$route['Project/updateBenefit/(:any)'] = 'Project/updateBenefit/$1';

// Router for Crosseling
$route['Project/Crosseling/(:any)'] = 'Project/Crosseling/$1';
$route['Project/storeCrosseling/(:any)'] = 'Project/storeCrosseling/$1';
$route['Project/(:any)/editCrosseling/(:any)'] = 'Project/editCrosseling/$1/$2';
$route['Project/updateCrosseling/(:any)'] = 'Project/updateCrosseling/$1';

// Router Master SubMenu
$route['Setting/Menu/Submenu/(:any)'] = 'Setting/Menu/Submenu/$1';
$route['Setting/Menu/StoreSubmenu/(:any)'] = 'Setting/Menu/StoreSubmenu/$1';
$route['Setting/Menu/(:any)/EditSubmenu/(:num)'] = 'Setting/Menu/EditSubmenu/$1/$2';
$route['Setting/Menu/UpdateSubmenu/(:any)'] = 'Setting/Menu/UpdateSubmenu/$1';

// Router Master Target
$route['Setting/Target'] = 'Setting/Target';