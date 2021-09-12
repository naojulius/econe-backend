<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class FlashAnnonceTable extends CI_Model
{
	var $table = "flashannonces";
	var $select_column = array("*");
	var $order_column = array(null, null, null, null,null , null);
	var $condition = array("text"=>StateEnum::PAYED_NOT_EXPIRED);
	function make_query(){
		$this->db->select($this->select_column);
		$this->db->order_by('date','DESC');
		$this->db->from($this->table);
		$this->db->join('state', 'state.state_id=flashannonces.state_id');
		//$this->db->join('menus', 'menus.menu_id=annonces.menu_id');
		//$this->db->where($this->condition);
		if($_POST["search"]["value"]){
				// $this->db->like('title', $_POST["search"]["value"]);
				// $this->db->or_like('description', $_POST["search"]["value"]);
				//$this->db->or_like('value', $_POST["search"]["value"]); 
		}
		if(isset($_POST["order"])){
			$this->db->order_by($this->order_column[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}else{
			$this->db->order_by('date', 'DESC');
		}
		if(isset($_POST["filter_category"]["name"])){
			$this->db->like('marque', $_POST["filter_category"]["name"]);
			$this->db->or_like('description', $_POST["search"]["value"]);
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
		$this->db->join('state', 'state.state_id=annonces.state_id');
		$this->db->where($this->condition);
	}
}








