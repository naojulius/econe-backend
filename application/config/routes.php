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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['api/nao/demo'] = 'nao/demo';
$route['api/nao/test/demo'] = 'test/naotest/demo';

$route['api/user/demo'] = 'api_test/demo';
$route['api/user/login'] = 'api_test/login';
$route['api/user/view'] = 'api_test/view';


$route['api/fixture/config']  = 'databaseFixture/configure';
$route['api/job/demo'] = 'databaseFixture/getJobDemo';



$route['api/job/new']  = 'job/new'; //POST
$route['api/job/delete'] = 'job/delete'; //POST
$route['api/job/get'] = 'job/getById'; //GET BY ID
$route['api/job/user/get'] = 'job/getByOwner'; //GET USER jobs
$route['api/job/delete'] = 'job/deleteById'; //DELETE BY ID
$route['api/job/follow'] = 'follower/followJob'; //POST
$route['api/job/unfollow'] = 'follower/unfollowJob'; //POST
$route['api/job/all'] = "job/jobTable";
$route['api/job/number'] = "job/JobByLimit";
/*
    picklists
*/
$route['api/picklist/new'] = 'picklist/new';
$route['api/picklist/get'] = 'picklist/getById';
$route['api/picklist/delete'] = 'picklist/deleteById';
$route['api/picklist/get/groupe'] = 'picklist/getByGroupe';
/*
annonces
*/
$route['api/annonce/new']  = 'annonce/new'; //POST
$route['api/annonce/delete'] = 'annonce/deleteById'; //GET
$route['api/annonce/get'] = 'annonce/getById'; //GET BY ID
$route['api/annonce/user/get'] = 'annonce/getByOwner'; //GET USER jobs
$route['api/annonce/follow'] =  'follower/followAnnonce'; //POST
$route['api/annonce/unfollow'] = 'follower/unfollowAnnonce'; //POST
$route['api/annonce/all'] = "annonce/annonceTable";
$route['api/annonce/number'] = "annonce/AnnonceByLimit";
 /*
    rencontres
 */
$route['api/rencontre/new']  = 'rencontre/new'; //POST
$route['api/rencontre/delete'] = 'rencontre/deleteById'; //GET
$route['api/rencontre/get'] = 'rencontre/getById'; //GET BY ID
$route['api/rencontre/user/get'] = 'rencontre/getByOwner'; //GET USER jobs
$route['api/rencontre/follow'] =  'follower/followRencontre'; //POST
$route['api/rencontre/unfollow'] = 'follower/unfollowRencontre'; //POST
$route['api/rencontre/all'] = "rencontre/rencontreTable"; //POST
$route['api/rencontre/number'] = "rencontre/RencontreByLimit";
/*
    ventes
*/
$route['api/vente/new']  = 'vente/new'; //POST
$route['api/vente/delete'] = 'vente/deleteById'; //GET
$route['api/vente/get'] = 'vente/getById'; //GET BY ID
$route['api/vente/user/get'] = 'vente/getByOwner'; //GET USER jobs
$route['api/vente/follow'] =  'follower/followVente'; //POST
$route['api/vente/unfollow'] = 'follower/unfollowVente'; //POST
$route['api/vente/all'] = "vente/venteTable"; //POST
$route['api/vente/number'] = "vente/VenteByLimit";

/*
   authentications 
*/
$route['api/auth/login']  = 'auth/login';
$route['api/auth/registration']  = 'auth/new';
$route['api/user/get']  = 'auth/getById';


/*
   flash annonces
*/

$route['api/flashannonce/number'] = "flashAnnonce/FlashAnnonceByLimit";
