<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {

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

        $this->load->helper('url');
        $this->load->helper('form');
    }

    // +----------------------------------------------------------
    // |
    // |    Zwemmers beheren
    // |
    // +----------------------------------------------------------

    public function index() {
        $data['titel'] = 'Team beheren';
     
        $zwemmers = $this->ladenZwemmers();
        
        $data['zwemmers'] = $zwemmers;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/team_lijst',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    public function ladenZwemmers(){
        $this->load->model("trainer/zwemmers_model");
        $zwemmers = $this->zwemmers_model->getZwemmers();
        
        $data_zwemmers = array();
        
        foreach ($zwemmers as $zwemmer) {                    
            $data_zwemmers[] = array(
                "voornaam" => $zwemmer->Voornaam,
                "achternaam" => $zwemmer->Achternaam,
                "straat" => $zwemmer->Straat,
                "huisnummer" => $zwemmer->Huisnummer,
                "postcode" => $zwemmer->Postcode,
                "gemeente" => $zwemmer->Gemeente,
                "telefoonnummer" => $zwemmer->Telefoonnummer,
                "email" => $zwemmer->Email,
                "wachtwoord" => $zwemmer->Wachtwoord,
                "omschrijving" => $zwemmer->Omschrijving,
                "foto" => $zwemmer->Foto,
                "color" => '#FF7534',
                "textColor" => '#000'
            );
        }
        return $zwemmers;
    }
    
    public function aanpassen() {
        $data['titel'] = 'Team beheren';
        $zwemmers = $this->ladenZwemmers();
        $data['zwemmers'] = $zwemmers;
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/team_aanpassen',
            'voetnoot' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function wijzig($id) {
        $this->load->model('trainer/zwemmers_model');
        $data['zwemmers'] = $this->zwemmers_model->get($id);
        $data['titel'] = 'Zwemmer wijzigen';
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/team_aanpassen',
            'voetnoot' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function schrap($id) {
        $this->load->model('trainer/zwemmers_model');
        $data['zwemmers'] = $this->zwemmers_model->delete($id);
        
        redirect('/trainer/team_lijst');
    }
    
    public function maakNieuwe() {
        $data['zwemmers'] = $this->getEmptySupplement();
        $data['titel'] = 'Supplement toevoegen';
        
        $this->load->model('trainer/supplementfunctie_model');
        $data['functies'] = $this->supplementfunctie_model->getAllByFunctie();
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/supplement_form',
            'voetnoot' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
}
