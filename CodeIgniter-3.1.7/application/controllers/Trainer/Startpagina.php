<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Startpagina extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Jolien Lauwers       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Startpagina controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    public function __construct() {

        parent::__construct();
        
        // controleren of bevoegde persoon is aangemeld        
        if (!$this->authex->isAangemeld()) {
            redirect('welcome/meldAan');
        } else {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->soort != "Trainer") {
                redirect('welcome/meldAan');
            }
        }

        // Helpers inladen
        $this->load->helper("url");
        $this->load->helper('form');
        $this->load->helper("my_form_helper");
        $this->load->helper("my_html_helper");
        $this->load->helper("notation_helper");
        
        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "true", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    // +----------------------------------------------------------
    // |
    // |    Startpagina beheren
    // |
    // +----------------------------------------------------------

    public function index() {
        
       $data['titel'] = 'Startpagina beheren';
       
       $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/NOGAANMAKEN',
            'voetnoot' => 'main_footer');

       $this->template->load('main_master', $partials, $data);
       
    }
    
    
}
