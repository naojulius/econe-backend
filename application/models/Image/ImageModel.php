<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class ImageModel extends CI_Model
{
	var $table = "images";
	public function getImageById ($id){
		$condition = array(
			'image_id'=> $id,
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$image = $this->db->get()->result_array();
		if(!$image){
			return null;exit;
		}
		return $image;
	}
	public function getAnnonceImageByAnnonceId($id){
		$condition = array(
			'annonce_id'=> $id,
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$image = $this->db->get()->result_array();
		if(!$image){
			return null;exit;
		}
		return $image;
	}
	public function getVenteImageByVenteId($id){
		$condition = array(
			'vente_id'=> $id,
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$image = $this->db->get()->result_array();
		if(!$image){
			return null;exit;
		}
		return $image;
	}
	/*public function getUserJobsByUserId($id){
		$condition = array(
			'user_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $job) {
			$job->owner = $this->UserModel->getUserById($job->user_id);
			$job->state = $this->State->getStatebyId($job->state_id);
			$job->follower_number = $this->JobFollower->getFollowersNumberByJobId($job->job_id);
			$job->category = $this->PickListModel->getById($job->category_id);
			unset($job->user_id);
			unset($job->state_id);
			unset($job->category_id);
			array_push($response, $job);
		}
		return $response;
	}*/
	public function saveImage($data){
		$u_id = $this->Guid->newGuid();
		$data['image_id'] = $u_id;
		$resp = $this->db->insert($this->table, $data);
		return $resp;
	}
	// public function deleteJobById($id){
	// 	$data = array(
	// 		'is_deleted' => true
	// 	);
	// 	$this->db->where('job_id', $id);
	// 	$this->db->update($this->table, $data);
	// }
	// public function getRandomJob(){
	// 	$this->db->select('*')->from($this->table);
	// 	$data = $this->db->get()->result();
	// 	$key = array_rand($data);
	// 	return  $data[$key];
	// }
	// public function getAllJobDemo(){
	// 	$this->db->select('*')->from($this->table);
	// 	$data = $this->db->get()->result();
	// 	$response = array();
	// 	foreach ($data as $job) {
	// 		$job->owner = $this->UserModel->getUserById($job->user_id);
	// 		$job->state = $this->State->getStatebyId($job->state_id);
	// 		$job->follower_number = $this->JobFollower->getFollowersNumberByJobId($job->job_id);
	// 		$job->category = $this->PickListModel->getById($job->category_id);
	// 		unset($job->user_id);
	// 		unset($job->state_id);
	// 		unset($job->category_id);
	// 		array_push($response, $job);
	// 	}
	// 	return $response;
	// }
}