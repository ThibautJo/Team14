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

        // Helpers inladen
        $this->load->helper('url');
    }

    // +----------------------------------------------------------
    // |
    // |    Persoonlijke agenda raadplegen
    // |
    // +----------------------------------------------------------

    public function index() {
        $data['titel'] = 'Agenda';
        
        $persoonId = 1;
        
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
                "title" => $wedstrijd->wedstrijd->Naam, // Titel van het event in de agenda
                "start" => $wedstrijd->wedstrijd->DatumStart, // Beginuur/begindatum van het event in de agenda
                "end" => $wedstrijd->wedstrijd->DatumStop, // Einduur/einddatum van het event in de agenda
                "color" => $this->agenda_model->getKleurActiviteit(1)->Kleur, // Kleur van het event in de agenda
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
                "title" => $onderzoek->Omschrijving,
                "start" => $onderzoek->TijdstipStart,
                "end" => $onderzoek->TijdstipStop,
                "color" => $this->agenda_model->getKleurActiviteit(2)->Kleur,
                "textColor" => '#000'
            );
        }
        
        return $data_onderzoeken;
    }
    
    public function kiesKleurTraining($id) {
        $this->load->model("zwemmer/agenda_model");
        $activiteit = $this->agenda_model->getActiviteit($id);
        
        // Verschillende typen trainingen krijgen allemaal een andere achtergrondkleur
        switch ($activiteit->TypeTrainingId) {
            case 1:
                $color = $this->agenda_model->getKleurActiviteit(3)->Kleur; // Kleur krachttraining
                break;

            case 2:
                $color = $this->agenda_model->getKleurActiviteit(4)->Kleur; // Kleur houdingstraining
                break;

            case 3:
                $color = $this->agenda_model->getKleurActiviteit(5)->Kleur; // Kleur zwemtraining
                break;

            case 4:
                $color = $this->agenda_model->getKleurActiviteit(6)->Kleur; // Kleur conditietraining
                break;

            case NULL:
                $color = $this->agenda_model->getKleurActiviteit(7)->Kleur; // Kleur stage
                break;
        }
        
        return $color;
    }
    
    public function kiesKleurActiviteiten($id) {
        $this->load->model("zwemmer/agenda_model");
        $activiteit = $this->agenda_model->getActiviteit($id);
        
        // Stage en training krijgen beiden een andere achtergrondkleur
        switch ($activiteit->TypeActiviteitId) {
            case 1:
                $color = $this->kiesKleurTraining($id); // Meerdere typen trainingen -> Kleur wordt bepaald in nieuwe functie
                break;

            case 2:
                $color = $this->agenda_model->getKleurActiviteit(7)->Kleur; // Kleur stage
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
            $color = $this->kiesKleurActiviteiten($activiteit->activiteit->ID);
                               
            $data_activiteiten[] = array(
                "title" => $activiteit->activiteit->StageTitel,
                "start" => $activiteit->activiteit->TijdstipStart,
                "end" => $activiteit->activiteit->TijdStipStop,
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
                "id" => $supplement->ID,
                "description" => $supplement->functie->Functie,
                "title" => $supplement->supplement->Naam,
                "start" => $supplement->Datum,
                "color" => $this->agenda_model->getKleurActiviteit(8)->Kleur,
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