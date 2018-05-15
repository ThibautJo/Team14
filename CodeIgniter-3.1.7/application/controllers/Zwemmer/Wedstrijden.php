<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Wedstrijden
 * @brief Controller-klasse voor wedstrijden
 *
 * Controller-klasse met alle methodes die gebruikt worden om wedstrijden te beheren
 */
class Wedstrijden extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Thibaut Joukes     |       Helper: /
    // +----------------------------------------------------------
    // |
    // |    Team controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    public function __construct() {
        parent::__construct();

        // controleren of bevoegde persoon is aangemeld
        if (!$this->authex->isAangemeld()) {
            redirect('welcome/meldAan');
        }

        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "true", "Jolien Lauwers" => "false", "Tom Nuyts" => "false", "Lise Van Eyck" => "true");
    }

    // +----------------------------------------------------------
    // |
    // |    wedstrijd beheren
    // |
    // +----------------------------------------------------------

    /** \brief Haalt alle wedstrijden op.
     *
     * toont de resulterende objecten in de view wedstrijden.php en wedstrijden_aanpassen.php.
     *
     * @see Wedstrijd_model::getWedstrijden()
     * @see wedstrijden.php
     * @see wedstrijden_aanpassen.php
     */
    public function index() {

        $data['titel'] = 'Wedstrijden';
        $data['team'] = $this->data->team;
        $data['persoonAangemeld'] = $this->authex->getPersoonInfo();

        //wedstrijden ophalen van de huidige maand
        $maand = $this->input->get('maand');
        $jaar = $this->input->get('jaar');
        ($maand == null) ? $data['maand'] = 0 : $data['maand'] = $maand;
        ($jaar == null) ? $data['jaar'] = date("Y") : $data['jaar'] = $jaar;

        if ($this->input->get('actie') == "vorige") {
            $jaar -= 1;
            $data["jaar"] = $jaar;
        } else {
            if ($this->input->get('actie') != null) {
                $jaar += 1;
                $data["jaar"] = $jaar;
            }
        }

        $firstDay = null;
        $lastDay = null;
        if ($jaar != null) {
            if ($maand != null && $maand != 0) {
                $date = date_create($jaar . "-" . $maand . "-1");
                $query_date = date_format($date, "Y-m-d");

                // First day of the month.
                $firstDay = date('Y-m-01', strtotime($query_date));

                // Last day of the month.
                $lastDay = date('Y-m-t', strtotime($query_date));
            } else {
                //alle wedstrijden van ander jaren laten zien
                // First day of the year.
                $firstDay = date('Y-m-d', strtotime(date($jaar . '-01-01')));

                // Last day of the year.
                $lastDay = date('Y-m-d', strtotime($jaar . '-12-31'));
            }
        }

        $this->load->model('trainer/wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getWedstrijdenToekomst($firstDay, $lastDay);

        $i = 0;
        foreach ($data['wedstrijden'] as $wedstrijd) {
            $data['wedstrijden'][$i]->personen = $this->wedstrijd_model->getIngeschrevenen($wedstrijd->id);
            $i++;
        }

        $inhoud = "zwemmer/wedstrijden";


        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => $inhoud,
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt alle reeksen van bepaalde wedstrijd op via wedstrijd_model en
     * toont de resulterende objecten in de view ajax_reeksen.php
     * 
     * @see Wedstrijd_model::getReeksPerWedstrijd()
     * @see axaj_reeksen.php
     */
    public function reeksen() {
        $id = $this->input->get('id');

        $this->load->model('trainer/wedstrijd_model');
        $data['reeksen'] = $this->wedstrijd_model->getReeksPerWedstrijd($id);

        $this->load->view("zwemmer/ajax_reeksen", $data);
    }

    /**
     * Slaagt de inschrijving op via Inschrijving_model en
     * toont opnieuw een lijst van alle toekomstige wedstrijden in de view wedstrijden.php
     * 
     * @see Inschrijving_model::insertInschrijving()
     */
    public function opslaanInschrijving() {
        $reeksPerWedstrijd = new stdClass();
        $inschrijving = new stdClass();
        $persoonAangemeld = $this->authex->getPersoonInfo();

        $reeksPerWedstrijd->id = $this->input->post('reeksen');

        $inschrijving->reeksPerWedstrijdId = $reeksPerWedstrijd->id;
        $inschrijving->status = 1;
        $inschrijving->persoonId = $persoonAangemeld->id;

        $this->load->model('trainer/inschrijving_model');
        $this->inschrijving_model->insertInschrijving($inschrijving);

        redirect('/zwemmer/wedstrijden/index');
    }

}
