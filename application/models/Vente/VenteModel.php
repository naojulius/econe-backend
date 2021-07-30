<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class VenteModel extends CI_Model
{
	var $table = "ventes";
	public function getVenteById ($id){
		$condition = array(
			'vente_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$vente = $this->db->get()->result_array();
		if(!$vente){
			return null;exit;
		}

		$followers = $this->VenteFollower->getFollowersNumberByVenteId($vente[0]['vente_id']); 
		if($followers){
			$vente[0]['follower_number'] = $followers;
		}else{
			$vente[0]['follower_number'] = 0;
		}
		$vente[0]['owner'] = $this->UserModel->getUserById($vente[0]['user_id']);
		$vente[0]['state'] = $this->State->getStatebyId($vente[0]['state_id']);
		$vente[0]['category'] = $this->PicklistModel->getById($vente[0]['category_id']);
		$vente[0]['images'] = $this->ImageModel->getVenteImageByVenteId($vente[0]['vente_id']); 
		unset($vente[0]['user_id']);
		unset($vente[0]['state_id']);
		unset($vente[0]['category_id']);
		return $vente;
	}
	public function getUserVentesByUserId($id){
		$condition = array( 
			'user_id'=> $id,
			'is_deleted'=>false
		);
		$this->db->where($condition)->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $vente) {
			$vente->owner = $this->UserModel->getUserById($vente->user_id);
			$vente->state = $this->State->getStatebyId($vente->state_id);
			$vente->follower_number = $this->VenteFollower->getFollowersNumberByVenteId($vente->vente_id); 
			$vente->category = $this->PicklistModel->getById($vente->category_id);
			unset($vente->user_id);
			unset($vente->state_id);
			unset($vente->category_id);
			array_push($response, $vente);
		}
		return $response;
	}
	public function saveVente($data){
		$u_id = $this->Guid->newGuid();
		$data['vente_id'] = $u_id;
		$data['date'] = date("Y/m/d h:i:sa");
		$data['reference'] = $this->Reference->new();
		$resp = $this->db->insert($this->table, $data);
		return $u_id;
	}
	public function deleteVenteById($id){
		$data = array(
			'is_deleted' => true
		);
		$this->db->where('vente_id', $id);
		$this->db->update($this->table, $data);
	}
	public function getRandomVente(){
		$this->db->select('*')->from($this->table);
		$data = $this->db->get()->result();
		$key = array_rand($data);
		return  $data[$key];
	}
	public function getVenteByLimit($limit){
		$this->db->select('*')->from($this->table)->limit($limit);
		$data = $this->db->get()->result();
		$response = array();
		foreach ($data as $vente) {
			$followers = $this->VenteFollower->getFollowersNumberByVenteId($vente->vente_id);
			if($followers){
				$vente->follower_number = $followers;
			}else{
				$vente->follower_number  = 0;
			}

			$vente->owner = $this->UserModel->getUserById($vente->user_id);
			$vente->state = $this->State->getStatebyId($vente->state_id);
			$vente->follower_number = $this->VenteFollower->getFollowersNumberByVenteId($vente->vente_id);
			$vente->category = $this->PicklistModel->getById($vente->category_id);
			$vente->images = $this->ImageModel->getVenteImageByVenteId($vente->vente_id);
			unset($vente->user_id);
			unset($vente->state_id);
			unset($vente->category_id);
			array_push($response, $vente);
		}
		return $response;
	}
}