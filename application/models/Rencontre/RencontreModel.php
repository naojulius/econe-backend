<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class RencontreModel extends CI_Model
{
	var $table = "rencontres";
	public function getRencontreById ($id){
		$condition = array(
			'rencontre_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$rencontre = $this->db->get()->result_array();
		if(!$rencontre){
			return null;exit;
		}

		$followers = $this->RencontreFollower->getFollowersNumberByRencontreId($rencontre[0]['rencontre_id']);
		if($followers){
			$rencontre[0]['follower_number'] = $followers;
		}else{
			$rencontre[0]['follower_number'] = 0;
		}
		$rencontre[0]['owner'] = $this->UserModel->getUserById($rencontre[0]['user_id']);
		$rencontre[0]['state'] = $this->State->getStatebyId($rencontre[0]['state_id']);
		$rencontre[0]['category'] = $this->PicklistModel->getById($rencontre[0]['menu_id']);
		unset($rencontre[0]['user_id']);
		unset($rencontre[0]['state_id']);
		unset($rencontre[0]['menu_id']);
		return $rencontre;
	}
	public function getUserRencontresByUserId($id){
		$condition = array(
			'user_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $rencontre) {
			$rencontre->owner = $this->UserModel->getUserById($rencontre->user_id);
			$rencontre->state = $this->State->getStatebyId($rencontre->state_id);
			$rencontre->follower_number = $this->RencontreFollower->getFollowersNumberByRencontreId($rencontre->rencontre_id);
			$rencontre->category = $this->PicklistModel->getById($rencontre->menu_id);
			unset($rencontre->user_id);
			unset($rencontre->state_id);
			unset($rencontre->menu_id);
			array_push($response, $rencontre);
		}
		return $response;
	}
	public function saveRencontre($data){
		$u_id = $this->Guid->newGuid();
		$data['rencontre_id'] = $u_id;
		$data['date'] = date("Y/m/d h:i:sa");
		$data['menu_id'] = "102S15BC-8MK6-0NVF-E9DF-9E72N75D7613";
		$data['reference'] = $this->Reference->new();
		$data['state_id'] = "4E91B75B-D204-7186-744F-9BCFA91FDF55";
		unset($data['montant']);
		$resp = $this->db->insert($this->table, $data);
		return $resp;
	}
	public function deleteRencontreById($id){
		$data = array(
			'is_deleted' => true
		);
		$this->db->where('rencontre_id', $id);
		$this->db->update($this->table, $data);
	}
	public function getRandomJob(){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$key = array_rand($data);
		return  $data[$key];
	}
	// public function getAllJobDemo(){
	// 	$this->db->select('*')->from($this->table);
	// 	$data = $this->db->get()->result();
	// 	$response = array();
	// 	foreach ($data as $job) {
	// 		$job->owner = $this->UserModel->getUserById($job->user_id);
	// 		$job->state = $this->State->getStatebyId($job->state_id);
	// 		$job->follower_number = $this->JobFollower->getFollowersNumberByJobId($job->job_id);
	// 		$job->category = $this->PicklistModel->getById($job->menu_id);
	// 		unset($job->user_id);
	// 		unset($job->state_id);
	// 		unset($job->menu_id);
	// 		array_push($response, $job);
	// 	}
	// 	return $response;
	// }

	public function getRencontreByLimit($limit){
		$this->db->select('*')->from($this->table)->limit($limit);
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $rencontre) {
			$rencontre->owner = $this->UserModel->getUserById($rencontre->user_id);
			$rencontre->state = $this->State->getStatebyId($rencontre->state_id);
			$rencontre->follower_number = $this->RencontreFollower->getFollowersNumberByRencontreId($rencontre->rencontre_id);
			$rencontre->category = $this->PicklistModel->getById($rencontre->menu_id);
			unset($rencontre->user_id);
			unset($rencontre->state_id);
			unset($rencontre->menu_id);
			array_push($response, $rencontre);
		}
		return $response;
	}
}