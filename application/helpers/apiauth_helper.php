<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';
if(!function_exists('ENABLE_AUTH')) 
{
    function ENABLE_AUTH(string $method, bool $status)
    {
    	$CI =& get_instance();
        $CI->_apiConfig([
				'methods' => [$method],
				'requireAuthorization' => false, //$status
		]);
    }
}