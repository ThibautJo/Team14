<?php

/**
 * @class Melding_model
 * @brief Model-klasse voor meldingen
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel melding
 */

class Melding_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Melding model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();

    }

    /**
     * Retourneert het record met id=$id uit de tabel melding
     * 
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    function getMelding($id){
        $this->db->where('id', $id);
        $query = $this->db->get('melding');
        return $query->row();
    }

    /**
     * Retourneert een array met id=$id uit de tabel meldingperpersoon met de bijhorende persoon en melding
     * 
     * @param $id De id van het record dat opgevraagd wordt
     * @return De opgevraagde array
     */
    function get($id) {

        $this->db->where('id', $id);
        $query = $this->db->get('meldingPerPersoon');
        $meldingPerPersoon = $query->row();

            $this->db->where('id', $meldingPerPersoon->persoonId);
            $queryPersoon = $this->db->get('persoon');
            $this->db->where('id', $meldingPerPersoon->meldingId);
            $queryMelding = $this->db->get('melding');
            $persoon = $queryPersoon->row();
            $melding = $queryMelding->row();

            $obj_merged = (object) array_merge((array)$persoon, (array)$melding);
        return $obj_merged;
    }

    /**
     * Retourneert een array van alle meldingen met bijhorende persoon
     * 
     * @return De opgevraagde array
     */
    public function getMeldingPerPersoon() {
        $query = $this->db->get('meldingPerPersoon');
        $meldingPerPersoon = $query->result();

        $meldingenPerPersoon = array();
        foreach ($meldingPerPersoon as $item) {
            $meldingpersoon = array();
            $meldingpersoon['meldingPerPersoon'] = $item->id;

            $this->db->where('id', $item->persoonId);
            $queryPersoon = $this->db->get('persoon');
            $this->db->where('id', $item->meldingId);
            $queryMelding = $this->db->get('melding');
            $persoon = $queryPersoon->row();
            $melding = $queryMelding->row();

            $obj_merged = (object) array_merge((array)$persoon, (array)$melding, (array)$meldingpersoon);
            array_push($meldingenPerPersoon, $obj_merged);

        }

        return $meldingenPerPersoon;
    }
    
    /**
     * Verwijdert het record met id=$id uit de tabel melding
     * 
     * @param $id De id van het record dat opgevraagd wordt
     */

    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('melding');
    }

    /**
     * Voegt een niew record toe aan de tabel melding
     * 
     * @param $melding Het melding object waar de ingevulde data in zit
     * @return Het ingevoegde melding ID
     */
    function insertMelding($melding) {
        $this->db->insert('melding', $melding);
        return $this->db->insert_id();
    }

    /**
     * Wijzigt een melding-record uit de tabel melding
     * 
     * @param $melding Het melding object waar de aangepaste data in zit
     */
    function updateMelding($melding) {
        $this->db->where('id', $melding->id);
        $this->db->update('melding', $melding);
    }
    
    /**
     *  Voegt een nieuw record toe aan de tabel meldingperpersoon
     * 
     * @param s$meldingPerPersoon Het meldingperpersoon object waar de ingevulde data in zit
     */
    function insertMeldingPerPersoon($meldingPerPersoon) {
        $this->db->insert('meldingperpersoon', $meldingPerPersoon);
    }
    
    /**
     * Wijzigt een meldingperpersoon-record uit de tabel meldingperpersoon
     * 
     * @param $meldingPerPersoon Het meldingperpersoon object waar de aangepaste data in zit
     */
    function updateMeldingPerPersoon($meldingPerPersoon) {
        $this->db->where('meldingId', $meldingPerPersoon->meldingId);
        $this->db->update('meldingperpersoon', $meldingPerPersoon);
    }
    
    /**
     * Verwijdert het record met id=$id uit de tabel meldingperpersoon
     * 
     * @param $id De id van het record dat opgevraagd wordt
     */
    function deleteMeldingPerPersoon($id){
        $this->db->where('id', $id);
        $this->db->delete('meldingperpersoon');
    }
}
