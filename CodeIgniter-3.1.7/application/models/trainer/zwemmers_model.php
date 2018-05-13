<?php

/**
 * @class Zwemmers_model
 * @brief Model-klasse voor zwemmers(personen)
 *
 * Model-klasse die alle methodes bevat om te interageren met de database-table persoon
 */
class Zwemmers_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Klaus Daems       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Zwemmers_model
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
     * Retourneert de records van de personen waarbij Soort = Zwemmer en Actief = 1 zijn 
     * uit het tabel persoon
     * @return opgevraagde records
     */
    public function getZwemmers() {
        $this->db->where('soort', "Zwemmer");
        $this->db->where('actief', 1);
        $query = $this->db->get('persoon');
        
        return $query->result();
    }
    
    /**
     * Retourneert de records van de personen waarbij Actief = 1 is 
     * uit het tabel persoon
     * @return opgevraagde records
     */
    public function getTeam() {
        $this->db->where('actief', 1);
        $query = $this->db->get('persoon');
        
        return $query->result();
    }
    
    /**
     * Retourneert de records van de personen waarbij Soort = Zwemmer en Actief = 0 zijn 
     * uit het tabel persoon
     * @return opgevraagde records
     */
    public function getZwemmersArchief() {
        $this->db->where('soort', "Zwemmer");
        $this->db->where('actief', 0);
        $query = $this->db->get('persoon');
        
        return $query->result();
    }
    
    /**
     * Retourneert het record met id=$id uit de tabel persoon
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }
    
    /**
     * Wijzigt een persoon-record uit de tabel persoon
     * @param $id Het id object verwijst de data waar het aangepast moet worden
     */
    function archiveer($id){
        $this->db->where('id', $id);
        $this->db->set('actief', 0 );
        $this->db->update('persoon', $persoon);
    }
    
    /**
     * Wijzigt een persoon-record uit de tabel persoon
     * @param $persoon Het persoon-id object verwijst de data waar het aangepast moet worden
     */
    function uitArchiefHalen($persoon){
        $this->db->where('id', $persoon->id);
        $this->db->set('actief', 1 );
        $this->db->update('persoon', $persoon);
    }
    
    /**
     * Voegt een nieuw record toe aan de tabel persoon
     * @param $persoon Het persoon object waar de ingevulde data in zit
     */
    function insert($persoon) {
        $this->db->insert('persoon', $persoon);
    }
    
    /**
     * Wijzigt een persoon-record uit de tabel persoon
     * @param $persoon Het persoon object waar de aangepaste data in zit
     */
    function update($persoon) {
        $this->db->where('id', $persoon->id);
        $this->db->update('persoon', $persoon);
    }
}

?>

