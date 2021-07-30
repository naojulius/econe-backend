<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class PicklistModel extends CI_Model
{
	var $table = "picklists";
	public function savePickList ($data){
		$data['picklist_id'] = $this->Guid->newGuid();
		$this->db->insert($this->table, $data);
	}
	public function getRandom (){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$key = array_rand($data);
		return  $data[$key];
	}
	public function getById($id){
		$condition = array(
			'picklist_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('groupe, value, picklist_id')->from($this->table);
		return $this->db->get()->result();
	}
	public function deleteById($id){
		$condition = array(
			'picklist_id'=> $id,
			'is_deleted'=>false
		);
		$data = array(
			'is_deleted'=>true
		);
		$this->db->where($condition);
		$this->db->update($this->table, $data);
	}
	public function getByGroupe($groupe){
		$condition = array(
			'groupe'=> $groupe,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('groupe, value, picklist_id')->from($this->table);
		return $this->db->get()->result();
	}
}