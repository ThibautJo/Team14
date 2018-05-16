<?php

/**
 * @class Melding_model
 * @brief Model-klasse voor meldingen
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel melding
 */

class Melding_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Melding model
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
     * Retourneert alle meldingen van bepaalde persoon
     * 
     * @param $persoonId De id van het record dat opgevraagt wordt
     * @return De opgevraagde data
     */
    public function getMeldingByPersoon($persoonId) {
        // Alle meldingen van een bepaalde persoon ophalen uit de databank
        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('meldingPerPersoon');
        $meldingen = $query->result();

        foreach ($meldingen as $melding) {
            $melding->melding = $this->getMelding($melding->meldingId);

        }

        return $meldingen;
    }

    /**
     * Retourneert het record met id=$id uit de tabel melding
     * 
     * @param $meldingId De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    public function getMelding($meldingId) {
        $this->db->where('id', $meldingId);
        $query = $this->db->get('melding');
        return $query->row();
    }
}
