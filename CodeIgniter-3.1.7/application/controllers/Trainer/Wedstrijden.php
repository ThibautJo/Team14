<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wedstrijden extends CI_Controller {

  // +----------------------------------------------------------
  // |    Trainingscentrum Wezenberg
  // +----------------------------------------------------------
  // |    Auteur: Thibaut Joukes     |       Helper: /
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
    $this->load->helper('notation');
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

    $i = 0;
    foreach ($data['wedstrijden'] as $wedstrijd) {
      $data['wedstrijden'][$i]->personen = $this->wedstrijd_model->getIngeschrevenen($wedstrijd->ID);
      $i++;
    }

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

  public function wedstrijdOpvragen($wedstrijdId){

    //opvragen van gegevens
    $this->load->model('trainer/wedstrijd_model');
    $data = new stdClass();
    $data = $this->wedstrijd_model->getWedstrijdenWithId($wedstrijdId);
    $d = new DateTime($data->DatumStart);
    $data->DatumStart = $d->format('Y-m-d');
    $d = new DateTime($data->DatumStop);
    $data->DatumStop = $d->format('Y-m-d');

    //gegevens in object steken
    print json_encode($data);
  }

  public function reeksenOpvragen($wedstrijdId){

    //opvragen van gegevens
    $this->load->model('trainer/wedstrijd_model');
    $reeksen = $this->wedstrijd_model->getReeksenWithWedstrijdID($wedstrijdId);

    $slagenIDs = array();
    $afstandenIDs = array();

    foreach ($reeksen as $reeks) {
      $slag = $this->wedstrijd_model->getSlagWithID($reeks->SlagId);
      $afstand = $this->wedstrijd_model->getAfstandWithID($reeks->AfstandId);
      array_push($slagenIDs, array($slag->ID => $slag->Slag));
      array_push($afstandenIDs, array($afstand->ID => $afstand->Afstand));
    }

    $data = new stdClass();
    $data->slagIDs = $slagenIDs;
    $data->afstandIDs = $afstandenIDs;

    print json_encode($data);
  }

  public function opslaanWedstrijd($actie = "toevoegen"){

    $data = new stdClass();
    $data->Naam = $this->input->post('titel-wedstrijd');
    $data->datumStart = $this->input->post('datum-wedstrijdStart');
    $data->datumStop = $this->input->post('datum-wedstrijdStop');
    $data->Plaats = $this->input->post('locatie-wedstrijd');
    $data->Programma = $this->input->post('programma-wedstrijd');
    $this->load->model('trainer/wedstrijd_model');

    $reeksen = new stdClass();
    $reeksen->afstanden = explode(",", $this->input->get('afstanden'));
    $reeksen->slagen = explode(",", $this->input->get('slagen'));

    if ($actie == "toevoegen") {
      //insert query
      $newWedstrijdID = $this->wedstrijd_model->insertWedstrijd($data);
      //reeks(en) per wedstrijd toevoegen
      $this->wedstrijd_model->insertReeksen($newWedstrijdID, $reeksen);
    }
    else{
      //update query
      $data->ID = $this->input->post('wedstrijdID');
      $this->wedstrijd_model->updateWedstrijd($data);
      //reeks(en) per wedstrijd updaten
      $this->wedstrijd_model->updateReeksen($data->ID, $reeksen);
    }

    //pagina opnieuw laden en niet de index functie (anders word er telkens bij reload opnieuw data geïnsert)
    header('Location: ' . site_url() .'/Trainer/wedstrijden/index?pagina=aanpassen');
  }
  public function verwijderWedstrijd($id){
    $this->load->model('trainer/wedstrijd_model');
    $this->wedstrijd_model->deleteWedstrijd($id);
  }

}
