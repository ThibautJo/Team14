
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

        
    }

    public function getZwemmers() {
        $query = $this->db->get('persoon');
        return $query->result();
    }
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }
    
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('persoon');
    }
    
    function insert($persoon) {
        $this->db->insert('persoon', $persoon);
    }
    
    function update($persoon) {
        $this->db->where('id', $persoon->ID);
        $this->db->update('persoon', $persoon);
    }
}

?>

