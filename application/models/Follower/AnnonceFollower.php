<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class AnnonceFollower extends CI_Model
{
	var $table = "annonce_followers";
	public function saveFollower($user_id, $annonce_id){
		$data= array(
			'user_id'=>$user_id,
			'annonce_id'=>$annonce_id
		);
		$response = $this->db->insert($this->table, $data);
		return $response;
	}


	public function deleteFollower($user_id, $annonce_id){
		$data= array(
			'user_id'=>$user_id,
			'annonce_id'=>$annonce_id
		);
		$this->db->delete($this->table, $data);
	}

	public function getFollowersByAnnonceId($annonce_id){
		$data= array(
			'annonce_id'=>$annonce_id,
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
	public function getFollowersNumberByAnnonceId($annonce_id){
		$data= array(
			'annonce_id'=>$annonce_id,
		);
		$this->db->where($data)->select('*')->from($this->table);
		return  $this->db->count_all_results(); 
	}
	public function getAnnoncesByFollowerId($id){
		$data= array(
			'user_id'=>$id,
		);
		$this->db->where($data)->select('*')->from($this->table);
		$responses = $this->db->get()->result(); 
		$results = [];
		foreach ($responses as $item) {
			$item = $this->AnnonceModel->getAnnonceById($item->annonce_id);
			array_push($results,$item[0]);
		}
		return $results;
	}
}