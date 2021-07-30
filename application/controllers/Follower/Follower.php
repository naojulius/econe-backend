<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';

class Follower extends API_Controller
{
	public function __construct() {
		parent::__construct();
	}
	public function followJob()
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
		if (!$data["job_id"]) {
			$this->api_return(['status' => false,"data" =>"Emploie invalide.",],404);exit;
		}

		try {
			$this->JobFollower->saveFollower($data['follower_id'], $data['job_id']);
			$this->api_return(['status' => true,"data" => "Suivie avec succès."],200);
		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}
	public function unfollowJob()
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
		if (!$data["job_id"]) {
			$this->api_return(['status' => false,"data" =>"Emploie ID invalide.",],404);exit;
		}

		try {
			$this->JobFollower->deleteFollower($data['follower_id'], $data['job_id']);
			$this->api_return(['status' => true,"data" => "Désabonnement avec succès."],200);
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