<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'member';
$route['404_override'] = 'pages';

$route['admin/help/([a-zA-Z0-9_-]+)']		= 'admin/help/$1';
$route['admin/([a-zA-Z0-9_-]+)/(:any)']	= '$1/admin/$2';
$route['admin/(login|logout)']			= 'admin/$1';
$route['admin/([a-zA-Z0-9_-]+)']			= '$1/admin/index';

//$route['register'] = 'users/register';

//$route['user/([\w]+)']	= 'users/view/$1';
//$route['my-profile']	= 'users/index';
//$route['edit-profile']	= 'users/edit';

//$route['sitemap.xml'] = 'sitemap/xml';

$route['fadmin']			= 'admin/login';
$route['fadmin/(login|logout)']			= 'admin/$1';
$route['fadmin/([a-zA-Z0-9_-]+)']			= '$1/admin/index';
$route['fadmin/([a-zA-Z0-9_-]+)/(:any)']	= '$1/admin/$2';

 
$route['admin']			= 'member';


$route['user']			= 'user';
$route['member']		= 'member';
$route['mod_io']		= 'mod_io';
$route['hentai']		= 'hentai';

$route['user/(:any)']			= 'user/$1';
$route['member/(:any)']		= 'member/$1';
$route['mod_io/(:any)']		= 'mod_io/$1';
$route['hentai/(:any)']		= 'hentai/$1';
$route['videos/(:any)']		= 'videos/$1';

$route['([a-zA-Z0-9_-]+)']	= 'user/user_profile/$1';
$route['([a-zA-Z0-9_-]+)/(:any)']	= 'user/user_profile/$1/$2';

/* End of file routes.php */