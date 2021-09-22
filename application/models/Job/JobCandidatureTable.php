<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class JobCandidatureTable extends CI_Model
{
	var $table = "job_candidatures";
	var $select_column = array("*");
	var $order_column = array(null, null, null, null,null , null);
	var $condition = array("text"=>StateEnum::PAYED_NOT_EXPIRED);
	function make_query(){
		$this->db->select($this->select_column);
		// ->order_by('rand()')
		$this->db->join('state', 'state.state_id=job_candidatures.state_id');
		$this->db->where($this->condition);
		$this->db->from($this->table);
		if($_POST["search"]["value"]){
			$this->db->like('wantedPost', $_POST["search"]["value"]);
			$this->db->or_like('skill', $_POST["search"]["value"]);
			$this->db->or_like('disponnibility', $_POST["search"]["value"]); 
			$this->db->or_like('recentExpertience', $_POST["search"]["value"]); 
			$this->db->or_like('coverLetter', $_POST["search"]["value"]);  

		}
		if(isset($_POST["order"])){
			$this->db->order_by($this->order_column[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}else{
			$this->db->order_by('date', 'DESC');
		}
		if(isset($_POST["filter_category"]["name"])){
			$this->db->like('wageClaim', $_POST["filter_category"]["name"]);
			$this->db->or_like('age', $_POST["search"]["value"]);
		}
	}
	function make_datatables(){
		$this->make_query();
		if($_POST["length"] != -1){
			if($_POST["start"] != 0){
				$start = $_POST["start"] - 1;
				$this->db->limit($_POST["length"],  $start);
			}else{
				$this->db->limit($_POST["length"],  0);
			}
		}
		$query = $this->db->get();
		return $query->result();
	}
	function get_filtered_data(){
		$this->db->where($this->condition);

		$this->make_query();
		$query = $this->db->get();
		$this->db->join('state', 'state.state_id=job_candidatures.state_id');
		return $query->num_rows();
	}
	function get_all_data(){

		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->condition);
		$this->db->join('state', 'state.state_id=job_candidatures.state_id');
		return $this->db->count_all_results();
	}
}








