<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

require_once APPPATH."third_party/phpseclib/Crypt/RSA.php";
require_once APPPATH."third_party/phpseclib/Crypt/TripleDES.php";
	use phpseclib\Crypt\RSA;
	use phpseclib\Crypt\TripleDES;
	class PHPTdes extends TripleDES{
		public function __construct() {
			parent::__construct();
			$this->CI = &get_instance();
		}
		// public function decypteo() {
			// $rsa = new \third_party\phpseclib\Crypt\RSA();
		     // extract($this->createKey());
		 
		     // $plaintext = 'terrafrost';
		 
		     // $this->loadKey($privatekey);
		     // $ciphertext = $this->encrypt($plaintext);
		 
		     // $this->loadKey($publickey);
		     
		     // return $this->decrypt($ciphertext);
		// }
		
		public function decypteo($plaintext) {
			// $rsa = new \third_party\phpseclib\Crypt\RSA();
		     // extract($this->createKey());
		 
		 
		     $this->loadKey($privatekey);		 
		     $this->loadKey($publickey);
		     
		     return $this->decrypt($plaintext);
		}
		
		
	}
?>