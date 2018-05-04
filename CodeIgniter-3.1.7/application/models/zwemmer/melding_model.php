<?php

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

    function __construct() {
        parent::__construct();

    }

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

    public function getMelding($meldingId) {
        $this->db->where('id', $meldingId);
        $query = $this->db->get('melding');
        return $query->row();
    }
}
