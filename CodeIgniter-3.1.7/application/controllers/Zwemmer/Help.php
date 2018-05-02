<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Jolien Lauwers  |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Help controller
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
        $this->load->helper("my_html_helper");
        $this->load->helper("my_url_helper");
        
        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "true", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    // +----------------------------------------------------------
    // |
    // |    Helpfuncties bekijken
    // |
    // +----------------------------------------------------------

    public function index() {
        
        // eventuele helppagina (?)
                       
    }
    
    public function agendaHelp() {
        
        $data['titel'] = 'Hoe werkt de Agenda-tool?';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
       
        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'zwemmer/help_agenda',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
}
