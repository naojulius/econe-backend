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

    public function validerAchat() 
    {
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

    public function paimentSuccess()
    {
        $this->_apiConfig([
			'methods' => ['GET'],
			'requireAuthorization' => $this->requireAuthorization,
        ]);

        $this->load->library('PHPTdes');
		$this->load->library('Paiement');
		$tdes = new pHPTdes();
		$util = new Util();
		$parts = parse_url($_SERVER['REQUEST_URI']);
		parse_str($parts['query'], $query);

		$idPanier = $util->decrypter('952770057584ed90f851a84235bfb6e062900428ae754409ce', $query['idpanier']);		
		$idpaiement = $util->decrypter('952770057584ed90f851a84235bfb6e062900428ae754409ce', $query['idpaiement']);		
		$ref_arn = $util->decrypter('952770057584ed90f851a84235bfb6e062900428ae754409ce', $query['ref_arn']);		
		$code_arn = $util->decrypter('952770057584ed90f851a84235bfb6e062900428ae754409ce', $query['code_arn']);		
        $nomPayeur = $util->decrypter('952770057584ed90f851a84235bfb6e062900428ae754409ce', $query['nom']);
        
        log_message('debug', 'idPanier : ' . $idPanier, false);
        log_message('debug', 'idpaiement : ' . $idpaiement, false);
        log_message('debug', 'ref_arn : ' . $ref_arn, false);
        log_message('debug', 'code_arn : ' . $code_arn, false);
        log_message('debug', 'nomPayeur : ' . $nomPayeur, false);
    }

    public function paimentFailed()
    {
        $this->CorsOrigin->Allow();
		$this->_apiConfig([
			'methods' => ['GET'],
			'requireAuthorization' => $this->requireAuthorization,
        ]);

        log_message('debug', 'PaimentFailed', false);
    }
}