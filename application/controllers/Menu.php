<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';

class Menu extends API_Controller
{
	var $requireAuthorization = false;
	var $table = "menus";
	public function __construct() {
		parent::__construct();
	}

	public function getByKey(){
		$this->_apiConfig([
			'methods' => ['GET'],
			 'requireAuthorization' => $this->requireAuthorization,
		]);
		$data = $_GET["key"];
		if(!$data){

		}
		$condition = array(
			'key'=>$data,
			'level'=>1,
		);

		$this->db->select('*')->from($this->table)->where($condition);
		$menus = $this->db->get()->result_array();
		$menus[0]['childs'] = array();
		foreach ($menus as $menu) {		
		$resp = $this->db->select('*')->from($this->table)->where(array('key'=>$data,'level'=>$menu['level'] + 1))->get()->result_array();
			foreach ($resp as $key=> $sub) {

				if(is_numeric($key)){	
					$subvalue = preg_replace('/[^a-zA-Z0-9_ -]/s', '', strtoupper(str_replace(' ', '', $sub['value'])));
					 $submenu  = $this->db->select('*')->from($this->table)->where(array('key'=> $subvalue  ,'level'=>$sub['level'] + 1))->get()->result_array();
					 $resp[$key]['sub_childs'] = $submenu;
				}
			}

			$menus = $resp;
		}
		$output = array(
			'status' => true,"data" => $menus
		);
		$this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
	}
	public function getByGroupe(){
			$this->_apiConfig([
				'methods' => ['GET'],
				 'requireAuthorization' => $this->requireAuthorization,
			]);
			$data = $_GET["key"];
			if(!$data){

			}
			$condition = array(
				'key'=>$data,
				'level'=>3,
			);
			$this->db->select('*')->from($this->table)->where($condition);
			$menus = $this->db->get()->result_array();
			$output = array(
				'status' => true,"data" => $menus
			);
			$this->output
	                    ->set_content_type('application/json')
	                    ->set_output(json_encode($output));

	}
}