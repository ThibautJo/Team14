<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Inschrijving
 * @brief Controller-klasse voor inschrijvingen
 *
 * Controller-klasse met alle methodes die gebruikt worden om inschrijvingen te beheren
 */
class Inschrijving extends CI_Controller {
    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Inschrijving controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    /**
     * Constructor
     */
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
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "true");
    }

    /**
     * Haalt alle inschrijvingen op via inschrijving_model en
     * toont de resulterende objecten in de view inschrijving.php
     * 
     * @see Inschrijving_model::getInschrijvingen()
     * @see inschrijving.php
     */
    public function index() {
        $data['titel'] = 'Inschrijvingen';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

        $this->load->model('trainer/inschrijving_model');
        $data['inschrijvingen'] = $this->inschrijving_model->getInschrijvingen();

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/inschrijving',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt alle inschrijvingen op via inschrijving_model en
     * toont de resulterende objecten in de view inschrijving_aanpassen.php
     * 
     * @see Inschrijving_model::getInschrijvingen()
     * @see inschrijving_aanpassen.php
     */
    public function aanpassen() {
        $data['titel'] = 'Inschrijvingen beheren';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

        $this->load->model('trainer/inschrijving_model');
        $data['inschrijvingen'] = $this->inschrijving_model->getInschrijvingen();

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/inschrijving_aanpassen',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt de id=$id op van het te wijzigen inschrijving-record via inschrijving_model en
     * maakt een melding en
     * toont de aangepaste lijst in de view inschrijving_aanpassen.php
     * 
     * @param $id De id van de te wijzigen inschrijving
     * @see Inschrijving_model::updateInschrijving()
     * @see Inschrijving_model::get()
     * @see Wedstrijd_model::getReeksWitID()
     * @see Wedstrijd_model::getAfstandWithID()
     * @see Wedstrijd_model::getSlagWithID()
     * @see Wedstrijd_model::get()
     * @see Melding_model::insertMelding()
     * @see Melding_model::insertMeldingPerPersoon()
     * 
     */
    public function goedkeurenInschrijving($id) {
        $inschrijving = new stdClass();
        $melding = new stdClass();
        $meldingPerPersoon = new stdClass();

        $inschrijving->id = $id;
        $inschrijving->status = 2;

        $this->load->model('trainer/inschrijving_model');
        $this->inschrijving_model->updateInschrijving($inschrijving);

        $inschrijvingTabel = $this->inschrijving_model->get($id);
        $reeksPerWedstrijdId = $inschrijvingTabel->reeksPerWedstrijdId;
        $this->load->model('trainer/wedstrijd_model');
        $reeksPerWedstrijdTabel = $this->wedstrijd_model->getReeksWithID($reeksPerWedstrijdId);

        // afstand
        $afstandId = $reeksPerWedstrijdTabel->afstandId;
        $afstand = $this->wedstrijd_model->getAfstandWithID($afstandId);

        // slag
        $slagId = $reeksPerWedstrijdTabel->slagId;
        $slag = $this->wedstrijd_model->getSlagWithID($slagId);

        // wedstrijd
        $wedstrijdId = $reeksPerWedstrijdTabel->wedstrijdId;
        $wedstrijd = $this->wedstrijd_model->get($wedstrijdId);

        $melding->datumStop = $wedstrijd->datumStop;
        $melding->meldingBericht = "Uw inschrijving voor " . $wedstrijd->naam . " reeks " . $afstand->afstand . " " . $slag->slag . " is goedgekeurd.";


//        $dt2 = new DateTime("+1 month");
//        $date = $dt2->format("Y-m-d");
//        $melding->datumStop = $date;
//        $melding->meldingBericht = "Uw inschrijving is goedgekeurd.";
        $this->load->model('trainer/melding_model');
        $newMeldingID = $this->melding_model->insertMelding($melding);

        $meldingPerPersoon->meldingId = $newMeldingID;
        $meldingPerPersoon->persoonId = $inschrijvingTabel->persoonId;
        $this->melding_model->insertMeldingPerPersoon($meldingPerPersoon);

        redirect('/trainer/inschrijving/aanpassen');
    }

    /**
     * Haalt de id=$id op van het te wijzigen inschrijving-record via inschrijving_model en
     * toont de aangepaste lijst in de view inschrijving_aanpassen.php
     * 
     * @param $id De id van de te wijzigen inschrijving
     * @see Inschrijving_model::updateInschrijving()
     */
    public function afkeurenInschrijving($id) {
        $inschrijving = new stdClass();

        $inschrijving->id = $id;
        $inschrijving->status = 0;

        $this->load->model('trainer/inschrijving_model');
        $this->inschrijving_model->updateInschrijving($inschrijving);

        redirect('/trainer/inschrijving/aanpassen');
    }

}
