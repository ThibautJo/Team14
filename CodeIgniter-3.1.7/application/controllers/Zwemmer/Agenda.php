<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |
    // |    Agenda controller
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    public function __construct() {

        parent::__construct();

        $this->load->helper('url');
    }

    // +----------------------------------------------------------
    // |    Auteur: Tom Nuyts       |       Helper: /
    // +----------------------------------------------------------
    // |
    // |    Persoonlijke agenda raadplegen
    // |
    // +----------------------------------------------------------

    public function index() {
        $data['titel'] = 'Agenda';
        $data['magNiet'] = 'ja';

        $data_wedstrijden = $this->ladenWedstrijden();
        $data_onderzoeken = $this->ladenOnderzoeken();
        $data_supplementen = $this->ladenSupplementen();
        $data_activiteiten = $this->ladenActiviteiten();
        $data_agenda = array_merge($data_supplementen, $data_onderzoeken, $data_wedstrijden, $data_activiteiten);
        
        $activiteiten = json_encode($data_agenda);
        
        $data['activiteiten'] = $activiteiten;

        $partials = array('hoofding' => 'main_header',
            'menu' => 'main_menu',
            'inhoud' => 'zwemmer/agenda',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
    
    public function ladenWedstrijden() {
        $this->load->model("zwemmer/agenda_model");
        $wedstrijden = $this->agenda_model->getWedstrijdenByPersoon(1);
        
        $data_wedstrijden = array();
        
        foreach ($wedstrijden as $wedstrijd) {                    
            $data_wedstrijden[] = array(
                "title" => $wedstrijd->wedstrijd->Naam,
                "start" => $wedstrijd->wedstrijd->DatumStart,
                "end" => $wedstrijd->wedstrijd->DatumStop,
                "color" => '#FF7534',
                "textColor" => '#000'
            );
        }
        
        return $data_wedstrijden;
    }
    
    public function ladenOnderzoeken() {
        $this->load->model("zwemmer/agenda_model");
        $onderzoeken = $this->agenda_model->getOnderzoekenByPersoon(1);
        
        $data_onderzoeken = array();
        
        foreach ($onderzoeken as $onderzoek) {                    
            $data_onderzoeken[] = array(
                "title" => $onderzoek->Omschrijving,
                "start" => $onderzoek->TijdstipStart,
                "end" => $onderzoek->TijdstipStop,
                "color" => '#BB9BFF',
                "textColor" => '#000'
            );
        }
        
        return $data_onderzoeken;
    }
    
    public function kiesKleurTraining($id) {
        $this->load->model("zwemmer/agenda_model");
        $activiteit = $this->agenda_model->getActiviteit($id);
        
        switch ($activiteit->TypeTrainingId) {
            case 1:
                $color = '#B5DD6C';
                break;

            case 2:
                $color = '#7CD246';
                break;

            case 3:
                $color = '#0FA865';
                break;

            case 4:
                $color = '#93E2C1';
                break;

            case NULL:
                $color = '#A0C7E8';
                break;
        }
        
        return $color;
    }
    
    public function kiesKleurActiviteiten($id) {
        $this->load->model("zwemmer/agenda_model");
        $activiteit = $this->agenda_model->getActiviteit($id);
        
        switch ($activiteit->TypeActiviteitId) {
            case 1:
                $color = $this->kiesKleurTraining($id);
                break;

            case 2:
                $color = '#A0C7E8';
                break;

            default:
                break;
        }
        
        return $color;
    }  
    
    public function ladenActiviteiten() {
        $this->load->model("zwemmer/agenda_model");
        $activiteiten = $this->agenda_model->getActiviteitenByPersoon(1);
        
        $data_activiteiten = array();
        $teller = 0;
        
        foreach ($activiteiten as $activiteit) {            
            $color = $this->kiesKleurActiviteiten($activiteit->activiteit->ID);
                               
            $data_activiteiten[] = array(
                "title" => $activiteit->activiteit->StageTitel,
                "start" => $activiteit->activiteit->TijdstipStart,
                "end" => $activiteit->activiteit->TijdStipStop,
                "color" => $color,
                "textColor" => '#000'
            );
            
            $teller++;
        }
        
        return $data_activiteiten;
    }
    
    public function ladenSupplementen() {
        $this->load->model("zwemmer/agenda_model");
        $supplementen = $this->agenda_model->getSupplementenByPersoon(1);
        
        $data_supplementen = array();
        
        foreach ($supplementen as $supplement) {                    
            $data_supplementen[] = array(
                "id" => $supplement->ID,
                "description" => $supplement->functie->Functie,
                "title" => $supplement->supplement->Naam,
                "start" => $supplement->Datum,
                "color" => '#E5343D',
                "textColor" => '#fff'
            );
        }
        
        return $data_supplementen;
    }

}
