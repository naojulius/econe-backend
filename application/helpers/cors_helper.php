<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('ALLOW_CORS')) 
{
    function ALLOW_CORS()
    {
        $CI =& get_instance();
        header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: POST, GET");
		header("Access-Control-Allow-Headers: Authorization, Content-Type");
		require_once APPPATH . 'libraries/API_Controller.php';
		require_once APPPATH.'enumerations/StateEnum.php';
    }
}