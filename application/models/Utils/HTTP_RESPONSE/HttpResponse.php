<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class HttpResponse extends CI_Model
{
	public function OK ($data){
		return 200;
	}
	public function BAD_REQUEST($data){
		return 400;
	}
	public function INTERNAL_SERVEUR(){
		return 500;
	}
	public function NOT_FOUND(){
		return 404;
	}
}