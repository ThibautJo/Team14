<?php
/**
 * @class Supplementfunctie_model
 * @brief Model-klasse voor supplementfunctie
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel supplementfunctie
 */

class Supplementfunctie_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |
    // |    Supplementfunctie model
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
     * Retourneert het record met id=$id uit de tabel supplementfunctie
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    function get($id) {
        $this->db->where('ID', $id);
        $query = $this->db->get('supplementfunctie');
        return $query->row();
    }
    
    /**
     * Retourneert alle functies alfabetisch uit de tabel supplementfunctie
     * @return Een lijst van alle functies
     */
    function getAllByFunctie() {
        $this->db->order_by('Functie', 'asc');
        $query = $this->db->get('supplementfunctie');
        return $query->result();
    }

}

?>

