<?php

/**
 * @class Agenda_model
 * @brief Model-klasse voor agenda aanpassen
 *
 * Model-klasse die alle methodes bevat om de agenda aan te passen.
 */

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

    /**
     * Constructor
     */
    
    function __construct() {
        parent::__construct();

        //helpers inladen
        $this->load->helper("my_html_helper");
        $this->load->helper("my_url_helper");
        $this->load->helper('url');
    }
    
    /**
     * Insert de activiteit
     * @param $activiteit De activiteit die ingeladen moet worden in de database.
     */

    public function insertActiviteit($activiteit) {
        // Activiteit toevoegen
        $this->db->insert('activiteit', $activiteit);
        return $this->db->insert_id();
    }
    
    /**
     * Update de activiteit
     * @param $activiteit De activiteit die geupdate moet worden in de database.
     */

    public function updateActiviteit($activiteit) {
        // Activiteit wijzigen
        $this->db->where('id', $activiteit->id);
        $this->db->update('activiteit', $activiteit);
    }
    
    /**
     * Delete de activiteit
     * @param $id De id van de activiteit die verwijderd moet worden uit de database.
     */

    public function deleteActiviteit($id){
        $this->db->where('id', $id);
        $this->db->delete('activiteit');
    }
    
    /**
     * Insert activiteitPerPersoon
     * @param $activiteitPerPersoon De activiteitPerPersoon die ingeladen moet worden in de database.
     */

    public function insertActiviteitPerPersoon($activiteitPerPersoon) {
        // ActiviteitPerPersoon toevoegen
        $this->db->insert('activiteitPerPersoon', $activiteitPerPersoon);
        return $this->db->insert_id();
    }
    
    /**
     * Update activiteitPerPersoon
     * @param $activiteitPerPersoon De activiteitPerPersoon die geupdate moet worden in de database.
     */

    public function updateActiviteitPerPersoon($activiteitPerPersoon) {
        // ActiviteitPerPersoon wijzigen
        $this->db->where('persoonId', $activiteitPerPersoon->persoonId);
        $this->db->where('activiteitId', $activiteitPerPersoon->activiteitId);
        $this->db->update('activiteitPerPersoon', $activiteitPerPersoon);
    }
    
    /**
     * Delete activiteitPerPersoon
     * @param $id De id van activiteitPerPersoon die verwijderd moet worden uit de database.
     */

    public function deleteActiviteitPerPersoon($id){
        $this->db->where('id', $id);
        $this->db->delete('activiteitPerPersoon');
    }
    
    /**
     * Delete activiteitPerPersoon 
     * @param $activiteitId De activiteitId van de activiteitPerPersoon die verwijderd moet worden uit de database.
     */

    public function deleteActiviteitPerPersoonWithActiviteitId($activiteitId){
        $this->db->where('activiteitId', $activiteitId);
        $this->db->delete('activiteitPerPersoon');
    }
    
    /**
     * Insert het supplement
     * @param $supplement Het supplement dat ingeladen moet worden in de database.
     */

    public function insertSupplement($supplement) {
        // supplement toevoegen
        $this->db->insert('supplementperpersoon', $supplement);
        return $this->db->insert_id();
    }
    
    /**
     * Update het supplement
     * @param $supplement Het supplement dat geupdate moet worden in de database.
     */

    public function updateSupplement($supplement) {
        // supplement wijzigen
        $this->db->where('id', $supplement->id);
        $this->db->update('supplementperpersoon', $supplement);
    }
    
    /**
     * Delete het supplement
     * @param $id Het supplement dat verwijderd moet worden uit de database.
     */

    public function deleteSupplement($id){
        $this->db->where('id', $id);
        $this->db->delete('supplementperpersoon');
    }
    
    /**
     * Insert de medische afspraak
     * @param $onderzoek De medische afspraak dat ingeladen moet worden in de database.
     */

    public function insertOnderzoek($onderzoek) {
        // supplement toevoegen
        $this->db->insert('medischeafspraak', $onderzoek);
        return $this->db->insert_id();
    }
    
    /**
     * Update de medische afspraak
     * @param $onderzoek De medische afspraak dat geupdate moet worden in de database.
     */

    public function updateOnderzoek($onderzoek) {
        // supplement wijzigen
        $this->db->where('id', $onderzoek->id);
        $this->db->update('medischeafspraak', $onderzoek);
    }
    
    /**
     * Delete het supplement
     * @param $id De id van de medische afpsraak die verwijdert moet worden uit de database
     */

    public function deleteOnderzoek($id){
        $this->db->where('id', $id);
        $this->db->delete('medischeafspraak');
    }
    
    /**
     * Retourneert een persoon object
     * @param $persoonId De id van de persoon dat opgevraagd wordt
     * @return Het opgevraagde record
     */

    public function getPersoon($persoonId) {
        // Persoon ophalen uit databank
        $this->db->where('id', $persoonId);
        $query = $this->db->get('persoon');
        return $query->row();
    }
    
    /**
     * Retourneert een activiteitPerPersoon object
     * @param $persoonId De persoonId van de activiteitPerPersoon die opgevraagd wordt
     * @param $activiteitId De activiteitId van de activiteitPerPersoon die opgevraagd wordt
     * @return Het opgevraagde record
     */

    public function getActiviteitPerPersoon($persoonId, $activiteitId) {
        // ActiviteitPerPersoon ophalen uit de databank ==> checken op persoonId & activiteitId
        $this->db->where('persoonId', $persoonId);
        $this->db->where('activiteitId', $activiteitId);
        $query = $this->db->get('activiteitPerPersoon');
        return $query->row();
    }
    
    /**
     * Retourneert een typeActiviteit object
     * @param $typeActiviteitId De id van de typeActiviteit die opgevraagd wordt
     * @return Het opgevraagde record
     */

    public function getTypeActiviteit($typeActiviteitId) {
        // Type activiteit ophalen uit de databank (training of stage)
        $this->db->where('id', $typeActiviteitId);
        $query = $this->db->get('typeActiviteit');
        return $query->row();
    }
    
    /**
     * Retourneert een typeTraining object
     * @param $typeTrainingId De id van de typeTraining die opgevraagd wordt
     * @return Het opgevraagde record
     */

    public function getTypeTraining($typeTrainingId) {
        // Type training ophalen uit de databank
        $this->db->where('id', $typeTrainingId);
        $query = $this->db->get('typeTraining');
        return $query->row();
    }
    
    /**
     * Retourneert alle personen die deelnemen aan een bepaalde activiteit
     * @param $activiteitId De id van de activiteit waarvan de deelnemende personen worden opgevraagd
     * @return Het opgevraagde record
     */

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
    
    /**
     * Retourneert alle activiteiten die in dezelfde reeks zitten.
     * @param $reeksId De id van de reeks waarvan de activiteiten worden opgevraagd
     * @return Het opgevraagde record
     */

    public function getReeksActiviteiten($reeksId) {
        $this->db->where('reeksId', $reeksId);
        $query = $this->db->get('activiteit');
        return $query->result();
    }
    
    /**
     * Retourneert een volledig activiteiten object inclusief al zijn relatietabellen
     * @param $activiteitId De id van de activiteit die wordt opgevraagd
     * @see getReeksActiviteiten($reeksId)
     * @see getTypeActiviteit($typeActiviteitId)
     * @see getTypeTraining($typeTrainingId)
     * @see getPersonenFromActiviteit($activiteitId)
     * @return Het opgevraagde record
     */

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
    
    /**
     * Retourneert alle reeksen die bij een bepaalde wedstrijd horen
     * @param $wedstrijdId De id van de wedstrijd waarvan de reeksen worden opgevraagd
     * @return Het opgevraagde record
     */

    public function getReeksenPerWedstrijd($wedstrijdId) {
        // Wedstrijdreeks ophalen uit de databank
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('reeksPerWedstrijd');
        return $query->result();
    }
    
    /**
     * Retourneert alle inschrijvingen die bij een bepaalde reeksPerWedstrijd horen
     * @param $reeksPerWedstrijdId De id van de reeksPerWedstrijd waarvan de inschrijvingen worden opgevraagd
     * @return Het opgevraagde record
     */

    public function getInschrijving($reeksPerWedstrijdId) {
        $this->db->where('reeksPerWedstrijdId', $reeksPerWedstrijdId);
        $query = $this->db->get('inschrijving');
        return $query->row();
    }
    
    /**
     * Retourneert alle personen die deelnemen aan een bepaalde wedstrijd
     * @param $wedstrijdId De id van de wedstrijd waarvan de deelnemende personen worden opgevraagd
     * @see getReeksenPerWedstrijd($wedstrijdId)
     * @see getInschrijving($reeksId)
     * @return Het opgevraagde record
     */

    public function getPersonenFromWedstrijd($wedstrijdId) {
        $reeksen = $this->getReeksenPerWedstrijd($wedstrijdId);
        $personen = [];
        foreach ($reeksen as $reeks) {
            $inschrijving = $this->getInschrijving($reeks->id);
            $personen[] = $inschrijving->persoonId;
        }

        return $personen;
    }
    
    /**
     * Retourneert een volledig wedstrijden object inclusief al zijn relatietabellen
     * @param $wedstrijdId De id van de wedstrijd die wordt opgevraagd
     * @see getReeksenPerWedstrijd($wedstrijdId)
     * @see getPersonenFromWedstrijd($wedstrijdId)
     * @return Het opgevraagde record
     */

    public function getWedstrijd($wedstrijdId) {
        $this->db->where('id', $wedstrijdId);
        $query = $this->db->get('wedstrijd');

        $wedstrijd = $query->row();

        $wedstrijd->reeksenPerWedstrijd = $this->getReeksenPerWedstrijd($wedstrijd->id);
        $wedstrijd->personen = $this->getPersonenFromWedstrijd($wedstrijd->id);

        return $wedstrijd;
    }
    
    /**
     * Retourneert alle reeksen van activiteiten die er zijn
     * @return Het opgevraagde record
     */

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
    
    /**
     * Retourneert een supplementPerPersoon object
     * @param $supplementPerPersoonId De id van de supplementPerPersoon
     * @return Het opgevraagde record
     */

    public function getSupplementPerPersoon($supplementPerPersoonId) {
        // SupplementPerPersoon ophalen uit de databank
        $this->db->where('id', $supplementPerPersoonId);
        $query = $this->db->get('supplementperpersoon');
        return $query->row();
    }
    
    /**
     * Retourneert een medische afspraak
     * @param $onderzoekId De id van de medische afspraak
     * @return Het opgevraagde record
     */
    
    public function getOnderzoek($onderzoekId) {
        // Alle medische onderzoeken van een bepaalde persoon ophalen uit de databank
        $this->db->where('id', $onderzoekId);
        $query = $this->db->get('medischeAfspraak');
        return $query->row();
    }
}
