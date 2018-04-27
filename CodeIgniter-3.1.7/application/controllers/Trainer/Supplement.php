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
        $this->load->helper('my_html_helper');
        $this->load->helper('my_form_helper');

        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "true");

    }

    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper: /
    // +----------------------------------------------------------
    // |
    // |    Supplementen beheren
    // |
    // +----------------------------------------------------------

    /**
     * Haalt alle supplementen namen op via Supplement_model en
     * haalt alle functies op via Supplementfunctie_model en
     * toont de resulterende objecten in de view supplementen_lijst.php
     *
     * @see Supplement_model::getAllByNaamSupplementWithFunctie()
     * @see Supplement_model::getAllByFunctie()
     * @see supplement_lijst.php
     */
    public function index() {
        $data['titel'] = 'Supplementen beheren';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();


        $this->load->model('trainer/supplement_model');
        $data['supplementen'] = $this->supplement_model->getAllByNaamSupplementWithFunctie();

        $this->load->model('trainer/supplementfunctie_model');
        $data['functies'] = $this->supplementfunctie_model->getAllByFunctie();

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
    public function wijzigSupplement($id) {
        $data = new stdClass();

        $this->load->model('trainer/supplement_model');
        $data = $this->supplement_model->get($id);

//        $this->load->model('trainer/supplementfunctie_model');
//        $data['functies'] = $this->supplementfunctie_model->getAllByFunctie();

        print json_encode($data);
    }

    /**
     * Verwijdert het supplement-record met id=$id via Supplement_model en toont de aangepaste lijst in de view supplement_lijst.php
     *
     * @param $id De id van het supplement-record dat verwijdert wordt
     * @see Supplement_model::delete()
     */
    public function verwijderSupplement($id) {
        $this->load->model('trainer/supplement_model');
        $this->supplement_model->delete($id);

        redirect('/trainer/supplement/index');
    }

    /**
     * Slaagt het nieuw/aangepaste supplement op via Supplement_model en toont de aangepaste lijst in de view supplement_lijst.php
     *
     * @see Supplementfunctie_model::get();
     * @see Supplement_model::insert();
     * @see Supplement_model::update();
     */
    public function opslaanSupplement($actie = "toevoegen") {
        $supplement = new stdClass();

       // $supplement->ID = $this->input->post('id');
        $supplement->naam = ucfirst($this->input->post('naam'));
        $supplement->omschrijving = lcfirst($this->input->post('omschrijving'));

        $functieId = $this->input->post('functie');
        $this->load->model('trainer/supplementfunctie_model');
        $functie = $this->supplementfunctie_model->get($functieId);
        $supplement->supplementFunctieId = $functie->id;

        $this->load->model('trainer/supplement_model');

//        if($supplement->ID == 0) {
        if($actie == "toevoegen") {
            $this->supplement_model->insert($supplement);
        } else {
            $supplement->id = $this->input->post('id');
            $this->supplement_model->update($supplement);
        }

       redirect('/trainer/supplement/index');

    }

}
