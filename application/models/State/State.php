<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class State extends CI_Model
{
	var $table = "state";
	public function getRandom (){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$key = array_rand($data);
		return  $data[$key];
	}
	public function saveState ($data){
		$this->db->insert($this->table, $data);
	}
	public function getStatebyId($id){
		$this->db->select('*')->from($this->table)->where('state_id', $id);
		return $this->db->get()->result();

	}
	public function getStatebyText($text){
		$this->db->select('*')->from($this->table)->where('text', $text);
		return $this->db->get()->result();
	}
}