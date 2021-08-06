<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'libraries/API_Controller.php';

class Counts extends API_Controller
{
	var $requireAuthorization = false;
	public function __construct() {
		parent::__construct();
	}
	public function getAll(){
		$this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['GET'],
			 'requireAuthorization' => $this->requireAuthorization,
		]);
		try {

			$counted = array(
				"annonce"=>$this->db->select('*')->from('annonces')->count_all_results(),
				"job"=>$this->db->select('*')->from('jobs')->count_all_results(),
				"rencontre"=>$this->db->select('*')->from('rencontres')->count_all_results(),
				"vnete"=>$this->db->select('*')->from('ventes')->count_all_results()
			);

			$this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $counted)));
			
		} catch (Exception $e) {
		$this->api_return(['status' => false,"data" =>"Erreur interne au serveur, veuillez contacter l'administrateur.",],400);exit;
		}
	}
}