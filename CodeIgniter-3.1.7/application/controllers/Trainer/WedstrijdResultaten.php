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
  * toont de resulterende objecten in de view wedstrijd_resultaten.php en wedstrijd_resultaten_aanpassen.php.
  *
  * @see Wedstrijd_model::getWedstrijdenVerleden()
  * @see Wedstrijd_model::getIngeschrevenen()
  * @see Wedstrijd_model::getAfstanden()
  * @see Wedstrijd_model::getSlagen()
  * @see wedstrijd_resultaten.php
  * @see wedstrijd_resultaten_aanpassen.php
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

  /** \brief Haalt alle wedstrijd resultaten op van bijhorende wedstrijd.
  *
  * toont de resulterende objecten in de view wedstrijd_resultaten_result.php en wedstrijd_resultaten_result_aanpassen.php.
  *
  * @param $actie duid aan op welke pagina men terecht komt
  * @see Wedstrijd_model::getResultatenTabel()
  * @see Wedstrijd_model::getRondes()
  * @see Wedstrijd_model::getSlagEnAfstandWithWedstrijdId()
  * @see zwemmers_model::getZwemmers()
  * @see wedstrijd_resultaten_result.php
  * @see wedstrijd_resultaten_result_aanpassen.php
  */
  public function resultatenWedstrijd($actie = null) {

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
    if ($this->input->get('pagina') == "aanpassen" || $actie == "aanpassen") {
      $inhoud = "trainer/wedstrijd_resultaten_result_aanpassen";
      // variabel benodigdheden voor comboboxen op te vullen
      // 1. Zwemmers die goedgekeurd zijn
      $data['zwemmers'] = $this->zwemmers_model->getZwemmers();
      // 2. wedstrijden

      // 3. Rondes
      $data['rondes'] = $this->wedstrijd_model->getRondes();
      // 4. reeksen (afstand + slag) (bestaande reeksen) (jquery -> ajax)

      $data['reeksen'] = $this->wedstrijd_model->getSlagEnAfstandWithWedstrijdId($this->input->get('wedstrijdid'));

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
  /** \brief Haalt het opgevraagde resultaat van de zwemmer op.
  *
  * @param $resultID duid het resultaat id aan dat opgevraagd moet worden
  * @see Wedstrijd_model::getResultatenWithId()
  * @see Wedstrijd_model::getRondeWithId()
  * @see Wedstrijd_model::getReeksenWithInschrijvingId()
  */
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

  public function opslaanResultaat($actie){

    $this->load->model('trainer/wedstrijd_model');
    //gegevens opslaan dmv 2 objecten
    $resultaat = new stdClass(); //moet inschrijvingsID retourneren
    if ($actie == "aanpassen") {
      $resultaat->id = $this->input->get('resultaatId');
      //inschrijvingid opvragen
      $data = $this->wedstrijd_model->getInschijvingsIdViaResultaatId($resultaat->id);
      $resultaat->inschrijvingId = $data->inschrijvingId;
    }
    else {
      // wedid + slagid + afstandID nodig voor reeksPerWedstrijdId
      $reeks = explode('-', $this->input->post('reeksenToevoegen')); //id's
      $slagId = $reeks[1]; //id
      $afstandId = $reeks[0]; //id
      $wedID = $this->input->get('wedstrijdId');
      $reeksPerWedstrijdId = $this->wedstrijd_model->getReeksPerWedstrijdViaSlagAndAfstandAndWedid($slagId,$afstandId, $wedID);
      // gettin inschrijvingsid via reeksperwedstrijdid
      $inschrijvingsID = $this->wedstrijd_model->getInschijvingsIdViaReeksPerWedstrijdId($reeksPerWedstrijdId->id);

      $resultaat->inschrijvingId = $inschrijvingsID->id;
    }
    $resultaat->tijd = $this->input->post('naam-datum'). ' ' . $this->input->post('naam-tijd');
    $resultaat->rondeId = $this->input->post('rondeToevoegen'); //id

    if ($actie == "aanpassen") {
      $inschrijving = new stdClass(); //zodat deze het ID weet dat aangepast moet worden + reeksperwedstr retourneren

      $inschrijving->id = $resultaat->inschrijvingId;

      $inschrijving->persoonId = $this->input->post('zwemmersToevoegen'); //id
      //reeksperwedstrijdid ophalen
      $data = $this->wedstrijd_model->getReeksPerWedstrijdViaInschrijvingId($inschrijving->id);
      $inschrijving->reeksPerWedstrijdId = $data->reeksPerWedstrijdId;
      $inschrijving->status = "2";
    }


    if ($actie == "aanpassen") {
      $reeksperwedstrijd = new stdClass(); //zodat deze weet welk reeksperwedstrijd aangepast moet worden

      $reeksperwedstrijd->id = $inschrijving->reeksPerWedstrijdId;
      $reeksperwedstrijd->wedstrijdId = $this->input->get('wedstrijdId');
      $reeks = explode('-', $this->input->post('reeksenToevoegen')); //id's
      $reeksperwedstrijd->slagId = $reeks[1]; //id
      $reeksperwedstrijd->afstandId = $reeks[0]; //id
    }





    if ($actie == "toevoegen") {
      //insert resultaat
      $this->wedstrijd_model->insertResultaat($resultaat);
      //update inschrijving
      // $this->wedstrijd_model->insertInschrijving($inschrijving);
      // //update reeksperwedstrijd
      // $this->wedstrijd_model->insertReeksPerWedstrijd($reeksperwedstrijd);
    }
    else {
      //update resultaat
      $this->wedstrijd_model->updateResultaat($resultaat);
      //update inschrijving
      $this->wedstrijd_model->updateInschrijving($inschrijving);
      //update reeksperwedstrijd
      $this->wedstrijd_model->updateReeksPerWedstrijd($reeksperwedstrijd);
    }



    header("Location: ". site_url().'/Trainer/WedstrijdResultaten/resultatenWedstrijd?pagina=aanpassen&wedstrijdid='.$this->input->get('wedstrijdId'));

  }
  /** \brief Verwijderd het gevraagde resultaat adhv resultaat id.
  *
  * @param $resultID duid het resultaat id aan dat opgevraagd moet worden
  * @see Wedstrijd_model::verwijderResultaatViaId()
  */
  public function verwijderResultaat($resultID){
    $this->load->model('trainer/wedstrijd_model');
    // $this->wedstrijd_model->verwijderResultaatViaId($resultID);
  }



}
