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
    function __construct() {
        
    }
    
    public function getProfielByPersoon($persoonId){
        $this->db->where('id', $persoonId);
        $query = $this->db->get('persoon');
        $profiel = $query->row();
        
        return $profiel;
    }
    
    function get($id) {
        
        // geef persoon-object met opgegeven $id   
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }
}
