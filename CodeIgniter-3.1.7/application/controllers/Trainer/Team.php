<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller-klasse met alle methodes die gebruikt worden om zwemmers(personen) te beheren
 * 
 * @class Team
 * @brief Controller-klasse voor team
 * @author Klaus
 */

class Team extends CI_Controller {

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
        $this->data->team = array("Klied Daems" => "true", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    // +----------------------------------------------------------
    // |
    // |    Zwemmers beheren
    // |
    // +----------------------------------------------------------

    /**
     * Haalt alle personen op via Zwemmers_model en
     * toont de resulterende objecten in de view team_lijst.php
     *
     * @see Zwemmers_model::getZwemmers()
     * @see team_lijst.php
     */
    public function index() {

        $data['titel'] = 'Team beheren';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
        $zwemmers = $this->ladenTeam();

        $data['zwemmers'] = $zwemmers;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/team_lijst',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt de gegevens op van de personen via Zwemmers_model en
     * stopt de resulterende objecten in een array $zwemmers
     *
     * @see Zwemmers_model::getTeam()
     * @return type $zwemmers
     */
    public function ladenTeam(){
        
        $this->load->model("trainer/zwemmers_model");
        $personen = $this->zwemmers_model->getTeam();

        $data_personen = array();
        foreach ($personen as $persoon) {
            $data_personen[] = array(
                "voornaam" => $persoon->voornaam,
                "achternaam" => $persoon->achternaam,
                "straat" => $persoon->straat,
                "huisnummer" => $persoon->huisnummer,
                "postcode" => $persoon->postcode,
                "gemeente" => $persoon->gemeente,
                "telefoonnummer" => $persoon->telefoonnummer,
                "email" => $persoon->email,
                "wachtwoord" => $persoon->wachtwoord,
                "omschrijving" => $persoon->omschrijving,
                "foto" => $persoon->foto,
                "color" => '#FF7534',"textColor" => '#000'
            );
        }
        return $personen;
    }
    
    /**
     * Haalt de gegevens op van de personen(zwemmers) die inactief staan -> (actief = 0) via Zwemmers_model en
     * stopt de resulterende objecten in een array $zwemmersuitarchief
     *
     * @see Zwemmers_model::getZwemmersArchief()
     * @return type $zwemmersuitarchief
     */
    public function ladenArchief(){

        $this->load->model("trainer/zwemmers_model");
        $zwemmersuitarchief = $this->zwemmers_model->getZwemmersArchief();

        $data_zwemmersuitarchief = array();
        foreach ($zwemmersuitarchief as $zwemmeruitarchief) {
            $data_zwemmersuitarchief[] = array(
                "id" => $zwemmeruitarchief->id,
                "voornaam" => $zwemmeruitarchief->voornaam,
                "achternaam" => $zwemmeruitarchief->achternaam,
                "straat" => $zwemmeruitarchief->straat,
                "huisnummer" => $zwemmeruitarchief->huisnummer,
                "postcode" => $zwemmeruitarchief->postcode,
                "gemeente" => $zwemmeruitarchief->gemeente,
                "telefoonnummer" => $zwemmeruitarchief->telefoonnummer,
                "email" => $zwemmeruitarchief->email,
                "wachtwoord" => $zwemmeruitarchief->wachtwoord,
                "omschrijving" => $zwemmeruitarchief->omschrijving,
                "foto" => $zwemmeruitarchief->foto
            );
        }
        return $zwemmersuitarchief;
    }
    /**
     * Haalt alle personen op via de methode ladenTeam() en ladenArchief() deze
     * resulterende objecten kan men in de view team_lijst.php gebruiken
     *
     * @see Zwemmers_model::getTeam()
     * @see Zwemmers_model::getZwemmersArchief()
     * @see team_aanpassen.php
     */
    public function aanpassen() {

        $data['titel'] = 'Team beheren';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
        $personen = $this->ladenTeam();
        $data['personen'] = $personen;

        $zwemmersuitarchief = $this->ladenArchief();
        $data['zwemmersuitarchief'] = $zwemmersuitarchief;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/team_aanpassen',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt alle personen op via Zwemmers_model en
     * toont de resulterende objecten in de view team_lijst.php
     *
     * @see Zwemmers_model::getZwemmers()
     * @see team_aanpassen.php
     */
    public function wijzig() {
        $data['titel'] = 'Team wijzigen';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
        $personen = $this->ladenTeam();
        $data['personen'] = $personen;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/team_aanpassen',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Archiveert de persoon met id=$id via het Zwemmers_model en
     * toont de aangepaste lijst in de vew team.php
     * 
     * @see Zwemmers_model::archiveer()
     * @see team.php
     */
    public function archiveren($id) {
        $this->load->model('trainer/zwemmers_model');
        $this->zwemmers_model->archiveer($id);

        redirect('trainer/team');
    }
    
    /**
     * Haalt het gearchiveerde persoon op via Zwemmers_model en
     * toont de aangepaste lijst in de view team.php
     *
     * @see Zwemmers_model::uitArchiefHalen()
     * @see team.php
     */
    public function opslaanZwemmerUitArchiefHalen() {
        $persoon = new stdClass();

        $this->load->model('trainer/zwemmers_model');

        $persoon->id = $this->input->post('archief');
        $this->zwemmers_model->uitArchiefHalen($persoon);

        redirect('trainer/team');
    }

    /**
     * Slaagt het nieuw/aangepaste persoon op via Zwemmers_model en 
     * toont de aangepaste lijst in de view team_lijst.php
     *
     * @see Zwemmers_model::insert($persoon);
     * @see Zwemmers_model::update($persoon);
     */
    public function opslaanPersoon($actie = "toevoegen")
    {
        $persoon = new stdClass();

        // $persoon->id=$this->input->post('id');
        $persoon->voornaam=$this->input->post('voornaam');
        $persoon->achternaam=$this->input->post('achternaam');
        $persoon->email=$this->input->post('email');
        $persoon->wachtwoord=$this->input->post('wachtwoord');
        $persoon->omschrijving=$this->input->post('omschrijving');
        $persoon->soort=$this->input->post('soort');

        $this->load->model('trainer/zwemmers_model');
        //        if($persoon->ID == 0) {
        if($actie == "toevoegen") {
            $this->zwemmers_model->insert($persoon);
        } else {
            $persoon->id = $this->input->post('id');
            $this->zwemmers_model->update($persoon);
        }
        redirect('trainer/team');
    }

    /**
     * Haalt de id=$id op van het te wijzigen persoon-record via Zwemmers_model
     * en toont de objecten in de view team_aanpassen.php
     *
     * @param $id De id van het te wijzigen zwemmer(persoon)
     * @see Zwemmers_model::get();
     * @see team_aanpassen.php
     */
    public function wijzigPersoon($id) {
        $data = new stdClass();

        $this->load->model('trainer/zwemmers_model');
        $data = $this->zwemmers_model->get($id);

        print json_encode($data);
    }
    
}
