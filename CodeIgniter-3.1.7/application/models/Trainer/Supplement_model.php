<?php
/**
 * @class Supplement_model
 * @brief Model-klasse voor supplementen
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-table supplement
 */


class Supplement_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |
    // |    Supplement model
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
     * Retourneert het record met id=$id uit de tabel supplement
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    
    function get($id) {
        $this->db->where('ID', $id);
        $query = $this->db->get('supplement');
        return $query->row();
    }
    
    /**
     * Retourneert alle namen alfabetisch uit de tabel supplement
     * @return Een lijst van alle namen
     */

    function getAllByNaamSupplement() {
        $this->db->order_by('Naam', 'asc');
        
        $query = $this->db->get('supplement');
        return $query->result();
    }
    
    /**
     * Retourneert alle namen alfabetisch met hun functie uit de tabel supplement en supplementfunctie
     * @return Een array van supplementnamen met bijhorende functieId
     */
    
    function getAllByNaamSupplementWithFunctie() {
        $this->db->order_by('Naam', 'asc');
        
        $query = $this->db->get('supplement');
        $supplementen = $query->result();
        
        $this->load->model('trainer/supplementfunctie_model');
        
        foreach ($supplementen as $supplement) {
            $supplement->functie = $this->supplementfunctie_model->get($supplement->FunctieId);
        }
        return $supplementen;
    }
    
    /**
     * Verwijdert het record met id=$id uit de tabel supplement
     * @param $id De id van het record dat opgevraagd wordt
     */
    
    function delete($id){
        $this->db->where('ID', $id);
        $this->db->delete('supplement');
    }
    
    /**
     * Voegt een nieuw record toe aan de tabel supplement
     * 
     * @param $supplement Het supplementen object waar de ingevulde data in zit
     * @return Automatisch gegenereerde id wordt teruggegeven
     */
    function insert($supplement) {
        $this->db->insert('supplement', $supplement);
        return $this->db->insert_id();
    }
    
    /**
     * Wijzigt een supplement-record uit de tabel supplement
     * 
     * @param $supplement Het supplementen object waar de aangepaste data in zit
     */
    function update($supplement) {
        $this->db->where('id', $supplement->ID);
        $this->db->update('supplement', $supplement);
    }

}

?>

