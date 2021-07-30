<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Files extends CI_Model
{
	public function upload($file, $imagePath){
		try {
			$u_id = $this->Guid->newGuid();
			$file_name = $u_id.".".pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = $file_name; 
			$CI = &get_instance();
			$folder = $imagePath;
			$target = $folder . "/" . $file["name"];
			
			if (move_uploaded_file($file["tmp_name"], $target)) {
				$uploadOk = true;
				//return $file_name;
				return array($file_name, $u_id);
			}
		} catch (Exception $e) {
			return null;
		}
	}
}