<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller-klasse met alle methodes de gebruikt worden om zwemmers profiel te beheren.
 * 
 * @class Team
 * @brief Controller-klasse voor profiel
 * @author Klaus
 */
class Profiel extends CI_Controller{
    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Klaus Daems     |       Helper: /
    // +----------------------------------------------------------
    // |
    // |    Team controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------
    public function __construct() {
        parent::__construct();
        
        // controleren of persoon is aangemeld
        if (!$this->authex->isAangemeld()) {
        redirect('welcome/meldAan');}
        
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("MY_form_helper");
        $this->load->helper("MY_html_helper");
        $this->load->helper("MY_url_helper");
        
        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "true", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    public function index(){
        $data['titel'] = 'Profiel zwemmer';
        $data['team'] = $this->data->team;
        
        $profielen = $this->ladenProfiel();
        $data['profielen'] = $profielen;
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'zwemmer/profiel',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    public function ladenProfiel($id){
        $this->load->model("zwemmer/profiel_model");
        $profielen = $this->profiel_model->getProfielByPersoon($id);
        
        $data_profielen = array();
        foreach ($profielen as $profiel) {                    
            $data_profielen[] = array(
                "voornaam" => $profiel->voornaam,
                "achternaam" => $profiel->achternaam,
                "straat" => $profiel->straat,
                "huisnummer" => $profiel->huisnummer,
                "postcode" => $profiel->postcode,
                "gemeente" => $profiel->gemeente,
                "telefoonnummer" => $profiel->telefoonnummer,
                "email" => $profiel->email,
                "wachtwoord" => $profiel->wachtwoord,
                "omschrijving" => $profiel->omschrijving,
                "foto" => $profiel->foto,
                "color" => '#FF7534',"textColor" => '#000'
            );
        }
        return $data_profielen;
    }
    
}
