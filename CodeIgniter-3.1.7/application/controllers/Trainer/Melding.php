<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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

        // Helpers inladen
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('my_html_helper');
        $this->load->helper('my_form_helper');
        
        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "true");
    }

    public function index() {
        $data['titel'] = 'Meldingen';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

        $this->load->model('trainer/melding_model');
        $data['meldingen'] = $this->melding_model->getMeldingen();
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/melding',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    public function beheren() {
        $data['titel'] = 'Meldingen';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

        $this->load->model('trainer/melding_model');
       // $data['meldingen'] = $this->melding_model->getMeldingen();
                
        $data['meldingen'] = $this->melding_model->getMeldingPerPersoon();
        
//        $i = 0;
//        foreach ($data['meldingen'] as $melding) {
//            $data['meldingen'][$i]->personen = $this->melding_model->getMeldingPerPersoon();
//            $i++;
//        }
//        
//        var_dump($data['meldingen'][0]);


        $this->load->model('trainer/zwemmers_model');
        $data['zwemmers'] = $this->zwemmers_model->getZwemmers();
        
        $partials = array('hoofding' => 'main_header',
            'menu' => 'trainer_main_menu',
            'inhoud' => 'trainer/melding_aanpassen',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Haalt de id=$id op van het te wijzigen melding-record via Melding_model
     *
     * @param $id De id van het te wijzigen melding
     */
    public function wijzigMelding($id) {
        $data = new stdClass();

        $this->load->model('trainer/melding_model');
        
        $data = $this->melding_model->get($id);

//        $this->load->model('trainer/supplementfunctie_model');
//        $data['functies'] = $this->supplementfunctie_model->getAllByFunctie();

        print json_encode($data);
    }
    
    /**
     * Verwijdert het melding-record met id=$id via Melding_model en toont de aangepaste lijst in de view melding_aanpassen.php
     *
     * @param $id De id van het melding-record dat verwijdert wordt
     * @see Melding_model::delete()
     */
    public function verwijderMelding($id) {
        $this->load->model('trainer/melding_model');
        $this->melding_model->delete($id);

        redirect('/trainer/melding/beheren');
    }
    
    /**
     * Slaagt het nieuw/aangepaste melding op via Melding_model en toont de aangepaste lijst in de view melding_aanpassen.php
     *
     * @see Supplementfunctie_model::get();
     * @see Melding_model::insert();
     * @see Melding_model::update();
     */
    public function opslaanMelding($actie = "toevoegen") {
        $melding = new stdClass();

       // $supplement->ID = $this->input->post('id');
        $melding->datumStop = $this->input->post('datumStop');
        $melding->meldingBericht = ucfirst($this->input->post('inhoud'));

        $persoonId = $this->input->post('aan');
        $this->load->model('persoon_model');
        $persoon = $this->persoon_model->get($persoonId);
        $melding->persoonId = $persoon->id;

        $this->load->model('trainer/melding_model');

//        if($supplement->ID == 0) {
        if($actie == "toevoegen") {
            $this->melding_model->insert($melding);
        } else {
            $melding->id = $this->input->post('id');
            $this->melding_model->update($melding);
        }

       redirect('/trainer/melding/beheren');

    }
    
}
