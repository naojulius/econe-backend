<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");

require_once APPPATH . 'libraries/API_Controller.php';
require_once APPPATH.'enumerations/StateEnum.php';

class PaiementController extends API_Controller {
    var $requireAuthorization = false;
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
        } catch (Exception $e) {
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

        log_message('debug', 'Payment successfull, Changing entity state');

        // $this->RencontreModel->updateRencontreState("CF791C4D-86E5-1DCB-2F6C-81F49AC89FDCF2" , StateEnum::PAYED_NOT_EXPIRED);
        // $this->AnnonceModel->updateAnnonceState("CF791C4D-86E5-1DCB-4F6C-81F49AC89FDC" , "PAYED_NOT_EXPIRED");
        // $this->JobModel->updateJobState("7DCFB691-31E6-4878-F4C1-499A963EFA7D", "PAYED_NOT_EXPIRED");
        
        $this->load->library('Util');
		// $this->load->library('Paiement'); 05D6CF0C-B058-FFA7-EFD6-F1748D1E8648
		// $tdes = new pHPTdes();
		$util = new Util();
		$parts = parse_url($_SERVER['REQUEST_URI']);
		parse_str($parts['query'], $query);

        // Decrypter avec le clé privé du site
		$idPanier = $util->decrypter('54687678314b8a55c6c131996742b90f59fc4a0d87a12d476a', $query['idpanier']);		
		$idpaiement = $util->decrypter('54687678314b8a55c6c131996742b90f59fc4a0d87a12d476a', $query['idpaiement']);		
		$ref_arn = $util->decrypter('54687678314b8a55c6c131996742b90f59fc4a0d87a12d476a', $query['ref_arn']);		
		$code_arn = $util->decrypter('54687678314b8a55c6c131996742b90f59fc4a0d87a12d476a', $query['code_arn']);		
        $nomPayeur = $util->decrypter('54687678314b8a55c6c131996742b90f59fc4a0d87a12d476a', $query['nom']);
        
        log_message('debug', 'idPanier : ' . $idPanier, false);
        log_message('debug', 'idpaiement : ' . $idpaiement, false);
        log_message('debug', 'ref_arn : ' . $ref_arn, false);
        log_message('debug', 'code_arn : ' . $code_arn, false);
        log_message('debug', 'nomPayeur : ' . $nomPayeur, false);

        $idPanierArr = explode("_", $idPanier);
        $entity = $idPanierArr[0];
        $idEntity = $idPanierArr[1];

        if ($entity === "Annonce") {
            // $this->AnnonceModel->getAnnonceById($data);
            $this->AnnonceModel->updateAnnonceState($idEntity , "PAYED_NOT_EXPIRED");
        } elseif ($entity === "Rencontre") {
            $this->RencontreModel->updateRencontreState($idEntity, "PAYED_NOT_EXPIRED");
        } elseif ($entity === "Job") {
            $this->JobModel->updateJobState($idEntity, "PAYED_NOT_EXPIRED");
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('status' => true,"message" => "Submited successfully")));
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