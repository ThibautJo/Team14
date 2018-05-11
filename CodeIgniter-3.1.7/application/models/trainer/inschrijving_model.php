<?php
/**
 * @class Inschrijving_model
 * @brief Model-klasse voor inschrijvingen
 *
 * Model-klasse die alle methodes bevat om te interageren met de database-table inschrijving
 */


class Inschrijving_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Inschrijving model
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
     * Retourneert het record met id=$id uit de tabel inschrijving
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('inschrijving');
        return $query->row();
    }

    /**
     * Verwijdert het record met id=$id uit de tabel inschrijving
     * @param $id De id van het record dat opgevraagd wordt
     */

    function deleteInschrijving($id){
        $this->db->where('id', $id);
        $this->db->delete('inschrijving');
    }

    /**
     * Voegt een nieuw record toe aan de tabel inschrijving
     * @param $inschrijving Het inschrijvingen object waar de ingevulde data in zit
     */
    function insertInschrijving($inschrijving) {
        $this->db->insert('inschrijving', $inschrijving);
    }

    /**
     * Wijzigt een inschrijving-record uit de tabel inschrijving
     * @param $inschrijving Het inschrijvingen object waar de aangepaste data in zit
     */
    function updateInschrijving($inschrijving) {
        $this->db->where('id', $inschrijving->id);
        $this->db->update('inschrijving', $inschrijving);
    }

}

?>
