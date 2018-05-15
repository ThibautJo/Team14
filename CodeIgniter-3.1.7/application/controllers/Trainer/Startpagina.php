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
* @brief Controller-klasse voor startpaginaItems
* 
* Controller-klasse met alle methodes die gebruikt worden voor startpaginaItems weer te geven.
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
        * Laadt de auteur van de geschreven code van deze pagina in de footer.
        */
        
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "true", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    public function index() {

        /**
        * Haalt alle startpaginaItems op via startpaginaItem_model en toont de resulterende objecten in de view startpagina_beheren.php
        * 
        * @see startpaginaItem_model::getStartpaginaItem()
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

    public function wijzigStartpaginaItem($id) {

        /**
        * Haalt de id=$id op van het te wijzigen startpaginaitem-record via startpaginaitem_model en
        * toont dit in het formulier in view startpagina_beheren.php
        * 
        * @param $id De id van het te wijzigen startpaginaitem
        * @see startpaginaItem_model::getStartpaginaItemMetId($id)
        * @see startpagina_beheren.php
        */
        
        $data = new stdClass();

        $this->load->model('trainer/startpaginaitem_model');
        $data = $this->startpaginaitem_model->getStartpaginaItemMetId($id);

        print json_encode($data);
    }

    public function opslaanStartpaginaItem($actie = "toevoegen") {

        /**
        * Slaagt het nieuw/aangepaste startpaginaItem op via startpaginaItem_model en
        * toont de aangepaste lijst in de view startpaginaitem_beheren.php
        *
        * @param $actie De vereiste actie die moet worden opgevangen voor het opslaan van startpaginaitems
        * @see startpaginaItem_model::insertStartpaginaItem()
        * @see startpaginaItem_model::updateStartpaginaItem()
        * @see startpagina_beheren.php
        */
        
        $startpaginaitem = new stdClass();

        $startpaginaitem->titel = ucfirst($this->input->post('titel'));
        $startpaginaitem->inhoud = lcfirst($this->input->post('inhoud'));

        $this->load->model('trainer/startpaginaitem_model');

        if ($actie == "toevoegen") {
            $this->startpaginaitem_model->insertStartpaginaItem($startpaginaitem);
        } else {
            $startpaginaitem->id = $this->input->post('id');
            $this->startpaginaitem_model->updateStartpaginaItem($startpaginaitem);
        }

        redirect('/trainer/startpagina/index');
    }

    public function verwijderStartpaginaItem($id) {

        /**
        * Verwijdert het startpaginaitem-record met id=$id via startpaginaItem_model en
        * toont de aangepaste lijst in de view startpaginaitem_beheren.php
        *
        * @param $id De id van het startpaginaitem-record dat verwijdert wordt
        * @see startpaginaItem_model::deleteStartpaginaItem()
        */
        
        $this->load->model('trainer/startpaginaitem_model');
        $this->startpaginaitem_model->deleteStartpaginaItem($id);

        redirect('/trainer/startpagina/index');
    }

}
