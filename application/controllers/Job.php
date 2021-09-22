<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';
require_once APPPATH.'enumerations/StateEnum.php';

class Job extends API_Controller
{
	var $requireAuthorization = false; 
	public function __construct() {
		parent::__construct();
	}
	public function candidature(){
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
			
			if (count($_FILES) > 0) {
	            foreach ($_FILES as $file) {
					$allowed_extention = array("jpeg","jpg","png", "svg"); 
					if (in_array(strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)), $allowed_extention)) {
						     $files_ = $this->Files->upload($file, FCPATH . "documents/_uploads/images");
						     $data['image'] = $files_;
					}else{
							 $files_ = $this->Files->upload($file,  FCPATH . "documents/_uploads/files");
							 $data['cv'] = $files_;
					}
	            }
			}
			
			$job_id = $this->JobModel->saveJobCandidature($data);
			$user = $this->UserModel->getUserById($data["user_id"]);
			if($user){
				$fullname = $user[0]->firstName . " " . $user[0]->lastName;
			}else{
				$fullname = "e-cone.mg";
			}
			$paymentData = array (
				"entity_type" => "Job",
				"entity_id" => $job_id,
				"montant" => $this->input->post("montant"),
				"name" => $fullname,
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

		} catch (Exception $e) {
				$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
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
			$entityId = $this->JobModel->saveJob($data);

			if (empty($entityId)) {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(array('status' => false,"data" => "Une erreur est survenue.")));
			}

			$user = $this->UserModel->getUserById($data["user_id"]);

			$paymentData = array (
				"entity_type" => "Job",
				"entity_id" => $entityId,
				"montant" => 1000,
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

			// $this->output
			//         ->set_content_type('application/json')
			//         ->set_output(json_encode(array('status' => true,"data" => "enregistrement avec succès")));
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
			$followers = $this->JobModel->getJobById($data);
			if(!$followers){
				$this->api_return(['status' => false,"data" =>"emploie introuvable.",],404);exit;
			}
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $followers)));
			
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
			$jobs = $this->JobModel->getUserJobsByUserId($data);
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $jobs)));
			
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
			$this->JobModel->deleteJobById($data);
			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => "supprimé avec succès")));
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}

	public function jobTable(){
		$fetch_data = $this->JobTable->make_datatables();
	    $data = array();
	    foreach($fetch_data as $row){
	      $sub_array = $this->JobModel->getJobById($row->job_id)[0];
	      $data[] = $sub_array;    
	    }
	    $output = array(
	      "draw" => intval($_POST["draw"]),
	      "recordsTotal" => $this->JobTable->get_all_data(),
	      "recordsFiltered" => $this->JobTable->get_filtered_data(),
	      "data" => $data    
	    );    
	   // $this->output
			 //        ->set_content_type('application/json')
			 //        ->set_output(json_encode(array('status' => true,"data" => $output)));
	    return HTTP_OK($output);
	}
	public function jobCandidatureTable(){
		$fetch_data = $this->JobCandidatureTable->make_datatables();
	    $data = array();
	    foreach($fetch_data as $row){
	      $sub_array = $this->JobModel->getJobCandidatureById($row->job_candidature_id)[0];
	      $data[] = $sub_array;    
	    }
	    $output = array(
	      "draw" => intval($_POST["draw"]),
	      "recordsTotal" => $this->JobCandidatureTable->get_all_data(),
	      "recordsFiltered" => $this->JobCandidatureTable->get_filtered_data(),
	      "data" => $data    
	    );    
	   // $this->output
			 //        ->set_content_type('application/json')
			 //        ->set_output(json_encode(array('status' => true,"data" => $output)));
	    return HTTP_OK($output);
	}

	public function JobByLimit(){
	    ENABLE_AUTH('GET', false);
		$limit = $_GET["limit"];
		try {
			if (!$limit) {
			  	return HTTP_BADREQUEST("données insuffisante.");
			}
			$response = $this->JobModel->getJobByLimit($limit);
			return HTTP_OK($response);
			
		} catch (Exception $e) {
			return HTTP_BADREQUEST("Erreur interne au serveur, veuillez contacter l'administrateur.");
		}
	}
}