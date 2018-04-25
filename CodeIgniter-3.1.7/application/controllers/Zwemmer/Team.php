<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Team
 *
 * @author Klied
 */
class Team extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("MY_form_helper");
        $this->load->helper("MY_html_helper");
        $this->load->helper("MY_url_helper");
        
        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "true", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    public function index() {
        $data['titel'] = 'Team beheren';
        $data['team'] = $this->data->team;
        
        $zwemmers = $this->ladenTeam();
        
        $data['zwemmers'] = $zwemmers;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'trainer/team_lijst',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Haalt de gegevens op van de zwemmers(personen) via Zwemmers_model en
     * stopt de resulterende objecten in een array $zwemmers
     * 
     * @see Zwemmers_model::getZwemmers()
     * @return type $zwemmers
     */
    public function ladenTeam(){
        $this->load->model("trainer/zwemmers_model");
        $zwemmers = $this->zwemmers_model->getZwemmers();
        
        $data_zwemmers = array();
        foreach ($zwemmers as $zwemmer) {                    
            $data_zwemmers[] = array(
                "voornaam" => $zwemmer->voornaam,
                "achternaam" => $zwemmer->achternaam,
                "straat" => $zwemmer->straat,
                "huisnummer" => $zwemmer->huisnummer,
                "postcode" => $zwemmer->postcode,
                "gemeente" => $zwemmer->gemeente,
                "telefoonnummer" => $zwemmer->telefoonnummer,
                "email" => $zwemmer->email,
                "wachtwoord" => $zwemmer->wachtwoord,
                "omschrijving" => $zwemmer->omschrijving,
                "foto" => $zwemmer->foto,
                "color" => '#FF7534',"textColor" => '#000'
            );
        }
        return $zwemmers;
    }
}
