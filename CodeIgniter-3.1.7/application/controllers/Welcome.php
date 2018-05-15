<?php

  // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Jolien Lauwers  |       Helper: 
    // +----------------------------------------------------------
    // |
    // |    Welcome controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

/**
 * @class Welcome
 * @brief Controller-klasse voor aanmelden en homepagina
 * 
 * Controller-klasse met alle methodes die gebruikt worden voor aanmelden van gebruikers
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        
        parent::__construct();
        
        /**
        * Laadt de auteur van deze code in de footer.
        */
        
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "true", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    public function index() {
        
       /**
       * Haalt verschillende zwemmers op via zwemmers_model en toont de resulterende objecten in de view bezoeker_main_master.php
       * 
       * @see Zwemmers_model::getLadenTeam ?? ()
       */
        
        $data['titel'] = 'Home';
        $data['team'] = $this->data->team;
        $data['persoon'] = $this->authex->getPersoonInfo();
        
        $zwemmers = $this->ladenTeam();        
        $data['zwemmers'] = $zwemmers;
        
        $this->load->model('trainer/startpaginaitem_model');
        $data['startpaginaitems'] = $this->startpaginaitem_model->getStartpaginaItem();
                       
        $this->load->model('trainer/wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAlleWedstrijden();         

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'aanmeldFormulier' => 'bezoeker/home_aanmelden',
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }

    public function meldAan()
    {
        $data['titel'] = 'Aanmelden';
        $data['team'] = $this->data->team;
        $data['persoon']  = $this->authex->getPersoonInfo();

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'aanmeldFormulier' => 'bezoeker/home_aanmelden',
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }

    public function toonFout()
    {
        $data['titel'] = 'Fout';
        $data['team'] = $this->data->team;
        $data['persoon']  = $this->authex->getPersoonInfo();
        $data['foutBoodschap'] = "De combinatie van het email-adres en wachtwoord is foutief! Probeer opnieuw.";

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'aanmeldFormulier' => 'bezoeker/home_fout',
            'foutMelding' => 'bezoeker/home_fout',
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }

    public function controleerAanmelden()
    {
        $email = $this->input->post('email');
        $wachtwoord = $this->input->post('wachtwoord');

        if ($this->authex->meldAan($email, $wachtwoord)) {

            $persoon = $this->authex->getPersoonInfo();

            // controleren welk soort gebruiker zich aanmeldt
            switch ($persoon->soort) {
                case "Trainer":
                    redirect('Trainer/supplement');
                    break;
                case "Zwemmer":
                    redirect('Zwemmer/agenda');
                    break;
            }

        } else {
            redirect('Welcome/toonFout');
        }
    }

    public function meldAf()
    {
        $this->authex->meldAf();
        redirect('Welcome');
    }
    
    public function ladenTeam(){
        
        $this->load->model("trainer/zwemmers_model");
        $zwemmers = $this->zwemmers_model->getTeam();
        
        $data_zwemmers = array();
        foreach ($zwemmers as $zwemmer) {                    
            $data_zwemmers[] = array(
                "voornaam" => $zwemmer->voornaam,
                "achternaam" => $zwemmer->achternaam,
                "omschrijving" => $zwemmer->omschrijving,
                "foto" => $zwemmer->foto,
            );
        }
        return $zwemmers;
    }

}
