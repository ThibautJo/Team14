<?php

class Agenda_model extends CI_Model {

    // +----------------------------------------------------------
    // | Lekkerbier - Bestelling_model.php
    // +----------------------------------------------------------
    // | 2 ITF - 201x-201x
    // +----------------------------------------------------------
    // | Bestelling model
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();

        $this->load->helper("MY_html_helper");
        $this->load->helper("MY_url_helper");
        $this->load->helper('url');
    }

    public function getActiviteit($activiteitId) {
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('activiteit');
        return $query->row();
    }
    
    public function getTypeActiviteit($activiteitId) {
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('typeactiviteit');
        return $query->row();
    }
    
    public function getTypeTraining($trainingId) {
        $this->db->where('id', $trainingId);
        $query = $this->db->get('typetraining');
        return $query->row();
    }
    
    public function getActiviteitenByPersoon($persoonId) {
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('activiteitperpersoon');
        
        $activiteiten = $query->result();
        
        foreach ($activiteiten as $activiteit) {
            $activiteit->activiteit = $this->getActiviteit($activiteit->ID);
            
            $activiteit->typeActiviteit = $this->getTypeActiviteit($activiteit->activiteit->TypeActiviteitId);
            
            $activiteit->typeTraining = $this->getTypeTraining($activiteit->activiteit->TypeTrainingId);
        }
        
        return $activiteiten;
    }
    
    public function getReeksPerWedstrijd($reeksPerWedstrijdId) {
        $this->db->where('id', $reeksPerWedstrijdId);
        $query = $this->db->get('reeksperwedstrijd');
        return $query->row();
    }
    
    public function getWedstrijd($wedstrijdId) {
        $this->db->where('id', $wedstrijdId);
        $query = $this->db->get('wedstrijd');
        return $query->row();
    }
    
    public function getWedstrijdenByPersoon($persoonId) {
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('inschrijving');
        
        $wedstrijden = $query->result();
        
        foreach ($wedstrijden as $wedstrijd) {
            $wedstrijd->reeksPerWedstrijd = $this->getReeksPerWedstrijd($wedstrijd->ReeksPerWedstrijdId);
            
            $wedstrijd->wedstrijd = $this->getWedstrijd($wedstrijd->reeksPerWedstrijd->WedstrijdId);
        }

        return $wedstrijden;
    }
    
    public function getOnderzoekenByPersoon($persoonId) {
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('medischeafspraak');
        return $query->result();
    }
    
    public function getSupplement($supplementId) {
        $this->db->where('id', $supplementId);
        $query = $this->db->get('supplement');        
        return $query->row();
    }
    
    public function getSupplementFunctie($functieId) {
        $this->db->where('id', $functieId);
        $query = $this->db->get('supplementfunctie');        
        return $query->row();
    }
    
    public function getSupplementenByPersoon($persoonId) {
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('supplementperpersoon');
        
        $supplementen = $query->result();
        
        foreach ($supplementen as $supplement) {
            $supplement->supplement = $this->getSupplement($supplement->SupplementId);

            $supplement->functie = $this->getSupplementFunctie($supplement->supplement->FunctieId);
        }
        
        return $supplementen;
    }
}
