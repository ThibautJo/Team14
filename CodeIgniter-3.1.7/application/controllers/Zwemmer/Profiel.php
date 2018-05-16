<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller-klasse met alle methodes de gebruikt worden om zwemmers profiel te beheren.
 *
 * @class Profiel
 * @brief Controller-klasse voor Profiel
 * @author Klaus
 */
class Profiel extends CI_Controller {
    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Klaus Daems     |       Helper: /
    // +----------------------------------------------------------
    // |
    // |    Profiel controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        // controleren of persoon is aangemeld
        if (!$this->authex->isAangemeld()) {
            redirect('welcome/meldAan');
        }

        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "true", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");

        // Aantal meldingen laten zien
        $this->load->model('zwemmer/melding_model');
        $persoon = $this->authex->getPersoonInfo();
        $persoonId = $persoon->id;
        $meldingen = $this->melding_model->getMeldingByPersoon($persoonId);
        $this->data->aantalMeldingen = count($meldingen);
    }

    /**
     * Haalt de gegevens van de ingelogde persoon op via Profiel_model en
     * toont de resulterende objecten in de view profiel.php
     *
     * @see Profiel_model::getProfielByPersoon()
     * @see profiel.php
     */
    public function index() {
        $data['titel'] = 'Profiel zwemmer';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
        $data['aantalMeldingen'] = $this->data->aantalMeldingen;

        $persoonAangemeld = $this->authex->getPersoonInfo();
        $persoonId = $persoonAangemeld->id;

        $this->load->model("zwemmer/profiel_model");
        $profiel = $this->profiel_model->getProfielByPersoon($persoonId);
        $data['profiel'] = $profiel;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'zwemmer/profiel',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Slaagt het aangepaste profiel op via Profiel_model en 
     * toont de aangepaste lijst in de view profiel.php
     *
     * @see Profiel_model::update($profielGegevens);
     */
    public function profielOpslaan() {
        $profielGegevens = new stdClass();

        $profielGegevens->voornaam = $this->input->post('voornaam');
        $profielGegevens->achternaam = $this->input->post('achternaam');
        $profielGegevens->straat = $this->input->post('straat');
        $profielGegevens->huisnummer = $this->input->post('huisnummer');
        $profielGegevens->postcode = $this->input->post('postcode');
        $profielGegevens->gemeente = $this->input->post('gemeente');
        $profielGegevens->email = $this->input->post('email');
        $profielGegevens->omschrijving = $this->input->post('omschrijving');

        $this->load->model('zwemmer/profiel_model');

        $profielGegevens->id = $this->input->post('id');
        $this->profiel_model->update($profielGegevens);

        redirect('Zwemmer/Profiel');
    }

}
