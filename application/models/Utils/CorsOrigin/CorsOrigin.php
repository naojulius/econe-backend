<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CorsOrigin extends CI_Model
{
	public function Allow (){
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: Authorization, Content-Type");
	}
}