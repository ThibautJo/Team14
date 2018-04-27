<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Tom Nuyts       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Agenda controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    public function __construct() {

        parent::__construct();
        
        // controleren of persoon is aangemeld
        if (!$this->authex->isAangemeld()) {
        redirect('welcome/meldAan');}

        // Helpers inladen
        $this->load->helper('url');
        $this->load->helper("my_html_helper");
        $this->load->helper("my_url_helper");
        
        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "false", "Tom Nuyts" => "true", "Lise Van Eyck" => "false");
    }

    // +----------------------------------------------------------
    // |
    // |    Persoonlijke agenda raadplegen
    // |
    // +----------------------------------------------------------

    public function index() {
        
        $data['titel'] = 'Agenda';
        $data['team'] = $this->data->team;
        $persoonAangemeld = $this->authex->getPersoonInfo();
        $data['persoonAangemeld'] = $persoonAangemeld;
        
        $persoonId = $persoonAangemeld->id;
        
        
        // Inladen van alle agenda punten (wedstrijden, medische onderzoeken, supplementen, trainingen en stages
        $data_wedstrijden = $this->ladenWedstrijden($persoonId);
        $data_onderzoeken = $this->ladenOnderzoeken($persoonId);
        $data_supplementen = $this->ladenSupplementen($persoonId);
        $data_activiteiten = $this->ladenActiviteiten($persoonId);
        // Eén grote array maken van alle arrays om deze om te kunnen zetten in JSON code
        $data_agenda = array_merge($data_supplementen, $data_onderzoeken, $data_wedstrijden, $data_activiteiten);
        
        // $data_agenda omzetten in JSON code -> Deze wordt in de variabele $activiteiten gestopt
        $activiteiten = json_encode($data_agenda);
        
        $data['activiteiten'] = $activiteiten;
        
        $this->load->model("zwemmer/agenda_model");
        $data['kleuren'] = json_encode($this->agenda_model->getKleurenActiviteiten());        

        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'zwemmer/agenda',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    public function ladenWedstrijden($persoonId) {
        
        // Wedstrijden worden opgehaald uit het model en in een lijst gestoken
        $this->load->model("zwemmer/agenda_model");
        $wedstrijden = $this->agenda_model->getWedstrijdenByPersoon($persoonId);
        
        $data_wedstrijden = array();
        
        // Wedstrijden worden in een array gestoken -> dit doen we om later van de array JSON code te kunnen maken
        foreach ($wedstrijden as $wedstrijd) {                    
            $data_wedstrijden[] = array(
                "title" => $wedstrijd->wedstrijd->naam, // Titel van het event in de agenda
                "description" => '',
                "start" => $wedstrijd->wedstrijd->datumStart, // Beginuur/begindatum van het event in de agenda
                "end" => $wedstrijd->wedstrijd->datumStop, // Einduur/einddatum van het event in de agenda
                "color" => $this->agenda_model->getKleurActiviteit(1)->kleur, // Kleur van het event in de agenda
                "textColor" => '#000' // Tekstkleur van het event in de agenda
            );
        }
        
        return $data_wedstrijden;
    }
    
    public function ladenOnderzoeken($persoonId) {
        // Medische onderzoeken worden opgehaald uit het model en in een lijst gestoken
        $this->load->model("zwemmer/agenda_model");
        $onderzoeken = $this->agenda_model->getOnderzoekenByPersoon($persoonId);
        
        $data_onderzoeken = array();
        
        // Medische onderzoeken worden in een array gestoken -> dit doen we om later van de array JSON code te kunnen maken
        foreach ($onderzoeken as $onderzoek) {                    
            $data_onderzoeken[] = array(
                "title" => $onderzoek->omschrijving,
                "description" => '',
                "start" => $onderzoek->tijdstipStart,
                "end" => $onderzoek->tijdstipStop,
                "color" => $this->agenda_model->getKleurActiviteit(2)->kleur,
                "textColor" => '#000'
            );
        }
        
        return $data_onderzoeken;
    }
    
    public function kiesKleurTraining($id) {
        $this->load->model("zwemmer/agenda_model");
        $activiteit = $this->agenda_model->getActiviteit($id);
        
        // Verschillende typen trainingen krijgen allemaal een andere achtergrondkleur
        switch ($activiteit->typeTrainingId) {
            case 1:
                $color = $this->agenda_model->getKleurActiviteit(3)->kleur; // Kleur krachttraining
                break;

            case 2:
                $color = $this->agenda_model->getKleurActiviteit(4)->kleur; // Kleur houdingstraining
                break;

            case 3:
                $color = $this->agenda_model->getKleurActiviteit(5)->kleur; // Kleur zwemtraining
                break;

            case 4:
                $color = $this->agenda_model->getKleurActiviteit(6)->kleur; // Kleur conditietraining
                break;

            case NULL:
                $color = $this->agenda_model->getKleurActiviteit(7)->kleur; // Kleur stage
                break;
        }
        
        return $color;
    }
    
    public function kiesKleurActiviteiten($id) {
        $this->load->model("zwemmer/agenda_model");
        $activiteit = $this->agenda_model->getActiviteit($id);
        
        // Stage en training krijgen beiden een andere achtergrondkleur
        switch ($activiteit->typeActiviteitId) {
            case 1:
                $color = $this->kiesKleurTraining($id); // Meerdere typen trainingen -> Kleur wordt bepaald in nieuwe functie
                break;

            case 2:
                $color = $this->agenda_model->getKleurActiviteit(7)->kleur; // Kleur stage
                break;

            default:
                break;
        }
        
        return $color;
    }  
    
    public function ladenActiviteiten($persoonId) {
        // Trainingen en stages worden opgehaald uit het model en in een lijst gestoken
        $this->load->model("zwemmer/agenda_model");
        $activiteiten = $this->agenda_model->getActiviteitenByPersoon($persoonId);
        
        $data_activiteiten = array();
        
        // Trainingen en stages worden in een array gestoken -> dit doen we om later van de array JSON code te kunnen maken
        foreach ($activiteiten as $activiteit) {            
            $color = $this->kiesKleurActiviteiten($activiteit->activiteit->id);
                               
            $data_activiteiten[] = array(
                "title" => $activiteit->activiteit->stageTitel,
                "description" => '',
                "start" => $activiteit->activiteit->tijdstipStart,
                "end" => $activiteit->activiteit->tijdstipStop,
                "color" => $color,
                "textColor" => '#000'
            );
        }
        
        return $data_activiteiten;
    }
    
    public function ladenSupplementen($persoonId) {
        // Supplementen worden opgehaald uit het model en in een lijst gestoken
        $this->load->model("zwemmer/agenda_model");
        $supplementen = $this->agenda_model->getSupplementenByPersoon($persoonId);
        
        $data_supplementen = array();
        
        // Supplementen worden in een array gestoken -> dit doen we om later van de array JSON code te kunnen maken
        foreach ($supplementen as $supplement) {                    
            $data_supplementen[] = array(
                "id" => $supplement->id,
                "description" => $supplement->functie->supplementFunctie . ', ' . $supplement->hoeveelheid . ' keer',
                "title" => $supplement->supplement->naam,
                "start" => $supplement->datum,
                "color" => $this->agenda_model->getKleurActiviteit(8)->kleur,
                "textColor" => '#fff'
            );
        }
        
        return $data_supplementen;
    }
    
    public function ladenKleuren() {
        // Kleuren worden opgehaald uit het model en in een lijst gestoken
        $this->load->model("zwemmer/agenda_model");
        $kleuren = $this->agenda_model->getKleuren();
        return $kleuren;
    }

}
