<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';
require_once APPPATH.'enumerations/StateEnum.php';

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
		$file_name = null;
		if (count($_FILES) > 0) {
		$imagePath = FCPATH . "documents/_uploads/users";
            foreach ($_FILES as $file) {
            	$name = $this->Files->upload($file, $imagePath);
            	$file_name = $name;
            }
        }else{
        	$file_name = "AEC303D8-7B05-79B5-6C4F-9F7A17E489E8.svg";
        }
		$data = json_decode($this->input->post("JsonBody"), true);
		$data['photo'] = $file_name;
		try {
			foreach ($data as $key => $value) {
			 if (!$value) {
			  	return HTTP_BADREQUEST(array('status' => false,"data" =>"données insuffisante."));
			  }
			}
			$rencontre_id = $this->RencontreModel->saveRencontre($data);

			$user = $this->UserModel->getUserById($data["user_id"]);
				$paymentData = array (
					"entity_type" => "Rencontre",
					"entity_id" => $rencontre_id,
					"montant" => $this->input->post("montant"),
					"name" => $user[0]->firstName . " " . $user[0]->lastName
				);
				try {
					$result = $this->Payment->process($paymentData);
					HTTP_OK(array('status' => true,"data" => $result));
				} catch (Exception $e) {
					return HTTP_BADREQUEST(array('status' => true,"data" => "Erreur interne au serveur, veuillez contacter l'administrateur."));
			}


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
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $rencontre)));
			
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
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $rencontre)));
			
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
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => "supprimé avec succès")));
			
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
	   // $this->output
			 //        ->set_content_type('application/json')
			 //        ->set_output(json_encode(array('status' => true,"data" => $output)));
	    return HTTP_OK($output);
	}

	public function RencontreByLimit(){
		ENABLE_AUTH('GET', false);
		$limit = $_GET["limit"];
		try {
			if (!$limit) {
			  	return HTTP_BADREQUEST("données insuffisante.");
			}
			$rencontres = $this->RencontreModel->getRencontreByLimit($limit);
			return HTTP_OK($rencontres);
			
		} catch (Exception $e) {
			return HTTP_BADREQUEST("Erreur interne au serveur, veuillez contacter l'administrateur.");
		}
	}
}