<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
  
    
    public function wijzig($id) {
        $this->load->model('trainer/supplement_model');
        $data['supplement'] = $this->supplement_model->get($id);
        $data['titel'] = 'Supplement wijzigen';
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/supplement_form',
            'voetnoot' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function schrap($id) {
        $this->load->model('trainer/supplement_model');
        $data['supplement'] = $this->supplement_model->delete($id);
        
        redirect('/trainer/supplement/index');
    }
    
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
    
    function getEmptySupplement() {
        $supplement = new stdClass();
        
        $supplement->ID = 0;
        $supplement->Naam = '';
        $supplement->Omschrijving = '';
        
        return $supplement;
    }
    
    public function registreer() {
        $supplement = new stdClass();
        
        $supplement->ID = $this->input->post('id');
        $supplement->Naam = $this->input->post('naam');
        $supplement->Omschrijving = $this->input->post('omschrijving');
        
        $functieId = $this->input->post('functie');
        $this->load->model('trainer/supplementfunctie_model');
        $functie = $this->supplementfunctie_model->get($functieId);
        $supplement->functie = $functie->Functie;
        
        $this->load->model('trainer/supplement_model');
        
        if($supplement->ID == 0) {
            $this->supplement_model->insert($supplement);
        } else {
            $this->supplement_model->update($supplement);
        }
        
        redirect('/trainer/supplement/index');
    }
      
}
