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

    $data['titel'] = 'Wedstrijd resultaten';
    $data['team'] = $this->data->team;
    $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

    $this->load->model('trainer/wedstrijd_model');
    $this->load->model('trainer/Zwemmers_model');
    // gegevens ophalen om tabel te vullen
    $data['resultaten'] = $this->wedstrijd_model->getResultatenTabel();

    // var_dump($data['resultaten']);

    $inhoud = "zwemmer/wedstrijd_resultaten";


    $partials = array('hoofding' => 'main_header',
    'menu' => 'main_menu',
    'inhoud' => $inhoud,
    'voetnoot' => 'main_footer');

    $this->template->load('main_master', $partials, $data);
  }



}
