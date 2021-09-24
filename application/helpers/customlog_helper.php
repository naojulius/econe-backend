<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('N_LOG_WRITE')) 
{
    function N_LOG_WRITE($logs)
    {

    	$prefix = "LOG_";
    	$time = new \DateTime();
    	$date = $time->format('Y_m_d');
        $file = fopen("documents/_logs/".$prefix.$date.".json", "a+");
        fwrite($file, json_encode($logs)."\n");
		fclose($file);
    }
}