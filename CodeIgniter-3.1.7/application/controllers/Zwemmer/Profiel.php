<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller-klasse met alle methodes de gebruikt worden om zwemmers profiel te beheren.
 *
 * @class Profiel
 * @brief Controller-klasse voor Profiel
 * @author Klaus
 */
class Profiel extends CI_Controller{
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
        redirect('welcome/meldAan');}

        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "true", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }
    
    /**
     * Haalt de gegevens van de ingelogde persoon op via Profiel_model en
     * toont de resulterende objecten in de view profiel.php
     *
     * @see Profiel_model::getProfielByPersoon()
     * @see profiel.php
     */
    public function index(){
        $data['titel'] = 'Profiel zwemmer';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

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

}
