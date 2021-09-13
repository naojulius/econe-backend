<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('HTTP_OK')) 
{
    function HTTP_OK($response)
    {
        $CI =& get_instance();
      	 return $CI->output->set_status_header(200)
						        ->set_content_type('application/json')
						        	->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}

if(!function_exists("HTTP_BADREQUEST"))
{
	function HTTP_BADREQUEST($response)
    {
        $CI =& get_instance();
      	 return $CI->output->set_status_header(400)
						        ->set_content_type('application/json')
						        	->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}

if(!function_exists("HTTP_INTERNAL_ERROR"))
{
	function HTTP_INTERNAL_ERROR($response)
    {
        $CI =& get_instance();
      	 return $CI->output->set_status_header(500)
						        ->set_content_type('application/json')
						        	->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}