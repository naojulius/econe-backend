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


$route['api/fixture/config']  = 'fixtures/DatabaseFixture/configure';
$route['api/job/demo'] = 'fixtures/DatabaseFixture/getJobDemo';



$route['api/job/new']  = 'Job/Job/new'; //POST
$route['api/job/delete'] = 'Job/Job/delete'; //POST
$route['api/job/get'] = 'Job/Job/getById'; //GET BY ID
$route['api/job/user/get'] = 'Job/Job/getByOwner'; //GET USER jobs
$route['api/job/delete'] = 'Job/Job/deleteById'; //DELETE BY ID
$route['api/job/follow'] = 'Follower/Follower/followJob'; //POST
$route['api/job/unfollow'] = 'Follower/Follower/unfollowJob'; //POST
$route['api/job/all'] = "Job/job/jobTable";
$route['api/job/number'] = "Job/job/JobByLimit";
/*
    picklists
*/
$route['api/picklist/new'] = 'Picklist/Picklist/new';
$route['api/picklist/get'] = 'Picklist/Picklist/getById';
$route['api/picklist/delete'] = 'Picklist/Picklist/deleteById';
$route['api/picklist/get/groupe'] = 'Picklist/Picklist/getByGroupe';
/*
annonces
*/
$route['api/annonce/new']  = 'Annonce/Annonce/new'; //POST
$route['api/annonce/delete'] = 'Annonce/Annonce/deleteById'; //GET
$route['api/annonce/get'] = 'Annonce/Annonce/getById'; //GET BY ID
$route['api/annonce/user/get'] = 'Annonce/Annonce/getByOwner'; //GET USER jobs
$route['api/annonce/follow'] =  'Follower/Follower/followAnnonce'; //POST
$route['api/annonce/unfollow'] = 'Follower/Follower/unfollowAnnonce'; //POST
$route['api/annonce/all'] = "Annonce/Annonce/annonceTable";
$route['api/annonce/number'] = "Annonce/Annonce/AnnonceByLimit";
 /*
    rencontres
 */
$route['api/rencontre/new']  = 'Rencontre/Rencontre/new'; //POST
$route['api/rencontre/delete'] = 'Rencontre/Rencontre/deleteById'; //GET
$route['api/rencontre/get'] = 'Rencontre/Rencontre/getById'; //GET BY ID
$route['api/rencontre/user/get'] = 'Rencontre/Rencontre/getByOwner'; //GET USER jobs
$route['api/rencontre/follow'] =  'Follower/Follower/followRencontre'; //POST
$route['api/rencontre/unfollow'] = 'Follower/Follower/unfollowRencontre'; //POST
$route['api/rencontre/all'] = "Rencontre/Rencontre/rencontreTable"; //POST
$route['api/rencontre/number'] = "Rencontre/Rencontre/RencontreByLimit";
/*
    ventes
*/
$route['api/vente/new']  = 'Vente/Vente/new'; //POST
$route['api/vente/delete'] = 'Vente/Vente/deleteById'; //GET
$route['api/vente/get'] = 'Vente/Vente/getById'; //GET BY ID
$route['api/vente/user/get'] = 'Vente/Vente/getByOwner'; //GET USER jobs
$route['api/vente/follow'] =  'Follower/Follower/followVente'; //POST
$route['api/vente/unfollow'] = 'Follower/Follower/unfollowVente'; //POST
$route['api/vente/all'] = "Vente/Vente/venteTable"; //POST
$route['api/vente/number'] = "Vente/Vente/VenteByLimit";

/*
   authentications 
*/
$route['api/auth/login']  = 'User/Auth/login';
$route['api/auth/registration']  = 'User/Auth/new';
$route['api/user/get']  = 'User/Auth/getById';


/*
   flash annonces
*/

$route['api/flashannonce/number'] = "Annonce/FlashAnnonce/FlashAnnonceByLimit";
