<?php

class Agenda_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Tom Nuyts       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Agenda model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();

        //helpers inladen
        $this->load->helper("my_html_helper");
        $this->load->helper("my_url_helper");
        $this->load->helper('url');
    }

    public function insertActiviteit($activiteit) {
        // Activiteit toevoegen
        $this->db->insert('activiteit', $activiteit);
        return $this->db->insert_id();
    }

    public function updateActiviteit($activiteit) {
        // Activiteit wijzigen
        $this->db->where('id', $activiteit->id);
        $this->db->update('activiteit', $activiteit);
    }

    public function insertActiviteitPerPersoon($activiteitPerPersoon) {
        $this->db->insert('activiteitPerPersoon', $activiteitPerPersoon);
        return $this->db->insert_id();
    }
}
