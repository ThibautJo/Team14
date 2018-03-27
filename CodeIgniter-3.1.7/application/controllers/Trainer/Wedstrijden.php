<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wedstrijden extends CI_Controller {

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
        $this->load->helper('MY_html');
    }

    // +----------------------------------------------------------
    // |
    // |    Zwemmers beheren
    // |
    // +----------------------------------------------------------

    public function index($aanpasbaar = "weergaven") {
        $data['titel'] = 'Wedstrijden';

        //wedstrijden ophalen van de huidige maand
        $data['maand'] = date("F");

        $this->load->model('trainer/wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getWedstrijden();

        if ($aanpasbaar == "aanpassen") {
          $inhoud = "trainer/wedstrijden_aanpassen";
        }
        else{
          $inhoud = "trainer/wedstrijden";
        }

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => $inhoud,
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

}
