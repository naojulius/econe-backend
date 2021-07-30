<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class VenteFollower extends CI_Model
{
	var $table = "vente_followers";
	public function saveFollower($user_id, $vente_id){
		$data= array(
			'user_id'=>$user_id,
			'vente_id'=>$vente_id
		);
		$response = $this->db->insert($this->table, $data);
		return $response;
	}


	public function deleteFollower($user_id, $vente_id){
		$data= array(
			'user_id'=>$user_id,
			'vente_id'=>$vente_id
		);
		$this->db->delete($this->table, $data);
	}

	public function getFollowersByVenteId($vente_id){
		$data= array(
			'vente_id'=>$vente_id,
		);
		$this->db->where($data)->select('*')->from($this->table);
		return $this->db->get()->result();
	}
	public function getFollowersByUserId($user_id){
		$data= array(
			'user_id'=>$user_id,
		);
		$this->db->where($data)->select('*')->from($this->table);
		return $this->db->get()->result();
	}
	public function getFollowersNumberByVenteId($vente_id){
		$data= array(
			'vente_id'=>$vente_id,
		);
		$this->db->where($data)->select('*')->from($this->table);
		return  $this->db->count_all_results(); 
	}
}