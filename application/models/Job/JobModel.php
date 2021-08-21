<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class JobModel extends CI_Model
{
	var $table = "jobs";
	public function getJobById ($id){
		$condition = array(
			'job_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$job = $this->db->get()->result_array();
		if(!$job){
			return null;exit;
		}

		$followers = $this->JobFollower->getFollowersNumberByJobId($job[0]['job_id']);
		if($followers){
			$job[0]['follower_number'] = $followers;
		}else{
			$job[0]['follower_number'] = 0;
		}
		$job[0]['owner'] = $this->UserModel->getUserById($job[0]['user_id']);
		$job[0]['state'] = $this->State->getStatebyId($job[0]['state_id']);
		$job[0]['category'] = $this->PicklistModel->getById($job[0]['menu_id']);
		unset($job[0]['user_id']);
		unset($job[0]['state_id']);
		unset($job[0]['menu_id']);
		return $job;
	}
	public function getUserJobsByUserId($id){
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
			$job->category = $this->PicklistModel->getById($job->menu_id);
			unset($job->user_id);
			unset($job->state_id);
			unset($job->menu_id);
			array_push($response, $job);
		}
		return $response;
	}
	public function saveJob($data){
		$u_id = $this->Guid->newGuid();
		$data['job_id'] = $u_id;
		$data['date'] = date("Y/m/d h:i:sa");
		$data['state_id'] = "4E91B75B-D204-7186-744F-9BCFA91FDF55";
		$data['menu_id']  = "102S15BC-8MK6-0NVF-E9DF-9E72N75D7613";
		$data['reference'] = $this->Reference->new();
		unset($data['montant']);
		$resp = $this->db->insert($this->table, $data);
		return $u_id;
	}
	public function deleteJobById($id){
		$data = array(
			'is_deleted' => true
		);
		$this->db->where('job_id', $id);
		$this->db->update($this->table, $data);
	}
	public function getRandomJob(){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$key = array_rand($data);
		return  $data[$key];
	}
	public function getAllJobDemo(){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $job) {
			$job->owner = $this->UserModel->getUserById($job->user_id);
			$job->state = $this->State->getStatebyId($job->state_id);
			$job->follower_number = $this->JobFollower->getFollowersNumberByJobId($job->job_id);
			$job->category = $this->PicklistModel->getById($job->menu_id);
			unset($job->user_id);
			unset($job->state_id);
			unset($job->menu_id);
			array_push($response, $job);
		}
		return $response;
	}
	public function getJobByLimit($limit){
		$this->db->select('*')->from($this->table)->limit($limit);
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $job) {
			$job->owner = $this->UserModel->getUserById($job->user_id);
			$job->state = $this->State->getStatebyId($job->state_id);
			$job->follower_number = $this->JobFollower->getFollowersNumberByJobId($job->job_id);
			$job->category = $this->PicklistModel->getById($job->menu_id);
			unset($job->user_id);
			unset($job->state_id);
			unset($job->menu_id);
			array_push($response, $job);
		}
		return $response;
	}

	/**
	 * Mettre à jour un job pour avoir un nouveau statut
	 */
	public function updateAnnonceState($id, $statusText)
	{
		if ($statusText === "PAYED_NOT_EXPIRED") {
			$statusId = '5D7E4A1C-5EFE-CE4D-4FE3-C273F52FBA26';
		} else if ($statusText === "PAYED_EXPIRED") {
			$statusId = "962A9106-4EEF-51C9-EEA8-B3D32018CC4C";
		} else if ($statusText === "EXPIRED_NOT_PAYED") {
			$statusId = "C6F4B459-6F90-D959-F2FC-890A0E63C7FE";
		}
		$data = array(
			'state_id' => $statusId
		);

		$this->db->where('job_id', $id);
		$this->db->update($this->table, $data);
	}
}