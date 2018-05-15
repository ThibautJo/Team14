<?php

defined('BASEPATH') OR exit('No direct script access allowed');

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Jolien Lauwers       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Startpagina controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

/**
 * @class Startpagina
 * @brief Controller-klasse voor startpaginaitem
 * 
 * Controller-klasse met alle methodes die gebruikt worden voor startpaginaitems
 */

class Startpagina extends CI_Controller {

    public function __construct() {

        parent::__construct();
        
        /**
        * Controleert of bevoegde persoon is aangemeld.
        * Indien deze niet aangemeld of bevoegd is, wordt hij doorverwezen naar de loginpagina.
        */
        
        if (!$this->authex->isAangemeld()) {
            redirect('welcome/meldAan');
        } else {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->soort != "Trainer") {
                redirect('welcome/meldAan');
            }
        }

        /**
        * Laadt de auteur van deze code in de footer.
        */
        
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "true", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }


    public function index() {
        
       /**
       * Haalt alle startpaginaitems op via startpaginaitem_model en toont de resulterende objecten in de view startpagina_beheren.php
       * 
       * @see StartpaginaItem_model::getStartpaginaItem()
       * @see startpagina_beheren.php
       */

       $data['titel'] = 'Startpagina beheren';
       $data['team'] = $this->data->team;
       $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

       
       $this->load->model('trainer/startpaginaitem_model');
       $data['startpaginaitems'] = $this->startpaginaitem_model->getStartpaginaItem();
         

       $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/startpagina_beheren',
            'voetnoot' => 'main_footer');

       $this->template->load('main_master', $partials, $data);

    }


}
