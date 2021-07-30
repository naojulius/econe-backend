<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reference extends CI_Model
{
	public function new(){
		 $n = 7;
         $generator = "135790246890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
         $result = "";
         for ($i=1; $i <= $n ; $i++) { 
                $result .= substr($generator, (rand() % (strlen($generator))), 1); 
         }
         return "EC".$result;
	}
}