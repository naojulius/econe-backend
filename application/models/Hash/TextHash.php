<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class TextHash extends CI_Model
{
	
	public function hashPass ($text){
		$options = [
		    'cost' => 12,
		];
		return password_hash($text, PASSWORD_BCRYPT, $options);
	}
}