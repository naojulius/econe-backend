<?php
class Util {
    private $CI;

    /**
     * Util constructor.
     */
    public function __construct(){
        $this->CI = & get_instance();
        $this->CI->load->library('crypt');
    }


    public function sendCurl($url,$type,$headers,$params){
        $curl=curl_init();
		//curl_setopt($curl, CURLOPT_PROXY, '127.0.0.1:8888');
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        if(strtoupper($type)=='POST'){
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$params);
        }else{
            $query=http_build_query($params);
            $url.="?".$query;
        }
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
        $result=curl_exec($curl);
		echo curl_error($curl);
        curl_close($curl);
        return $result;
    }

    public function crypter($key,$data){
        $this->CI->crypt->setKey($key);
		//$this->CI->crypt->setIV('\0\0\0\0\0\0\0\0');
        return $this->CI->crypt->encrypt($data);
    }

    public function decrypter($key,$data){
        $this->CI->crypt->setKey($key);
        return $this->CI->crypt->decrypt($data);
    }
}