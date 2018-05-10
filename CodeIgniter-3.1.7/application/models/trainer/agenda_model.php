<?php

class Agenda_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Tom Nuyts       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Agenda model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();

        //helpers inladen
        $this->load->helper("my_html_helper");
        $this->load->helper("my_url_helper");
        $this->load->helper('url');
    }

    public function insertActiviteit($activiteit) {
        // Activiteit toevoegen
        $this->db->insert('activiteit', $activiteit);
        return $this->db->insert_id();
    }

    public function updateActiviteit($activiteit) {
        // Activiteit wijzigen
        $this->db->where('id', $activiteit->id);
        $this->db->update('activiteit', $activiteit);
    }

    public function insertActiviteitPerPersoon($activiteitPerPersoon) {
        $this->db->insert('activiteitPerPersoon', $activiteitPerPersoon);
        return $this->db->insert_id();
    }
    
    public function getPersoon($persoonId) {
        // Type activiteit ophalen uit de databank (training of stage)
        $this->db->where('id', $persoonId);
        $query = $this->db->get('persoon');
        return $query->row();
    }
    
    public function getTypeActiviteit($typeActiviteitId) {
        // Type activiteit ophalen uit de databank (training of stage)
        $this->db->where('id', $typeActiviteitId);
        $query = $this->db->get('typeActiviteit');
        return $query->row();
    }

    public function getTypeTraining($typeTrainingId) {
        // Type training ophalen uit de databank
        $this->db->where('id', $typeTrainingId);
        $query = $this->db->get('typeTraining');
        return $query->row();
    }
    
    public function getPersonenFromActiviteit($activiteitId) {
        $this->db->where('activiteitId', $activiteitId);
        $query = $this->db->get('activiteitperpersoon');
        $activiteitenPerPersoon = $query->result();
        $personen = [];
        
        foreach ($activiteitenPerPersoon as $activiteitPerPersoon) {
            $personen[] = $activiteitPerPersoon->persoonId;
        }
        
        return $personen;
    }
    
    public function getActiviteit($activiteitId) {
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('activiteit');
        
        $activiteit = $query->row();
        
        $activiteit->typeActiviteit = $this->getTypeActiviteit($activiteit->typeActiviteitId);
        $activiteit->typeTraining = $this->getTypeTraining($activiteit->typeTrainingId);
        $activiteit->personen = $this->getPersonenFromActiviteit($activiteitId);
        
        return $activiteit;
    }
    
    public function getReeksenPerWedstrijd($wedstrijdId) {
        // Wedstrijdreeks ophalen uit de databank
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('reeksPerWedstrijd');
        return $query->result();
    }
    
    public function getInschrijving($reeksPerWedstrijdId) {
        $this->db->where('reeksPerWedstrijdId', $reeksPerWedstrijdId);
        $query = $this->db->get('inschrijving');
        return $query->row();
    }
    
    public function getPersonenFromWedstrijd($wedstrijdId) {
        $reeksen = $this->getReeksenPerWedstrijd($wedstrijdId);
        $personen = [];
        foreach ($reeksen as $reeks) {
            $inschrijving = $this->getInschrijving($reeks->id);
            $personen[] = $inschrijving->persoonId;
        }
        
        return $personen;
    }
    
    public function getWedstrijd($wedstrijdId) {
        $this->db->where('id', $wedstrijdId);
        $query = $this->db->get('wedstrijd');
        
        $wedstrijd = $query->row();
        
        $wedstrijd->reeksenPerWedstrijd = $this->getReeksenPerWedstrijd($wedstrijd->id);
        $wedstrijd->personen = $this->getPersonenFromWedstrijd($wedstrijd->id);
        
        return $wedstrijd;
    }
}
