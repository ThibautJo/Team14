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

    public function deleteActiviteit($id){
        $this->db->where('id', $id);
        $this->db->delete('activiteit');
    }

    public function insertActiviteitPerPersoon($activiteitPerPersoon) {
        // ActiviteitPerPersoon toevoegen
        $this->db->insert('activiteitPerPersoon', $activiteitPerPersoon);
        return $this->db->insert_id();
    }

    public function updateActiviteitPerPersoon($activiteitPerPersoon) {
        // ActiviteitPerPersoon wijzigen
        $this->db->where('persoonId', $activiteitPerPersoon->persoonId);
        $this->db->where('activiteitId', $activiteitPerPersoon->activiteitId);
        $this->db->update('activiteitPerPersoon', $activiteitPerPersoon);
    }

    public function deleteActiviteitPerPersoon($id){
        $this->db->where('id', $id);
        $this->db->delete('activiteitPerPersoon');
    }

    public function deleteActiviteitPerPersoonWithActiviteitId($activiteitId){
        $this->db->where('activiteitId', $activiteitId);
        $this->db->delete('activiteitPerPersoon');
    }

    public function insertSupplement($supplement) {
        // supplement toevoegen
        $this->db->insert('supplementperpersoon', $supplement);
        return $this->db->insert_id();
    }

    public function updateSupplement($supplement) {
        // supplement wijzigen
        $this->db->where('id', $supplement->id);
        $this->db->update('supplementperpersoon', $supplement);
    }

    public function deleteSupplement($id){
        $this->db->where('id', $id);
        $this->db->delete('supplementperpersoon');
    }

    public function insertOnderzoek($onderzoek) {
        // supplement toevoegen
        $this->db->insert('medischeafspraak', $onderzoek);
        return $this->db->insert_id();
    }

    public function updateOnderzoek($onderzoek) {
        // supplement wijzigen
        $this->db->where('id', $onderzoek->id);
        $this->db->update('medischeafspraak', $onderzoek);
    }

    public function deleteOnderzoek($id){
        $this->db->where('id', $id);
        $this->db->delete('medischeafspraak');
    }

    public function getPersoon($persoonId) {
        // Persoon ophalen uit databank
        $this->db->where('id', $persoonId);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    public function getActiviteitPerPersoon($persoonId, $activiteitId) {
        // ActiviteitPerPersoon ophalen uit de databank ==> checken op persoonId & activiteitId
        $this->db->where('persoonId', $persoonId);
        $this->db->where('activiteitId', $activiteitId);
        $query = $this->db->get('activiteitPerPersoon');
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

    public function getReeksActiviteiten($reeksId) {
        $this->db->where('reeksId', $reeksId);
        $query = $this->db->get('activiteit');
        return $query->result();
    }

    public function getActiviteit($activiteitId) {
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('activiteit');

        $activiteit = $query->row();

        if ($activiteit->reeksId !== null) {
            $activiteit->reeks = $this->getReeksActiviteiten($activiteit->reeksId);
        }

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

    public function getAllReeksen() {
        $query = $this->db->get('activiteit');
        $records = $query->result();

        $reeksen = [];

        foreach ($records as $record) {
            if (!in_array($record->reeksId, $reeksen)) {
                $reeksen[] = $record->reeksId;
            }
        }

        return $reeksen;
    }

    public function getSupplementPerPersoon($supplementPerPersoonId) {
        // SupplementPerPersoon ophalen uit de databank
        $this->db->where('id', $supplementPerPersoonId);
        $query = $this->db->get('supplementperpersoon');
        return $query->row();
    }
    
    public function getOnderzoek($onderzoekId) {
        // Alle medische onderzoeken van een bepaalde persoon ophalen uit de databank
        $this->db->where('id', $onderzoekId);
        $query = $this->db->get('medischeAfspraak');
        return $query->row();
    }
}
