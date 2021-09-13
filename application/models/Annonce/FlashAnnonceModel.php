<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class FlashAnnonceModel extends CI_Model
{
	var $table = "flashannonces";
	public function getFlashAnnonceById ($id){
		$condition = array(
			'flashannonce_id'=> $id,
			//'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$flashannonce = $this->db->get()->result_array();
		if(!$flashannonce){
			return null;
		}

		// $followers = $this->AnnonceFollower->getFollowersNumberByAnnonceId($annonce[0]['annonce_id']);
		// if($followers){
		// 	$annonce[0]['follower_number'] = $followers;
		// }else{
		// 	$annonce[0]['follower_number'] = 0;
		// }
		// $annonce[0]['owner'] = $this->UserModel->getUserById($annonce[0]['user_id']);
		 $flashannonce[0]['state'] = $this->State->getStatebyId($flashannonce[0]['state_id']);
		// $annonce[0]['category'] = $this->PicklistModel->getById($annonce[0]['category_id']);
		//$annonce[0]['images'] = $this->ImageModel->getAnnonceImageByAnnonceId($annonce[0]['annonce_id']);
		unset($flashannonce[0]['user_id']);
		unset($flashannonce[0]['state_id']);
		unset($flashannonce[0]['category_id']);
		unset($flashannonce[0]['menu_id']);
		return $flashannonce;
	}
	// public function getUserAnnoncesByUserId($id){
	// 	$condition = array(
	// 		'user_id'=> $id,
	// 		'is_deleted'=>false
	// 	);
	// 	$this->db->where($condition)->select('*')->from($this->table);
	// 	$data = $this->db->get()->result();
	// 	$response = array();
	// 	foreach ($data as $annonce) {
	// 		$annonce->owner = $this->UserModel->getUserById($annonce->user_id);
	// 		$annonce->state = $this->State->getStatebyId($annonce->state_id);
	// 		$annonce->follower_number = $this->AnnonceFollower->getFollowersNumberByAnnonceId($annonce->annonce_id);
	// 		$annonce->category = $this->PicklistModel->getById($annonce->category_id);
	// 		unset($annonce->user_id);
	// 		unset($annonce->state_id);
	// 		unset($annonce->category_id);
	// 		array_push($response, $annonce);
	// 	}
	// 	return $response;
	// }
	public function saveFlashAnnonce($data){
		$u_id = $this->Guid->newGuid();
		$data['flashannonce_id'] = $u_id;
		$data['state_id']  = "4E91B75B-D204-7186-744F-9BCFA91FDF55";
		$data['date'] = date("Y/m/d h:i:sa");
		$data['reference'] = $this->Reference->new();
		$resp = $this->db->insert($this->table, $data);
		return $u_id;
	}
	public function deleteFlashAnnonceById($id){
		$data = array(
			'is_deleted' => true
		);
		$this->db->where('flashannonce_id', $id);
		$this->db->update($this->table, $data);
	}
	// public function getRandomAnnonce(){
	// 	$this->db->select('*')->from($this->table);
	// 	$data = $this->db->get()->result();
	// 	$key = array_rand($data);
	// 	return  $data[$key];
	// }
	// public function getAllAnnonceDemo(){
	// 	$this->db->select('*')->from($this->table);
	// 	$data = $this->db->get()->result();
	// 	$response = array();
	// 	foreach ($data as $annonce) {
	// 		$annonce->owner = $this->UserModel->getUserById($annonce->user_id);
	// 		$annonce->state = $this->State->getStatebyId($annonce->state_id);
	// 		$annonce->follower_number = $this->AnnonceFollower->getFollowersNumberByAnnonceId($annonce->annonce_id);
	// 		$annonce->category = $this->PicklistModel->getById($annonce->category_id);
	// 		unset($annonce->user_id);
	// 		unset($annonce->state_id);
	// 		unset($annonce->category_id);
	// 		array_push($response, $annonce);
	// 	}
	// 	return $response;
	// }
	public function getFLashAnnonceByLimit($limit){
		$this->db->select('title, link, image, flashannonce_id')->from($this->table)->limit($limit)->order_by('rand()')->where("is_deleted", false);
		$response = $this->db->get()->result();
		return $response;
	}
}