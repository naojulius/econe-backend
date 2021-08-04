<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class UserTable extends CI_Model
{
	var $table = "users";
	var $select_column = array("*");
	var $order_column = array(null, null, null, null,null , null);
	function make_query(){
		$this->db->select($this->select_column)->order_by('rand()');
		$this->db->from($this->table);
		if(isset($_POST["search"]["value"])){
			$this->db->like('username', $_POST["search"]["value"]);
			$this->db->or_like('firstName', $_POST["search"]["value"]);

		}
		if(isset($_POST["order"])){
			$this->db->order_by($this->order_column[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}else{
			$this->db->order_by('user_id', 'DESC');
		}
		if(isset($_POST["filter_category"]["name"])){
			$this->db->like('username', $_POST["filter_category"]["name"]);
			$this->db->or_like('firstName', $_POST["search"]["value"]);
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








