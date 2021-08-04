<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class UserModel extends CI_Model
{
	var $table = "users";
	public function getUserByUsernameAndPassword ($username, $password){
		$password = $this->TextHash->hashPass($password);
		$condition = array(
			"username"=>$username,
			"password"=>$password,
		);
		$this->db->where('username', $username)->select('*')->from($this->table);
		return $this->db->get()->result();
	}
	public function getUserById($id){
		$this->db->where('user_id', $id)->select('user_id, username, email, photo, firstName, lastName, nationality, birthDate, sexe, phone')->from($this->table);
		return $this->db->get()->result();
	}
	public function saveUser($data){
		$u_id = $this->Guid->newGuid();
		$data['user_id'] = $u_id;
		$data['password'] = $this->TextHash->hashPass($data['password']);
		if($this->db->insert($this->table, $data)){
            $this->db->insert('user_status', array('user_id'=>$u_id));
            return $data;
        }
	}
	public function getRandomUser(){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$key = array_rand($data);
		return  $data[$key];
	}
	public function getUserStatusByUSerId($id){
		$condition = array(
			'user_id'=>$id
		);
		return $this->db->select('*')->from('user_status')->where($condition)->get()->result_array()[0];
	}

	public function getAllUser(){
		$this->db->select('username, user_id, photo, firstName, lastName, nationality, birthDate, sexe, phone, nationality')->from($this->table);
		$data = $this->db->get()->result();

		$response = array();
		foreach ($data as $user) {
			$user->status = $this->UserModel->getUserStatusByUSerId($user->user_id);
			array_push($response, $user);
		}
		return $response;
	}
}