<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';

class Rencontre extends API_Controller
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
			$this->RencontreModel->saveRencontre($data);
			$this->api_return(['status' => false,"data" =>"enregistrement avec succès.",],200);exit;
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
			$rencontre = $this->RencontreModel->getRencontreById($data);
			if(!$rencontre){
				$this->api_return(['status' => false,"data" =>"emploie introuvable.",],404);exit;
			}
			$this->api_return(['status' => false,"data" =>$rencontre,],200);exit;
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
	public function getByOwner(){
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
			$rencontre = $this->RencontreModel->getUserRencontresByUserId($data); 
			$this->api_return(['status' => false,"data" =>$rencontre,],200);exit;
			
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
			$this->RencontreModel->deleteRencontreById($data);
			$this->api_return(['status' => false,"data" =>"supprimé avec succès",],200);exit;
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}

	public function rencontreTable(){
		$fetch_data = $this->RencontreTable->make_datatables();
	    $data = array();
	    foreach($fetch_data as $row){
	      $sub_array = $this->RencontreModel->getRencontreById($row->rencontre_id)[0];
	      $data[] = $sub_array;    
	    }
	    $output = array(
	      "draw" => intval($_POST["draw"]),
	      "recordsTotal" => $this->RencontreTable->get_all_data(),
	      "recordsFiltered" => $this->RencontreTable->get_filtered_data(),
	      "data" => $data    
	    );    
	    $this->api_return(['status' => false,"data" =>$output,],200);exit;
	}

	public function RencontreByLimit(){
		 $this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['GET'],
			 'requireAuthorization' => $this->requireAuthorization,
		]);
		$limit = $_GET["limit"];
		try {
			if (!$limit) {
			  	$this->api_return(['status' => false,"data" =>"données insuffisante.",],400);exit;
			}
			$rencontres = $this->RencontreModel->getRencontreByLimit($limit);
			$this->api_return(['status' => false,"data" =>$rencontres,],200);exit;
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
}