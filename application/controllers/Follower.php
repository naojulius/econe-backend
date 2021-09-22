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

	/*
	follow job
	*/
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
					return HTTP_OK("emploi déjà suivi.");
				}
			}

			$this->JobFollower->saveFollower($data['follower_id'], $data['job_id']);
			return HTTP_OK("Suivie avec succès.");
		} catch (Exception $e) { 
			return HTTP_INTERNAL_ERROR("Erreur interne au serveur!");
		}
	}
	public function unfollowJob()
	{
		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			
			return HTTP_BADREQUEST("une erreur s'est produite.");
		}
		if (!$data["job_id"]) {
			return HTTP_BADREQUEST("une erreur s'est produite.");
		}

		try {
			$this->JobFollower->deleteFollower($data['follower_id'], $data['job_id']);
			return HTTP_OK("Désabonnement avec succès.");
		} catch (Exception $e) {
			return HTTP_INTERNAL_ERROR("Erreur interne au serveur.");
		}
	}
	public function getJobsByFollower(){
		
		ENABLE_AUTH('GET', false);

		$follower_id = $_GET["id"];
		if(!$follower_id){
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		$jobs = $this->JobFollower->getJobsByFollowerId($follower_id);
		return Http_OK($jobs);
	}

	/*
	follow annonce
	*/
	public function followAnnonce()
	{
		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		if (!$data["annonce_id"]) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}

		try {
			$followers = $this->AnnonceFollower->getFollowersByAnnonceId($data['annonce_id']);

			foreach ($followers as $follower) {
				if($data['follower_id'] == $follower->user_id){
					return HTTP_OK("Article déjà suivi.");
				}
			}
			$this->AnnonceFollower->saveFollower($data['follower_id'], $data['annonce_id']);
			return HTTP_OK("Suivie avec succès.");
		} catch (Exception $e) {
			return HTTP_INTERNAL_ERROR("Erreur interne au serveur.");
		}
	}
	public function unfollowAnnonce()
	{
		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		if (!$data["annonce_id"]) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}

		try {
			$this->AnnonceFollower->deleteFollower($data['follower_id'], $data['annonce_id']);
			return HTTP_OK("Désabonnement avec succès.");
		} catch (Exception $e) {
			return HTTP_INTERNAL_ERROR("Erreur interne au serveur.");
		}
	}
	public function getAnnonceByFollower(){
		ENABLE_AUTH('GET', false);
		$follower_id = $_GET["id"];
		if(!$follower_id){
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		$jobs = $this->AnnonceFollower->getAnnoncesByFollowerId($follower_id);
		return Http_OK($jobs);
	}
	/*
	follow Rencontre
	*/
	public function followRencontre()
	{

		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['rencontre_id']) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		if (!$data["rencontre_id"]) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}

		try {

			$followers = $this->RencontreFollower->getFollowersByRencontreId($data['rencontre_id']);

			foreach ($followers as $follower) {
				if($data['follower_id'] == $follower->user_id){
					return HTTP_OK("Coeur déjà suivie.");
				}
			}
			$this->RencontreFollower->saveFollower($data['follower_id'], $data['rencontre_id']);
			return HTTP_OK("Suivie avec succès.");
		} catch (Exception $e) {
			return HTTP_INTERNAL_ERROR("Erreur interne au serveur.");
		}
	}
	public function unfollowRencontre()
	{
		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['rencontre_id']) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		if (!$data["rencontre_id"]) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}

		try {
			$this->RencontreFollower->deleteFollower($data['follower_id'], $data['rencontre_id']);
			return HTTP_OK("Désaboné avec succès.");
		} catch (Exception $e) {
			return HTTP_INTERNAL_ERROR("Erreur interne au serveur!");
		}
	}
	public function getRencontreByFollower(){
		ENABLE_AUTH('GET', false);
		$follower_id = $_GET["id"];
		if(!$follower_id){
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		$jobs = $this->RencontreFollower->getRencontresByFollowerId($follower_id);
		return Http_OK($jobs);
	}

	/*
		follow achat-vente
	*/

	public function followVente()
	{
		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		if (!$data["vente_id"]) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}

		try {
			$followers = $this->RencontreFollower->getFollowersByRencontreId($data['vente_id']);

			foreach ($followers as $follower) {
				if($data['follower_id'] == $follower->user_id){
					return HTTP_OK("Article déjà suivie.");
				}
			}
			$this->VenteFollower->saveFollower($data['follower_id'], $data['vente_id']);
			return HTTP_OK("Suivie avec succès.");
		} catch (Exception $e) {
			return HTTP_INTERNAL_ERROR("Erreur interne au serveur.");
		}
	}
	public function unfollowVente()
	{
		ENABLE_AUTH('POST', false);
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['follower_id']) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		if (!$data["vente_id"]) {
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}

		try {
			$this->VenteFollower->deleteFollower($data['follower_id'], $data['vente_id']);
			return HTTP_OK("Désabonnement avec succès.");
		} catch (Exception $e) {
			return HTTP_INTERNAL_ERROR("Erreur interne au serveur.");
		}
	}	
	public function getVenteByFollower(){
		ENABLE_AUTH('GET', false);
		$follower_id = $_GET["id"];
		if(!$follower_id){
			return HTTP_BADREQUEST("Une erreur s'est produite.");
		}
		$items = $this->VenteFollower->getVentesByFollowerId($follower_id);
		return Http_OK($items);
	}
}