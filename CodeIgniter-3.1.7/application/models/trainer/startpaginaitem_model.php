<?php
/**
 * @class StartpaginaItem_model.
 * @brief Model-klasse voor startpaginaItems.
 *
 * Model-klasse die alle methodes bevat om te interacteren met de database-table startpaginaItem.
 */


class StartpaginaItem_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |
    // |    StartpaginaItem model
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
     * Retourneert het record met id=$id uit de tabel startpaginaItem.
     * @param $id De id van het record dat opgevraagd wordt.
     * @return Het opgevraagde record.
     */

    function get($id) {
        
        $this->db->where('id', $id);
        $query = $this->db->get('startpaginaItem');
        return $query->row();
    }
    
    // doxygen
    
    public function getStartpaginaTekst() {
        
        $this->db->where('soort', "tekst");
        $query = $this->db->get('startpaginaItem');
        
        return $query->result();
    }

    /**
     * Verwijdert het record met id=$id uit de tabel startpaginaItem.
     * @param $id De id van het record dat opgevraagd wordt.
     */

    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('startpaginaItem');
    }

    /**
     * Voegt een nieuw record toe aan de tabel startpaginaItem.
     * @param $startpaginaitem Het startpaginaItem waar de ingevulde data in wordt bewaard.
     */

    function insert($startpaginaitem) {
        $this->db->insert('startpaginaItem', $startpaginaitem);
    }

    /**
     * Wijzigt een startpaginaItem-object uit de tabel startpaginaItem.
     * @param $startpaginaitem Het supplementen object waar de aangepaste data in zit.
     */

    function update($startpaginaitem) {
        $this->db->where('id', $startpaginaitem->id);
        $this->db->update('startpaginaItem', $startpaginaitem);
    }

}

?>
