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
       $data['team'] = $this->data->team;
       $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

       
       $this->load->model('trainer/startpaginaitem_model');
       $data['startpaginaitems'] = $this->startpaginaitem_model->getStartpaginaItem();
         

       $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/startpagina_beheren',
            'voetnoot' => 'main_footer');

       $this->template->load('main_master', $partials, $data);

    }


}
