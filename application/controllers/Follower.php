<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';
require_once APPPATH.'enumerations/StateEnum.php';

class Follower extends API_Controller
{
	public function __construct() {
		parent::__construct();
	}
	public function getJobsByFollower(){
		
		ENABLE_AUTH('GET', false);

		$follower_id = $_GET["id"];
		if(!$follower_id){
			return HTTP_BADREQUEST(array('status' => false,"data" =>"Une erreur s'est produite."));
		}
		$jobs = $this->JobFollower->getJobsByFollowerId($follower_id);
		Http_OK($jobs);
	}
	public function checkFollower(){
		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);
		if (!$data['follower_id']) {		
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		if (!$data["job_id"]) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		$followers = $this->JobFollower->getFollowersByJobId($data['job_id']);

		foreach ($followers as $follower) {
			 if($data['follower_id'] == $follower->user_id){
				return HTTP_OK(true);
			 }
		}
		return HTTP_OK(false);
	}
	public function followJob()
	{

		ENABLE_AUTH('POST', false);

		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {		
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		if (!$data["job_id"]) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}

		try {
			$followers = $this->JobFollower->getFollowersByJobId($data['job_id']);

			foreach ($followers as $follower) {
				 if($data['follower_id'] == $follower->user_id){
					return HTTP_OK(array('status' => true,"data" => "emploie déjà suivie."));
				 }
			}

			$this->JobFollower->saveFollower($data['follower_id'], $data['job_id']);
			return HTTP_OK(array('status' => true,"data" => "Suivie avec succès."));
		} catch (Exception $e) { 
			return HTTP_INTERNAL_ERROR(array('status' => false,"data" =>"Erreur interne au serveur!"));
		}
	}
	public function unfollowJob()
	{
		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			
			return HTTP_BADREQUEST(array('status' => false,"data" =>"une erreur s'est produite."));
		}
		if (!$data["job_id"]) {
			return HTTP_BADREQUEST(array('status' => false,"data" =>"une erreur s'est produite."));
		}

		try {
			$this->JobFollower->deleteFollower($data['follower_id'], $data['job_id']);
			HTTP_OK(array('status' => true,"data" => "Désabonnement avec succès."));
		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}

	/*
	follow annonce
	*/
	public function followAnnonce()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['POST'],
			 //'requireAuthorization' => true,
		]);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			$this->api_return(['status' => false,"data" =>"suiveur invalide.",],404);exit;
		}
		if (!$data["annonce_id"]) {
			$this->api_return(['status' => false,"data" =>"annonce invalide.",],404);exit;
		}

		try {
			$this->AnnonceFollower->saveFollower($data['follower_id'], $data['annonce_id']);
			$this->api_return(['status' => true,"data" => "Suivie avec succès."],200);
		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}
	public function unfollowAnnonce()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['POST'],
			 //'requireAuthorization' => true,
		]);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			$this->api_return(['status' => false,"data" =>"suiveur ID invalide.",],404);exit;
		}
		if (!$data["annonce_id"]) {
			$this->api_return(['status' => false,"data" =>"annonce ID invalide.",],404);exit;
		}

		try {
			$this->AnnonceFollower->deleteFollower($data['follower_id'], $data['annonce_id']);
			$this->api_return(['status' => true,"data" => "Désabonnement avec succès."],200);
		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}
	/*
	follow Rencontre
	*/
	public function followRencontre()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['POST'],
			 //'requireAuthorization' => true,
		]);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			$this->api_return(['status' => false,"data" =>"suiveur invalide.",],404);exit;
		}
		if (!$data["rencontre_id"]) {
			$this->api_return(['status' => false,"data" =>"rencontre invalide.",],404);exit;
		}

		try {
			$this->RencontreFollower->saveFollower($data['follower_id'], $data['rencontre_id']);
			$this->api_return(['status' => true,"data" => "Suivie avec succès."],200);
		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}
	public function unfollowRencontre()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['POST'],
			 //'requireAuthorization' => true,
		]);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			$this->api_return(['status' => false,"data" =>"suiveur ID invalide.",],404);exit;
		}
		if (!$data["rencontre_id"]) {
			$this->api_return(['status' => false,"data" =>"rencontre ID invalide.",],404);exit;
		}

		try {
			$this->RencontreFollower->deleteFollower($data['follower_id'], $data['rencontre_id']);
			$this->api_return(['status' => true,"data" => "Désabonnement avec succès."],200);
		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}

	/*
		follow achat-vente
	*/

	public function followVente()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['POST'],
			 //'requireAuthorization' => true,
		]);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			$this->api_return(['status' => false,"data" =>"suiveur invalide.",],404);exit;
		}
		if (!$data["vente_id"]) {
			$this->api_return(['status' => false,"data" =>"vente invalide.",],404);exit;
		}

		try {
			$this->VenteFollower->saveFollower($data['follower_id'], $data['vente_id']);
			$this->api_return(['status' => true,"data" => "Suivie avec succès."],200);
		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}
	public function unfollowVente()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['POST'],
			 //'requireAuthorization' => true,
		]);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			$this->api_return(['status' => false,"data" =>"suiveur ID invalide.",],404);exit;
		}
		if (!$data["vente_id"]) {
			$this->api_return(['status' => false,"data" =>"vente ID invalide.",],404);exit;
		}

		try {
			$this->VenteFollower->deleteFollower($data['follower_id'], $data['vente_id']);
			$this->api_return(['status' => true,"data" => "Désabonnement avec succès."],200);
		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}	
}