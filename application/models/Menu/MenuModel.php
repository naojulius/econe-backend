<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MenuModel extends CI_Model
{
	var $table = "menus";
	public function getById ($id){
		$condition = array(
			'menu_id'=> $id,
			//'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$menus = $this->db->get()->result_array();
		return $menus;
	}
}