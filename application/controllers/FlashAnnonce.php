<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';
require_once APPPATH.'enumerations/StateEnum.php';

class FlashAnnonce extends API_Controller
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

		try {
			if ($this->input->post("JsonBody") == false) {
           		$this->api_return(['status' => true,"data" => "donées manquante",],404);exit;
	        }
	        $data = json_decode($this->input->post("JsonBody"), true);
	       

			$file_name = null;
			if (count($_FILES) > 0) {
			$imagePath = FCPATH . "documents/_uploads/images";
	            foreach ($_FILES as $file) {
	            	$name = $this->Files->upload($file, $imagePath);
	            	$file_name = $name;
	            }
	        }
	        $data['image'] = $file_name;
	        $data['user_id'] = "C978A66F-48BF-0471-A93F-36E50940B705";
	         $data['menu_id'] = "102S15BC-8MK6-0NVF-E9DF-9E72N75D7613";
	        $flashannonce_id = $this->FlashAnnonceModel->saveFlashAnnonce($data);

			$this->api_return(['status' => false,"data" =>"crée avec succès.",],200);exit;
		} catch (Exception $e) {
				$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
	// public function getById()
	// {
	// 	$this->CorsOrigin->Allow();
	// 	$this->_apiConfig([
	// 		'methods' => ['GET'],
	// 		 'requireAuthorization' => $this->requireAuthorization,
	// 	]);
	// 	$data = $_GET["id"];
	// 	try {
	// 		if (!$data) {
	// 		  	$this->api_return(['status' => false,"data" =>"données insuffisante.",],400);exit;
	// 		}
	// 		$followers = $this->AnnonceModel->getAnnonceById($data);
	// 		if(!$followers){
	// 			$this->api_return(['status' => false,"data" =>"annonce introuvable.",],404);exit;
	// 		}
	// 		$this->api_return(['status' => false,"data" =>$followers,],200);exit;
			
	// 	} catch (Exception $e) {
	// 	$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
	// 	}
	// }
	// public function getByOwner(){
	// 	$this->CorsOrigin->Allow();
	// 	$this->_apiConfig([
	// 		'methods' => ['GET'],
	// 		 'requireAuthorization' => $this->requireAuthorization,
	// 	]);
	// 	$data = $_GET["id"];
	// 	try {
	// 		if (!$data) {
	// 		  	$this->api_return(['status' => false,"data" =>"données insuffisante.",],400);exit;
	// 		}
	// 		$jobs = $this->AnnonceModel->getUserAnnoncesByUserId($data);
	// 		$this->api_return(['status' => false,"data" =>$jobs,],200);exit;
			
	// 	} catch (Exception $e) {
	// 	$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
	// 	}
	// }
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
			$this->FlashAnnonceModel->deleteFlashAnnonceById($data);
			$this->api_return(['status' => false,"data" =>"supprimé avec succès",],200);exit;
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}

	public function FlashAnnonceTable(){
		$fetch_data = $this->FlashAnnonceTable->make_datatables();
	    $data = array();
	    foreach($fetch_data as $row){
	      $sub_array = $this->FlashAnnonceModel->getFlashAnnonceById($row->flashannonce_id)[0];
	      $data[] = $sub_array;    
	    }
	    $output = array(
	      "draw" => intval($_POST["draw"]),
	      "recordsTotal" => $this->FlashAnnonceTable->get_all_data(),
	      "recordsFiltered" => $this->FlashAnnonceTable->get_filtered_data(),
	      "data" => $data    
	    );    
	    $this->api_return(['status' => false,"data" =>$output,],200);exit;
	}

	public function FlashAnnonceByLimit(){
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
			$annonces = $this->FlashAnnonceModel->getFlashAnnonceByLimit($limit);
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $annonces)));
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
}