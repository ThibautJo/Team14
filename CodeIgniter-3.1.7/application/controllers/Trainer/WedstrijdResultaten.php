<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @class WedstrijdResultaten
* @brief Controller-klasse voor WedstrijdResultaten
*
* Controller-klasse met alle methodes die gebruikt worden om WedstrijdResultaten te beheren
*/
class WedstrijdResultaten extends CI_Controller {

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
    $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "true", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");

  }

  // +----------------------------------------------------------
  // |
  // |    wedstrijd resultaten beheren
  // |
  // +----------------------------------------------------------

  /** \brief Haalt alle wedstrijden op.
  *
  * toont de resulterende objecten in de view wedstrijden.php en wedstrijden_aanpassen.php.
  *
  * @see Wedstrijd_model::getWedstrijden()
  * @see wedstrijd_resultaten.php
  */
  public function index() {

    $data['titel'] = 'Wedstrijden';
    $data['team'] = $this->data->team;
    $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

    //wedstrijden ophalen van de huidige maand
    $maand = $this->input->get('maand');
    $jaar = $this->input->get('jaar');
    ($maand == null) ? $data['maand'] = 0 : $data['maand'] = $maand;
    ($jaar == null) ? $data['jaar'] = date("Y") : $data['jaar'] = $jaar;

    if ($this->input->get('actie') == "vorige") {
      $jaar -= 1;
      $data["jaar"] = $jaar;
    }
    else{
      if ($this->input->get('actie') != null) {
        $jaar += 1;
        $data["jaar"] = $jaar;
      }
    }

    $firstDay = null;
    $lastDay = null;

    // day of today
    $lastDay = date("Y-m-d");

    if ($jaar != null) {
      if ($maand != null && $maand != 0) {
        $date = date_create($jaar."-".$maand."-1");
        $query_date = date_format($date,"Y-m-d");

        // first/last day of the month.
        $firstDay = date('Y-m-01', strtotime($query_date));
        $lastDay = date('Y-m-t', strtotime($query_date));
      }
    }

    $this->load->model('trainer/wedstrijd_model');
    $data['wedstrijden'] = $this->wedstrijd_model->getWedstrijdenVerleden($firstDay, $lastDay);

    $i = 0;
    foreach ($data['wedstrijden'] as $wedstrijd) {
      $data['wedstrijden'][$i]->personen = $this->wedstrijd_model->getIngeschrevenen($wedstrijd->id);
      $i++;
    }

    if ($this->input->get('pagina') == "aanpassen") {
      $inhoud = "trainer/wedstrijd_resultaten_aanpassen";
      //afstand en slag opnemen
      $data['afstanden'] = $this->wedstrijd_model->getAfstanden();
      $data['slagen'] = $this->wedstrijd_model->getSlagen();
    }
    else{
      $inhoud = "trainer/wedstrijd_resultaten";
    }

    $partials = array('hoofding' => 'main_header',
    'menu' => 'trainer_main_menu',
    'inhoud' => $inhoud,
    'voetnoot' => 'main_footer');

    $this->template->load('main_master', $partials, $data);
  }

  public function resultatenWedstrijd() {

    $data['titel'] = 'Wedstrijd resultaten';
    $data['team'] = $this->data->team;
    $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

    $this->load->model('trainer/wedstrijd_model');
    $this->load->model('trainer/zwemmers_model');


    // var_dump($data['resultaten']);

    // gegevens ophalen om tabel te vullen
    $data['resultaten'] = $this->wedstrijd_model->getResultatenTabel($this->input->get('wedstrijdid'));
    // var_dump($data['resultaten']);

    // wedstrijden voor comboboxes
    if ($this->input->get('pagina') == "aanpassen") {
      $inhoud = "trainer/wedstrijd_resultaten_result_aanpassen";
      // variabel benodigdheden voor comboboxen op te vullen
      // 1. Zwemmers
      $data['zwemmers'] = $this->zwemmers_model->getZwemmers();
      // 2. wedstrijden

      // 3. Rondes
      $data['rondes'] = $this->wedstrijd_model->getRondes();
      // 4. reeksen (afstand + slag) (bestaande reeksen) (jquery -> ajax)
      $wedId = $this->input->get('wedstrijdid');
      $data['reeksen'] = $this->wedstrijd_model->getSlagEnAfstandWithWedstrijdId($wedId);
      // Tijd word zelf ingevuld met een formaat

    }
    else{
      $inhoud = "trainer/wedstrijd_resultaten_result";
    }


    $partials = array('hoofding' => 'main_header',
    'menu' => 'trainer_main_menu',
    'inhoud' => $inhoud,
    'voetnoot' => 'main_footer');

    $this->template->load('main_master', $partials, $data);
  }

  public function resultaatOpvragen($resultID){
    $this->load->model('trainer/wedstrijd_model');
    $data = new stdClass();
    $data = $this->wedstrijd_model->getResultatenWithId($resultID);
    $data->ronde = $this->wedstrijd_model->getRondeWithId($data->rondeId);
    //verschillende reeksen ophalen horend bij wedstrijd
    $data->reeksen = $this->wedstrijd_model->getReeksenWithInschrijvingId($data->inschrijvingId);


    //gegevens in object steken
    print json_encode($data);
  }
  public function verwijderResultaat($resultID){
    $this->load->model('trainer/wedstrijd_model');
    // $this->wedstrijd_model->verwijderResultaatViaId($resultID);
  }



}
