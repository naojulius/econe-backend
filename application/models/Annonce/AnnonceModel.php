<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class AnnonceModel extends CI_Model
{
	var $table = "annonces";
	public function getAnnonceById ($id){
		$condition = array(
			'annonce_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$annonce = $this->db->get()->result_array();
		if(!$annonce){
			return null;exit;
		}

		$followers = $this->AnnonceFollower->getFollowersNumberByAnnonceId($annonce[0]['annonce_id']);
		if($followers){
			$annonce[0]['follower_number'] = $followers;
		}else{
			$annonce[0]['follower_number'] = 0;
		}
		$annonce[0]['owner'] = $this->UserModel->getUserById($annonce[0]['user_id']);
		$annonce[0]['state'] = $this->State->getStatebyId($annonce[0]['state_id']);
		$annonce[0]['category'] = $this->PicklistModel->getById($annonce[0]['category_id']);
		$annonce[0]['images'] = $this->ImageModel->getAnnonceImageByAnnonceId($annonce[0]['annonce_id']);
		unset($annonce[0]['user_id']);
		unset($annonce[0]['state_id']);
		unset($annonce[0]['category_id']);
		return $annonce;
	}
	public function getUserAnnoncesByUserId($id){
		$condition = array(
			'user_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table)->order_by('rand()');
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $annonce) {
			$annonce->owner = $this->UserModel->getUserById($annonce->user_id);
			$annonce->state = $this->State->getStatebyId($annonce->state_id);
			$annonce->follower_number = $this->AnnonceFollower->getFollowersNumberByAnnonceId($annonce->annonce_id);
			$annonce->category = $this->PicklistModel->getById($annonce->category_id);
			unset($annonce->user_id);
			unset($annonce->state_id);
			unset($annonce->category_id);
			array_push($response, $annonce);
		}
		return $response;
	}
	public function saveAnnonce($data){
		$u_id = $this->Guid->newGuid();
		$data['annonce_id'] = $u_id;
		$data['date'] = date("Y/m/d h:i:sa");
		$data['reference'] = $this->Reference->new();
		$resp = $this->db->insert($this->table, $data);
		return $u_id;
	}
	public function deleteAnnonceById($id){
		$data = array(
			'is_deleted' => true
		);
		$this->db->where('annonce_id', $id);
		$this->db->update($this->table, $data);
	}
	public function getRandomAnnonce(){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$key = array_rand($data);
		return  $data[$key];
	}
	public function getAllAnnonceDemo(){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $annonce) {
			$annonce->owner = $this->UserModel->getUserById($annonce->user_id);
			$annonce->state = $this->State->getStatebyId($annonce->state_id);
			$annonce->follower_number = $this->AnnonceFollower->getFollowersNumberByAnnonceId($annonce->annonce_id);
			$annonce->category = $this->PicklistModel->getById($annonce->category_id);
			unset($annonce->user_id);
			unset($annonce->state_id);
			unset($annonce->category_id);
			array_push($response, $annonce);
		}
		return $response;
	}

	public function getAnnonceByLimit($limit){
		$this->db->select('*')->from($this->table)->limit($limit)->order_by('rand()');
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $annonce) {
			$followers = $this->AnnonceFollower->getFollowersNumberByAnnonceId($annonce->annonce_id);
			if($followers){
				$annonce->follower_number = $followers;
			}else{
				$annonce->follower_number  = 0;
			}

			$annonce->owner = $this->UserModel->getUserById($annonce->user_id);
			$annonce->state = $this->State->getStatebyId($annonce->state_id);
			$annonce->follower_number = $this->AnnonceFollower->getFollowersNumberByAnnonceId($annonce->annonce_id);
			$annonce->category = $this->PicklistModel->getById($annonce->category_id);
			$annonce->images = $this->ImageModel->getAnnonceImageByAnnonceId($annonce->annonce_id);
			unset($annonce->user_id);
			unset($annonce->state_id);
			unset($annonce->category_id);
			array_push($response, $annonce);
		}
		return $response;
	}
}