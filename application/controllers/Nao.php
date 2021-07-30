<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Nao extends API_Controller
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * demo method 
     *
     * @link [api/user/demo]
     * @method POST
     * @return Response|void
     */
    public function demo()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            /**
             * By Default Request Method `GET`
             */
            'methods' => ['POST'], // 'GET', 'OPTIONS'

            /**
             * Number limit, type limit, time limit (last minute)
             */
            'limit' => [5, 'ip', 'everyday'],

            /**
             * type :: ['header', 'get', 'post']
             * key  :: ['table : Check Key in Database', 'key']
             */
            'key' => ['POST', $this->key() ], // type, {key}|table (by default)
        ]);
        
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => "Return API Response",
            ],
        200);
    }
}