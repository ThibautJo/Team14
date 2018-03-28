<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Supplement
 * @brief Controller-klasse voor supplement
 * 
 * Controller-klasse met alle methodes die gebruikt worden om supplementen te beheren
 */

class Supplement extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |
    // |    Supplement controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    /**
     * Constructor
     */
    
    public function __construct() {

        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('MY_html_helper');
    }

    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper: /
    // +----------------------------------------------------------
    // |
    // |    Supplementen beheren
    // |
    // +----------------------------------------------------------

    /**
     * Haalt alle supplementen namen op via Supplement_model en toont de resulterende objecten in de view supplementen_lijst.php
     * 
     * @see Supplement_model::getAllByNaamSupplementWithFunctie()
     * @see supplement_lijst.php
     */
    public function index() {
        $data['titel'] = 'Supplementen beheren';

       $this->load->model('trainer/supplement_model');
       //$data['supplementen'] = $this->supplement_model->getAllByNaamSupplement();
       $data['supplementen'] = $this->supplement_model->getAllByNaamSupplementWithFunctie();
       
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/supplement_lijst',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
  
    /**
     * Haalt de id=$id op van het te wijzigen supplement-record via Supplement_model 
     * en alle supplementfuncties via Supplementfunctie_model en toont de objecten in de view supplement_form.php
     * 
     * @param $id De id van het te wijzigen supplement
     * @see Supplement_model::get();
     * @see Supplementfunctie_model::getAllByFunctie();
     * @see supplement_form.php
     */
    public function wijzig($id) {
        $this->load->model('trainer/supplement_model');
        $data['supplement'] = $this->supplement_model->get($id);
        $data['titel'] = 'Supplement wijzigen';
        
        $this->load->model('trainer/supplementfunctie_model');
        $data['functies'] = $this->supplementfunctie_model->getAllByFunctie();
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/supplement_form',
            'voetnoot' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Verwijdert het supplement-record met id=$id via Supplement_model en toont de aangepaste lijst in de view supplement_lijst.php
     * 
     * @param $id De id van het supplement-record dat verwijdert wordt
     * @see Supplement_model::delete()
     */
    public function schrap($id) {
        $this->load->model('trainer/supplement_model');
        $data['supplement'] = $this->supplement_model->delete($id);
        
        redirect('/trainer/supplement/index');
    }
    
    /**
     * Haalt een leeg supplement op uit deze controller en haalt alle supplementfuncties op via Supplementfunctie_model en toont de objecten in de view supplement_form.php
     * 
     * @see ::getEmptySupplement();
     * @see Supplementfunctie_model::getAllByFunctie();
     * @see supplement_form.php
     */
    public function maakNieuwe() {
        $data['supplement'] = $this->getEmptySupplement();
        $data['titel'] = 'Supplement toevoegen';
        
        $this->load->model('trainer/supplementfunctie_model');
        $data['functies'] = $this->supplementfunctie_model->getAllByFunctie();
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/supplement_form',
            'voetnoot' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Maakt een leeg supplement
     * @return $supplement;
     */
    function getEmptySupplement() {
        $supplement = new stdClass();
        
        $supplement->ID = 0;
        $supplement->Naam = '';
        $supplement->Omschrijving = '';
        $supplement->FunctieId = 0;
        
        return $supplement;
    }
    
    /**
     * Slaagt het nieuw/aangepaste supplement op via Supplement_model en toont de aangepaste lijst in de view supplement_lijst.php
     * 
     * @see Supplementfunctie_model::get();
     * @see Supplement_model::insert();
     * @see Supplement_model::update();
     */
    public function registreer() {
        $supplement = new stdClass();
        
        $supplement->ID = $this->input->post('id');
        $supplement->Naam = $this->input->post('naam');
        $supplement->Omschrijving = $this->input->post('omschrijving');
        
        $functieId = $this->input->post('FunctieId');
        $this->load->model('trainer/supplementfunctie_model');
        $functie = $this->supplementfunctie_model->get($functieId);
        $supplement->FunctieId = $functie->ID;
        
        $this->load->model('trainer/supplement_model');
        
        if($supplement->ID == 0) {
            $this->supplement_model->insert($supplement);
        } else {
            $this->supplement_model->update($supplement);
        }
        
        redirect('/trainer/supplement/index');
    }
      
}
