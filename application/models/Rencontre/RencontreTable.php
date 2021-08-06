<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class RencontreTable extends CI_Model
{
	var $table = "rencontres";
	var $select_column = array("*");
	var $order_column = array(null, null, null, null,null , null);
	function make_query(){
		$this->db->select($this->select_column)->order_by('rand()');

		$this->db->from($this->table);
		$this->db->join('users', 'users.user_id=rencontres.user_id');
		if(isset($_POST["search"]["value"])){
			$this->db->like('sexe', $_POST["search"]["value"]);
			$this->db->or_like('description', $_POST["search"]["value"]);
			$this->db->or_like('reference', $_POST["search"]["value"]);

		}
		if(isset($_POST["order"])){
			$this->db->order_by($this->order_column[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}else{
			$this->db->order_by('rencontre_id', 'DESC');
		}
		if(isset($_POST["filter"]["name"])){
			$this->db->like('sexe', $_POST["filter"]["name"]);
			$this->db->or_like('phone', $_POST["filter"]["name"]);
		}
	}
	function make_datatables(){
		$this->make_query();
		if($_POST["length"] != -1){
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$query = $this->db->get();
		return $query->result();
	}
	function get_filtered_data(){
		
		$this->make_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	function get_all_data(){
		$this->db->select('*');
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}








