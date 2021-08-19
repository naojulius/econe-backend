<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends CI_Model
{
    // public function __construct()
    // {
    //     // 
    // }

    public function process ($dataPayment)
    {
        // OLD
        // $cle_prive = "952770057584ed90f851a84235bfb6e062900428ae754409ce";
        // $cle_public = "5493f5bd94f4d97c5b7d48b1c3b6c328122ef95d65c6593935";
        $cle_prive = "54687678314b8a55c6c131996742b90f59fc4a0d87a12d476a";
        $cle_public = "53c9973768e1a4b4b31ab6c144a4082ba3bd1f4286e85b5058";
        $CLIENT_ID = "268_5w7f80czz9wc0gkss0ogc84g08wogw40goos088k88gkwsw4so";
        $CLIENT_SECRET = "5ky5pym2tuo0okwwgsk8gssw8c0so44og4000gw4socgcksww4";
        $serverIpAdress = "167.99.243.114";
        // $this->load->library('util');
        // $this->load->library('crypt');
        // $this->load->library('des_crypt');

        $params = array("public_key"=>$cle_public, "private_key"=>$cle_prive, "client_id"=>$CLIENT_ID, "client_secret"=>$CLIENT_SECRET);

        $idPanier = $dataPayment["entity_type"] . $dataPayment["entity_id"];
        $idReference = "REF" . $dataPayment["entity_type"] . $dataPayment["entity_id"];
        $montant = $dataPayment["montant"];
        $name = $dataPayment["name"];

        $this->load->library('paiement',$params);
        $paiement = new Paiement($params);
        $urlDePaiement = $paiement->initPaie($idPanier, $montant, $name, $idReference, $serverIpAdress);

        return $urlDePaiement;
    }
}
