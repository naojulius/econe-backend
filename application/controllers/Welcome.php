<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'enumerations/StateEnum.php';

class Welcome extends CI_Controller {

	public function index()
	{
		// Welcome page API.
		$this->load->view('welcome_message');
	}
}