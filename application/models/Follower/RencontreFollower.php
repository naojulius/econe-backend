<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class RencontreFollower extends CI_Model
{
	var $table = "rencontre_followers";
	public function saveFollower($user_id, $rencontre_id){
		$data= array(
			'user_id'=>$user_id,
			'rencontre_id'=>$rencontre_id
		);
		$response = $this->db->insert($this->table, $data);
		return $response;
	}


	public function deleteFollower($user_id, $rencontre_id){
		$data= array(
			'user_id'=>$user_id,
			'rencontre_id'=>$rencontre_id
		);
		$this->db->delete($this->table, $data);
	}

	public function getFollowersByRencontreId($rencontre_id){ 
		$data= array(
			'rencontre_id'=>$rencontre_id,
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
	public function getFollowersNumberByRencontreId($rencontre_id){
		$data= array(
			'rencontre_id'=>$rencontre_id,
		);
		$this->db->where($data)->select('*')->from($this->table);
		return  $this->db->count_all_results(); 
	}
	public function getRencontresByFollowerId($id){
		$data= array(
			'user_id'=>$id,
		);
		$this->db->where($data)->select('*')->from($this->table);
		$rencontres = $this->db->get()->result(); 
		$results = [];
		foreach ($rencontres as $rencontre) {
			$rencontre = $this->RencontreModel->getRencontreById($rencontre->rencontre_id);
			array_push($results,$rencontre[0]);
		}
		return $results;
	}
}