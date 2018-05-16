<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
 * @brief Controller-klasse voor aanmelden en homepagina.
 * 
 * Controller-klasse met methodes die gebruikt worden voor aanmelden van gebruikers en het weergeven van de homepagina.
 */

class Welcome extends CI_Controller {

    public function __construct() {
        
        parent::__construct();
        
        /**
        * Laadt de auteur van de geschreven code van deze pagina in de footer.
        */
        
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "true", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    public function index() {

        /**
        * Haalt alle startpaginaItems op via startpaginaItem_model, alle verschillende wedstrijden op via wedstrijd_model,  
        * alle verschillende zwemmers op via zwemmers_model en toont de resulterende objecten in de view bezoeker_main_master.php
        * 
        * @see startpaginaItem_model::getStartpaginaItem()
        * @see zwemmers_model::getLadenTeam()
        * @see wedstrijd_model::getAlleWedstrijden()
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
    
    public function ladenTeam() {
        
        /**
        * Haalt alle verschillende zwemmers op via zwemmers_model en toont de resulterende objecten in de view bezoeker_main_master.php
        * 
        * @see startpaginaItem_model::getStartpaginaItem()
        * @see zwemmers_model::getLadenTeam()
        * @see wedstrijd_model::getAlleWedstrijden()
        */
        
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

    public function meldAan() {       
        
        /**
        * Weergeven van de view home_aanmelden.php die de gebruiker de mogelijkheid geeft om aan te melden.
        * 
        * @see home_aanmelden.php
        */
        
        $data['titel'] = 'Aanmelden';
        $data['team'] = $this->data->team;
        $data['persoon']  = $this->authex->getPersoonInfo();

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'aanmeldFormulier' => 'bezoeker/home_aanmelden',
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }

    public function toonFout() {      
        
        /**
        * Weergeven van de view home_fout.php die de gebruiker de mogelijkheid geeft om opnieuw aan te melden.
        * 
        * @see home_fout.php
        */
        
        $data['titel'] = 'Fout';
        $data['team'] = $this->data->team;
        $data['persoon']  = $this->authex->getPersoonInfo();
        $data['foutBoodschap'] = "De combinatie van het email-adres en wachtwoord is foutief! Probeer opnieuw.";
        
        $zwemmers = $this->ladenTeam();        
        $data['zwemmers'] = $zwemmers;
        
        $this->load->model('trainer/startpaginaitem_model');
        $data['startpaginaitems'] = $this->startpaginaitem_model->getStartpaginaItem();
                       
        $this->load->model('trainer/wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAlleWedstrijden();   

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'aanmeldFormulier' => 'bezoeker/home_fout',
            'foutMelding' => 'bezoeker/home_aanmelden',
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }

    public function controleerAanmelden() {
        /**
        * Gebruikt de Authex-library om te controleren of de ingevoerde gebruikersgegevens overeenstemmen met een bestaande persoon in de database en controleert welke soort persoon zich aanmeldt.
        * 
        * @see home_aanmelden.php
        * @see Authex.php
        */
        
        $email = $this->input->post('email');
        $wachtwoord = $this->input->post('wachtwoord');

        if ($this->authex->meldAan($email, $wachtwoord)) {

            $persoon = $this->authex->getPersoonInfo();

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

    public function meldAf() {
        
        /**
        * Gebruikt de Authex-library om de gebruiker af te melden en de homepagina opnieuw weer te geven.
        * 
        * @see Authex.php
        */
        
        $this->authex->meldAf();
        redirect('Welcome');
    }  
}
