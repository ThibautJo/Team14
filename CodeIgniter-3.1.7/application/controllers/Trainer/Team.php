<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Team
 * @brief Controller-klasse voor team
 *
 * Controller-klasse met alle methodes die gebruikt worden om zwemmers(personen) te beheren
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
        
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("MY_form_helper");
        $this->load->helper("MY_html_helper");
        $this->load->helper("MY_url_helper");
        
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
     * Haalt de gegevens op van de zwemmers(personen) via Zwemmers_model en
     * stopt de resulterende objecten in een array $zwemmers
     * 
     * @see Zwemmers_model::getZwemmers()
     * @return type $zwemmers
     */
    public function ladenTeam(){
        
        $this->load->model("trainer/zwemmers_model");
        $zwemmers = $this->zwemmers_model->getTeam();
        
        $data_zwemmers = array();
        foreach ($zwemmers as $zwemmer) {                    
            $data_zwemmers[] = array(
                "voornaam" => $zwemmer->voornaam,
                "achternaam" => $zwemmer->achternaam,
                "straat" => $zwemmer->straat,
                "huisnummer" => $zwemmer->huisnummer,
                "postcode" => $zwemmer->postcode,
                "gemeente" => $zwemmer->gemeente,
                "telefoonnummer" => $zwemmer->telefoonnummer,
                "email" => $zwemmer->email,
                "wachtwoord" => $zwemmer->wachtwoord,
                "omschrijving" => $zwemmer->omschrijving,
                "foto" => $zwemmer->foto,
                "color" => '#FF7534',"textColor" => '#000'
            );
        }
        return $zwemmers;
    }
    
    public function ladenArchief(){
        
        $this->load->model("trainer/zwemmers_model");
        $zwemmersuitarchief = $this->zwemmers_model->getZwemmersArchief();
        
        $data_zwemmersuitarchief = array();
        foreach ($zwemmersuitarchief as $zwemmeruitarchief) {                    
            $data_zwemmersuitarchief[] = array(
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
                "foto" => $zwemmeruitarchief->foto,
                "color" => '#FF7534',"textColor" => '#000'
            );
        }
        return $zwemmersuitarchief;
    }
    /**
     * Haalt alle personen op via Zwemmers_model en
     * toont de resulterende objecten in de view team_lijst.php
     *
     * @see Zwemmers_model::getZwemmers()
     * @see team_aanpassen.php
     */
    public function aanpassen() {
        
        $data['titel'] = 'Team beheren';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
        $zwemmers = $this->ladenTeam();
        $data['zwemmers'] = $zwemmers;
        
        $zwemmersuitarchief = $this->ladenArchief();
        $data['zwemmersuitarchief'] = $zwemmersuitarchief;
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/team_aanpassen',
            'voetnoot' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    
    public function wijzig() {
        $data['titel'] = 'Team wijzigen';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
        $zwemmers = $this->ladenTeam();
        $data['zwemmers'] = $zwemmers;
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/team_aanpassen',
            'voetnoot' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function archiveren($id) {
        $this->load->model('trainer/zwemmers_model');
        $this->zwemmers_model->archiveer($id);
        
        redirect('trainer/team');
    }
    
    public function uitArchiefHalen($id) {
        $this->load->model('trainer/zwemmers_model');
        $this->zwemmers_model->uitArchiefHalen($id);
        
        redirect('trainer/team');
    }
    
    
    /**
     * Slaagt het nieuw/aangepaste zwemmer op via Zwemmers_model en toont de aangepaste lijst in de view team_lijst.php
     *
     * @see Zwemmers_model::insert($persoon);
     * @see Zwemmers_model::update($persoon);
     */
    public function opslaanZwemmer($actie = "toevoegen")
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
    public function wijzigZwemmer($id) {
        $data = new stdClass();

        $this->load->model('trainer/zwemmers_model');
        $data = $this->zwemmers_model->get($id);

        print json_encode($data);
    }
}
