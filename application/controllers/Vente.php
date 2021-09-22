<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';
require_once APPPATH.'enumerations/StateEnum.php';

class Vente extends API_Controller
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
	        $vente_id = $this->VenteModel->saveVente($data);

			$file_name = null;
			if (count($_FILES) > 0) {
			$imagePath = FCPATH . "documents/_uploads/images";
	            foreach ($_FILES as $file) {
	            	$files_ = $this->Files->upload($file, $imagePath);
	            	$array_image = array(
	            		"value"=> $files_[0],
	            		"vente_id"=> $vente_id,
	            	);
	            	$this->ImageModel->saveImage($array_image);
	            }
	        }

	        $user = $this->UserModel->getUserById($data["user_id"]);
			
			$paymentData = array (
				"entity_type" => "Vente",
				"entity_id" => $vente_id,
				"montant" => $this->input->post("montant"),
				"name" => $user[0]->firstName . " " . $user[0]->lastName
			);
			try {
				$result = $this->Payment->process($paymentData);
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(array('status' => true,"data" => $result)));
			} catch (Exception $e) {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(array('status' => false,"data" => $e->getMessage())));
			}



			// $this->output
			//         ->set_content_type('application/json')
			//         ->set_output(json_encode(array('status' => true,"data" => "créea avec succès")));
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
			$ventes = $this->VenteModel->getVenteById($data);
			if(!$ventes){
				$this->api_return(['status' => false,"data" =>"annonce introuvable.",],404);exit;
			}
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $ventes)));
			
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
			$ventes = $this->VenteModel->getUserVentesByUserId($data);
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $ventes)));
			
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
			$this->VenteModel->deleteVenteById($data);
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => "supprimé avec succès")));
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}

	public function venteTable(){
		$fetch_data = $this->VenteTable->make_datatables(); 
	    $data = array();
	    foreach($fetch_data as $row){
	      $sub_array = $this->VenteModel->getVenteById($row->vente_id)[0];
	      $data[] = $sub_array;    
	    }
	    $output = array(
	      "draw" => intval($_POST["draw"]),
	      "recordsTotal" => $this->VenteTable->get_all_data(),
	      "recordsFiltered" => $this->VenteTable->get_filtered_data(),
	      "data" => $data    
	    );    
	    // $this->output
			  //       ->set_content_type('application/json')
			  //       ->set_output(json_encode(array('status' => true,"data" => $output)));
	    return HTTP_OK($output);
	}

	public function VenteByLimit(){
		ENABLE_AUTH('GET', false);
		$limit = $_GET["limit"];
		try {
			if (!$limit) {
			  	return HTTP_BADREQUEST("donées insuffisante");
			}
			$response = $this->VenteModel->getVenteByLimit($limit);
			return HTTP_OK($response);
			
		} catch (Exception $e) {
			return HTTP_BADREQUEST("Erreur interne au serveur, veuillez contacter l'administrateur.");
		}
	}
}