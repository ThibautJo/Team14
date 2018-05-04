<?php

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

    function __construct() {
        parent::__construct();

    }

    function getMelding($id){
        $this->db->where('id', $id);
        $query = $this->db->get('melding');
        return $query->row();
    }

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
     * @param $id De id van het record dat opgevraagd wordt
     */

    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('melding');
    }

    /**
     * Voegt een nieuw record toe aan de tabel melding
     *
     * @param $melding Het meldingen object waar de ingevulde data in zit
     */
    function insertMelding($melding) {
        $this->db->insert('melding', $melding);
        return $this->db->insert_id();
    }

    /**
     * Wijzigt een melding-record uit de tabel melding
     *
     * @param $melding Het meldingen object waar de aangepaste data in zit
     */
    function updateMelding($melding) {
        $this->db->where('id', $melding->id);
        $this->db->update('melding', $melding);
    }
    
    
    function insertMeldingPerPersoon($meldingPerPersoon) {
        $this->db->insert('meldingperpersoon', $meldingPerPersoon);
    }
    
    function updateMeldingPerPersoon($meldingPerPersoon) {
        $this->db->where('meldingId', $meldingPerPersoon->meldingId);
        $this->db->update('meldingperpersoon', $meldingPerPersoon);
    }
    
    function deleteMeldingPerPersoon($id){
        $this->db->where('id', $id);
        $this->db->delete('meldingperpersoon');
    }
}
