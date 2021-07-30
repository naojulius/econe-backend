<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class HttpResponse extends CI_Model
{
	public function HTTP_OK (){
		return 200;
	}
	public function HTTP_BAD_REQUEST(){
		return 400;
	}
	public function HTTP_INTERNAL_SERVEUR(){
		return 500;
	}
	public function HTTP_ACCEPTED(){
		return 202;
	}
	public function HTTP_NOT_FOUND(){
		return 404;
	}
}