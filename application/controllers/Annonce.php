<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';
require_once APPPATH.'enumerations/StateEnum.php';

class Annonce extends API_Controller
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
			
			if ($this->input->post("montant") == false) {
				$this->api_return(['status' => true,"data" => "donées manquante",],404);exit;
			}
			
			$data = json_decode($this->input->post("JsonBody"), true);
			$annonce_id = $this->AnnonceModel->saveAnnonce($data);

			$file_name = null;
			if (count($_FILES) > 0) {
				$imagePath = FCPATH . "documents/_uploads/images";
				foreach ($_FILES as $file) {
					$files_ = $this->Files->upload($file, $imagePath);
					$array_image = array(
						"value"=> $files_[0],
						"annonce_id"=> $annonce_id,

					);
					$this->ImageModel->saveImage($array_image);
				}
			}

			$user = $this->UserModel->getUserById($data["user_id"]);
			
			$paymentData = array (
				"entity_type" => "Annonce",
				"entity_id" => $annonce_id,
				"montant" => $this->input->post("montant"),
				"name" => $user[0]->firstName . " " . $user[0]->lastName
			);
			try {
				$result = $this->Payment->process($paymentData);
				$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => true,"data" => $result)));
			} catch (\Exception $e) {
				$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => false,"data" => $e->getMessage())));
			}

		} catch (Exception $e) {
			return HTTP_BADREQUEST(array('status' => true,"data" => "Erreur interne au serveur, veuillez contacter l'administrateur."));
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
			$followers = $this->AnnonceModel->getAnnonceById($data);
			if(!$followers){
				$this->api_return(['status' => false,"data" =>"annonce introuvable.",],404);exit;
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('status' => true,"data" => $followers)));
			
		} catch (Exception $e) {
			return HTTP_BADREQUEST(array('status' => true,"data" => "Erreur interne au serveur, veuillez contacter l'administrateur."));
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
			$jobs = $this->AnnonceModel->getUserAnnoncesByUserId($data);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('status' => true,"data" => $jobs)));
			
		} catch (Exception $e) {
			return HTTP_BADREQUEST(array('status' => true,"data" => "Erreur interne au serveur, veuillez contacter l'administrateur."));
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
			$this->AnnonceModel->deleteAnnonceById($data);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('status' => true,"data" => "supprimé")));

			
		} catch (Exception $e) {
			return HTTP_BADREQUEST(array('status' => true,"data" => "Erreur interne au serveur, veuillez contacter l'administrateur."));
		}
	}

	public function annonceTable(){
		$fetch_data = $this->AnnonceTable->make_datatables();
		$data = array();
		foreach($fetch_data as $row){
			$sub_array = $this->AnnonceModel->getAnnonceById($row->annonce_id)[0];
			$data[] = $sub_array;    
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->AnnonceTable->get_all_data(),
			"recordsFiltered" => $this->AnnonceTable->get_filtered_data(),
			"data" => $data    
		);    
		$response = array('status' => true,"data" => $output) ; 
		return HTTP_OK($response);
	}

	public function AnnonceByLimit(){
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['GET'],
			'requireAuthorization' => $this->requireAuthorization,
		]);
		$limit = $_GET["limit"];
		try {
			if (!$limit) {
				return HTTP_BADREQUEST(array('status' => true,"data" => "donées insuffisante"));
			}
			$annonces = $this->AnnonceModel->getAnnonceByLimit($limit);
			return HTTP_OK(array('status' => true,"data" => $annonces));
			
		} catch (Exception $e) {
			return HTTP_BADREQUEST(array('status' => true,"data" => "Erreur interne au serveur, veuillez contacter l'administrateur."));
		}
	}
}