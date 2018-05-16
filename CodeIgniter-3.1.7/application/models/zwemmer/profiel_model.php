<?php

/**
 * @class Profiel_model
 * @brief Model-klasse voor profiel
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-table persoon
 * @author Klaus
 */
class profiel_model extends CI_Model{
    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Klaus Daems       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Profiel_model
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
     * Retourneert het record met id=$persoonId uit de tabel persoon
     * @param $persoonId De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    public function getProfielByPersoon($persoonId){
        $this->db->where('id', $persoonId);
        $query = $this->db->get('persoon');
        $profiel = $query->row();
        
        return $profiel;
    }
    
    /**
     * Retourneert het record met id=$id uit de tabel persoon
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde records
     */
    function get($id) {
        
        // geef persoon-object met opgegeven $id   
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }
    
    /**
     * Wijzigt een persoon-record uit de tabel persoon
     * @param $profiel Het persoon object waar de aangepaste data in zit
     */
    function update($profielGegevens) {
        $this->db->where('id', $profielGegevens->id);
        $this->db->update('persoon', $profielGegevens);
    }
}
