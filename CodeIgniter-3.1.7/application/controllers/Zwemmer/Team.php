<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller-klasse met alle methodes de gebruikt worden om zwemmers team te beheren.
 *
 * @class Team
 * @brief Controller-klasse voor Team
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

        // controleren of persoon is aangemeld
        if (!$this->authex->isAangemeld()) {
        redirect('welcome/meldAan');}
        
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
     * Haalt de gegevens van de zwemmers op via de methode ladenTeam() en
     * toont de resulterende objecten in de view team.php
     *
     * @see ladenTeam()
     * @see team.php
     */
    public function index() {

        $data['titel'] = 'Team';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();
        $data['aantalMeldingen'] = $this->data->aantalMeldingen;
        $zwemmers = $this->ladenTeam();

        $data['zwemmers'] = $zwemmers;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'zwemmer/team',
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
        $zwemmers = $this->zwemmers_model->getZwemmers();

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
    
    /**
     * Haalt de gegevens op van de zwemmer id=$id via Zwemmers_model en
     * returned de resulterende objecten via $data
     * 
     * $see Zwemmers_model::get()
     * $return type $data
     */
    public function profielTonen($id) {
        $this->load->model('trainer/zwemmers_model');
        $data = $this->zwemmers_model->get($id);

        print json_encode($data);
    }
}
