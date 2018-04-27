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
        
        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "true");
    }

    public function index() {
        
        $data['titel'] = 'Meldingen';
        $data['team'] = $this->data->team;
<<<<<<< HEAD
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
        
        $persoonId = 5;
=======
        $persoonAangemeld = $this->authex->getPersoonInfo();
        $data['persoonAangemeld'] = $persoonAangemeld;
>>>>>>> f0d97e7a245fdc54c29f9e98475c9e21a0ed0c34

        $persoonId = $persoonAangemeld->id;
        
        $this->load->model('zwemmer/melding_model');
        $data['meldingen'] = $this->melding_model->getMeldingByPersoon($persoonId);

        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'zwemmer/melding',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
}
