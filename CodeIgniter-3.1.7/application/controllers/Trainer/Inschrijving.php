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

    public function index() {
        $data['titel'] = 'Inschrijvingen';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();



        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/inschrijving',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
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
     * Haalt de id=$id op van het te wijzigen supplement-record via Supplement_model en
     * toont dit in het formulier in view supplement_lijst.php
     * 
     * @param $id De id van het te wijzigen supplement
     * @see Supplement_model::get()
     */
    public function goedkeurenInschrijving($id) {
        $inschrijving = new stdClass();
        $melding = new stdClass();
        $meldingPerPersoon = new stdClass();
        
        $inschrijving->id = $id;
        $inschrijving->status = 2;
        
        $this->load->model('trainer/inschrijving_model');
        $this->inschrijving_model->updateInschrijving($inschrijving);
        
        //$melding->datumStop = $this->input->post('datumStop');
        $dt2 = new DateTime("+1 month");
        $date = $dt2->format("Y-m-d");
        $melding->datumStop = $date;
        $melding->meldingBericht = "Uw inschrijving is goedgekeurd.";
        $this->load->model('trainer/melding_model');
        $newMeldingID = $this->melding_model->insertMelding($melding);
                
        $meldingPerPersoon->meldingId = $newMeldingID;
        //$meldingPerPersoon->persoonId = $this->input->post('persoonId');
        $persoonId = $this->inschrijving_model->get($id);
        $meldingPerPersoon->persoonId = $persoonId->persoonId;
        $this->melding_model->insertMeldingPerPersoon($meldingPerPersoon);

        redirect('/trainer/inschrijving/aanpassen');
    }

    /**
     * Verwijdert het supplement-record met id=$id via Supplement_model en
     * toont de aangepaste lijst in de view supplement_lijst.php
     *
     * @param $id De id van het supplement-record dat verwijdert wordt
     * @see Supplement_model::deleteSupplement()
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
