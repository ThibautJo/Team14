<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Melding extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Melding controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    public function __construct() {

        parent::__construct();
        
        // controleren of persoon is aangemeld
        if (!$this->authex->isAangemeld()) {
        redirect('welcome/meldAan');}

        // Helpers inladen
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('my_html_helper');
        $this->load->helper('my_form_helper');
        
        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "true");
    }

    public function index() {
        $data['titel'] = 'Meldingen';
        $data['team'] = $this->data->team;

        $this->load->model('trainer/melding_model');
        $data['meldingen'] = $this->melding_model->getMeldingen();

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/melding',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    public function beheren() {
        $data['titel'] = 'Meldingen';
        $data['team'] = $this->data->team;

        $this->load->model('trainer/melding_model');
        $data['meldingen'] = $this->melding_model->getMeldingen();

        $this->load->model('trainer/zwemmers_model');
        $data['zwemmers'] = $this->zwemmers_model->getZwemmers();
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/melding_aanpassen',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
}
