<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'libraries/API_Controller.php';

class Picklist extends API_Controller
{
	var $requireAuthorization = false;
	public function __construct() {
		parent::__construct();
	}
	public function new()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['POST'],
			 'requireAuthorization' => $this->requireAuthorization,
		]);
		$data = json_decode(file_get_contents('php://input'), true);
		try {
			foreach ($data as $key => $value) {
			 if (!$value) {
			  	$this->api_return(['status' => false,"data" =>"données insuffisante.",],400);exit;
			  }
			}
			$this->PicklistModel->savePickList($data);
			$this->api_return(['status' => false,"data" =>"crée avec succès.",],200);exit;
		} catch (Exception $e) {
				$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
	public function getById()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['GET'],
			 'requireAuthorization' => $this->requireAuthorization,
		]);
		$data = $_GET["id"];
		try {
			if (!$data) {
			  	$this->api_return(['status' => false,"data" =>"données insuffisante.",],400);exit;
			}
			$picklist = $this->PicklistModel->getById($data);
			if(!$picklist){
				$this->api_return(['status' => false,"data" =>"picklist introuvable.",],404);exit;
			}
			$this->api_return(['status' => false,"data" =>$picklist,],200);exit;
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
	public function deleteById(){
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['GET'],
			 'requireAuthorization' => $this->requireAuthorization,
		]);
		$data = $_GET["id"];
		try {
			if (!$data) {
			  	$this->api_return(['status' => false,"data" =>"données insuffisante.",],400);exit;
			}
			$this->PicklistModel->deleteById($data);
			$this->api_return(['status' => false,"data" =>"supprimé avec succès",],200);exit;
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
	public function getByGroupe(){
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['GET'],
			 'requireAuthorization' => $this->requireAuthorization,
		]);
		$data = $_GET["groupe"];
		try {
			if (!$data) {
			  	$this->api_return(['status' => false,"data" =>"données insuffisante.",],400);exit;
			}
			$picklist = $this->PicklistModel->getByGroupe($data);
			if(!$picklist){
				$this->api_return(['status' => false,"data" =>"picklist introuvable.",],404);exit;
			}
			$this->api_return(['status' => false,"data" =>$picklist,],200);exit;
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
}