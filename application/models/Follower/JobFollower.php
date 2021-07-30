<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class JobFollower extends CI_Model
{
	var $table = "job_followers";
	public function saveFollower($user_id, $job_id){
		$data= array(
			'user_id'=>$user_id,
			'job_id'=>$job_id
		);
		$response = $this->db->insert($this->table, $data);
		return $response;
	}


	public function deleteFollower($user_id, $job_id){
		$data= array(
			'user_id'=>$user_id,
			'job_id'=>$job_id
		);
		$this->db->delete($this->table, $data);
	}

	public function getFollowersByJobId($job_id){
		$data= array(
			'job_id'=>$job_id,
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
	public function getFollowersNumberByJobId($job_id){
		$data= array(
			'job_id'=>$job_id,
		);
		$this->db->where($data)->select('*')->from($this->table);
		return  $this->db->count_all_results(); 
	}
}