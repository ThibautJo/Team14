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
    
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('meldingperpersoon');
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
    
    public function getMeldingen() {
        $this->db->order_by('datumStop');
        $query = $this->db->get('melding');
        
        return $query->result();
    }

    public function getMeldingPerPersoon() {
        $query = $this->db->get('meldingperpersoon');
        $meldingPerPersoon = $query->result();
        
        $meldingenPerPersoon = array();
        foreach ($meldingPerPersoon as $item) {
            $this->db->where('id', $item->id);
            $queryPersoon = $this->db->get('persoon');
            $this->db->where('id', $item->id);
            $queryMelding = $this->db->get('melding');
            $persoon = $queryPersoon->row();
            $melding = $queryMelding->row();
            
            $obj_merged = (object) array_merge((array)$persoon, (array)$melding);
            array_push($meldingenPerPersoon, $obj_merged);
             
        }
        return $meldingenPerPersoon;
        
        
        /*
        $this->db->order_by('datumStop');
        $query = $this->db->get('melding');
        $meldingen = $query->result();
        
        $persoonIDs = array();
        foreach ($meldingen as $melding) {
            $this->db->where('meldingId', $melding->id);
            $query = $this->db->get('meldingperpersoon');
            $meldingPerPersonen = $query->result();
            foreach ($meldingPerPersonen as $meldingPerPersoon) {
                array_push($persoonIDs, $meldingPerPersoon->persoonId);
            }
        }
        
        $namen = array();
        foreach ($persoonIDs as $value) {
            $this->db->where('id', $meldingPerPersoon->persoonId);
            $query = $this->db->get('persoon');
            $result = $query->row();
            array_push($namen, $result->voornaam . ' ' . $result->achternaam);
        }
        
        $personen = new stdClass();
        $personen->ID = $persoonIDs;
        $personen->namen = $namen;
        
        return $personen;
         * */
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
    function insert($melding) {
        $this->db->insert('melding', $melding);
    }
    
    /**
     * Wijzigt een melding-record uit de tabel melding
     * 
     * @param $melding Het meldingen object waar de aangepaste data in zit
     */
    function update($melding) {
        $this->db->where('id', $melding->id);
        $this->db->update('melding', $melding);
    }
}
