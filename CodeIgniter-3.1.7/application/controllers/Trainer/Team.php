<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |
    // |    Team controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    public function __construct() {

        parent::__construct();

        $this->load->helper('url');
    }

    // +----------------------------------------------------------
    // |    Auteur: Klaus Daems       |       Helper: /
    // +----------------------------------------------------------
    // |
    // |    Zwemmers beheren
    // |
    // +----------------------------------------------------------

    public function index() {
        $data['titel'] = 'Team';
        $data['magNiet'] = 'ja';
     
        $zwemmers = $this->ladenZwemmers();
        
        $data['zwemmers'] = $zwemmers;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'trainer/team',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    public function ladenZwemmers(){
        $this->load->model("trainer/zwemmers_model");
        $zwemmers = $this->zwemmers_model->getZwemmers();
        
//        $data_zwemmers = array();
//        
//        foreach ($zwemmers as $zwemmer) {                    
//            $data_zwemmers[] = array(
//                "voornaam" => $zwemmer->Naam,
//                "achternaam" => $zwemmer->Familienaam,
//                "straat" => $zwemmer->Straat,
//                "huisnummer" => $zwemmer->Huisnummer,
//                "postcode" => $zwemmer->Postcode,
//                "gemeente" => $zwemmer->Gemeente,
//                "telefoonnummer" => $zwemmer->Telefoonnummer,
//                "email" => $zwemmer->Email,
//                "wachtwoord" => $zwemmer->Wachtwoord,
//                "omschrijving" => $zwemmer->Omschrijving,
//                "foto" => $zwemmer->Foto,
//                "color" => '#FF7534',
//                "textColor" => '#000'
//            );
//        }
        
        return $zwemmers;
    }
}
