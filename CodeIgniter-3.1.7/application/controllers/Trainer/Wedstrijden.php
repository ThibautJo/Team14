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

    public function index() {
        $data['titel'] = 'Wedstrijden';

        //wedstrijden ophalen van de huidige maand
        $data['maand'] = date("F");

        $this->load->model('trainer/wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getWedstrijden();

        if ($this->input->get('pagina') == "aanpassen") {
          $inhoud = "trainer/wedstrijden_aanpassen";
          //afstand en slag opnemen
          $data['afstanden'] = $this->wedstrijd_model->getAfstanden();
          $data['slagen'] = $this->wedstrijd_model->getSlagen();
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

    public function opslaanWedstrijd(){
      //insert query
      $titel = $this->input->post('titel-wedstrijd');
      $datumStart = $this->input->post('datum-wedstrijdStart');
      $datumEnd = $this->input->post('datum-wedstrijdEnd');
      $locatie = $this->input->post('locatie-wedstrijd');
      $programma = $this->input->post('programma-wedstrijd');
      $afstanden = $this->input->get('afstanden');
      $slagen = $this->input->get('slagen');

      $this->load->model('trainer/wedstrijd_model');
      $this->wedstrijd_model->insertWedstrijd($titel,$datumStart,$datumEnd,$locatie);

      //pagina opnieuw laden en niet de index functie (anders word er telkens bij reload opnieuw data geïnsert)
      header('Location: ' . site_url() .'/Trainer/wedstrijden/index?pagina=aanpassen');
    }
    public function verwijderWedstrijd($id){
      $this->load->model('trainer/wedstrijd_model');
      $this->wedstrijd_model->deleteWedstrijd($id);
    }

}
