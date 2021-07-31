<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");

require_once APPPATH . 'libraries/API_Controller.php';

class PaiementController extends API_Controller {
    public function __construct()
    {
        parent::__construct();
        // $this->load->helper(array('form'));
    }

    public function validerAchat() {
        // $Payment = new Payment\Payment();

        // $this->AnnonceModel
        $paymentData = array (
            "entity_type" => "Annonces",
            "entity_id" => "IDHU",
            "montant" => 1000,
            "name" => "Riana Rakotoarinivo"
        );
        try {
            $result = $this->Payment->process($paymentData);
            $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => true,"data" => $result)));
        } catch (\Exception $e) {
            $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode(array('status' => false,"data" => $e->getMessage())));
        }

    }
}