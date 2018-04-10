
<?php

class Zwemmers_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Klaus Daems       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Agenda model
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

    public function getZwemmers() {
        $this->db->where('soort', 'Zwemmer');
        $query = $this->db->get('persoon');
        return $query->result();
    }
    
    function get($id) {
        $this->db->where('ID', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }
    
    function delete($id){
        $this->db->where('ID', $id);
        $this->db->delete('persoon');
    }
    
    function insert($persoon) {
        $this->db->insert('persoon', $persoon);
        return $this->db->insert_id();
    }
    
    function update($persoon) {
        $this->db->where('id', $persoon->ID);
        $this->db->update('persoon', $persoon);
    }
}

?>

