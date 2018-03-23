<?php

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

    function __construct() {
        parent::__construct();

        $this->load->helper("MY_html_helper");
        $this->load->helper("MY_url_helper");
        $this->load->helper('url');
    }
    
    function get($id) {
        $this->db->where('ID', $id);
        $query = $this->db->get('supplement');
        return $query->row();
    }

    function getAllByNaamSupplement() {
        $this->db->order_by('Naam', 'asc');
        
        $query = $this->db->get('supplement');
        return $query->result();
    }
    
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
    
    function delete($id){
        $this->db->where('ID', $id);
        $this->db->delete('supplement');
    }
    
    function insert($supplement) {
        $this->db->insert('supplement', $supplement);
        return $this->db->insert_id();
    }
    
    function update($supplement) {
        $this->db->where('id', $supplement->ID);
        $this->db->update('supplement', $supplement);
    }

}

?>

