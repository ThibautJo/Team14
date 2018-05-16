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

        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "true", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
        
        // Aantal meldingen laten zien
        $this->load->model('zwemmer/melding_model');
        $persoon = $this->authex->getPersoonInfo();
        $persoonId = $persoon->id;
        $meldingen = $this->melding_model->getMeldingByPersoon($persoonId);
        $this->data->aantalMeldingen = count($meldingen);
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
        $data['aantalMeldingen'] = $this->data->aantalMeldingen;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'zwemmer/help_agenda',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
}
