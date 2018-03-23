<?php

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

    function __construct() {
        parent::__construct();

    }
    
    function get($id) {
        $this->db->where('ID', $id);
        $query = $this->db->get('supplementfunctie');
        return $query->row();
    }
    
    function getAllByFunctie() {
        $this->db->order_by('Functie', 'asc');
        $query = $this->db->get('supplementfunctie');
        return $query->result();
    }

}

?>

