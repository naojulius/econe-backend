<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';
require_once APPPATH.'enumerations/StateEnum.php';

class Auth extends API_Controller
{
	var $requireAuthorization = false;
	public function __construct() {
		parent::__construct();
	}
	public function login()
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: POST, GET");
		header("Access-Control-Allow-Headers: Authorization, Content-Type");
		$this->_apiConfig([
			'methods' => ['POST'],
		]);

		$data = json_decode(file_get_contents('php://input'), true);

		if (!$data['username']) {
			$this->api_return(['status' => false,"data" =>"nom utilisateurs vide.",],400);exit;
		}
		if (!$data["password"]) {
			$this->api_return(['status' => false,"data" =>"mot de passe vide.",],400);exit;
		}
		try {
			$user = $this->UserModel->getUserByUsernameAndPassword($data['username'], $data['password']);
			if(!$user){
				$this->api_return(['status' => false,"data" =>null,],404);exit;
			}
			$payload = [
				'user_id' => $user[0]->user_id,
				'username' => $user[0]->username,
				'role'=>$user[0]->role,
			];
		$token = $this->authorization_token->generateToken($payload);
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('status' => true,"data" => $token)));

		//$this->api_return(array('status' => true,"data" => $token,),200);

		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}


	public function new()
	{
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['POST'],
		]);

		if ($this->input->post("JsonBody") == false) {
           //$this->api_return(['status' => true,"data" => "donées manquante",],404);exit;
			$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode(array('status' => true,"data" => "données manquante")));
        }
		$file_name = null;
		if (count($_FILES) > 0) {
		$imagePath = FCPATH . "documents/_uploads/users";
            foreach ($_FILES as $file) {
            	$name = $this->Files->upload($file, $imagePath);
            	$file_name = $name[0];
            }
        }

		 $data = json_decode($this->input->post("JsonBody"), true);
		 foreach ($data as $key => $value) {
			if (!$value) {
			  	$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => "donées manquante")));
						}
		}
		try {
			$data['photo'] = $file_name;
			$user = $this->UserModel->saveUser($data);
			if(!$user){
				$this->api_return(['status' => false,"data" =>null,],404);exit;
			}
			$user_id = $user['username'];
			$payload = [
				'user_id' => $user['user_id'],
				'username' => $user['username']
			];
		$token = $this->authorization_token->generateToken($payload);
		$this->api_return(['status' => true,"data" => $token,],200);

		} catch (Exception $e) {
			$this->api_return(['status' => false,"data" =>"Erreur interne au serveur!",],500);exit;
		}
	}

	public function getById(){
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
			$followers = $this->UserModel->getUserById($data);
			if(!$followers){
				$this->api_return(['status' => false,"data" =>"utilisateurs introuvable.",],404);exit;
			}
			$this->api_return(['status' => false,"data" =>$followers,],200);exit;
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
	public function getAllUser(){
		$fetch_data = $this->UserTable->make_datatables();
	    $data = array();
	    foreach($fetch_data as $row){
	      $sub_array = $this->UserModel->getAllUser();
	      $data = $sub_array;    
	    }
	    $output = array(
	      "draw" => intval($_POST["draw"]),
	      "recordsTotal" => $this->UserTable->get_all_data(),
	      "recordsFiltered" => $this->UserTable->get_filtered_data(),
	      "data" => $data    
	    );    
	    // $this->output
			  //       ->set_content_type('application/json')
			  //       ->set_output(json_encode(array('status' => true,"data" => $output)));
	    HTTP_OK($output);
	}
}