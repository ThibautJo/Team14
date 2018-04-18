
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
        $this->db->where('soort', "Zwemmer");
        $this->db->where('actief', 1);
        $query = $this->db->get('persoon');
        
        return $query->result();
    }
    
    public function getTeam() {
        $this->db->where('actief', 1);
        $query = $this->db->get('persoon');
        
        return $query->result();
    }
    
    public function getZwemmersArchief() {
        $this->db->where('actief', 0);
        $query = $this->db->get('persoon');
        
        return $query->result();
    }
    
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }
    
    function archiveer($id){
        $this->db->where('id', $id);
        $this->db->set('actief', 0 );
        $this->db->update('persoon', $persoon);
    }
    
    function insert($persoon) {
        $this->db->insert('persoon', $persoon);
    }
    
    function update($persoon) {
        $this->db->where('id', $persoon->id);
        $this->db->update('persoon', $persoon);
    }
}

?>

