<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @class Wedstrijden
 * @brief Controller-klasse voor wedstrijden
 *
 * Controller-klasse met alle methodes die gebruikt worden om wedstrijden te beheren
 */
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
  // |    wedstrijd beheren
  // |
  // +----------------------------------------------------------

  /** \brief Haalt alle wedstrijden op.
   *
   * toont de resulterende objecten in de view wedstrijden.php en wedstrijden_aanpassen.php.
   *
   * @see Wedstrijd_model::getWedstrijden()
   * @see wedstrijden.php
   * @see wedstrijden_aanpassen.php
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
    if ($jaar != null) {
      if ($maand != null && $maand != 0) {
        $date = date_create($jaar."-".$maand."-1");
        $query_date = date_format($date,"Y-m-d");

        // First day of the month.
        $firstDay = date('Y-m-01', strtotime($query_date));

        // Last day of the month.
        $lastDay = date('Y-m-t', strtotime($query_date));
      }
      else{
        //alle wedstrijden van ander jaren laten zien
        // First day of the year.
        $firstDay = date('Y-m-d',strtotime(date($jaar.'-01-01')));

        // Last day of the year.
        $lastDay = date('Y-m-d', strtotime($jaar.'-12-31'));
      }
    }

    $this->load->model('trainer/wedstrijd_model');
    $data['wedstrijden'] = $this->wedstrijd_model->getWedstrijden($firstDay, $lastDay);

    $i = 0;
    foreach ($data['wedstrijden'] as $wedstrijd) {
      $data['wedstrijden'][$i]->personen = $this->wedstrijd_model->getIngeschrevenen($wedstrijd->id);
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
    /**
     * \brief Haalt opgevraagde wedstrijd op.
     *
     * Toont data van het gevraagde wedstrijd in het formulier in view wedstrijden_aanpassen.php.
     * \param $wedstrijdId is het gescpecifieerde wedstrijd.
     *
     * @see Wedstrijd_model::getWedstrijdenWithId()
     * @see wedstrijden_aanpassen.php
     */

    //opvragen van gegevens
    $this->load->model('trainer/wedstrijd_model');
    $data = new stdClass();
    $data = $this->wedstrijd_model->getWedstrijdenWithId($wedstrijdId);
    $d = new DateTime($data->datumStart);
    $data->datumStart = $d->format('Y-m-d');
    $d = new DateTime($data->datumStop);
    $data->datumStop = $d->format('Y-m-d');

    //gegevens in object steken
    print json_encode($data);
  }

  public function reeksenOpvragen($wedstrijdId){
    /**
     * \brief Haalt reeksen op van het opgevraagde wedstrijd.
     *
     * Toont data van het gevraagde reeksen van het specifiek wedstrijd in het formulier in view wedstrijden_aanpassen.php.
     * \param $wedstrijdId is het id van het opgevraagde wedstrijd
     *
     * @see Wedstrijd_model::getWedstrijdenWithId()
     * @see wedstrijden_aanpassen.php
     */

    //opvragen van gegevens
    $this->load->model('trainer/wedstrijd_model');
    $reeksen = $this->wedstrijd_model->getReeksenWithWedstrijdID($wedstrijdId);

    $slagenIDs = array();
    $afstandenIDs = array();

    foreach ($reeksen as $reeks) {
      $slag = $this->wedstrijd_model->getSlagWithID($reeks->slagId);
      $afstand = $this->wedstrijd_model->getAfstandWithID($reeks->afstandId);
      array_push($slagenIDs, array($slag->id => $slag->slag));
      array_push($afstandenIDs, array($afstand->id => $afstand->afstand));
    }

    $data = new stdClass();
    $data->slagIDs = $slagenIDs;
    $data->afstandIDs = $afstandenIDs;

    print json_encode($data);
  }

  public function opslaanWedstrijd($actie = "toevoegen"){
    /**
     * \brief Opslaan/updaten van wedstrijd
     *
     * Deze functie zorgt ervoor dat een wedstrijd opgeslagen of aangepast kan worden in het Wedstrijd_model.
     * \param $actie is om na te gaan of het update of toevoegen is.
     *
     * @see Wedstrijd_model::updateReeksen()
     * @see Wedstrijden_aanpassen.php
     */

    $data = new stdClass();
    $data->naam = $this->input->post('titel-wedstrijd');
    $data->datumStart = $this->input->post('datum-wedstrijdStart');
    $data->datumStop = $this->input->post('datum-wedstrijdStop');
    $data->plaats = $this->input->post('locatie-wedstrijd');
    $data->programma = $this->input->post('programma-wedstrijd');
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
      $data->id = $this->input->post('wedstrijdID');
      $this->wedstrijd_model->updateWedstrijd($data);
      //reeks(en) per wedstrijd updaten
      $this->wedstrijd_model->updateReeksen($data->id, $reeksen);
    }

    //pagina opnieuw laden en niet de index functie (anders word er telkens bij reload opnieuw data geïnsert)
    header('Location: ' . site_url() .'/Trainer/wedstrijden/index?pagina=aanpassen');
  }
  public function verwijderWedstrijd($id){
    /**
     * \brief Verwijderen van een wedstrijd en bijhorende reeksen.
     *
     * \param $id is het speciefiek wedstrijd dat verwijdered word in het Wedstrijd_model.
     *
     * @see Wedstrijd_model::deleteWedstrijd()
     * @see wedstrijden_aanpassen.php
     */
    $this->load->model('trainer/wedstrijd_model');
    $this->wedstrijd_model->deleteWedstrijd($id);
  }

}
