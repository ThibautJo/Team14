<?php
    
    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Jolien Lauwers       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    StartpaginaItem model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------
    
/**
 * @class StartpaginaItem_model.
 * @brief Model-klasse voor startpaginaItems.
 *
 * Model-klasse die alle methodes bevat om te interacteren met de database-table startpaginaItem.
 */

class StartpaginaItem_model extends CI_Model {

    function __construct() {
        
        /**
        * Constructor
        */
        
        parent::__construct();
    }

    function getStartpaginaItemMetId($id) {

        /**
         * Retourneert het record met id=$id uit de tabel startpaginaItem.
         * @param $id De id van het record dat opgevraagd wordt.
         * @return Het opgevraagde record.
         */
        
        $this->db->where('id', $id);
        $query = $this->db->get('startpaginaItem');
        return $query->row();
    }

    function getStartpaginaItem() {

        /**
         * Retourneert alle startpaginaItems uit de tabel startpaginaItem.
         * @return Alle startpaginaItems.
         */
        
        $query = $this->db->get('startpaginaItem');
        return $query->result();
    }

    function deletegetStartpaginaItem($id) {

        /**
         * Verwijdert het record met id=$id uit de tabel startpaginaItem.
         * @param $id De id van het record dat opgevraagd wordt.
         */
        
        $this->db->where('id', $id);
        $this->db->delete('startpaginaItem');
    }

    function insertgetStartpaginaItem($startpaginaitem) {

        /**
         * Voegt een nieuw record toe aan de tabel startpaginaItem.
         * @param $startpaginaitem Het startpaginaItem waar de ingevulde data in wordt bewaard.
         */
        
        $this->db->insert('startpaginaItem', $startpaginaitem);
    }

    function updategetStartpaginaItem($startpaginaitem) {

        /**
         * Wijzigt een startpaginaItem-object uit de tabel startpaginaItem.
         * @param $startpaginaitem Het supplementen object waar de aangepaste data in zit.
         */
        
        $this->db->where('id', $startpaginaitem->id);
        $this->db->update('startpaginaItem', $startpaginaitem);
    }

}

?>
