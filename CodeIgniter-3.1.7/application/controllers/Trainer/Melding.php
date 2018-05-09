<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Melding
 * @brief Controller-klasse voor melding
 * 
 * Controller-klasse met alle methodes die gebruikt worden voor meldingen
 */

class Melding extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Melding controller
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
     * Haalt alle meldingen per persoon op via melding_model en toont de resulterende objecten in de view melding.php
     * 
     * @see Melding_model::getMeldingPerPersoon()
     * @see melding.php
     */
    public function index() {

        $data['titel'] = 'Meldingen';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

        $this->load->model('trainer/melding_model');
        $data['meldingen'] = $this->melding_model->getMeldingPerPersoon();

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/melding',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt alle meldingen per persoon op via melding_model en 
     * haalt alle zwemmers op via zwemmers_model en
     * toont de resulerende objecten in de view melding_aanpassen.php
     * 
     * @see Melding_model::getMeldingPerPersoon()
     * @see Zwemmers_model::getZwemmers()
     * @see melding_aanpassen.php
     */
    public function beheren() {
        $data['titel'] = 'Meldingen';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

        $this->load->model('trainer/melding_model');

        $data['meldingen'] = $this->melding_model->getMeldingPerPersoon();
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

        $this->load->model('trainer/zwemmers_model');
        $data['zwemmers'] = $this->zwemmers_model->getZwemmers();

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/melding_aanpassen',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt de id=$id op van het te wijzigen melding-record via Melding_model en
     * toont dit in het formulier in view melding_aanpassen.php
     *
     * @param $id De id van de te wijzigen melding
     * @see Melding_model::get()
     */
    public function wijzigMelding($id) {
        $data = new stdClass();

        $this->load->model('trainer/melding_model');

        $data = $this->melding_model->get($id);

        print json_encode($data);
    }

    /**
     * Verwijdert het meldingPerPersoon-record met id=$id via Melding_model en
     * toont de aangepaste lijst in de view melding_aanpassen.php
     *
     * @param $id De id van het meldingPerPersoon-record dat verwijdert wordt
     * @see Melding_model::deleteMeldingPerPersoon()
     */
    public function verwijderMelding($id) {
        $this->load->model('trainer/melding_model');
        $this->melding_model->deleteMeldingPerPersoon($id);

        redirect('/trainer/melding/beheren');
    }

    /**
     * Slaagt het nieuw/aangepaste melding op via Melding_model en
     * toont de aangepaste lijst in de view melding_aanpassen.php
     *
     * @see Zwemmers_model::get()
     * @see Melding_model::insertMelding()
     * @see Melding_model::insertMeldingPerPersoon()
     * @see Melding_model::getMelding()
     * @see Melding_model::updateMelding()
     * @see Melding_model::updateMeldingPerPersoon()
     */
    public function opslaanMelding($actie = "toevoegen") {
        $melding = new stdClass();
        $meldingPerPersoon = new stdClass();

        $melding->datumStop = $this->input->post('datumStop');
        $melding->meldingBericht = ucfirst($this->input->post('inhoud'));
        
        $persoonId = $this->input->post('aan');
        $this->load->model('trainer/zwemmers_model');
        $persoon = $this->zwemmers_model->get($persoonId);
        $meldingPerPersoon->persoonId = $persoon->id;

        $this->load->model('trainer/melding_model');

        if($actie == "toevoegen") {
            $newMeldingID = $this->melding_model->insertMelding($melding);
            $this->load->model('trainer/melding_model');
            $meldingPerPersoon->meldingId = $newMeldingID;
            $this->melding_model->insertMeldingPerPersoon($meldingPerPersoon);
        } else {
            $melding->id = $this->input->post('id');
            $meldingId = $this->input->post('id');
            $this->load->model('trainer/melding_model');
            $meldingMelding = $this->melding_model->getMelding($meldingId);
            $meldingPerPersoon->meldingId = $melding->id;
            $this->melding_model->updateMelding($melding);
            $this->melding_model->updateMeldingPerPersoon($meldingPerPersoon);
        }

       redirect('/trainer/melding/beheren');

    }

}
